<?php
include("config.php");
$sql = mysqli_query($con, "SELECT * FROM `cron` WHERE `name`='day' ");
$update = mysqli_fetch_assoc($sql);

date_default_timezone_set("UTC");
$date = date('j F Y');
$timestamp = strtotime($date);

function lt($index, $value)
{
    return array($index => array('$lt' => $value));
}

if($update['time'] < $timestamp){
	mysqli_query($con, "UPDATE `cron` SET `time`='".$timestamp."', `ptoday`='0', `hits`='0',`cash`='0',`mcash`='0',`chits`='0',`mchits`='0'");
	mysqli_query($con, "DELETE FROM `adcash` WHERE adcash.timestamp < '" . strtotime("-5 days") . "' ");
	mysqli_query($con, "UPDATE users SET tmpcash='0' AND tmphits='0' ");
	mysqli_query($con, "DELETE FROM `ptphits`");
	


	require_once __DIR__ . "/vendor/autoload.php";

	try{

        $m = new MongoDB\Client;
        $dbname = 'ptp';
        $db = $m->$dbname;

        $tname = "hits";
        $table = $db->selectCollection($tname);

	$table->deleteMany(lt("time", strtotime("-25 hours")));

	}catch(Exception $e){
        	echo $e->getMessage();
	}

}
unset($update);


?>
