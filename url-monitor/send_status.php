<?php

function create_incident($api_url,$api_token,$stat_data) {
        $uri = "$api_url/incidents";
        $method = "POST";
        return  send_stat($uri,$api_token,$stat_data,$method);
}

function get_incident_status($api_url,$api_token,$stat_data,$page_id) {
        $uri = "$api_url/incidents?page=$page_id";
        $method = "GET";
        return  send_stat($uri,$api_token,$stat_data,$method);
}

function get_metrics($api_url,$api_token,$stat_data,$page_id) {
	$uri="$api_url/metrics?page=$page_id";
	$method="GET";
	return send_stat($uri,$api_token,$stat_data,$method);
}

function send_metrics_points($api_url,$api_token,$metric_id,$stat_data) {
	$uri="$api_url/metrics/$metric_id/points";
	$method="POST";
	return send_stat($uri,$api_token,$stat_data,$method);
}

function send_stat($uri,$api_token,$stat_data,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stat_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: $api_token"));
        return curl_exec($ch);
}

//$metrics_data = array();
/*$page_id = 1;
do  {
$metrics = json_decode(get_metrics($api_url,$api_token,$stat_data,$page_id),true);
$page_id += 1;
print_r($metrics);
foreach($metrics['data'] as $metric) {
        if(strpos($metric['name'],"$name") !== false) {
                //$metrics_data[] = array($metric['name']);

        }
}

} while($metrics['meta']['pagination']['links']['next_page'] !== null);
*/

?>
