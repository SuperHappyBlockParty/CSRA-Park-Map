<?php 
if(isset($_POST['multi_city']) && $_POST['multi_city'] != ''){ 
	$_SESSION['multi_city'] = $_POST['multi_city'];
	$_SESSION['multi_city1'] = $_POST['multi_city'];
}else if(isset($_REQUEST['front_post_city_id']) && $_REQUEST['front_post_city_id'] != "" ){
	setcookie("multi_city1", $_REQUEST['front_post_city_id'],time()+3600*24*30*12);
	$_COOKIE['multi_city1'] = $_REQUEST['front_post_city_id'];
	$_SESSION['multi_city1'] = $_COOKIE['multi_city1'];
	$_SESSION['multi_city'] = $_COOKIE['multi_city1'];
}else if($_SESSION['multi_city'] == "" && $_POST['multi_city'] == ""){
	if($_REQUEST['front_post_city_id'] == "" && get_option('splash_page') != "" && $_SESSION['multi_city1']=="" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "") {
		include_once("tpl_splash.php");
		exit;
	} else {
		global $multicity_db_table_name; 
		$my_city =$wpdb->get_row("select city_id from $multicity_db_table_name where is_default='1'");
		$_SESSION['multi_city'] = $my_city->city_id;
	}
} else{ 
	$_SESSION['multi_city'] = $_SESSION['multi_city'];
	$_SESSION['multi_city1'] = $_SESSION['multi_city'];
}
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
 $cur_post_id = $_REQUEST['pid'];
 $postdata = get_post($cur_post_id );
 $post_author_id = $postdata->post_author;
}
if(isset($_REQUEST['front_post_city_id']) =="" && get_option('splash_page') != "" && $_SESSION['multi_city1'] == "" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "") {
	include_once("tpl_splash.php");
	exit;
}else {
	if($_SESSION['multi_city'] == ""){
		$_SESSION['multi_city']= $_COOKIE['multi_city1'];
	}
	if(isset($_REQUEST['ptype']) && $_REQUEST['ptype']!=""){
	if($_REQUEST['ptype'] == 'favorite'){
		if($_REQUEST['action']=='add')	{
			add_to_favorite($_REQUEST['pid']);
		}else{
			remove_from_favorite($_REQUEST['pid']);
		}
	} else if($_REQUEST['ptype']=='profile'){
		global $current_user,$site_url;
		if(!$current_user->ID)	{
			wp_redirect($site_url.'/?ptype=login');
			exit;
		}
		include_once(TT_MODULES_FOLDER_PATH . "registration/registration.php");exit;
	} elseif($_REQUEST['ptype'] == 'phpinfo') {
		//echo phpinfo();exit;
	} elseif($_REQUEST['ptype'] == 'csvdl') {
		include (TT_MODULES_FOLDER_PATH . "/library/includes/csvdl.php");
	}
	elseif($_REQUEST['ptype'] == 'register' || $_REQUEST['ptype'] == 'login') {
		include (TT_MODULES_FOLDER_PATH . "registration/registration.php");
	} else if($_REQUEST['ptype']=='post_listing') {
		include_once(TT_MODULES_FOLDER_PATH.'place/submit_place.php');exit;
	} elseif($_REQUEST['ptype']=='post_event') {
		include_once(TT_MODULES_FOLDER_PATH.'event/submit_event.php');exit;
	} elseif($_REQUEST['ptype'] == 'preview'){
		include (TT_MODULES_FOLDER_PATH . "place/preview.php");
		exit;
	} elseif($_REQUEST['ptype'] == 'preview_event'){
		include (TT_MODULES_FOLDER_PATH . "event/preview_event.php"); exit;
	} elseif($_REQUEST['ptype'] == 'paynow'){
		include (TT_MODULES_FOLDER_PATH . "place/paynow.php");
	} elseif($_REQUEST['ptype'] == 'paynow_event'){
		include (TT_MODULES_FOLDER_PATH . "event/paynow_event.php");
	} elseif($_REQUEST['ptype'] == 'cancel_return'){
		include_once(TT_MODULES_FOLDER_PATH . 'general/cancel.php');
		if($post_author_id == $current_user->ID){
		set_property_status($_REQUEST['pid'],'trash');
		}
		exit;
	} elseif($_GET['ptype'] == 'return' || $_GET['ptype'] == 'payment_success')  // PAYMENT GATEWAY RETURN
	{
		$status = get_property_default_status();
		if($post_author_id == $current_user->ID){
		set_property_status($_REQUEST['pid'],$status);
		}
		include_once(TT_MODULES_FOLDER_PATH . 'general/return.php');
		exit;
	} elseif($_GET['ptype'] == 'success')  // PAYMENT GATEWAY RETURN 
	{
		include_once(TT_MODULES_FOLDER_PATH . "general/success.php");
		exit;
	} elseif($_GET['ptype'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
	{
		if($_GET['pmethod'] == 'paypal')	{
			include_once(TT_MODULES_FOLDER_PATH . 'general/ipn_process.php');
		} elseif($_GET['pmethod'] == '2co')	{
			include_once(TT_MODULES_FOLDER_PATH . 'general/ipn_process_2co.php');
		}
		exit;
	} elseif($_REQUEST['ptype'] == 'sort_image') {
		global $wpdb;
		$arr_pid = explode(',',$_REQUEST['pid']);
		for($j=0;$j<count($arr_pid);$j++){
			$media_id = $arr_pid[$j];
			if(strstr($media_id,'div_')){
				$media_id = str_replace('div_','',$arr_pid[$j]);
			}
			$wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where ID = "'.$media_id.'" ');
		}
		echo 'Image order saved successfully';
	} elseif($_REQUEST['ptype'] == 'delete') {
		global $current_user;	
		if($post_author_id == $current_user->ID){
			wp_delete_post($_REQUEST['pid']);
			wp_redirect(get_author_link($echo = false, $current_user->ID));
		}	
	} elseif($_REQUEST['ptype'] == 'att_delete') {	
		if($_REQUEST['remove'] == 'temp')	{
			if($_SESSION["file_info"])	{
				$tmp_file_info = array();
				foreach($_SESSION["file_info"] as $image_id=>$val)	{
					if($image_id == $_REQUEST['pid']) {
						@unlink(ABSPATH."/".$upload_folder_path."tmp/".$_REQUEST['pid'].".jpg");
					} else{	
						$tmp_file_info[$image_id] = $val;
					}
				}
				$_SESSION["file_info"] = $tmp_file_info;
			}
		} else{		
			if($post_author_id == $current_user->ID){
			wp_delete_attachment($_REQUEST['pid']);	
			}
		}	
	} }else {  get_header(); ?>

<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START -->

    <?php templ_page_title_above(); //page title above action hook?>
    
    <div class="content-title">
      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
      <?php /* If this is a category archive */ if (is_category()) { ?>
      <?php $ptitle = sprintf(__('%s','templatic'), single_cat_title('', false)); ?>
      <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
      <?php $ptitle = sprintf(POST_TAG_ARCHIVE_TEXT, single_tag_title('', false) ); ?>
      <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
      <?php $ptitle = sprintf(DAILY_ARCHIVE_TEXT, get_the_time(templ_get_date_format())); ?>
      <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
      <?php $ptitle = sprintf(MONTHLY_ARCHIVE_TEXT, get_the_time('F, Y')); ?>
      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
      <?php $ptitle = sprintf(YEARLY_ARCHIVE_TEXT, get_the_time('Y')); ?>
      <?php /* If this is an author archive */ } elseif (is_author()) { ?>
      <?php $ptitle = AUTHOR_ARCHIVE_TEXT; ?>
      <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        <?php $ptitle = BLOG_ARCHIVE_TEXT; ?>
        <?php }elseif(is_tax()){
		$current_term = $wp_query->get_queried_object();	
		$ptitle = $current_term->name; 
		}		?>
      <?php echo templ_page_title_filter($ptitle); //page tilte filter?>  </div>
    <?php templ_page_title_below(); //page title below action hook?>
    
        
       <?php if (category_description( $category_id ) != null) {?> <div class="cat_desc"><?php echo _e(category_description(),'templatic'); ?> </div><?php } ?>
        
    
    <?php get_template_part('loop'); ?>

    <?php get_template_part('pagination'); ?>

<!--  CONTENT AREA END -->
</div>
<?php include_once ('library/includes/sidebar_blog_listing.php'); ?>
<?php get_footer(); }

}?>