<?php

$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");

$fname = get_option('post_type_export')."_report_".time().".csv";
header('Content-Description: File Transfer');
header("Content-type: application/force-download");

header('Content-Disposition: inline; filename="'.$fname.'"'); 
define('CUSTOM_POST_TYPE2',__('Event','templatic'));

global $wpdb;
$city_table = $wpdb->prefix."multicity";
$query = "select * from $city_table";
$results = $wpdb->get_results($query);

$header =  "City Id,Country Id,ptype,Zones Id,City Name,Latitude,Longitude,Scall Factor,Sort Order,Is Zoom Home,Categories,Is Default,Geo Address";

echo $header." \r\n";

foreach($results as $_results)
 {
 	$categories = explode(",",$_results->categories);
	$sep = "-";
	$cat_id = "";
	for($i=0;$i<count($categories);$i++)
	{
		if($i== (count($categories)-1))
			$sep = "";
		$cat_id .= $categories[$i].$sep;
	}
	$content=  "$_results->city_id,$_results->country_id,$_results->ptype,$_results->zones_id,$_results->cityname,$_results->lat,$_results->lng,$_results->scall_factor,$_results->sortorder,$_results->is_zoom_home,$cat_id,$_results->is_default,$_results->geo_address";
	 echo $content." \r\n";
 }
 ?>