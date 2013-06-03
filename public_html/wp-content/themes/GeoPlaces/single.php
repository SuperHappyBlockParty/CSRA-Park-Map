<?php
if($post->post_type == CUSTOM_POST_TYPE1)
{
	require_once (get_template_directory() . '/single-place.php');
}
else if($post->post_type == CUSTOM_POST_TYPE2)
{
	require_once (get_template_directory() . '/single-event.php');
}
else
{
	require_once (get_template_directory() . '/single-blog.php');
}
?>