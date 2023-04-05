<?php
include('conf/config.php');

$mesaj = '';
if(isset($_GET['code']) && $_GET['code'] != 0 && is_numeric($_GET['code'])){
  $code = mysqli_real_escape_string($con, $_GET['code']);
  if(mysqli_num_rows(mysqli_query($con, "SELECT id FROM `users` WHERE `activate`='".$code."'")) > 0){
   mysqli_query($con, "UPDATE `users` SET `activate`='0' WHERE `activate`='".$code."'");
  $mesaj = '<center><b style="color:green">You have successfully activated your account!</b></center>';
}else{
		$mesaj = '<center><b style="color:red">Invalid Activation Code.</b></center>';
	}
}else{
	$mesaj = '<center><b style="color:red">Access Denied.</b></center>';
}
?>
<html><title>SkillerzPTP - Account Activation</title>
<head>
<meta http-equiv="refresh" content="2; URL=index.php" />
</head>
<div style="background:#e0e0e0;width:50%;margin:75px auto;padding:25px;border:1px #ffffff solid;border-radius:3px;">
	<?php echo $mesaj?>
</div>
</body>
</html>
