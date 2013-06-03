<?php 
global $wpdb,$table_prefix;
/*Currency Table Creation BOF */
if(!get_option('ptthemes_photo_gallery'))
{	add_option('ptthemes_photo_gallery','Yes'); }
if(!get_option('ptthemes_email_on_detailpage'))
{	add_option('ptthemes_email_on_detailpage','Yes'); }
if(!get_option('ptthemes_inquiry_on_detailpage'))
{
add_option('ptthemes_inquiry_on_detailpage','Yes'); }
if(!get_option('ptthemes_contact_on_detailpage'))
{
add_option('ptthemes_contact_on_detailpage','Yes'); }
if(!get_option('ptthemes_disable_rating'))
{
add_option('ptthemes_disable_rating','yes'); }
if(!get_option('ptthemes_timthumb'))
{
add_option('ptthemes_timthumb','Yes'); }

if(!get_option('ptthemes_add_place_nav'))
{
add_option('ptthemes_add_place_nav','Yes'); }

if(!get_option('ptthemes_add_event_nav'))
{
add_option('ptthemes_add_event_nav','Yes'); }
if(!get_option('ptthemes_listing_views'))
{
add_option('ptthemes_listing_views','No'); }


if(!get_option('ptthemes_notification_type'))
{
add_option('ptthemes_notification_type','PHP Mail'); }
if(!get_option('ptthemes_customcss'))
{
add_option('ptthemes_customcss','Deactivate'); }
if(!get_option('ptthemes_top_pages_nav_enable'))
{
add_option('ptthemes_top_pages_nav_enable','Activate'); }
if(!get_option('ptthemes_category_noindex'))
{
add_option('ptthemes_category_noindex','No'); }
if(!get_option('ptthemes_archives_noindex'))
{
add_option('ptthemes_archives_noindex','No'); }
if(!get_option('ptthemes_tag_archives_noindex'))
{
add_option('ptthemes_tag_archives_noindex','No'); }
if(!get_option('ptthemes_captcha_dislay')){
add_option('ptthemes_captcha_dislay','None of them'); }
if(!get_option('ptthemes_category_map_place'))
{
add_option('ptthemes_category_map_place','yes'); }
if(!get_option('ptthemes_category_map_event'))
{
add_option('ptthemes_category_map_event','yes'); }
if(!get_option('ptthemes_enable_multicity_flag'))
{
add_option('ptthemes_enable_multicity_flag','yes'); }
if(!get_option('ptthemes_facebook_button'))
{
add_option('ptthemes_facebook_button','Yes'); }
if(!get_option('ptthemes_tweet_button'))
{
add_option('ptthemes_tweet_button','Yes'); }
if(!get_option('ptthemes_breadcrumbs'))
{
add_option('ptthemes_breadcrumbs','Yes'); }
if(!get_option('ptthemes_cat_listing'))
{
add_option('ptthemes_cat_listing','Listing'); }
if(!get_option('ptthemes_postcontent_full'))
{
add_option('ptthemes_postcontent_full','Excerpt'); }
if(!get_option('ptthemes_content_excerpt_count'))
{
add_option('ptthemes_content_excerpt_count','40'); }
if(!get_option('ptthemes_main_pages_nav_enable'))
{
add_option('ptthemes_main_pages_nav_enable','Activate'); }
if(!get_option('ptthemes_show_empty_category'))
{
add_option('ptthemes_show_empty_category','Yes'); }
if(!get_option('ptthemes_related_listing_cnt'))
{
add_option('ptthemes_related_listing_cnt','3'); }
if(!get_option('ptthemes_pagination'))
{
add_option('ptthemes_pagination','Default + WP Page-Navi support'); }
if(!get_option('currency_symbol') || get_option('currency_symbol') == ''){
add_option('currency_symbol','USD'); 
}
if(!get_option('splash_page') || get_option('splash_page') == ''){
	add_option('splash_page','splash_city'); 
}if(!get_option('ptthemes_related_listing') || get_option('ptthemes_related_listing') == ''){
add_option('ptthemes_related_listing','Yes'); 
}

if(!get_option('ptthemes_enable_responsivemap') || get_option('ptthemes_enable_responsivemap') == ''){
add_option('ptthemes_enable_responsivemap','Yes'); 
}


$field_check1 = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_icon'");
		if('term_icon' != $field_check1)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_icon text NOT NULL");
		}
		$field_check2 = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_price'");
		if('term_price' != $field_check2)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_price varchar(100) NOT NULL");
		}

