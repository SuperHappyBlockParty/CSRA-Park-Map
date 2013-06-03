<?php
// Register widgetized areas
if ( function_exists('register_sidebar') ) {
	$sidebar_widget_arr = array();
	
///-----------------------------------------------------------------
	  //  ABOVE HEADER WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['top_navigation'] =array(1,array('name' => __('Above Header','templatic'), 'description' => 'This region is located above the header. Usually, a primary navigation menu goes here.', 'id' => 'top_navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  HEADER SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['header_logo_right_side'] =array(1,array('name' => __('Header: Right area','templatic'),'description' => 'The rightmost section alongside the logo. A search box or a login form can go here.','id' => 'header_logo_right_side','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  BELOW HEADER WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['main_navigation'] =array(1,array('name' => __('Below Header','templatic'), 'description' => 'This region is located below the header. You can put a secondary navigation menu here.', 'id' => 'main_navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  HOMEPAGE ABOVE FOLD SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['home_slider'] =array(1,array('name' => __('Homepage: Above Fold','templatic'), 'description' => 'This region appears only on homepage, just above the fold. You can put a slider or an introductory text widget here.', 'id' => 'home_slider','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
		
///-----------------------------------------------------------------
	  //  SINGLE POST SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['single_post_below'] =array(1,array('name' => __('Single post: Below Content','templatic'), 'description' => 'This region appears only on single posts, just after your content. You can put adsense code or social media button codes here.','id' => 'single_post_below','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));


///-----------------------------------------------------------------
	  //  SIDEBAR SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['sidebar1'] =array(1,array('name' => __('Sidebar 1','templatic'),'id' => 'sidebar1','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['sidebar2'] =array(1,array('name' => __('Sidebar 2','templatic'),'id' => 'sidebar2','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

	$sidebar_widget_arr['sidebar_2col_merge'] =array(1,array('name' => __('Sidebar: Combined width','templatic'),'description' => 'This section lets you utilise the combined width of both the sidebars.','id' => 'sidebar_2col_merge','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));

///-----------------------------------------------------------------
	  //  FOOTER SECTION WIDGET AREAS  //
///----------------------------------------------------------------

	$sidebar_widget_arr['footer1'] =array('1',array('name' => __('Pre-footer: First column','templatic'), 'description' => 'The first & the left-most column in the pre-footer area.','id' => 'footer1', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer2'] =array('1',array('name' => __('Pre-footer: Second column','templatic'), 'description' => 'The second column in the pre-footer area.','id' => 'footer2', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer3'] =array('1',array('name' => __('Pre-footer: Third column','templatic'), 'description' => 'The third column in the pre-footer area.','id' => 'footer3', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	
	$sidebar_widget_arr['footer4'] =array('1',array('name' => __('Pre-footer: Fourth column','templatic'), 'description' => 'The fourth & the right-most column in the pre-footer area.','id' => 'footer4', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
	


	$sidebar_widget_arr = apply_filters('templ_sidebar_widget_box_filter',$sidebar_widget_arr); //Sidebar widget area manage filer
	foreach($sidebar_widget_arr as $key=>$val)
	{
		if($val){
		register_sidebars($val[0],$val[1]);
		}
	}

}
?>