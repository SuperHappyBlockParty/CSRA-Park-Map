<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");	

$country_id = $_REQUEST['country_id'];

echo zones_cmb($country_id); 

?>