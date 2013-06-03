<?php
/**-- Multiple cities with select box BOC--**/

class multi_city extends WP_Widget {
	function multi_city() {
	//Constructor
		$widget_ops = array('classname' => 'Multi City Options', 'description' => __('Multi City Options. It should be once on the page.','templatic') );		
		$this->WP_Widget('widget_multi_city', __('T &rarr; Multi City Options','templatic'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
        <div class="widget multi_city">
        	<?php
			echo get_multicity_dl('multi_city','multi_city',$_SESSION['multi_city'],'onchange="set_selected_city(this.value)"');?>
        </div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>

<?php
	}}
register_widget('multi_city');
/**-- Multiple cities with select box EOC--**/

/**-- Home page banner widget BOC --**/

class homebannerwidget extends WP_Widget {
	function homebannerwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Home Banner', 'description' => __('Home page banner slider - you can place this widget instead of map widget in front end.','templatic') );		
		$this->WP_Widget('widget_homebannerwidget', __('T &rarr; Home Page Banner','templatic'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
		$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
		$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
		$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
		$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
		$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
		$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
		$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
		$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
		$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
		$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
		$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
		$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
		$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
		$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
		$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
		$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
		$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
		$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
		$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
	
		$effect = empty($instance['effect']) ? 'random' : apply_filters('widget_effect', $instance['effect']);
		$slices = empty($instance['slices']) ? '15' : apply_filters('widget_slices', $instance['slices']);
	 	$animSpeed = empty($instance['animSpeed']) ? '700' : apply_filters('widget_animSpeed', $instance['animSpeed']);
		$pauseTime = empty($instance['pauseTime']) ? '3000' : apply_filters('widget_pauseTime', $instance['pauseTime']);
		$startSlide = empty($instance['startSlide']) ? '' : apply_filters('widget_startSlide', $instance['startSlide']);
		$directionNavHide = empty($instance['directionNavHide']) ? '' : apply_filters('widget_directionNavHide', $instance['directionNavHide']);
		$slider_img = empty($instance['slider_img']) ? 'Yes' : apply_filters('widget_slider_img', $instance['slider_img']);
		?>						
		<style type="text/css">
		.nivoSlider img {
			max-width: none;
		}
		</style>
		<script type="text/javascript" language="javascript">
		var $sl = jQuery.noConflict();
		$sl(window).load(function() {
			$sl('#slider').nivoSlider({
				effect:'<?php if (($effect) <> "" ) { echo (($effect)); } else { echo 'random'; } ?>', //Specify sets like: 'random,fold,fade,sliceDown'
				slices:<?php if (($slices) <> "" ) { echo (($slices)); } else { echo '15'; } ?>,
				animSpeed:<?php if (($animSpeed) <> "" ) { echo (($animSpeed)); } else { echo '700'; } ?>,
				pauseTime:<?php if (($pauseTime) <> "" ) { echo (($pauseTime)); } else { echo '3000'; } ?>,
				startSlide:0, //Set starting Slide (0 index)
				directionNav:true, //Next and Prev
				directionNavHide:true, //Only show on hover
				controlNav:true, //1,2,3...
				controlNavThumbs:false, //Use thumbnails for Control Nav
				controlNavThumbsFromRel:false, //Use image rel for thumbs
				controlNavThumbsSearch: '.jpg', //Replace this with...
				controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
				keyboardNav:true, //Use left and right arrows
				pauseOnHover:true, //Stop animation while hovering
				manualAdvance:false, //Force manual transitions
				captionOpacity:0.8, //Universal caption opacity
				beforeChange: function(){},
				afterChange: function(){},
				slideshowEnd: function(){} //Triggers after all slides have been shown
			});
		});
		</script>

		<div class="top_banner_section">
                <div class="top_banner_section_in clearfix">
   
           
             	<div  id="slider" class="grid8 fr">
              
             	
               	<?php if ( $s1 <> "" ) { ?>	  
         			<a class="" href="<?php echo $s1link; ?>"><img src="<?php echo $s1; ?>"  alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s2 <> "" ) { ?>	 
         			<a  class="" href="<?php echo $s2link; ?>"><img src="<?php echo $s2; ?>" alt=""/></a>
         		<?php } ?>
                
                <?php if ( $s3 <> "" ) { ?>	 
         			<a  class="" href="<?php echo $s3link; ?>"><img src="<?php echo $s3; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s4 <> "" ) { ?>	 
         			<a  class="" href="<?php echo $s4link; ?>"><img src="<?php echo $s4; ?>"  alt=""/></a>
         		<?php } ?>
                
                <?php if ( $s5 <> "" ) { ?>	 
         			<a  class="" href="<?php echo $s5link; ?>"><img src="<?php echo $s5; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s6 <> "" ) { ?>	  
         			<a class="" href="<?php echo $s6link; ?>"><img src="<?php echo $s6; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s7 <> "" ) { ?>	 
         			<a class="" href="<?php echo $s7link; ?>"><img src="<?php echo $s7; ?>"  alt=""/></a>
         		<?php } ?>
                
                <?php if ( $s8 <> "" ) { ?>	 
         			<a class="" href="<?php echo $s8link; ?>"><img src="<?php echo $s8; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s9 <> "" ) { ?>	 
         			<a style="display:block;" class="" href="<?php echo $s9link; ?>"><img src="<?php echo $s9; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s10 <> "" ) { ?>	 
         			<a class="" href="<?php echo $s10link; ?>"><img src="<?php echo $s10; ?>"  alt=""/></a>
         		<?php } ?>
                	
                </div>
            </div>
         </div> <!-- top_banner_section #end -->
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['s1'] = ($new_instance['s1']);
		$instance['s1link'] = ($new_instance['s1link']);
		$instance['s2'] = ($new_instance['s2']);
		$instance['s2link'] = ($new_instance['s2link']);
		$instance['s3'] = ($new_instance['s3']);
		$instance['s3link'] = ($new_instance['s3link']);
		$instance['s4'] = ($new_instance['s4']);
		$instance['s4link'] = ($new_instance['s4link']);
		$instance['s5'] = ($new_instance['s5']);
		$instance['s5link'] = ($new_instance['s5link']);
		$instance['s6'] = ($new_instance['s6']);
		$instance['s6link'] = ($new_instance['s6link']);
		$instance['s7'] = ($new_instance['s7']);
		$instance['s7link'] = ($new_instance['s7link']);
		$instance['s8'] = ($new_instance['s8']);
		$instance['s8link'] = ($new_instance['s8link']);
		$instance['s9'] = ($new_instance['s9']);
		$instance['s9link'] = ($new_instance['s9link']);
		$instance['s10'] = ($new_instance['s10']);
		$instance['s10link'] = ($new_instance['s10link']);
		
		$instance['width'] = ($new_instance['width']);
		$instance['height'] = ($new_instance['height']);
		$instance['effect'] = ($new_instance['effect']);
		$instance['slices'] = ($new_instance['slices']);
		$instance['animSpeed'] = ($new_instance['animSpeed']);
		$instance['pauseTime'] = ($new_instance['pauseTime']);
		$instance['startSlide'] = ($new_instance['startSlide']);
		$instance['directionNavHide'] = ($new_instance['directionNavHide']);
		$instance['slider_img'] = ($new_instance['slider_img']);
 		return $instance;
		}
		function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc' => '','actionbtn' => '','actionlink' => '','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '', 'effect' => '','slices' => '','animSpeed' => '','pauseTime' => '','startSlide' => '','directionNavHide' => '', 'slider_img' => '','width' => '','height' => '' ) );		
		$title = strip_tags($instance['title']);
		$width = ($instance['width']);
		$height = ($instance['height']);
 		$s1 = ($instance['s1']);
		$s1link = ($instance['s1link']);
		$s2 = ($instance['s2']);
		$s2link = ($instance['s2link']);
		$s3 = ($instance['s3']);
		$s3link = ($instance['s3link']);
		$s4 = ($instance['s4']);
		$s4link = ($instance['s4link']);
		$s5 = ($instance['s5']);
		$s5link = ($instance['s5link']);
		$s6 = ($instance['s6']);
		$s6link = ($instance['s6link']);
		$s7 = ($instance['s7']);
		$s7link = ($instance['s7link']);
		$s8 = ($instance['s8']);
		$s8link = ($instance['s8link']);
		$s9 = ($instance['s9']);
		$s9link = ($instance['s9link']);
		$s10 = ($instance['s9']);
		$s10link = ($instance['s10link']);
		
		$effect = ($instance['effect']);
		$slices = ($instance['slices']);
		$animSpeed = ($instance['animSpeed']);
		$pauseTime = ($instance['pauseTime']);
		$startSlide = ($instance['startSlide']);
		$directionNavHide = ($instance['directionNavHide']);
		$slider_img = ($instance['slider_img']);
		 ?>

		<p><label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Banner Images slices (slider images slice effect)','templatic');?>:
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo attribute_escape($slices); ?>"></label>
		</p> 

		<p><label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Banner Slider image in time','templatic');?>: 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo attribute_escape($animSpeed); ?>"></label>
		</p>

		<p><label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Banner Slider image out time','templatic'); ?>: 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo attribute_escape($pauseTime); ?>"></label>
		</p>


		<p>
		  <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Banner Effect','templatic'); ?>:
		  <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="width:50%;">
		  <option value="random" <?php if(attribute_escape($effect)=='random'){ echo 'selected="selected"';}?>></option>
		  <option value="fold" <?php if(attribute_escape($effect)=='fold'){ echo 'selected="selected"';}?>><?php _e('fold','templatic');?></option>
		  <option value="fade" <?php if(attribute_escape($effect)=='fade'){ echo 'selected="selected"';}?>><?php _e('fade','templatic');?></option>
		  <option value="sliceDown" <?php if(attribute_escape($effect)=='sliceDown'){ echo 'selected="selected"';}?>><?php _e('sliceDown','templatic');?></option>
		  </select>
		  </label>
		</p>

		<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL (size : w940xh425 pixel) (ex.http://templatic.com/images/banner1.png)','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo attribute_escape($s1); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link (ex.http://templatic.com)','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo attribute_escape($s1link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo attribute_escape($s2); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link','templatic');?>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo attribute_escape($s2link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo attribute_escape($s3); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link','templatic');?>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo attribute_escape($s3link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo attribute_escape($s4); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo attribute_escape($s4link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo attribute_escape($s5); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo attribute_escape($s5link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo attribute_escape($s6); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link','templatic');?>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo attribute_escape($s6link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo attribute_escape($s7); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo attribute_escape($s7link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo attribute_escape($s8); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo attribute_escape($s8link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo attribute_escape($s9); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo attribute_escape($s9link); ?>"></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo attribute_escape($s10); ?>"></label>
		</p> 
		<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link','templatic');?> 
		<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo attribute_escape($s10link); ?>"></label>
		</p>
		<?php
	}}
register_widget('homebannerwidget');

/**-- Home page banner widget EOC --**/

/**-- We recommended widget BOC --**/
class werecommend extends WP_Widget {
	function werecommend() {
	//Constructor
		$widget_ops = array('classname' => 'widget We Recommend', 'description' => __('We Recommend - slider','templatic') );		
		$this->WP_Widget('widget_werecommend', __('T &rarr; We Recommend','templatic'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$div_id = empty($instance['div_id']) ? 'slider1' : apply_filters('widget_div_id', $instance['div_id']);
		$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
		$s1link = empty($instance['s1link']) ? '' : apply_filters('widget_s1', $instance['s1link']);
		$s2 = empty($instance['s2']) ? '' : apply_filters('widget_s2', $instance['s2']);
		$s2link = empty($instance['s2link']) ? '' : apply_filters('widget_s2link', $instance['s2link']);
		$s3 = empty($instance['s3']) ? '' : apply_filters('widget_s3', $instance['s3']);
		$s3link = empty($instance['s3link']) ? '' : apply_filters('widget_s3link', $instance['s3link']);
		$s4 = empty($instance['s4']) ? '' : apply_filters('widget_s4', $instance['s4']);
		$s4link = empty($instance['s4link']) ? '' : apply_filters('widget_s4link', $instance['s4link']);
		$s5 = empty($instance['s5']) ? '' : apply_filters('widget_s5', $instance['s5']);
		$s5link = empty($instance['s5link']) ? '' : apply_filters('widget_s5link', $instance['s5link']);
		$s6 = empty($instance['s6']) ? '' : apply_filters('widget_s6', $instance['s6']);
		$s6link = empty($instance['s6link']) ? '' : apply_filters('widget_s6link', $instance['s6link']);
		$s7 = empty($instance['s7']) ? '' : apply_filters('widget_s7', $instance['s7']);
		$s7link = empty($instance['s7link']) ? '' : apply_filters('widget_s7link', $instance['s7link']);
		$s8 = empty($instance['s8']) ? '' : apply_filters('widget_s8', $instance['s8']);
		$s8link = empty($instance['s8link']) ? '' : apply_filters('widget_s8link', $instance['s8link']);
		$s9 = empty($instance['s9']) ? '' : apply_filters('widget_s9', $instance['s9']);
		$s9link = empty($instance['s9link']) ? '' : apply_filters('widget_s9link', $instance['s9link']);
		$s10 = empty($instance['s10']) ? '' : apply_filters('widget_s10', $instance['s10']);
		$s10link = empty($instance['s10link']) ? '' : apply_filters('widget_s10link', $instance['s10link']);
		
		$width = '295';
		$height = '220';

		
		$effect = empty($instance['effect']) ? 'random' : apply_filters('widget_effect', $instance['effect']);
		$slices = empty($instance['slices']) ? '15' : apply_filters('widget_slices', $instance['slices']);
		$animSpeed = empty($instance['animSpeed']) ? '700' : apply_filters('widget_animSpeed', $instance['animSpeed']);
		$pauseTime = empty($instance['pauseTime']) ? '3000' : apply_filters('widget_pauseTime', $instance['pauseTime']);
		$startSlide = empty($instance['startSlide']) ? '' : apply_filters('widget_startSlide', $instance['startSlide']);
		$directionNavHide = empty($instance['directionNavHide']) ? '' : apply_filters('widget_directionNavHide', $instance['directionNavHide']);
		$slider_img = empty($instance['slider_img']) ? 'Yes' : apply_filters('widget_slider_img', $instance['slider_img']);
		$height = empty($instance['height']) ? '188' : apply_filters('widget_height', $instance['height']);
		$width = empty($instance['width']) ? '307' : apply_filters('widget_width', $instance['width']);
	  ?>		
	  <style type="text/css">
		.nivoSlider img {
			max-width: none;
		}
		</style>				
	<script type="text/javascript" language="javascript">
	jQuery.noConflict();
	jQuery(window).load(function() {
		jQuery('#<?php echo $div_id; ?>').nivoSlider({
			effect:'<?php if (($effect) <> "" ) { echo (($effect)); } else { echo 'random'; } ?>', //Specify sets like: 'random,fold,fade,sliceDown'
			slices:<?php if (($slices) <> "" ) { echo (($slices)); } else { echo '15'; } ?>,
			animSpeed:<?php if (($animSpeed) <> "" ) { echo (($animSpeed)); } else { echo '700'; } ?>,
			pauseTime:<?php if (($pauseTime) <> "" ) { echo (($pauseTime)); } else { echo '3000'; } ?>,
			startSlide:0, //Set starting Slide (0 index)
			directionNav:true, //Next and Prev
			directionNavHide:true, //Only show on hover
			controlNav:1, //1,2,3...
			controlNavThumbs:false, //Use thumbnails for Control Nav
			controlNavThumbsFromRel:false, //Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', //Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			keyboardNav:true, //Use left and right arrows
			pauseOnHover:true, //Stop animation while hovering
			manualAdvance:false, //Force manual transitions
			captionOpacity:0.8, //Universal caption opacity
			beforeChange: function(){},
			afterChange: function(){},
			slideshowEnd: function(){} //Triggers after all slides have been shown
		});
	});
	</script>
		<div class="we_recommend">
           <h3> <?php echo $title; ?> </h3>
            <div class="we_recommend_in" style="height:<?php echo $height;?>px !important;width:<?php echo $width;?>px !important;">
           
             	<div  id="<?php echo $div_id; ?>" >
             	
               	<?php if ( $s1 <> "" ) { ?>	 
         			<a class="nivo-imageLink" href="<?php echo $s1link; ?>" style=" overflow:hidden;" ><img src="<?php echo $s1; ?>"  alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s2 <> "" ) { ?>	 
         			<a  class="nivo-imageLink" href="<?php echo $s2link; ?>" style="overflow:hidden;" ><img src="<?php echo $s2; ?>" alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s3 <> "" ) { ?>	 
         			<a  class="nivo-imageLink" href="<?php echo $s3link; ?>" style="overflow:hidden;" ><img src="<?php echo $s3; ?>" alt=""  /></a>
         		<?php } ?>
                
                <?php if ( $s4 <> "" ) { ?>	 
         			<a  class="nivo-imageLink" href="<?php echo $s4link; ?>" style="overflow:hidden;" ><img src="<?php echo $s4; ?>"  alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s5 <> "" ) { ?>	 
         			<a  class="nivo-imageLink" href="<?php echo $s5link; ?>" style="overflow:hidden;" ><img src="<?php echo $s5; ?>" alt=""  /></a>
         		<?php } ?>
                
                <?php if ( $s6 <> "" ) { ?>	 
         			<a class="nivo-imageLink" href="<?php echo $s6link; ?>" style="overflow:hidden;" ><img src="<?php echo $s6; ?>" alt=""  /></a>
         		<?php } ?>
                
                <?php if ( $s7 <> "" ) { ?>	 
         			<a class="nivo-imageLink" href="<?php echo $s7link; ?>" style="overflow:hidden;" ><img src="<?php echo $s7; ?>"  alt="" /></a>
         		<?php } ?>
                
                <?php if ( $s8 <> "" ) { ?>	 
         			<a class="nivo-imageLink" href="<?php echo $s8link; ?>" style="overflow:hidden;" ><img src="<?php echo $s8; ?>" alt=""  /></a>
         		<?php } ?>
                
                <?php if ( $s9 <> "" ) { ?>	 
         			<a  class="nivo-imageLink" href="<?php echo $s9link; ?>" style="overflow:hidden;" > <img src="<?php echo $s9; ?>" alt=""  /></a>
         		<?php } ?>
                
                <?php if ( $s10 <> "" ) { ?>	 
         			<a class="nivo-imageLink" href="<?php echo $s10link; ?>" style="overflow:hidden;" ><img src="<?php echo $s10; ?>"  alt="" /></a>
         		<?php } ?>
                	
                </div>
            </div> 
		</div> 
    <?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['div_id'] = strip_tags($new_instance['div_id']);
		$instance['s1'] = ($new_instance['s1']);
		$instance['s1link'] = ($new_instance['s1link']);
		$instance['s2'] = ($new_instance['s2']);
		$instance['s2link'] = ($new_instance['s2link']);
		$instance['s3'] = ($new_instance['s3']);
		$instance['s3link'] = ($new_instance['s3link']);
		$instance['s4'] = ($new_instance['s4']);
		$instance['s4link'] = ($new_instance['s4link']);
		$instance['s5'] = ($new_instance['s5']);
		$instance['s5link'] = ($new_instance['s5link']);
		$instance['s6'] = ($new_instance['s6']);
		$instance['s6link'] = ($new_instance['s6link']);
		$instance['s7'] = ($new_instance['s7']);
		$instance['s7link'] = ($new_instance['s7link']);
		$instance['s8'] = ($new_instance['s8']);
		$instance['s8link'] = ($new_instance['s8link']);
		$instance['s9'] = ($new_instance['s9']);
		$instance['s9link'] = ($new_instance['s9link']);
		$instance['s10'] = ($new_instance['s10']);
		$instance['s10link'] = ($new_instance['s10link']);
		
		$instance['effect'] = ($new_instance['effect']);
		$instance['slices'] = ($new_instance['slices']);
		$instance['animSpeed'] = ($new_instance['animSpeed']);
		$instance['pauseTime'] = ($new_instance['pauseTime']);
		$instance['startSlide'] = ($new_instance['startSlide']);
		$instance['directionNavHide'] = ($new_instance['directionNavHide']);
		$instance['slider_img'] = ($new_instance['slider_img']);
		
		$instance['width'] = ($new_instance['width']);
		$instance['height'] = ($new_instance['height']);
 		return $instance;
		
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'desc' => '','actionbtn' => '','actionlink' => '','s1' => '','s2' => '','s3' => '','s4' => '','s5' => '','s6' => '','s7' => '','s8' => '','s9' => '','s10' => '','s1link' => '','s2link' => '','s3link' => '','s4link' => '','s5link' => '','s6link' => '','s7link' => '','s8link' => '','s9link' => '','s10link' => '', 'effect' => '','slices' => '','animSpeed' => '','pauseTime' => '','startSlide' => '','directionNavHide' => '', 'slider_img' => '', 'width' => '', 'height' => '' ) );		
		$title = strip_tags($instance['title']);
 		$s1 = ($instance['s1']);
		$s1link = ($instance['s1link']);
		$s2 = ($instance['s2']);
		$s2link = ($instance['s2link']);
		$s3 = ($instance['s3']);
		$s3link = ($instance['s3link']);
		$s4 = ($instance['s4']);
		$s4link = ($instance['s4link']);
		$s5 = ($instance['s5']);
		$s5link = ($instance['s5link']);
		$s6 = ($instance['s6']);
		$s6link = ($instance['s6link']);
		$s7 = ($instance['s7']);
		$s7link = ($instance['s7link']);
		$s8 = ($instance['s8']);
		$s8link = ($instance['s8link']);
		$s9 = ($instance['s9']);
		$s9link = ($instance['s9link']);
		$s10 = ($instance['s9']);
		$s10link = ($instance['s10link']);
		
		$width = ($instance['width']);
		$height = ($instance['height']);
		
		$effect = ($instance['effect']);
		$slices = ($instance['slices']);
		$animSpeed = ($instance['animSpeed']);
		$pauseTime = ($instance['pauseTime']);
		$startSlide = ($instance['startSlide']);
		$directionNavHide = ($instance['directionNavHide']);
		$slider_img = ($instance['slider_img']);
		$div_id = ($instance['div_id']);
		 ?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('div_id'); ?>"><?php _e('Enter uniq ID for DIV','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('div_id'); ?>" name="<?php echo $this->get_field_name('div_id'); ?>" type="text" value="<?php echo attribute_escape($div_id); ?>" />
	  </label>
	</p>
	<p><label for="<?php echo $this->get_field_id('slices'); ?>"><?php _e('Banner Images slices (slider images slice effect)','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('slices'); ?>" name="<?php echo $this->get_field_name('slices'); ?>" value="<?php echo attribute_escape($slices); ?>"></label>
	</p> 

	<p><label for="<?php echo $this->get_field_id('animSpeed'); ?>"><?php _e('Banner Slider image in time','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('animSpeed'); ?>" name="<?php echo $this->get_field_name('animSpeed'); ?>" value="<?php echo attribute_escape($animSpeed); ?>"></label>
	</p>

	<p><label for="<?php echo $this->get_field_id('pauseTime'); ?>"><?php _e('Banner Slider image out time','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('pauseTime'); ?>" name="<?php echo $this->get_field_name('pauseTime'); ?>" value="<?php echo attribute_escape($pauseTime); ?>"></label>
	</p>

	<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Banner image width','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo attribute_escape($width); ?>"></label>
	</p>

	<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Banner image height','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo attribute_escape($height); ?>"></label>
	</p>

	<p>
	  <label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Banner Effect','templatic');?>
	  <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="width:50%;">
	  <option <?php if(attribute_escape($effect)=='random'){ echo 'selected="selected"';}?>><?php _e('random','templatic');?></option>
	  <option <?php if(attribute_escape($effect)=='fold'){ echo 'selected="selected"';}?>><?php _e('fold','templatic');?></option>
	  <option <?php if(attribute_escape($effect)=='fade'){ echo 'selected="selected"';}?>><?php _e('fade','templatic');?></option>
	  <option <?php if(attribute_escape($effect)=='sliceDown'){ echo 'selected="selected"';}?>><?php _e('sliceDown','templatic');?></option>
	  </select>
	  </label>
	</p>
 
	<p><label for="<?php echo $this->get_field_id('s1'); ?>"><?php _e('Banner Slider Image 1 full URL(ex.http://templatic.com/images/banner1.png)','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1'); ?>" name="<?php echo $this->get_field_name('s1'); ?>" value="<?php echo attribute_escape($s1); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s1link'); ?>"><?php _e('Banner Slider Image 1 Link (ex.http://templatic.com)','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s1link'); ?>" name="<?php echo $this->get_field_name('s1link'); ?>" value="<?php echo attribute_escape($s1link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s2'); ?>"><?php _e('Banner Slider Image 2 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2'); ?>" name="<?php echo $this->get_field_name('s2'); ?>" value="<?php echo attribute_escape($s2); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s2link'); ?>"><?php _e('Banner Slider Image 2 Link','templatic');?>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s2link'); ?>" name="<?php echo $this->get_field_name('s2link'); ?>" value="<?php echo attribute_escape($s2link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s3'); ?>"><?php _e('Banner Slider Image 3 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3'); ?>" name="<?php echo $this->get_field_name('s3'); ?>" value="<?php echo attribute_escape($s3); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s3link'); ?>"><?php _e('Banner Slider Image 3 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s3link'); ?>" name="<?php echo $this->get_field_name('s3link'); ?>" value="<?php echo attribute_escape($s3link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s4'); ?>"><?php _e('Banner Slider Image 4 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4'); ?>" name="<?php echo $this->get_field_name('s4'); ?>" value="<?php echo attribute_escape($s4); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s4link'); ?>"><?php _e('Banner Slider Image 4 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s4link'); ?>" name="<?php echo $this->get_field_name('s4link'); ?>" value="<?php echo attribute_escape($s4link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s5'); ?>"><?php _e('Banner Slider Image 5 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5'); ?>" name="<?php echo $this->get_field_name('s5'); ?>" value="<?php echo attribute_escape($s5); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s5link'); ?>"><?php _e('Banner Slider Image 5 Link','templatic');?>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s5link'); ?>" name="<?php echo $this->get_field_name('s5link'); ?>" value="<?php echo attribute_escape($s5link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s6'); ?>"><?php _e('Banner Slider Image 6 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6'); ?>" name="<?php echo $this->get_field_name('s6'); ?>" value="<?php echo attribute_escape($s6); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s6link'); ?>"><?php _e('Banner Slider Image 6 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s6link'); ?>" name="<?php echo $this->get_field_name('s6link'); ?>" value="<?php echo attribute_escape($s6link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s7'); ?>"><?php _e('Banner Slider Image 7 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7'); ?>" name="<?php echo $this->get_field_name('s7'); ?>" value="<?php echo attribute_escape($s7); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s7link'); ?>"><?php _e('Banner Slider Image 7 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s7link'); ?>" name="<?php echo $this->get_field_name('s7link'); ?>" value="<?php echo attribute_escape($s7link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s8'); ?>"><?php _e('Banner Slider Image 8 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8'); ?>" name="<?php echo $this->get_field_name('s8'); ?>" value="<?php echo attribute_escape($s8); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s8link'); ?>"><?php _e('Banner Slider Image 8 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s8link'); ?>" name="<?php echo $this->get_field_name('s8link'); ?>" value="<?php echo attribute_escape($s8link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s9'); ?>"><?php _e('Banner Slider Image 9 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9'); ?>" name="<?php echo $this->get_field_name('s9'); ?>" value="<?php echo attribute_escape($s9); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s9link'); ?>"><?php _e('Banner Slider Image 9 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s9link'); ?>" name="<?php echo $this->get_field_name('s9link'); ?>" value="<?php echo attribute_escape($s9link); ?>"></label>
	</p>
	<p><label for="<?php echo $this->get_field_id('s10'); ?>"><?php _e('Banner Slider Image 10 full URL','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10'); ?>" name="<?php echo $this->get_field_name('s10'); ?>" value="<?php echo attribute_escape($s10); ?>"></label>
	</p> 
	<p><label for="<?php echo $this->get_field_id('s10link'); ?>"><?php _e('Banner Slider Image 10 Link','templatic');?> 
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('s10link'); ?>" name="<?php echo $this->get_field_name('s10link'); ?>" value="<?php echo attribute_escape($s10link); ?>"></label>
	</p>
	<?php
	}}
register_widget('werecommend');
/**-- We recommended widget EOC --**/

/* Latest Places/Events Custom Taxonomy  -->  Listview BOC*/
	
remove_filter('posts_where', 'author_filter_where');
remove_filter('posts_orderby', 'author_filter_orderby');
class templ_latest_posts_list_view extends WP_Widget {
	
		function templ_latest_posts_list_view() {
		//Constructor
		global $thumb_url,$wpdb;
			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_latestpost_with_img_widget_desc_filter',__('Show place or event home page featured listings in a list layout.','templatic')) );
			$this->WP_Widget('latest_posts_list_view',apply_filters('templ_latestpost_with_img_widget_title_filter',__('T &rarr; Featured Listings For Home Page(List view)','templatic')), $widget_ops);
		}
	 
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
	 
			//echo $before_widget;
			$title = empty($instance['title']) ? 'Places' : apply_filters('widget_title', $instance['title']);
		    $category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$my_post_type = empty($instance['post_type']) ? CUSTOM_POST_TYPE1 : apply_filters('widget_post_type', $instance['post_type']);
			$link = empty($instance['link']) ? '' : apply_filters('widget_link', $instance['link']);
			$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
			global $wpdb,$query_string;
			global $post;
			$arg = '';
			if($my_post_type == CUSTOM_POST_TYPE1){
				$my_post_cat = 'placecategory';
			}else{
				$my_post_cat = 'eventcategory';
			}

			$args=array($my_post_cat => $category,
				  'post_type' => $my_post_type,
				  'posts_per_page' => $number,
				  'ignore_sticky_posts'=> 1);
			$my_query = null;
			$my_query = new WP_Query($args);

			if( $my_query->have_posts() ) { ?>
			<div id="loop" class="list clear">
			<?php if($title){ ?> 
				<h3><span><?php _e($title,'templatic');?></span>
				<?php if($link){?><a href="<?php _e($link,'templatic');?>" class="more" ><?php _e($text,'templatic');?></a><?php }?></h3> <?php }?>
          
			 <?php while ($my_query->have_posts()) : $my_query->the_post();
				$post_images =  bdw_get_images_with_info($post->ID,'thumb');   
				$attachment_id = $post_images[0]['id']; ?>				
			<div id="post_<?php the_ID(); ?>" <?php if((get_post_meta($post->ID,'is_featured',true) == 1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){ post_class('post featured_post');} else { post_class('post');}?>>
				<div class="post-content">
					
					<?php if((get_post_meta($post->ID,'is_featured',true) ==1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){?>
					<span class="featured_img"><?php _e('featured','templatic');?></span>
					<?php }
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					$is_crop = get_option('thumbnail_crop');
					if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
					if($title ==''){ $title = $post->post_title; }
					if($alt ==''){ $alt = $post->post_title; }
					if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );

					?>
						<a class="post_img"  href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
					<?php
					}else{?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php _e('Image Not Available','templatic');?> </a>
					<?php } ?>
					
				
					<div class="post_content">
						<h2><a class="widget-title" href="<?php the_permalink(); ?>"><?php __(the_title(),'templatic'); ?></a></h2> 
						<!-- Displat author details and date and etc -->
						 <div class="post-meta listing_meta">
							<?php if(templ_is_show_listing_author()){ ?>
							<label><?php _e('By','templatic');?></label> <span class="post-author"> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="<?php _e('By','templatic');?> <?php the_author(); ?>">
							<?php the_author(); ?>
							</a> </span>
							<?php }  ?>
							<?php if(templ_is_show_listing_date()){?>
							<label><?php _e('on','templatic');?></label>  <span class="post-date">
							<?php the_time(templ_get_date_format()) ?>
							</span>
							<?php } 
							if(templ_is_show_listing_views()){
							echo '<span class="post-total-view"> '.VIEW_LIST_TEXT.": ".user_post_visit_count($post->ID).'</span>';
							echo '<span class="post-daily-view"> '.VIEW_LIST_TEXT_DAILY.": ".user_post_visit_count_daily($post->ID).'</span>';
							}
							if(get_post_format( $post->ID )){
							$format = get_post_format( $post->ID );
									?>
								<em>&bull; </em> <a href="<?php echo get_post_format_link($format); ?>" title="<?php esc_attr_e( VIEW_TEXT . $format, 'templatic' ); ?>">
								<?php _e( MORE_TEXT . $format, 'templatic' ); ?>
								</a>
							<?php } ?>
						 </div>
						<p class="address"><?php echo get_post_meta($post->ID,'geo_address',true);?></p>
						<p> <?php 	echo excerpt(get_option('ptthemes_content_excerpt_count')); //echo bm_better_excerpt(175, ''); ?> </p> 
						<?php if($post->post_type == CUSTOM_POST_TYPE1){
								$taxonomy = CUSTOM_CATEGORY_TYPE1;
								$tags = CUSTOM_TAG_TYPE1;
							}elseif($post->post_type == CUSTOM_POST_TYPE2){
								$taxonomy = CUSTOM_CATEGORY_TYPE2;
								$tags = CUSTOM_TAG_TYPE2;
							}else{
								$taxonomy = 'category';
								$tags = 'post_tag';
							}
							/* display categories of the post if show on listing enable */
							if(templ_is_show_listing_category()){
								templ_wp_categories_listing($post->ID ,$taxonomy);
							}
							/* display tags of the post if show on listing enable */
							echo "&nbsp;";
							if(templ_is_show_listing_tags()){
								templ_wp_tags_listing($post->ID ,$tags);
							} ?>
					</div> 
					<div class="post_right">
							<?php if(trim(get_option('ptthemes_listing_comment')) == trim('Yes') || !get_option('ptthemes_listing_comment') ){ ?>
							<a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number(__('0 '.REVIEWS.''), __('1 '.REVIEW.''), __('% '.REVIEWS.'')); ?> </a> 	
							<?php } ?>
							<?php if(get_option('ptthemes_disable_rating') == 'no') { 	?>
							<?php  if($my_post_type != 'post' && get_option('ptthemes_disable_rating') == 'no') {  ?><span class="rating"><?php echo get_post_rating_star($post->ID);?></span>	 <?php } ?>					
							<?php } ?>
							<?php favourite_html($post->post_author,$post->ID); ?>
					</div>					
                </div>
			</div>
			
		<?php endwhile; wp_reset_query(); ?>
			</div>
		<?php	} 
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			$instance['link'] = strip_tags($new_instance['link']);
			$instance['text'] = strip_tags($new_instance['text']);
			return $instance;
		}
	 
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$number = strip_tags($instance['number']);
			$my_post_type = strip_tags($instance['post_type']);
			$link = strip_tags($instance['link']);
			$text = strip_tags($instance['text']);
	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('View All Text :','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo attribute_escape($text); ?>" /></label>
	</p>
    <p>
		<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('View All Link URL (ex.http://templatic.com/events):','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo attribute_escape($link); ?>" /></label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
	  </label>
	</p>
    <p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:','templatic')?>
		<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
		<?php
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');   
		foreach ($custom_post_types as $content_type) {
		if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post'){ ?>
			<option value="<?php _e($content_type->name);?>" <?php if(attribute_escape($my_post_type)==$content_type->name){ echo 'selected="selected"';}?>><?php _e($content_type->label);?></option>
		<?php }}?>
		</select>
		</label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>SLUGs</code> separated by commas):','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<?php
		}
	}
	register_widget('templ_latest_posts_list_view');
	
/* Latest Places/Events Custom Taxonomy  -->  Listview EOC*/	

/* Latest Places/Events Custom Taxonomy  -->  Gridview BOC*/
 class templ_latest_posts_grid_view extends WP_Widget {
	
		function templ_latest_posts_grid_view() {
		//Constructor
		global $thumb_url;
			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_latestpost_with_img_widget_desc_filter',__('Show place or event home page featured listings in a grid layout.','templatic')) );
			$this->WP_Widget('latest_posts_grid_view',apply_filters('templ_latestpost_with_img_widget_title_filter',__('T &rarr;Featured Listings For Home Page(Grid view)','templatic')), $widget_ops);
		}
	 
		function widget($args, $instance) {
		// prints the widget
			
			extract($args, EXTR_SKIP);
	 
			//echo $before_widget;
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$my_post_type = empty($instance['post_type']) ? 'event' : apply_filters('widget_post_type', $instance['post_type']);
			$link = empty($instance['link']) ? '' : apply_filters('widget_link', $instance['link']);
			$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
			global $post,$wpdb;
			$post_widget_count = 1;

				if($my_post_type == CUSTOM_POST_TYPE1){
				$my_post_cat = 'placecategory';
				}else{
				$my_post_cat = 'eventcategory';
				}
				$args=array($my_post_cat => $category,
				  'post_type' => $my_post_type,
				  'posts_per_page' => $number,
				  'ignore_sticky_posts'=> 1);
				$my_query = null;
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
				 ?>
					
			<div id="loop" class="grid clear">	
				<?php if($title){?> 
					<h3><span><?php _e($title,'templatic');?></span>
					<?php if($link){?><a href="<?php _e($link,'templatic');?>" class="more" ><?php _e($text,'templatic');?></a><?php }?>
         
					</h3> <?php }?>
			
			<?php   while ($my_query->have_posts()) : $my_query->the_post();
					$post_images =  bdw_get_images_with_info($post->ID,'large');   
					$attachment_id = $post_images[0]['id']; ?>	
					<div id="post_<?php the_ID(); ?>" <?php if((get_post_meta($post->ID,'is_featured',true) == 1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){ post_class('post featured_post');} else { post_class('post');}?>>
					<div class="post-content">
					
				
					<?php if((get_post_meta($post->ID,'is_featured',true) ==1) && ( get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){?>
							<span class="featured_img"><?php _e('featured','templatic');?></span>
					<?php }
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					$is_crop = get_option('thumbnail_crop');
					if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
					if($title ==''){ $title = $post->post_title; }
					if($alt ==''){ $alt = $post->post_title; }
					if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );
					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php echo  $alt; ?>" title="<?php echo $title; ?>"  /> </a>
					
					<?php
					}else {?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php _e('Image Not Available','templatic')?> </a>
					<?php } ?>
						
					<div class="post_content">
						<h2><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
						<!-- Displat author details and date and etc -->
						 <div class="post-meta listing_meta">
							<?php if(templ_is_show_listing_author()){ ?>
							<?php _e('By','templatic'); ?> <span class="post-author"> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>">
							<?php the_author(); ?>
							</a> </span>
							<?php }  ?>
							<?php if(templ_is_show_listing_date()){?>
							<?php _e('on','templatic');?> <span class="post-date">
							<?php the_time(templ_get_date_format()) ?>
							</span>
							<?php } 
							if(templ_is_show_listing_views()){
							echo '<span class="post-total-view"> '.VIEW_LIST_TEXT.": ".user_post_visit_count($post->ID).'</span>';
							echo '<span class="post-daily-view"> '.VIEW_LIST_TEXT_DAILY.": ".user_post_visit_count_daily($post->ID).'</span>';
							}
							if(get_post_format( $post->ID )){
							$format = get_post_format( $post->ID );
									?>
								<em>&bull; </em> <a href="<?php echo get_post_format_link($format); ?>" title="<?php esc_attr_e( VIEW_TEXT . $format, 'templatic' ); ?>">
								<?php _e( MORE_TEXT . $format, 'templatic' ); ?>
								</a>
							<?php } ?>
						 </div>
						<?php  if($my_post_type != 'post' && get_option('ptthemes_disable_rating') == 'no') {  ?><span class="rating"><?php echo get_post_rating_star($post->ID);?></span>	 <?php } ?>                    
						<p> <?php 	echo excerpt(get_option('ptthemes_content_excerpt_count')); ?> 	<a href="<?php echo get_permalink($post->ID); ?>" ><?php echo get_option('ptthemes_content_excerpt_readmore'); ?></a></p> 
						<?php
						/* fetch categories - taxonomies */
						if($post->post_type == CUSTOM_POST_TYPE1){
						$taxonomy = CUSTOM_CATEGORY_TYPE1;
						$tags = CUSTOM_TAG_TYPE1;
						}elseif($post->post_type == CUSTOM_POST_TYPE2){
							$taxonomy = CUSTOM_CATEGORY_TYPE2;
							$tags = CUSTOM_TAG_TYPE2;
						}else{
							$taxonomy = 'category';
							$tags = 'post_tag';
						}
						/* display categories of the post if show on listing enable */
						if(templ_is_show_listing_category()){
							templ_wp_categories_listing($post->ID ,$taxonomy);
						}
						/* display tags of the post if show on listing enable */
						echo "&nbsp;";
						if(templ_is_show_listing_tags()){
							templ_wp_tags_listing($post->ID ,$tags);
						}
						
						if(trim(get_option('ptthemes_listing_comment')) == trim('Yes') || !get_option('ptthemes_listing_comment') ){
						?>
						<p class="review clearfix">    
							<a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number(__('0'), __('1'), __('%')); ?> </a> 	
						
						</p>
						<?php } favourite_html($post->post_author,$post->ID); ?>
					</div>     
					</div>                      
					</div>
          <?php  
		  
		  if($post_widget_count == '3') {
				echo '<div class="hr clearfix"></div>';
				$post_widget_count = 0;
            } 
            
	 $post_widget_count++;
	 endwhile; wp_reset_query(); ?>
	</div>
	<?php }
	
	 //echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['post_type'] = strip_tags($new_instance['post_type']);
			$instance['link'] = strip_tags($new_instance['link']);
			$instance['text'] = strip_tags($new_instance['text']);
			return $instance;
		}
	 
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$number = strip_tags($instance['number']);
			$my_post_type = strip_tags($instance['post_type']);
			$link = strip_tags($instance['link']);
			$text = strip_tags($instance['text']);
	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('View All Text :','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo attribute_escape($text); ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('View All Link URL (ex.http://templatic.com/events):','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo attribute_escape($link); ?>" /></label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts:','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
	  </label>
	</p>
    <p>
		<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:','templatic')?>
		<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
		<?php
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');   
		foreach ($custom_post_types as $content_type) {
		if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post'){
		?>
			<option value="<?php _e($content_type->name);?>" <?php if(attribute_escape($my_post_type)==$content_type->name){ echo 'selected="selected"';}?>><?php _e($content_type->label);?></option>
		<?php }}?>
		</select>
		</label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>SLUGs</code> separated by commas):','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<?php
		}
	}
register_widget('templ_latest_posts_grid_view');

/* Latest Places/Events Custom Taxonomy  -->  Gridview EOC*/

//============================= Upcoming Events ==========================================
class upComingEvents extends WP_Widget {
	function upComingEvents() {
	//Constructor
		$widget_ops = array('classname' => 'widget upComing Events', 'description' => __('List of upcoming Events','templatic') );
		$this->WP_Widget('upComingEvents', __('T &rarr; Upcoming Events','templatic'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$post_number = empty($instance['post_number']) ? '3' : apply_filters('widget_post_number', $instance['post_number']);
		$more_title = empty($instance['more_title']) ? '&nbsp;' : apply_filters('widget_more_title', $instance['more_title']);
		$more_link = empty($instance['more_link']) ? '&nbsp;' : apply_filters('widget_more_link', $instance['more_link']);
		
	 ?>
         <?php
			        global $wp_query, $post;
					$current_term = $wp_query->get_queried_object();
					$blog_cat = get_blog_sub_cats_str($type='array');
					global $wpdb,$wp_query;
					$current_term = $wp_query->get_queried_object();
					$my_post_type = 'event';
					$today = date('Y-m-d');
					remove_action('pre_get_posts', 'search_filter');
					remove_filter('posts_orderby', 'feature_listing_orderby');
					$args=
					array( 'post_type' => 'event',
					'posts_per_page' => $post_number	,
					'post_status' => array('publish','private')	,
					'meta_query' => array(
						array(
							'key' => 'st_date',
							'value' => $today,
							'compare' => '>=',
							'type' => 'DATE'
						),
						array(
							'key' => 'post_city_id',
							'value' => $_SESSION['multi_city'],
							'compare' => 'LIKE'
						)
					),					
					'meta_key' => 'st_date',
					'orderby' => 'meta_value',					
					'order' => 'ASC'
					);
					$upcoming = New WP_Query($args);
					if($upcoming->have_posts())
					{
					?>
					<div class="grid clear" id="loop">					
                     <h3 class="clearfix"><span><a href="<?php echo $more_link; ?>"><?php echo $title; ?></a></span>
					<?php if ( $more_link <> "" ) { ?>	 
						   <a class="more" href="<?php echo $more_link; ?>"> <?php echo $more_title;?></a>
					<?php } ?>
							</h3>
				   <?php $pcount=0;
					while($upcoming->have_posts()) :
						$upcoming->the_post();
						$pcount++;
						$post_images =  bdw_get_images_with_info($post->ID,'large');   
					$attachment_id = $post_images[0]['id']; ?>	
				<div id="post_<?php the_ID(); ?>" <?php if((get_post_meta($post->ID,'is_featured',true) == 1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){ post_class('post featured_post');} else { post_class('post');}?>>
				<div class="post-content">
					<?php if((get_post_meta($post->ID,'is_featured',true) ==1) && ( get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){?>
							<span class="featured_img"><?php _e('featured','templatic');?></span>
					<?php }
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					$is_crop = get_option('thumbnail_crop');
					if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
					if($title ==''){ $title = $post->post_title; }
					if($alt ==''){ $alt = $post->post_title; }
					if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );
					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
					<?php
					}else {?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php _e('Image Not Available','templatic')?> </a>
					<?php } ?>
					<div class="post_content">
						<h2><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
						<?php  if($my_post_type != 'post' && get_option('ptthemes_disable_rating') == 'no') { ?><span class="rating"><?php echo get_post_rating_star($post->ID);?></span>	 <?php } ?>                    
						<p> <?php echo bm_better_excerpt(175, '',''); ?> </p> 
						<?php if(trim(get_option('ptthemes_listing_comment')) == trim('Yes') || !get_option('ptthemes_listing_comment') ){ ?>
						<p class="review clearfix">    
							<a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number(__('0','templatic'), __('1','templatic'), __('%','templatic')); ?> </a> 	
								<span class="readmore"> <a href="<?php the_permalink(); ?>"> <?php echo READ_MORE_LABEL;?> </a></span>
						</p>
						<?php } ?>
					</div>
				</div>
            </div>				 
				 
                 <?php if($pcount!=0 && ($pcount%3)==0){
				 echo '<div class="hr clearfix"></div>';
				 }
				 endwhile; ?>
</div>
 <?php }?>
<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['more_title'] = strip_tags($new_instance['more_title']);
		$instance['more_link'] = strip_tags($new_instance['more_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','character_cout' => '','more_link' => '' ) );
		$title = strip_tags($instance['title']);
		$post_number = strip_tags($instance['post_number']);
		$more_title = strip_tags($instance['more_title']);
		$more_link = strip_tags($instance['more_link']);
		
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts','templatic');?>:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('more_title'); ?>"><?php _e('More link name','templatic');?> :
  <input class="widefat" id="<?php echo $this->get_field_id('more_title'); ?>" name="<?php echo $this->get_field_name('more_title'); ?>" type="text" value="<?php echo attribute_escape($more_title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('more_link'); ?>"><?php _e('More link URL','templatic');?>:
  <input class="widefat" id="<?php echo $this->get_field_id('more_link'); ?>" name="<?php echo $this->get_field_name('more_link'); ?>" type="text" value="<?php echo attribute_escape($more_link); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('upComingEvents');
/* Recent Comments Widget */
class CommentsWidget extends WP_Widget {

	function CommentsWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Recent Review', 'description' => 'Front Page Comments' );		
		$this->WP_Widget('widget_comment', 'T &rarr; Recent Review', $widget_ops);
	}
	function widget($args, $instance) {
	 global $wpdb, $tablecomments, $tableposts,$rating_table_name;
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$my_post_type = empty($instance['post_type']) ? '' : apply_filters('widget_post_type', $instance['post_type']);
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);
 		 ?>						
		
        
        <div class="widget recent_comments_section">
        <?php 
		global $wpdb;
			
			
			if(is_plugin_active('wpml-string-translation/plugin.php')){
				$icl_table = $wpdb->prefix."icl_translations";
				$language = ICL_LANGUAGE_CODE;
				$sql = "SELECT * FROM $icl_table , $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND post_type='".$my_post_type."' AND $icl_table.language_code='".$language."' and $icl_table.element_id = $wpdb->posts.ID and $icl_table.element_type = '".'post_'.$my_post_type."' GROUP BY comment_post_ID ORDER BY comment_date_gmt DESC LIMIT $count";
			}else{
				$sql = "SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND post_type='".$my_post_type."' ORDER BY comment_date_gmt DESC LIMIT $count";	
			}
			$comments = $wpdb->get_results($sql);
			if($comments) {
		?>
        <h3> <?php echo $title; ?> </h3>
       
       	<ul class="recent_comments">
		  	<?php
			
//$comments = get_comments("number=$count");
  foreach($comments as $comm) :
 ?>
 <li class="clearfix"> 
 <?php 
  $url = '<a href="'. get_permalink($comm->comment_post_ID).'#comment-'.$comm->comment_ID .'" title="'.$comm->comment_author .' | '.get_the_title($comm->comment_post_ID).'">' . get_the_title($comm->comment_post_ID) . '</a>';
?>
<?php $user_photo = get_user_meta($comm->user_id,'user_photo',true); if($user_photo != '')  { ?>
			<img src="<?php echo $user_photo; ?>" width="40" height="40" />
	<?php } 
	else { echo get_avatar($comm->comment_author_email, 40); }?>
 <p> <span> <?php echo $url; ?> <?php _e('by','templatic');?> <?php echo $comm->comment_author;?></span>
 <span class="rating">
 <?php  $post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comm->comment_ID\"");
echo ''.draw_rating_star($post_rating);?></span>
</p>
 
<p><?php echo $comm->comment_content; ?></p>
</li>
<?php
  endforeach;
?> 
       </ul>
	   <?php }?>
	</div> 
            
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['count'] = strip_tags($new_instance['count']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'count' => '' ) );		
		$title = strip_tags($instance['title']);
		$my_post_type = strip_tags($instance['post_type']);
		$count = strip_tags($instance['count']);
 ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
		<p>
		  <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type','templatic');?>:
			<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" style="width:50%;">
				<option value="post" <?php if(attribute_escape($my_post_type)=='post'){ echo 'selected="selected"';}?>><?php _e('Post','templatic'); ?></option>
				<option value="<?php echo CUSTOM_POST_TYPE1; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE1){ echo 'selected="selected"';}?>>
				<?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
				<option value="<?php echo CUSTOM_POST_TYPE2; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE2){ echo 'selected="selected"';}?>>
				<?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
 			</select>  </label>
		</p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Reviews','templatic');?>  <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo attribute_escape($count); ?>" /></label></p>
<?php
	}}
register_widget('CommentsWidget');

/* Latest news Post, Places, Event Widget (particular category)*/
class eventwidget extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'eventwidget', // Base ID
			'T &rarr; Latest Post / Places / Event', // Name
			array( 'description' => __('List of latest posts, places, events in particular category ( Sidebar or Footer content )','templatic'), ) // Args
		);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$my_post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		global $post,$wpdb;

		if($my_post_type !='post'){
				if($my_post_type == CUSTOM_POST_TYPE1 ){ $taxonomy_slug = CUSTOM_CATEGORY_TYPE1 ; }else{ $taxonomy_slug = CUSTOM_CATEGORY_TYPE2 ; }
				if($category){
					$args = array('post_type' => $my_post_type,'posts_per_page' =>  $number	,'post_status' => array('publish'),				 
				  'tax_query' => array( array('taxonomy' => $taxonomy_slug,'field' => 'id','terms' => $category,'operator'  => 'IN') ),
					'orderby' => 'ID',
					'order' => 'DESC');
				}else{
					$args = array('post_type' => $my_post_type,'posts_per_page' =>  $number	,'post_status' => array('publish'),				 
					'orderby' => 'ID',
					'order' => 'DESC');
				}
		}else{
				/* REMOVE aLL FILTERS WHILE IT'S POSTS*/
				remove_action('pre_get_posts', 'search_filter');
				remove_filter('posts_where', 'author_filter_where');
				remove_filter('posts_where', 'searching_filter_where');			
				remove_filter('posts_orderby', 'feature_listing_orderby');
				remove_filter('posts_where', 'popular_posts_where');
				remove_filter('posts_orderby', 'author_filter_orderby');
				remove_filter('posts_orderby', 'archive_filter_orderby');
				if($category){
					$args = array(
					  'post_type' => 'post',
					  'posts_per_page' => $number,
					  'ignore_sticky_posts'=> 1,
					  'tax_query' => array(
										array(
											'taxonomy' => 'category',
											'field' => 'id',
											'terms' => $category,
											'operator'  => 'IN'
										)				
									 ),
					  'orderby' => 'ID',
					  'order' => 'DESC'
					  );
				  }
				  else
				  {
				  	$args = array(
				  'post_type' => 'post',
				  'posts_per_page' => $number,
				  'ignore_sticky_posts'=> 1,
				  'orderby' => 'ID',
				  'order' => 'DESC'
				  );
				  }
		}
		global $wp_query;
		$wp_query1 = null;
		$wp_query1 = new WP_Query($args);	
		if($wp_query1->have_posts()) {  ?>
        <h3><?php echo $title; ?></h3>
          <ul> 
		 <?php 
		 while($wp_query1->have_posts()) :
					$wp_query1->the_post(); global $post; ?>
			<?php $post_images = bdw_get_images($post->ID); ?>	
			<li class="clearfix"> 
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>  <br />
                   <span class="date"><?php the_time('j F Y') ?> <?php _e('at','templatic');?> <?php the_time('H : s A') ?>  </span> 
            </li>
	<?php endwhile; wp_reset_query();?>
		  </ul>
		<?php
		}
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$my_post_type = strip_tags($instance['post_type']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:');?>
    <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" style="width:50%;">
		<option value="post" <?php if(attribute_escape($my_post_type)=='post'){ echo 'selected="selected"';}?>><?php _e('Post','templatic'); ?></option>
		<option value="<?php echo CUSTOM_POST_TYPE1; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
		<option value="<?php echo CUSTOM_POST_TYPE2; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
			  
	</select> </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas):');?>
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts','templatic');?>
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<?php
	}

}
register_widget('eventwidget');
/* Videos Widget (particular category) */

