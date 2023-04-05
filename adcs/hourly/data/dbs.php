<?php 
if (!defined('require')) {
    die('Direct access to this area is not permitted.');
} else {

    $sqlhost = "localhost";
    $sqluser = "";
    $sqlpass = "";
    $sqlbase = "ptp";

    $myConn = mysqli_connect($sqlhost, $sqluser, $sqlpass, $sqlbase) or die(mysqli_error($myConn));
}
?>
