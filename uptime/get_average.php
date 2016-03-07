<?php

if($_GET) {
	$metric_id = $_GET['metric_id'];
} else {
	$metric_id = $argv[1];
}

$dbserver = "db1";
$dbname = "cachetdb";
$dbpass = "mypass2015";
$dbuser = "cachet";

$con = mysql_connect($dbserver,$dbuser,$dbpass) or die(mysql_error());

mysql_select_db($dbname,$con) or die(mysql_error());

$query = "select round(avg(value)) as avg_response_time from metric_points where metric_id=$metric_id and DATE(created_at) = DATE(NOW());";

$resp = mysql_query($query) or die(mysql_error());

$average = mysql_fetch_assoc($resp);

print  $average['avg_response_time'] . "ms" . "\n";



?>
