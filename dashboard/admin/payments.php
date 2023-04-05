<?php
include('header.php');
if(isset($_GET['pay'])){
$pid = mysql_real_escape_string($_GET['pay']);
$user = mysql_real_escape_string($_GET['user']);
$sql = mysql_query("SELECT id,user,amount,paid,gateway FROM `requests` WHERE `paypal`='".$pid."' and `paid`='0'");
if(mysql_num_rows($sql) > 0){
            $req = mysql_fetch_assoc($sql);
   if($req['paid'] != 1){
   mysql_query("UPDATE `requests` SET `paid`='1' WHERE `paid`='0' and `paypal`='".$pid."'");
   $msg = "<center>You have successfully marked this request as paid.</center>";
   }else{
   $msg = "<center>The request is already marked as paid.</center>";
   }
   }else{
   $msg = "<center>The request doesn't exist.</center>";
   }
   }
   
   
?>
<div class="content">
<?php echo $msg?>
<table class="table" border="1" style="color:rgb(143, 143, 143);border-color:rgb(68,68,68);border-radius:5px;margin-left:2%;margin-right:2%;margin-top:10px;">
		<thead>
			<tr>
				<td width="20"><u>#</u></td>
				<td><u>User id</u></td>
				<td><u>Amount</u></td>
				<td><u>Payment Email</u></td>
				<td><u>Gateway</u></td>
				<td><u>Date</u></td>
				<td><u>Reached Hits</u></td>
				<td><u>Counted Hits</u></td>
				<td><u>Paid</u></td>
				<td><u>Accept</u></td>
				<td><u>Reject</u></td>
			</tr>
		</thead>
		<tbody>
<?php
if(!isset($_GET['mid'])){
$pid = 0;
}elseif(isset($_GET['mid']) && is_numeric($_GET['mid'])){ 
$pid = mysql_real_escape_string($_GET['mid']);
}
$sql = mysql_query("SELECT id,user,sum(amount) as amount,paypal,gateway,date,reached,vhits,paid FROM `requests` WHERE `paid`='0' AND `gateway`='".$_GET['gway']."' group by paypal ORDER BY `date` LIMIT ".$pid.", 50 ");
  $num = mysql_num_rows($sql);
 $limit = $pid + $num; 
  if($num == 0){ echo '<tr><td colspan="6" align="center"><b>No Withdrawal Requests Found.</b></td><tr>';}else{
  for($j=1; $user = mysql_fetch_assoc($sql); $j++)
{
?>	
<tr>
				<td><?php echo $user['id']?></td>
				<td><?php echo $user['user']?>
				<td><?php echo $user['amount']?>$</td>
				<td><span><?php echo (!empty($user['paypal']) ? $user['paypal'] : 'N/A')?></span></td>
				<td><?php echo ucfirst($user['gateway'])?></td>
				<td><?php echo $user['date']?></td>
                <td><?php echo $user['Reached']?></td>	
                <td><?php echo $user['vhits']?></td>					
				<td><?php if($user['paid'] == 0){?><font color="orange">Pending<?php }elseif($user['paid'] == 2){?><font color="red"><?php echo $user['reason']?>(Rejected)</font><?php }else{?><font color="green">Paid<?php }?></font></td>
			    <td><a href="payments.php?pay=<?php echo $user['paypal']?>&user=<?php echo $user['user']?>&gway=<?php echo $_GET['gway']?>"><input type="submit" name="pay" value="Accept" /> </a></td>
				<td><a href="reject.php?reject=<?php echo $user['paypal']?>"><input type="submit" name="rej" value="Reject" /></a> </td>
			</tr><?php }}?>
		</tbody>
	</table>
<?php
$sql = mysql_query("SELECT * FROM `proofs` where `approved`='1' ");
$sql2 = mysql_query("SELECT * FROM `requests` ORDER BY `date` DESC LIMIT ".$limit.", 50 ");
  $num = mysql_num_rows($sql2); 
  if ($num > 0){
  ?>
<center><a href="payments.php?mid=<?php echo $limit ?>&gway=<?php echo $_GET['gway']?>">Older Payments</a></center>
<?php }	?>
	</div>
