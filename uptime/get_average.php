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

$con = mysqli_connect($dbserver,$dbuser,$dbpass) or die(mysqli_error());

mysqli_select_db($con,$dbname) or die(mysqli_error());

$query = "select round(avg(value)) as avg_response_time from metric_points where metric_id=$metric_id and DATE(created_at) = DATE(NOW());";

$resp = mysqli_query($con,$query) or die(mysqli_error());

$average = mysqli_fetch_assoc($resp);

print  $average['avg_response_time'] . "ms" . "\n";



?>
