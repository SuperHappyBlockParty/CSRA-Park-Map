<?php
/*
Template Name: Page - Sitemap for event
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>


<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
			 <div class="content-title">
      
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php // templ_page_title_above(); //page title above action hook?>
      <?php templ_page_title_below(); //page title below action hook?>
     </div>
<!--  CONTENT AREA START -->


<div class="entry">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    
    <div class="post-content">
    
    <?php the_content(); ?>
    
      <div class="arclist">
        <h3><?php echo PAGE_TEXT;?></h3>
        <ul class="sitemap_list">
          <?php wp_list_pages('title_li='); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <h3><?php echo POST_TEXT;?></h3>
        <ul class="sitemap_list">
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
      <!--/arclist -->
      <div class="arclist">
        <h3><?php echo ARCHIVE_TEXT;?></h3>
        <ul class="sitemap_list">
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <h3><?php echo CATGORIES_TEXT;?></h3>
        <ul class="sitemap_list">
          <?php  if(get_option('ptthemes_show_empty_category') == 'No'){ 
					$hide_empty = '1';
				} else {
					$hide_empty = '0';
				}
			wp_list_categories("title_li=&hierarchical=0&show_count=1&hide_empty=$hide_empty&taxonomy=".CUSTOM_CATEGORY_TYPE2); 
			wp_list_categories("title_li=&hierarchical=0&show_count=1&hide_empty=$hide_empty&taxonomy=".CUSTOM_CATEGORY_TYPE1);
			wp_list_categories("title_li=&hierarchical=0&show_count=1&hide_empty=$hide_empty"); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <h3><?php echo META_TEXT;?></h3>
        <ul class="sitemap_list">
          <li><a href="<?php echo get_bloginfo('rdf_url'); ?>" title="<?php echo RDF_RSS.' '.ONE_FEED;?>"><?php echo RDF_RSS.' '.ONE_FEED;?></a></li>
          <li><a href="<?php echo get_bloginfo('rss_url'); ?>" title="<?php echo RSS_TEXT.' '.POINT_FEED;?>"><?php echo RSS_TEXT.' '.POINT_FEED;?></a></li>
          <li><a href="<?php echo get_bloginfo('rss2_url'); ?>" title="<?php echo RSS_TEXT.' '.TWO_FEED;?>"><?php echo RSS_TEXT.' '.TWO_FEED;?></a></li>
          <li><a href="<?php echo get_bloginfo('atom_url'); ?>" title="<?php echo ATOM_FEED;?>"><?php echo ATOM_FEED;?></a></li>
        </ul>
      </div>
      <!--/arclist -->
    </div>
     
  </div>
</div>
<?php endwhile; ?>
<?php endif; ?>


<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>