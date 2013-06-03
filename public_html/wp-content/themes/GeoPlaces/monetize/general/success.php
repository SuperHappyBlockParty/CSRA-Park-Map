<?php 
$order_id = $_REQUEST['pid'];
if($_REQUEST['renew'])
{
	$page_title = RENEW_SUCCESS_TITLE;
}else
{
	$page_title = POSTED_SUCCESS_TITLE;
}

global $page_title,$site_url;?>
<?php get_header(); ?>
<?php 

$paymentmethod = get_post_meta($_REQUEST['pid'],'paymentmethod',true);
$paid_amount = display_amount_with_currency(get_post_meta($_REQUEST['pid'],'paid_amount',true));
global $upload_folder_path;
if($paymentmethod == 'prebanktransfer')
{
	$filecontent = stripslashes(get_option('post_pre_bank_trasfer_msg_content'));
	if(!$filecontent)	{
		$filecontent = POSTED_SUCCESS_PREBANK_MSG;
	}
}else
{
	$filecontent = stripslashes(get_option('post_added_success_msg_content'));
	if(!$filecontent)
	{
		$filecontent = POSTED_SUCCESS_MSG;
	}
}
?>
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes' ) {  ?>
<div class="breadcrumb_in"><a href="<?php echo $site_url; ?>"><?php _e('Home','templatic'); ?></a> &raquo; <?php echo $page_title; ?></div><?php } ?>
<?php if(get_post_type($order_id) == CUSTOM_POST_TYPE1) { ?>
 <div class="steps">
        		<span ><?php _e(ENTER_PLACE,'templatic'); ?></span>
            <span ><?php _e(PREVIEW_PLACE,'templatic'); ?></span>
            <span  class="current"><?php _e(SUCCESS_PLACE,'templatic'); ?></span>
        </div> 
<?php } else { ?>
	<div class="steps">
        	<span><?php _e(ENTER_EVENT,'templatic'); ?></span>
            <span><?php _e(PREVIEW_EVENT,'templatic'); ?></span>
            <span  class="current"><?php _e(SUCCESS_EVENT,'templatic'); ?></span>
        </div>
<?php } ?>

<div class="content-title"><?php echo $page_title; ?></div>
 <div  class="<?php templ_content_css();?>" >
	
	    <div class="post-content">
 
<?php

if(strtolower(get_option('ptthemes_listing_new_status'))=='publish')
{
	$post_link = get_permalink($_REQUEST['pid']);
}else {
	$post_link = get_option('home').'/?ptype=preview&alook=1&pid='.$_REQUEST['pid'];	
}

$store_name = get_option('blogname');
if($paymentmethod == 'prebanktransfer')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_name='payment_method_".$paymentmethod."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	$paymentInfo = unserialize($paymentupdinfo[0]->option_value);
	$payOpts = $paymentInfo['payOpts'];
	$bankInfo = $payOpts[0]['value'];
	$accountinfo = $payOpts[1]['value'];
	
}

if(($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary') && get_post_status( $_REQUEST['pid'] ) == 'draft')
	$post_link = get_option('home').'/?ptype=preview&alook=1&pid='.$_REQUEST['pid'];
$buyer_information = "";
								global $custom_post_meta_db_table_name;
								$post = get_post($_REQUEST['pid']);
								$address = stripslashes(get_post_meta($post->ID,'geo_address',true));
								$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
								$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
								$contact = stripslashes(get_post_meta($post->ID,'contact',true));
								$email = get_post_meta($post->ID,'email',true);
								$website = get_post_meta($post->ID,'website',true);
								$twitter = get_post_meta($post->ID,'twitter',true);
								$facebook = get_post_meta($post->ID,'facebook',true);
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='".CUSTOM_POST_TYPE2."' or post_type='both') ";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,admin_title asc";
				$post_meta_info = $wpdb->get_results($sql);
				$buyer_information .= "<b>".$post->post_title."</b>";
				$buyer_information .= $post->post_content;
				if($address) {  
							$buyer_information .="<p> <span class='i_location'>".ADDRESS." :" ."</span> ". get_post_meta($post->ID,'geo_address',true)."  </p> "; 
							} 
				
				foreach($post_meta_info as $post_meta_info_obj){ 
					
					if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
						if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing")
						{
							 
							
						
							$buyer_information .= "<div class='i_customlable'><span class='i_lbl'>".$post_meta_info_obj->site_title." :"."</span>";
							$buyer_information  .="<div class='i_customtext'>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div></div>";
						}
					 }		
		} 
         
							
							



$orderId = $_REQUEST['pid'];

$search_array = array('[#order_amt#]','[#bank_name#]','[#account_number#]','[#orderId#]','[#site_name#]','[#submited_information_link#]','[#submited_information#]');
$replace_array = array($paid_amount,$bankInfo,$accountinfo,$order_id,$store_name,$post_link,$buyer_information);
$filecontent = str_replace($search_array,$replace_array,$filecontent); 
echo $filecontent;

?> 
</div> <!-- content #end -->
</div> 
<div id="sidebar">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>