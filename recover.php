<?php
include("conf/config.php");	
if($is_online){
	redirect('dashboard');
}	
$mesaj='';
if (isset($_POST['recover']))
{
		$rescap = $_POST['g-recaptcha-response'];
		$name = mysqli_real_escape_string($con, $_POST['uname']);
		$skey = "6LeDOQATAAAAAMg7N7OPMFZskXzKYViSgsEaGnO3";
		$request = get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$rescap);
		$res = json_decode($request);
		if($res->success == true)
		{
			$data = mysqli_fetch_assoc(mysqli_query($con, "SELECT `id`,`email`,`login`,`banned`,`rec_hash`,`activate` FROM `users` WHERE (`login`='".$name."' OR `email`='".$name."')"));
			if($data['banned'] > 0){
				$mesaj = '<div class="alert alert-danger">Your account is banned, Please contact us for more details.</div>';
            }elseif($data['id'] != ''){
                if($data['activate'] > 0)
                    mysqli_query($con, "Update users set activate='0' where id='".$data['id']."' ");
                
                $randh = md5(rand(1000000, 99999999));
                mysqli_query($con, "UPDATE users SET rec_hash = '".$randh."' WHERE id='".$data['id']."' ");
                
                $message='<html>
					<body style="font-family: Verdana; color: #333333; font-size: 12px;">
						<table style="width: 350px; margin: 0px auto;">
							<tr style="text-align: center;">
								<td style="border-bottom: solid 1px #cccccc;"><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">Password Recovery</h2></td>
							</tr>
							<tr style="text-align: justify;">
								<td style="padding-top: 15px; padding-bottom: 15px;">
									Hello '.$data['login'].',
									<br />
									<br />
									Please click on this link to recover your account:<br />
									<a href="http://ptp.skillerzforum.com/recover.php?code='.$randh.'">http://ptp.skillerzforum.com/recover.php?code='.$randh.'</a>
								</td>
							</tr>
							<tr style="text-align: right; color: #777777;">
								<td style="padding-top: 10px; border-top: solid 1px #cccccc;">
									Best Regards!
								</td>
							</tr>
						</table>
					</body>
				</html>';
				require 'conf/phpmailer/PHPMailerAutoload.php';

				$mail = new PHPMailer;
				
				//$mail->SMTPDebug = 3;                               // Enable verbose debug output
				
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'apikey';                 // SMTP username
				$mail->Password = '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';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to
				
				$mail->setFrom('noreply@skillerzforum.com', 'SkillerzPTP');
				$mail->addAddress($data['email']);               // Name is optional
				$mail->addReplyTo('support@skillerzforum.com');
				$mail->isHTML(true);                                  // Set email format to HTML
				
				$mail->Subject = 'SkillerzPTP - Password Recovery';
				$mail->Body    = $message;
				
				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}                
                $mesaj = '<div class="alert alert-success">A password reset link is sent. Please check your email.</div>';
			}else{
				$mesaj = '<div class="alert alert-danger">Invalid Username Or Password.</div>';
			}
		}else{
			$mesaj = '<div class="alert alert-danger">Invalid Captcha, Please try again.</div>';
		}
}

$hash = "";
$done = false;
if(isset($_POST['reset']))
{
		$rescap = $_POST['g-recaptcha-response'];
		$pass = mysqli_real_escape_string($con, $_POST['pass']);
		$pass1 = mysqli_real_escape_string($con, $_POST['pass1']);
		$skey = "6LeDOQATAAAAAMg7N7OPMFZskXzKYViSgsEaGnO3";
		$request = get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$rescap);
		$res = json_decode($request);
		$pass2 = $pass;
        $pass = md5($pass);
		$pass1 = md5($pass1);
		$hash = mysqli_real_escape_string($con, $_GET['code']);
		if($res->success == true)
		{
			$sql = mysqli_query($con, "SELECT `id`,`rec_hash`,`pass` FROM `users` WHERE rec_hash = '".$hash."' ");
			$nou = mysqli_num_rows($sql);
			$data = mysqli_fetch_assoc($sql);
			if(($data['id'] != "") && ($data['rec_hash'] != "0") && ($data['rec_hash'] != "") && (strlen($hash) > 6)){
                	if(($pass != $pass1) || strlen($pass2) < 6){
                    	$mesaj = '<div class="alert alert-danger">Passwords are insecure or do not match.</div>';
                	}else{
                    	mysqli_query($con, "UPDATE `users` set `pass`='".$pass1."', `rec_hash`='' WHERE id='".$data['id']."' ");
						$mesaj = '<div class="alert alert-success">Password reset successful, You may login now.</div>';
						$done = true;
					}
			}else{
				$mesaj = '<div class="alert alert-danger">Invalid recovery link.</div>';
			}

		}else{
			$mesaj = '<div class="alert alert-danger">Invalid Captcha, Please try again.</div>';
		}
}

