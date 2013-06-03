<?php
/**
 * The Sidebar containing the Sidebar 1 and Sidebar 2 widget areas.
 */

templ_before_sidebar(); // before sidebar hooks

if(templ_is_layout('full_width'))  //Sidebar Full width page
{
	
}else{
	global $post;
	if(templ_is_layout('2_col_right'))  //Sidebar 2 column right
	{	
		templ_event_detail_sidebar($post,'sidebar right right_col','detail_page_sidebar');	
	}else  //Sidebar 2 column left as default setting
	{
		templ_event_detail_sidebar($post,'sidebar left left_col','detail_page_sidebar');
	}
}
templ_after_sidebar(); // after sidebar hooks ?>
