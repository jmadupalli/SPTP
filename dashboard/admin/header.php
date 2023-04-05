<?php
include('../../conf/config.php');
if($is_online && $data['admin'] == 0)
{
    redirect($site['site_url']);
    exit;
}elseif(!$is_online){
	redirect($site['site_url']);
    exit;
}	

mysql_connect($host,$username,$pass) or die ("error");
mysql_select_db($db);

?>

<html>
<head><title>S-PTP Admin Panel</title>
<link rel="stylesheet" href="skillerzadmin.css" />
</head>
<div class="nav">
<p class="left" style="margin-left:25px;">S-PTP Admin</p>
<p class="right" style="margin-right:25px;"><?php echo $site['site_name']?></p>
</div>
<div style="clear:both;"></div>
<div class="navbar">
<ul class="navlist">
<li>
<a href="index.php">
Dashboard
</a>
</li>
<li>
<a href="settings.php">
Settings
</a>
</li>
<li>
<a href="users.php">
Search Users
</a>
</li>
<li>
<a href="tiers.php">
Tiers
</a>
</li>
<li>
<a href="payments.php">
Payments
</a>
</li>
<li>
<a href="email.php">
Email Users
</a>
</li>
</ul>
</div>