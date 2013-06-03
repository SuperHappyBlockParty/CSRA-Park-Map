<?php 
/* fetch categories options */
function display_wpcategories_options($taxonomy,$cid)
{ 
		if($taxonomy == "")
		{
			$taxonomy ="category";
		}
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL;
		if($taxonomy == '1')
		{
			$wpcategories = (array)$wpdb->get_results("SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
			WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id AND ({$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE1."' OR {$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE2."') ORDER BY {$table_prefix}terms.name");
		}else{
			$wpcategories = (array)$wpdb->get_results("SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
			WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' ORDER BY {$table_prefix}terms.name");
		}
		$wpcategories = array_values($wpcategories);
		$wpcat2 = NULL;

		 	foreach ($wpcategories as $wpcat)
    		{ 	if($wpcat->parent =='0' ) {?>
				<option value="<?php echo $wpcat->term_id; ?>" <?php if($wpcat->term_id == $cid) { echo 'selected="selected"'; } ?>><?php echo apply_filters('single_cat_title', stripslashes(str_replace('"', '', ucfirst($wpcat->name)." "))); ?></option>
			<?php }else{ ?>
				<option value="<?php echo $wpcat->term_id; ?>" <?php if($wpcat->term_id == $cid) { echo 'selected="selected"'; } ?>><?php echo apply_filters('single_cat_title', stripslashes(str_replace('"', '', " - ".ucfirst($wpcat->name)." "))); ?></option>
			<?php }
			}
}
/* end of function */

/* function to display dropdown of taxonomies term */
function get_wp_post_categores($taxonomy)
{ 
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' AND {$table_prefix}term_taxonomy.parent = 0 ORDER BY {$table_prefix}terms.name");
		
		$wpcategories = array_values($wpcategories);

			echo "<select name='post_category'  class='textfield sctof' id='post_category' echo='0'>";
			echo "<option value='0' selected='selected'>Select category</option>";
		 	foreach ($wpcategories as $wpcat)
    		{
					echo "<option value='".$wpcat->term_id."'>".apply_filters('single_cat_title', stripslashes(str_replace('"', '', ucfirst($wpcat->name)." ")))."</option>";
					 $wpsubcategories = (array)$wpdb->get_results("
					SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
					WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
							AND {$table_prefix}term_taxonomy.taxonomy = '".$taxonomy."' AND {$table_prefix}term_taxonomy.parent = '".$wpcat->term_id."'");
					if(mysql_affected_rows() >0)
					{
						foreach ($wpsubcategories as $wpscat)
						{
							echo "<option value='".$wpscat->term_id."'>".apply_filters('single_cat_title', "-".stripslashes(str_replace('"', '', ucfirst($wpscat->name)." ")))."</option>";
						}
					}
			}
			echo "</select>"; 
}
/* end of function  */

/* Function to fetch category name BOF */
function get_categoty_name($cat_id)
{
	global $wpdb;
	$cat_name ="";
	$table_prefix = $wpdb->prefix;
	$wpcat_id = NULL; 
	$pos = explode(',',$cat_id);
	$cat_id1 = implode('&',$pos);
	$pos_of = strpos($cat_id1,'&');
	if($pos_of == false){
		$wpcategories = $wpdb->get_row("SELECT * FROM {$table_prefix}terms WHERE {$table_prefix}terms.term_id = '".$cat_id."'");
		_e($wpcategories->name,'templatic');
	}else{
		$cid = explode('&',$cat_id1);
		$total_cid = count($cid);
		for($c=0;$c<=$total_cid;$c++){
			$wpcategories = $wpdb->get_row("SELECT * FROM {$table_prefix}terms WHERE {$table_prefix}terms.term_id = '".$cid[$c]."'");
			if($wpcategories->name !=""){
			$cat_name .= $wpcategories->name.", "; }
		}
			echo $cat_name;
	}
	
	   
}
/* Function to fetch category name EOF */
function get_post_custom_fields_templatic($cat_id)
{ 
	global $wpdb,$custom_post_meta_db_table_name;

	$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where is_active=1 and post_type = '".CUSTOM_POST_TYPE1."' and field_category = '".$cat_id."' order by sort_order asc,cid asc");
	$return_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
			$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values"  => $post_meta_info_obj->option_values,
					"site_title"     => $post_meta_info_obj->site_title,
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


function get_property_default_status()
{
	if(get_option('ptthemes_listing_new_status'))
	{
		return strtolower(get_option('ptthemes_listing_new_status'));
	}else
	{
		return 'publish';
	}
} 
function get_payment_optins($method)
{
	global $wpdb;
	$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
	$paymentinfo = $wpdb->get_results($paymentsql);
	if($paymentinfo)
	{
		foreach($paymentinfo as $paymentinfoObj)
		{
			$option_value = unserialize($paymentinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
			$optReturnarr = array();
			for($i=0;$i<count($paymentOpts);$i++)
			{
				$optReturnarr[$paymentOpts[$i]['fieldname']] = $paymentOpts[$i]['value'];
			}
			return $optReturnarr;
		}
	}
}
function is_user_can_add_event(){
	global $current_user;
	//$current_user->ID
	return 1;	
} function is_allow_user_register()
{
	if(get_option('is_allow_user_add')!='')
	{
		return get_option('is_allow_user_add');
	}else
	{
		return 1;
	}
}
function get_ssl_normal_url($url,$pid='')
{
	if($pid)
	{
		return $url;
	}else
	{
		if(get_option('is_allow_ssl')=='0')
		{
		}else
		{
			$url = str_replace('http://','https://',$url);
		}
	}
	return $url;
}
function get_property_price_info($pro_type='',$price='')
{ 
	global $price_db_table_name,$wpdb;
	$subsql = '';
	if($pro_type !="")
	{
		$subsql = " and pid=\"$pro_type\"";	
	}
	$pricesql = "select * from $price_db_table_name where status=1 $subsql";
	$priceinfo = $wpdb->get_results($pricesql);
	$price_info = array(); 
	if($priceinfo !="")
	{
		foreach($priceinfo as $priceinfoObj)
		{	
		$info = array();
		$vper = $priceinfoObj->validity_per;
		$validity = $priceinfoObj->validity;
		if(($priceinfoObj->validity != "" || $priceinfoObj->validity != 0))
		{
			if($vper == 'M')
			{
				$tvalidity = $validity*30 ;
			}else if($vper == 'Y'){
				$tvalidity = $validity*365 ;
			}else{
				$tvalidity = $validity ;
			}
		}
		$info['title'] = $priceinfoObj->price_title;
		$info['price'] = $price;
		$info['days'] = $tvalidity;
		$info['alive_days'] =$tvalidity;
		$info['cat'] =$priceinfoObj->price_post_cat;
		$info['is_featured'] = $priceinfoObj->is_featured;
		
		$info['title_desc'] =@$priceinfoObj->title_desc;
		$info['is_recurring'] =$priceinfoObj->is_recurring;
		if($priceinfoObj->is_recurring == '1') {
			$info['billing_num'] =$priceinfoObj->billing_num;
			$info['billing_per'] =$priceinfoObj->billing_per;
			$info['billing_cycle'] =$priceinfoObj->billing_cycle;
		}
		$price_info[] = $info;
		}
	}
	return $price_info;

}

function get_price_info($title='',$catid = '',$ptype)
{	
	global $price_db_table_name,$wpdb;

	$catarray = explode(',',$catid);
	$cat_display=get_option('ptthemes_category_dislay');
	$catid1 = ",".$catid.",";
	$catid2 = $catid.",";
	$catid3 = ",".$catid;
	if($catid != ""){ 
		if($cat_display == 'select'){ 
			//$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and ((price_post_cat LIKE '%".$catid1."%' or price_post_cat LIKE '%".$catid2."%' or price_post_cat LIKE '%".$catid3."%' or price_post_cat = '".$catid."') or is_show=1) and status=1  "; 
			$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both')";
			
				if($catid != '0' ){
					if(!strstr($catid,',')){
					$pricesql .= " and ((price_post_cat LIKE '%,".$catid.",%' or price_post_cat LIKE '%,".$catid."' or price_post_cat LIKE '%".$catid.",%' or price_post_cat = '".$catid."' or price_post_cat = '0') or is_show=1)";
					}else{
					$pricesql .= " and (( price_post_cat Like '0' ";
					$count = explode(",",$catid);
					for($k=0;$k<(count($count)-1);$k++)
					{
						if($k != count($count) )
						$pricesql .= "   or price_post_cat Like '%".$count[$k]."%' or price_post_cat Like '%all%'";
						else
						$pricesql .= " price_post_cat Like '0'";
					}
					$pricesql .= " )or is_show=1) ";
					}
					$pricesql .= "and status=1";
			} 
		}else{
			$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and (price_post_cat RLIKE '".$catid.'f5'."' or price_post_cat Like '%all%' or is_show=1) and status=1  ";
		}
	} else {
		
		$pricesql = "select * from $price_db_table_name where (price_post_type='".$ptype."' or price_post_type='both') and status=1 and is_show=1" ;
	}

	$priceinfo = $wpdb->get_results($pricesql);
	if($priceinfo)
	{
		$counter=1;
		foreach($priceinfo as $priceinfoObj)
		{	
			$pricecat= stristr($priceinfoObj->price_post_cat,$catid1);
		?>
         <div class="package">
		 <label><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>" onClick="show_featuredprice(this.value);"/>
		 <h3><?php _e($priceinfoObj->price_title,'templatic');?></h3>
		 <p><?php _e($priceinfoObj->price_desc,'templatic');?></p>
		 <p class="cost"><span><?php _e('Cost :','templatic'); ?> <?php _e(display_amount_with_currency($priceinfoObj->package_cost),'templatic'); ?></span> <span><?php _e('Validity :','templatic'); ?> <?php _e($priceinfoObj->validity,'templatic'); if($priceinfoObj->validity_per == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->validity_per == 'M'){ _e(' Months','templatic'); }else{   _e(' Years','templatic'); }?><?php if($priceinfoObj->billing_cycle != "" && $priceinfoObj->is_recurring) { ?></span>  <span><?php _e('Billing cycle :','templatic'); ?> <?php _e($priceinfoObj->billing_cycle,'templatic'); if($priceinfoObj->billing_per == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->billing_per == 'M'){ _e('Months','templatic'); }else{   _e('Years','templatic'); } } ?></span></p> </label>
		 </div>
        <?php $counter++;
		}
	}
}

function display_custom_post_field($custom_metaboxes,$session_variable,$geo_latitude='',$geo_longitude='',$geo_address=''){
	global $wpdb; 
	foreach($custom_metaboxes as $key=>$val) {
		//string translate of wpml activale
		$context = get_option('blogname');
		if(function_exists('icl_register_string')){			
			
			$site_title = $val['site_title'];
			icl_t($context,'site_title',$site_title);
			$site_title = icl_t($context,$site_title,$site_title);
			$admin_desc = $val['desc'];
			icl_t($context,'admin_desc',$admin_desc);
			$admin_desc = icl_t($context,$admin_desc,$admin_desc);
		}else{
			$site_title = $val['site_title'];
			$admin_desc = $val['desc'];
		}	
		$name = $val['name'];		
		$type = $val['type'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		/* Is required CHECK BOF */
		$is_required = '';
		$input_type = '';
		if($val['is_require'] == '1'){
			$is_required = '<span>*</span>';
			$is_required_msg = '<span id="'.$name.'_error" class="message_error2"></span>';
		} else {
			$is_required = '';
			$is_required_msg = '';
		}
		$value = '';
		/* Is required CHECK EOF */
		if(@$_REQUEST['pid'])
		{ 
			$post_info = get_post($_REQUEST['pid']);
			if($name == 'property_name') {
				$value = $post_info->post_title;
			} else if($name == 'proprty_desc' || $name == 'event_desc') {
				$value = $post_info->post_content;
			} else if($name == 'excerpt') {
				$value = $post_info->post_excerpt;
			}else if($name == 'kw_tags'){
				if($session_variable =='event_info'){
					$ktag = 'eventtags';
				}else{
					$ktag = 'placetags';
				}
				
				$value1 = get_the_terms($post_info->ID,$ktag);
				for($v=0; $v < count($value1); $v++){
					if($value1[$v]->name)
					$value .= $value1[$v]->name.",";
				}
			}else {
				$value = get_post_meta($_REQUEST['pid'], $name,true);
			}
			
		}else{
			$value = $default_value;
		}
		if($_SESSION[$session_variable] && $_REQUEST['backandedit'])
		{
			$value = $_SESSION[$session_variable][$name];
		}
	?>
	<div class="form_row clearfix">
	   <?php if($type=='text'){?>
	   <label><?php _e($site_title,'templatic'); echo $is_required; ?></label>
	   <?php if($name == 'geo_latitude' || $name == 'geo_longitude') {
			$extra_script = 'onblur="changeMap();"';
			
		} else {
			$extra_script = '';
			
		}?>
	 <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo stripslashes($value);?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> <?php echo $extra_script;?> PLACEHOLDER="<?php echo  $val['default']; ?>"/>
	 
	   <?php 
		}elseif($type=='geo_map'){
		?>     
		 <label><?php _e($site_title,'templatic'); echo $is_required; ?></label>      
		<input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php if($value){ echo $value; } ?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo 	$extra_parameter;?> />
		
		<?php
		}elseif($type=='checkbox'){
		?>     
		 <label>&nbsp;</label>      
		<input name="<?php echo $name;?>" id="<?php echo $name;?>" <?php if($value){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" <?php echo 	$extra_parameter;?> /> <?php _e($site_title,'templatic');?>
		<?php
		}elseif($type=='radio'){
		?>     
		 <label class="r_lbl"><?php _e($site_title,'templatic'); echo $is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					if (trim($value) == trim($option_values_arr[$i])){ $seled='checked="checked"';}	
					if(function_exists('icl_t')){
						$context = get_option('blogname');;
						$dis_name = icl_t($context,$option_values_arr[$i],$option_values_arr[$i]);
					}else{
						$dis_name = $option_values_arr[$i];
					}
					echo '
					<div class="form_cat">
						<label class="r_lbl">
							<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$dis_name.'
						</label>
					</div>';							
				}
				
			}
	   
		}elseif($type=='date'){
		?>     
		<label><?php  _e($site_title,'templatic'); echo $is_required; ?></label>
		<input type="text" name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes($value)); ?>" size="25" <?php echo 	$extra_parameter;?> />
		&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.propertyform.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" />
		<?php
		}
		elseif($type=='multicheckbox')
		{ ?>
		 <label><?php _e($site_title,'templatic'); echo $is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if(!isset($_REQUEST['pid']) && !$_REQUEST['backandedit'])
			{
				$default_value = explode(",",$val['default']);
			}
			if($options)
			{  $chkcounter = 0;
				echo '<div class="form_cat_right">';
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if(isset($_REQUEST['pid']) || $_REQUEST['backandedit'])
					  {
						$default_value = $value;
					  }

					if($default_value !=''){
					if(in_array($option_values_arr[$i],$default_value)){ 
					$seled='checked="checked"';} }	
										
					echo '
					<div class="form_cat">
						<label>
							<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				echo '</div>';
			}
		}
		
		elseif($type=='texteditor'){	
		if (preg_match("/Android/", $agent) =='') { $mce = "mce"; }else{ $mce = 'textarea';}
		?>
		<label><?php  _e($site_title,'templatic'); echo $is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>"  class="<?php echo $mce;?>" <?php echo $extra_parameter;?> ><?php if($value != '') { echo stripslashes($value); }else{ echo  stripslashes($val['default']); } ?></textarea>       
		<?php
		}elseif($type=='textarea'){ 
		if(isset($_REQUEST['pid']) || @$_REQUEST['backandedit'] )
		  {
			$default_value = $value;
		  }
		?>
		<label><?php _e($site_title,'templatic'); echo $is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" class="<?php if($style_class != '') { echo $style_class;}?> textarea" <?php echo $extra_parameter;?>><?php echo stripslashes($default_value);?></textarea>       
		<?php
		}elseif($type=='select'){
		?>
		    <label style="padding-top:10px;"><?php _e($site_title,'templatic'); echo $is_required; ?></label>
            <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
            <option value="">Please Select</option>
            <?php if($option_values){
            $option_values_arr = explode(',',$option_values);
            for($i=0;$i<count($option_values_arr);$i++)
            {
            ?>
            <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
            <?php	
            }
            ?>
            <?php }?>
           
            </select>

		<?php
		}else if($type=='upload'){?>
		 <label><?php  _e($site_title,'templatic'); echo $is_required; ?></label>
		<input type="file" value="<?php echo $value; ?>" name="<?php echo $name; ?>"/>
		
		<?php }
		if($type != 'image_uploader') {?>
		 <span class="message_note"><?php echo $admin_desc;?></span><?php echo $is_required_msg;?>
		 <?php } ?>
	  </div>
	  <?php if($type=='geo_map') { ?>
	  <div class="form_row clearfix"> 
	 <?php include_once(get_template_directory() . "/library/map/location_add_map.php");?>
	 <span class="message_note"><?php echo GET_MAP_MSG;?></span></div> <?php } ?>
	<?php
		if($type=='image_uploader') { ?>
	 <h5 class="form_title"> <?php _e(PRO_PHOTO_TEXT,'templatic'); ?></h5>
	 <div class="form_row clearfix">
		<label><?php  _e($site_title,'templatic'); echo $is_required; ?></label>
		<?php include (TT_MODULES_FOLDER_PATH."general/image_uploader.php"); ?>
		 <span class="message_note"><?php echo $admin_desc;?></span><?php echo $is_required_msg;?>
	 </div>
	<?php } 
	}
}
function search_custom_post_field($custom_metaboxes){
		foreach($custom_metaboxes as $key=>$val) {
		$name = $val['name'];
		$site_title = $val['site_title'];
		$type = $val['type'];
		$admin_desc = $val['desc'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		if($_POST[$name]){
			$value = $_POST[$name];
		} ?>
	<p>
	   <?php if($type=='text'){?>
	   <label><?php echo $site_title.$is_required; ?></label>
		<input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> />
	 
	   <?php 
		}elseif($type=='geo_map'){
		?>     
		 <label><?php echo $site_title.$is_required; ?></label>      
		<input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> />
		
		<?php
		}elseif($type=='checkbox'){
		?>     
		 <label>&nbsp;</label>      
		<input name="<?php echo $name;?>" id="<?php echo $name;?>" <?php if($value){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" <?php echo 	$extra_parameter;?> /> <?php echo $site_title; ?>
		<?php
		}elseif($type=='radio'){
		?>     
		 <label class="r_lbl"><?php echo $site_title.$is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					if (trim($value) == trim($option_values_arr[$i])){ $seled='checked="checked"';}	
					echo '
					<div class="form_cat">
						<label>
							<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			}
	   
		}elseif($type=='date'){
		?>     
		<label><?php echo $site_title.$is_required; ?></label>
		<input type="text" name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes($value)); ?>" size="25" <?php echo 	$extra_parameter;?> />
		&nbsp;<img src="<?php echo get_bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.searchform.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" />
		<?php
		}
		elseif($type=='multicheckbox')	{ ?>
		 <label><?php echo $site_title.$is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					$default_value = $value;
								if($default_value !=''){
					if(in_array($option_values_arr[$i],$default_value)){ 
					$seled='checked="checked"';}	}
							
					echo '
					<div class="form_cat">
						<label>
							<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			}
		}
		elseif($type=='textarea' || $type=='texteditor'){ ?>
		<label><?php echo $site_title.$is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" class="<?php if($style_class != '') { echo $style_class;}?> textfield" <?php echo $extra_parameter;?>><?php echo $value;?></textarea>       
		<?php
		}elseif($type=='select'){
	   
		?>
		 <label><?php echo $site_title.$is_required; ?></label>
		<select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
		<?php if($option_values){
		
		$option_values_arr = explode(',',$option_values);
		
		for($i=0;$i<count($option_values_arr);$i++)
		{
		?>
		<option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
		<?php	
		}
		?>
		<?php }?>
	   
		</select>
		
		<?php
		}
		 ?>
	  </p>
	
	<?php
	
	}
}
?>