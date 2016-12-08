<?php
include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';

$stat_data = json_encode(array("name" => "test", "status" => 4));
$method = "GET";
        $ch = curl_init("http://status.spiralworks-cloud.com/api/v1/incidents?pages=1");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	if($method == "POST") {
	curl_setopt($ch, CURLOPT_POSTFIELDS, $stat_data);
	}
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: AB9t4PZPp4D73EaM5AZy"));
        return curl_exec($ch);


print_r(get_incident_status($status_url,$cachet_token,$stat_data,$page_id));
?>
