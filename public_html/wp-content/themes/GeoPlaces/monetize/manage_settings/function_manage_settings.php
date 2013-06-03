<?php
define('TEMPL_MANAGE_SETTINGS_MODULE', __("Advanced settings",'templatic'));
define('TEMPL_MANAGE_SETTINGS_CURRENT_VERSION', '1.0.0');
define('TEMPL_MANAGE_SETTINGS_LOG_PATH','http://templatic.com/updates/monetize/manage_settings/manage_settings_change_log.txt');
define('TEMPL_MANAGE_SETTINGS_ZIP_FOLDER_PATH','http://templatic.com/updates/monetize/manage_settings/manage_settings.zip');
define('TT_MANAGE_SETTINGS_FOLDER','manage_settings');
define('TT_MANAGE_SETTINGS_MODULES_PATH',TT_MODULES_FOLDER_PATH . TT_MANAGE_SETTINGS_FOLDER.'/');
define ("PLUGIN_DIR_MANAGE_SETTINGS", basename(dirname(__FILE__)));
define ("PLUGIN_URL_MANAGE_SETTINGS", get_template_directory_uri().'/monetize/'.PLUGIN_DIR_MANAGE_SETTINGS.'/');
//----------------------------------------------
     //MODULE AUTO UPDATE START//
//----------------------------------------------

//----------------------------------------------
     //MODULE AUTO UPDATE END//
//----------------------------------------------


/////////admin menu settings start////////////////
add_action('templ_admin_menu', 'manage_settings_add_admin_menu');
function manage_settings_add_admin_menu()
{
	
	add_submenu_page('templatic_wp_admin_menu', TEMPL_MANAGE_SETTINGS_MODULE,TEMPL_MANAGE_SETTINGS_MODULE,'administrator', 'manage_settings', 'manage_settings');
}
function manage_settings()
{
	global $templ_module_path;
		include_once($templ_module_path . 'admin_manage_settings.php');

}
function allow_nt_allow($field_value = ''){
	$y_n_array = array("Y"=>"Yes","N"=>"No");
	$y_n_display = '';
	foreach($y_n_array as $ykey => $yvalue){
		if($ykey == $field_value){
			$yselect = "selected";
		} else {
			$yselect = "";
		}
		$y_n_display .= '<option value="'.$ykey.'" '.$yselect.'>'.$yvalue.'</option>';
	}
	return $y_n_display;
}
function enable_disable($field_value = ''){
	$e_d_array = array("E"=>"Enable","D"=>"Disable");
	$e_d_display = '';
	foreach($e_d_array as $edkey => $edvalue){
		if($edkey == $field_value){
			$edselect = "selected";
		} else {
			$edselect = "";
		}
		$e_d_display .= '<option value="'.$edkey.'" '.$edselect.'>'.__($edvalue,'templatic').'</option>';
	}
	return $e_d_display;
} function position_cmb($position = ''){
	$position_array = array("1"=>"Symbol Before amount","2"=>"Space between Before amount and Symbol","3"=>"Symbol After amount","4"=>"Space between After amount and Symbol");
	$position_display = '';
	foreach($position_array as $pkey => $pvalue){
		if($pkey == $position){
			$pselect = "selected";
		} else {
			$pselect = "";
		}
		$position_display .= '<option value="'.$pkey.'" '.$pselect.'>'.__($pvalue,'templatic').'</option>';
	}
	return $position_display;
} function currency_cmb($currency_value = ''){
	global $wpdb;
	$currency_table = $wpdb->prefix . "currency";
	$curreny_sql = mysql_query("select * from $currency_table order by currency_name");
	$currency_display = '';
	$currency_select = "";
	while($currency_res = mysql_fetch_array($curreny_sql)){
		if($currency_res['currency_code'] == $currency_value){
			$currency_select = "selected";
		} else {
			$currency_select = "";
		}
		$currency_display .= '<option value="'.$currency_res['currency_code'].'" '.$currency_select.'>'.$currency_res['currency_name'].'</option>';
	}
	return $currency_display;
}
/* Function For Select Box EOF */
/*payment Method Settings */
function templ_payment_option_radio()
{
	do_action('templ_payment_option_radio');	
}
					 
