<?php get_header(); ?>
<?php
if($_SERVER['HTTP_REFERER'] == '' || !strstr($_SERVER['HTTP_REFERER'],$_SERVER['REQUEST_URI']))
{
$viewed_count = get_post_meta($post->ID,'viewed_count',true);
$viewed_count_daily = get_post_meta($post->ID,'viewed_count_daily',true);
$daily_date = get_post_meta($post->ID,'daily_date',true);

update_post_meta($post->ID,'viewed_count',$viewed_count+1);

if(get_post_meta($post->ID,'daily_date',true) == date('Y-m-d')){
	update_post_meta($post->ID,'viewed_count_daily',$viewed_count_daily+1);
} else {
	update_post_meta($post->ID,'viewed_count_daily','0');
}
update_post_meta($post->ID,'daily_date',date('Y-m-d'));
}
?>
<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?>
    <div class="breadcrumb clearfix">
               
        <div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
    </div><?php } ?>
<!--  CONTENT AREA START. -->
	<?php templ_before_single_entry(); // before single entry  hooks?>
    <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="entry">
      <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
        <div class="post-meta listing_meta">
          <?php //templ_page_title_above(); //page title above action hook?>
          <?php // echo templ_page_title_filter(get_the_title()); //page tilte filter?>
          
            <!--  Post Title Condition for Post Format-->
            <?php if ( has_post_format( 'chat' )){?>
            
             <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
             
            <?php }elseif(has_post_format( 'gallery' )){?>
            
            <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
            
            <?php }elseif(has_post_format( 'image' )){?>
            
           <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
           
            <?php }elseif(has_post_format( 'link' )){?>
            
           <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
           
           <?php }elseif(has_post_format( 'video' )){?>
            
           <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
             
            <?php }elseif(has_post_format( 'audio' )){?>
            
             <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
             
            <?php }else{?>
            
            <?php  echo templ_page_title_filter(get_the_title()); //page title filter?>
            
            <?php }?>
            <!--  Post Title Condition for Post Format-->
            
          <?php templ_page_title_below(); //page title below action hook?>
          <?php if(templ_is_show_post_author()){?>
          <span class="post-author"><label> <?php echo By ;?> </label>  <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>">
          <?php the_author(); ?>
          </a> </span>
          <?php } ?>
          <?php if(templ_is_show_post_date()){?>
          <span class="post-date">
		  <label><?php echo on ;?></label> 
          <?php the_time(get_option('date_format')) ?>
          </span>
          <?php } 
			if(templ_is_show_listing_views()){
			echo '<span class="post-total-view">'. VIEW_LIST_TEXT.": ". user_post_visit_count($post->ID).'</span>';
			echo '&nbsp; <span class="post-daily-view">'.VIEW_LIST_TEXT_DAILY.": ".user_post_visit_count_daily($post->ID).'</span>&nbsp;';
			}
			
			if(templ_is_show_post_comment()){
				comments_popup_link(__('No Comments','templatic'), __('1 Comment','templatic'), __('% Comments','templatic'), '', __('Comments Closed','templatic'));
			} ?>
          
            
            
		<?php if(get_post_format( $post->ID )){
        $format = get_post_format( $post->ID );
        ?>
       
        <a href="<?php echo get_post_format_link($format); ?>" title="<?php esc_attr_e( 'View '. $format, 'templatic' ); ?>"><?php _e( 'More '. $format, 'templatic' ); ?></a>
        <?php } ?>
         
               
        </div>
        
       
 
        <?php templ_before_single_post_content(); // BEFORE  single post content  hooks?>
        
        <!--  Post Content Condition for Post Format-->
        <?php if ( has_post_format( 'chat' )){?>
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'gallery' )){?>
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'image' )){?>
        
        <div class="post-content">
        
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'link' )){?>
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'video' )){?>
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'audio' )){?>
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'quote' )){?> 
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }elseif(has_post_format( 'status' )){?> 
        
        <div class="post-content">
        <?php the_content(); ?>
        </div>
        
        <?php }else{?>
        
        <div class="post-content">
        <?php the_content(); ?>
        
        
        
      
        </div>
        
        <?php }?>  
        <!--  Post Content Condition for Post Format-->
        
        <?php templ_after_single_post_content(); // after single post content hooks?>
        
        
         <!-- twitter & facebook likethis option-->
        <?php 
            templ_show_twitter_button();
            templ_show_facebook_button();
        ?>  <!--#end -->
         <div class="googleplus">
	   <!-- Place this tag where you want the +1 button to render -->
		<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
		<!-- Place this render call where appropriate -->
				<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
	   </div>
        
        <div class="post_bottom">
        	 <?php if(templ_is_show_post_tags()){?>
           <?php the_tags('<span class="post-tags">', ', ', '</span>'); ?>
          <?php } ?>
          <?php if(templ_is_show_post_category()){?>
          	<span class="post-category" ><?php the_category(' <span>/</span> '); ?></span>
          <?php } ?>
        </div>
        
      
      </div>
	  
      <div class="post-navigation clear">
        <?php
            $prev_post = get_adjacent_post(false, '', true);
            $next_post = get_adjacent_post(false, '', false); ?>
        <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); $prev_post_title = $prev_post->post_title; ?>
        <a class="post-prev" href="<?php echo $prev_post_url; ?>"><em><?php _e('Previous post','templatic');?></em><span><?php echo $prev_post_title; ?></span></a>
        <?php endif; ?>
        <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); $next_post_title = $next_post->post_title; ?>
        <a class="post-next" href="<?php echo $next_post_url; ?>"><em><?php _e('Next post','templatic');?></em><span><?php echo $next_post_title; ?></span></a>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
    <?php endif; ?>	
     <?php templ_after_single_entry(); // after single entry  hooks?>
    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('single_post_below'); }?>
	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('blog_detail_content_banner'); } ?>
    <?php comments_template(); ?>

<!--  CONTENT AREA END -->    
</div>
<?php include_once ('library/includes/sidebar_blog_detail.php'); ?>
<?php get_footer(); ?>