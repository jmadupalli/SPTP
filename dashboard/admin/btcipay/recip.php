<?php
error_reporting(E_ALL); 
include('../../config.php');
if(isset($_GET['k']) && ($_GET['k'] == "ero32@ls0!"))
{
	$q = mysql_query("SELECT id,paypal,sum(amount) as amt from `requests` WHERE `gateway`='bitcoin' AND `paid`='0' group by paypal ORDER BY id ASC");
	
	$n = mysql_num_rows($q);
	if($n > 0){
		$arr = null;
		while($req = mysql_fetch_assoc($q)){
			if(preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $req['paypal'])){
				$amt = floor(($req['amt'] / 6890) * 100000000);
				$arr[$req['paypal']] = $amt;
				// do not update as paid on the first attempt. Take the data out first. Blockchain.info's api sucks!!!
				//mysql_query("UPDATE `requests` SET `paid`='1' WHERE `paypal`='".$req['paypal']."' AND `paid`='0' ");
			}
		}
		$arr = urlencode(json_encode($arr));
		//$json_url = "http://localhost:3000/merchant/4f3da0b8-ca43-4665-ae1c-9f790707f69e/sendmany?password=OjAnL098&recipients=$arr&fee=9000&from=0";
		//$json_data = file_get_contents($json_url);

		$json_feed = json_decode($json_data);

		print_r($json_feed);
	}else echo "No pending requests.";
}

?>