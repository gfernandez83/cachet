<?php 
include ('config.php');
include ('monitor.php');

$domain = $argv[1];
if(isset($domain)) {
	get_config("$domain");
	run_request($url,$threshold,$name,$api_url,$api_token,$metric_id,$interval);
} else {
	print "Usage: php url-monitor.php \"json\"" . "\n";
	exit ();
}

?>
