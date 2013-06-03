<?php	
global $upload_folder_path,$site_url;
$cat_display=get_option('ptthemes_category_dislay');

if($_POST)
{		
	$_SESSION['place_info'] = $_POST;
	if(!is_int($_POST['total_price']) && $_POST['total_price']<0)
	{ ?>
	<script>
	alert('<?php _e('Price is Invalid,please select valid price','templatic');?>');
	window.location= '<?php echo $site_url; ?>'+'/?ptype=post_listing&backandedit=1';</script>
<?php	
	}
	$property_name = stripslashes($_POST['property_name']);
	$address = stripslashes($_POST['geo_address']);
	$zooming_factor = $_POST['zooming_factor'];
	$geo_latitude = $_POST['geo_latitude'];
	$geo_longitude = $_POST['geo_longitude'];
	$map_view = $_POST['map_view'];
	$timing = $_POST['timing'];
	$contact = stripslashes($_POST['contact']);
	$email = $_POST['email'];
	$website = $_POST['website'];
	$twitter = $_POST['twitter'];
	$facebook = $_POST['facebook'];
	$kw_tags = $_POST['kw_tags'];
	
	$price_select = $_POST['price_select'];
	$featured_type = $_POST['featured_type'];
	$total_price = $_POST['total_price'];
	
	$post_city_id  = $_POST['post_city_id'];
	$proprty_desc = stripslashes($_POST['proprty_desc']);
	$proprty_feature = stripslashes($_POST['proprty_feature']);
	if($cat_display == 'checkbox' && is_array($_POST['category'])){
		$cat_array1 = implode("-",$_POST['category']) ;
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ )
		{
			//echo $cat_array2[$i];
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
			$allc1 .= $allc[0].","; }

		}
	$cat = explode(',',$allc1);

	}else{
	$cat = $_POST['category'];
	}
	$sep = "";
	$a = "";
	$cat1 = "";

	if($_POST['user_email'] && $_FILES['user_photo']['name'])
	{
		$src = $_FILES['user_photo']['tmp_name'];
		$dest_path = get_image_phy_destination_path_user().date('Ymdhis')."_".$_FILES['user_photo']['name'];
		$user_photo = image_resize_custom($src,$dest_path,150,150);
        $photo_path = get_image_rel_destination_path_user().$user_photo['file'];
		$_SESSION['place_info']['user_photo'] = $photo_path;
	}
	/**registration validation for user BOF**/
	if($current_user->ID ==''){
		if ($_POST['user_email'] == '' )	{
			$_SESSION['userinset_error'] = array();
			$_SESSION['userinset_error'][] = __('Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.','templatic');
			wp_redirect($site_url.'/?ptype=post_listing&backandedit=1&usererror=1');
			exit;
		}
		
		require( 'wp-load.php' );
		require(ABSPATH.'wp-includes/registration.php');
		
		global $wpdb;
		$errors1 = new WP_Error();
		
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_login = $user_fname;	
		$user_login = sanitize_user( $user_login );
		$user_email = apply_filters( 'user_registration_email', $user_email );
		
		// Check the username
		if ( $user_login == '' )
			$errors1->add('empty_username', __('ERROR: Please enter a username.'));
		elseif ( !validate_username( $user_login ) ) {
			$errors1->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
			$user_login = '';
		} elseif ( username_exists( $user_login ) )
			$errors1->add('username_exists', __('<strong>ERROR</strong>: '.$user_login.' This username is already registered, please choose another one.'));

		// Check the e-mail address
		if ($user_email == '') {
			$errors1->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
		} elseif ( !is_email( $user_email ) ) {
			$errors1->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
			$user_email = '';
		} elseif ( email_exists( $user_email ) )
			$errors1->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));

		do_action('register_post', $user_login, $user_email, $errors1);	
		
		//$errors1 = apply_filters( 'registration_errors', $errors1 );
		if($errors1)
		{
			$_SESSION['userinset_error'] = array();
			foreach($errors1 as $errorsObj)
			{
				foreach($errorsObj as $key=>$val)
				{
					for($i=0;$i<count($val);$i++)
					{
						$_SESSION['userinset_error'][] = $val[$i];
						if($val[$i]){break;}
					}
				} 
			}
		}	
		if ($errors1->get_error_code() )
		{
			wp_redirect($site_url.'/?ptype=post_listing&backandedit=1&usererror=1');
			exit;
		}
			
	}	/**registration validation for user EOF**/
	
	
}else
{

	$catid_info_arr = get_property_cat_id_name($_REQUEST['pid']);
	$post_info = get_post_info($_REQUEST['pid']);
	$property_name = stripslashes($post_info['property_name']);
	$proprty_desc = stripslashes($post_info['post_content']);
		
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$proprty_feature = stripslashes($post_meta['proprty_feature'][0]);
	$address = stripslashes($post_meta['geo_address'][0]);
	$zooming_factor = $post_meta['zooming_factor'][0];
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];
	$map_view = $post_meta['map_view'][0];
	$timing = $post_meta['timing'][0];
	$contact = $post_meta['contact'][0];
	$email = $post_meta['email'][0];
	$website = $post_meta['website'][0];
	$twitter = $post_meta['twitter'][0];
	$facebook = $post_meta['facebook'][0];
	$kw_tags = $post_meta['kw_tags'][0];
	$post_city_id  = $post_meta['post_city_id'][0];
	$cat = $post_meta['category'];
	$sep = "";
	$a = "";
	$cat1 = "";
	if($_REQUEST['pid'])
	{
		$is_delet_property = 1;
	}
}

