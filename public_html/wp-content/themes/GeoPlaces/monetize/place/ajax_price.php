<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$packid = $_REQUEST['pkid'];
global  $price_db_table_name,$wpdb ;
	if($packid != "")
	{
	/* if price packages selected then it will fetch the package details for amount and all */
	$pricesql = $wpdb->get_row("select * from $price_db_table_name where pid='".$packid."'"); 
	$homelist = $pricesql->feature_amount;
	$catlist = $pricesql->feature_cat_amount;
	$bothlist = $pricesql->feature_cat_amount + $pricesql->feature_amount;
	$packprice = $pricesql->package_cost;
	$is_featured = $pricesql->is_featured;
	$none = 0;
	
	$priceof = array($homelist,$catlist,$bothlist,$none,$packprice,$is_featured);
	$rawrsize = sizeof($priceof);
	
	$returnstring = "";
	
	//go through the array, using a unique identifier to mark the start of each new record
	for($i=0;$i<$rawrsize;$i++)
	{
		
		$returnstring .= $priceof[$i];
		$returnstring .= '###RAWR###';
	}
	
	echo $returnstring; /* return the package details concat with '###RAWR###'*/
	}
	if(isset($_REQUEST['pckid'])) {
		$pckid = $_REQUEST['pckid'];
		if($pckid != ""){
			get_price_info($price_select,$pckid,CUSTOM_POST_TYPE1);
		} else {
			get_price_info($price_select,$pckid,CUSTOM_POST_TYPE1);
		}	 
	}

	?>