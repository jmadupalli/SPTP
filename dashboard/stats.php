<?php
include('header.php');

$sql="";
$range="";
	if(isset($_POST['range'])){
		$range = mysqli_real_escape_string($con, $_POST['range']);
		$sdate = mysqli_real_escape_string($con, $_POST['sdate']);
		$edate = mysqli_real_escape_string($con, $_POST['edate']);
		
		if($range == "yesterday"){
			$sdate = date("Y-m-d",strtotime("yesterday"));
			$sql = mysqli_query($con, "SELECT * FROM (SELECT username,views,cash,from_unixtime(timestamp, '%Y-%m-%d') as date from stats WHERE username='".$data['login']."') as s WHERE s.date='".$sdate."' ");
		}else if($range == "month"){
			$sdate = date("Y-m-d",strtotime("first day of this month"));
			$edate = date("Y-m-d",strtotime("last day of this month"));
			$sql = mysqli_query($con, "SELECT * FROM (SELECT username,views,cash,from_unixtime(timestamp, '%Y-%m-%d') as date from stats WHERE username='".$data['login']."') as s WHERE s.date>='".$sdate."' AND s.date<='".$edate."' ORDER BY s.date ASC");	
		}else if($range == "prevmon"){
			$sdate = date("Y-m-d",strtotime("first day of last month"));
			$edate = date("Y-m-d",strtotime("last day of last month"));
			$sql = mysqli_query($con, "SELECT * FROM (SELECT username,views,cash,from_unixtime(timestamp, '%Y-%m-%d') as date from stats WHERE username='".$data['login']."') as s WHERE s.date>='".$sdate."' AND s.date<='".$edate."' ORDER BY s.date ASC");			
		}else if($range == "custom"){
			$sql = mysqli_query($con, "SELECT * FROM (SELECT username,views,cash,from_unixtime(timestamp, '%Y-%m-%d') as date from stats WHERE username='".$data['login']."') as s WHERE s.date>='".$sdate."' AND s.date<='".$edate."' ORDER BY s.date ASC");			
		}
	}
?>

    <section class="content-header">
      <h1>
        Statistics
        <small>Reports</small>
      </h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="breadcrumb-item active">Statistics</li>
      </ol>
    </section>
	
	<section class="content">
		<div class="row">
		<div class="info-box" style="width:100%;padding-top:35px;">
		<div style="margin-left:5%;margin-right:5%;" class="form-group">
		<form action="" id="statForm" method="post" name="report">
			<label>Range: </label>
			<select id="range" name="range" class="form-control" onchange="changeDate()" style="margin-left:20px;margin-right:20px;width:auto;display:inline-block;">
				<option value="today" <?php if($range == "today") echo "selected"; ?>>Today</option>
				<option value="yesterday" <?php if($range == "yesterday") echo "selected"; ?>>Yesterday</option>
				<option value="month" <?php if($range == "month") echo "selected"; ?>>This Month</option>
				<option value="prevmon" <?php if($range == "prevmon") echo "selected"; ?>>Last Month</option>
				<option value="custom" <?php if($range == "custom") echo "selected"; ?>>Custom</option>
			</select>
			<label>Start Date: </label> <input id="sdate" type="date" class="form-control" style="margin-left:20px;margin-right:20px;width:auto;display:inline-block;" name="sdate" value="" disabled/>
			<label>End Date: </label> <input id="edate" type="date" class="form-control" style="margin-left:20px;margin-right:20px;width:auto;display:inline-block;" name="edate" value="" disabled/>
			
			<button class="btn btn-lg btn-primary btn-block" style="background-color:#3dceff;border-color:#3dceff;width:auto;display:inline-block" type="submit" name="report">
						Show Reports
			</button>
		</form>
		</div>
		
		</div>
		</div>

	<script type="text/javascript">
	function changeDate(){
		var range =	document.getElementById("range").value;
		var sdate = document.getElementById("sdate");
		var edate = document.getElementById("edate");
		if(range == "custom"){
			sdate.disabled=false;
			sdate.required=true;
			edate.disabled=false;
			edate.required=true;
		}else{
			sdate.disabled=true;
			sdate.required=false;
			edate.disabled=true;
			edate.required=false;			
		}
			
	}
	</script>	
	<div class="row">
	<div class="info-box" style="width:100%;padding-top:35px;">

	<table class="table table-hover" style="text-align:center;">
						<thead>
							<tr>
								<th>Date</td>
								<th>Amount</td>
								<th>Views</td>
								<th>ECpm</td>				
							</tr>
						</thead>
						<tbody>
						<?php if(!isset($_POST['report']) || $range == "today"){ ?>
						<tr>
							<td><?=date("Y-m-d",strtotime("today"))?></td>
							<td>$<?=number_format($data['tmpcash'],3)?></td>
							<td><?=number_format($data['tmphits'])?></td>
							<td><?=number_format($data['tmpcash']/($data['tmphits']/1000),3)?></td>
						</tr>
						<?php }else{ 
							$num = mysqli_num_rows($sql);
							if($num == 0){ echo '<tr><td colspan="6" align="center"><b>No Stats found for specified period.</b></td><tr>';
							}else{
							$totviews=0;$totcash=0;
							for($j=1; $row = mysqli_fetch_assoc($sql); $j++)
							{
							$totviews+=$row['views'];$totcash+=$row['cash'];
						?>
						<tr>
							<td><?=$row['date']?></td>
							<td>$<?=number_format($row['cash'],3)?></td>
							<td><?=number_format($row['views'])?></td>
							<td><?=number_format($row['cash']/($row['views']/1000),3)?></td>
						</tr>
							
							
						<?php } ?>
						</tbody>
						<?php if($range != "yesterday"){ ?>
						<tfoot>
						<tr>
							<td><b>Totals</b></td>
							<td><b>$<?=number_format($totcash,3)?></b></td>
							<td><b><?=number_format($totviews)?></b></td>
							<td><b><?=number_format($totcash/($totviews/1000),3)?></b></td>
						</tr>
						</tfoot>
						<?php }}} ?>
						
	</table>					
	</div>
	</div>
	</section>
	
	
<?php include('footer.php'); ?>