global $upload_folder_path;
$_SESSION["file_info"] = explode(",",$_POST['imgarr']);
if($_SESSION["file_info"])
{
	//$tmppath = $upload_folder_path.'themes/MFramework/images/tmp/';
	foreach($_SESSION["file_info"] as $image_id=>$val)
	{		 
		$image_src =  get_template_directory_uri().'/images/tmp/'.$val;
		break;
	}
}else
{
	$image_src = $thumb_img_arr[0];
	if($_REQUEST['pid']){
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
	}
	$image_src = $large_img_arr[0];
}

if($_REQUEST['pid'])
{
	$large_img_arr = bdw_get_images($_REQUEST['pid'],'medium');
	$thumb_img_arr = bdw_get_images($_REQUEST['pid'],'thumb');
	$largest_img_arr = bdw_get_images($_REQUEST['pid'],'large');
}
$pcd = explode(',',get_option('ptthemes_captcha_dislay'));	
if((in_array('Add Place/Event submission page',$pcd) || in_array('Both',$pcd)) && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha') ){
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) {
			wp_redirect($site_url.'/?ptype=post_listing&backandedit=1&ecptcha=captch');
			exit;
		} 
	}
$page_title = $property_name;
global $page_title;	

?>
<?php get_header(); ?>


 <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes' ) {  ?>       
 <div class="breadcrumb_in"><a href="<?php echo $site_url; ?>"><?php _e('Home','templatic'); ?></a> &raquo; <?php echo $property_name; ?></div>  
 <?php } ?>
 
<div class="steps">
        	<span ><?php _e(ENTER_PLACE,'templatic'); ?></span>
            <span class="current"><?php _e(PREVIEW_PLACE,'templatic'); ?></span>
            <span><?php _e(SUCCESS_PLACE,'templatic'); ?></span>
</div>     


 
<?php include_once(TT_MODULES_FOLDER_PATH . "place/preview_buttons.php");?>
<div  class="<?php templ_content_css();?>" >
  <!--  CONTENT AREA START. -->
 
	<div class="entry">
		<div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
			
      <?php templ_before_single_post_content(); // BEFORE  single post content  hooks?>
