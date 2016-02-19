<?php 

$content = file_get_contents('http://99uu.web-replica.spiralworks-cloud.com');
 #$pattern = '/PPA=[:alnum:]/'
preg_match('/PPA=[a-z0-9\-\_]{32}/i', $content, $matches);
if(isset($matches[0])) {
	print($matches[0]) . "\n";
}
?>
