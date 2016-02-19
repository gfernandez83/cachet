<?php
$running = exec("ps aux|grep ". basename(__FILE__) ."|grep -v grep|wc -l");
print $running;
$operator = "nb88.com";
if(!$servers = @file_get_contents("http://www.dns-lg.com/nodes.json")) {
        die("api unreachable");
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
$server_array = array();
foreach($rand_server as $rand) {
        $url="http://www.dns-lg.com/$nameservers[$rand]/$operator/a";
        if(!$contents = @file_get_contents($url)) {
	print "error connecting to name servers $nameservers[$rand]";
        } else {
	$webs = json_decode($contents,true);		
        foreach($webs['answer'] as $web) {	
		array_push($server_array, $web['rdata']);		
	}
        }
}



print_r(array_unique($server_array));

$results =exec("tcptraceroute $operator");
$pattern = '/\b(?:\d{1,3}\.){3}\d{1,3}\b/';
preg_match($pattern,$results,$ip_addr);

#print "This is the IP Adress:"  . "$ip_addr";
print_r($ip_addr);

?> 
