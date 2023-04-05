<?php
include('header.php');

if(isset($_POST['title']) && isset($_POST['message'])){
    $subject = $_POST['title'];
	$message = $_POST['message'];
$sql = mysql_query("SELECT id,login,email from `users` where activate='0' ");
$total = mysql_num_rows($sql);
while(($row = mysql_fetch_assoc($sql))){
$message = str_replace('-USER-', $row['login'], $message);
$subject = str_replace('-USER-', $row['login'], $subject);
mail($row['email'], $subject, 
				'<html>
					<body style="font-family: Verdana; color: #333333; font-size: 12px;">
						<table style="width: 480px; margin: 0px auto;">
							<tr style="text-align: center;">
								<td style="border-bottom: solid 1px #cccccc;"><h1 style="margin: 0; font-size: 20px;"><a href="'.$site['site_url'].'" style="text-decoration:none;color:#333333"><b>'.$site['site_name'].'</b></a></h1><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">'.$subject.'</h2></td>
							</tr>
							<tr style="text-align: justify;">
								<td style="padding-top: 15px; padding-bottom: 15px;">
									<p>'.$message.'</p>
								</td>
							</tr>
							</table>
					</body>
				</html>', 
				"Reply-To: ".$site['site_email']."\r\n".  
				"From: ".$site['site_email']."\r\n".
				"X-Priority: 3\r\n".
				"X-Mailer: PHP/".phpversion().
				"MIME-Version: 1.0\r\n".
				"Content-type: text/html; charset=UTF-8");
				
				$mesaj = "<center>Emails sent successfully.</center>";
}
}
?>
<div class="content">
<?php echo $mesaj?>
<div style="margin-left:250px;margin-top:100px;;border:1px solid;border-radius:7px;width:400px;height:350px;">
<form action="" method="post">
<input id="user" placeholder="Title" value="" name="title" style="margin:20px;" required/></br>
<textarea name="message" placeholder="Your Message" rows="6" cols="76" style="margin:20px;width:350px;" required="required"></textarea>

<center><input id="reg" type="submit" value="Email All Users" name="email" /></center>
</form>
<div style="margin:20px;text-align:center;">
Use ' -USER- ' </br>eg: Hello -USER- Replaces with username of each user.</br>

</div>
</div>
</div>