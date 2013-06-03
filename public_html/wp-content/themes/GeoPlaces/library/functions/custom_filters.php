<?php
/********************************************************************
You can add your filetes in this file and it will affected.
This is the common filter functions file where you can add you filtes.
********************************************************************/

add_filter('templ_page_title_filter','templ_page_title_fun');
function templ_page_title_fun($title)
{
	return '<h1>'.$title.'</h1>';
}

add_filter('templ_theme_guide_link_filter','templ_theme_guide_link_fun');
function templ_theme_guide_link_fun($guidelink)
{
	$guidelink .= "/theme-documentation/geoplaces-v4-theme-guide/"; // templatic.com site theme guide url here
	return $guidelink;
}

add_filter('templ_theme_forum_link_filter','templ_theme_forum_link_fun');
function templ_theme_forum_link_fun($forumlink)
{
	$forumlink .= "/viewforum.php?f=88"; // templatic.com site Forum url here
	return $forumlink;
}

add_filter('templ_admin_menu_title_filter','templ_admin_menu_title_fun');
function templ_admin_menu_title_fun($content)
{
	return $content=__('GeoPlaces','templatic');
}


add_filter('templ_breadcrumbs_navigation_filter','templ_breadcrumbs_navigation_fun');
function templ_breadcrumbs_navigation_fun($bc){
	global $post;
	if($post->post_type == CUSTOM_POST_TYPE1){
		if(strstr($bc,CUSTOM_MENU_TAG_TITLE)) {
			$templ = substr($bc, strrpos($bc,'. &raquo; '.CUSTOM_MENU_TAG_TITLE.':') , strlen($bc));
			$arr = explode('&raquo;',$templ);
			$bc = str_replace($arr[1],'',$bc);
		}	
		$bread = str_replace('. &raquo;',' &raquo;',$bc);
		$bread = str_replace(CUSTOM_MENU_CAT_TITLE.':','',$bread);
		$bread = str_replace(', and',',',$bread);
		$bread = str_replace(' and ',', ',$bread);
		$bread = str_replace(' &raquo;&raquo; ',' &raquo; ',$bread);
		$bread = str_replace(' &raquo;  &raquo; ',' &raquo; ',$bread);
	} else if($post->post_type == CUSTOM_POST_TYPE2){
		if(strstr($bc,CUSTOM_MENU_TAG_TITLE2)) {
			$templ = substr($bc, strrpos($bc,'. &raquo; '.CUSTOM_MENU_TAG_TITLE2.':') , strlen($bc));
			$arr = explode('&raquo;',$templ);
			$bc = str_replace($arr[1],'',$bc);
		}	
		$bread = str_replace('. &raquo;',' &raquo;',$bc);
		$bread = str_replace(CUSTOM_MENU_CAT_TITLE2.':','',$bread);
		$bread = str_replace(', and',',',$bread);
		$bread = str_replace(' and ',', ',$bread);
		$bread = str_replace(' &raquo;&raquo; ',' &raquo; ',$bread);
		$bread = str_replace(' &raquo;  &raquo; ',' &raquo; ',$bread);
	}
	return __($bread,'templatic');	
}

add_action('templ_page_title_above','templ_page_title_above_fun'); //page title above action hook
//add_action('templ_page_title_below','templ_page_title_below_fun');  //page title below action hook
function templ_page_title_above_fun()
{
	templ_set_breadcrumbs_navigation();
}

add_filter('templ_anything_slider_widget_content_filter','templ_anything_slider_content_fun');
function templ_anything_slider_content_fun($post)
{
	ob_start(); // don't remove this code
/////////////////////////////////////////////////////
	if(get_the_post_thumbnail( $post->ID, array())){
	?>
	<a class="post_img" href="<?php echo get_permalink($post->ID);?>"><?php echo  get_the_post_thumbnail( $post->ID, array(220,220),array('class'	=> "",));?></a>
	<?php
    }else if($post_images = bdw_get_images($post->ID,'medium')){ 
	global $thumb_url;
	?>
	<a class="post_img" href="<?php echo get_permalink($post->ID);?>">
	 <img src="<?php echo get_bloginfo('template_url');?>/thumb.php?src=<?php echo $post_images[0];?>&amp;w=220&amp;h=220&amp;zc=1&amp;q=80<?php echo $thumb_url;?>" alt="<?php echo get_the_title($post->ID);?>" title="<?php echo get_the_title($post->ID);?>"  /></a>
	<?php } ?>
    <div class="tslider3_content">
    <h3> <a class="widget-title" href="<?php echo get_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></h3>
    <p>
	<?php echo bm_better_excerpt(605, ' ... ');?></p>
    <p><a href="<?php echo get_permalink($post->ID);?>" class="more"><?php echo READ_MORE_LABEL; ?></a></p>
   </div>


<?php
/////////////////////////////////////////////////////
	$return = ob_get_contents(); // don't remove this code
	ob_end_clean(); // don't remove this code
	return  $return;
}

