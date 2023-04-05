<?php
include('header.php');


?>
<div class="alert alert-success">More ad zones/codes will be provided soon, Please use the below promotion url in the meantime.</div>
	<section class="content-header">
      <h1>
        Ad Codes
        <small>Tags</small>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Ad Codes</li>
      </ol>
    </section>
	
	<section class="content">
		<div class="row">
			<div class="info-box" style="width:100%;padding-top:35px;text-align:center">
			<h3> Your Promotion Link :</h3>
			<center><input type="text" class="form-control" style="width:70%" value="http://ptp.skillerzforum.com/promote.php?id=<?php echo $data['id']?>" readonly> </br></center>
			
			</div>
		
		</div>
	</section>
		<script src="./template/jquery-3.3.1.js.download"></script>

<script src="./template/raphael.min.js.download"></script>
<script src="./template/morris.min.js.download"></script>
<?php include('footer.php'); ?>
