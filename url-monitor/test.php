<?php 
$json = "99uu.json";

$data = json_decode(file_get_contents($json),true);

print($data['monitors'][0]['name']);

?>
