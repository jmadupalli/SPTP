<?php
@error_reporting(1);
if(isset($_GET['k']) && ($_GET['k']=="seri34@1l")){
	
	//$recipients = urlencode(file_get_contents("http://ptp.skillerzforum.com/admin/btcipay/recip.php?k=ero32@ls0!"));
	$recipients = urlencode('{"1PqUS1QszMzbeid5LVZiKsbJHfLnMJCogj":13470}');
	$json_url = "http://localhost:3000/merchant/$guid/sendmany?password=$firstpassword&recipients=$recipients&fee=5000&from=0";
	$json_data = file_get_contents($json_url);

	$json_feed = json_decode($json_data);

	print_r($json_feed);
	$message = $json_feed->message;
	$txid = $json_feed->tx_hash;
	echo $message."<br/>";
	echo $txid;
}
?>