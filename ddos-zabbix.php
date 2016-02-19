<?php

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$trigger_name = $argv[1];
$name = 'DDOS attack has been detected.';
$trigger_status = $argv[2];
$soft_limit = "RPM soft-limit reached, putting ddos protection in place";
$hard_limit = "RPM hard-limit reached, putting ddos protection in place";


function get_status($status_url,$cachet_token,$data_string) {
	$uri = "$status_url/api/v1/incidents";
	$method = "GET";
	return  send_curl($uri,$cachet_token,$data_string,$method);
}	 

function update_status($status_url,$cachet_token,$data_string,$incident_id) {
	$uri = "$status_url/api/v1/incidents/$incident_id";
	$method = "PUT";
	return  send_curl($uri,$cachet_token,$data_string,$method);
}	 

function create_new($status_url,$cachet_token,$data_string) {
	$uri = "$status_url/api/v1/incidents";
	$method = "POST";
	return send_curl($uri,$cachet_token,$data_string,$method);
}	 


function send_curl($uri,$cachet_token,$data_string,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: $cachet_token"));
        return curl_exec($ch);
}

 if($trigger_status == "PROBLEM") {
	if($trigger_name == $soft_limit) {
		$message = $soft_limit;
		$incident_status = 1;
		} elseif ($trigger_name == $hard_limit) {
		$message = $hard_limit;
		$incident_status = 3;
		} else {
		$message = "unknown";
		$incident_status = 3;
		}
} elseif ($trigger_status == "OK") {
	$message = "DDOS status OK";
	$incident_status = 4;
} else{
	$message = "unknown status";
	$incident_status = 3;
	}

$data = array("name" => "$name","status" => "$incident_status","message" => "$message");
$data_string = json_encode($data);

$results = json_decode(get_status($status_url,$cachet_token,$data_string),true);
$match = 0;

foreach($results['data'] as $result) {
	if($result['name'] == $name) {
		$incident_id = $result['id'];
		update_status($status_url,$cachet_token,$data_string,$incident_id);
		$match = 1;
	}
}

if($match == 0 && $incident_status !=4) {
	 create_new($status_url,$cachet_token,$data_string);
}
?>
