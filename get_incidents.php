<?php

include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$group_id = 4;
$stat_data = json_encode(array("name" => "test", "status" => 4));

function get_Istatus($status_url,$cachet_token,$stat_data,$page_id) {
        $uri = "$status_url/api/v1/components?page=$page_id";
        $method = "GET";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}
$data = array();
$page_id = 1;
do  {
$incidents = json_decode(get_incident_status($status_url,$cachet_token,$stat_data,$page_id),true);
$page_id += 1;
foreach($incidents['data'] as $incident) {
	if(strpos($incident['message'],'bnd') !== false) {
		$data[] = array($incident['status'],$incident['created_at']);
	}
}

} while($incidents['meta']['pagination']['links']['next_page'] !== null); 

$curr = 0;
$next = 1;

$count = count($data) - 1;

while ($curr < $count) {
	if($data[$curr][0] == 1 && $data[$next][0] == 4) {
		$down = new DateTime($data[$curr][1]);
		$up = new DateTime($data[$next][1]);
		$interval = $down->diff($up);
//		$hours = $interval->format('%h');	
		$minute = $interval->format('%i');	
		print $minute;
	}
	$curr = $next;
	$next += 1;	
}


?>
