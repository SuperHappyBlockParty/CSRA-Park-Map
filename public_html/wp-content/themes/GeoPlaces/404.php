<?php get_header(); ?>
<div class="content content_full">
	<!--  CONTENT AREA START -->
	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>
	<div class="content-title"><?php echo templ_page_title_filter(__("404! We couldn't find the page!",'templatic')); //page tilte filter?></div>
	<div class="entry">
		<div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
			<div class="post-content page_404_set">
				<p>
					<?php _e("The page you are looking for does not exist. It appears you've missed your intended destination, either through a bad or outdated link, or a typo in the page you were hoping to reach.",'templatic');?>
				</p>
			<div class="error_404">
				<div class="head_error"><?php _e('404 Error!','templatic');?></div>
				<p> <?php _e('404 Error the page that you are looking for does not exist go back. friend, go back','templatic');?> </p>
        </div>
        <div class="two_thirds  left ">
          <?php include_once('searchform.php'); // search form ?>
        </div>
        <div class="spacer_404"></div>
        <div class="one_third_column left">
          <h3>
            <?php _e('Pages','templatic');?>
          </h3>
          <ul>
            <?php wp_list_pages('title_li='); ?>
          </ul>
        </div>
        <div class="one_third_column left">
          <h3>
            <?php _e('Posts','templatic');?>
          </h3>
          <ul>
            <?php $archive_query = new WP_Query('showposts=60');
            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
              <?php the_title(); ?>
              </a> <span class="arclist_comment">
              <?php comments_number(__('0 comment','templatic'), __('1 comment','templatic'),__('% comments','templatic')); ?>
              </span></li>
            <?php endwhile; ?>
          </ul>
        </div>
        <div class="one_third_column_last right">
          
            <h3>
              <?php _e('Categories','templatic');?>
            </h3>
            <ul>
              <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
            </ul>
           
          <h3>
            <?php _e('Archives','templatic');?>
          </h3>
          <ul>
            <?php wp_get_archives('type=monthly'); ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--  CONTENT AREA END -->
</div>
<?php get_footer(); ?>