class spotlightpost extends WP_Widget {
	function spotlightpost() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Video', 'description' => __('List of In Featured Video in particular category','templatic') );
		$this->WP_Widget('spotlight_post', __('T &rarr; Featured Video','templatic'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '6' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$video_link = empty($instance['video_link']) ? '' : apply_filters('widget_video_link', $instance['video_link']);
		$my_post_type = empty($instance['post_type']) ? '' : apply_filters('widget_post_type', $instance['post_type']);
		?>
				<?php 
			       global $post;
			       global $wpdb;
				   $my_post_type = $my_post_type;
				   if($category)
				   {
				   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
				   }
					if($_SESSION['multi_city'])
					{
						$multi_city_id = $_SESSION['multi_city'];
						$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_type='".$my_post_type."' and p.post_status='publish' and (pm.meta_key='post_city_id' and (pm.meta_value like \"%,$multi_city_id,%\" or pm.meta_value like \"$multi_city_id,%\" or pm.meta_value like \"%,$multi_city_id\" or pm.meta_value like \"$multi_city_id\" or pm.meta_value='' or pm.meta_value='0')) $subsql  order by p.post_date desc";
					}else
					{
						$sql = "select p.* from $wpdb->posts p where p.post_type='".$my_post_type."' and p.post_status='publish' $subsql order by p.post_date desc limit $post_number";
					}
					$latest_menus = $wpdb->get_results($sql);
					if($latest_menus)
					{
					?>
                    <div class="featured_video">		
                    <h3 class="clearfix"> <span class="fl"><?php echo $title; ?> </span>                 
                      <?php if ( $video_link <> "" ) { ?>	 
                       <span class="more"><a href="<?php echo $video_link; ?>"> <?php _e('View All','templatic'); ?></a> </span> 
                    <?php } ?>                 
                     </h3>
                    
                    <?php
					$i = 1;
                    foreach($latest_menus as $post) :
                    setup_postdata($post);
 			    ?>
              		 
                <?php if(get_post_meta($post->ID,'video',true) != ""){?>
                     <div class="video">
                    <?php echo get_post_meta($post->ID,'video',true);?>
                    	<h4><a class="widget-title" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h4>
                    </div>
                    <?php if($i == $post_number){ break; }?>
                    <?php $i++; }?>
                 <?php endforeach; ?>
                 </div>
                <?php }?>
				<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['video_link'] = strip_tags($new_instance['video_link']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','video_link' => '','post_type' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$video_link = strip_tags($instance['video_link']);
		$my_post_type = strip_tags($instance['post_type']);		?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>IDs</code> separated by commas)','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('video_link'); ?>"><?php _e('View All link full URL','templatic');?>:
		<input class="widefat" id="<?php echo $this->get_field_id('video_link'); ?>" name="<?php echo $this->get_field_name('video_link'); ?>" type="text" value="<?php echo attribute_escape($video_link); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type','templatic');?>:
		<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" style="width:50%;">
			<option value="<?php echo CUSTOM_POST_TYPE1; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
			<option value="<?php echo CUSTOM_POST_TYPE2; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_POST_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
				  
		</select> </label>
	</p><?php
	}
}
register_widget('spotlightpost');
/* Top place Link */
class widget_listing_link extends WP_Widget {
	function widget_listing_link() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Video', 'description' => __('Put Add place links and login module. Recommended in the &lsquo;Header: Right area&rsquo;','templatic') );
		$this->WP_Widget('listing_link', __('T &rarr; Login & Add place widget','templatic'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		?>
        
    
    <ul class="member_link menu-header">
    <?php
    global $current_user;
	$user_link = get_author_posts_url($current_user->ID);
	if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
	/* get site url when WPML is activated */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(function_exists('icl_t')){
				if(ICL_LANGUAGE_CODE !='' && ICL_LANGUAGE_CODE !='en'){
					$language = ICL_LANGUAGE_CODE;
					$site_url = site_url()."/".$language;
				}else{
					$site_url = site_url();
				}
	}else{
		$site_url = home_url();
	}
    if($current_user->ID)
    {
		if(add_filter('templ_tophdr_welcome_filter',true))
		{
		?>
		<li class="first_li"><?php echo __('Welcome, ','templatic'); ?><a href="<?php echo str_replace(' ','-',$user_link); ?>"><?php echo $current_user->display_name; ?></a></li>
		<?php
		}
		$redirect = $site_url.'/?ptype=login';
		?>
		<li><a href="<?php echo $site_url; ?>/?ptype=profile"><?php _e('Edit profile','templatic');?></a></li>
		<li><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Log out','templatic');?></a></li> 
		<?php	
    }else
    { 
		if ( get_option('users_can_register') ) { ?>
		<li><a href="<?php echo $site_url; ?>/?ptype=register"><?php _e('Register','templatic');?></a></li> <?php } ?>
		<li><a href="<?php echo $site_url; ?>/?ptype=login"><?php _e('Sign In','templatic');?></a></li> 
		<?php	
    }
	if(get_option('ptthemes_add_place_nav') == 'Yes'){
    ?>
     <li><a href="<?php echo $site_url; ?>/?ptype=post_listing"><?php _e('Add place','templatic');?></a></li> 
	<?php } 
	 if(get_option('ptthemes_add_event_nav') == 'Yes') { ?>
     <li><a href="<?php echo $site_url; ?>/?ptype=post_event"><?php _e('Add event','templatic');?></a></li> 
	<?php } ?>
    </ul>
	<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '','video_link' => '' ) );
		$title = strip_tags($instance['title']);

?>
 <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Title','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
          </label>
        </p>
<?php
	}

}

register_widget('widget_listing_link');
/* Facebook Fan widget */
if(!class_exists('templ_facebook_fanbox'))
{
	class templ_facebook_fanbox extends WP_Widget {
		function templ_facebook_fanbox() {
		//Constructor
			$widget_ops = array('classname' => 'facebook_fanbox', 'description' => apply_filters('templ_facebook_fanbox_widget_desc_filter',__('Show your facebook fans on your site.','templatic')) );
			$this->WP_Widget('widget_facebook_fan_widget', apply_filters('templ_facebook_fanbox_widget_title_filter',__('T &rarr; Facebook Fans','templatic')), $widget_ops);
		}
	
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			//echo $before_widget;
			$facebook_page_url = empty($instance['facebook_page_url']) ? '' : apply_filters('widget_facebook_page_url', $instance['facebook_page_url']);
			$width = empty($instance['width']) ? '' : apply_filters('widget_width', $instance['width']);
			$show_faces = empty($instance['show_faces']) ? '' : apply_filters('widget_show_faces', $instance['show_faces']);
			$show_stream = empty($instance['show_stream']) ? '' : apply_filters('widget_show_stream', $instance['show_stream']);
			$show_header = empty($instance['show_header']) ? '' : apply_filters('widget_show_header', $instance['show_header']);
			
			
			if($show_faces == 1) $face='true'; else $face='false';
			if($show_stream == 1) $stream='true'; else $stream='false';
			if($show_header == 1) $header='true'; else $header='false';
			?>		 
			<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like-box href="<?php echo $facebook_page_url; ?>" width="<?php echo $width; ?>" show_faces="<?php echo $face; ?>" border_color="" stream="<?php echo $stream; ?>" header="<?php echo $header; ?>"></fb:like-box>
         
		<?php
		}
	
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['facebook_page_url'] = strip_tags($new_instance['facebook_page_url']);
			$instance['width'] = strip_tags($new_instance['width']);
			$instance['show_faces'] = strip_tags($new_instance['show_faces']);
			$instance['show_stream'] = strip_tags($new_instance['show_stream']);
			$instance['show_header'] = strip_tags($new_instance['show_header']);
			
			return $instance;
	
		}
	
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array('width'=>'', 'facebook_page_url'=>'', 'show_faces'=>'', 'show_stream'=>'', 'show_header'=>'' ) );
			$facebook_page_url = strip_tags($instance['facebook_page_url']);
			$width = strip_tags($instance['width']);
			$show_faces = strip_tags($instance['show_faces']);
			$show_stream = strip_tags($instance['show_stream']);
			$show_header = strip_tags($instance['show_header']);
			
