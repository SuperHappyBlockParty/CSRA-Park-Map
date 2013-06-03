<?php
global $multicity_db_table_name ; // DATABASE TABLE  MULTY CITY
$city_info = get_multicity_name_info();
function get_multicity_city_settings($id,$option_name='cityname')
{
	global $wpdb,$multicity_db_table_name;
	return $wpdb->get_var("select $option_name from $multicity_db_table_name where city_id=\"$id\"");
}

function get_current_city_lat()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}

	$lat = get_multicity_city_settings($catid,'lat');
	if($lat)
	{
		return 	$lat;
	}else
	{
		return 34;	
	}
}

function get_current_city_lng()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	$lng = get_multicity_city_settings($catid,'lng');	
	if($lng)
	{
		return $lng;	
	}else
	{
		return '0';	
	}
}

function get_current_city_scale_factor()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	$scall_factor = get_multicity_city_settings($catid,'scall_factor');
	if($scall_factor)
	{
		return $scall_factor;	
	}else
	{
		return 13;	
	}
}

function get_current_city_set_zooming_opt()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	$set_zooming_opt = get_multicity_city_settings($catid,'set_zooming_opt');
	if($set_zooming_opt)
	{
		return $set_zooming_opt;	
	}else
	{
		return 0;	
	}
}
function get_current_city_map_type()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	$map_type = get_multicity_city_settings($catid,'map_type');
	if($map_type)
	{
		return $map_type;	
	}else
	{
		return 'ROADMAP';	
	}	
}
function get_current_city_map_scroll_flag()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	return get_multicity_city_settings($catid,'is_zoom_home');	
}

function get_current_city_category()
{
	if($_SESSION['multi_city']=='all')
	{
		$catid = $_SESSION['multi_city_default'];	
	}else
	{
		$catid = $_SESSION['multi_city'];
	}
	return get_multicity_city_settings($catid,'categories');	
}

function set_multi_city_wp_admin_post_custom_fields()
{
	global $wpdb,$multicity_db_table_name;
	$multi_city=$wpdb->get_var("select group_concat(city_id) from $multicity_db_table_name where is_default=1");
	$desc_str = get_multicity_id_name_desc();
	$return_arr = array(
	"post_city_id" => array (
		"name"		=> "post_city_id",
		"default" 	=> $multi_city,
		"label" 	=> __("City ID"),
		"type" 		=> "text",
		"desc"      => __("Enter City ID. In case of Multi city settings, The posts will display as per City ID.").'<br><b>'.__('The city Id Information as per theme design settings : ').$desc_str.'</b>',
	),
	);
	return $return_arr;
}

function get_multicity_id_name_desc()
{
	$multicity_arr = get_multicity_name_info();
	$desc_str = '';
	if($multicity_arr)
	{
		foreach($multicity_arr as $key=>$val)
		{
			$desc_arr[] = $val. '=' . $key;
		}
		if($desc_arr)
		{
			$desc_str = implode(', ',$desc_arr);	
		}
	}
	return $desc_str;
}
function get_multicity_name_info()
{
	global $multicity_db_table_name,$wpdb;
	$city_info = array();
	$multisite_arr = $wpdb->get_results("select * from $multicity_db_table_name order by cityname asc, is_default desc");
	if($multisite_arr)
	{
		foreach($multisite_arr as $multisite_arr_obj)
		{
			$city_info[$multisite_arr_obj->city_id] =  $multisite_arr_obj->cityname;
		}
	}
	return $city_info;
}

function get_multicity_dl_options($selected='',$default_option='',$att='')
{
	$city_info = get_multicity_name_info();
	global $wpdb;
	$multy_city_table = $wpdb->prefix."multicity";
	$multici_default = $wpdb->get_var("select city_id from $multy_city_table where is_default=1;");
	$return_str = '<option value="'.$multici_default.'">'.SELECT_CITY_TEXT.'</option>';
	if($city_info)
	{
		foreach($city_info as $key=>$val)
		{
			$context = get_option('blogname');
			$city_name = trim($val);
			
			$return_str .= '<option ';
			if($selected==$key)
			{
				$return_str .= ' selected=selected ';		
			}
			
			$return_str .= 'value="'.$key.'" '.$att.'>';
			if(function_exists('icl_register_string')){
			$return_str .= icl_t($context, $city_name, $val).'</option>';
			}else{
			$return_str .= trim($val).'</option>';	
			}
		}
	}
	return $return_str;
}

function get_multicity_checkbox_options($name,$selected='')
{
	$city_info = get_multicity_name_info();
	$return_str = '';
	if($city_info)
	{
		foreach($city_info as $key=>$val)
		{
			$city_name = trim($val);
			$return_str .= '<div class="multi_checkbox"><input type="checkbox" ';
			if($selected==($key))
			{
				$return_str .= ' checked=checked';		
			}
			$return_str .= 'value="'.($val).'" name='.$name;
			$return_str .= ' />'.trim($val).'</div>';
		}
	}
	return $return_str;
}

function get_multicity_dl($dl_name,$dl_id='',$selected='',$extra='',$default_option='')
{	
	if($dl_id=='')
	{
		$dl_id = $dl_name;	
	}
	global $site_url;
	$dl_options = get_multicity_dl_options($selected,$default_option);
	if($dl_options){
		$return_str = '<form id="multicity_dl_frm_id" name="multicity_dl_frm_name" action="'.$site_url.'" method="post">';
		$return_str .= get_multicit_select_dl($dl_name,$dl_id,$selected,$extra,$default_option,$dl_options);
		//$return_str .= '<input type="hidden" name="multicity" id= "multicity" />';
		$return_str .= '</form>';
	}
	return $return_str;
}

function get_multicit_select_dl($dl_name,$dl_id='',$selected='',$extra='',$default_option='',$dl_options='')
{
	if($dl_options=='')
	{	
		$dl_options = get_multicity_dl_options($selected,$default_option);
	}
	$return_str = '';
	$return_str .= '<select name="'.$dl_name.'" id="'.$dl_id.'" '.$extra.'>';
	$return_str .= $dl_options;	
	return $return_str .= '</select>';	
}

function multicity_js_insert_to_header()
{
?>
<script type="text/javascript">
function set_selected_city(city)
{
	document.multicity_dl_frm_name.submit();
}
</script>
<?php
}
add_action('wp_head', 'multicity_js_insert_to_header');
?>