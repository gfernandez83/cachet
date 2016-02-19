<?php
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
//send curl request with headers
function send_stat($uri,$cachet_token,$stat_data,$method) {
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $stat_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Cachet-Token: $cachet_token"));
        return curl_exec($ch);
}

?>
