<?php 
global $wpdb,$post;
if(!isset($_REQUEST['etype'])) {
			@$_REQUEST['etype'] == 'all';
}
get_header(); ?>
<?php 
if(get_option('ptthemes_category_map_event') == 'yes' || get_option('ptthemes_category_map_event') == ''){
	if(file_exists(get_template_directory() . '/library/map/category_listing_map.php')){
		include_once (get_template_directory() . '/library/map/category_listing_map.php');
	}
	$map_display_category = 'no';
	global $map_display_category;
}  else {
	$map_display_category = 'yes';
	global $map_display_category;
}
	global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();	
	$category_link = get_term_link( $current_term->slug, CUSTOM_CATEGORY_TYPE2 );
	if( $current_term->name){
		$ptitle = $current_term->name; 
	}	?>
<?php templ_page_title_above(); //page title above action hook?>
<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {?>
 <div class="breadcrumb clearfix">
				<?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
            <?php } ?>
            </div>
			<?php } ?>
<div class="content-title">
  <?php 
		echo templ_page_title_filter($ptitle); //page tilte filter
	?>
</div>

<?php $category_id = '';if (category_description( $category_id ) != null) {?> <div class="cat_desc"><?php echo _e(category_description(),'templatic'); ?> </div><?php } ?>

<?php templ_page_title_below(); //page title below action hook 
$deptID = $current_term->term_id;
if(isset($deptID) && $deptID !=""){
$childCatID = $wpdb->get_col("SELECT term_id FROM $wpdb->term_taxonomy WHERE parent=$deptID");
if ($childCatID){
	echo '<div class="subcate_list">';
	foreach ($childCatID as $kid) {
		$childCatName = $wpdb->get_row("SELECT name, term_id,slug FROM $wpdb->terms WHERE term_id=$kid");
		$cat_link = get_term_link($childCatName->slug, CUSTOM_CATEGORY_TYPE2);
		?>
		<a href="<?php echo $cat_link; ?>"><?php echo $childCatName->name; ?></a>
		<?php
	}
	echo '</div>';
}
}
$category_main_link = get_term_link($current_term->slug, CUSTOM_CATEGORY_TYPE2);
?>
<ul class="sort_by">
    	<li class="title"> <?php _e('Events','templatic');?> :</li>
			<li class="<?php if(@$_REQUEST['etype']==''){ echo 'current'; }?>"> <a href="<?php echo $category_main_link; ?>">  <?php echo ALL_TEXT; ?> </a></li>
			<li class="<?php if(@$_REQUEST['etype']=='upcoming'){ echo 'current';}?>"> <a href="<?php if(strstr($category_main_link,'?')){ echo $cat_url = $category_main_link."&amp;etype=upcoming";}else{ echo $cat_url = $category_main_link."?etype=upcoming";}?>">  <?php _e('Upcoming','templatic');?> </a></li>
			<li class="<?php if(@$_REQUEST['etype']=='past'){ echo 'current'; }?>"> <a href="<?php if(strstr($category_main_link,'?')){ echo $cat_url = $category_main_link."&amp;etype=past"; }else{ echo $cat_url = $category_main_link."?etype=past";}?>">  <?php _e('Past','templatic');?> </a></li>
         
           <li class="i_next"> <?php next_posts_link(__(NEXT_TITLE)) ?>  </li>
            <li class="i_previous"><?php previous_posts_link(__(PREVIOUS)) ?> </li>
     </ul>
<?php templ_before_loop(); // before loop hooks
global $wp_query; 
?>
<?php if ( have_posts() ) : ?>
<div id="loop" class="<?php if (get_option('ptthemes_cat_listing')=='Grid'){ echo 'grid'; }  else { echo 'list clear work_list'; }?> ">

