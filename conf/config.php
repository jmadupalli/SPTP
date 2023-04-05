<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('db.php'); 
$con = mysqli_connect($host,$username,$pass,$db);
require_once('functions.php');
session_start();
$is_online = false;
$site = mysqli_fetch_assoc(mysqli_query($con, "Select * from `settings` "));
if(isset($_SESSION['EX_login'])){
	$ses_id = mysqli_real_escape_string($con, $_SESSION['EX_login']);
    $sql	= mysqli_query($con, "SELECT *,UNIX_TIMESTAMP(`online`) AS `online` FROM `users` WHERE `id`='".$ses_id."' AND `banned`='0'");
    $data	= mysqli_fetch_assoc($sql);
	$is_online = true;
	if(empty($data['id'])){
		session_destroy();
		$is_online = false;
	}elseif($data['online']+60 < time()){
		mysqli_query($con, "UPDATE `users` SET `online`=NOW() WHERE `id`='".$data['id']."'");
		$_SESSION['EX_login'] = $data['id'];
	}
	
}
$mesaj="";


?>
