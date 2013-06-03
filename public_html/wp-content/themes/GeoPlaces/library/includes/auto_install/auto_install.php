<?php if(get_option('ptthemes_auto_install')=='No' || get_option('ptthemes_auto_install')=='')
{
	function autoinstall_admin_header()
	{
		global $wpdb;
		if(strstr($_SERVER['REQUEST_URI'],'themes.php') && (!isset($_REQUEST['template']) && @$_REQUEST['template']=='') && (!isset($_GET['page']) && $_GET['page']=='')) 
		{
			//update_option("ptthemes_alt_stylesheet",'1-default');
			if(isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='del')
			{echo "hellloo";
				delete_dummy_data();	
				$dummy_deleted = '<p><b>All Dummy data has been removed from your database successfully!</b></p>';
				wp_safe_redirect(admin_url("themes.php"));
			}
			if(isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert'])
			{
				$multicity_db_table_name = $table_prefix . "multicity";
				global $multicity_db_table_name;
				if($wpdb->get_var("SHOW TABLES LIKE \"$multicity_db_table_name\"") == $multicity_db_table_name) {
					
						$insert_muticity = $wpdb->query("INSERT INTO $multicity_db_table_name (country_id,zones_id,cityname,lat,lng,scall_factor,sortorder,is_zoom_home,categories,is_default) VALUES
			('1','3748','New York','40.714321', '-74.00579', 13, 7, 'No', '', 1),
			('2','3740','Philadelphia', '39.952473', '-75.164106', 13, 1, 'Yes', '', 0),('3','1485','San Fransisco', '37.774936', '-122.4194229', 13, 4, 'Yes', '', 0)");
				
						$newyork = $wpdb->get_var("select city_id from $multicity_db_table_name where cityname = 'New York'");
						$philadelphia = $wpdb->get_var("select city_id from $multicity_db_table_name where cityname = 'Philadelphia'");
						$sanfransisco = $wpdb->get_var("select city_id from $multicity_db_table_name where cityname = 'San Fransisco'");
					
				}
				include_once (TT_INCLUDES_FOLDER_PATH . 'auto_install/auto_install_data.php'); // auto install data file
			}
			if(isset($_REQUEST['activated']) && $_REQUEST['activated']=='true')
			{
				$theme_actived_success = '<p class="message">Theme activated successfully.</p>';	
			}
			$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
			if($post_counts>0)
			{
				$dummy_data_msg = '<p> <b>Sample data has been populated on your site. Wish to delete sample data?</b> <br />  <a class="button_delete" href="'.get_option('home').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p>';
			}else
			{
				$dummy_data_msg = '<p> <b>Would you like to auto install this theme and populate sample data on your site?</b> <br />  <a class="button_insert" href="'.get_option('home').'/wp-admin/themes.php?dummy_insert=1">Yes, insert sample data please</a></p>';
			}
	
	
			define('THEME_ACTIVE_MESSAGE','
		<style>
		.highlight { width:60% !important; background:#FFFFE0 !important; overflow:hidden; display:table; border:2px solid #558e23 !important; padding:15px 20px 0px 20px !important; -moz-border-radius:11px  !important;  -webkit-border-radius:11px  !important; } 
		.highlight p { color:#444 !important; font:15px Arial, Helvetica, sans-serif !important; text-align:center;  } 
		.highlight p.message { font-size:13px !important; }
		.highlight p a { color:#ff7e00; text-decoration:none !important; } 
		.highlight p a:hover { color:#000; }
		.highlight p a.button_insert 
			{ display:block; width:230px; margin:10px auto 0 auto;  background:#5aa145; padding:10px 15px; color:#fff; border:1px solid #4c9a35; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_insert { background:#347c1e; color:#fff; border:1px solid #4c9a35;   } 
		.highlight p a.button_delete 
			{ display:block; width:140px; margin:10px auto 0 auto; background:#dd4401; padding:10px 15px; color:#fff; border:1px solid #9e3000; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_delete { background:#c43e03; color:#fff; border:1px solid #9e3000;   } 
		#message0 { display:none !important;  }
		</style>
		
		<div class="updated highlight fade"> '.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>');
			echo THEME_ACTIVE_MESSAGE;
			
		}
	}
	
	add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.

	function delete_dummy_data()
	{
		global $wpdb,$table_prefix;
		delete_option('sidebars_widgets'); //delete widgets
		$productArray = array();
		$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1";
		$pids_info = $wpdb->get_results($pids_sql);
		$multicity_db_table_name = $wpdb->prefix."multicity";
		global $multicity_db_table_name;
		$wpdb->query("DELETE FROM $multicity_db_table_name WHERE `cityname` LIKE 'Philadelphia'");
		$wpdb->query("DELETE FROM $multicity_db_table_name WHERE `cityname` LIKE 'New York'");
		$wpdb->query("DELETE FROM $multicity_db_table_name WHERE `cityname` LIKE 'San Fransisco'");
		foreach($pids_info as $pids_info_obj)
		{	
			wp_delete_post($pids_info_obj->ID);
		}
		wp_redirect(admin_url("themes.php"));
	}
}?>