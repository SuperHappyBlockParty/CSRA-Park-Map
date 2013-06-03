<?php get_header(); ?>
<div  class="<?php templ_content_css();?>" >
<!-- TITLE START -->
<div class="content-title">
  <?php ob_start(); // don't remove this code?>
   <?php if($_REQUEST['s']=='cal_event'){
					   global $wpdb,$wp_query;
						$m = $wp_query->query_vars['m'];
						$py = substr($m,0,4);
						$pm = substr($m,4,2);
						$pd = substr($m,6,2);
						$the_req_date = "$py-$pm-$pd";
					   ?>
    <h1><?php _e('Browsing Day','templatic');?> "<?php echo date('F jS, Y',strtotime($the_req_date)); ?>"</h1>
    <?php } else {
				   
   if($_REQUEST['catdrop']) echo SEARCH_CATEGORY_TITLE; elseif($_REQUEST['todate'] || $_REQUEST['frmdate']) echo SEARCH_DATE_TITLE; elseif($_REQUEST['articleauthor']) echo SEARCH_AUTHOR_TITLE; else SEARCH_TITLE;?>
  <?php  
        echo $page_title = get_search_query(); // don't remove this code
		ob_end_clean(); // don't remove this code
		
		 $page_title_near = $_REQUEST['sn'];
	?>
	<h1><?php 
	if($_REQUEST['sn'] ==""){
	 echo  sprintf(__('You search %s ','templatic'),$page_title);
  }else{
   	echo sprintf(__('You search %s near %s','templatic'),$page_title,$page_title_near);
  }?> </h1>
  <?php } 
  templ_page_title_above(); //page title above action hook
  templ_page_title_below(); //page title below action hook?>
</div>
<!-- TITLE ENd -->
<!--  CONTENT AREA START -->

<?php 
if ( have_posts() ) : ?>
<?php get_template_part('loop'); ?>
<?php else : ?>


<div class="entry">
  <div class="single clear">
    <div class="post-content">
       		<div class="searchbox">
				<form action="<?php echo home_url(); ?>  " id="searchform2" method="get">
					<fieldset>
						<input type="text" value="Search" onblur="if(this.value=='') this.value='Search';" onfocus="if(this.value=='Search') this.value='';" name="s" />
						<button type="submit"></button>
					</fieldset>
				</form>
			</div>
            <p><?php echo SEARCH_RESULT_NOT_FOUND; ?></p>
            
            
            <div class="arclist">
        <h3><?php echo ARCHIVE_TEXT;?></h3>
        <ul class="sitemap_list" >
          <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
        </ul>
      </div>
      <!--/arclist -->
      
      
      <div class="arclist">
        <h3><?php echo CATEGORY_TEXT;?></h3>
        <ul class="sitemap_list">
          <?php 
		  if(get_option('ptthemes_show_empty_category') == 'No'){ 
					$hide_empty = '1';
				} else {
					$hide_empty = '0';
				}
		  wp_list_categories("title_li=&hierarchical=0&show_count=1&hide_empty=$hide_empty") ?>
        </ul>
      </div>
      <!--/arclist -->
            
     </div>
  </div>
</div>
<?php endif; ?>


<!--  CONTENT AREA END -->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>