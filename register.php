<?php
include("conf/config.php");		
if (isset($_POST['register']))
{
		$mesaj='';
		$rescap = $_POST['g-recaptcha-response'];
		$skey = "6LeDOQATAAAAAMg7N7OPMFZskXzKYViSgsEaGnO3";
		$request = get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$rescap);
		$res = json_decode($request);
		if($res->success == true){
			$name = mysqli_real_escape_string($con, $_POST['name']);
			if(isset($_COOKIE['ref']))
				$ref = mysqli_real_escape_string($con, $_COOKIE['ref']);
			else
				$ref = "";
			$email = mysqli_real_escape_string($con, $_POST['email']);
			$pass = mysqli_real_escape_string($con, $_POST['pass1']);
			$pass2 = mysqli_real_escape_string($con, $_POST['pass2']);
           
		    if(mysqli_num_rows(mysqli_query($con,"SELECT id FROM `users` WHERE `login`='".$name."' OR `email`='".$email."'" )) > 0)  
			{
				$mesaj = '<div class="alert alert-danger">The username or email is already registered.</div>';
            }
			elseif($pass != $pass2 && strlen($pass) < 6) 
			{
				$mesaj = '<div class="alert alert-danger">Passwords are insecure or do not match.</div>';
			}
			elseif(!isUserID($name))
			{
				$mesaj = '<div class="alert alert-danger">Please enter a valid Username.</div>';
			}else{
				$activate = rand(100000000, 999999999);
				$country = mysqli_real_escape_string($con, $_SERVER['HTTP_CF_IPCOUNTRY']);
				if($ref != ""){
					$sponsor = mysqli_fetch_assoc(mysqli_query($con, "SELECT IP,log_ip from users where id='".$ref."' "));
					if($sponsor['IP'] == $ip || $sponsor['log_ip'] == $ip)
						$ref = "";
				}
				$message='<html>
					<body style="font-family: Verdana; color: #333333; font-size: 12px;">
						<table style="width: 350px; margin: 0px auto;">
							<tr style="text-align: center;">
								<td style="border-bottom: solid 1px #cccccc;"><h2 style="text-align: right; font-size: 14px; margin: 7px 0 10px 0;">Verify Your email</h2></td>
							</tr>
							<tr style="text-align: justify;">
								<td style="padding-top: 15px; padding-bottom: 15px;">
									Hello '.$name.',
									<br />
									<br />
									Please click on this link to activate your account:<br />
									<a href="http://ptp.skillerzforum.com/activate.php?code='.$activate.'">http://ptp.skillerzforum.com/activate.php?code='.$activate.'</a>
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
				$mail->Host = '';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = '';                 // SMTP username
				$mail->Password = '';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect to
				
				$mail->setFrom('noreply@skillerzforum.com', 'SkillerzPTP');
				$mail->addAddress($email);               // Name is optional
				$mail->addReplyTo('support@skillerzforum.com');
				$mail->isHTML(true);                                  // Set email format to HTML
				
				$mail->Subject = 'SkillerzPTP - Verify Your Email';
				$mail->Body    = $message;
				
				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}		
				mysqli_query($con, "INSERT INTO `users`(login,country,email,pass,IP,ref,regdate,activate) values('".$name."','".$country."','".$email."','".md5($pass)."','".VisitorIP()."','".$ref."',NOW(),'".$activate."')");
				$mesaj = '<div class="alert alert-success">Registered Successfully, Please check your email for a verification link before proceeding to login.</div>';
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

        <title>Skillerz PTP - Registration </title>



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
                    <div class="col-lg-12" style="margin-top:20px;">
	<?=$mesaj?>
        <div class="account-wall">
		<a href="index.php"><img src="template/logo.png" /></a>
        <!-- BEGIN REGISTER FORM -->
        <form name="register" method="post" class="form-login" role="form">
			
            <input type="text" class="form-control" name="name" placeholder="User Name" id="name" required="required">
			
			
            <input type="email" class="form-control" name="email" placeholder="Your Email" id="email" required="required">
			
            <input type="password" value="" class="form-control" name="pass1" id="password" placeholder="Password" required="required">
			
            <input type="password" value="" class="form-control" name="pass2" id="repeat-password" placeholder="Confirm Password" required="required">
			
                    
            <script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="6LeDOQATAAAAADjSfpPKYsVdKEoQJaUAHPA6HZ9W" data-theme="light" data-type="image" data-size="normal" data-tabIndex="0"></div>

            <div class="checkbox" style="margin-top:15px;font-size:15px;">
                <input type="checkbox" class="i-checks" name="terms" checked="">
                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </div>
            <button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff" type="submit" onclick="submitForm();" name="register">
                Register
            </button>
            <label class="pull-left"></label>
        </form>
        <!-- END REGISTER FORM -->
    </div>
    <a href="login.php" class="text-center new-account">Already have an account?</a>



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