<?php 
	$pcount=0; 
	while ( have_posts() ) : the_post(); 
	
	$post_images =  bdw_get_images_with_info($post->ID,'thumb');   
	$attachment_id = $post_images[0]['id'];
	$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
	$attach_data = get_post($attachment_id);
	$title = $attach_data->post_title;
	$width = get_option('thumbnail_size_w');
	$height = get_option('thumbnail_size_h');
	$is_crop = get_option('thumbnail_crop');
	if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
	if($title ==''){ $title = $post->post_title; }
	if($alt ==''){ $alt = $post->post_title; }
	
	$pcount++;	
	
	?>
  <div  id="post_<?php the_ID(); ?>" <?php if(get_post_meta($post->ID,'is_featured',true) == 1 && (get_post_meta($post->ID,'featured_type',true) =="c" || get_post_meta($post->ID,'featured_type',true) =="both" )){ post_class('post featured_post');} else { post_class('post');}?>>
  
    <?php templ_before_loop_post_content(); // before loop post content hooks?>
    
    <!--  Post Content Condition for Post Format-->
    <?php if ( has_post_format( 'chat' )){?>
    
    <div class="post-content">
      <?php the_excerpt()?>
    </div>
    
    <?php }elseif(has_post_format( 'gallery' )){?>
    
    <div class="post-content">
	
    <?php 			
	
	if(get_post_meta($post->ID,'is_featured',true) == 1 && (get_post_meta($post->ID,'featured_type',true) =="c" || get_post_meta($post->ID,'featured_type',true) =="both" )){ ?> <span class="featured_strip"></span> <?php } 
      	if($post_images[0]['file']){  
				$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );
					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php $alt; ?>" title="<?php echo $title; ?>"  /> </a>
		<?php 	}else{ ?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php echo IMAGE_NOT_AVAILABLE_TEXT;?> </a>

		<?php } 
	?>
    </div>
    
     <?php }elseif(has_post_format( 'image' )){?>
     
     <div class="post-content">
      <?php 
        if($post_images[0]['file']){  
				$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );
					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php $alt; ?>" title="<?php echo $title; ?>"  /> </a>
		<?php 	}else{ ?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php echo IMAGE_NOT_AVAILABLE_TEXT;?> </a>

		<?php } ?>
      <?php the_excerpt()?>
    </div>
    
     <?php }elseif(has_post_format( 'link' )){?>
     
      <div class="post-content">
      <?php the_excerpt()?>
      </div>
      
     <?php }elseif(has_post_format( 'video' )){?>
     
     <div class="post-content">
      <?php the_excerpt()?>
      </div>
      
     <?php }elseif(has_post_format( 'audio' )){?>
     
     <div class="post-content">
     
      <?php the_excerpt()?>
      </div>
      
     <?php }elseif(has_post_format( 'quote' )){?> 
     
     <div class="post-content">
      <?php the_excerpt()?>
      </div>
      
     <?php }elseif(has_post_format( 'status' )){?> 
     
     <div class="post-content">
      <?php the_excerpt()?>
      </div>
      
      <?php }else{?>
      
       <div class="post-content ">
	   <?php if(get_post_meta($post->ID,'is_featured',true) == 1 && (get_post_meta($post->ID,'featured_type',true) =="c" || get_post_meta($post->ID,'featured_type',true) =="both")){?>
       <span class="featured_img"><?php _e('featured','templatic');?></span>
	   <?php } 
		if($post_images[0]['file']){  
				$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );
					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
		<?php 	}else{ ?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php echo IMAGE_NOT_AVAILABLE_TEXT;?> </a>

		<?php } ?>
            
            <div class="post_content">
         			<!--  Post Title Condition for Post Format-->
    <?php if ( has_post_format( 'chat' )){?>
    <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
     <?php }elseif(has_post_format( 'gallery' )){?>
      <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
     <?php }elseif(has_post_format( 'image' )){?>
       <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
     <?php }elseif(has_post_format( 'link' )){?>
       <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
     <?php }elseif(has_post_format( 'video' )){?>
       <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
     <?php }elseif(has_post_format( 'audio' )){?>
       <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
       <?php }else{?>
       <h2><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></h2>
       <?php }?>
     <!--  Post Title Condition for Post Format-->
				 <div class="post-meta listing_meta">
							<?php if(templ_is_show_listing_author()){ ?>
							<?php _e('By','templatic');?> <span class="post-author"> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>">
							<?php the_author(); ?>
							</a> </span>
							<?php }  ?>
							<?php if(templ_is_show_listing_date()){?>
							<?php _e('on','templatic');?> <span class="post-date">
							<?php the_time(templ_get_date_format()) ?>
							</span>
							<?php } 
							if(templ_is_show_listing_views()){
							echo '<span class="post-total-view"> '.VIEW_LIST_TEXT.": ".user_post_visit_count($post->ID).'</span>';
							echo '<span class="post-daily-view"> '.VIEW_LIST_TEXT_DAILY.": ".user_post_visit_count_daily($post->ID).'</span>';
							}
							if(get_post_format( $post->ID )){
							$format = get_post_format( $post->ID );
									?>
								<em>&bull; </em> <a href="<?php echo get_post_format_link($format); ?>" title="<?php esc_attr_e( VIEW_TEXT . $format, 'templatic' ); ?>">
								<?php _e( MORE_TEXT . $format, 'templatic' ); ?>
								</a>
							<?php } ?>
				</div>
	 
		<?php 
				/* display event timing */
				$st_date = date('M d, Y',strtotime(get_post_meta($post->ID,'st_date',true)));
				$end_date = date('M d, Y',strtotime(get_post_meta($post->ID,'end_date',true)));
				if($end_date && $st_date && strtotime(get_post_meta($post->ID,'st_date',true)) < strtotime(get_post_meta($post->ID,'end_date',true))){	 /* if st date and end date both are set */
					$event_date = date('M d, Y',strtotime(get_post_meta($post->ID,'st_date',true))).__(' to ','templatic').date('M d, Y',strtotime(get_post_meta($post->ID,'end_date',true)));
				}else if(($st_date && !$end_date) || (strtotime(get_post_meta($post->ID,'st_date',true)) == strtotime(get_post_meta($post->ID,'end_date',true)))){ /* if only st date is set or st date is less the or equal to end date*/
					$event_date = date('M d, Y',strtotime(get_post_meta($post->ID,'st_date',true)));				
				}else{
					$event_date = date('M d, Y',strtotime(get_post_meta($post->ID,'st_date',true))).__(' to ','templatic').date('M d, Y',strtotime(get_post_meta($post->ID,'end_date',true)));
				}
				if (get_option('ptthemes_cat_listing')=='Listing'){ ?>
					
				<p class="timing"> <span><?php _e('Date','templatic');?>:</span> <?php echo $event_date; ?><br> <span><?php _e('Timing','templatic');?>:</span> <?php echo get_post_meta($post->ID,'st_time',true).__(' to ','templatic').get_post_meta($post->ID,'end_time',true);?> </p>
				
				
				
                <?php if(get_post_meta($post->ID,'geo_address',true) != '') { echo '<p class="address"><span>'.LOCATION.'</span> '.get_post_meta($post->ID,'geo_address',true).'</p>'; } ?>
				<?php echo get_post_custom_for_listing_page($post->ID,'<p><span>{#TITLE#} : </span>{#VALUE#}</p>','',CUSTOM_POST_TYPE2);?>
				<?php  echo '<p>';
					 echo templ_listing_content($post);
					  echo '</p>'; ?>
				<?php }
				else{ ?>
					
					<p class="timing"> <span><?php _e('Date','templatic');?>:</span> <?php echo $event_date; ?><br> <span><?php _e('Timing','templatic');?>: </span> <?php echo get_post_meta($post->ID,'st_time',true).__(' to ','templatic').get_post_meta($post->ID,'end_time',true); ?> </p>
					<span class="rating"><?php echo get_post_rating_star($post->ID);?></span>
					
                   
				<?php if(get_post_meta($post->ID,'geo_address',true) != '') { echo '<p class="address"><span>'.LOCATION.'</span> '.get_post_meta($post->ID,'geo_address',true).'</p>'; } ?>
				<?php echo get_post_custom_for_listing_page($post->ID,'<p><span>{#TITLE#}: </span>{#VALUE#}</p>','',CUSTOM_POST_TYPE2);?>
				<?php echo '<p>';
							echo excerpt(get_option('ptthemes_content_excerpt_count'));
					  echo '</p>';
						/* display categories of the post if show on listing enable */
						if(templ_is_show_listing_category()){
							templ_wp_categories_listing($post->ID ,CUSTOM_CATEGORY_TYPE2);
						}
						/* display tags of the post if show on listing enable */
						echo "&nbsp;";
						if(templ_is_show_listing_tags()){
							templ_wp_tags_listing($post->ID ,CUSTOM_TAG_TYPE2);
						}		
						if(get_post_meta($post->ID,'geo_address',true) != '') { ?>
							<span class="ping"><a href="#map_canvas" id="pinpoint_<?php echo $post->ID; ?>"><?php _e('Pinpoint','templatic');?></a></span> <?php } ?>
						<?php favourite_html($post->post_author,$post->ID); 
						if(trim(get_option('ptthemes_listing_comment')) == trim('Yes') || !get_option('ptthemes_listing_comment') ){
						?>
						<p class="review clearfix">    
							<a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number(__('0','templatic'), __('1','templatic'), __('%','templatic')); ?> </a>
							<span class="readmore"> <a href="<?php the_permalink(); ?>"><?php echo READ_MORE_LABEL; ?> </a> </span>
						</p>
				<?php	}
				}
						
				?>
	 
        </div>
		<?php if (get_option('ptthemes_cat_listing')=='Listing'){ ?>
		 <div class="post_right">
					<?php if(get_option('default_comment_status') == 'open'){ ?>
					<a href="<?php the_permalink(); ?>#comments" class="pcomments" ><?php comments_number(__('0 '.REVIEWS.'','templatic'), __('1 '.REVIEW.'','templatic'), __('% '.REVIEWS.'','templatic')); ?> </a>
					<?php } ?>
					<?php if(get_option('ptthemes_disable_rating') == 'no') { 	?>	
					<span class="rating"><?php echo get_post_rating_star($post->ID);?></span>
					<?php }				
							if(get_post_meta($post->ID,'geo_address',true) != '') { ?>
							<a href="#map_canvas"  class="ping" id="pinpoint_<?php echo $post->ID; ?>"><?php _e('Pinpoint','templatic');?></a> <?php } ?>
							<?php favourite_html($post->post_author,$post->ID); ?>
                   
		 </div>
		 <?php } ?>
     </div>
      <?php }?>  
    <!--  Post Content Condition for Post Format-->
     <?php templ_after_loop_post_content(); // after loop post content hooks?>
  </div>
        <?php 
		$page_layout = templ_get_page_layout();
		if($page_layout=='full_width'){
					if($pcount==4){
					$pcount=0; 
					?>
                 		<div class="hr clearfix"></div>
                <?php } }
				else if(($page_layout=='3_col_fix' ) || ($page_layout=='3_col_right') ||( $page_layout=='3_col_left')){
					if($pcount==2){
					$pcount=0; 
					?>
                 		<div class="hr clearfix"></div>
                <?php }
				}
				else if ($pcount==3){
					$pcount=0; 
					?>
                <div class="hr clearfix"></div>
                <?php }?>
        
  <?php endwhile; ?>
</div>
<?php else : ?>	
<?php echo NO_EVENT_TEXT;?>
<?php endif; ?>
  <div class="pagination">
   <!-- ADD Custom Numbered Pagination code. -->
   <?php if(function_exists('pagenavi')) { pagenavi(); } ?>
  </div>
<?php templ_after_loop(); // after loop hooks?>


<!--  CONTENT AREA END -->
</div>
<?php include_once ('library/includes/sidebar_event_listing.php'); ?>
<?php get_footer(); ?>