add_action('templ_payment_option_radio','templ_payment_option_radio_fun');
function templ_payment_option_radio_fun()
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
	?>
	<h3> <?php echo SELECT_PAY_MEHTOD_TEXT; ?></h3>
	<ul class="payment_method">
	<?php
		$paymentOptionArray = array();
		$paymethodKeyarray = array();
		foreach($paymentinfo as $paymentinfoObj)
		{
			$paymentInfo = unserialize($paymentinfoObj->option_value);
			if($paymentInfo['isactive'])
			{
				$paymethodKeyarray[] = $paymentInfo['key'];
				$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
			}
		}
		ksort($paymentOptionArray);
		$array_pay_options = array();
		if($paymentOptionArray)
		{
			foreach($paymentOptionArray as $key=>$paymentInfoval)
			{
				for($i=0;$i<count($paymentInfoval);$i++)
				{
					$paymentInfo = $paymentInfoval[$i];
					$jsfunction = 'onclick="showoptions(this.value);"';
					$chked = '';
					if($key==1)
					{
						$chked = 'checked="checked"';
					}
				?>
	<li id="<?php echo $paymentInfo['key'];?>"><label>
	  <input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php _e($paymentInfo['name'],'templatic');?></label></li>
	 
	  <?php
					if(file_exists(get_template_directory().'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
					{
					?>
	  <?php
						$array_pay_options[] =get_template_directory().'/library/includes/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php';
						?>
	  <?php
					} 
				 ?> 
	  <?php
				}
			}
		}else
		{
		?>
		<li><?php echo NO_PAYMENT_METHOD_MSG;?></li>
		<?php
		}
		
	?>
	
	</ul>
    <?php
    if($array_pay_options)
	{
		for($i=0;$i<count($array_pay_options);$i++)	
		{
			include_once($array_pay_options[$i]);	
		}
	}
	?>
    <script type="text/javascript">
    function showoptions(paymethod)
    {
    <?php
    for($i=0;$i<count($paymethodKeyarray);$i++)
    {
    ?>
    showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
    if(eval(document.getElementById(showoptvar)))
    {
    document.getElementById(showoptvar).style.display = 'none';
    if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
    {
    document.getElementById(showoptvar).style.display = '';
    }
    }
    <?php
    }
    ?>
    }
    <?php
    for($i=0;$i<count($paymethodKeyarray);$i++)
    {
    ?>
    if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
    {
    showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
    }
    <?php
    }	
    ?>
    </script>
	<?php
	}	
}

function templ_nopayment_redirect()
{
	if(apply_filters('templ_skip_payment_method','0'))
	{
	}else
	{
		wp_redirect(apply_filters('templ_nopayment_redirect_url',home_url('/?ptype=submition&backandedit=1&emsg=nopaymethod')));	
		exit;
	}
}

add_filter('templ_submit_form_emsg_filter','templ_submit_form_emsg_payment');
function templ_submit_form_emsg_payment($msg)
{
	if($_REQUEST['emsg']=='nopaymethod')
	{
		return $msg.=__('Please select payment method on preview page.','templatic');
	}
}
/* Payment Method EOF */
/* Coupon BOF */

function get_payable_amount_with_coupon($total_amt,$coupon_code)
{
	$discount_amt = 0;
	if(function_exists('get_discount_amount'))
	{
		$discount_amt = get_discount_amount($coupon_code,$total_amt);	
	}	
	if($discount_amt>0)
	{
		$final_amount = $total_amt - $discount_amt;
		return sprintf("%01.2f", $final_amount);
	}else
	{
		return sprintf("%01.2f",$total_amt);
	}
}