$currency_table = $table_prefix . "currency";
global $currency_table;
define('DIR_FS_CSV_PATH',TT_MODULES_FOLDER_PATH.'csv/');
if($wpdb->get_var("SHOW TABLES LIKE \"$currency_table\"") != $currency_table) { 
	$create_currency = "CREATE TABLE " . $currency_table . " (
	  currency_id int(8) NOT NULL AUTO_INCREMENT,
	  currency_name varchar(100) NOT NULL,
	  currency_code varchar(10) NOT NULL,
	  currency_symbol varchar(10) NOT NULL,
	  symbol_position TINYINT(1) NOT NULL,
	  PRIMARY KEY currency_id (currency_id));";
	$wpdb->query($create_currency);
	$currency_file = DIR_FS_CSV_PATH."currency.csv";
	if(file_exists($currency_file))
	  {
		$currency_handel = fopen($currency_file, 'r');
	  }
	$theData = fgets($currency_handel);
	$i = 0;
	$insert_currency = "Insert into $currency_table(currency_id,currency_name,currency_code,currency_symbol,symbol_position) values";
	while (!feof($currency_handel)) { 
		
		$currency_data[] = fgets($currency_handel, 1024); 
		$currency_array = explode(",",$currency_data[$i]);
		if(trim($currency_array[0])!='' && trim($currency_array[2])!='' && trim($currency_array[2])!='' && trim($currency_array[3])!='' && trim($currency_array[4])!='')
		{
			$insert_currency.= "('".trim($currency_array[0])."','".trim($currency_array[1])."','".trim($currency_array[2])."','".trim($currency_array[3])."','".trim($currency_array[4])."'),";
		}
		
		$i++;
	}	
	$wpdb->query(substr($insert_currency,0,-1));
	fclose($currency_handel);
}
/*Currency Table Creation EOF */

/*Zone Table Creation BOF */
$zones_table = $table_prefix . "zones";
global $zones_table;
if($wpdb->get_var("SHOW TABLES LIKE \"$zones_table\"") != $zones_table) { 
	$create_zones = "CREATE TABLE " . $zones_table . " (
	  zones_id int(8) NOT NULL AUTO_INCREMENT,
	  country_id int(8) NOT NULL,
	  zone_code varchar(10) NOT NULL,
	  zone_name varchar(255) NOT NULL,
	  PRIMARY KEY zones_id (zones_id));";
	$wpdb->query($create_zones);
	$zones_file = DIR_FS_CSV_PATH."zones.csv";
	$zones_handel = fopen($zones_file, 'r');
	$theData = fgets($zones_handel);
	$i = 0;
	$j=0;
	$counter=1;
	$insert_zones = "INSERT INTO $zones_table(country_id,zone_code,zone_name) VALUES";
	while (!feof($zones_handel)) { 
		$zones_data[] = fgets($zones_handel, 1024); 
		$zones_array = explode(",",$zones_data[$i]);
		
		/*if($j==200)
		{
			$wpdb->query(substr($insert_zones,0,-2));
			$insert_zones='';
			$insert_zones.= "INSERT INTO $zones_table(country_id,zone_code,zone_name) VALUES";			
			$counter++;
			$j=0;
		}
		$j++;*/
		//$insert_zones = "Insert into $zones_table values('".trim($zones_array[0])."','".trim($zones_array[1])."','".trim($zones_array[2])."','".trim($zones_array[3])."')";
		if(trim($zones_array[0])!='' && trim($zones_array[1])!='' && trim($zones_array[2])!='' && trim($zones_array[3])!='')
		{
			$insert_zones.= "(".trim($zones_array[1]).",'".mysql_escape_string(trim($zones_array[2]))."','".mysql_escape_string(trim($zones_array[3]))."'), ";
		}				
		$i++;
	}	
	$wpdb->query(substr($insert_zones,0,-2));		
	fclose($zones_handel);
}
/*zones Table Creation EOF */


/*Country Table Creation BOF */
$country_table = $table_prefix."countries";
global $country_table;
if($wpdb->get_var("SHOW TABLES LIKE \"$country_table\"") != $country_table) {
	$create_country = "CREATE TABLE IF NOT EXISTS $country_table (
	country_id int(8) NOT NULL AUTO_INCREMENT,
	country_name varchar(255) NOT NULL,
	iso_code_2 char(2) NOT NULL,
	iso_code_3 char(3) NOT NULL,
	PRIMARY KEY (country_id))";
	$wpdb->query($create_country);
	$country_file = DIR_FS_CSV_PATH."country.csv";
	$country_handel = fopen($country_file, 'r');
	$theData = fgets($country_handel);
	$i = 0;
	$j=0;
	$insert_country = "INSERT INTO $country_table(country_id,country_name,iso_code_2,iso_code_3) VALUES";
	while (!feof($country_handel)) { 
		$country_data[] = fgets($country_handel, 1024); 
		$country_array = explode(",",$country_data[$i]);
		/*if($j==100)
		{			
			$wpdb->query(substr($insert_country,0,-1));
			$insert_country='';
			$insert_country.= "INSERT INTO $country_table(country_id,country_name,iso_code_2,iso_code_3) VALUES";
			$j=0;
		}*/
		if(trim($country_array[0])!='' && trim($country_array[1])!='' && trim($country_array[2])!='' && trim($country_array[3])!='')
		{
			$insert_country.="('".trim($country_array[0])."','".mysql_escape_string(trim($country_array[1]))."','".mysql_escape_string(trim($country_array[2]))."','".mysql_escape_string(trim($country_array[3]))."'),";
		}
		$j++;
		$i++;
	}
	
	$wpdb->query(substr($insert_country,0,-1));	
	fclose($country_handel);
}

