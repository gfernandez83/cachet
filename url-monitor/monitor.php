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
curl_setopt($ch,CURLOPT_VERBOSE,true);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($ch,CURLOPT_MAXREDIRS,1);
curl_setopt($ch,CURLOPT_FAILONERROR,true);
curl_exec($ch);

$returned_status_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
$response_time = round(curl_getinfo($ch,CURLINFO_TOTAL_TIME) * 1000);
$curl_error = curl_error($ch);

curl_close($ch);
}

function last_incident_status ($api_url,$api_token,$stat_data,$name) {
	$data = array();
        $page_id = 1;
        do  {
        $incidents = json_decode(get_incident_status($api_url,$api_token,$stat_data,$page_id),true);
        $page_id += 1;
	if(count($incidents) == 0 ) {
 		return 0;
		exit ();
	}
        foreach($incidents['data'] as $incident) {
               	if(strpos($incident['name'],"$name") !== false) {
                       	$data[] = array($incident['name'],$incident['status'],$incident['created_at']);
                       	}
               	}
        } while($incidents['meta']['pagination']['links']['next_page'] !== null);
	$last = array_pop($data);
	return $last[1];
}

function run_request($url,$threshold,$name,$api_url,$api_token,$metric_id,$interval) {
global $returned_status_code,$response_time,$curl_error,$stat_data;

$check=1;
while (true) {
	monitor_url($url,$metric_id);
	if($returned_status_code == 200) {
		if(last_incident_status($api_url,$api_token,$stat_data,$name) != 4 && last_incident_status($api_url,$api_token,$stat_data,$name) != 0) {
			$incident_status = 4;
			$stat_data = json_encode(array("name"=>"$name","message"=>"$name check succeeded","status"=>"$incident_status","visible"=>1));
			print "updating incident: $name check succeeded";
			create_incident($api_url,$api_token,$stat_data);
		}
		$rt[] = $response_time;
		print_r($rt);
		if(count($rt) >= 5) {
			$art = round(array_sum($rt)/count($rt));
			print $art . "\n";
			$stat_data = json_encode(array("id"=>"$metric_id","value"=>"$art"));
			send_metrics_points($api_url,$api_token,$metric_id,$stat_data);
			$rt=array();
		}	
		$check=1;
	} else { 
		print $check;
		if($check < $threshold) {
			sleep(5);
			$check += 1;
		} else {
			if(last_incident_status($api_url,$api_token,$stat_data,$name) != 1 ) {
				$incident_status = 1;
				$stat_data = json_encode(array("name"=>"$name","message"=>"$curl_error","status"=>"$incident_status","visible"=>1));
				print "creating incident: $curl_error";
				create_incident($api_url,$api_token,$stat_data);
				}
			$check=1;
			}	
		}
	sleep($interval);	
	}	
}
?>