function get_discount_amount($coupon,$amount)
{
	global $wpdb;
	if($coupon!='' && $amount>0)
	{
		$couponinfo = templ_get_coupon_info($coupon);
		
		if($couponinfo->dis_per=='per')
		{
			$discount_amt = ($amount*$couponinfo->dis_amt)/100;
		}else
		if($couponinfo->dis_per=='amt')
		{
			$discount_amt = $couponinfo->dis_amt;
		}
		return apply_filters('templ_discount_amount_filter',$discount_amt);		
	}
	return '0';			
}
function get_coupon_amount($coupon,$amount)
{
	global $wpdb;
	if($coupon!='' && $amount>0)
	{
		$couponinfo = templ_get_coupon_info($coupon);

		if($couponinfo->dis_per=='per')
		{
			$discount_amt = ($amount*$couponinfo->dis_amt)/100;
		}else
		if($couponinfo->dis_per=='amt')
		{
			$discount_amt = $couponinfo->dis_amt;
		}
		return apply_filters('templ_discount_amount_filter',$discount_amt);		
	}
	return '0';			
}

function templ_get_coupon_info($coupon)
{
	if($coupon!='')
	{
		$couponinfo = json_decode(get_option('discount_coupons'));
		if($couponinfo)
		{
			foreach($couponinfo as $key=>$value)
			{
				if($value->couponcode == $coupon)
				{
					return $value;
				}
			}
		}
	}
	return false;
}

add_filter('templ_submit_form_emsg_filter','templ_submit_form_emsg_fun');
function templ_submit_form_emsg_fun($msg)
{
	if($_REQUEST['emsg']=='invalid_coupon')
	{
		return $msg.=__('Invalid coupon','templatic');
	}
}
/* Coupon EOF */
/* Package BOF */
function templ_get_package_price_info($pro_type='')
{
	global $price_db_table_name,$wpdb;
	if($pro_type)
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array();
	if($priceinfo)
	{
		foreach($priceinfo as $priceinfoObj)
		{
		$info = array();
		$info['id'] = $priceinfoObj->pid;
		$info['title'] = $priceinfoObj->title;
		$info['price'] = $priceinfoObj->amount;
		$info['days'] = $priceinfoObj->days;
		$info['alive_days'] =$priceinfoObj->days;
		$info['cat'] =$priceinfoObj->cat;
		$info['is_featured'] =$priceinfoObj->is_featured;
		$info['title_desc'] = stripslashes($priceinfoObj->title_desc);
		$price_info[] = $info;
		}
	}
	return $price_info;
}

