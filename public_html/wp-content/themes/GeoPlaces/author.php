<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!--  CONTENT AREA START. -->
<?php
global $current_user,$wp_query,$site_url;
$qvar = $wp_query->query_vars;
$authname = $qvar['author_name'];

$curauth = get_userdata($qvar['author']);

if($curauth->ID == $current_user->ID) {
	
	$user_displayname = $curauth->display_name ;
	$dashboard_display = '<a href="'.get_author_posts_url($current_user->ID).'" class="back_link" >'.BACK_TO_DASHBOARD.'</a>';
} elseif($curauth->ID != $current_user->ID ){
	
	$user_displayname = $curauth->display_name;
}
$user_link = get_author_posts_url($curauth->ID);
if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
?>
<?php if ( get_option('ptthemes_breadcrumbs' ) == 'Yes' ) {  ?>
		<div class="breadcrumb clearfix">
			<div class="breadcrumb_in"><a href="<?php echo $site_url; ?>"><?php echo HOME; ?></a> &raquo; <?php _e($curauth->display_name,'templatic'); ?> </div>
		</div>
<?php } if($curauth->ID == $current_user->ID) {?>
<div class="content-title"> 
	 <h1><?php echo DASHBOARD;?></h1> <?php //  echo templ_page_title_filter( $curauth->display_name); //page tilte filter?> 
</div>
<?php } ?>
<?php //templ_page_title_below(); //page title below action hook?>

<div class="author_details">
    <div class="author_photo">
		
					<?php if($curauth->user_photo != '')  { ?>
			<img src="<?php echo $curauth->user_photo; ?>" width="75" height="75" />
			<?php } 
					else { echo get_avatar($curauth->ID, 75 ); }
				?>
    </div>
	<div class="author_content">
		<h3><?php echo $user_displayname;	?></h3>
		<p class="detail_links">
			<?php get_user_meta($curauth->ID,'user_fname',true). get_user_meta($curauth->ID,'user_lname',true); ?></a>
			<?php if($curauth->user_url != "" ) {?>
			<a href="<?php echo $curauth->user_url;?>" target="_blank"><?php _e('Visit website','templatic');?> </a>
			<?php } ?>
			<?php if(get_user_meta($curauth->ID,'user_twitter',true) != "" ) {?>
			<a href="<?php echo get_user_meta($curauth->ID,'user_twitter',true);?>" target="_blank"><?php _e('Twitter','templatic');?> </a>
			<?php } ?>
			<?php if(get_user_meta($curauth->ID,'user_facebook',true) != "" ) {?>
			<a href="<?php echo get_user_meta($curauth->ID,'user_facebook',true);?>" target="_blank"><?php _e('Facebook','templatic');?> </a>
			<?php } ?>
		</p>
		<ul class="user_detail">
			<li><?php _e(get_user_meta($curauth->ID,'description',true)); ?></li> 
			<?php echo templ_show_profile_fields($curauth->ID); ?>
		</ul>
    </div>
 </div>
<ul class="sort_by">
    	<li class="title"> <?php echo LISTING_TEXT;?>: </li>
		<?php if($curauth->ID == $current_user->ID) { ?>
       	<li class="<?php if($_REQUEST['list']==''){ echo 'current'; } ?>"> <a href="<?php echo get_author_posts_url($curauth->ID);?>">  <?php echo MY_SUBMISSION;?> </a></li>
       	<li class="<?php if($_REQUEST['list']=='favourite'){ echo 'current'; } ?>"> <a href="<?php echo $user_link; ?>">  <?php echo MY_FAVOURITE_TEXT;?> </a></li>
		<?php } else { ?>
			<li class="<?php if($_REQUEST['list']==''){ echo 'current'; } ?>"> <a href="<?php echo get_author_posts_url($curauth->ID);?>">  <?php _e('Submissions','templatic');?> </a></li>
		<?php }?>
		
     </ul>
<?php 
$request = str_replace("post_type = 'post'","post_type in ('".CUSTOM_POST_TYPE1."','".CUSTOM_POST_TYPE2."')",$request); 
	get_template_part('loop');
	?>
	 
<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>