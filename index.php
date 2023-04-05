<?php
include("conf/config.php");

if(!isset($_COOKIE['ref']) && isset($_GET['ref']))
	setcookie("ref",$_GET['ref'],time() + (48 * 60 * 60));
$users = mysqli_num_rows(mysqli_query($con, "SELECT id from users"));
$paid = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(amount) as amtpaid from requests where paid='1'"));
$nofhits = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(views) as views from stats"));

$mesaj = '';
$done = false;
if(isset($_POST['cont'])){
    $name = $_POST['fname'];
    $email = $_POST['semail'];
    $sub = $_POST['sbject'];
    $msg = $_POST['comments'];
    $rescap = $_POST['g-recaptcha-response'];
    $skey = "6LeDOQATAAAAAMg7N7OPMFZskXzKYViSgsEaGnO3";
    $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$rescap);
    $res = json_decode($request);
    if($res->success == true)
    {

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
		
	$mail->setFrom($email, $name);
	$mail->addAddress('support@skillerzforum.com');               // Name is optional
	$mail->addReplyTo($email);
	$mail->isHTML(false);                                  // Set email format to HTML
			
	$mail->Subject = 'Contact: '.$sub;
	$mail->Body    = $msg;
				
	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    $mesaj = '<div class="alert alert-success">Your message is sent.</div>';                
    }else{
    $mesaj = '<div class="alert alert-danger">Invalid Captcha, Please try again.</div>';
    }
    $done = true;
}
?>

<!DOCTYPE html>
<!-- saved from url=(0040) -->
<html lang="en" class="no-js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skillerz PTP - Paid To Promote</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="VBThemes">

    <link rel="shortcut icon" href="">

    <!-- Magnific-popup -->
    <link rel="stylesheet" href="./template/magnific-popup.css">

    <!--Slider Css-->
    <link href="./template/owl.carousel.css" rel="stylesheet">
    <link href="./template/owl.theme.css" rel="stylesheet">
    <link href="./template/owl.transitions.css" rel="stylesheet">
	<link href="//cdn.materialdesignicons.com/2.8.94/css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="./template/mobiriseicons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./template/materialdesignicons.min.css">

    <!--bootstrap Css-->
    <link rel="stylesheet" type="text/css" href="./template/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="./template/style.css" rel="stylesheet">
	<script type="text/javascript">
	function diff(){
		var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
		var firstDate = new Date(2012,10,01);
		var secondDate = new Date();

		var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
		return diffDays;
	}
	</script>