	?>
        <p>
          <label for="<?php echo $this->get_field_id('facebook_page_url'); ?>"><?php  _e('Facebook Page Full URL','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('facebook_page_url'); ?>" name="<?php echo $this->get_field_name('facebook_page_url'); ?>" type="text" value="<?php echo attribute_escape($facebook_page_url); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php  _e('Width','templatic')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
          </label>
        </p> 
		<p>
		  <label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php  _e('Show Faces','templatic')?>:
		  <select id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" style="width:50%;">
			  <option value="1" <?php if(attribute_escape($show_faces)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
			  <option value="0" <?php if(attribute_escape($show_faces)=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
		  </select>
		  </label>
		</p>		
		<p>
          <label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php  _e('Show Stream','templatic')?>:
          <select id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" style="width:50%;">
			  <option value="1" <?php if(attribute_escape($show_stream)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
			  <option value="0" <?php if(attribute_escape($show_stream)=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
		  </select>
          </label>
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('show_header'); ?>"><?php  _e('Show Header','templatic')?>:
            <select id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" style="width:50%;">
			  <option value="1" <?php if(attribute_escape($show_header)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
			  <option value="0" <?php if(attribute_escape($show_header)=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
			</select>
          </label>
        </p>
       
	<?php
		}
	
	}
	register_widget('templ_facebook_fanbox');
}
/* Create the function to output the contents of our claim ownership Dashboard Widget BOF */
 function call_widget_js()
 {
 	wp_enqueue_script('script', get_template_directory_uri() .'/js/widget.js', 'jquery', false); 
 }
 add_action('admin_init', 'call_widget_js', 1);
	function claimownership_dashboard_widget_function() { 
	if((!isset($_REQUEST['dummy']) && @$_REQUEST['dummy']=='') && (!isset($_REQUEST['dummy_insert']) && @$_REQUEST['dummy_insert']=='') && strstr($_SERVER['REQUEST_URI'],'/wp-admin/')) { ?>
	<script type="text/javascript">
	/* <![CDATA[ */
	function confirmSubmit(str) {
			var answer = confirm("<?php echo DELETE_CONFIRM_ALERT; ?>");
			if (answer){
				window.location = "<?php echo home_url(); ?>/wp-admin/index.php?poid="+str;
				alert('<?php echo ENTRY_DELETED; ?>');
			}
		}
	/* ]]> */
	</script>
	<?php } 
	global $wpdb,$claim_db_table_name ;
	
	$claimreq = $wpdb->get_results("select * from $claim_db_table_name where status = '0'");
	echo "<table class='widefat'>
	<tr>
			<th>".ID_TEXT."</th>
			<th>".TITLE_TEXT."</th>
			<th>".AUTHOR_NAME_TEXT."</th>
			<th>".CLAIMER_TEXT."</th>
			<th>".CONTACT_NUM_TEXT."</th>
			<th>".ACTION_TEXT."</th></tr>";
	if(mysql_affected_rows() > 0)
	{	$counter =0;
		foreach($claimreq as $cro)
		{
			$udata = get_userdata($cro->author_id);
			echo "<tr><td>".$cro->post_id."</td>
			<td>".$cro->post_title."</td>
			<td>".$udata->user_login."</td>
			<td>".$cro->full_name."</td>
			<td>".$cro->contact_number."</td>
			<td>"; ?>
			 <a href="javascript:void(0);claimer_showdetail('<?php echo $cro->clid;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Details','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
			<a href="<?php echo home_url().'/wp-admin/post.php?post='.$cro->post_id.'&action=edit&verified=yes&clid='.$cro->clid ;?>" title="<?php _e('Verify this post','templatic');?>"><img style="width:16px; height:16px;" src="<?php echo get_template_directory_uri(); ?>/images/accept.png" alt="<?php _e('Verify','templatic');?>" border="0" /></a> &nbsp;&nbsp;
			<a href="<?php echo home_url().'/wp-admin/post.php?post='.$cro->post_id.'&action=edit';?>" title="<?php _e('View post','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/view.png" alt="<?php _e('View','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
			<a href="javascript:void(0);" onclick="return confirmSubmit(<?php echo $cro->clid; ?>);" title="<?php _e('Delete','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete this request','templatic');?>" border="0" /></a>
		<?php	echo "</td>
			</tr>"; ?>
			<tr id='<?php echo "comments_".$cro->clid; ?>' style='display:none; padding:5px;'><td colspan="7"><?php echo $cro->comments; ?> </td></tr>
		<?php 
		$c = $counter ++;
		}
	}else{
		echo "<tr><td colspan='6'>No claim request</td></tr>";
	}
	echo "</table>";
	} 
	/* Create the function to output the contents of our claim ownership Dashboard Widget EOF */
	/* to display widget */
	function claim_ownership_widgets() { 
		
		wp_add_dashboard_widget('claim_dashboard_widget', 'Ownership claims', 'claimownership_dashboard_widget_function');
		global $wp_meta_boxes;
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		$example_widget_backup = array('claim_dashboard_widget' => $normal_dashboard['claim_dashboard_widget']);
		unset($normal_dashboard['claim_dashboard_widget']);
		$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	} 

/* -- neighborhood posts Widget (particular category) -- */
	
class neighborhood extends WP_Widget {
	function neighborhood() {
	//Constructor
		$widget_ops = array('classname' => 'widget In the neighborhood', 'description' => __('In the neighborhood Post List ','templatic') );
		$this->WP_Widget('neighborhood', __('PT &rarr; In the neighborhood','templatic'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '' : apply_filters('widget_post_link', $instance['post_link']);
		$closer_factor = empty($instance['closer_factor']) ? '0' : apply_filters('widget_closer_factor', $instance['closer_factor']);

		global $wpdb,$post,$thumb_url,$single_post;
		$post=$single_post;
		$current_post = $post->ID;
		if($category)
		{
			global $wpdb;
		   $my_post_type = "'place','event'";
		   if($category)
		   {
		   	$subsql = "and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category) )";
		   }
			if($_SESSION['multi_city'])
			{
				$multi_city_id = $_SESSION['multi_city'];
				$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.ID!=$current_post and p.post_type in (".$my_post_type.") and (pm.meta_key='post_city_id' and (pm.meta_value like \"%,$multi_city_id,%\" or pm.meta_value like \"$multi_city_id,%\" or pm.meta_value like \"%,$multi_city_id\" or pm.meta_value like \"%$multi_city_id%\" or pm.meta_value='' or pm.meta_value='0')) and p.post_status='publish' $subsql order by p.post_date desc";
				
			}else
			{
				$sql = "select p.* from $wpdb->posts p where  p.ID!=$current_post and p.post_type in (".$my_post_type.") and p.post_status='publish' $subsql order by p.post_date desc";
			}
			
			$latest_menus = $wpdb->get_results($sql);
		}else
		{
			
			$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
			if($geo_latitude)
			{
				$geo_latitude_arr = explode('.',$geo_latitude);
				if($geo_latitude_arr[1])
				{
					$geo_latitude = $geo_latitude_arr[0].'.'.substr($geo_latitude_arr[1],0,$closer_factor);
				}else
				{
					$geo_latitude = $geo_latitude_arr[0];	
				}
			}
			$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
			if($geo_longitude)
			{
				$geo_latitude_arr = explode('.',$geo_longitude);
				if($geo_latitude_arr[1])
				{
					$geo_longitude = $geo_latitude_arr[0].'.'.substr($geo_latitude_arr[1],0,$closer_factor);
				}else
				{
					$geo_longitude = $geo_latitude_arr[0];	
				}
			}
			
			if($_SESSION['multi_city'])
			{ 
			$multi_city_id = $_SESSION['multi_city'];
			$sql= "select post_id from $wpdb->postmeta where meta_key like \"geo_latitude\" and (meta_value like\"$geo_latitude%\") and post_id!=\"$current_post\" and post_id in (select post_id from $wpdb->postmeta where meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \",$multi_city_id%\" or $wpdb->postmeta.meta_value like \"%$multi_city_id%\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))";
				$post_lat = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_latitude\" and (meta_value like\"$geo_latitude%\") and post_id!=\"$current_post\" and post_id in (select post_id from $wpdb->postmeta where meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \",$multi_city_id%\" or $wpdb->postmeta.meta_value like \"%$multi_city_id%\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))");
				$post_lng = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_longitude\" and (meta_value like\"$geo_longitude%\") and post_id!=\"$current_post\" and post_id in (select post_id from $wpdb->postmeta where meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"%$multi_city_id%\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))");
			}else
			{
				$post_lat = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_latitude\" and (meta_value like\"$geo_latitude%\") and post_id!=\"$current_post\"");
				$post_lng = $wpdb->get_col("select post_id from $wpdb->postmeta where meta_key like \"geo_longitude\" and (meta_value like\"$geo_longitude%\") and post_id!=\"$current_post\"");
			}
					
			if(1)
			{
				$post_id_arr = array();
				if($post_lat && $post_lng)
				{
					$post_id_arr = array_intersect($post_lat,$post_lng);
				}
				$post_id_arr = array_slice($post_id_arr,0,$post_number);
				$post_ids = implode(',',$post_id_arr);
			}
			
			if($post_ids)
			{
				$post_ids1 = get_post($post_ids);
				if($post_ids){$post_ids_include = "&include=$post_ids&post_type=$post_ids1->post_type";}
				$current_post = $post->ID;
				$latest_menus = get_posts('numberposts='.$post_number.$post_ids_include);
			}
		}
		$pcount=0;
		//print_r($latest_menus);
		if($latest_menus)
		{
		 ?>
          <h3> <?php echo $title; ?> </h3>
          <ul class="recent_comments">
				<?php
					foreach($latest_menus as $post) :	setup_postdata($post);				
                   $comment_info = get_comment_count($post->ID);
				   
				   	$post_images = bdw_get_images_with_info($post->ID,'large');
					$attachment_id = $post_images[0]['id'];
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					$width = 40;
					$height = 40;
					$is_crop = true;
					if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
					if($title ==''){ $title = $post->post_title; }
					if($alt ==''){ $alt = $post->post_title; }
					
					
			    ?>
				
           		<li class="clearfix">
            	 <?php if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );?>
                   <a  href="<?php echo get_permalink($post->ID); ?>"><img src="<?php echo $crop_image['url']; ?>" alt="<?php echo get_the_title($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>" class="thumb" /> </a>
            <?php } else { ?> 
						 <a  href="<?php echo get_permalink($post->ID); ?>"><span class="img_available">   <?php _e('Image not available');?> </span></a>
				<?php }?>          
            
					<a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a>
					<?php  if(get_option('ptthemes_disable_rating') == 'no') {  ?>

                    <span class="rating"> <?php echo get_post_rating_star($post->ID);?></span>
					<?php } ?>
            <?php echo '<span class="comment_excerpt">'.templ_listing_content($post).'</span>'; ?>
         	 </li>
             <?php
             
			if($pcount==($post_number - 1))
			{
				break;	
			}
			$pcount++;
			 ?>
<?php endforeach; ?>
 </ul>
<?php
		echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['closer_factor'] = strip_tags($new_instance['closer_factor']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'closer_factor'=>'2' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$closer_factor = strip_tags($instance['closer_factor']); ?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','tempaltic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category (<code>IDs</code> separated by commas)','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('closer_factor'); ?>"><?php _e('Show Listings From','templatic');?>
	 <select id="<?php echo $this->get_field_id('closer_factor'); ?>" name="<?php echo $this->get_field_name('closer_factor'); ?>">
	  <option value="0" <?php if(attribute_escape($closer_factor)=='0'){ echo 'selected="selected"';} ?>><?php _e('So Far Away','templatic');?></option>
	  <option value="1" <?php if(attribute_escape($closer_factor)=='1'){ echo 'selected="selected"';} ?>><?php _e('Far Away','templatic');?></option>
	  <option value="2" <?php if(attribute_escape($closer_factor)=='2'){ echo 'selected="selected"';} ?>><?php _e('At Some Distant','templatic');?></option>
	  <option value="3" <?php if(attribute_escape($closer_factor)=='3'){ echo 'selected="selected"';} ?>><?php _e('Nearer','templatic');?></option>
	  <option value="4" <?php if(attribute_escape($closer_factor)=='4'){ echo 'selected="selected"';} ?>><?php _e('Very Near','templatic');?></option>
	  </select>
	  </label>
	</p> 
	<?php
	}
}
register_widget('neighborhood');

//add_filter('posts_where','nearby_filter',10,4); 
function nearby_filter($where){
	global $wpdb,$current_post,$miles;
	$geo_latitude=get_post_meta($current_post,'geo_latitude',true);
	$geo_longitude=get_post_meta($current_post,'geo_longitude',true);			

	$postcode = $wpdb->prefix."postcodes";
	$where .= " AND ($wpdb->posts.ID in (SELECT post_id FROM $postcode WHERE truncate((degrees(acos( sin(radians(`latitude`)) * sin( radians('".$geo_latitude."')) + cos(radians(`latitude`)) * cos( radians('".$geo_latitude."')) * cos( radians(`longitude` - '".$geo_longitude."') ) ) ) * 69.09),1) <= ".$miles." ORDER BY truncate((degrees(acos( sin(radians(`latitude`)) * sin( radians('".$geo_latitude."')) + cos(radians(`latitude`)) * cos( radians('".$geo_latitude."')) * cos( radians(`longitude` - '".$geo_longitude."') ) ) ) * 69.09),1) ASC))";
	return $where;
}
/**
 * neighborhood posts Widget by miles 
 */
class neighborhood_bymiles extends WP_Widget {
	function neighborhood_bymiles() {
	//Constructor
		$widget_ops = array('classname' => 'widget In the neighborhood by miles', 'description' => __('In the neighborhood Post List by miles ','templatic') );
		$this->WP_Widget('neighborhood_bymiles', __('PT &rarr; In the neighborhood by miles','templatic'), $widget_ops);
	}
	
	/*
	 * Display the neighborhood post by given miles on font side
	 */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		global $miles;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']); 		
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);		
		$radius = empty($instance['radius']) ? '0' : apply_filters('widget_closer_factor', $instance['radius']);
		if(strtolower(get_option('pttthemes_milestone_unit')) == strtolower('Kilometer')){
			$miles = $radius * 0.621;
		}else{
			$miles = $radius;	
		}
		global $wpdb,$post,$thumb_url,$single_post,$miles;		
		global $current_post;
 		$current_post = $post->ID;	
		global $current_post;		
		$current_post_details=get_post($post->ID);
		$current_post_type=$current_post_details->post_type;
		$post_type = $post->post_type;
		$post_meta=get_post_custom($post->ID);	
		
		$multi_city_id = $_SESSION['multi_city'];
		$post_meta=$wpdb->prefix."postmeta";

		add_filter('posts_where','nearby_filter'); 
					
		$args = array(
		'post__not_in' => 	array($current_post) ,
		'post_type' => 		$post_type,
		'posts_per_page' => $post_number,
		'ignore_sticky_posts'=> 1
		);

		//global $wp_query;
		$wp_query_near = null;
		$wp_query_near = new WP_Query($args);		

		$pcount=0;		
		?>
        <div class="neighborhood_bymiles">
         <h3> <?php echo $title; ?> </h3>          
        <?php
		if($wp_query_near->have_posts()):
			echo '<ul class="recent_comments">';
		while($wp_query_near->have_posts())
		{
			$wp_query_near->the_post();			
			$post_images = bdw_get_images_with_info(get_the_ID(),'large');			
			$attachment_id = $post_images[0]['id'];
			$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			$attach_data = get_post($attachment_id);
			$width = 40;
			$height = 40;
			$is_crop = true;
			if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
			if($title ==''){ $title = $post->post_title; }
			if($alt ==''){ $alt = $post->post_title; }
			?>
			<li class="nearby clearfix">
            	 <?php if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );?>
                   <a  href="<?php echo get_permalink($post->post_id); ?>"><img src="<?php echo $crop_image['url']; ?>" alt="<?php echo get_the_title($post->post_id); ?>" title="<?php echo get_the_title($post->post_id); ?>" class="thumb" /> </a>
            <?php } else { ?> 
						 <a  href="<?php echo get_permalink($post->post_id); ?>"><span class="img_available">   <?php _e('Image not available','templatic');?> </span></a>
				<?php }?>          
            
					<a href="<?php echo get_permalink($post->post_id); ?>"><?php the_title(); ?></a>
					<?php  if(get_option('ptthemes_disable_rating') == 'no') {  ?>

                    <span class="rating"> <?php echo get_post_rating_star($post->post_id);?></span>
					<?php } 
					the_excerpt(); ?>
         	 </li>
			<?php
			if($pcount==($post_number - 1))			
				break;	
				
			$pcount++;
		}
		echo "</ul>";
		
		else:
		?>
        <p class="clearfix"><?php 
			$no_result='No any near miles '.$current_post_type.' to related '.$current_post_type.'.';
		_e($no_result,'templatic');?></p>
        <?php
		endif;
		remove_filter('posts_where','nearby_filter'); 
		wp_reset_query();
		?>

        </div>
        <?php
		echo $after_widget;
	}
	
	/*
	 * Update neighbord post by miles form
	 */
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);		
		$instance['post_number'] = strip_tags($new_instance['post_number']);		
		$instance['radius'] = strip_tags($new_instance['radius']);
		return $instance;		
	}
	
	/*
	 * Display neighborhood post by miles form
	 */
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'closer_factor'=>'2' ) );
		$title = strip_tags($instance['title']);		
		$post_number = strip_tags($instance['post_number']);		
		$closer_factor = strip_tags($instance['radius']); ?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>	
	<p>
	  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts','templatic'); ?>
	  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
	  </label>
	</p>
	<p>
	 <label for="<?php echo $this->get_field_id('radius'); ?>"><?php _e('Show Listings From','templatic');?>
	 <select id="<?php echo $this->get_field_id('radius'); ?>" name="<?php echo $this->get_field_name('radius'); ?>">
          <option value="1" <?php if(attribute_escape($closer_factor)=='1'){ echo 'selected="selected"';} ?>><?php _e('1 mile','templatic'); ?></option>
          <option value="5" <?php if(attribute_escape($closer_factor)=='5'){ echo 'selected="selected"';} ?>><?php _e('5 miles','templatic'); ?></option>
          <option value="10" <?php if(attribute_escape($closer_factor)=='10'){ echo 'selected="selected"';} ?>><?php _e('10 miles','templatic'); ?></option>
          <option value="100" <?php if(attribute_escape($closer_factor)=='100'){ echo 'selected="selected"';} ?>><?php _e('100 miles','templatic'); ?></option>
          <option value="1000" <?php if(attribute_escape($closer_factor)=='1000'){ echo 'selected="selected"';} ?>><?php _e('1000 miles','templatic'); ?></option>
          <option value="5000" <?php if(attribute_escape($closer_factor)=='5000'){ echo 'selected="selected"';} ?>><?php _e('5000 miles','templatic'); ?></option>      
	  </select>
	  </label>
	</p> 
	<?php
	}
} 
register_widget('neighborhood_bymiles');

