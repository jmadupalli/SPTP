<?php
include('header.php');
if($_GET['do']=="yes"){
$users = mysql_query("SELECT * from `users` WHERE `points`>'0'");
for($i=1; $user=mysql_fetch_assoc($users); $i++)
{
	$c = $user['points']*$site['pex'];
	$totc = $totc + $c;
	$totp = $totp + $user['points'];
	mysql_query("UPDATE `users` SET `points`='0', cash=`cash`+'".$c."' WHERE `id`='".$user['id']."' ");
}
	mysql_query("INSERT INTO `conv` (`month`,`totpoints`,`totcash`,`pex`) VALUES(NOW(), '".$totp."', '".$totc."', '".$site['pex']."')");

echo "Total cash this month :$".$totc;
}else{
	echo "nothing.";
}
?>