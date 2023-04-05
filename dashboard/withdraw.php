<?php
include('header.php');
$nowcash = mysqli_fetch_assoc(mysqli_query($con,"SELECT SUM(cash) as tamount FROM `stats` WHERE stats.timestamp >= '" . strtotime("first day of this month") . "' AND username='" . $data['login'] . "' "));
$avcash = $data['cash'] - $nowcash['tamount'];
$msg='<div id="msg"></div>';
if(isset($_POST['cash']) && isset($_POST['email']) && isset($_POST['gateway'])){ 
        $cash = mysqli_real_escape_string($con, $_POST['cash']);
		$pemail = mysqli_real_escape_string($con, $_POST['email']);
		$gateway = mysqli_real_escape_string($con, $_POST['gateway']);
		if(!is_numeric($cash) || $cash < 1){
		$msg = '<div id="msg"><div class="alert alert-danger">The minimum payout is $1 </div></div>';
        }elseif($gateway == "paypal" && !preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $pemail)){
		$msg = '<div id="msg"><div class="alert alert-danger">Enter a valid Paypal Email.</div></div>';
		}elseif($gateway == "Bitcoin" && !preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $pemail)){
		$msg = '<div id="msg"><div class="alert alert-danger">Enter a valid Bitcoin Address.</div></div>';	
		}elseif($_POST['cash'] > $avcash){
			$msg = '<div id="msg"><div class="alert alert-danger">You do not have enough money available for withdrawal.</div></div>';
		}else{
			mysqli_query($con, "INSERT INTO `requests` (user, paypal, amount, date, gateway, vhits, Reached) VALUES('".$data['id']."', '".$pemail."', '".$cash."', NOW(), '".$gateway."', '".$data['vhits']."', '".$data['vhitsa']."')");
			mysqli_query($con, "UPDATE `users` SET `cash`=`cash`-'".$cash."' WHERE `id`='".$data['id']."'");			
			$msg = '<div id="msg"><div class="alert alert-success">The withdrawal request has been successfully submitted and will be processed in our next batch of payments.</div></div>';
			$dat1=mysqli_fetch_assoc(mysqli_query($con, "SELECT cash from users where id='".$data['id']."' "));
			$avcash = $dat1['cash'] - $nowcash1['tamount'];
		}
}
?>
<style>
.form-control{
	margin-bottom:15px;
}
</style>
<?=$msg?>

	<section class="content-header">
      <h1>
        Withdraw
        <small>Payout requests</small>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Withdraw</li>
      </ol>
    </section>
	
	<section class="content">
		<div class="row">
			<div class="info-box" style="width:100%;padding-top:35px;padding:20px;text-align:center">
				<form name="withdraw" method="post" onsubmit="event.preventDefault(); validateW();">
					<label>Cash available for withdrawal: <b>$<?=number_format($avcash,2)?></b> (Money earned until first of this month)</label></br></br> 
					<input id="cash" class="form-control" placeholder="Amount to withdraw, Minimum is $1" value="" name="cash" required/>
					<input id="email" class="form-control" placeholder="Paypal email or Bitcoin address" value="" name="email" required/>

					<select name="gateway" class="form-control"  id="gateway"  required>
						<option value="" disabled selected>Choose Payment gateway</option>
						<option value="Bitcoin">Bitcoin</option>
						<option value="paypal">Paypal</option>
					</select>
					
					<button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff" type="submit" name="withdraw">
						Withdraw
					</button>
				</form>
			</div>

		</div>
		
		<div class="row">
			<div class="info-box" style="width:100%;padding-top:25px;padding:20px;">
				  <h3 >Last 5 withdrawal requests</h2>
					<table class="table table-hover">
						<thead>
							<tr>
								<th width="20">#</td>
								<th>Amount</td>
								<th>Payment Address</td>
								<th>Gateway</td>
								<th>Date</td>
								<th>Paid</td>
				
							</tr>
						</thead>
						<tbody>
<?php
$sql = mysqli_query($con, "SELECT amount,paypal,date,paid,gateway,reason FROM `requests` WHERE `user`='".$data['id']."' AND `gateway`!='accb' ORDER BY `date` DESC LIMIT 5");
  $num = mysqli_num_rows($sql);
  if($num == 0){ echo '<tr><td colspan="6" align="center"><b>No Withdrawal Requests Found.</b></td><tr>';}else{
  for($j=1; $user = mysqli_fetch_assoc($sql); $j++)
{
?>	
							<tr>
								<td><?php echo $j;?></td>
								<td>$<?php echo $user['amount']?></td>
								<td><font style="font-size:12px;"><?php echo (!empty($user['paypal']) ? $user['paypal'] : 'N/A')?></font></td>
								<td><?php echo ucfirst($user['gateway'])?></td>
								<td><?php echo $user['date']?></td>
								<td><?php if($user['paid'] == 0){?><font color="orange">Pending<?php }elseif($user['paid'] == 2){?><font color="red"><?php echo $user['reason']?>(Rejected)</font><?php }else{?><font color="green">Paid<?php }?></font></td>
							</tr><?php }}?>
						</tbody>
					</table>
			
			</div>
		</div>
	</section>

<script type="text/javascript">
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validateBTC(addr) {
    var re = /^(bc1|[13])[a-zA-HJ-NP-Z0-9]{25,39}$/;
    return re.test(String(addr));
}
function fillmsg(msg){
	var msge = document.getElementById("msg");
	msge.className = "alert alert-danger";
	msge.innerText=msg;
}
function validateW(){
	var amt = document.getElementById("cash").value;
	var email = document.getElementById("email").value;
	var gateway = document.getElementById("gateway").value;
	if(amt == "" || amt < 1)
		fillmsg("Invalid Withdrawal amount, Minimum withdrawal is $1.");
	else if(gateway == "")
		fillmsg("Please choose a valid Payment gateway.");
	else if(gateway == "Bitcoin" && !validateBTC(email))
		fillmsg("Invalid Bitcoin address, Please try again.");
	else if(gateway == "paypal" && !validateEmail(email))
		fillmsg("Invalid payment email, Please try again.");
	else
		document.withdraw.submit();
}
</script>
<?php include('footer.php'); ?>
