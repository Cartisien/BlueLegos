<?php

$dbhost = "XXXXXX";//host IP
$dbuser = "XXXXXX";//database username
$dbpass = "XXXXXX";//database password
$dbname = "XXXXXX";//database name

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die (mysql_error());
mysql_select_db($dbname);

?>