function templ_get_package_price_html()
{
	$packinfo = templ_get_package_price_info();
	$package_arr = array();
	foreach($packinfo as $packinfo_obj)
	{
		$id=$packinfo_obj['id'];
		$title=$packinfo_obj['title'];
		$price=$packinfo_obj['price'];
		$alive_days=$packinfo_obj['alive_days'];
		$days=$packinfo_obj['days'];
		$title_desc=$packinfo_obj['title_desc'];
		if(!$title_desc)
		{
			$currency = get_currency_sym();
			$packageinfo = apply_filters('templ_package_price_desc_filter','%s '.__('in','templatic').' %s '.__('for','templatic').' %s '.__('days','templatic'));
			$title_desc = sprintf($packageinfo,$title,display_amount_with_currency($price),$alive_days);
		}
		$package_arr[$id] = $title_desc;
	}	
	return $package_arr;
}
function get_category_array(){
	global $wpdb;
	$return_array = array();
	$pn_categories = $wpdb->get_results("SELECT $wpdb->terms.name as name, $wpdb->term_taxonomy.count as count, $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id
                                AND $wpdb->term_taxonomy.taxonomy in ('".CUSTOM_CATEGORY_TYPE1."','".CUSTOM_CATEGORY_TYPE2."')
								ORDER BY name");	
	foreach($pn_categories as $pn_categories_obj)
	{
		$return_array[] = array("id" => $pn_categories_obj->cat_ID,
							   "title"=> $pn_categories_obj->name,);
	}
	return $return_array;
}
/* Package EOF */
/* Bulk Upload BOF */
add_filter('templ_bulk_sample_csv_link_filter','templ_bulk_sample_csv_link_fun');
function templ_bulk_sample_csv_link_fun($file)
{
	$file = get_template_directory_uri().'/monetize/'.TT_MANAGE_SETTINGS_FOLDER.'/post_sample.csv';
	return $file;
}
/* Bulk Upload EOF */
/* Custom Post Field BOF*/

function validation_type_cmb($validation_type = ''){
	$validation_type_display = '';
	$validation_type_array = array(" "=>"Select validation type","require"=>"Require","phone_no"=>"Phone No.","digit"=>"Digit","email"=>"Email");
	foreach($validation_type_array as $validationkey => $validationvalue){
		if($validation_type == $validationkey){
			$vselected = 'selected';
		} else {
			$vselected = '';
		}
		$validation_type_display .= '<option value="'.$validationkey.'" '.$vselected.'>'.__($validationvalue,'templatic').'</option>';
	}
	return $validation_type_display;
}
function get_post_custom_fields_templ($post_types,$category_id='',$show_on_page = '',$is_search = '') {

	global $wpdb,$custom_post_meta_db_table_name;
	$post_query = "select * from $custom_post_meta_db_table_name where is_active=1";	
	if($is_search != ''){
		$post_query .= " and (post_type in ($post_types) or post_type='both')";
	} else {
		$post_query .= " and (post_type in ('$post_types') or post_type='both')";
	}
	if($show_on_page != '') {
		$post_query .= " and (show_on_page = '$show_on_page' or show_on_page = 'both_side')";  
	} else {
		$post_query .= " and show_on_page in('both_side','admin_side')";
	}if($is_search != ''){
		$post_query .= " and is_search = '1'";
	}
	if(!is_wp_admin())
	{
		if($category_id != '0' && $category_id !='admin'){
			if(!strstr($category_id,',')){
			$post_query .= " and (field_category LIKE '%,".$category_id.",%' or field_category LIKE '%,".$category_id."' or field_category LIKE '%".$category_id.",%' or field_category = '".$category_id."' or field_category = '0')";
			}else{
			$post_query .= " and ( field_category Like '0' or  field_category = '' ";
			$count = explode(",",$category_id);
			for($k=0;$k<(count($count)-1);$k++)
			{
				if($k != count($count) )
				$post_query .= "   or field_category Like '%".$count[$k]."%'";
				else
				$post_query .= " field_category Like '0'";
			}
			$post_query .= " ) ";
			}
			$post_query .=  " order by sort_order asc,cid asc";
		}else{
			if($is_search == '' && get_option('ptthemes_category_dislay') == 'select'){
			$post_query .=  "AND field_category = '0' order by sort_order asc,cid asc";
			}else{
			$post_query .=  " order by sort_order asc,cid asc";
			}
		}	
	}
	else
	{
		$post_query .=  " order by sort_order asc,cid asc";
	}
	$post_meta_info = $wpdb->get_results($post_query);
	$return_arr = array();
	if($post_meta_info){
		
		foreach($post_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"field_category" 	=> $post_meta_info_obj->field_category,
					"htmlvar_name" 	=> $post_meta_info_obj->htmlvar_name,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"site_title"  => $post_meta_info_obj->site_title,
					"is_require"  => $post_meta_info_obj->is_require,
					"is_active"  => $post_meta_info_obj->is_active,
					"show_on_listing"  => $post_meta_info_obj->show_on_listing,
					"show_on_detail"  => $post_meta_info_obj->show_on_detail,
					"validation_type"  => $post_meta_info_obj->validation_type,
					"style_class"  => $post_meta_info_obj->style_class,
					"extra_parameter"  => $post_meta_info_obj->extra_parameter,
					);
			if($options)
			{
				$custom_fields["options"]=$options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr;
	
}
//$custom_metaboxes = get_post_custom_fields_templ();


function get_post_custom_listing_single_page($pid, $paten_str,$fields_name='')
{	
	global $wpdb,$custom_post_meta_db_table_name;
	 $sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " and ctype!='upload' order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			if($post_meta_info_obj->ctype=='upload'){
			$image_var = "<img src='".templ_thumbimage_filter(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true),'&amp;w=100&amp;h=100&amp;zc=1&amp;q=80')."'/>";
			$replace_arr = array($post_meta_info_obj->site_title,$image_var);
			
			}
			
			$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true))
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
		}	
	}
	
	return $return_str;
}

