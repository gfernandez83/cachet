<?php

include ('status.php');

$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';
$uri="http://www.99uuuat.com/diagnostic/login";
$method="GET";

//$data = array("email" => "$email","password" => "$pass","persistent" => "false");
//$data_string = json_encode($data);
function send_curl($uri,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest","Accept: application/json, text/javascript", "Accept-Language: zh-hans"));
        return curl_exec($ch);
}
$get_token = json_decode(send_curl($uri,$method),true);
$token = $get_token['result']['token'];
//$sessionId = $get_token['result']['sessionId']

$stat_url="http://www.99uuuat.com/diagnostic/balances";
function get_sys_stat($stat_url,$method,$token) {
        $ch = curl_init($stat_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Cookie: diagnostic_token=$token"));
        return curl_exec($ch);
}

$sys_stat = json_decode(get_sys_stat($stat_url,$method,$token),true);
print_r($sys_stat) . "\n";