<div class="content-title">
	<?php echo $property_name; ?>
   </div>
	  <div class="post-content">
	  
      <script src="<?php echo get_bloginfo('template_directory'); ?>/js/galleria.js" type="text/javascript" ></script>
            <div id="galleria">
          <?php			$thumb_img_counter = 0;
							if($_SESSION["file_info"] || $_REQUEST['alook'])
							{
								$thumb_img_counter = $thumb_img_counter+count($_SESSION["file_info"]);
								$image_path = get_image_phy_destination_path();
									
								$tmppath = "/".$upload_folder_path."tmp/";
									
								foreach($_SESSION["file_info"] as $image_id=>$val)
								{
									//$thumb_image = home_url().$tmppath.$image_id.'.jpg';
								    $curry = date("Y");
									$currm = date("m");
									$src = get_template_directory().'/images/tmp/'.$val;
									if($val):
									if(file_exists($src)):
										$thumb_image = get_template_directory_uri().'/images/tmp/'.$val; ?>
										<a href="<?php echo $thumb_image;?>"><img src="<?php echo $thumb_image;?>"></a>
                                    <?php else: ?>
										<?php
                                            foreach($largest_img_arr as $value):
												$name = end(explode("/",$value));
                                                if($val == $name):
                                        ?>
                                            <a href="<?php echo $value; ?>"><img src="<?php echo $value;?>"></a>
                                        <?php
										        endif;
											endforeach;	
										?>
                                    <?php endif; ?>
                                    <?php endif; ?>
								<?php
								$thumb_img_counter++;
								 
							if($_REQUEST['alook']): ?>
						 <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/jquery.lightbox-0.5.js"></script>
						 <script type="text/javascript">
							var IMAGE_LOADING = '<?php echo get_template_directory_uri()."/images/lightbox-ico-loading.gif"; ?>';
							var IMAGE_PREV = '<?php echo get_template_directory_uri()."/images/lightbox-btn-prev.gif"; ?>';
							var IMAGE_NEXT = '<?php echo get_template_directory_uri()."/images/lightbox-btn-next.gif"; ?>';
							var IMAGE_CLOSE = '<?php echo get_template_directory_uri()."/images/lightbox-btn-close.gif"; ?>';
							var IMAGE_BLANK = '<?php echo get_template_directory_uri()."/images/lightbox-blank.gif"; ?>';
							jQuery(function() {
								jQuery('#gallery a').lightBox();
							});
						</script>
						<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/library/css/jquery.lightbox-0.5.css" media="screen" />
						<?php 
                         $post_img_thumb = bdw_get_images_with_info($_REQUEST['pid'],'thumb'); 
						 $large_arr = bdw_get_images_with_info($_REQUEST['pid'],'large'); 
						 for($im=0;$im<count($post_img_thumb);$im++): ?>
							<li>
							   <a href="<?php echo $large_arr[$im]['file'];
						   $attachment_id = $large_arr[$im]['id'];
						   $attach_data = get_post($attachment_id);
						   $img_title = $attach_data->post_excerpt;
						 ?>" title="<?php echo $img_title; ?>">
									<img src="<?php echo $post_img_thumb[$im]["file"];?>" height="70" width="70"  title="<?php echo $img_title; ?>" alt="<?php echo $img_alt; ?>" />
							   </a>
							</li>
						<?php 
						endfor;
						endif;
								}
							}
	
							?>
        </div>
        <?php echo $proprty_desc; ?>
		<?php if(isset($_SESSION['place_info']['video']) && $_SESSION['place_info']['video'] != '') { echo "<p>".stripslashes($_SESSION['place_info']['video'])."</p>"; } ?>
        <?php if($proprty_feature != '') { ?>       
        <div class="register_info">     
            <h3><?php echo SPECIAL_OFFER;?></h3><p><?php echo $proprty_feature;?></p>
           	  
           </div>
		  <?php } ?>
        <div>
	
		<?php
		$texonomytable = $wpdb->prefix."term_taxonomy";
		$termtable = $wpdb->prefix."terms";
		if(is_array($cat)) {
		$countc = implode(',',$cat);
		if($cat != ""){
					for($dc = 0; $dc < $countc; $dc ++ )
					{
						if($dc == $countc)
						{	$sep = ""; }
						else
						{	$sep =","; }
						
						$place_taxonomy_res = $wpdb->get_row("select * from $texonomytable where term_taxonomy_id = '".$cat[$dc]."'");
						$place_term = $wpdb->get_row("select * from $termtable where term_id = '".$place_taxonomy_res->term_id."'");
						
						$a .= $cat[$dc].$sep;
						if($place_term->name != ""){
						$taxcategory_link = get_term_link($place_term->slug,CUSTOM_CATEGORY_TYPE1 );
						
						$final_var .= '<a href="'.intval($taxcategory_link).'">'.$place_term->name.'</a>'.$sep;
						
						}
					}
					
					
					echo '<span class="post-category">'.$final_var.'</span>';
				} 				
		
		} else {
		$place_taxonomy_res = $wpdb->get_row("select * from $texonomytable where term_taxonomy_id = '".$cat."'");
		$place_term = $wpdb->get_row("select * from $termtable where term_id = '".$place_taxonomy_res->term_id."'");	
		if($place_term->name != '') {
		
	
				echo '<span class="post-category"><a href="#">'.$place_term->name.'</a></span>';	
			}
		} if($kw_tags != '') {?>
        <span class="post-tags"><?php echo $kw_tags; ?></span> <?php } ?>
		</div>
        
      </div>
	</div>
	</div>	
		<!--  Post Content Condition for Post Format-->
		<?php templ_after_single_post_content(); // after single post content hooks?>
		<!-- twitter & facebook likethis option-->
	 
	</div>

		<div class="sidebar right">
			<div class="company_info">
            <!-- claim to ownership -->
          <?php 
		     if(get_option('ptthemes_enable_claimownership') =='Yes'){
							global $post,$wpdb,$claim_db_table_name,$site_url ;
							$claimreq = $wpdb->get_results("select * from $claim_db_table_name where post_id= '".$post->ID."' and status = '1'");
								if(mysql_affected_rows() >0 || get_post_meta($post->ID,'is_claimed',true) == 1)
								{
								_e('<p class="i_verfied">Owner Verified Listing</p>','templatic');
								}else{
						
						?>	
							<a href="javascript:void(0);" onclick="show_hide_popup('claim_listing');" title="Mail to a friend" class="i_claim c_sendtofriend"><?php echo CLAIM_OWNERSHIP;?></a>
						<?php include_once (get_template_directory() .'/monetize/email_notification/popup_owner_frm.php'); ?>
						<?php } }?>

