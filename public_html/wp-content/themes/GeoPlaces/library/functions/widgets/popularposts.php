<?php
// =============================== Popular Posts Widget ======================================
if(!class_exists('templ_popularposts'))
{
	class templ_popularposts extends WP_Widget {
		function templ_popularposts() {
		//Constructor
			$widget_ops = array('classname' => 'widget popularposts', 'description' => apply_filters('templ_popularpost_widget_desc_filter',__('Popular Posts Widget','templatic')) );		
			$this->WP_Widget('templ_popularposts', apply_filters('templ_popularpost_widget_title_filter',__('T &rarr; Popular Posts','templatic')), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$my_post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
			$number = empty($instance['number']) ? 5 : apply_filters('widget_number', $instance['number']);
			?>						
        <div class="widget popular">
       <?php if($title){?> <h3><?php _e($title,'templatic');?></h3><?php }?>
        <ul>
        <?php
        global $wpdb;

		/* REMOVE aLL FILTERS WHILE IT'S POSTS*/
		remove_action('pre_get_posts', 'search_filter');
		remove_filter('posts_where', 'searching_filter_where');			
		remove_filter('posts_orderby', 'feature_listing_orderby');
		if($my_post_type != 'post')
			add_action('posts_where','popular_posts_where');
		$args = array(
				  'post_type' => $my_post_type,
				  'posts_per_page' => $number,
				  'ignore_sticky_posts'=> 1,
				  'orderby' => 'comment_count',
				  'order' => 'DESC'
		);

		global $wp_query;
		$cmt_query = null;
		$cmt_query = new WP_Query($args);
        if($cmt_query->have_posts()){
            while($cmt_query->have_posts()){ $cmt_query->the_post();
                $post_title = stripslashes($post->post_title);
                $guid = get_permalink($post->ID);
				$first_post_title=substr($post_title,0,26);  ?>
				<li> <a href="<?php echo $guid; ?>" title="<?php echo $post_title; ?>"><?php the_title(); ?></a> <br />
				<span class="date"><?php echo the_time(templ_get_date_format(),$post) ?> <?php _e(' at ','templatic');?> <?php echo the_time(templ_get_time_format(),$post) ?></span> 
				</li>
        <?php } } ?>
        </ul>
        </div>
				   
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			$instance['number'] = ($new_instance['number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );	
			$my_post_type = strip_tags($instance['post_type']);	
			$title = strip_tags($instance['title']);
			$number = ($instance['number']);
		?>
		
        <p><label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>: <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p>
<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:','templatic')?>
<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
<?php
$custom_post_types_args = array();  
$custom_post_types = get_post_types($custom_post_types_args,'objects');   
foreach ($custom_post_types as $content_type) {
if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page'){
?>
<option value="<?php _e($content_type->name);?>" <?php if(attribute_escape($my_post_type)==$content_type->name){ echo 'selected="selected"';}?>><?php _e($content_type->label);?></option>
<?php }}?>
</select>
</label>
</p>
		<p><label for="<?php  echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts','templatic');?> <input class="widefat" id="<?php  echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" /></label></p>
		
		<?php
	}}
	register_widget('templ_popularposts');
}
?>
