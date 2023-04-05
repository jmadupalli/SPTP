<?php
include('header.php');
if(isset($_GET['reject'])){
      $pid = mysql_real_escape_string($_GET['reject']);
      $sql = mysql_query("SELECT id,reason FROM `requests` WHERE `paypal`='".$pid."' && `paid`='0' ");
     	if(mysql_num_rows($sql) == 0){
		redirect("payments.php");
		exit;
	    }
	   $rej = mysql_fetch_assoc($sql);
       if(isset($_POST['reject'])){
		if($_POST['reason'] != ''){
		$reason = mysql_real_escape_string($_POST['reason']);
			mysql_query("UPDATE `requests` SET `paid`='2', `reason`='".$reason."' WHERE `paypal`='".$pid."' and `paid`='0' ");
			$msg = '<center><div class="alert error">Request marked as rejected!</center></div>';		
		
		}else{
		$msg = '<div class="alert error">Please write a reason to reject!</a></div>';
		}
	  }	
}
?>
<div class="content">
<?php echo $msg?>
<form method="post" action="" style="text-align:center;">
<center> Reject Request</center>
<input type="text" name="reason" placeholder="Reason" value="<?php echo (isset($_POST['reason']) ? $_POST['reason'] : $rej['reason'])?>" required />
<input type="submit" name="reject" value="Reject"/>
</form>
