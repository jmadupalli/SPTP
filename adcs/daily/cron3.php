<?php
ignore_user_abort(true);
set_time_limit(0);
ini_set("log_errors", 1);
ini_set("error_log", dirname($_SERVER['SCRIPT_FILENAME']) . "/data/cron3_errors.txt");

define('require', true);
$page = 'cron';

$cookie = dirname($_SERVER['SCRIPT_FILENAME']) . "/data/cookie.txt";
date_default_timezone_set("UTC");
###################################### LOGIN ######################################
/*Login API URL*/
$url = "https://www.myadcash.com/console/login_proxy.php";
/*username and password of the user who logs in*/
$post_data = array(
    'login' => "",
    'password' => ""
);
/*specifying curl options*/
$options = array(
    CURLOPT_URL => $url,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POST => true, // POST method is used
    CURLOPT_POSTFIELDS => http_build_query($post_data), //POST request body parameters
    CURLOPT_HTTPHEADER => array('Content-type: application/x-www-form-urlencoded'), //This header is mandatory in case if parameters are passed in request body.
    CURLOPT_RETURNTRANSFER => true
);
/*connection initiation*/
$curl = curl_init();
/*Applying curl options to our curl instance*/
curl_setopt_array($curl, $options);
/*Executing the call*/
$result = curl_exec($curl);
/*Retrieving token from the response*/
$token = json_decode($result, true)["token"];
file_put_contents($cookie, $result);

###################################### DOWNLOADING STATS ######################################

/*Login API URL*/
$url = "https://myadcash.com/console/api_proxy.php";
/*username and password of the user who logs in*/
$post_data = array(
    'token' => $token,
    'call' => "get_publisher_detailed_statistics",
    'start_date' => date("Y-m-d", strtotime("-1 days")),
    'end_date' => date("Y-m-d", strtotime("-1 days")),
    'grouping' => array("sub1")
);
/*specifying curl options*/
$options = array(
    CURLOPT_URL => $url,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_POST => true, // POST method is used
    CURLOPT_POSTFIELDS => http_build_query($post_data), //POST request body parameters
    CURLOPT_HTTPHEADER => array('Content-type: application/x-www-form-urlencoded'), //This header is mandatory in case if parameters are passed in request body.
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEFILE => $cookie
);
/*connection initiation*/
$curl = curl_init();
/*Applying curl options to our curl instance*/
curl_setopt_array($curl, $options);
/*Executing the call*/
$result = curl_exec($curl);
/*Creating array*/
$r_arr = json_decode($result, true);

if (!isset($r_arr["error"])) {
    $object = $r_arr["rows"];
    $toput = json_encode($object);
    file_put_contents(dirname($_SERVER['SCRIPT_FILENAME']) . "/data/stats/" . strtotime("yesterday") . ".html", $toput);
} else {
    echo "Error: " . $r_arr["error"];
}

die();
