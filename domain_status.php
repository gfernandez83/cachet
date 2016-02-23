<?php 

include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
#$email="glenn@mnltechnology.com";
#$pass="qwerty";
$email="devops@mnltechnology.com";
$pass="3ubhshEH6H";
#$uri="http://staging-aws.prometheus-service.com/cms/admin/login";
$uri="http://prometheus-service.com/cms/admin/login";
$method="POST";

$data = array("email" => "$email","password" => "$pass","persistent" => "false");
$data_string = json_encode($data);
function send_curl($uri,$data_string,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json", "Accept-Language: en", "Connection: keep-alive"));
        return curl_exec($ch);
}

$get_token = json_decode(send_curl($uri,$data_string,$method),true);
$token = $get_token['token'];
#$parse = "http://staging-aws.prometheus-service.com/cms/admin/system/operator/";
$parse = "http://prometheus-service.com/cms/admin/system/operator/";

function query($parse,$token) {
	$bearer = "Bearer ". $token;
        $ch = curl_init($parse);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Accept: application/json", "Accept-Language: en", "Authorization: $bearer", "Connection: keep-alive"));
        return curl_exec($ch);
}

//get domain status code
function get_code($url) {
	$ch = curl_init($url);
	curl_setopt($ch,CURLOPT_HEADER,true);
	curl_setopt($ch,CURLOPT_NOBODY,true);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_TIMEOUT,10);
	curl_exec($ch);
	return curl_getinfo($ch, CURLINFO_HTTP_CODE);
}

//get operator domains
$results = json_decode(query($parse,$token),true);
foreach($results as $result) {
	if($result['operatorName']=='99uu' || $result['operatorName']=='Aubo88' || $result['operatorName']=='NewBet88') {
	foreach($result['domains'] as $domain) {
#		print $domain . "\n";
		$code = get_code($domain);
		$component_name = $domain;
		$group_id = 1;
		$link = "http://" . $domain;
		if($code == 200 || $code == 302 || $code == 301) {
			$component_status = 1;
			} elseif($code == 0 || $code == 503 || $code == 500) {
			$component_status = 4;
			} else {
			$component_status = 2;
			}
		$stat_data = json_encode(array("name" => "$component_name","status" => "$component_status","link" => "$link","group_id" => 1,"description" => "returned with status code $code"));
		$stats = json_decode(get_status($status_url,$cachet_token,$stat_data,$group_id),true);
		$match = 0;
		foreach($stats['data']['enabled_components'] as $stat) {
#			print "$stat[name]" . "----->>>" . "$component_name" . "\n";
        		if($stat['name'] === $component_name) {
#			print "true" . "\n";	
			$component_id = $stat['id'];
                	update_status($status_url,$cachet_token,$stat_data,$component_id);
			$match = 1;
			break;
        			}		
			}	
		print($match) . "\n";		
		if($match == 0) {
      			create_new($status_url,$cachet_token,$stat_data);
			}
		}
	}
}
?>
