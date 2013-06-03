<?php
/*
Template Name: Page - Left Sidebar
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<!-- Content  2 column - Right Sidebar is here -->
<div class="content right">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
  <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>
  <div class="entry">
  
  <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
    </div>
  
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
      <div class="post-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</div>
<!-- /Content -->
<?php endwhile; ?>
<?php endif; ?>
<div class="sidebar left" >
  <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('sidebar1');}?>
</div>
<!-- sidebar #end -->
<!--Page 2 column - Right Sidebar #end  -->
<?php get_footer(); ?>
