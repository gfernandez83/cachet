<?php
$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$name = 'tcp traceroute test';
$operator = 'nb88.com';

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

$results =exec("tcptraceroute $operator");
$pattern = '/\b(?:\d{1,3}\.){3}\d{1,3}\b/';
preg_match($pattern,$results,$ip_addr);

if(!empty($ip_addr) && filter_var($ip_addr[0], FILTER_VALIDATE_IP)) {
	$message = "Everything is fine";
	$incident_status = 4;
} else {
	$message = "traceroute took more that 30 hops on $operator or invalid destination address";
	$incident_status = 1; 
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
