<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$front_title = $_REQUEST['front_title'];
$html_var = strtolower(str_replace(array(' ','.','-'),'_',$front_title));
echo $html_var;
?>