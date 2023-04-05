<?php
include('../conf/config.php');
session_regenerate_id(true);
session_unset();
session_destroy();
session_write_close();
header("Location: index.php");
?>