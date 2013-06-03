<?php 
if (!class_exists('General')) {
	class General {
		// Class initialization
		function General() {
		}
		
		function get_payment_method($method)
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			if($paymentinfo)
			{
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					return __('Pay with '.$paymentInfo['name']);
				}
			}
		}
		
		function get_product_imagepath()
		{
			return get_option('imagepath');
		}
		
		function get_product_tax()
		{
			return $this->get_product_tax_cal();
		}
		
		function getLoginUserInfo()
		{
			$logininfoarr = explode('|',$_COOKIE[LOGGED_IN_COOKIE]);
			if($logininfoarr)
			{
				global $wpdb;
				$userInfoArray = array();
				$usersql = "select * from $wpdb->users where user_login = '".$logininfoarr[0]."'";
				$userinfo = $wpdb->get_results($usersql);
				foreach($userinfo as $userinfoObj)
				{
					$userInfoArray['ID'] = 	$userinfoObj->ID;
					$userInfoArray['display_name'] = 	$userinfoObj->display_name;
					$userInfoArray['user_nicename'] = 	$userinfoObj->user_login;
					$userInfoArray['user_email'] = 	$userinfoObj->user_email;
					$userInfoArray['user_id'] = 	$logininfoarr[0];
				}
				return $userInfoArray;
			}else
			{
				return false;
			}
		}
		
		
		function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
		{
			if($fromEmail && $toEmail)
			{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
				$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
				
				if(wp_mail( $toEmail, $subject, $message, $headers ))
				{
					
				}else
				{
					mail( $toEmail, $subject, $message, $headers );
				}
			}
		}
		
		
		function get_post_array($postid,$prdcount=5)
		{
			$prdcount++;
			$related_prd = 1;
			$postCatArr = wp_get_post_categories($postid);
			$postCatArr = implode(',',$postCatArr);
			$post_array = array();
			if($postCatArr)
			{
				$postCatStr = $postCatArr;
			}
			$category_posts=get_posts("numberposts=$prdcount&category=".$postCatStr);
			foreach($category_posts as $post) 
			{
				if($post->ID !=  $postid)
				{
					$post_array[$post->ID] = $post;
					$related_prd++;
				}
				if($related_prd==$prdcount)
				break;
			}
			return $post_array;
		}
		
		function get_digital_productpath()
		{
			return get_option('digitalproductpath');
		}
		
		function is_show_term_conditions()
		{
			return get_option('is_show_termcondition');
		}
		function get_term_conditions_statement()
		{
			return get_option('termcondition');
		}
		function get_loginpage_top_statement()
		{
			global $General;
			if(get_option('loginpagecontent'))
			{
				$topcontent = get_option('loginpagecontent');
				$store_name = get_option('blogname');
				$search_array = array('[#$store_name#]');
				$replace_array = array($store_name);
				$instruction = str_replace($search_array,$replace_array,$topcontent);
				?>
				<p class="login_instruction"><?php 	echo $instruction;	?> </p>
				<?php
			}else
			{
				_e(LOGIN_PAGE_TOP_MSG);
			}
		}
		
		function get_userinfo_mandatory_fields()
		{
			$return_array = array();
			if(!$this->is_storetype_digital())
			{
			$return_array['last_name'] = get_option('last_name');
			$return_array['bill_address1'] = get_option('bill_address1');
			$return_array['bill_address2'] = get_option('bill_address2');
			$return_array['bill_city'] = get_option('bill_city');
			$return_array['bill_state'] = get_option('bill_state');
			$return_array['bill_country'] = get_option('bill_country');
			$return_array['bill_zip'] = get_option('bill_zip');
			$return_array['bill_phone'] = get_option('bill_phone');
			}
			return $return_array;
		}
		
		function get_attribute_str($attribute_array)
		{
			for($i=0;$i<count($attribute_array);$i++)
			{
				if($attribute_array[$i])
				{
					$attribute_array[$i] = trim(preg_replace('/[(]([+-]+)(.*)[)]/','',$attribute_array[$i]));
				}
			}
			if($attribute_array && is_array($attribute_array))
			{
				return $att_str = ','.implode(',',$attribute_array).',';	
			}else
			{
				return $att_str = '';
			}
			
		}
		function all_product_listing_format()
		{
			 if(get_option('ptthemes_prd_listing_format')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		function home_product_listing_format()
		{
			 if(get_option('ptthemes_prd_listing_format_home')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		function archive_listing_format()
		{
			  if(get_option('ptthemes_prd_listing_format_cat')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		
		function is_allow_user_reglogin()
		{
			if(get_option('is_user_reg_allow'))
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_send_forgot_pw_email()
		{
			if(get_option('send_email_forgotpw') || get_option('send_email_forgotpw')=='')
			{
				return true;
			}else
			{
				return false;
			}
		}
		
		
		function get_blog_sub_cats_str($type='array')
		{
			$catid = get_inc_categories("cat_exclude_");
			$catid_arr = explode(',',$catid);
			$blogcatids = '';
			$subcatids_arr = array();
			for($i=0;$i<count($catid_arr);$i++)
			{
				if($catid_arr[$i])
				{
					$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
				}
			}
			if($subcatids_arr && $type=='string')
			{
				$blogcatids = implode(',',$subcatids_arr);
				return $blogcatids;	
			}else
			{
				return $subcatids_arr;
			}			
		}
		
		function show_blog_link_header_nav()
		{
			global $General;
			$blogcatids = $General->get_blog_sub_cats_str('string');
			if($blogcatids && $General->is_show_blogpage())
			{
				if(get_option('ptthemes_show_empty_category') == 'No'){ 
					$hide_empty = '&hide_empty=1';
				} else {
					$hide_empty = '&hide_empty=0';
				}
				$categoyli = wp_list_categories ('title_li=&use_desc_for_title=0&depth=0&include=' . $blogcatids.$hide_empty.'&sort_column=menu_order&echo=0'); 
				if(!strstr($categoyli,'No categories'))
				{
					echo $categoyli;	
				}
			}
			
		}
		function show_category_header_nav()
		{
			if(get_option('ptthemes_catheader_display')=='Show')
			{
				$categories = get_option('ptthemes_categories_id');
				if(is_array($categories))
				{
					$categories = implode(',',$categories);
				}
				if(get_option('ptthemes_show_empty_category') == 'No'){ 
					$hide_empty = '1';
				} else {
					$hide_empty = '0';
				}
								
				$categoyli = wp_list_categories ('title_li=&use_desc_for_title=0&depth=0&include=' . $categories. '&hide_empty='.$hide_empty.'&sort_column=menu_order&echo=0'); 
				if(!strstr($categoyli,'No categories'))
				{
					echo $categoyli;	
				}
			}
			
		}
		
		function is_on_ssl_url()
		{
			if(get_option('is_on_ssl'))
			{
				return true;
			}else
			{
				return false;
			}
		}
		function allow_autologin_after_reg()
		{
			if(get_option('allow_autologin_after_reg') || get_option('allow_autologin_after_reg')=='')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function get_ssl_normal_url($url)
		{
			if($this->is_on_ssl_url())
			{
				$url = str_replace('http://','https://',$url);
			}
			return $url;
		}
		function get_url_login($url)
		{
			if(get_option('is_on_ssl_login'))
			{
				return $url = str_replace('http://','https://',$url);
			}else
			{
				return $url;
			}
			return $url;
		}
		
		function view_store_link_home()
		{
		?>
        <a href="<?php echo home_url("/?ptype=store");?>" class="highlight_button fr" ><?php _e(VIEW_STORE_TEXT);?></a>
        <?php	
		}
		
		function show_term_and_condition()
		{
			global $General;
			if($General->is_show_term_conditions())
			{
			?>
			<div class="terms_condition clearfix">
			<input type="checkbox" name="termsandconditions" id="termsandconditions" class="checkin2" />&nbsp;
			<?php
			if($General->get_term_conditions_statement()!='')
			{
			echo $General->get_term_conditions_statement();
			}else
			{
			_e(CHECKOUT_TERMS_CONDITIONS_MSG);
			}
			?>
			</div>
			<?php
			}
		}
	}
}
if(!isset($General))
{
	$General = new General();
}

/* get category checklist tree BOF*/
function get_wp_category_checklist($post_taxonomy,$pid,$mod='',$select_all='')
{
	    $pid = explode(',',$pid);
		global $wpdb;
		$taxonomy = $post_taxonomy;
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL;
		/*-Fetch main category-*/
		if($taxonomy == "")
		{
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND ({$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE2."' or {$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE1."')and  {$table_prefix}term_taxonomy.parent=0  ORDER BY {$table_prefix}terms.name");
		}else{
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' and  {$table_prefix}term_taxonomy.parent=0  ORDER BY {$table_prefix}terms.name");
		}
		$wpcategories = array_values($wpcategories);
		$wpcat2 = NULL;
		if($wpcategories)
		{
		echo "<ul>"; 
		if($select_all == 'select_all')
		{
		?>
		<li><label><input type="checkbox" name="selectall" id="selectall" value="all" class="checkbox" <?php if($_REQUEST['mod']=='custom_fields'){ ?> onclick="displaychk_custom();"<?php  } elseif($_REQUEST['mod']=='price'){ ?> onclick="displaychk_price();"<?php  }else{ ?>onclick="displaychk_frm();"<?php } ?> <?php if($pid[0]){ if(in_array('all',$pid)){ echo "checked=checked"; } }else{  }?>/></label>&nbsp;<?php echo "Select All"; ?></li>

		<?php
		}
		foreach ($wpcategories as $wpcat)
		{ 
		$counter++;
		$termid = $wpcat->term_id;;
		$name = ucfirst($wpcat->name); 
		$termprice = $wpcat->term_price;
		$tparent =  $wpcat->parent;	
		?>
		<li><label><input type="checkbox" name="category[]" id="<?php echo $termid; ?>" value="<?php echo $termid; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($termid,$pid) || in_array('all',$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; if($termprice != "") { echo " (".display_amount_with_currency($termprice).") ";}else{  echo " (".display_amount_with_currency('0').") "; } ?></li>
		<?php
		
		if($taxonomy !=""){

		 $child = get_term_children( $termid, $post_taxonomy );
		 $args = array(
				'type'                     => 'place,event',
				'child_of'                 => $termid,
				'hide_empty'               => 0,
				'taxonomy'                 => $post_taxonomy
				);
		 $categories = get_categories( $args );
		 
		 foreach($categories as $child_of)
		 { 
			$child_of = $child_of->term_id; 
		 	$p = 0;
			$term = get_term_by( 'id', $child_of,$post_taxonomy);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$termprice = $term->term_price;
			$name = $term->name;

			if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".$taxonomy."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p++;
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".$taxonomy."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			$p = $p*15;
		 ?>
			<li style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="<?php echo $term_tax_id; ?>" value="<?php echo $term_tax_id; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($term_tax_id,$pid) || in_array('all',$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; if($termprice != "") { echo " (".display_amount_with_currency($termprice).") ";}else{  echo " (".display_amount_with_currency('0').") "; } ?></li>
		<?php  }	}else{
		

		if($wpcat->taxonomy == CUSTOM_CATEGORY_TYPE1 )
			$post_taxonomy  = CUSTOM_CATEGORY_TYPE1;
		elseif($wpcat->taxonomy == CUSTOM_CATEGORY_TYPE2){
			$post_taxonomy  = CUSTOM_CATEGORY_TYPE2;
			}
		 $child = get_term_children( $termid, $post_taxonomy );
		 
		 foreach($child as $child_of)
		 { 
		 	$p = 0;
			$term = get_term_by( 'id', $child_of,$post_taxonomy);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$termprice = $term->term_price;
			$name = $term->name;

			if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND (tt.taxonomy ='".CUSTOM_CATEGORY_TYPE1."' or tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."')");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p++;
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND (tt.taxonomy ='".CUSTOM_CATEGORY_TYPE1."' or tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."')");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			$p = $p*15;
		 ?>
			<li style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="<?php echo $term_tax_id; ?>" value="<?php echo $term_tax_id; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($term_tax_id,$pid) || in_array('all',$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; if($termprice != "") { echo " (".display_amount_with_currency($termprice).") ";}else{  echo " (".display_amount_with_currency('0').") "; } ?></li>
		<?php  }	
				}		
}
	echo "</ul>"; } 
}
/* get category checklist tree EOF*/

/* remove custom user meta box*/
function remove_metaboxes() {
 remove_meta_box( 'postcustom' , CUSTOM_POST_TYPE1 , 'normal' ); //removes custom fields for page
 remove_meta_box( 'postcustom' , CUSTOM_POST_TYPE2 , 'normal' ); //removes custom fields for page
}
add_action( 'admin_menu' , 'remove_metaboxes' );

?>