/** Event Calendar widget BOC **/

class my_event_calender_widget extends WP_Widget {
	function my_event_calender_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Event Listing calender.', 'description' => 'Event Listing calendar' );		
		$this->WP_Widget('event_calendar', 'T &rarr; Event Listing Calendar', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		global $post;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		include_once (get_template_directory() . '/library/calendar/calendar.php');
		if($title)
		{
		echo '<h3>'.$title.'</h3>';	
		}
		get_my_event_calendar();
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );		
		$title = strip_tags($instance['title']);
		?><p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php  _e('Title')?>:
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
			</label>
		</p>
        <?php
	}}
register_widget('my_event_calender_widget');

/** Event Calendar widget EOC **/	

if(file_exists(get_template_directory() . '/library/map/home_map_widget.php'))
{
	include_once (get_template_directory() . '/library/map/home_map_widget.php');
}
if(file_exists(get_template_directory() . '/library/map/listing_map_widget.php')){
	include_once (get_template_directory() . '/library/map/listing_map_widget.php');
}
if(file_exists(get_template_directory() . '/library/map/single_map_widget.php')) {
	include_once (get_template_directory() . '/library/map/single_map_widget.php');
}

/******Category listing widget BOF*******/

class category_listing extends WP_Widget {
	function category_listing() {
	//Constructor
		$widget_ops = array('classname' => 'widget Category wise listing', 'description' => __('List of events or places categories (Sidebar or Footer widget areas)','templatic') );
		$this->WP_Widget('category_listing', __('T &rarr; Category wise listing','templatic'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_category_type = empty($instance['post_category_type']) ? '' : apply_filters('widget_post_type', $instance['post_category_type']);
		$show_count = empty($instance['show_count']) ? '' : apply_filters('widget_show_count', $instance['show_count']);

		 global $post;
	
		//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
		$orderby = 'name';
		$show_count = $show_count; // 1 for yes, 0 for no
		$pad_counts = 0; // 1 for yes, 0 for no
		$hierarchical = 1; // 1 for yes, 0 for no
		$taxonomy = $post_category_type;
		
		$args = array(
		  'orderby' => $orderby,
		  'show_count' => $show_count,
		  'pad_counts' => $pad_counts,
		  'hierarchical' => $hierarchical,
		  'taxonomy' => $taxonomy,
		  'title_li' => ''
		);
		echo "<h3>".$title."</h3>";
		?>
		<ul class="categorywise_listing_widget">
	
    <?php 
	global $wpdb;
	 $hiterms = get_terms($taxonomy, array("orderby" => $orderby, "parent" => 0)); ?>
    <?php foreach($hiterms as $key => $hiterm) : ?>
        <li>
            <?php echo '<a href="'.get_term_link($hiterm->slug, $taxonomy).'">'.$hiterm->name; 
			if($_SESSION['multi_city'])
			{
				$multi_city_id = $_SESSION['multi_city'];
				$sql = " select count($wpdb->posts.ID) as count from $wpdb->posts,$wpdb->term_relationships,$wpdb->term_taxonomy  where  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0') and $wpdb->posts.post_status='publish' ) and $wpdb->term_relationships.object_id = $wpdb->posts.ID and $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id and $wpdb->term_taxonomy.term_id = $hiterm->term_id) ";
				$count_category_city_wise = $wpdb->get_row($sql);
				if($show_count):
				echo " (".$count_category_city_wise->count.")";
				endif; 
				echo "</a>";
			}
			?>
            <?php $loterms = get_terms($taxonomy, array("orderby" => $orderby, "parent" => $hiterm->term_id)); //print_r($hiterms); ?>
            <?php if($loterms) : ?>
                <ul>
                    <?php foreach($loterms as $key => $loterm) : ?>
                        <li><?php echo '<a href="'.get_term_link($loterm->slug, $taxonomy).'">'.$loterm->name;
						if($_SESSION['multi_city'])
						{
							$multi_city_id = $_SESSION['multi_city'];
							$sql = " select count($wpdb->posts.ID) as count from $wpdb->posts,$wpdb->term_relationships,$wpdb->term_taxonomy  where  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0') and $wpdb->posts.post_status='publish' ) and $wpdb->term_relationships.object_id = $wpdb->posts.ID and $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id and $wpdb->term_taxonomy.term_id = $loterm->term_id) ";
							$count_category_city_wise = $wpdb->get_row($sql);
							if($show_count):
							echo " (".$count_category_city_wise->count.")";
							endif;
							echo "</a>";
						}
						 ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>

		<?php
		//wp_list_categories($args);
		?>
		</ul>
	<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_category_type'] = strip_tags($new_instance['post_category_type']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$my_post_type = strip_tags($instance['post_category_type']);
		$show_count = strip_tags($instance['show_count']);
	?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_category_type'); ?>"><?php _e('Post type','templatic');?>
		 <select id="<?php echo $this->get_field_id('post_category_type'); ?>" name="<?php echo $this->get_field_name('post_category_type'); ?>" style="width:50%;">
			<option value="<?php echo CUSTOM_CATEGORY_TYPE1; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_CATEGORY_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
			<option value="<?php echo CUSTOM_CATEGORY_TYPE2; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_CATEGORY_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
				  
		</select>
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show post count with category','templatic');?>:
		<select id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" style="width:50%;">
			<option value="1" <?php if(attribute_escape($show_count)==1){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
			<option value="0" <?php if(attribute_escape($show_count)==0){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
				  
		</select> </label>
	</p>
	<?php
	}
}
register_widget('category_listing');
/* Category listing widget EOF */

/* Tag listing widget BOF */
class tag_listing_widget extends WP_Widget {
	function tag_listing_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget tag wise listing', 'description' => __('List of  places, events in particular tag ( Sidebar or Footer content )','templatic') );
		$this->WP_Widget('tag_listing_widget', __('T &rarr; Tag wise listing','templatic'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_tag_type = empty($instance['post_tag_type']) ? '' : apply_filters('widget_post_type', $instance['post_tag_type']);
		$show_count = empty($instance['show_count']) ? '' : apply_filters('widget_show_count', $instance['show_count']);

		 global $post;
	
		//list terms in a given taxonomy using wp_tag_cloud (also useful as a widget)
		$orderby = 'name';
		$show_count = $show_count; // 1 for yes, 0 for no
		$pad_counts = 0; // 1 for yes, 0 for no
		$hierarchical = 1; // 1 for yes, 0 for no
		$taxonomy = $post_tag_type;
		if(!$taxonomy){ $taxonomy = CUSTOM_TAG_TYPE1; }
		$args = array(
		'smallest'                  => 8, 
		'largest'                   => 22,
		'unit'                      => 'pt', 
		'number'                    => $show_count,  
		'format'                    => 'flat',
		'separator'                 => " ",
		'orderby'                   => 'name', 
		'order'                     => 'ASC',
		'exclude'                   => null, 
		'include'                   => null, 
		'topic_count_text_callback' => default_topic_count_text,
		'link'                      => 'view', 
		'taxonomy'                  => $taxonomy, 
		'echo'                      => true );
		echo "<h3>".$title."</h3>";
		?>
		<ul class="tagwise_listing_widget">
		<?php
		wp_tag_cloud( $args );
		?>
		</ul>
	<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_tag_type'] = strip_tags($new_instance['post_tag_type']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$my_post_type_tag = strip_tags($instance['post_tag_type']);
		$show_count = strip_tags($instance['show_count']);
		if(!$show_count){ $show_count = "45"; } ?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_tag_type'); ?>"><?php _e('Post type','templatic');?>
		 <select id="<?php echo $this->get_field_id('post_tag_type'); ?>" name="<?php echo $this->get_field_name('post_tag_type'); ?>" style="width:50%;">
			<option value="<?php echo CUSTOM_TAG_TYPE1; ?>" <?php if(attribute_escape($my_post_type_tag)== CUSTOM_TAG_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
			<option value="<?php echo CUSTOM_TAG_TYPE2; ?>" <?php if(attribute_escape($my_post_type_tag)== CUSTOM_TAG_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
				  
		</select>
	  </label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show number of tags','templatic');?>

			<input class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="text" value="<?php echo attribute_escape($show_count); ?>" /></label>

	</p><?php
	}
}
register_widget('tag_listing_widget');

/* Tag listing widget EOF */

/* Latest Posts/News  Widget  BOC */	

class templ_latest_posts_widget extends WP_Widget {
	
		function templ_latest_posts_widget() {
		//Constructor
		global $thumb_url,$wpdb;
			$widget_ops = array('classname' => 'widget special', 'description' => apply_filters('templ_latest_posts_widget',__('Show Latest posts/News on home page.','templatic')) );
			$this->WP_Widget('templ_latest_posts_widget',apply_filters('templ_latest_posts_widget',__('T &rarr; Latest posts/news for home page. ','templatic')), $widget_ops);
		}
	 
		function widget($args, $instance) {
		// prints the widget
			
			extract($args, EXTR_SKIP);
	 
			//echo $before_widget;
			$category = "";
			$title = empty($instance['title']) ? 'Latest News' : apply_filters('widget_title', $instance['title']);
		    $category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
			$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
			$link = empty($instance['link']) ? '' : apply_filters('widget_link', $instance['link']);
			$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
			$view = empty($instance['view']) ? 'grid' : apply_filters('widget_view', $instance['view']);
			global $wpdb,$query_string;
			global $post;
			$arg = '';
			
			$post_widget_count = 1;
			$args = array(
				  'post_type' => 'post',
				  'posts_per_page' => $number,
				  'ignore_sticky_posts'=> 1,
				  'category_name' =>  $category 
				  );
			global $wp_query;
			$my_query = null;
			remove_action('pre_get_posts', 'search_filter');
			remove_filter('posts_where', 'searching_filter_where');			
			remove_filter('posts_orderby', 'feature_listing_orderby');
			$my_query = new WP_Query($args);
			//print_r($my_query); // if ant problem - to find out uncomment the line
			if( $my_query->have_posts() ) {
	 ?>
			<div id="loop" class="<?php echo $view; ?> clear">
			<?php if($title){ ?> 
				<h3><span><?php _e($title,'templatic');?></span>
				<?php if($link){?><a href="<?php _e($link,'templatic');?>" class="more" ><?php _e($text,'templatic');?></a><?php }?></h3> <?php }?>
          
			 <?php while($my_query->have_posts()) :	$my_query->the_post();
				$post_images =  bdw_get_images_with_info($post->ID,'thumb');   
				$attachment_id = $post_images[0]['id']; ?>				
			<div id="post_<?php the_ID(); ?>" <?php if((get_post_meta($post->ID,'is_featured',true) == 1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){ post_class('post featured_post');} else { post_class('post');}?>>
				<div class="post-content">
			
					<?php if((get_post_meta($post->ID,'is_featured',true) ==1) && (get_post_meta($post->ID,'featured_type',true) =="both" || get_post_meta($post->ID,'featured_type',true) =="h")){?>
					<span class="featured_img"><?php _e('featured','templatic');?></span>
					<?php }
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					$is_crop = get_option('thumbnail_crop');
					if($is_crop == 1){ $is_crop = 'true'; }else{ $is_crop = 'false'; }
					if($title ==''){ $title = $post->post_title; }
					if($alt ==''){ $alt = $post->post_title; }
					if($post_images[0]['file']){  
					$crop_image = vt_resize($attachment_id, $post_images[0]['file'], $width, $height, $crop = $is_crop );

					?>
						<a class="post_img" href="<?php the_permalink(); ?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>"  /> </a>
					<?php
					}else{?>
						<a class="img_no_available" href="<?php the_permalink(); ?>"> <?php _e('Image Not Available','templatic');?> </a>
					<?php } ?>
						
					<div class="post_content">
						<h2><a class="widget-title" href="<?php the_permalink(); ?>"><?php __(the_title(),'templatic'); ?></a></h2> 
						<div class="post_right">
							<?php if(get_option('default_comment_status') == 'open'){ ?>
							<a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number(__('0 '.REVIEWS.'','templatic'), __('1 '.REVIEW.'','templatic'), __('% '.REVIEWS.'','templatic')); ?> </a> 	
							<?php } ?>
					
						</div>
						<p class="address"><?php echo get_post_meta($post->ID,'geo_address',true);?></p>
						<p> <?php 	echo excerpt(get_option('ptthemes_content_excerpt_count')); //echo bm_better_excerpt(175, ''); ?> </p> 
					</div>     
                </div>
			</div>
		
			<?php 
			if($view =='grid'){
			if($post_widget_count == '3') {
				echo '<div class="hr clearfix"></div>';
				$post_widget_count = 0;
            } }
            $post_widget_count++; ?>
		<?php endwhile;  ?>
			</div>	
		<?php	} 
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['view'] = strip_tags($new_instance['view']);
			$instance['link'] = strip_tags($new_instance['link']);
			$instance['text'] = strip_tags($new_instance['text']);
			return $instance;
		}
	 
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
			$title = strip_tags($instance['title']);
			$category = strip_tags($instance['category']);
			$number = strip_tags($instance['number']);
			$view = strip_tags($instance['view']);
			$link = strip_tags($instance['link']);
			$text = strip_tags($instance['text']);
	?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('View All Text','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo attribute_escape($text); ?>" /></label>
	</p>
    <p>
		<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('View All Link URL (ex.http://templatic.com/events)','templatic');?> <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo attribute_escape($link); ?>" /></label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($number); ?>" />
	  </label>
	</p>
    <p>
		<label for="<?php echo $this->get_field_id('view'); ?>"><?php _e('View','templatic')?>
		<select id="<?php echo $this->get_field_id('view'); ?>" name="<?php echo $this->get_field_name('view'); ?>">
				<option value="list" <?php if($view == 'list'){ echo 'selected="selected"';}?>><?php _e('List view','templatic');?></option>
				<option value="grid" <?php if($view == 'grid'){ echo 'selected="selected"';}?>><?php _e('Grid view','templatic');?></option>
		</select>
		</label>
	</p>
	<p>
	  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories (<code>Slugs</code> separated by commas)','templatic');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
	  </label>
	</p>
	<?php
		}
	}
	register_widget('templ_latest_posts_widget');	
/* Latest Posts/News  Widget  EOC*/	
?>