function get_post_custom_for_listing_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_post_meta_db_table_name;
	$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_listing=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			if($post_meta_info_obj->ctype!='upload'){
			//$image_var = get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true);
			$image_var = "<img src='".templ_thumbimage_filter(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true),'&amp;w=100&amp;h=100&amp;zc=1&amp;q=80')."'/>";
			$replace_arr = array($post_meta_info_obj->site_title,$image_var);
			
			
			$replace_arr = array($post_meta_info_obj->site_title,get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true));
			if(get_post_meta($pid,$post_meta_info_obj->htmlvar_name,true) !="")
			{
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}
			}
		}	
	}
	return $return_str;
}
include_once(TT_MODULES_FOLDER_PATH.'manage_settings/manage_post_custom_fields.php');
/* Custom Post Field EOF*/

/* Custom User meta Field BOF*/
function templ_get_usermeta($types='registration') {
	$table_prefix = '';
	$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
	global $wpdb,$custom_usermeta_db_table_name;
	if($types =='registration'){
		$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and on_registration='1' order by sort_order asc,admin_title asc");
	}else{
		$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and on_profile='1' order by sort_order asc,admin_title asc");
	}
	$return_arr = array();
	if($user_meta_info){
		foreach($user_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"site_title" 	=> $post_meta_info_obj->site_title,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"is_require"  => $post_meta_info_obj->is_require,
					"on_registration"  => $post_meta_info_obj->on_registration,
					"on_profile"  => $post_meta_info_obj->on_profile,
					"extrafield1"  => $post_meta_info_obj->extrafield1,
					"extrafield2"  => $post_meta_info_obj->extrafield2,
					);
			if($options)
			{
				$custom_fields["options"]=$options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr;
}
function get_custom_usermeta_single_page($pid, $paten_str,$fields_name='')
{
	global $wpdb,$custom_usermeta_db_table_name;
	$sql = "select * from $custom_usermeta_db_table_name where is_active=1";
	 
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " and ctype!='upload' and ctype!='texteditor' order by sort_order asc,admin_title asc";
	
	$post_meta_info = $wpdb->get_results($sql);
	$return_str = '';
	$search_arr = array('{#TITLE#}','{#VALUE#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $user_meta_info_obj){
			
			if($user_meta_info_obj->site_title)
			{
				$replace_arr[] = $user_meta_info_obj->site_title;	
			}
			if($user_meta_info_obj->ctype=='upload'){
			//$image_var = get_use_rmeta($pid,$user_meta_info_obj->htmlvar_name,true);
			$image_var = "<img src='".templ_thumbimage_filter(get_user_meta($pid,$user_meta_info_obj->htmlvar_name,true),'&amp;w=100&amp;h=100&amp;zc=1&amp;q=80')."'/>";
			$replace_arr = array($user_meta_info_obj->site_title,$image_var);
			
			}
			if($user_meta_info_obj->ctype=='multicheckbox'){
					$val_category = get_user_meta($pid,$user_meta_info_obj->htmlvar_name,true);
					if(is_array($val_category)){
						$val_category_value = implode(",",$val_category);
					}else{
						$val_category_value = $val_category;
					}
				
				$replace_arr = array($user_meta_info_obj->site_title,$val_category_value);
				$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
			}else{
			
				$replace_arr = array($user_meta_info_obj->site_title,get_user_meta($pid,$user_meta_info_obj->htmlvar_name,true));
				if(get_user_meta($pid,$user_meta_info_obj->htmlvar_name,true))
				{
					
					$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
				}
			}
		}	
	}
	
	return $return_str;
}
include_once(TT_MODULES_FOLDER_PATH.'manage_settings/manage_custom_usermeta.php');
/* Custom User meta Field  EOF*/

/* Email and messages notification  BOF*/
function legend_notification(){
	$legend_display = '<h4>Legend : </h4>';
	$legend_display .= '<p style="line-height:30px;width:100%;"><label style="float:left;width:180px;">[#to_name#]</label> : '.__('Name of the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#site_name#]</label> : '.__('Site name as you provided in General Settings','templatic').'<br />
	<label style="float:left;width:180px;">[#site_login_url#]</label> : '.__('Site\'s login page URL','templatic').'<br />
	<label style="float:left;width:180px;">[#user_login#]</label> : '.__('Recipient\'s login ID','templatic').'<br />
	<label style="float:left;width:180px;">[#user_password#]</label> : '.__('Recepient\'s password','templatic').'<br />
	<label style="float:left;width:180px;">[#site_login_url_link#]</label> : '.__('Site login page link','templatic').'<br />
	<label style="float:left;width:180px;">[#post_date#]</label> : '.__('Date of post','templatic').'<br />
	<label style="float:left;width:180px;">[#information_details#]</label> : '.__('Information details of place/event.','templatic').'<br />
	<label style="float:left;width:180px;">[#transaction_details#]</label> : '.__('Transaction details of place/event.','templatic').'<br />
	<label style="float:left;width:180px;">[#frnd_subject#]</label> : '.__('Subject for the email to the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#frnd_comments#]</label> : '.__('Comment for the email to the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#your_name#]</label> : '.__('Sender\'s name','templatic').'<br />
	<label style="float:left;width:180px;">[#submited_information_link#]</label> : '.__('URL of the detail page','templatic').'<br />
	<label style="float:left;width:180px;">[#order_amt#]</label> : '.__('Payable amount','templatic').'<br />
	<label style="float:left;width:180px;">[#bank_name#]</label> : '.__('Bank name','templatic').'<br />
	<label style="float:left;width:180px;">[#account_number#]</label> : '.__('Account number','templatic').'<br />
	<label style="float:left;width:180px;">[#orderId#]</label> : '.__('Submission ID','templatic').'</p>';
	return $legend_display;
}
/* Email and messages notification  EOF*/
 function country_cmb($country_id = ''){
	global $country_table;
	$country_sql = mysql_query("select country_id,country_name from $country_table order by country_id");
	$country_display = '';
	$country_select = "";
	while($country_res = mysql_fetch_array($country_sql)){
		if($country_res['country_id'] == $country_id){
			$country_select = "selected";
		} else {
			$country_select = "";
		}
		$country_display .= '<option value="'.$country_res['country_id'].'" '.$country_select.'>'.$country_res['country_name'].'</option>';
	}
	return $country_display;
}
function zones_cmb($country_id,$zones_id = ''){
	global $zones_table,$wpdb;

	$zones_sql = $wpdb->get_results("select zones_id,zone_name from $zones_table where country_id = '".$country_id."'");
	$zones_display .= "<select name='zones_id' id='zones_id' onchange='fill_city_cmb(this.value);' >";
	foreach($zones_sql as $zones_res){
		$zoneid1 = $zones_res->zones_id;
		$zonename = $zones_res->zone_name;
		
		if($zones_res->zones_id == $zones_id){
			$zones_display .= "<option value=".$zoneid1." selected=selected>".$zonename."</option>";
		}else{
			$zones_display .= "<option value=".$zoneid1.">".$zonename."</option>";
		}
		
	}
	$zones_display .= "</select>";
	return $zones_display;
}
/*-Function to fetch city name BOF -*/
function fetch_country_name($country_id=''){
	global $wpdb;
	global $country_table;
	$country_name = $wpdb->get_var("select country_name from $country_table where country_id='".$country_id."'");
	return $country_name;
}
/*-Function to fetch city name EOF -*/

/*-Function to fetch state name BOF -*/
function fetch_state_name($zones_id=''){
	global $wpdb;
	global $zones_table;
	$country_name = $wpdb->get_var("select zone_name from $zones_table where zones_id = '".$zones_id."'");
	return $zone_name;
}
/*-Function to fetch state name EOF -*/
?>