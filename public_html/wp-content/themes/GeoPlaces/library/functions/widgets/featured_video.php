<?php
// =============================== Videos Widget (particular category) ======================================
if(!class_exists('templ_featured_video')){
	class templ_featured_video extends WP_Widget {
		function templ_featured_video() {
		//Constructor
			$widget_ops = array('classname' => 'widget featured_video', 'description' => apply_filters('templ_featuredvideo_widget_desc_filter',__('Shows a list of featured video from a particular category. A Post custom field "video" is required with embed code to make this widget work.','templatic')) );
			$this->WP_Widget('featured_video', apply_filters('templ_featuredvideo_widget_title_filter',__('T &rarr; Featured Video','templatic')), $widget_ops);
		}
	
		function widget($args, $instance) {
		// prints the widget
	
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$my_post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
			$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
			?>
			<div class="featured_video">		
			<?php if($title){?><h3 class="clearfix"><?php _e($title,'templatic');?></h3><?php }?>
            <?php 
                global $post;
				$args = '';
				if($category)
				{
					$args .= '&category='.$category;
				}
				$latest_menus = get_posts('numberposts='.$post_number.$args.'&post_type='.$my_post_type);
				foreach($latest_menus as $post) :
                setup_postdata($post);
				
           		if(get_post_meta($post->ID,'video',true) || get_post_meta($post->ID,'Video',true)|| get_post_meta($post->ID,'VIDEO',true)){
					if(get_post_meta($post->ID,'video',true))
					{
						$video = get_post_meta($post->ID,'video',true);	
					}elseif(get_post_meta($post->ID,'Video',true))
					{
						$video = get_post_meta($post->ID,'Video',true);	
					}elseif(get_post_meta($post->ID,'VIDEO',true))
					{
						$video = get_post_meta($post->ID,'VIDEO',true);	
					}
					?>
                 <div class="video">
                <?php echo $video;?>
                    <h4><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h4>
                </div>
                <?php }?>
             <?php endforeach; ?>
             </div>
            <?php
			echo $after_widget;
		}
	
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['post_number'] = strip_tags($new_instance['post_number']);
			return $instance;
		}
	
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','post_type' => '' ) );
			$my_post_type = strip_tags($instance['post_type']);
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$post_number = strip_tags($instance['post_number']);
	
	?>
    
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('video_link'); ?>"><?php echo sprintf(__('Before using this widget, make sure you&rsquo;ve added a custom field called "video" in the post.  ','templatic').'%s','<a href="'.admin_url( 'edit.php' ).'"><strong>Post Custom Field</strong></a>');?> 
	</p>
	<?php
		}
	}
	register_widget('templ_featured_video');
}
?>