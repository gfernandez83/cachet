<?php 
function get_config($json) {
global $api_url,$api_token,$error,$message,$interval,$name,$url,$metric_id,$threshold,$expected_status_code;
//$json=$argv[1];
$error=false;
if(file_exists($json) && filesize($json) != 0) {
	$configs = json_decode(file_get_contents($json),true);
	if(!empty($configs['api_url'])) {
		$api_url = $configs['api_url'];
	}else {
		$error=true;
		$message="API url is not defined. Monitor will not be able to report incidents.";
	}
	if(!empty($configs['api_token'])) {
		$api_token=$configs['api_token'];
	}else {
		$error=true;
		$message="API token is not defined. Monitor will not be able to report incidents.";
	}
	if(!empty($configs['interval'])) {
		$interval=$configs['interval'];
	}else {
		$interval=5;
		$message="check interval is not defined. Will use default value of 5.";
	}
	if(!empty($configs['name'])) {
		$name=$configs['name'];
	}else {
		$name=gethostname();
		$message="Name was not set. Will use hostname.";
	}
	if(!empty($configs['url'])) {
		$url=$configs['url'];
	}else {
		$error=true;
		$message="The url to be monitored is not set. Please check config file.";
	}
	if(!empty($configs['metric_id'])) {
		$metric_id=$configs['metric_id'];
	}else {
		$error=true;
		$message="metric_id was not set. Please check config file.";
	}
	if(!empty($configs['threshold'])) {
		$threshold=$configs['threshold'];
	}else {
		$threshold=3;
		$message="Threshold is not set. Will use default value of 3.";
	}
	if(!empty($configs['expected_status_code'])) {
		$expected_status_code=$configs['expected_status_code'];
	}else {
		$expected_status_code=200;
		$message="expected status code is not set. will use default value of 200.";
	}

}else {
	$error=true;
	$message="config file could not be found or is empty.";	
}
}
?>
