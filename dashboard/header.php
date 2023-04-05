<?php
include('../conf/config.php');
if(!$is_online){
	redirect('../index.php');
}
?>
<html lang="en" style="height: auto; min-height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/favicon.ico">
    <title>SkillerzPTP - Dashboard</title>
	<!-- Bootstrap 4.1.3-->
	<link rel="stylesheet" href="./template/bootstrap.css">
	<!-- Bootstrap-extend-->
	<link rel="stylesheet" href="./template/bootstrap-extend.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- ionicons -->
	<link rel="stylesheet" href="./template/ionicons.css">
	<!-- theme style -->
	<link rel="stylesheet" href="./template/master_style.css">
	<!-- Minimal-art Admin skins. choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="./template/_all-skins.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="./template/jquery-jvectormap.css">
	<!-- Morris charts -->
	<link rel="stylesheet" href="./template/morris.css">

	<!-- google font -->
	<link href="./template/css" rel="stylesheet">

</head>   

<body class="skin-blue sidebar-mini" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="font-size:13px;padding:5px;">SPTP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SkillerzPTP </b>User</span>
    </a>
    <!-- Header Navbar-->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <i class="fa fa-bars"></i>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  <!-- User Account-->
          <li class="dropdown user user-menu" style="height:auto;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="./template/user2-160x160.png" class="user-image rounded-circle" alt="User Image">
            </a>
            <ul class="dropdown-menu scale-up">
              <!-- User image -->
              <li class="user-header">
                <img src="./template/user2-160x160.png" class="float-left rounded-circle" alt="User Image">

                <p>
                  <?=$data['login']?>
                  <small class="mb-5"><?=$data['email']?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row no-gutters">
                  <div class="col-12 text-left">
                    <a href="#"><i class="ion ion-settings"></i> Setting</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-block btn-danger"><i class="ion ion-power"></i> Log Out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar -->
    <section class="sidebar" style="height: auto;">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image float-left">
          <img src="./template/user2-160x160.png" class="rounded-circle" alt="User Image">
        </div>
        <div class="info float-left">
          <p><?=$data['login']?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      
      <!-- sidebar menu -->
      <ul class="sidebar-menu tree" data-widget="tree">
        
        <li class="treeview">
		
          <a href="index.php">
            <i class="fa fa-desktop"></i>
			<span>Dashboard</span>
          </a>	
        </li>
		  
        <li class="treeview">
          <a href="stats.php">
            <i class="fa fa-chart-line"></i>
            <span>Statistics</span>

          </a>

        </li>
        <li class="treeview">
          <a href="adcodes.php">
            <i class="fa fa-tags"></i>
            <span>Ad Codes</span>

          </a>

        </li>
		 <li class="treeview">
          <a href="withdraw.php">
            <i class="fa fa-money-bill-alt"></i>
            <span>Withdraw</span>

          </a>

        </li>
     
        
      </ul>
    </section>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
		<!-- item-->
		<a href="" class="link" data-toggle="tooltip" title="" data-original-title="Settings"><i class="fa fa-cog fa-spin"></i></a>
		<!-- item-->
		 <a href="mailto:support@skillerzforum.com" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="fa fa-envelope"></i></a>
		<!-- item-->
		<a href="logout.php" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="fa fa-power-off"></i></a>
	</div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 567px;">