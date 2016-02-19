<?php 


$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$name = "DNS lookup status";
//get list of nameservers
if(!$servers = @file_get_contents("http://www.dns-lg.com/nodes.json")) {
	echo "api unreachable";
	} 
else 
	{
	$ns_data = json_decode($servers, true);
	$nameservers = array();
	foreach($ns_data['nodes'] as $data) {
		array_push($nameservers, $data['name']);
	}
}		
//get 5 random servers
$rand_server = array_rand($nameservers, 5);
$pass = 0;
$fail = 0;
//check if domain is resolvable
foreach($rand_server as $rand) { 
	$url="http://www.dns-lg.com/$nameservers[$rand]/99uu999.com/a";
	if(!$contents = @file_get_contents($url)) {
	//$ns = array();
	//array_push($ns,$nameservers[$rand]);
	$fail = $fail + 1;
	} else {
	$pass = $pass + 1;
	}
}

if($pass >= 1) {
	$message = "Everything is normal.";
	$incident_status = 4;
} else {
	$message = "Domain name cannot be resolve.";
	$incident_status = 1;
}	

$data = array("component_id" => 2,"name" => "$name","status" => $incident_status,"message" => "$message");
$data_string = json_encode($data);

//function to get incident status
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
	return  send_curl($uri,$cachet_token,$data_string,$method);
}
//send curl request with headers
function send_curl($uri,$cachet_token,$data_string,$method) {
	$ch = curl_init($uri);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: $cachet_token"));
	return curl_exec($ch);
}

//get incident status
$results = json_decode(get_status($status_url,$cachet_token,$data_string),true);
/*foreach($result['data'] as $res) {
	if($res['name'] == $name) {
		$incident_id = $res['id'];
		update_status($status_url,$cachet_token,$data_string,$incident_id);
	} else {
		if($incident_status != 4) {
		create_new($status_url,$cachet_token,$data_string);
		break;
		}
	}
}*/
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
