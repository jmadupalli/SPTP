<?php
include('header.php');

$tot_users = mysql_num_rows(mysql_query("SELECT * from users"));
$usert = mysql_num_rows(mysql_query("SELECT id FROM `users` WHERE DATE(`regdate`)=CURDATE()"));
$tot_points = mysql_fetch_assoc(mysql_query("SELECT SUM(points) AS tot_points from users "));
$pointsc = mysql_fetch_assoc(mysql_query("SELECT SUM(points) AS points_con from pextrans "));
$tot_cash = mysql_fetch_assoc(mysql_query("SELECT SUM(cash) AS tot_cash from users "));
$cashp = mysql_fetch_assoc(mysql_query("SELECT SUM(amount) AS paid from requests where `paid`='1' "));
$tot_req = mysql_num_rows(mysql_query("SELECT * from requests"));
$reqp = mysql_num_rows(mysql_query("SELECT * from requests where `paid`='0'"));

?>
<div class="content">

<div class="dashbox">

<center><font style="font-color:rgb(143,143,143);">Registrations</font></center>
<div class="textd">
<?php echo $tot_users?></br>
<small>registered users</small>
</div></br>

<div class="textd1">
<?php echo $usert?></br>
<small>registered today</small>
</div></br>


</div>

<div class="dashbox1">

<center><font style="font-color:rgb(143,143,143);">Total points/converted.</font></center>
<div class="textd">
<?php echo $tot_points['tot_points']?></br>
<small>total points</small>
</div></br>

<div class="textd1">
<?php echo $pointsc['points_con']?></br>
<small>points converted</small>
</div></br>

</div>

<div class="dashbox" style="margin-top:300px;">

<center><font style="font-color:rgb(143,143,143);">Money</font></center>
<div class="textd">
<?php echo $tot_cash['tot_cash']?></br>
<small>total money</small>
</div></br>

<div class="textd1">
<?php echo $cashp['paid']?></br>
<small>money paid</small>
</div></br>


</div>

<div class="dashbox1" style="margin-top:300px;">

<center><font style="font-color:rgb(143,143,143);">Payment Requests</font></center>
<div class="textd">
<?php echo $tot_req?></br>
<small>payment requests.</small>
</div></br>

<div class="textd1">
<?php echo $reqp?></br>
<small>pending requests</small>
</div></br>

</div>

</div>
</html>