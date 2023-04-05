<?php
include('header.php');
if(isset($_GET['user'])) {
$id = mysql_real_escape_string($_GET['user']);
$sql = mysql_query("SELECT * from users where `id`='".$id."' or `login`='".$id."' ");
$user = mysql_fetch_assoc($sql);
if($user['ref'] == ""){
$user['ref'] = "none";
}
if(isset($_POST['change'])) {

mysql_query("UPDATE users set `cash`='".$_POST['cash']."', `points`='".$_POST['points']."', `banned`='".$_POST['banned']."', `activate`='".$_POST['activate']."' where `id`='".$id."' or `login`='".$id."' ");
$msg = "<center>You have successfully updated this user.</center>"; 
}
if(isset($_POST['delete'])) {
mysql_query("DELETE FROM `users` WHERE `id`='".$id."' or `login`='".$id."' ");
}
if(isset($_POST['Login']) && isset($_POST['user1'])) {
 $_SESSION['EX_login'] = $_POST['user1'];
  redirect('index.php');
}
}else{
redirect('users.php');
exit;
}
?>
<div class="content">
<?php echo $msg?>
<div style="width:1050px;height:100px;border:1px solid;margin-top:50px;margin-left:50px;border-radius:10px;">
<div class="textd">
<?php echo $user['login']?></br>
<center><small>Username</small></center>
</div>
<div class="textd" style="margin-left:150px;">
<?php echo $user['country']?></br>
<center><small>country</small></center>
</div>
<div class="textd" style="margin-left:250px;">
<?php echo $user['email']?></br>
<center><small>email</small></center>
</div>
<div class="textd" style="margin-left:500px;">
<?php echo $user['log_ip']?></br>
<center><small>Log Ip</small></center>
</div>
<div class="textd" style="margin-left:700px;">
<?php echo $user['IP']?></br>
<center><small>Reg Ip</small></center>
</div>
<div class="textd" style="margin-left:850px;">
<?php echo $user['ref']?></br>
<center><small>referred by</small></center>
</div>
</div>

<div style="width:900px;height:200px;border:1px solid;margin-top:50px;margin-left:100px;border-radius:10px;">
<form style="padding:50px;" method="post" action="">
<label>Cash :</label>
<input style="margin-right:50px;" type="text" placeholder="cash" value="<?php echo $user['cash']?>" name="cash" required/>
<label>Points :</label>
<input style="margin-right:50px;" type="text" placeholder="points" value="<?php echo $user['points']?>" name="points" required
<label>Banned :</label>
<input type="text" placeholder="0 or 1" value="<?php echo $user['banned']?>" name="banned" required/>
<small>(1=banned)</small></br></br>
<label>Activate :</label>
<input type="text" value="<?php echo $user['activate']?>" style="width:125px;margin-top:30px;" name="activate" required/>
<small>(0=activated)</small>

<input type="submit" value="Submit" style="margin-top:30px;margin-left:50px;" name="change" />
Counted hits : <?php echo $user['vhits'] ?>  Reached hits : <?php echo $user['vhitsa'] ?>
</form>
</div>
<center><form method="post" action="" style="margin-top:50px;"><input type="hidden" value="<?php echo $user['id']?>" name="user1" /><input style="margin-right:30px;" type="submit" value="Login As This User" name="Login"></form><form method="post" action="" style="margin-top:50px;"><input type="submit" value="Delete This User" name="delete"></form></center>
</div>