/*Country Table Creation EOF */

/*MultiCity Table Creation BOF */
$multicity_db_table_name = $table_prefix . "multicity";
global $multicity_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$multicity_db_table_name\"") != $multicity_db_table_name) {
	$create_multicity = "CREATE TABLE IF NOT EXISTS $multicity_db_table_name (
	city_id int(8) NOT NULL AUTO_INCREMENT,
	country_id int(8) NOT NULL,
	ptype varchar(18) NOT NULL,
	zones_id int(8) NOT NULL,
	cityname varchar(255) NOT NULL,
	lat varchar(255) NOT NULL,
	lng varchar(255) NOT NULL,
	scall_factor int(100) NOT NULL,
	sortorder int(11) NOT NULL,
	is_zoom_home varchar(100) NOT NULL,
	categories text NOT NULL,
	is_default tinyint(4) NOT NULL DEFAULT '0',
	PRIMARY KEY (city_id))";
	$wpdb->query($create_multicity);
	
}
	
	
$field_check = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'geo_address'");
if(!isset($field_check))	{
	
$wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `geo_address` VARCHAR(1000) NOT NULL AFTER `is_default`");
} 
$city_editfield_check = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'set_zooming_opt'");
if(!isset($city_editfield_check))	{
	$city_edit_table_alter = $wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `set_zooming_opt` tinyint(2) NOT NULL AFTER `scall_factor`");
	$update_city = $wpdb->query("update $multicity_db_table_name set set_zooming_opt = '0'");
}
$city_maptypefield_check = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'map_type'");
if(!isset($city_maptypefield_check))	{
	$city_edit_table_alter = $wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `map_type` varchar(20) NOT NULL AFTER `set_zooming_opt`");
	$update_city = $wpdb->query("update $multicity_db_table_name set map_type = 'ROADMAP'");
}
$country_id = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'country_id'");
if(!isset($country_id))	{
	$country_id_qry = $wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `country_id` varchar(20) NOT NULL AFTER `map_type`");
	$update_city = $wpdb->query("update $multicity_db_table_name set country_id = '1'");
}

$zones_id = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'zones_id'");
if(!isset($zones_id))	{
	$zones_id_qry = $wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `zones_id` varchar(20) NOT NULL AFTER `country_id`");
	$update_city = $wpdb->query("update $multicity_db_table_name set zones_id = '13'");
}
$cat_ptype = $wpdb->get_var("SHOW COLUMNS FROM $multicity_db_table_name LIKE 'ptype'");
if(!isset($cat_ptype))	{
	$cat_ptype_qry = $wpdb->query("ALTER TABLE $multicity_db_table_name  ADD `ptype` varchar(20) NOT NULL AFTER `zones_id`");
	$update_city = $wpdb->query("update $multicity_db_table_name set ptype = 'place'");
	/* $insert_muticity = $wpdb->query("INSERT INTO $multicity_db_table_name (country_id,zones_id,cityname,lat,lng,scall_factor,sortorder,is_zoom_home,categories,is_default) VALUES
('1','3748','New York','40.714321', '-74.00579', 13, 7, 'No', '', 1),
('2','3740','Philadelphia', '39.952473', '-75.164106', 13, 1, 'Yes', '', 0),('3','1485','San Francisco', '37.774936', '-122.4194229', 13, 4, 'Yes', '', 0)"); */

}
/*MultiCity Table Creation EOF */

/* Custom Post Field TABLE Creation BOF */
$custom_post_meta_db_table_name = $table_prefix . "templatic_custom_post_fields_g4";
global $custom_post_meta_db_table_name,$wpdb ;
//$wpdb->query("DROP TABLE $custom_post_meta_db_table_name");
global $wpdb;
$is_search = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'is_search'");
if(!isset($is_search))	{
$wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `is_search` VARCHAR(10) NOT NULL AFTER `is_require`");
}


		 


