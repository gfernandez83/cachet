<?php 
include ('send_status.php');
function monitor_url ($url,$metric_id) {
global $returned_status_code,$response_time,$curl_error,$stat_data;
$user_agent="Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36 (cachet)";
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_NOBODY,true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_TIMEOUT,10);
curl_setopt($ch,CURLOPT_USERAGENT,$user_agent);
//curl_setopt($ch,CURLOPT_VERBOSE,true);
curl_setopt($ch,CURLOPT_FAILONERROR,true);
curl_exec($ch);

$returned_status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
$response_time = round(curl_getinfo($ch,CURLINFO_TOTAL_TIME) * 1000);
$curl_error = curl_error($ch);

curl_close($ch);
$stat_data = json_encode(array("id"=>"$metric_id","value"=>"$response_time"));
}

function last_incident_status ($api_url,$api_token,$stat_data,$page_id) {
	$data = array();
        $page_id = 1;
        do  {
        $incidents = json_decode(get_incident_status($api_url,$api_token,$stat_data,$page_id),true);
        $page_id += 1;
        foreach($incidents['data'] as $incident) {
               if(strpos($incident['name'],"$name") !== false) {
                       $data[] = array($incident['name'],$incident['status'],$incident['created_at']);
                       }
               }
        } while($incidents['meta']['pagination']['links']['next_page'] !== null);
	if(end($data[1]) != 4){
		return 1;
	} else {
		return 4; 
}


function run_request($url,$threshold,$name,$api_url,$api_token,$metric_id,$interval) {
global $returned_status_code,$response_time,$curl_error,$stat_data;

while (true) {
	monitor_url($url,$metric_id);
	if($returned_status_code == 200) {
		if(last_incident_status($api_url,$api_token,$stat_data,$page_id) != 4) {
			$incident_status = 4;
			$stat_data = json_encode(array("name"=>"$name","message"=>"$curl_error","status"=>"$incident_status","visible"=>1));
			print "updating incident: $name check succeeded";
			create_incident($api_url,$api_token,$stat_data);
		}
		send_metrics_points($api_url,$api_token,$metric_id,$stat_data);	
	} else { 
		$check=1;
		while ($check < $threshold) {
			sleep(5);
			monitor_url($url,$metric_id);
			if($returned_status_code != 200) {
				$check += 1;
				continue; 
			} else {
			send_metrics_points($api_url,$api_token,$metric_id,$stat_data);
			break;	
			}
		}
		if(last_incident_status($api_url,$api_token,$stat_data,$page_id) != 1) {
			$incident_status = 1;
			$stat_data = json_encode(array("name"=>"$name","message"=>"$curl_error","status"=>"$incident_status","visible"=>1));
			print "creating incident: $curl_error";
			create_incident($api_url,$api_token,$stat_data);
		}
	}	
	sleep($interval);	
}
}
?>
