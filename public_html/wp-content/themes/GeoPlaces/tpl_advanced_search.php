<?php
/*
Template Name: Page - Advanced Search
*/
?>
<?php
add_action('wp_head','templ_header_tpl_advsearch');
function templ_header_tpl_advsearch()
{
	?>
	<script type="text/javascript" language="javascript">var rootfolderpath = '<?php echo get_bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
    <?php
}
?>
<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb clearfix">
               
                	<div class="breadcrumb_in"><?php yoast_breadcrumb('','');  ?></div>
               
             </div><?php } ?>
<!--  CONTENT AREA START -->

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
      <?php endwhile; ?>
      <?php endif; ?>
      
        <div class="post-content">
    	 <?php the_content(); ?>
    </div>
      
      
      <div id="advancedsearch">
        <h4> <?php echo SEARCH_WEBSITE; ?></h4>
        <form method="get"  action="<?php echo bloginfo('url')."/"; ?>" name="searchform" onsubmit="return sformcheck();">
          <div class="advanced_left">
           <p> <label><?php echo SEARCH;?></label>
              <input class="adv_input" name="s" id="adv_s" type="text" PLACEHOLDER="<?php echo SEARCH; ?>" value="" />
			  <input class="adv_input" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </p> 
			<p> <label><?php echo TAG_SEARCG_TEXT;?></label>
              <input class="adv_input" name="tag_s" id="tag_s" type="text"  PLACEHOLDER="<?php echo TAG_SEARCG_TEXT; ?>" value=""  />
			  <input class="adv_input" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </p>
            <p> <label><?php echo CATEGORY;?></label>
         
              <?php wp_dropdown_categories( array('name' => 'catdrop','orderby'=> 'name','show_option_all' => __('select category','templatic'), 'taxonomy'=>array(CUSTOM_CATEGORY_TYPE1,CUSTOM_CATEGORY_TYPE2)) ); ?>
            </p>
            <p>
              <label><?php echo DATE_TEXT;?></label>
                <input name="todate" type="text" class="textfield" />
                <img src="<?php echo get_bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" class="adv_calendar" onclick="displayCalendar(document.searchform.todate,'yyyy-mm-dd',this)"  />
				<?php echo TO;?> 
                <input name="frmdate" type="text" class="textfield"  />
                <img src="<?php echo get_bloginfo('template_directory');?>/images/cal.gif" alt="Calendar"  class="adv_calendar" onclick="displayCalendar(document.searchform.frmdate,'yyyy-mm-dd',this)"  />
            </p>
            <p>
              <label><?php echo AUTHOR_TEXT;?> </label>
                <input name="articleauthor" type="text" class="textfield"  />
                <span class="adv_author">
                <?php echo EXACT_AUTHOR_TEXT;?>
                </span>
                <input name="exactyes" type="checkbox" value="1" class="checkbox" />
			</p>
			<?php 
			$post_types = "'place','event'";
			$custom_metaboxes = get_post_custom_fields_templ($post_types,'0','user_side','1');
			search_custom_post_field($custom_metaboxes); ?>
            
          </div>
          <input type="submit" value="Submit" class="adv_submit" />
        </form>
      </div>
    </div>
  </div>
</div>


<!--  CONTENT AREA END -->
</div>
<script type="text/javascript" >
function sformcheck()
{
if(document.getElementById('adv_s').value=="")
{
	alert('<?php echo SEARCH_ALERT_MSG;?>');
	document.getElementById('adv_s').focus();
	return false;
}
if(document.getElementById('adv_s').value=='<?php echo SEARCH;?>')
{
document.getElementById('adv_s').value = ' ';
}
return true;
}
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>