add_action('init','insert_categories',14);		  
function insert_categories(){
	global $wpdb,$custom_post_meta_db_table_name;
	if($wpdb->get_var("SHOW TABLES LIKE \"$custom_post_meta_db_table_name\"") != $custom_post_meta_db_table_name){
	$wpdb->query("CREATE TABLE IF NOT EXISTS $custom_post_meta_db_table_name (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `field_category` varchar(255) NOT NULL ,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT 'text,checkbox,date,radio,select,textarea,upload',
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT '1',
	  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
	  `is_edit` tinyint(4) NOT NULL DEFAULT '1',
	  `is_require` tinyint(4) NOT NULL DEFAULT '0',
	  `show_on_page` varchar(20) NOT NULL ,
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT '1',
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT '1',
	  `field_require_desc` text NOT NULL,
	  `style_class` varchar(200) NOT NULL,
	  `extra_parameter` text NOT NULL,
	  `validation_type` varchar(20) NOT NULL,
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	);");

	$categories = get_terms( 'eventcategory', array( 'hide_empty' => 0 ) );
	foreach($categories as $categories){
		$term_ids .= $categories->term_id.',';
		$eids = rtrim($term_ids,',');
	}
	$categories1 = get_terms( 'placecategory', array( 'hide_empty' => 0 ) );
	foreach($categories1 as $categories1){
		$term_ids1 .= $categories1->term_id.',';
		$pids = rtrim($term_ids1,',');
	}
	$ids = rtrim($term_ids.$term_ids1,',');
	$_SESSION['custom_ids'] = $ids;
		
	$qry = $wpdb->query("INSERT INTO $custom_post_meta_db_table_name (`cid`, `post_type`, `admin_title`, `field_category`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_edit`, `is_require`, `show_on_page`, `show_on_listing`, `show_on_detail`, `field_require_desc`, `style_class`, `extra_parameter`, `validation_type`, `extrafield1`, `extrafield2`) VALUES
	(1, 'place', 'Listing Title', '$pids', 'property_name', 'Enter listing title.', 'Listing Title', 'text', '', '', 'Listing Title', 1, 1, 0, 1, 1, 'user_side', 0, 0, 'Please Enter Listing Title', '', '', 'require', '', ''),
	(2, 'both', 'Address', '$ids', 'geo_address', 'Please enter listing address. eg. : <b>230 Vine Street And locations throughout Old City, Philadelphia, PA 19106</b>', 'Address', 'geo_map', '', '', 'Address', 2, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter address to locate your location on map.', '', '', ' ', '', ''),
	(3, 'both', 'Address Latitude', '$ids', 'geo_latitude', '', 'Address Latitude', 'text', '', '', 'Address Latitude', 3, 1, 0, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(4, 'both', 'Address Longitude', '$ids', 'geo_longitude', '', 'Address Longitude', 'text', '', '', 'Address Longitude', 4, 1, 0, 1, 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(5, 'both', 'Google Map View', '$ids', 'map_view', '', 'Google Map View', 'radio', 'Default Map', 'Default Map,Satellite Map,Hybrid Map', 'Google Map View', 7, 1, 0, 1, 1, 'both_side', 0, 0, '0', '', '', ' ', '', ''),
	(6, 'place', 'Listing Description', '$pids', 'proprty_desc', 'Note : Basic HTML tags are allowed', 'Listing Description', 'texteditor', 'Enter description for your listing.', '', 'Listing Description', 5, 1, 0, 1, 1, 'user_side', 0, 0, 'Enter place description.', 'mce', '', 'require', '', ''),

	(7, 'place', 'Special Offers', '$pids', 'proprty_feature', 'Note: List out any special offers (optional)', 'Special Offers', 'texteditor', '', '', 'Special Offers', 7, 1, 1, '1', 0, 'both_side', 0, 0, '', 'mce', '', ' ', '', ''),
	(8, 'place', 'Time', '$pids', 'timing', 'Enter Business or Listing Timing Information. <br> eg. : <b>10.00 am to 6 pm every day</b>', 'Time', 'text', '', '', 'Time', 8, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(9, 'both', 'Phone', '$ids', 'contact', 'You can enter phone number,cell phone number etc.', 'Phone', 'text', '', '', 'Phone', 10, 1, 1, '1', 1, 'both_side', 0, 0, 'Please enter phone number', '', '', 'phone_no', '', ''),
	(10, 'both', 'Email', '$ids', 'email', 'Enter your email address.', 'Email', 'text', '', '', 'Email', 11, 1, 0, 1, 1, 'both_side', 0, 0, 'Please enter your email address.', '', '', 'email', '', ''),
	(11, 'both', 'Website', '$ids', 'website', 'Enter website URL. eg. : <b>http://myplace.com</b>', 'Website', 'text', '', '', 'Website', 11, 1, 1, 1, 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(12, 'both', 'Twitter', '$ids', 'twitter', 'Enter twitter URL. eg. : <b>http://twitter.com/myplace</b>', 'Twitter', 'text', '', '', 'Twitter', 12, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(13, 'both', 'Facebook', '$ids', 'facebook', 'Enter facebook URL. eg. : <b>http://facebook.com/myplace</b>', 'Facebook', 'text', '', '', 'Facebook', 13, 1, 1, 1, 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(14, 'place', 'Tag Keyword', '$pids', 'kw_tags', 'Tags are short keywords, with no space within. Up to 40 characters only.', 'Tag Keyword', 'text', '', '', 'Tag Keyword', 14, 1, 1, 1, 0, 'user_side', 0, 0, '', '', '', ' ', '', ''),
	(15, 'place', 'Select Images', '$pids', 'listing_image', 'Note : You can sort images from Dashboard and then clicking on &quot; Edit&quot;  in the listing', 'Select Images', 'image_uploader', '', '', 'Select Images', 15, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(16, 'event', 'Event Title', '$eids', 'property_name', 'Enter event title.', 'Event Title', 'text', '', '', 'Event Title', 1, 1, 0, 1, 1, 'user_side', 0, 0, 'Please enter event title', '', '', 'require', '', ''),

	(21, 'event', 'Event Start Date', '$eids', 'st_date', 'Enter Event Start Date. eg. : <b>2011-09-05</b>', 'Event Start Date', 'date', '', '', 'Event Start Date', 8, 1, 0, 1, 1, 'both_side', 0, 1, 'Please enter start date of an avent.', '', '', ' ', '', ''),
	(22, 'event', 'Start Time', '$eids', 'st_time', 'Enter Event Start Time. eg. : <b>10:14</b>', 'Start Time', 'text', '', '', 'Start Time', 8, 1, 0, 1, 1, 'both_side', 0, 1, 'Please enter start time of an event.', '', '', ' ', '', ''),
	(23, 'event', 'Event End Date', '$eids', 'end_date', 'Enter Event End Date. eg. : <b>2011-09-05</b>', 'Event End Date', 'date', '', '', 'Event End Date', 9, 1, 0, 1, 1, 'both_side', 0, 1, 'Please enter end date of event.', '', '', ' ', '', ''),
	(24, 'event', 'End Time', '$eids', 'end_time', 'Enter Event End Time. eg. : <b>10:14</b>', 'End Time', 'text', '', '', 'End Time', 9, 1, 0, 1, 1, 'both_side', 0, 1, 'Please enter event end time.', '', '', ' ', '', ''),
	(25, 'event', 'Event Description', '$eids', 'event_desc', 'Note : Basic HTML tags are allowed', 'Event Description', 'texteditor', 'You should enter description content for your listing.', '', 'Event Description', 5, 1, 0, 1, 1, 'user_side', 0, 0, 'Please enter description of an event.', '', '', 'require', '', ''),
	(26, 'event', 'How to Register', '$eids', 'reg_desc', 'Enter how to register details ', 'How to Register', 'texteditor', '<h3>How to Register</h3><p>Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.</p><p><a href &equiv; &acute;javascript:void(0)&acute; mce_href &equiv; &acute;javascript:void(0)&acute; class &equiv; &acute;button&acute;>Register Now</a></p>', '', 'How to Register', 11, 1, 1, 1, 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(27, 'event', 'Registration Fees', '$eids', 'reg_fees', 'Enter Registration Fees, in USD eg. : <b>$50</b>', 'Registration Fees', 'text', '', '', 'Registration Fees', 12, 1, 1, '1', 0, 'both_side', 0, 1, '', '', '', ' ', '', ''),
	(33, 'event', 'Select Images', '$eids', 'listing_image', 'Note : You can sort images from Dashboard and then clicking on &quot; Edit&quot; in the lisitng', 'Select Images', 'image_uploader', '', '', 'Select Images', 18, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),
	(35, 'both', 'Excerpt', '$ids', 'excerpt', 'Note : Basic HTML tags are allowed', 'Excerpt', 'texteditor', 'Enter excerpt for your listing.', '', 'Excerpt', 6, 1, 0, 1, 1, 'user_side', 0, 0, 'Enter excerpt for this listing.', 'mce', '', '', '', ''),
	(34, 'both', 'Video code', '$ids', 'video', 'Add video code here', 'Video code', 'textarea', '', '', 'Video code', 18, 1, 1, '1', 0, 'both_side', 0, 0, '', '', '', ' ', '', ''),(37, 'event', 'Registration URL', '0', 'register_link', '', 'Registration URL', 'text', '', '', 'Registration URL', 12, 1, 0, 0, 0, 'both_side', 0, 0, 'Enter URL for the &acute;Register&acute; button', '', '', '', '', '')"); 
	}	
}

/* $field_check1 = $wpdb->get_row("SELECT * FROM  $custom_post_meta_db_table_name where htmlvar_name LIKE  '%register_link%'");
if($field_check1 =="")	{
$wpdb->query("INSERT INTO $custom_post_meta_db_table_name (`cid`, `post_type`, `admin_title`, `field_category`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_edit`, `is_require`, `show_on_page`, `show_on_listing`, `show_on_detail`, `field_require_desc`, `style_class`, `extra_parameter`, `validation_type`, `extrafield1`, `extrafield2`) VALUES
(37, 'event', 'Registration URL', '0', 'register_link', '', 'Registration URL', 'text', '', '', 'Registration URL', 12, 1, 0, 0, 0, 'both_side', 0, 0, 'Enter URL for the &acute;Register&acute; button', '', '', '', '', '')");
} */
/* Custom Post Field TABLE Creation EOF */
/* Price TABLE Creation BOF */
$price_db_table_name = $table_prefix . "price";

global $price_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$price_db_table_name\"") != $price_db_table_name){
	$price_table = 'CREATE TABLE IF NOT EXISTS '.$price_db_table_name.' (
	  `pid` int(11) NOT NULL AUTO_INCREMENT,
	  `price_title` varchar(255) NOT NULL,
	  `price_desc` varchar(1000) NOT NULL,
	  `price_post_type` varchar(100) NOT NULL,
	  `price_post_cat` varchar(100) NOT NULL,
	  `is_show` varchar(10) NOT NULL,
	  `package_cost` float(10,2) NOT NULL,
	  `validity` int(10) NOT NULL,
	  `validity_per` varchar(10) NOT NULL,
	  `status` int(10) NOT NULL ,
	  `is_recurring` int(10) NOT NULL ,
	  `billing_num` int(10) NOT NULL,
	  `billing_per` varchar(10) NOT NULL,
	  `billing_cycle` varchar(10) NOT NULL,
	  `is_featured` int(10) NOT NULL,
	  `feature_amount` float(10,2) NOT NULL,
	  `feature_cat_amount` float(10,2) NOT NULL,
	  PRIMARY KEY (`pid`)
	)'; 
	$wpdb->query($price_table);

	$price_insert = '
	INSERT INTO `'.$price_db_table_name.'` (`pid`, `price_title`, `price_desc`, `price_post_type`, `price_post_cat`,`is_show`,`package_cost`,`validity`,`validity_per`,`status`,`is_recurring`,`billing_num`,`billing_per`,`billing_cycle`,`is_featured`,`feature_amount`,`feature_cat_amount`) VALUES
	(1, "Free", "Special time-limited offer: No charges for listing your place/event.", "both","","1","0","Unlimited","","1","","","","", 1,"0","0"),(2, "Summer pack", "Special time-limited offer", "both","","1","40","3","M","1","","","","",1,"10","4")';
	$wpdb->query($price_insert);
}
$price_title = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'title'");
if(isset($price_title))	{
$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `title` `price_title` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}

$price_post_cat = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_post_cat'");
if(isset($price_post_cat))	{
$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `price_post_cat` `price_post_cat` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}

$price_desc = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_desc'");
if(!isset($price_desc))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_desc` VARCHAR(1000) NOT NULL AFTER `price_title`");
}

$price_post_type = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_post_type'");
if(!isset($price_post_type))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_post_type` VARCHAR(1000) NOT NULL AFTER `price_desc`");
}

$price_post_cat = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'price_post_cat'");
if(!isset($price_post_cat))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `price_post_cat` VARCHAR(1000) NOT NULL AFTER `price_post_type`");
}

$is_show = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'is_show'");
if(!isset($is_show))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `is_show` VARCHAR(1000) NOT NULL AFTER `price_post_cat`");
}

$price_days = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'days'");
if(isset($price_days))	{
$wpdb->query("ALTER TABLE $price_db_table_name CHANGE `days` `validity` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL");
}
$validity_per = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'validity_per'");
if(!isset($validity_per))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `validity_per` VARCHAR(1000) NOT NULL AFTER `validity`");
}
$is_recurring = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'is_recurring'");
if(!isset($is_recurring))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `is_recurring` VARCHAR(1000) NOT NULL AFTER `validity_per`");
}
$billing_num = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_num'");
if(!isset($billing_num))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_num` VARCHAR(1000) NOT NULL AFTER `validity_per`");
}
$billing_per = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_per'");
if(!isset($billing_per))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_per` VARCHAR(1000) NOT NULL AFTER `billing_num`");
}
$billing_cycle = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'billing_cycle'");
if(!isset($billing_cycle))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `billing_cycle` VARCHAR(1000) NOT NULL AFTER `billing_per`");
}