?>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Skillerz PTP - Recover password </title>
        <!-- BEGIN CSS FRAMEWORK -->
        <link rel="stylesheet" href="./template/bootstrap.min.css">
        <link rel="stylesheet" href="./template/font-awesome.min.css">
        <!-- END CSS FRAMEWORK -->
        <!-- BEGIN CSS PLUGIN -->
        <link rel="stylesheet" href="./template/pace-theme-minimal.css">
        <!-- END CSS PLUGIN -->
        <!-- BEGIN CSS TEMPLATE -->
        <link rel="stylesheet" href="./template/main.css">
        <!-- END CSS TEMPLATE -->
		<?php if($done){ 
				echo "<meta http-equiv='refresh' content='3; url=//".$_SERVER['HTTP_HOST']."/login.php' />";
			}
		?>
    </head>
    <body class="login  pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
  <div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="row">
                    <!-- BEGIN BOX REGISTER -->
                    <div class="col-lg-12">
 
    <h1 class="text-center login-title" >Recover Password</h1>
	<?=$mesaj?>
        <div class="account-wall">
		<a href="index.php"><img src="template/logo.png"></a>
        <!-- BEGIN REGISTER FORM -->
        <?php if(!isset($_GET['code']) && !isset($_POST['reset'])){ ?>
        <form name="recover" method="post" action="" class="form-login" role="form">

            <input type="text" class="form-control" name="uname" placeholder="Enter Your Username or Email" id="username" required="required">
            <script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="6LeDOQATAAAAADjSfpPKYsVdKEoQJaUAHPA6HZ9W" data-theme="light" data-type="image" data-size="normal" data-tabIndex="0"></div>        
            <button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff"  type="submit" onclick="loginForm();" name="recover">
                Recover Password
            </button>
            <label class="pull-left"></label>
        </form>
        <?php }else{ ?>
            <form name="reset" method="post" action="" class="form-login" role="form">

            <input type="password" class="form-control" name="pass" placeholder="Enter new password" required="required">
            <input type="password" class="form-control" name="pass1" placeholder="Re-Enter new password" required="required">
            <script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="6LeDOQATAAAAADjSfpPKYsVdKEoQJaUAHPA6HZ9W" data-theme="light" data-type="image" data-size="normal" data-tabIndex="0"></div>        
            <button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff"  type="submit" onclick="loginForm();" name="reset">
                Reset Password
            </button>
            <label class="pull-left"></label>
        </form>
        <?php } ?>
    </div>
    </div>
    <!-- END BOX REGISTER -->
    </div>
    </div>
    </div>
    </div>

    <!-- BEGIN JS FRAMEWORK -->
    <script src="./template/jquery-2.1.0.min.js.download"></script>
    <script src="./template/bootstrap.min.js.download"></script>
    <!-- END JS FRAMEWORK -->

    <!-- BEGIN JS PLUGIN -->
    <script src="./template/pace.min.js.download"></script>
    <!-- END JS PLUGIN -->
    
    


    <div style="background-color: #fff; border: 1px solid #ccc; box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2); position: absolute; left: 0px; top: -10000px; transition: visibility 0s linear 0.3s, opacity 0.3s linear; opacity: 0; visibility: hidden; z-index: 2000000000;"><div style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: #fff; opacity: 0.05;  filter: alpha(opacity=5)"></div><div class="g-recaptcha-bubble-arrow" style="border: 11px solid transparent; width: 0; height: 0; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000;"></div><div class="g-recaptcha-bubble-arrow" style="border: 10px solid transparent; width: 0; height: 0; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000;"></div><div style="z-index: 2000000000; position: relative;"><iframe src="./template/bframe.html" title="recaptcha challenge" frameborder="0" scrolling="no" sandbox="allow-forms allow-modals allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation" name="omzhrj8dl6gy" style="width: 100%; height: 100%;"></iframe></div></div></body></html>
