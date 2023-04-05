<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
include('../../../conf/config.php');


if($is_online && $data['admin'] == 0)
{
    redirect($site['site_url']);
    exit;
}elseif(!$is_online){
	redirect($site['site_url']);
    exit;
}

$guid = "";
$pass = "";

$q = mysqli_query($con, "SELECT paypal,sum(amount) as amt from `requests` WHERE `gateway`='bitcoin' AND `paid`='0' group by paypal");
$recip = array();
$addr = array();
$i = 0;
$sum = 0.000000;

while($row = mysqli_fetch_array($q)){
    $recip[$row[0]] = floor(($row[1] / 31000) * 100000000);
    $addr[$i++] = $row[0];
    $sum += ($row[1] / 31000);
    mysqli_query($con, "UPDATE requests SET `paid`='-2' WHERE `paypal`='".$row['paypal']."' ");
}
echo "No. of payment requests: "+count($addr);
echo "<br/>Total btc to be paid: $sum";
echo "workds";

if(count($addr) == count(array_unique($addr))){
    $recip = urlencode(json_encode($recip));
    $json_url = "http://localhost:3000/merchant/$guid/sendmany?password=$pass&recipients=$recip&fee=5000&from=0";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch,CURLOPT_URL,$json_url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
$json_data = curl_exec($ch);
curl_close($ch);

	$json_feed = json_decode($json_data);

	print_r($json_feed);
	$message = $json_feed->message;
	
	$txid = $json_feed->tx_hash;
	echo $message."<br/>";
    echo $txid;
    if($txid != "" && strlen($txid) > 60)
        mysqli_query($con, "UPDATE requests SET `paid`='1', `details`='".$txid."' WHERE `paid`='-2' ");
}else{
    echo "Duplicates exist, Please check.";
    exit();
}

?>
