<?php

include ('status.php');
$status_url = 'http://status.spiralworks-cloud.com';
$cachet_token = 'AB9t4PZPp4D73EaM5AZy';

function send_curl($uri) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Prometheus-Domain: 99uu.com","Prometheus-Bold:35"));
        return curl_exec($ch);
}

function get_head($uri) {
	$ch = curl_init($uri);
        curl_setopt($ch,CURLOPT_HEADER,true);
        curl_setopt($ch,CURLOPT_NOBODY,true);
	curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'HEAD');
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($ch,CURLOPT_MAXREDIRS,3);
        curl_exec($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);		
}

function send_status($vendor_url,$group_id,$code,$status_url,$cachet_token) {
                if($code == 200 /*|| $code == 301 || $code == 302*/) {
                        $component_status = 1;
                } else {
                        $component_status = 4;
                }
                $stat_data = json_encode(array("name" => "$vendor_url","status" => "$component_status","link" => "$vendor_url","group_id" => "$group_id","description" => "returned with status code $code"));
                $stats = json_decode(get_status($status_url,$cachet_token,$stat_data,$group_id),true);
                $match = 0;
                foreach($stats['data']['enabled_components'] as $stat) {
                        if($stat['name'] === $vendor_url) {
                        $component_id = $stat['id'];
                        update_status($status_url,$cachet_token,$stat_data,$component_id);
                        $match = 1;
                        break;
                                }
                        }
                if($match == 0) {
                        create_new($status_url,$cachet_token,$stat_data);
                }
}

$uri = "http://prometheus-service.com/cms/api/v2/page";
$data = json_decode(send_curl($uri),true);

foreach($data['data']['config']['configs'] as $name) {
		if(stripos($name['name'],'FUN_URL') !== false) { 
		$vendors[] = $name['value'];
		}
}

function query_game($game_id,$group_id,$status_url,$cachet_token) {
         foreach($game_id as $id) {
                 $g_id[] = $id['game_links']['free_play'];
                 }
         foreach($g_id as $id) {
                 $vendor_url ="http://nb88.com" . "$id";
                 $code = get_head($vendor_url);
		 print "$id" . "------->>>>>>". "$code" . "\n";
		 send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
	}
}

$operator_id = 7;
$game_type = "slot_machines";

#$vendor_names = array("pt","gpi","massimo","apollo","betsoft","crescendo","png");
$vendor_names = array("apollo");
foreach($vendor_names as $vendor_name) {
	$prometheus_url = "http://prometheus-service.com/zh-hans/api/v1/operator/" . "$operator_id" . "/game_item/type/" . "$game_type" . "?game-type-category=" . "$vendor_name"; 
	$game_id = json_decode(file_get_contents("$prometheus_url"),true);
	switch ($vendor_name) {
		case "pt":  
			foreach($game_id as $id) {
				$g_id[] = $id['game_id'];
				}
			foreach($g_id as $id) {
				$rep = $id;
				$group_id = 2;
				$srch = array(":gameId", ":lang");
				$rep_string = array("$rep", "en");
				$vendor_url = str_replace($srch,$rep_string,$vendors[0]);
				$code = get_head($vendor_url);
				send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
				}
			break;
		case "gpi":
				$group_id = 3;
				query_game($game_id,$group_id,$status_url,$cachet_token);
				break;
		case "massimo": 
				print "$vendor_name" . "\n";	
				$group_id = 4;
                        foreach($game_id as $id) {
                                $g_id[] = $id['game_id'];
                                }
                        foreach($g_id as $id) {
                                $rep = $id;
                                $srch = array(":gameId", ":lang");
                                $rep_string = array("$rep", "zh-hans");
                                $vendor_url = str_replace($srch,$rep_string,$vendors[6]);
				print($vendor_url);
                                $code = get_head($vendor_url);
                                send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
                                }					
				break;
		case "apollo": 
				print "$vendor_name" . "\n";	
				$group_id = 5;
                        foreach($game_id as $id) {
                                $g_id[] = $id['game_id'];
                                }
                        foreach($g_id as $id) {
                                //$rep = $id;
				list($rep['gameId'],$rep['gameName'],$rep['gameType']) = explode("|",$id);
                                $srch = array(":gameId",":gameName","gameType",":lang");
                                $rep_string = array("$rep[gameId]","$rep[gameName]","$rep[gameType]","en");
                                $vendor_url = str_replace($srch,$rep_string,$vendors[1]);
                                print($vendor_url);
                                $code = get_head($vendor_url);
                                send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
                                }			
				break;
		case "betsoft":
				print "$vendor_name" . "\n";	
				$group_id = 6;
                        foreach($game_id as $id) {
                                $g_id[] = $id['game_id'];
                                }
                        foreach($g_id as $id) {
                                $rep = $id;
                                $srch = array(":gameId",":operator",":lang");
                                $rep_string = array("$rep","Newbet88","en");
                                $vendor_url = str_replace($srch,$rep_string,$vendors[2]);
                                print($vendor_url);
                                $code = get_head($vendor_url);
				print "\n" . $code . "\n";
                                send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
                                }
                                break;
		case "crescendo":
				print "$vendor_name" . "\n";	
				$group_id = 7;
                        foreach($game_id as $id) {
                                $g_id[] = $id['game_id'];
                                }
                        foreach($g_id as $id) {
                                $rep = $id;
                                $srch = array(":gameCode",":merchantId",":lang");
                                $rep_string = array("$rep","Newbet88","zh-hans");
                                $vendor_url = str_replace($srch,$rep_string,$vendors[4]);
                                print($vendor_url);
                                $code = get_head($vendor_url);
                                send_status($vendor_url,$group_id,$code,$status_url,$cachet_token);
                                }
				break;
		case "png":
				print "$vendor_name" . "\n";	
				$group_id = 8;
				query_game($game_id,$group_id,$status_url,$cachet_token);
				print "done with $vendor_name" . "\n";	
				break;
		default: 
			print "unknown vendor name";
	}
}

?>
