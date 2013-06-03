<?php
/**
 * The Sidebar containing the Sidebar 1 and Sidebar 2 widget areas.
 */
?>
<?php templ_before_sidebar(); // before sidebar hooks?>
<?php
if(templ_is_layout('full_width'))  ////Sidebar Full width page
{
	
}else
if(templ_is_layout('2_col_right'))  ////Sidebar 2 column right
{
	echo '<div class="sidebar right right_col">';
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('place_listing_sidebar')){?><?php } else {?>  <?php }
	echo '</div>';
}
else  ////Sidebar 2 column left as default setting
{
	echo '<div class="sidebar left left_col">';
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('place_listing_sidebar')){?><?php } else {?>  <?php }
	echo '</div>';
}
?>
<?php templ_after_sidebar(); // after sidebar hooks?>