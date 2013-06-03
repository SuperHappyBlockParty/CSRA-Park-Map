<?php
ob_start();
global $wpdb,$post,$site_url;
$current_user = wp_get_current_user(); 
$payable_amount = 0;
$cat_display = get_option('ptthemes_category_dislay');
if($cat_display ==''){
$cat_display ='checkbox';
}
$property_price_info = get_property_price_info($_SESSION['place_info']['price_select'],$_SESSION['place_info']['total_price']);
$property_price_info = $property_price_info[0];

if($property_price_info['price']>0){
$payable_amount = $property_price_info['price'];
}
$price_capable_cat = $property_price_info['cat'];
if($property_price_info['price']>0){
$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['place_info']['proprty_add_coupon']);
}
if($_REQUEST['pid']=='' && $payable_amount>0 && $_REQUEST['paymentmethod']=='')
{
	wp_redirect($site_url.'/?ptype=preview&msg=nopaymethod');
	exit;
}

if($current_user->ID=='' && $_SESSION['place_info'])
{
	include_once(TT_MODULES_FOLDER_PATH . 'place/single_page_checkout_insertuser.php');
} 

$paymentmethod = $_REQUEST['paymentmethod'];
global $wpdb;
if($_POST) {	
	if($_POST['paynow'])
	{
		$place_info = $_SESSION['place_info'];
		if($place_info){
			if($place_info['website'] && !strstr($place_info['website'],'http://'))
			{
				$place_info['website'] = 'http://'.$place_info['website'];
			}
			if($place_info['twitter'] && !strstr($place_info['twitter'],'http://'))
			{
				$place_info['twitter'] = 'http://'.$place_info['twitter'];
			}
			if($place_info['facebook'] && !strstr($place_info['facebook'],'http://'))
			{
				$place_info['facebook'] = 'http://'.$place_info['facebook'];
			}
		}
		
		if(!$place_info['post_city_id'])
		{
			$place_info['post_city_id'] = 1;	
		}
		
		if(!$place_info['geo_address']){$place_info['geo_address']=' ';}
		$custom = array("geo_address" 		=> $place_info['geo_address'],
						"geo_latitude"	=> $place_info['geo_latitude'],
						"geo_longitude"	=> $place_info['geo_longitude'],
						"map_view"		=> $place_info['map_view'],
						"add_feature"	=> $place_info['proprty_add_feature'],
						"timing"		=> $place_info['timing'],
						"contact"		=> $place_info['contact'],
						"email"			=> $place_info['email'],
						"website"		=> $place_info['website'],
						"twitter"		=> $place_info['twitter'],
						"facebook"		=> $place_info['facebook'],
						"proprty_feature"=> $place_info['proprty_feature'],	
						"post_city_id"	=> $place_info['post_city_id'],
						"zooming_factor" => $place_info['zooming_factor'],
					);
		$category = str_replace('|',',',$_SESSION['place_info']['all_cat']);
		
		$featured_type =$_SESSION['place_info']['featured_type'];
		if($property_price_info['is_featured'] != "" && $property_price_info['is_featured'] == 1 && ($featured_type == "c" || $featured_type == "h" || $featured_type == "both"))
		{
			$custom['is_featured'] =$property_price_info['is_featured'];
		}else{
			$custom['is_featured'] =0;
		}
		$post_title = $place_info['property_name'];
		if($place_info['proprty_desc'] != 'Enter description for your listing.'){
		$description = $place_info['proprty_desc'];
		}
		if($place_info['excerpt'] != 'Enter excerpt for your listing.'){
		$excerpt = $place_info['excerpt'];
		}
		
		$catids_arr = array();

		if($place_info['category'] != '')
		{
			$catids_arr = $place_info['category'];
		}else
		{
			$catids_arr[] = 1;	
		}
	
		$my_post = array();
		if($_REQUEST['pid'] && $place_info['renew']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			$custom['paid_amount'] = $payable_amount;
			$custom['alive_days'] = $property_price_info['alive_days'];
			$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
		 	if($payable_amount>0)
			{
				$post_default_status = 'draft';
				
			}else
			{ 
				$post_default_status = get_property_default_status();
			}			
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_content'] = $description;
		$my_post['post_excerpt'] = $excerpt;
		$my_post['post_type'] = CUSTOM_POST_TYPE1;
		if($place_info['category'])
		{	
			$post_category = $place_info['category'];
		}else
		{
			$post_category = array(1);	
		}
		//$my_post['post_category'] =$post_category ;
		if($price_capable_cat)
		{ 
			if($cat_display == 'checkbox'){
			//$post_category[] = $price_capable_cat;
			$post_category = $place_info['category'];
			}else{
			$post_category = $place_info['category'];
			}
		}
		/*
			save custom fields category wise for checkbox and select box.
		*/
		if($cat_display == 'checkbox'){
			$custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'0','user_side');
		}else{
			$custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,$post_category,'user_side');
		}
		
		foreach($custom_metaboxes as $key=>$val)
		{
			$name = $val['name'];
			$custom[$name] = $place_info[$name];
		}
		$my_post['post_category'] = $post_category;
		
		if($place_info['kw_tags'])
		{
			$kw_tags = substr($place_info['kw_tags'],0,TAGKW_TEXT_COUNT);
			$tagkw = explode(',',$kw_tags);	
		}
		$my_post['tags_input'] = $tagkw;
		if($tagkw)
		  {
			$tagkw = implode(',',$tagkw);
		  }	
		if($_REQUEST['pid'])
		{

			if($place_info['renew'])
			{
				$post_status = strtolower(get_option('ptthemes_listing_new_status'));
				if($post_status == ''){
				$post_status ='publish';
				}
				$my_post['post_date'] = date('Y-m-d H:i:s');
				$my_post['post_status'] = $post_status;
				$custom['paid_amount'] = $payable_amount;
				$custom['alive_days'] = $property_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_update_post($my_post);
			}else
			{
				$last_postid = wp_update_post($my_post);
			}
			
			/* update the place geo_latitude and geo_longitude in postcodes table */
			$postcode=$wpdb->prefix."postcodes";
			$sql="update $postcode set post_type='".CUSTOM_POST_TYPE1."', latitude='". $place_info['geo_latitude']."',longitude='". $place_info['geo_longitude']."' where post_id=".$last_postid;
			$wpdb->query($sql);
			/*Finish the update place geo_latitude and geo_longitude in postcodes table */
			
			$icl_table = $wpdb->prefix."icl_translations";
			$language = ICL_LANGUAGE_CODE;
			
			wp_set_post_terms($last_postid, $tagkw, $taxonomy = CUSTOM_TAG_TYPE1,true);
		}else
		{
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
			/* insert the place geo_latitude and geo_longitude in postcodes table*/
			$postcode=$wpdb->prefix."postcodes";
			$sql="insert into $postcode(post_id,post_type,latitude,longitude) values(".$last_postid.",'".CUSTOM_POST_TYPE1."','". $place_info['geo_latitude']."','". $place_info['geo_longitude']."')";
			$wpdb->query($sql);
			/* Finish the place geo_latitude and geo_longitude in postcodes table*/
			if(is_plugin_active('wpml-string-translation/plugin.php')){
				wpml_insert_templ_post($last_postid,CUSTOM_POST_TYPE1); /* insert post in language */
			}
			
		
			
		}$taxonomy='';
		$custom["paid_amount"] = $payable_amount;
		
		foreach($custom as $key=>$val)
		{		
			update_post_meta($last_postid, $key, $val);
		}
		/*if going to edit then don't upgrade information*/
		if(!$_REQUEST['pid']){
		update_post_meta($last_postid, 'remote_ip',getenv('REMOTE_ADDR'));
		update_post_meta($last_postid,'ip_status',$_SESSION['place_info']['ip_status']);
		update_post_meta($last_postid,'pkg_id',$_SESSION['place_info']['price_select']);
		if($_SESSION['place_info']['featured_type'] == 'c' && $_SESSION['place_info']['featured_type'] != 'both'){
		$_SESSION['place_info']['home_featured_type'] = "icat";
		update_post_meta($last_postid,'home_featured_type',$_SESSION['place_info']['home_featured_type']);
		}else{
		update_post_meta($last_postid,'home_featured_type',$_SESSION['place_info']['featured_type']);
		}
		$_SESSION['place_info']['featured_type'];
		update_post_meta($last_postid,'featured_type',$_SESSION['place_info']['featured_type']);
		update_post_meta($last_postid,'total_amount',$_SESSION['place_info']['price_select']);
		}
		if($paymentmethod !="" && $last_postid !=""){
		$post_author  = $wpdb->get_row("select * from $wpdb->posts where ID = '".$last_postid."'") ;
		$post_author  = $post_author->post_author ;
		$uinfo = get_userdata($post_author);
		$user_fname = $uinfo->display_name;
		$user_email = $uinfo->user_email;
		$user_billing_name = $uinfo->display_name;
		$billing_Address = '';
		global $transection_db_table_name;
		$transaction_insert = 'INSERT INTO '.$transection_db_table_name.' set 
		post_id="'.$last_postid.'",
		user_id = "'.$post_author.'",
		post_title ="'.$post_title.'",
		payment_method="'.$paymentmethod.'",
		payable_amt='.$payable_amount.',
		payment_date="'.date("Y-m-d H:i:s").'",
		paypal_transection_id="",
		status="0",
		user_name="'.$user_fname.'",
		pay_email="'.$user_email.'",
		billing_name="'.$user_billing_name.'",
		billing_add="'.$billing_Address.'"';
		}
		$wpdb->query($transaction_insert);
		$trans_id = mysql_insert_id();
		global $trans_id;
		$termtable = $wpdb->prefix."term_relationships";
		$del_cat="";
		if(is_array($post_category) && $post_category!=""){
			$del_cat_id = implode($post_category,",");
			$del_cat=$wpdb->query("delete from $termtable where object_id = '".$last_postid."' and term_taxonomy_id NOT IN ( $del_cat_id )");
		}else{
			if($post_category!=""){
				$del_cat = $wpdb->query("delete from $termtable where object_id = '".$last_postid."' and term_taxonomy_id!=$post_category");
			}
		}
		if(is_array($post_category) && $post_category!="")
		{
			foreach($post_category as $_post_category)
			{
				wp_set_post_terms( $last_postid,$_post_category,'placecategory',true);
			}
		}
		else
		{
			wp_set_post_terms( $last_postid,$post_category,'placecategory',true);
		} 
		/* insert tags start */
		$tagkw = explode(',',$place_info['kw_tags']);
		
			//wp_set_post_terms($last_postid, $tagkw, $taxonomy = CUSTOM_TAG_TYPE1,true);

			if(is_array($tagkw) && $tagkw!="")
			{
				foreach($tagkw as $_tagkw)
				{ echo $_tagkw;
					wp_set_post_terms( $last_postid,$_tagkw,$taxonomy = CUSTOM_TAG_TYPE1,true);
				}
			}else{
					wp_set_post_terms($last_postid, $tagkw, $taxonomy = CUSTOM_TAG_TYPE1,true);
			}
		/* insert tags end */
	
		if($_SESSION["file_info"])
		{
			$menu_order = 0;
			for($im=0;$im<count($_SESSION["file_info"]);$im++)
			{
				//echo $_SESSION["file_info"][$im];	
			}
			
			foreach($_SESSION["file_info"] as $image_id=>$val)
			{
				//$src = get_image_tmp_phy_path().$val;
				
				$src = get_template_directory()."/images/tmp/".$val;
				if($val)
				  {
					if(file_exists($src))
					{
						$menu_order++;
						$dest_path = get_image_phy_destination_path().$val;
						$original_size = get_image_size($src);
						$thumb_info = image_resize_custom($src,$dest_path,get_option('thumbnail_size_w'),get_option('thumbnail_size_h'));
						$medium_info = image_resize_custom($src,$dest_path,get_option('medium_size_w'),get_option('medium_size_h'));
						$post_img = move_original_image_file($src,$dest_path);
	
						$post_img['post_status'] = 'inherit';
						$post_img['post_parent'] = $last_postid;
						$post_img['post_type'] = 'attachment';
						$post_img['post_mime_type'] = 'image/jpeg';
						$post_img['menu_order'] = $menu_order;
						
						$last_postimage_id = wp_insert_post( $post_img ); // Insert the post into the database
			
						$thumb_info_arr = array();
						if($thumb_info)
						{
							$sizes_info_array = array();
							if($thumb_info)
							{
							$sizes_info_array['thumbnail'] =  array(
																	"file" =>	$thumb_info['file'],
																	"height" =>	$thumb_info['height'],
																	"width" =>	$thumb_info['width'],
																	);
							}
							if($medium_info)
							{
							$sizes_info_array['medium'] =  array(
																	"file" =>	$medium_info['file'],
																	"height" =>	$medium_info['height'],
																	"width" =>	$medium_info['width'],
																	);
							}
							$hwstring_small = "height='".$thumb_info['height']."' width='".$thumb_info['width']."'";
						}else
						{
							$hwstring_small = "height='".$original_size['height']."' width='".$original_size['width']."'";
						}
						
	
						//update_post_meta($last_postimage_id, '_wp_attached_file', get_attached_file_meta_path($post_img['guid']));
						update_post_meta($last_postimage_id, '_wp_attached_file', get_image_new_destination_path().$val);
						$post_attach_arr = array(
											"width"	=>	$original_size['width'],
											"height" =>	$original_size['height'],
											"hwstring_small"=> $hwstring_small,
											"file"	=> get_attached_file_meta_path($post_img['guid']),
											"sizes"=> $sizes_info_array,
											);
	
						wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
					 }
			     }
			}
		}

	  /* Code for update menu for images */
	  
	  if($_REQUEST['pid'])
		  {
			$j = 1;
			foreach($_SESSION["file_info"] as $arrVal)
			 {
				$expName = array_slice(explode(".",$arrVal),0,1);
				$wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where post_name = "'.$expName[0].'"  and post_parent = "'.$_REQUEST['pid'].'"');
				$j++;	
			 }
		  }

	/* End Code for update menu for images */


		if($_REQUEST['pid'] && $place_info['renew']=='')
		{
			wp_redirect(get_author_posts_url($current_user->ID));
			exit;
		}else
		{
			///////ADMIN EMAIL START//////
			$fromEmail = get_site_emailId();
			$fromEmailName = get_site_emailName();
			$store_name = get_option('blogname');
			$email_content = get_option('post_submited_success_email_content');
			$email_subject = get_option('post_submited_success_email_subject');
			
			$email_content_user = get_option('post_submited_success_email_user_content');
			$email_subject_user = get_option('post_submited_success_email_user_subject');
			
			if(!$email_subject)
			{
				$email_subject = __('New place listing of ID:#'.$last_postid);	
			}
			if(!$email_content)
			{
				$email_content = __('<p>Dear [#to_name#],</p>
				<p>A New listing has been submitted on your site. Here is the information about the listing:</p>
				[#information_details#]
				<br>
				<p>[#site_name#]</p>');
			}
			
			if(!$email_subject_user)
			{
				$email_subject_user = __(sprintf('New place listing of ID:#%s',$last_postid));	
			}
			if(!$email_content_user)
			{
				$email_content_user = __('<p>Dear [#to_name#],</p><p>A New place has been submitted by you . Here is the information about the Place:</p>[#information_details#]<br><p>[#site_name#]</p>','templatic');
			}
			
			$information_details = "<p>".__('ID')." : ".$last_postid."</p>";
			$information_details .= '<p>'.__('View more detail from').' <a href="'.get_permalink($last_postid).'">'.$my_post['post_title'].'</a></p>';
			
			$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
			$replace_array_admin = array($fromEmail,$information_details,$store_name);
			$replace_array_client =  array($user_email,$information_details,$store_name);
			$email_content_admin = str_replace($search_array,$replace_array_admin,$email_content);
			$email_content_client = str_replace($search_array,$replace_array_client,$email_content_user);
			
			$email_content_admin = stripslashes($email_content_admin);
			$email_content_client = stripslashes($email_content_client);
			
			templ_sendEmail($user_email,$user_fname,$fromEmail,$fromEmailName,$email_subject,$email_content_admin,$extra='');///To admin email
			templ_sendEmail($fromEmail,$fromEmailName,$user_email,$user_fname,$email_subject_user,$email_content_client,$extra='');//to client email
			//////ADMIN EMAIL END////////
			if($payable_amount <= 0)
			{
				$suburl .= "&pid=$last_postid";
				if($place_info['renew'])
				{
					$suburl .= "&renew=1";
				}

				wp_redirect($site_url."/?ptype=success$suburl");
				exit;
			}else	{
				$paymentmethod = $_REQUEST['paymentmethod'];
				$package_id = $property_price_info['pid'];
				$is_recurring = $property_price_info['is_recurring'];
				$billing_num = $property_price_info['billing_num'];
				$billing_per = $property_price_info['billing_per'];
				$billing_cycle = $property_price_info['billing_cycle'];
				$paymentSuccessFlag = 0;
				if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
				{
					if($place_info['renew'])
					{
						$suburl = "&renew=1";
					}
					$suburl .= "&pid=$last_postid&trans_id=$trans_id";
					wp_redirect($site_url.'/?ptype=success&paydeltype='.$paymentmethod.$suburl);
				}
				else
				{ 
					if(file_exists( get_template_directory().'/library/includes/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
					{ 
						include_once(get_template_directory().'/library/includes/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
					}
				}
				exit;	
			}
		}
	}	
}
?>