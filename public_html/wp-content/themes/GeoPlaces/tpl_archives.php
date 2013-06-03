<?php
/*
Template Name: Page - Archives
*/
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

if(isset($_REQUEST['front_post_city_id']) =="" && get_option('splash_page') != "" && $_SESSION['multi_city1'] == "" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "") {
	include_once("tpl_splash.php");
	exit;
}else { global $site_url;
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
		global $current_user;
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
		set_property_status($_REQUEST['pid'],'trash');
		exit;
	} elseif($_GET['ptype'] == 'return' || $_GET['ptype'] == 'payment_success')  // PAYMENT GATEWAY RETURN
	{
		$status = get_property_default_status();
		set_property_status($_REQUEST['pid'],$status);
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
		if($_REQUEST['pid'])	{
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
			wp_delete_attachment($_REQUEST['pid']);	
		}	
	} }else { get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
<!--  CONTENT AREA START -->

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $post_images = bdw_get_images($post->ID,'large'); ?>

<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
     </div>
    <div class="post-content">
      <?php endwhile; ?>
      <?php endif; ?>
      
       <div class="post-content">
    	 <?php the_content(); ?>
    </div>
     		
            
            <?php
         $years = $wpdb->get_results("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) as year
		FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post'   ORDER BY post_date DESC");
	if($years)
		{
			foreach($years as $years_obj)
			{
				$year = $years_obj->year;	
				$month = $years_obj->month;
				?>
                <?php query_posts("showposts=1000&year=$year&monthnum=$month"); ?>
           
         	<div class="arclist">  
                  <div class="arclist_head">
                   <h3><?php echo $year; ?>  </h3>
                   <h4> <?php echo  date('F', mktime(0,0,0,$month,1)); ?>  </h4>
           		 </div>
                 
           <ul >
          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        
          <li>  <a href="<?php the_permalink() ?>">
            <?php the_title(); ?>
            </a> <br />
            
            <span class="arclist_date">  <?php _e('by','templatic');?>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>"><?php the_author(); ?></a>
            
            <?php _e('on','templatic');?>  <?php the_time(__('M j, Y','templatic')) ?> // <?php comments_popup_link(__('No Comments','templatic'), __('1 Comment','templatic'), __('% Comments','templatic'), '', __('Comments Closed','templatic')); ?>
            </span>
           
           
            </li> 
          <?php endwhile; endif; ?> </ul></div>
                <?php
			}
		}
		 ?> 
      
     
    </div>
  </div>
</div>



<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); 
}

}?>