$feature_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'feature_amount'");
if(!isset($feature_amount))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `feature_amount` VARCHAR(1000) NOT NULL AFTER `is_featured`");
}
$feature_cat_amount = $wpdb->get_var("SHOW COLUMNS FROM $price_db_table_name LIKE 'feature_cat_amount'");
if(!isset($feature_cat_amount))	{
$wpdb->query("ALTER TABLE $price_db_table_name  ADD `feature_cat_amount` VARCHAR(1000) NOT NULL AFTER `feature_amount`");

	$price_insert = '
	INSERT INTO `'.$price_db_table_name.'` (`pid`, `price_title`, `price_desc`, `price_post_type`, `price_post_cat`,`is_show`,`package_cost`,`validity`,`validity_per`,`status`,`is_recurring`,`billing_num`,`billing_per`,`billing_cycle`,`is_featured`,`feature_amount`,`feature_cat_amount`) VALUES
	(1, "Free", "Special time-limited offer: No charges for listing your place/event.", "both","","1","0","Unlimited","","1","","","","", 1,"0","0"),(2, "Summer pack", "Special time-limited offer", "both","","1","40","3","M","1","","","","",1,"10","4")';
	$wpdb->query($price_insert);
}


/* Price TABLE Creation EOF */
global $ip_db_table_name;
$ip_db_table_name= $table_prefix . "ip_settings";