add_filter('templ_sidebar_widget_box_filter','templ_sidebar_widget_box_fun');
function templ_sidebar_widget_box_fun($content)
{

	$content['home_slider']='';
	// End Remove Footer Widgets Area Page Layout option wise
	//$content['top_navigation']='';
	//$content['header_logo_right_side']='';
	//$content['main_navigation']='';
	$content['header_above']='';
	$content['slider_above']='';
	$content['slider_below']='';
	$content['sidebar_2col_merge']='';
	$content['sidebar2']='';
	
	//$content['header_logo_right_side']='';
	
	$array_key = array_keys($content);
	$position = array_keys($array_key,'single_post_below');
	$widget_pos = $position[0]+1;

$sidebar_widget_arr = array();

$sidebar_widget_arr['front_top_banner'] =array(1,array('name' => 'Front Top Banner Section','id' => 'front_top_banner','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));

$sidebar_widget_arr['front_content'] =array(1,array('name' => 'Front Content','id' => 'front_content','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['front_sidebar'] =array(1,array('name' => 'Front Sidebar','id' => 'front_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['below_registration'] =array(1,array('name' => 'Below Login/Registration','id' => 'below_registration', 'description' => 'This region is located below login form and its only for social gigya plugin.','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['place_listing_sidebar'] =array(1,array('name' => 'Place Listing Sidebar','id' => 'place_listing_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['place_detail_sidebar'] =array(1,array('name' => 'Place Detail Sidebar','id' => 'place_detail_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['place_detail_content_banner'] =array(1,array('name' => 'Place Detail Content Banner','id' => 'place_detail_content_banner','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['add_place_sidebar'] =array(1,array('name' => 'Add Place Sidebar','id' => 'add_place_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));

$sidebar_widget_arr['event_listing_sidebar'] =array(1,array('name' => 'Event Listing Sidebar','id' => 'event_listing_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['event_detail_sidebar'] =array(1,array('name' => 'Event Detail Sidebar','id' => 'event_detail_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['event_detail_content_banner'] =array(1,array('name' => 'Event Detail Content Banner','id' => 'event_detail_content_banner','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['add_event_sidebar'] =array(1,array('name' => 'Add Event Sidebar','id' => 'add_event_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));


$sidebar_widget_arr['contact_googlemap'] =array(1,array('name' => 'Contact Page - Google Map','id' => 'contact_googlemap','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['blog_listing_sidebar'] =array(1,array('name' => 'Blog Listing - Sidebar','id' => 'blog_listing_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['blog_detail_sidebar'] =array(1,array('name' => 'Blog Details - Sidebar','id' => 'blog_detail_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['blog_detail_content_banner'] =array(1,array('name' => 'Blog Detail Content Banner','id' => 'blog_detail_content_banner','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['login_page'] =array(1,array('name' => 'Login Page','id' => 'login_page','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
//$sidebar_widget_arr['custome_sidebar'] =array(1,array('name' => 'Custom Sidebar','id' => 'custome_sidebar','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));
$sidebar_widget_arr['footer_nav'] =array(1,array('name' => 'Footer Navigation','id' => 'footer_nav','before_widget' => '','after_widget' => '','before_title' => '<h3>','after_title' => '</h3>'));

	 
	array_splice($content, $widget_pos-1, 0, $sidebar_widget_arr);
	
	//print_r($content);
	
	return $content;
}

add_filter('templ_widgets_listing_filter','templ_widgets_listing_fun');
function templ_widgets_listing_fun($content)
{
	//print_r($content);
	$content['featured_video']='';
	$content['pika_choose_slider']='';
	$content['anything_slider']='';
	//$content['login']='';
	$content['anything_listing_slider']='';
	$content['nivo_slider']='';
	$content['my_bio']='';
	//$content['social_media']='';
	
	//print_r($content);
	//$content['flickr']='';
	return $content;
} 

/*-Extra fields in user area BOF-*/
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { 
$user_id = $user->ID;
$user_facebook = get_user_meta($user_id,'user_facebook',true);
$user_twitter = get_user_meta($user_id,'user_twitter',true);
?>
<h3><?php _e("Other information", "templatic"); ?></h3>
 
<table class="form-table">
<tr>
<th><label for="user_facebook"><?php _e("Facebook Link ",'templatic'); ?></label></th>
<td>
<input type="text" name="user_facebook" id="user_facebook" value="<?php echo esc_attr($user_facebook); ?>" class="textfield" /><br />
</td>
</tr>

<tr>
<th><label for="user_twitter"><?php _e("Twitter Link",'templatic'); ?></label></th>
<td>
<input type="text" name="user_twitter" id="user_twitter" value="<?php echo esc_attr( $user_twitter); ?>" class="textfield" /><br />
</td>
</tr>

<?php
global $form_fields_usermeta;
$validation_info = array();

$custom_metaboxes = templ_get_usermeta('profile');

foreach($form_fields_usermeta as $key=>$val)
{
	if($val['on_profile']){
	$str = ''; $fval = '';
	$field_val = $key.'_val';
	if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
	if($val['is_require'])
	{
		$validation_info[] = array(
								   'name'	=> $key,
								   'espan'	=> $key.'_error',
								   'type'	=> $val['type'],
								   'text'	=> $val['label'],
								   );
	}
	if($key)
	{
		$fval = get_user_meta($user_id,$key,true);
	}

	if($val['type']=='text')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';
		}
	}elseif($val['type']=='hidden')
	{
		$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='textarea')
	{
		$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='texteditor')
	{
		
		$str = $val['tag_before'].'<textarea name="'.$key.'" PLACEHOLDER="'.$val["default"].'" class="mce $val["extra_parameter"]">'.$fval.'</textarea>'.$val['tag_after'];
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
	}else
	if($val['type']=='file')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='include')
	{
		$str = @include_once($val['default']);
	}else
	if($val['type']=='head')
	{
		$str = '';
	}else
	if($val['type']=='date')
	{ 
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.get_user_meta($user_id,$key,true).'">';	
		$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.userform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catselect')
	{
		$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key => $cat) 
		{
		
			$seled='';
			if($term->name==$cat->name){ $seled='selected="selected"';}
			$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catdropdown')
	{
		$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
		$cat_args['show_option_none'] = __('Select Category','templatic');
		$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='select')
	{
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$option_values_arr = explode(',', $val['options']);
		for($i=0;$i<count($option_values_arr);$i++)
		{
			$seled='';
			
			if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
			$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catcheckbox')
	{
		$fval_arr = explode(',',$fval);
		$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catradio')
	{
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key1 => $cat) 
		{
			
			
				$seled='';
				if($fval==$cat->term_id){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
			
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='checkbox')
	{
		if($fval){ $seled='checked="checked"';}
		$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='upload')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
			if($fval!=''){
				$str .='<img src="'.templ_thumbimage_filter($fval,'&amp;w=121&amp;h=115&amp;zc=1&amp;q=80').'" alt="" />
				<br />
				<input type="hidden" name="prev_upload" value="'.$fval.'" />
				';	
			}
		if($val['is_require'])
		{
			$str .='<span id="'.$key.'_error"></span>';	
		}
	}
	else
	if($val['type']=='radio')
	{
		$options = $val['options'];
		if($options)
		{
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$seled='';
				if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}else
	if($val['type']=='multicheckbox')
	{
		$options = $val['options'];
		if($options)
		{  $chkcounter = 0;
			
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$chkcounter++;
				$seled='';
				if(in_array($option_values_arr[$i],$fval)){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}
	else
	if($val['type']=='packageradio')
	{
		$options = $val['options'];
		foreach($options as $okey=>$oval)
		{
			$seled='';
			if($fval==$okey){$seled='checked="checked"';}
			$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='geo_map')
	{
		do_action('templ_submit_form_googlemap');	
	}else
	if($val['type']=='image_uploader')
	{
		do_action('templ_submit_form_image_uploader');	
	}
	if($val['is_require'])
	{
		$label = '<label>'.$val['label'].' <span>*</span> </label>';
	}else
	{
		$label = '<label>'.$val['label'].'</label>';
	}
	$outer_st = "<tr><th>";
	$tag_st = "</th><td>";
	$tag_end = "</td>";
	$outer_end = "</tr>";
	echo $outer_st.$label.$tag_st.$str.$tag_end.$outer_end;
	}
}
?>
</table>
<?php }
 /*-Extra fields in user area EOF-*/
 
 /*-Extra fields in user info save BOF-*/
add_action('personal_options_update', 'save_extra_user_profile_fields' );
add_action('edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
global $wpdb;
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

		$user_facebook = $_POST['user_facebook'];
		$user_twitter = $_POST['user_twitter'];
		update_usermeta($user_id, 'user_facebook', $user_facebook);
		update_usermeta($user_id, 'user_twitter',$user_twitter);	
			
			global $upload_folder_path;
	
		$custom_metaboxes = templ_get_usermeta('profile');
		
		foreach($custom_metaboxes as $fkey=>$fval)
		{
			$fldkey = "$fkey";
			$$fldkey = $_POST["$fkey"];
			if($fval['type']=='upload')
			{
				
				if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
					$dirinfo = wp_upload_dir();
					$path = $dirinfo['path'];
					$url = $dirinfo['url'];
					$destination_path = $path."/";
					$destination_url = $url."/";
					
					$src = $_FILES[$fkey]['tmp_name'];
					$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
					$target_file = $destination_path.$file_ame;
					if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
					{
						$image_path = $destination_url.$file_ame;
					}else
					{
						$image_path = '';	
					}				
					$_POST[$fkey] = $image_path;
					$fldkey = $image_path;
					
				}
				else{
					$_POST[$fkey]=$_POST['prev_upload'];
				}
			}
			
			update_usermeta($user_id, $fkey, $$fldkey);
			 // User Custom Metadata Here
		} 
		
}
 /*-Extra fields in user info save EOF-*/
 ?>