<!DOCTYPE html>
<?php
include('header.php');

$fm = strtotime('first day of this month');
$lm = strtotime('last day of this month');
$monstats = mysqli_fetch_assoc(mysqli_query($con, "SELECT sum(cash) as cash, sum(views) as views from stats WHERE username='".$data['login']."' AND timestamp >='".$fm."' AND timestamp < '".$lm."' "));

?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xl-3 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon push-bottom bg-orange"><i class="ion-social-usd-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Earnings</span>
              <span class="info-box-number"><?=number_format($data['tmpcash'],3)?></span>

              <div class="progress">
                <div class="progress-bar bg-orange" style="width: 50%"></div>
              </div>
              <span class="progress-description text-muted">
				Est. Today.
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon push-bottom bg-orange"><i class="ion ion-ios-eye-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Visits</span>
              <span class="info-box-number"><?=number_format($monstats['views'])?></span>

              <div class="progress">
                <div class="progress-bar bg-orange" style="width: 50%"></div>
              </div>
              <span class="progress-description text-muted">
				This Month
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon push-bottom bg-orange"><i class="ion-social-usd-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Earnings</span>
              <span class="info-box-number"><?=number_format($monstats['cash'],2)?></span>

              <div class="progress">
                <div class="progress-bar bg-orange" style="width: 75%"></div>
              </div>
              <span class="progress-description text-muted">
                    This Month
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-xl-3 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon push-bottom bg-orange"><i class="ion-social-usd"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Balance</span>
              <span class="info-box-number"><?=number_format($data['cash'],2)?></span>

              <div class="progress">
                <div class="progress-bar bg-orange" style="width: 75%"></div>
              </div>
              <span class="progress-description text-muted">
                    Total Unpaid.
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->			
		
      <div class="row">

		
		<div class="col-xl-6 connectedSortable" style="flex: 0 0 100%;max-width:100%">
			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Last 10 days statistics</h3>
				</div>
				<div class="box-body chart-responsive">
				  <div class="chart" id="line-chart" style="height: 332px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
		</div>
				</div>
				<!-- /.box-body -->
            </div>
          <!-- /.box -->
      	</div>         
        <!-- /.col -->        
       </div>        
      <!-- /.row -->		
	</section>
    <!-- /.content -->
<?php
$daym10 = strtotime("-10 days");
$stats = mysqli_query($con, "SELECT cash,views,timestamp from stats WHERE username='".$data['login']."' AND timestamp>='".$daym10."' ");
$data1 = array();
while($stat = mysqli_fetch_assoc($stats)){
	while(date("Y-m-d",$stat['timestamp']) != date("Y-m-d",$daym10)){
		array_push($data1, array("date"=>date("Y-m-d",$daym10),"cash"=>number_format(0,2),"ecpm"=>number_format(0,3)));
		$daym10 += (24*60*60);
	}
	array_push($data1, array("date"=>date("Y-m-d",$daym10), 
						"cash"=>number_format($stat['cash'],2), 
						"ecpm"=>number_format($stat['cash']/($stat['views']/1000),3)
						)
			);
	$daym10 += (24*60*60);
}
while(date("Y-m-d",$daym10) <= date("Y-m-d",strtotime("yesterday"))){
	array_push($data1, array("date"=>date("Y-m-d",$daym10),"cash"=>number_format(0,2),"ecpm"=>number_format(0,3)));
	$daym10 += (24*60*60);
}
$data1 = json_encode($data1);

?>
	<!-- Morris.js charts -->
		<script src="./template/jquery-3.3.1.js.download"></script>

<script src="./template/raphael.min.js.download"></script>
<script src="./template/morris.min.js.download"></script>
<script type="text/javascript">
    var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: <?=$data1?>,
		xkey: 'date',
		ykeys: ['cash','ecpm'],
		labels: ['Earnings','Ecpm'],
		lineWidth:2,
		pointFillColors: ['#ff6028','#45aef1'],
		lineColors: ['#ff6028','#45aef1'],
		hideHover: 'auto',
    });

</script>
 <?php include('footer.php'); ?>