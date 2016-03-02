<?php

include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$group_id=9;
function send_curl($uri) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest","Accept: application/json, text/javascript", "Accept-Language: zh-hans"));
        return curl_exec($ch);
}

function get_sys_stat($stat_url,$token) {
        $ch = curl_init($stat_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: diagnostic_token=$token"));
        return curl_exec($ch);
}

$uri="http://www.99uuuat.com/diagnostic/login";
function get_token($status_url,$cachet_token,$uri,$group_id) {
	$get_token = json_decode(send_curl($uri),true);
	$component_name = $uri;
	$link = $uri;
	if($get_token['status'] === true) {
		$token = $get_token['result']['token'];
		$cookie_file = fopen("cookie.txt", "w") or die("Unable to open file!");
		fwrite($cookie_file,$token);
		fclose($cookie_file);
		$component_status = 1;
		$code = "OK";
	} else {
		$component_status = 3;
		$code = $get_token['result'];
	}
	get_components($status_url,$cachet_token,$component_status,$component_name,$link,$code,$group_id);
}

$functions = array("games","announcements","balances","withdrawal-methods","deposit-methods","system-bank-accounts","member-bank-accounts","wallets");
#$functions = array("wallets");
if(file_exists("cookie.txt") && filesize('cookie.txt') != 0 && time() - filemtime('cookie.txt') < 3600 ) {
	$token = file_get_contents('cookie.txt');
	foreach($functions as $function) {
	$stat_url="http://www.99uuuat.com/diagnostic/$function/";
	$sys_stat = json_decode(get_sys_stat($stat_url,$token),true);
	$code = $sys_stat['status'];
	$component_name = $stat_url;
	$link = $stat_url;
//	print $sys_stat['status'] . "------>>>>>" . $sys_stat['result']['message']  . "\n";
	if($sys_stat['status'] === true){
		$component_status = 1;
		$code = "OK";
		} else {
		$component_status = 3;
		$code = $get_token['result'];
		} 
	get_components($status_url,$cachet_token,$component_status,$component_name,$link,$code,$group_id);
	}
} else {
	get_token($status_url,$cachet_token,$group_id,$uri);
}