<?php if($address) {     ?>
<p> <span class="i_location"><?php echo ADDRESS." :"; ?></span> <?php echo $address;?>   </p> <?php } ?>
<?php if($website){
		$website = $website;
        if(!strstr($website,'http')) {
             $website = 'http://'.$website;
        } ?>

		<p>  <span class="i_website"><a href="<?php echo $website;?>"><strong><?php _e('Website');?></strong></a>  </span> </p>

<?php } if($timing){?>
<p> <span class="i_time"> <?php echo TIME." :" ; ?> </span>  <?php echo $timing;?>  </p> <?php } 
if($contact) { ?>
<p> <span class="i_contact"> <?php echo PHONE." :"; ?></span>  <?php echo $contact;?>  </p> <?php } ?>
		        </div>  <!-- company info -->
                
        <div class="company_info2">
		<?php  if(get_option('ptthemes_disable_rating') == 'no') {  ?>
       <p> <span class="i_rating"><?php echo RATING." :"; ?></span> 
       <span class="single_rating"> 
       <?php echo get_post_rating_star($post->ID);?>
        	</span> 
        </p><?php } ?>
       <div class="share clarfix"> 
       <div class="addthis_toolbox addthis_default_style">
        <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c873bb26489d97f" class="addthis_button_compact sharethis"><?php echo SHARE_TEXT; ?></a>
        </div>
       <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
	
    	</div>
      <?php if($twitter || $facebook) {  ?>
      <div class="links">
	  <?php if($twitter) {  ?>
       <a class="i_twitter" href="<?php echo $twitter ;?>"> <?php echo TWITTER; ?> </a>      <?php } 
	   if($facebook) { ?>
        <a class="i_facebook" href="<?php echo $facebook;?>"><?php echo FACEBOOK; ?> </a>  <?php } ?>
         </div>
         
         <?php }
		 if(get_option('ptthemes_email_on_detailpage') == 'Yes') { ?>
         <a href="javascript:void(0);"  title="Mail to a friend" class="b_sendtofriend i_email2"><?php echo MAIL_TO_FRIEND;?></a> 
		<?php include_once (get_template_directory() . '/monetize/email_notification/popup_frms.php'); } ?>					
    <!-- post Inquiry -->
	<?php if(get_option('ptthemes_inquiry_on_detailpage') == 'Yes') { ?>
        <a href="javascript:void(0);" title="I"  class="i_email2 i_sendtofriend"><?php echo SEND_INQUIRY;?></a> 
        <?php include_once (get_template_directory() .'/monetize/email_notification/popup_inquiry_frm.php'); } ?>
		<?php	global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both') ";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date'){
					if($_SESSION['place_info'][$post_meta_info_obj->htmlvar_name] != "" ){
						if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing" && $post_meta_info_obj->htmlvar_name != "video")
						{
							if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
								echo "<div class='i_customlable'><span >".$post_meta_info_obj->site_title." :"."</span>". stripslashes($_SESSION['place_info'][$post_meta_info_obj->htmlvar_name]) ."</div>";
							} else {
								echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>". stripslashes($_SESSION['place_info'][$post_meta_info_obj->htmlvar_name]) ."</div>";
							}
						}
					 }
					}elseif($post_meta_info_obj->ctype =='upload'){
						echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>".$_FILES[$post_meta_info_obj->htmlvar_name]['name']."</div>";	
					}else{
							$value_1 = $_SESSION['place_info'][$post_meta_info_obj->htmlvar_name];
							if($post_meta_info_obj->ctype == 'multicheckbox'):
								$checkArr = $_SESSION['place_info'][$post_meta_info_obj->htmlvar_name];
								$check="";
								if($checkArr):
									foreach($checkArr as $_checkArr)
									{
										$check .= $_checkArr.",";
									}
								endif;	
								$check = substr($check,0,-1);
								echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>".$check."</div>";
							else:
								if($value_1 !=''){
									echo "<div class='i_customlable'><span>".$post_meta_info_obj->site_title." :"."</span>". stripslashes($_SESSION['place_info'][$post_meta_info_obj->htmlvar_name])."</div>"; }
							endif;	
					}
		} ?>
         
  
         
        </div>
	<div class="sidebar_in">
	<div class="sidebar_map clearfix">
     <?php if($geo_longitude &&  $geo_latitude){?>
      <?php
	  
   include_once (get_template_directory() . '/library/map/preview_map.php');   
   show_address_google_map($geo_latitude,$geo_longitude,$address,$map_view,$zooming_factor,$width='275',$height='315');?>
    <?php }elseif($address){?>
    <iframe src="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=<?php echo $address;?>&ie=UTF8&z=14&iwloc=A&output=embed" height="315" width="275"></iframe>
    <?php }?>
		</div>
	
    </div>
		</div>	
  <script type="text/javascript">
var $cg = jQuery.noConflict();
// Load theme
Galleria.loadTheme('<?php echo get_bloginfo('template_directory'); ?>/js/galleria.classic.js');
// run galleria and add some options
    $cg('#galleria').galleria({
        image_crop: true, // crop all images to fit
        thumb_crop: true, // crop all thumbnails to fit
        transition: 'fade', // crossfade photos
        transition_speed: 700, // slow down the crossfade
		autoplay: <?php if(get_option('ptthemes_photo_gallery') == 'Yes'){ echo 'true';} else { echo 'false';}?>,
        data_config: function(img) {
            // will extract and return image captions from the source:
            return  {
                title: $cg(img).parent().next('strong').html(),
                description: $cg(img).parent().next('strong').next().html()
            };
        },
        extend: function() {
            this.bind(Galleria.IMAGE, function(e) {
                // bind a click event to the active image
                $cg(e.imageTarget).css('cursor','pointer').click(this.proxy(function() {
                    // open the image in a lightbox
                    this.openLightbox();
                }));
            });
        }
    });
</script>		
<?php get_footer(); ?>	