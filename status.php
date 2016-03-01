<?php
function get_components($status_url,$cachet_token,$component_status,$component_name,$link,$code,$group_id) {
$stat_data = json_encode(array("name" => "$component_name","status" => "$component_status","link" => "$link","group_id" => $group_id,"description" => "returned with status code $code"));
        $stats = json_decode(get_status($status_url,$cachet_token,$stat_data,$group_id),true);
        $match = 0;
        foreach($stats['data']['enabled_components'] as $stat) {
                if($stat['name'] === $component_name) {
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

function get_status($status_url,$cachet_token,$stat_data,$group_id) {
        $uri = "$status_url/api/v1/components/groups/$group_id";
        $method = "GET";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}

function update_status($status_url,$cachet_token,$stat_data,$component_id) {
        $uri = "$status_url/api/v1/components/$component_id";
        $method = "PUT";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}

function create_new($status_url,$cachet_token,$stat_data) {
        $uri = "$status_url/api/v1/components";
        $method = "POST";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}

function get_incident_status($status_url,$cachet_token,$stat_data,$page_id) {
        $uri = "$status_url/api/v1/incidents?page=$page_id";
        $method = "GET";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}

function update_incident_status($status_url,$cachet_token,$stat_data,$incident_id) {
        $uri = "$status_url/api/v1/incidents/$incident_id";
        $method = "PUT";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}

function create_new_incident($status_url,$cachet_token,$stat_data) {
        $uri = "$status_url/api/v1/incidents";
        $method = "POST";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}
//send curl request with headers
function send_stat($uri,$cachet_token,$stat_data,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stat_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: $cachet_token"));
        return curl_exec($ch);
}

function get_metrics($status_url,$cachet_token,$stat_data,$page_id,$id) {
        $uri = "$status_url/api/v1/metrics/$id/points?page=$page_id";
        $method = "GET";
        return  send_stat($uri,$cachet_token,$stat_data,$method);
}
?>
