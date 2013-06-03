<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$my_post_type = explode(",",$_REQUEST['post_type']);
get_wp_category_checklist($my_post_type[1],'','','select_all');
?>