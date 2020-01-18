<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','fantasy');



$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME) or die ('Could not connect to the database server' . mysqli_connect_error());
$conn->set_charset("utf8");

?>