<?php
include("conf/config.php");	
if($is_online){
	redirect('dashboard');
}	
if (isset($_POST['login']))
{
		$mesaj='';
		$rescap = $_POST['g-recaptcha-response'];
		$name = mysqli_real_escape_string($con, $_POST['uname']);
		$pass = mysqli_real_escape_string($con, $_POST['pass1']);
		$skey = "6LeDOQATAAAAAMg7N7OPMFZskXzKYViSgsEaGnO3";
		$request = get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$rescap);
		$res = json_decode($request);
		$pass=md5($pass);
		if($res->success == true)
		{
			
			$data = mysqli_fetch_assoc(mysqli_query($con, "SELECT id,login,banned,activate FROM `users` WHERE (`login`='".$name."' OR `email`='".$name."') AND `pass`='".$pass."'"));
			if($data['banned'] > 0){
				$mesaj = '<div class="alert alert-danger">Your account is banned, Please contact us for more details.</div>';
			}elseif($data['activate'] > 0){
				$mesaj = '<div class="alert alert-danger">Your account is unverified, Please check your email for a verification link.</div>';
			}
			elseif($data['id'] != '') {
				mysqli_query($con, "UPDATE `users` SET `log_ip`='".VisitorIP()."', `online`=NOW() WHERE `id`='".$data['id']."'");
                $_SESSION['EX_login'] = $data['id'];
                redirect('dashboard');
			}else{
				$mesaj = '<div class="alert alert-danger">Invalid Username Or Password.</div>';
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

        <title>Skillerz PTP - Login </title>



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
                    <div class="col-lg-12">

    
    <h1 class="text-center login-title" >SIGN IN</h1>
	<?=$mesaj?>
        <div class="account-wall">
		<a href="index.php"><img src="template/logo.png" /></a>
        <!-- BEGIN REGISTER FORM -->
        <form name="register" method="post" action="" class="form-login" role="form">

            <input type="text" class="form-control" name="uname" placeholder="Username" id="username" required="required">
            <input type="password" value="" class="form-control" name="pass1" id="password" placeholder="Password" required="required">

            <script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="6LeDOQATAAAAADjSfpPKYsVdKEoQJaUAHPA6HZ9W" data-theme="light" data-type="image" data-size="normal" data-tabIndex="0"></div>        
            <button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff"  type="submit" onclick="loginForm();" name="login">
                Sign In
            </button>
            <label class="pull-left"></label>
        </form>
    </div>
    <a href="recover.php" class="text-center new-account">Forgot your password? Click here.</a>
    <a href="register.php" class="text-center new-account">Don't have an account? Click here.</a>



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