//$wpdb->query("drop table $ip_db_table_name");
if($wpdb->get_var("SHOW TABLES LIKE \"$ip_db_table_name\"") != $ip_db_table_name){
	$ip_table = 'CREATE TABLE IF NOT EXISTS `'.$ip_db_table_name.'` (
	  `ipid` int(11) NOT NULL AUTO_INCREMENT,
	  `ipaddress` varchar(255) NOT NULL,
	  `ipstatus` varchar(25) NOT NULL,
	  PRIMARY KEY (`ipid`)
	)';
	$wpdb->query($ip_table);
}
/* Price TABLE Creation EOF */
/* Custome User meta TABLE Creation BOF */
$table_prefix = $wpdb->prefix;
global $wpdb,$table_prefix;
$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
global $wpdb,$custom_usermeta_db_table_name;
if(strtolower($wpdb->get_var("SHOW TABLES LIKE \"$custom_usermeta_db_table_name\"")) != strtolower($custom_usermeta_db_table_name))
{
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_usermeta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,date,radio,select,textarea,upload",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `is_delete` tinyint(4) NOT NULL DEFAULT "0",
	  `is_require` tinyint(4) NOT NULL DEFAULT "0",
	  `on_registration` tinyint(4) NOT NULL DEFAULT "1",
	  `on_profile` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
}
$show_on_listing = $wpdb->get_var("SHOW COLUMNS FROM $custom_usermeta_db_table_name LIKE 'show_on_listing'");
if($show_on_listing)	{
$wpdb->query("ALTER TABLE $custom_usermeta_db_table_name  CHANGE `show_on_listing` `on_registration` TINYINT( 4 ) NOT NULL DEFAULT '1'");
}
$show_on_profile = $wpdb->get_var("SHOW COLUMNS FROM $custom_usermeta_db_table_name LIKE 'show_on_detail'");
if($show_on_profile)	{
$wpdb->query("ALTER TABLE $custom_usermeta_db_table_name  CHANGE `show_on_detail` `on_profile` TINYINT( 4 ) NOT NULL DEFAULT '1'");
}
/* Custome User meta TABLE Creation EOF */

