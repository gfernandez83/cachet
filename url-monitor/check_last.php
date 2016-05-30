<?php 
include ('send_status.php');
$api_url = "http://status.spiralworks-cloud.com/api/v1";
$api_token = "AB9t4PZPp4D73EaM5AZy";
$name = "99uu";

function last_incident_status ($api_url,$api_token,$stat_data,$name) {
	$data = array();
	$last = array();
        $page_id = 1;
        do  {
        $incidents = json_decode(get_incident_status($api_url,$api_token,$stat_data,$page_id),true);
        $page_id += 1;
	if(count($incidents) == 0 ) {
 		return 0;
		exit();
	}
        foreach($incidents['data'] as $incident) {
               	if(strpos($incident['name'],"$name") !== false) {
                       	$data[] = array($incident['name'],$incident['status'],$incident['created_at']);
			if(empty($data)){
				return 4;
				exit();
				} 
                       	}
               	}
        } while($incidents['meta']['pagination']['links']['next_page'] !== null);

	$last = array_pop($data);
	print $last[1];
	return $last[1];
}
$stat_data = json_encode(array("name"=>"$name"));
last_incident_status($api_url,$api_token,$stat_data,$name);
?>
