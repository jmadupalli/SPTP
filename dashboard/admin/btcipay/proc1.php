<?php
error_reporting(E_ALL); 
include('../../config.php');
if(isset($_GET['k']) && ($_GET['k'] == "ero32@ls0!"))
{
	
		$arr = null; $su=0;
		$str = file_get_contents("penpaydec3.txt");
		$str = explode("\n",$str);
		$str1=null;
		for($i=0;$i<count($str);$i++){
			$temp = explode("\t",$str[$i]);
			if($temp != "")
				$str1[$i] = $temp;
		}
		for($i=0;$i<count($str);$i++){
			if($str1[$i][0] != "")
				$arr[$str1[$i][0]]= floor(($str1[$i][1] / 4500) * 100000000);
		}
		$arr = urlencode(json_encode($arr));/*
		$json_url = "http://localhost:3000/merchant/4f3da0b8-ca43-4665-ae1c-9f790707f69e/sendmany?password=OjAnL098&recipients=$arr&fee=9000&from=0";
		$json_data = file_get_contents($json_url);
		print($json_data);
		$json_feed = json_decode($json_data);

		print_r($json_feed); */
	
}

?>
