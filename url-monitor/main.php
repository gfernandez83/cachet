<?php 
include ('config.php');
include ('monitor.php');

get_config('99uu.json');
run_request($url,$threshold,$name,$api_url,$api_token,$metric_id,$interval);
//print $returned_status_code . "\n";
//print $response_time . "\n";
print $curl_error. "\n";

?>