/*transaction table BOF*/

global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "transactions";
if($wpdb->get_var("SHOW TABLES LIKE \"$transection_db_table_name\"") != $transection_db_table_name)
{
	$transaction_table = 'CREATE TABLE IF NOT EXISTS `'.$transection_db_table_name.'` (
	`trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) NOT NULL,
	`post_id` bigint(20) NOT NULL,
	`post_title` varchar(255) NOT NULL,
	`status` int(2) NOT NULL,
	`payment_method` varchar(255) NOT NULL,
	`payable_amt` float(25,5) NOT NULL,
	`payment_date` datetime NOT NULL,
	`paypal_transection_id` varchar(255) NOT NULL,
	`user_name` varchar(255) NOT NULL,
	`pay_email` varchar(255) NOT NULL,
	`billing_name` varchar(255) NOT NULL,
	`billing_add` text NOT NULL,
	PRIMARY KEY (`trans_id`)
	)';
	$wpdb->query($transaction_table);	
}

/*transaction table EOF*/

/* ----------------------------------------- Payment Metthod Option BOF --------------------------------------------------*/
//////////pay settings start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	MERCHANT_ID_TEXT,
					"fieldname"		=>	"merchantid",
					"value"			=>	"myaccount@paypal.com",
					"description"	=>	__("Example : myaccount@paypal.com",'templatic'),
					);
	$payOpts[] = array(
					"title"			=>	CANCEL_URL_TEXT,
					"fieldname"		=>	"cancel_return",
					"value"			=>	home_url("/?ptype=cancel_return&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),home_url("/?ptype=cancel_return&pmethod=paypal")),
					);
	$payOpts[] = array(
					"title"			=>	RETURN_URL_TEXT,
					"fieldname"		=>	"returnUrl",
					"value"			=>	home_url("/?ptype=return&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),home_url("/?ptype=return&pmethod=paypal")),
					);
	$payOpts[] = array(
					"title"			=>	NOTIFY_URL_TEXT,
					"fieldname"		=>	"notify_url",
					"value"			=>	home_url("/?ptype=notifyurl&pmethod=paypal"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),home_url("/?ptype=notifyurl&pmethod=paypal")),
					);
								
	$paymethodinfo[] = array(
						"name" 		=> __('Paypal','templatic'),
						"key" 		=> 'paypal',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'1',
						"payOpts"	=>	$payOpts,
						);
	//////////pay settings end////////
	
	//////////google checkout start////////
	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	MERCHANT_ID_TEXT,
					"fieldname"		=>	"merchantid",
					"value"			=>	"1234567890",
					"description"	=>	__("Example : 1234567890",'templatic')
					);
												
	$paymethodinfo[] = array(
						"name" 		=> GCHECKOUT_TEXT,
						"key" 		=> 'googlechkout',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'2',
						"payOpts"	=>	$payOpts,
						);

//////////google checkout end////////
//////////authorize.net start////////

$payOpts = array();
	$payOpts[] = array(
					"title"			=>	LOGIN_ID_TEXT,
					"fieldname"		=>	"loginid",
					"value"			=>	"yourname@domain.com",
					"description"	=>	LOGIN_ID_NOTE
					);
	$payOpts[] = array(
					"title"			=>	TRANS_KEY_TEXT,
					"fieldname"		=>	"transkey",
					"value"			=>	"1234567890",
					"description"	=>	TRANS_KEY_NOTE,
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('Authorize.net','templatic'),
						"key" 		=> 'authorizenet',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'3',
						"payOpts"	=>	$payOpts,
						);

//////////authorize.net end////////
//////////worldpay start////////

	$payOpts = array();	
	$payOpts[] = array(
					"title"			=>	INSTANT_ID_TEXT,
					"fieldname"		=>	"instId",
					"value"			=>	"123456",
					"description"	=>	INSTANT_ID_NOTE
					);
	$payOpts[] = array(
					"title"			=>	ACCOUNT_ID_TEXT,
					"fieldname"		=>	"accId1",
					"value"			=>	"12345",
					"description"	=>	ACCOUNT_ID_NOTE
					);
											
	$paymethodinfo[] = array(
						"name" 		=> WORLD_PAY_TEXT,
						"key" 		=> 'worldpay',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'4',
						"payOpts"	=>	$payOpts,
						);
//////////worldpay end////////
//////////2co start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	VENDOR_ID_TEXT,
					"fieldname"		=>	"vendorid",
					"value"			=>	"1303908",
					"description"	=>	VENDOR_ID_NOTE
					);
	$payOpts[] = array(
					"title"			=>	NOTIFY_URL_TEXT,
					"fieldname"		=>	"ipnfilepath",
					"value"			=>	home_url("/?ptype=notifyurl&pmethod=2co"),
					"description"	=>	sprintf(__("Example : %s",'templatic'),home_url("/?ptype=notifyurl&pmethod=2co")),
					);
					
	$paymethodinfo[] = array(
						"name" 		=> __('2CO (2Checkout)','templatic'),
						"key" 		=> '2co',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'5',
						"payOpts"	=>	$payOpts,
						);
	
								
//////////2co end////////
//////////pre bank transfer start////////

	$payOpts = array();
	$payOpts[] = array(
					"title"			=>	BANK_INFO_TEXT,
					"fieldname"		=>	"bankinfo",
					"value"			=>	"ICICI Bank",
					"description"	=>	BANK_INFO_NOTE
					);
	$payOpts[] = array(
					"title"			=>	ACCOUNT_ID_TEXT,
					"fieldname"		=>	"bank_accountid",
					"value"			=>	"AB1234567890",
					"description"	=>	ACCOUNT_ID_NOTE2,
					);
					
	$paymethodinfo[] = array(
						"name" 		=> PRE_BANK_TRANSFER_TEXT,
						"key" 		=> 'prebanktransfer',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'6',
						"payOpts"	=>	$payOpts,
						);
											
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
	$payOpts = array();
	$paymethodinfo[] = array(
						"name" 		=> PAY_CASH_TEXT,
						"key" 		=> 'payondelevary',
						"isactive"	=>	'1', // 1->display,0->hide
						"display_order"=>'7',
						"payOpts"	=>	$payOpts,
						);

//////////pay cash on devivery end////////
/////////////////////////////////////////
for($i=0;$i<count($paymethodinfo);$i++)
{
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_".$paymethodinfo[$i]['key']."' order by option_id asc";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if(count($paymentinfo)==0)
	{
		$paymethodArray = array(
						"option_name"	=>	'payment_method_'.$paymethodinfo[$i]['key'],
						"option_value"	=>	serialize($paymethodinfo[$i]),
						);
		$wpdb->insert( $wpdb->options, $paymethodArray );
	}
}
/* ----------------------------------------- Payment Metthod Option EOF --------------------------------------------------*/
/* Claim ownership TABLE Creation BOF */
$claim_db_table_name = $table_prefix."claim_ownership";
global $claim_db_table_name ;
if($wpdb->get_var("SHOW TABLES LIKE \"$claim_db_table_name\"") != $claim_db_table_name){
$ownership_table = 'CREATE TABLE `'.$claim_db_table_name .'`  (
`clid` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`post_id` INT NOT NULL, `post_title` VARCHAR(2000) NOT NULL, 
`user_id` INT NOT NULL, `full_name` VARCHAR(1000) NOT NULL, 
`your_email` VARCHAR(250) NOT NULL, 
`contact_number` VARCHAR(200) NOT NULL, 
`your_position` VARCHAR(100) NOT NULL, 
`author_id` VARCHAR(100) NOT NULL, 
`status` VARCHAR(100) NOT NULL, 
`comments` VARCHAR(1000) NOT NULL)';
$wpdb->query($ownership_table);
}
/* Claim ownership TABLE Creation EOF */

/*postcodes table BOF*/

global $wpdb,$table_prefix;
$postcodes_db_table_name = $table_prefix . "postcodes";
if($wpdb->get_var("SHOW TABLES LIKE \"$postcodes_db_table_name\"") != $postcodes_db_table_name)
{
	$postcodes_table = 'CREATE TABLE IF NOT EXISTS `'.$postcodes_db_table_name.'` (
		`pcid` bigint(20) NOT NULL AUTO_INCREMENT,
		`post_id` bigint(20) NOT NULL,
		`post_type` varchar(100) NOT NULL,
		`latitude` varchar(255) NOT NULL,
		`longitude` varchar(255) NOT NULL,
		PRIMARY KEY (`pcid`)
	)';
	$wpdb->query($postcodes_table);	
}
/*postcodes table EOF*/

?>