</head>

    <body>
        
        <!-- START NAVBAR -->
        <nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
            <div class="container">
                <!-- LOGO -->
                <a class="navbar-brand logo" href="">
                    <img src="./template/logo.png" style="height:60px;" alt="" class="img-fluid logo-light">
                    <img src="./template/logo.png" style="height:60px;" alt="" class="img-fluid logo-dark">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
                    <i class="mdi mdi-menu"></i>
                </button>
                <div class="navbar-collapse collapse show" id="navbarCollapse" style="">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a href="#home" class="nav-link">Home</a>
                        </li>
						<?php if(!$is_online){ ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="nav-link">Register</a>
                        </li>
						<?php }else{ ?>
						<li class="nav-item">
                            <a href="/dashboard" class="nav-link">Dashboard</a>
                        </li>
						<?php } ?>
						<li class="nav-item">
                            <a href="#contact" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END NAVBAR -->

        <!-- Home Section Start-->
        <section class="bg_home_personal_img full_height_100vh_home" id="home">
            <div class="bg_overlay_cover_on"></div>
            <div class="home_table_cell">
                <div class="home_table_cell_center">
                    <div class="container position-relative up-index">
                        <div class="row justify-content-center">
                        <div class="alert alert-danger">
                We are in a non-functional state, Please do not send your traffic here. We had a good run but, the time is up.
            </div>
                            <div class="col-lg-12">
                                <div class=" mx-auto text-center home_text_personal">
                                    <span class="text-white home_top_header">Hello &amp;  Welcome</span>
                                    <h1 class="home_title  mt-4 font-weight-bold text-white mb-0"> We  <span class="simple-text-rotate font-weight-bold" style="opacity: 0.999997;">Are Skillerz PTP.,Help You Earn.,Monetize Traffic.</span></h1>
                                    <p class="home_subtitle mx-auto mt-4 mb-0">Monetize your traffic in all your sites across all devices with the best possible eCPM. We find the highest paying campaign for each and every visit & match it accordingly boosting your revenue.</p>
                                    <div class="home_btn_manage mt-4 pt-2">
                                        <?php if(!$is_online){ ?><a href="register.php" class="btn btn_outline_custom btn-rounded"> Get Started</a>
										<?php }else{ ?><a href="/dashboard" class="btn btn_outline_custom btn-rounded"> Members Area </a><?php } ?>
										
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <canvas class="particles-js-canvas-el" width="1349" height="582" style="width: 100%; height: 100%; position: absolute; top: 0px;"></canvas></section>
        <!-- Home Section End-->


        <!-- Start Services -->
        <section class="section_all bg-light" style="padding-top:20px">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-lg-4">
                        <div class="text-center services_box bg-white p-4 mt-3">
                            <div class="service_icon text-center">
                                <i class="mbri-responsive"></i>
                            </div>
                            <div class="service_content mt-4">
                                <h5 class="font-weight-bold">Ad Formats</h5>
                                <p class="mt-3 text-muted mb-0">We provide you with standard destop ad formats and a direct link.</p>
                            </div>
                            <div class="mt-4">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="text-center services_box bg-white p-4 mt-3">
                            <div class="service_icon text-center">
                                <i class="mbri-growing-chart"></i>
                            </div>
                            <div class="service_content mt-4">
                                <h5 class="font-weight-bold">Intuitive Reporting</h5>
                                <p class="mt-3 text-muted mb-0">Stats are provided in a detailed manner for your generated revenue.</p>
                            </div>
                            <div class="mt-4">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="text-center services_box bg-white p-4 mt-3">
                            <div class="service_icon text-center">
                                <i class="mbri-clock"></i>
                            </div>
                            <div class="service_content mt-4">
                                <h5 class="font-weight-bold">Timely Payments</h5>
                                <p class="mt-3 text-muted mb-0">Payments are made via Bitcoin & Paypal on monthly basis.</p>
                            </div>
                            <div class="mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Services -->
        <!-- Counter Start -->
        <section class="section_all bg_counter_cover">
            <div class="bg_overlay_cover_on"></div>
            <div class="container">
                <div class="row" id="counter">
                    <div class="col-lg-3">
                        <div class="text-center counter_box p-4 mt-3 text-white">
                            <div class="counter_icon mb-3">
                                <i class="mbri-users"></i>
                            </div>
                            <h1 class="counter_value mb-1"><?=(number_format($users/1000,2))."K"?></h1>
                            <p class="info_name mb-0">Registered Users</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="text-center counter_box p-4 mt-3 text-white">
                            <div class="counter_icon mb-3">
                                <i class="mbri-cash"></i>
                            </div>
                            <h1 class="counter_value mb-1"><?=(number_format($paid['amtpaid']/1000,2))."K"?></h1>
                            <p class="info_name mb-0">Paid</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="text-center counter_box p-4 mt-3 text-white">
                            <div class="counter_icon mb-3">
                                <i class="mbri-rocket"></i>
                            </div>
                            <h1 class="counter_value mb-1"><?=(number_format($nofhits['views']/1000000,2))."M"?></h1>
                            <p class="info_name mb-0">Impressions Served</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="text-center counter_box p-4 mt-3 text-white">
                            <div class="counter_icon mb-3">
                                <i class="mbri-calendar"></i>
                            </div>
                            <script type="text/javascript">document.write('<h1 class="counter_value mb-1">'+diff()+'</h1>');</script>
                            <p class="info_name mb-0">Days Active</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Us Start -->
        <footer class="section_all bg-light" id="contact" style="padding-top:0px;padding-bottom:10px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section_title text-center">
                            <p class="mb-0">Get in touch</p>
                            <h3 class="font-weight-bold text-capitalize mb-0">Contact Us</h3>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <button type="button" class="btn btn_custom btn_round" data-toggle="modal" data-target="#exampleModalCenter">Get In Touch</button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mb-0 font-weight-bold" id="exampleModalLongTitle"> Contact Us</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="custom_form_body" action="" method="post">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="fname" placeholder="Your Name">
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="semail" placeholder="Your Registered Email">
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="sbject" placeholder="Subject">
                                                </div>

                                                <div class="form-group mt-2">
                                                    <textarea name="comments" id="comments" rows="6" class="form-control" placeholder="Please mention your account details & your issue here..."></textarea>
                                                </div>
                                                <div class="form-group">
                                                <script src="https://www.google.com/recaptcha/api.js" async defer></script><div class="g-recaptcha" data-sitekey="6LeDOQATAAAAADjSfpPKYsVdKEoQJaUAHPA6HZ9W" data-theme="light" data-type="image" data-size="normal" data-tabIndex="0"></div>        
                                                </div>
                                                <div>
                                                    <input class="btn btn_custom w-50" name="cont" type="submit" value="Submit" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal1">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mb-0 font-weight-bold" id="exampleModalLongTitle"> Contact Us</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?php echo $mesaj ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="contact_social_icons text-center mt-3">
                            <ul class="list-unstyled">
                                <li class="list-inline-item"><iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2FSkillerzPTP%2F&width=141&layout=button_count&action=like&size=large&show_faces=true&share=true&height=46&appId" width="141" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe></li>

                            </ul>
                            <div class="mt-4">
                                <p class="text-muted mb-0">© Copyright | SkillerzPTP 2018 All Right Reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Contact Us End  -->

        <!-- JAVASCRIPTS -->
        <script src="./template/jquery.min.js.download"></script>
        <script src="./template/popper.min.js.download"></script>
        <script src="./template/bootstrap.min.js.download"></script>
        <!--TESTISLIDER JS-->
        <script src="./template/owl.carousel.min.js.download"></script>
        <script src="./template/isotope.js.download"></script>
        <script src="./template/jquery.magnific-popup.min.js.download"></script>
        <script src="./template/scrollspy.min.js.download"></script>
        <script src="./template/jquery.easing.min.js.download"></script> 
        <script src="./template/jquery.simple-text-rotator.js.download"></script>       
        <!--PARTICLES ANIMATE JS-->
        <script src="./template/particles.js.download"></script>  
        <script src="./template/particles.app.js.download"></script>        
        <script src="./template/custom.js.download"></script>
        <script>
            $(".simple-text-rotate").textrotator({
                animation: "fade",
                speed: 3500
            });
        </script>
        <?php if($done){
                echo "<script type='text/javascript'>
                $(window).on('load',function(){
                    $('#exampleModal1').modal('show');
                });
            </script>";
        }
        ?>
    <div style="background-color: #fff; border: 1px solid #ccc; box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2); position: absolute; left: 0px; top: -10000px; transition: visibility 0s linear 0.3s, opacity 0.3s linear; opacity: 0; visibility: hidden; z-index: 2000000000;"><div style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: #fff; opacity: 0.05;  filter: alpha(opacity=5)"></div><div class="g-recaptcha-bubble-arrow" style="border: 11px solid transparent; width: 0; height: 0; position: absolute; pointer-events: none; margin-top: -11px; z-index: 2000000000;"></div><div class="g-recaptcha-bubble-arrow" style="border: 10px solid transparent; width: 0; height: 0; position: absolute; pointer-events: none; margin-top: -10px; z-index: 2000000000;"></div><div style="z-index: 2000000000; position: relative;"><iframe src="./template/bframe.html" title="recaptcha challenge" frameborder="0" scrolling="no" sandbox="allow-forms allow-modals allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation" name="omzhrj8dl6gy" style="width: 100%; height: 100%;"></iframe></div></div></body></html>