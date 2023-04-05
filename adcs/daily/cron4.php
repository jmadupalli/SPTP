<?php
ignore_user_abort(true);
set_time_limit(0);
ini_set("log_errors", 1);
ini_set("error_log", dirname($_SERVER['SCRIPT_FILENAME']) . "/data/cron4_errors.txt");

define('require', true);
$page = 'cron';
require "data/dbs.php";
date_default_timezone_set("UTC");
$time = time();

$filename = "NO_FILE";
$revshare = "40";
$x = 0;
$y = 0;

$root = dirname($_SERVER['SCRIPT_FILENAME']);
$dir = $root . "/data/stats";

if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if (preg_match("/.html/", $file)) {
            // ############################################
            $name = preg_replace('/.html/', '', $file, -1);
            if (ctype_digit($name) && ($time - $name < (72 * 60 * 60))) {
                $filename = $file;
                break;
            }
            // ############################################
        }
    }
    // ############################################
    closedir($handle);
    // ############################################
}

if ($filename != "NO_FILE") {
    $result = file_get_contents($root."/data/stats/" . $filename);
    $obj = json_decode($result, true); // converting json to array
    $output = array_slice($obj, 0, 250, true); // selecting first N indices

    foreach ($output as $key => $item) {

        list($x, $y, $z) = array_pad(explode("|", $item["sub1"], 3), 3, null);

        if ($x == "ptp") {

            $id = $y;
            $views = $item["impressions"];
            # $amt = $item["earnings"];
            $amt = (($revshare * $item["earnings"]) / 100);

            if (ctype_digit($id)) {

                    $check = mysqli_fetch_assoc(mysqli_query($myConn, "SELECT * FROM `adcash` WHERE  userid='" . $id . "' AND timestamp='" . strtotime("yesterday") . "' "));

                    if (!$check) {

                        $query = mysqli_query($myConn, "INSERT INTO `adcash`(`userid`, `timestamp`) VALUES ('" . $id . "','" . strtotime("yesterday") . "')") or die(mysqli_error($myConn));

                        $user = mysqli_fetch_assoc(mysqli_query($myConn, "SELECT * FROM `users` WHERE id='" . $id . "' AND banned='0' "));

                        if ($user) {
                            $query = mysqli_query($myConn, "UPDATE `users` SET cash=(cash + '" . $amt . "')  WHERE id='" . $id . "'") or die(mysqli_error($myConn));
                            $query = mysqli_query($myConn, "INSERT INTO `stats`(`username`, `views`, `cash`, `timestamp`) VALUES ('" . $user["login"] . "', '" . $views . "','" . $amt . "','" . strtotime("yesterday") . "') ON DUPLICATE KEY UPDATE views=(views + '" . $views . "'), cash=(cash + '" . $amt . "')") or die(mysqli_error($myConn));
                        }
                    }
               
            }
        }

        unset($obj[$key]); // removing the indices
    }

    $obj = array_values($obj); // removing indices

    if (!empty($obj)) {
        $result = json_encode($obj); // converting to json
        # echo $result;
        file_put_contents($root."/data/stats/" . $filename, $result);
        # print_r($obj);
    } else {
        unlink($root."/data/stats/" . $filename);
    }
} else {
    die();
}

?>
