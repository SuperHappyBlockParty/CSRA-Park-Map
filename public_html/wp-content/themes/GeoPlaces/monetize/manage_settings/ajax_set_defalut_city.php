<?php
$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	
global $wpdb,$multicity_db_table_name;
if($_REQUEST['city_id'] == 'splash_city')	{

	$set_currency_sql = "select option_value from $wpdb->options where option_name='splash_page'";
	$set_currencyinfo = $wpdb->get_row($set_currency_sql);
	if($set_currencyinfo){
		update_option('splash_page',$_REQUEST['city_id']);
	} else {	
		$insertcurrency = "insert into $wpdb->options (option_name,option_value) values ('splash_page','".$_REQUEST['city_id']."')";
		$wpdb->query($insertcurrency);
	}

			$set_city_default = $wpdb->get_row("select * from $multicity_db_table_name where is_default='1' ");
			echo $set_city_default->cityname;exit;

			/*$wpdb->query("update $multicity_db_table_name set is_default='0'  ");
		$set_city_default = $wpdb->query("update $multicity_db_table_name set is_default='1' where city_id=".$_REQUEST['city_id']." ");
		if(mysql_affected_rows() > 0)
		{
			$set_city_default = $wpdb->get_row("select * from $multicity_db_table_name where city_id=".$_REQUEST['city_id']." ");
			echo $set_city_default->cityname;exit;
		}*/
	}
	if($_REQUEST['city_id'] == 'default_city')	{
		update_option('splash_page','');
		$wpdb->query("update $multicity_db_table_name set is_default='0'  ");
		$set_city_default = $wpdb->query("update $multicity_db_table_name set is_default='1' where city_id=".$_REQUEST['city']." ");
		//$_SESSION['multi_city'] = $_REQUEST['city'];
		//$_COOKIE['multi_city']= $_SESSION['multi_city'];
		if(mysql_affected_rows() > 0)
		{
			$set_city_default = $wpdb->get_row("select * from $multicity_db_table_name where city_id=".$_REQUEST['city']." ");
			echo $set_city_default->cityname;
			exit;
		}
	}
	
	if(isset($_REQUEST['cityid']) && $_REQUEST['cityid'] != '')	{
		$set_city_default = $wpdb->query("delete from  $multicity_db_table_name  where city_id=".$_REQUEST['cityid']." ");
		if(mysql_affected_rows() > 0)
		{?>
			<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;width:300px;" >
		<?php	_e('City has been deleted successfully.','templatic'); ?>
		</div>
<?php		include_once('ajax_list_city.php');
		}
	}

?>