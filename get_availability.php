<?php

include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$group_id = 4;
$stat_data = json_encode(array("name" => "test", "status" => 4));
$operator = $argv[1];

function get_downtime ($start,$end) {
		$interval = $start->diff($end);
		$days = $interval->format('%d') * 1440;
		$hours = $interval->format('%h') * 60;	
		$minute = $interval->format('%i') * 60; 
		$seconds = $interval->format('%s');
		return $days + $hours + $minute + $seconds;	
}

$data = array();
$page_id = 1;
do  {
$incidents = json_decode(get_incident_status($status_url,$cachet_token,$stat_data,$page_id),true);
$page_id += 1;
foreach($incidents['data'] as $incident) {
	if(strpos($incident['message'],"$operator") !== false && strpos($incident['created_at'],date("Y-m-d")) !== false) {
		$data[] = array($incident['status'],$incident['created_at']);
	}
}

} while($incidents['meta']['pagination']['links']['next_page'] !== null); 

$curr = 0;
$next = 1;

$count = count($data) - 1;
$downtime = array();
while ($curr < $count) {
	if($data[$curr][0] != 4 && $data[$next][0] == 4) {
		#$start = new DateTime($data[$curr][1]);
		if($curr == 0 ) {
			$start = new DateTime(date("Y-m-d 00:00:00")); 
			$end = new DateTime($data[$next][1]);
		} else {
			$start = new DateTime($data[$curr][1]);
			$end = new DateTime($data[$next][1]);
		}
		$downtime[] = get_downtime($start,$end);
	} elseif($data[$curr][0] != 4 && $data[$next][0] !=4) {
		$start = new DateTime($data[$curr][1]);
		$end = new DateTime($data[$next][1]);
		$downtime[] = get_downtime($start,$end);
	}
#	print_r($downtime);
	$curr = $next;
	$next += 1;	
}
$total_downtime = array_sum($downtime);
$availability = (86400 - $total_downtime) / 86400;
$percent = round($availability * 100,2);
print $percent . "%" . "\n"; 

?>
