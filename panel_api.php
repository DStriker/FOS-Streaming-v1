<?php
ob_start();
include('config.php');
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent = $_SERVER['HTTP_USER_AGENT'];                                                               
}                                                                                                       
                                                                                                        
if (!isset($_GET['username']) || !isset($_GET['password'])) {
    $error = "Username or Password is invalid";
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    header('Status: 404 Not Found');
    die();
}                                                                                                       
                                                                                                        
$user = User::where('username', '=', $_GET['username'])->where('password', '=', $_GET['password'])->first();
if(!$user) {
    $error = "Username or Password is invalid";
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    header('Status: 404 Not Found');
    die();
}                                                                                                       

$setting = Setting::first();
echo "User Info<br>";                                                                                   
echo "Username: " . $user->username . "<br>";
echo "Password: " . $user->password . "<br>";
if($user->exp_date != "0000-00-00") {
   if ($user->exp_date <= date('Y-m-d H:i:s')) {                                                        
   echo "Status: Expired<br>";
   } if ($user->exp_date > date('Y-m-d H:i:s')) {
    if($user->active != "1") {
    echo "Status: Disabled<br>";
   } if ($user->active == "1") {
   echo "Status: Active<br>";
   }}                                                                                                   
} else {
   echo "Status: Active<br>";
}                                                                                                       
echo "Expire Date: " . $user->exp_date  . "<br>";
echo "Max Connections: " . $user->max_connections . "<br>";
echo "Active Connections: " . $user->activity()->where('date_end', '=', NULL)->get . "<br>";
echo $user->laststream->get;                                                                            
echo "M3U Address: http://ip:port/playlist.php?username=". $user->username . "&password=" . $user->password . "&m3u <br>";
echo "Channels List: <br>";
foreach($user->categories as $category) {
foreach($category->streams as $stream) {
if($stream->running == 1) {
echo $stream->id . " " . $stream->name .  "<br>";
}
}
}
die;
