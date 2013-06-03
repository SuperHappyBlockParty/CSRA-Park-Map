<?php
/*
Template Name: Page - Contact Us
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
	} }else {
if($_POST)
{
	if($_POST['your-email'])
	{
		$toEmailName = get_option('blogname');
		$toEmail = get_site_emailId();
		
		$subject = $_POST['your-subject'];
		$message = '';
		$message .= '<p>'.DEAR.$toEmailName.',</p>';
		$message .= '<p>'.NAME.' : '.$_POST['your-name'].',</p>';
		$message .= '<p>'.EMAIL.' : '.$_POST['your-email'].',</p>';
		$message .= '<p>'.MESSAGE.' : '.nl2br($_POST['your-message']).'</p>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
		$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
		$headers .= 'From: '.$_POST['your-name'].' <'.$_POST['your-email'].'>' . "\r\n";
		
		// Mail it
		wp_mail($toEmail, $subject, $message, $headers);
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&msg=success'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?msg=success'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."';</script>";
	}
}
?>

<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
<!--  CONTENT AREA START -->

<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>
<!-- contact -->
<?php global $is_home; ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>

<div class="entry">

  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
  	
    <div class="post-meta">
	
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
     
    </div>
    <div class="post-content">
    
    		 <div class="google_map_contact"> 
				<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('contact_googlemap')){?><?php } else {?>  <?php }?>
            </div>
    
      <div class="contact_detail"><?php the_content(); ?></div>
    </div>
    
  </div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<?php
if($_REQUEST['msg'] == 'success')
{
?>
	<p class="success_msg">
	  <?php echo CONTACT_SUCCESS_TEXT;?>
	</p>
	<?php
}
?>
<form action="<?php echo get_permalink($post->ID);?>" method="post" id="contact_frm" name="contact_frm" class="wpcf7-form">
  <input type="hidden" name="request_url" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
  <div class="form_row ">
    <label>
      <?php echo NAME;?>
      <span class="indicates">*</span></label>
    <input type="text" name="your-name" id="your-name" value="" class="textfield" size="40" />
    <span id="your_name_Info" class="error"></span> </div>
  <div class="form_row ">
    <label>
      <?php echo EMAIL;?>
      <span class="indicates">*</span></label>
    <input type="text" name="your-email" id="your-email" value="" class="textfield" size="40" />
    <span id="your_emailInfo"  class="error"></span> </div>
  <div class="form_row ">
    <label>
      <?php echo SUBJECT;?>
      <span class="indicates">*</span></label>
    <input type="text" name="your-subject" id="your-subject" value="" size="40" class="textfield" />
    <span id="your_subjectInfo"></span> </div>
  <div class="form_row">
    <label>
      <?php echo MESSAGE;?>
      <span class="indicates">*</span></label>
    <textarea name="your-message" id="your-message" cols="40" class="textarea textarea2" rows="10"></textarea>
    <span id="your_messageInfo"  class="error"></span> </div>
  <input type="submit" value="<?php _e('Send','templatic'); ?>" class="b_submit" />
</form>

<script type="text/javascript">
var $c = jQuery.noConflict();
$c(document).ready(function(){

	//global vars
	var enquiryfrm = $c("#contact_frm");
	var your_name = $c("#your-name");
	var your_email = $c("#your-email");
	var your_subject = $c("#your-subject");
	var your_message = $c("#your-message");
	
	var your_name_Info = $c("#your_name_Info");
	var your_emailInfo = $c("#your_emailInfo");
	var your_subjectInfo = $c("#your_subjectInfo");
	var your_messageInfo = $c("#your_messageInfo");
	
	//On blur
	your_name.blur(validate_your_name);
	your_email.blur(validate_your_email);
	your_subject.blur(validate_your_subject);
	your_message.blur(validate_your_message);

	//On key press
	your_name.keyup(validate_your_name);
	your_email.keyup(validate_your_email);
	your_subject.keyup(validate_your_subject);
	your_message.keyup(validate_your_message);
	
	

	//On Submitting
	enquiryfrm.submit(function(){
		if(validate_your_name() & validate_your_email() & validate_your_subject() & validate_your_message())
		{
			hideform();
			return true
		}
		else
		{
			return false;
		}
	});

	//validation functions
	function validate_your_name()
	{
		
		if($c("#your-name").val() == '')
		{
			your_name.addClass("error");
			your_name_Info.text("<?php _e('Please enter your name','templatic'); ?>");
			your_name_Info.addClass("message_error");
			return false;
		}
		else
		{
			your_name.removeClass("error");
			your_name_Info.text("");
			your_name_Info.removeClass("message_error");
			return true;
		}
	}

	function validate_your_email()
	{
		var isvalidemailflag = 0;
		if($c("#your-email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($c("#your-email").val() != '')
		{
			var a = $c("#your-email").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		
		if(isvalidemailflag)
		{
			your_email.addClass("error");
			your_emailInfo.text("<?php _e('Please enter valid email address','templatic'); ?>");
			your_emailInfo.addClass("message_error");
			return false;
		}else
		{
			your_email.removeClass("error");
			your_emailInfo.text("");
			your_emailInfo.removeClass("message_error");
			return true;
		}
	}

	

	function validate_your_subject()
	{
		if($c("#your-subject").val() == '')
		{
			your_subject.addClass("error");
			your_subjectInfo.text("<?php _e('Please enter a subject','templatic'); ?>");
			your_subjectInfo.addClass("message_error");
			return false;
		}
		else{
			your_subject.removeClass("error");
			your_subjectInfo.text("");
			your_subjectInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_your_message()
	{
		if($c("#your-message").val() == '')
		{
			your_message.addClass("error");
			your_messageInfo.text(" <?php _e('Please enter your message','templatic'); ?> ");
			your_messageInfo.addClass("message_error");
			return false;
		}
		else{
			your_message.removeClass("error");
			your_messageInfo.text("");
			your_messageInfo.removeClass("message_error");
			return true;
		}
	}

});
</script>


<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer();
}
} ?>