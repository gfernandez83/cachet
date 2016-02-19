<?php

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$name = 'DDOS has been detected.';
$operator = 'http://99uu999.com';

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

$content = file_get_contents("$operator");
$pattern = '/PPA=[a-z0-9\-\_]{32}/i';
preg_match("$pattern", $content, $matches);
if(isset($matches[0])) {
        #print($matches[0]) . "\n";
	$message = "ddos mode on $operator has been triggered.";
	$incident_status = 1;
} else {
	$message = "Everything is fine.";
	$incident_status = "4";
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
