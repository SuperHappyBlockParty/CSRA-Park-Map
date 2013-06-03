<?php 
// Excerpt length
function bm_better_excerpt($length, $ellipsis,$post='') {
global $post;
if(get_the_excerpt() != ''){
	$text = get_the_excerpt();
} else {
	$text = get_the_content();
}

$text = substr($text, 0, $length);
$text = substr($text, 0, strrpos($text, " "));
$text = $text.$ellipsis;
return $text;
}
 function tmpl_excerpt_length($length) { 
 global $post;
	if(get_option('ptthemes_content_excerpt_count') !=""){
	$length = get_option('ptthemes_content_excerpt_count') ;
	}else{
	$length = 30 ;
	}
	return $length;
}
add_filter('excerpt_length', 'tmpl_excerpt_length'); 

function tmpl_excerpt_more($more)
{
global $post;
return str_replace('[...]', '<a href="'.get_permalink($post->ID).'"  class="read_more">'.READ_MORE_LABEL.'</a>',$more);
}
add_filter('excerpt_more', 'tmpl_excerpt_more');

 ///////////NEW FUNCTIONS  START//////
function bdw_get_images($iPostID,$img_size='thumb',$no_images='') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$counter = 0;
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id,'medium'); //THE medium SIZE IMAGE INSTEAD		 
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}
			$counter++;
			if($no_images!='' && $counter==$no_images)
			{
				break;	
			}
	   }
	  return $return_arr;
	}
}

function get_site_emailId()
{
	return get_option('admin_email');
}
function get_site_emailName()
{
	
	if(get_option('ptthemes_site_name'))
	{
		return stripslashes(get_option('ptthemes_site_name'));	
	}
	return stripslashes(get_option('blogname'));
}


/************************************
//FUNCTION NAME : commentslist
//ARGUMENTS :comment data, arguments,depth level for comments reply
//RETURNS : Comment listing format
***************************************/
function commentslist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
global $wpdb,$post,$rating_table_name;
	?>
    
    
   <li >
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?> >
    <div class="comment_left"> 
	<span class="gravatar_bg"> </span>
    <?php 
		foreach($comment as $key=> $_comment)
		{
			if($key == 'comment_author_email')
			 {
				$email_id = $_comment;
				break;
			 }
		}
	$user = get_userdata($comment->user_id);
	 	$user_id = $user->ID;
	?>
	<?php $user_photo = get_user_meta($user_id,'user_photo',true); if($user_photo != '')  { ?>
			<img src="<?php echo $user_photo; ?>" width="65" height="65" />
	<?php } 
	else { echo get_avatar($email_id, 60); } ?>
    </div>
    <div class="comment-text">
       
        <p class="comment-author"> <?php printf(__('<span>%s</span>','templatic'), get_comment_author_link()) ?>, <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></p>
        <?php if(get_option('ptthemes_disable_rating') == 'no' && ($post->post_type == CUSTOM_POST_TYPE1 || $post->post_type == CUSTOM_POST_TYPE2)) { ?>
         <span class="single_rating"> 
        <?php  
		$post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comment->comment_ID\"");
		echo draw_rating_star($post_rating);?>
        	</span> 
		<?php } ?>
      
      	 <?php if ($comment->comment_approved == '0') : ?>
      
        <?php _e('Your comment is awaiting moderation.','templatic') ?>
     
      <?php endif; ?>
      
      <?php comment_text() ?>
      
      
 	  <?php// edit_comment_link(__('+ Edit'),'  ','') ?>
      
      <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  
     
    </div>
  </div>
    
	
<!-- add to calendar section start -->
    
<?php
}
/****--add function to check widget is available r not BOF--***/
function is_sidebar_active($index) {
    global $wp_registered_sidebars;
    $widgetcolums = wp_get_sidebars_widgets();
    if ($widgetcolums[$index])
    return true;
    return false;
}
/**-Widget function EOF-**/
function get_formated_date($date)
{
	return mysql2date(get_option('date_format'), $date);
}
function get_formated_time($time)
{
	return mysql2date(get_option('time_format'), $time, $translate=true);;
}

function get_add_to_calender($args=array('outlook'=>1,'google_calender'=>1,'yahoo_calender'=>1,'ical_cal'=>1))
{
	global $post;
	if($args)
	{
		$icalurl = get_event_ical_info($post->ID);
		
?>
<div class="i_addtocalendar"> <a href="#"><?php _e('Add to my calendar','templatic');?></a> 
<div class="addtocalendar">
<ul>
<?php if($args['outlook']){?><li class="i_calendar"><a href="<?php echo $icalurl['ical']; ?>"> <?php _e('Outlook Calendar','templatic');?></a> </li><?php }?>
<?php if($args['google_calender']){?><li class="i_google"><a href="<?php echo $icalurl['google']; ?>" target="_blank"> <?php _e('Google Calendar','templatic');?> </a> </li><?php }?>
<?php if($args['yahoo_calender']){?><li class="i_yahoo"><a href="<?php echo $icalurl['yahoo']; ?>" target="_blank"><?php _e('Yahoo! Calendar','templatic');?></a> </li><?php }?>
<?php if($args['ical_cal']){?><li class="i_calendar"><a href="<?php echo $icalurl['ical']; ?>"> <?php _e('iCal Calendar','templatic');?> </a> </li><?php }?>
</ul>
</div>
</div>
<?php
	}
}

function get_event_ical_info($post_id) {
	require_once(get_template_directory().'/library/ical/iCalcreator.class.php');
	$cal_post = get_post($post_id);
	if ($cal_post) {
		$location = get_post_meta($post_id,'address',true);
		$start_year = date('Y',strtotime(get_post_meta($post_id,'st_date',true)));
		$start_month = date('m',strtotime(get_post_meta($post_id,'st_date',true)));
		$start_day = date('d',strtotime(get_post_meta($post_id,'st_date',true)));
		
		$end_year = date('Y',strtotime(get_post_meta($post_id,'end_date',true)));
		$end_month = date('m',strtotime(get_post_meta($post_id,'end_date',true)));
		$end_day = date('d',strtotime(get_post_meta($post_id,'end_date',true)));
		
		$start_time = get_post_meta($post_id,'st_time',true);
		$end_time = get_post_meta($post_id,'end_time',true);
		if (($start_time != '') && ($start_time != ':')) { $event_start_time = explode(":",$start_time); }
		if (($end_time != '') && ($end_time != ':')) { $event_end_time = explode(":",$end_time); }
		
		$post_title = get_the_title($post_id);
		$v = new vcalendar();                          
		$e = new vevent();  
		$e->setProperty( 'categories' , CUSTOM_POST_TYPE2 );                   
		
		if (isset($event_start_time)) { $e->setProperty( 'dtstart' 	,  $start_year, $start_month, $start_day, $event_start_time[0], $event_start_time[1], 00 ); } else { $e->setProperty( 'dtstart' ,  $start_year, $start_month, $start_day ); } // YY MM dd hh mm ss
		if (isset($event_end_time)) { $e->setProperty( 'dtend'   	,  $end_year, $end_month, $end_day, $event_end_time[0], $event_end_time[1], 00 );  } else { $e->setProperty( 'dtend' , $end_year, $end_month, $end_day );  } // YY MM dd hh mm ss
		$e->setProperty( 'description' 	, strip_tags($cal_post->post_excerpt) ); 
		if (isset($location)) { $e->setProperty( 'location'	, $location ); } 
		$e->setProperty( 'summary'	, $post_title );                 
		$v->addComponent( $e );                        
	
		$templateurl = get_bloginfo('template_url').'/cache/';
		$siteurl = get_bloginfo('url');
		$dir = str_replace($siteurl,'',$templateurl);
		$dir = str_replace('/wp-content/','wp-content/',$dir);
		
		$v->setConfig( 'directory', $dir ); 
		$v->setConfig( 'filename', 'event-'.$post_id.'.ics' ); 
		$v->saveCalendar(); 
		////OUT LOOK & iCAL URL//
		$output['ical'] = $templateurl.'event-'.$post_id.'.ics';
		////GOOGLE URL//
		$google_url = "http://www.google.com/calendar/event?action=TEMPLATE";
		$google_url .= "&text=".$post_title;
		if (isset($event_start_time) && isset($event_end_time)) { 
			$google_url .= "&dates=".$start_year.$start_month.$start_day."T".$event_start_time[0].$event_start_time[1]."00/".$end_year.$end_month.$end_day."T".$event_end_time[0].$event_end_time[1]."00"; 
			//$google_url .= "&dates=".$start_year.$start_month.$start_day."T".$event_start_time[0].$event_start_time[1]."00Z/".$end_year.$end_month.$end_day."T".$event_end_time[0].$event_end_time[1]."00Z"; 
		} else { 
			$google_url .= "&dates=".$start_year.$start_month.$start_day."/".$end_year.$end_month.$end_day; 
		}
		$google_url .= "&sprop=website:".$siteurl;
		$google_url .= "&details=".strip_tags($cal_post->post_excerpt);
		if (isset($location)) { $google_url .= "&location=".$location; } else { $google_url .= "&location=Unknown"; }
		$google_url .= "&trp=true";
		$output['google'] = $google_url;
		////YAHOO URL///
		$yahoo_url = "http://calendar.yahoo.com/?v=60&view=d&type=20";
		$yahoo_url .= "&title=".str_replace(' ','+',$post_title);
		if (isset($event_start_time)) 
		{ 
			$yahoo_url .= "&st=".$start_year.$start_month.$start_day."T".$event_start_time[0].$event_start_time[1]."00"; 
		}
		else
		{ 
			$yahoo_url .= "&st=".$start_year.$start_month.$start_day;
		}
		if(isset($event_end_time))
		{
			//$yahoo_url .= "&dur=".$event_start_time[0].$event_start_time[1];
		}
		$yahoo_url .= "&desc=".__('For+details,+link+').get_permalink($post_id).' - '.str_replace(' ','+',strip_tags($cal_post->post_excerpt));
		$yahoo_url .= "&in_loc=".str_replace(' ','+',$location);
		$output['yahoo'] = $yahoo_url;
	}
	return $output;
}  

//<!-- add to calendar section start --> ///


// ---------------------------------------------------------------------- ///
//Shortcodes add --------------------------------------------------------
//----------------------------------------------------------------------- /// 

// Shortcodes - Messages -------------------------------------------------------- //
function message_download( $atts, $content = null ) {
   return '<p class="download">' . $content . '</p>';
}
add_shortcode( 'Download', 'message_download' );

function message_alert( $atts, $content = null ) {
   return '<p class="alert">' . $content . '</p>';
}
add_shortcode( 'Alert', 'message_alert' );

function message_note( $atts, $content = null ) {
   return '<p class="note">' . $content . '</p>';
}
add_shortcode( 'Note', 'message_note' );


function message_info( $atts, $content = null ) {
   return '<p class="info">' . $content . '</p>';
}
add_shortcode( 'Info', 'message_info' );


// Shortcodes - About Author -------------------------------------------------------- //

function about_author( $atts, $content = null ) {
   return '<div class="about_author">' . $content . '</p></div>';
}
add_shortcode( 'Author Info', 'about_author' );


function icon_list_view( $atts, $content = null ) {
   return '<div class="check_list">' . $content . '</p></div>';
}
add_shortcode( 'Icon List', 'icon_list_view' );


// Shortcodes - Boxes -------------------------------------------------------- //

function normal_box( $atts, $content = null ) {
   return '<div class="boxes normal_box">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box', 'normal_box' );

function warning_box( $atts, $content = null ) {
   return '<div class="boxes warning_box">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box', 'warning_box' );

function about_box( $atts, $content = null ) {
   return '<div class="boxes about_box">' . $content . '</p></div>';
}
add_shortcode( 'About_Box', 'about_box' );

function download_box( $atts, $content = null ) {
   return '<div class="boxes download_box">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box', 'download_box' );

function info_box( $atts, $content = null ) {
   return '<div class="boxes info_box">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box', 'info_box' );


function alert_box( $atts, $content = null ) {
   return '<div class="boxes alert_box">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box', 'alert_box' );






// Shortcodes - Boxes - Equal -------------------------------------------------------- //

function normal_box_equal( $atts, $content = null ) {
   return '<div class="boxes normal_box small">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box_Equal', 'normal_box_equal' );

function warning_box_equal( $atts, $content = null ) {
   return '<div class="boxes warning_box small">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box_Equal', 'warning_box_equal' );

function about_box_equal( $atts, $content = null ) {
   return '<div class="boxes about_box small_without_margin">' . $content . '</p></div>';
}
add_shortcode( 'About_Box_Equal', 'about_box_equal' );

function download_box_equal( $atts, $content = null ) {
   return '<div class="boxes download_box small">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box_Equal', 'download_box_equal' );

function info_box_equal( $atts, $content = null ) {
   return '<div class="boxes info_box small">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box_Equal', 'info_box_equal' );


function alert_box_equal( $atts, $content = null ) {
   return '<div class="boxes alert_box small">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box_Equal', 'alert_box_equal' );


// Shortcodes - Content Columns -------------------------------------------------------- //

function one_half_column( $atts, $content = null ) {
   return '<div class="one_half_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Half', 'one_half_column' );

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half_column right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Half_Last', 'one_half_last' );


function one_third_column( $atts, $content = null ) {
   return '<div class="one_third_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Third', 'one_third_column' );

function one_third_column_last( $atts, $content = null ) {
   return '<div class="one_third_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Third_Last', 'one_third_column_last' );


function one_fourth_column( $atts, $content = null ) {
   return '<div class="one_fourth_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Fourth', 'one_fourth_column' );

function one_fourth_column_last( $atts, $content = null ) {
   return '<div class="one_fourth_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Fourth_Last', 'one_fourth_column_last' );


function two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds left">' . $content . '</p></div>';
}
add_shortcode( 'Two_Third', 'two_thirds' );

function two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'Two_Third_Last', 'two_thirds_last' );


function dropcaps( $atts, $content = null ) {
   return '<p class="dropcaps">' . $content . '</p>';
}
add_shortcode( 'Dropcaps', 'dropcaps' );


// Shortcodes - Small Buttons -------------------------------------------------------- //

function small_button( $atts, $content ) {
 return '<div class="small_button '.$atts['class'].'">' . $content . '</div>';
}
add_shortcode( 'Small_Button', 'small_button' );

//FUNCTION NAME : Related post as per tags
//RETURNS : a search box wrapped in a div

 function get_related_posts($postdata,$my_post_type,$post_tags,$post_category,$city_id) {
 
global $wp_query;

$do_not_duplicate[] = $postdata->ID;
if(strtolower(get_option('ptthemes_related_listing_per')) == strtolower('Tags')){
$terms = wp_get_post_terms($postdata->ID, $post_tags, array("fields" => "slugs"));
$post_category = $post_tags;
}else{ 
$terms = wp_get_post_terms($postdata->ID, $post_category, array("fields" => "slugs"));
}

if(is_array($terms[0])){
$terms = implode(',',$terms[0]);
}else{
$terms = $terms[0];
}

$relatedprd_count = 0;
if(!empty($terms)){
$no_of_posts = get_option('ptthemes_related_listing_cnt');
wp_reset_query();
	 $postQuery = array(
                        'post_type'                 => $my_post_type,
                        'post_status'               => 'publish',
                        $post_category             => $terms,
                        'posts_per_page'            => $no_of_posts,
						'meta_key'                     => 'post_city_id',
                        'meta_value'                     => $city_id,
                        'orderby'                   => 'date',
                        'order'                     => 'ASC',
						'post__not_in' => array($postdata->ID)
                    );
        //query_posts($postQuery );
		$my_query = null;
		$my_query1 = null;
		$my_query1 = new wp_query($postQuery);

       if( $my_query1->have_posts() ) { ?>
		<div class="related_listing">  
            			
<h3><?php _e('Related Listing','templatic');?></h3>
<ul>   <?php
            while ( $my_query1->have_posts() ) : $my_query1->the_post(); $do_not_duplicate[] = $postdata->ID; 
			$comment_count = $post->comment_count; 
			$relatedprd_count++;
			$post_rel_img =  bdw_get_images_with_info(get_the_ID(),'medium'); 

			$attachment_id = $post_rel_img[0]['id'];
			//echo "<pre>"; print_r($post_images);
			$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			$attach_data = get_post($attachment_id);
			$title = $attach_data->post_title;
			if($title ==''){ $title = $post->post_title; }
			if($alt ==''){ $alt = $post->post_title; } ?>
            <li class="clearfix" class="related-post">
				<?php if($post_rel_img[0]['file']){ 
				$crop_image = vt_resize($attachment_id, $post_rel_img[0]['file'], 150, 105, $crop = true ); ?>
				<a class="post_img" href="<?php echo get_permalink(get_the_ID());?>"><img  src="<?php echo $crop_image['url'];?>" alt="<?php $alt; ?>" title="<?php echo $title; ?>"  /> </a>
				<?php 	}else{ ?>
				<a class="img_no_available" href="<?php echo get_permalink(get_the_ID());  ?>"> <?php echo IMAGE_NOT_AVAILABLE_TEXT;?> </a>
				<?php } ?> 
				<h3><a href="<?php echo get_permalink(get_the_ID());?>" /> <?php the_title();?> </a></h3>
				<?php if(get_option('ptthemes_disable_rating') == 'no') { ?>
                    <span class="rating">
                    <?php echo get_post_rating_star(get_the_ID());?>
                    </span>
                <?php } ?> 
				<p><?php echo templ_listing_content($post); ?></p>   
                <p class="review clearfix">    
					<a href="<?php echo get_permalink(get_the_ID()); ?>#commentarea" class="pcomments" ><?php echo $comment_count; ?> </a> 
					<a href="<?php echo get_permalink(get_the_ID()); ?>" class="read_more"><?php echo READ_MORE_LABEL; ?></a> 
                </p>
            </li>
			<?php
			if($relatedprd_count==3){$relatedprd_count=0;?>
			 <li class="hr"></li>
			<?php }	?>
            <?php endwhile; ?>
</ul>
</div>
<?php
        }

}
 }
add_filter('templ_head_css','templ_print_css');
function templ_print_css()
{ ?>

<link rel="stylesheet" type="text/css" href="<?php echo TT_CSS_FOLDER_URL; ?>print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo TT_CSS_FOLDER_URL; ?>basic.css" media="all" />
<?php
}

function user_post_visit_count($pid)
{
	if(get_post_meta($pid,'viewed_count',true))
	{
		return get_post_meta($pid,'viewed_count',true);
	}else
	{
		return '0';	
	}
}
function user_post_visit_count_daily($pid)
{
	if(get_post_meta($pid,'viewed_count_daily',true))
	{
		return get_post_meta($pid,'viewed_count_daily',true);
	}else
	{
		return '0';	
	}
}
function get_image_phy_destination_path()
{	
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	  $destination_path = $path."/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',str_replace(ABSPATH,'', $destination_path));
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	  return $destination_path;
}

//This function would return paths of folder to which upload the image 
function get_image_phy_destination_path_user()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	$destination_path = ABSPATH . $tmppath."users/";
      if (!file_exists($destination_path)){
      $imagepatharr = explode('/',$tmppath."users");
	   $year_path = ABSPATH;
		for($i=0;$i<count($imagepatharr);$i++)
		{
		  if($imagepatharr[$i])
		  {
			$year_path .= $imagepatharr[$i]."/";
			  if (!file_exists($year_path)){
				  mkdir($year_path, 0777);
			  }     
			}
		}
	}
	 return $destination_path;
	
}

//
function get_image_rel_destination_path_user(){	
	global $upload_folder_path;
	$destination_path = home_url() ."/".$upload_folder_path."users/";
	return $destination_path;
	
}

function get_image_rel_destination_path()
{
	$wp_upload_dir = wp_upload_dir();
	$path = $wp_upload_dir['path'];
	$url = $wp_upload_dir['url'];
	return $url.'/';
}

function get_image_new_destination_path()
{
	$today = getdate();
	if ($today['month'] == "January"){
	  $today['month'] = "01";
	}
	elseif ($today['month'] == "February"){
	  $today['month'] = "02";
	}
	elseif  ($today['month'] == "March"){
	  $today['month'] = "03";
	}
	elseif  ($today['month'] == "April"){
	  $today['month'] = "04";
	}
	elseif  ($today['month'] == "May"){
	  $today['month'] = "05";
	}
	elseif  ($today['month'] == "June"){
	  $today['month'] = "06";
	}
	elseif  ($today['month'] == "July"){
	  $today['month'] = "07";
	}
	elseif  ($today['month'] == "August"){
	  $today['month'] = "08";
	}
	elseif  ($today['month'] == "September"){
	  $today['month'] = "09";
	}
	elseif  ($today['month'] == "October"){
	  $today['month'] = "10";
	}
	elseif  ($today['month'] == "November"){
	  $today['month'] = "11";
	}
	elseif  ($today['month'] == "December"){
	  $today['month'] = "12";
	}
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	global $blog_id;
	if($blog_id)
	{
		return $user_path = $today['year']."/".$today['month']."/";
	}else
	{
		return $user_path = get_option( 'home' ) ."/$tmppath".$today['year']."/".$today['month']."/";
	}
}

function get_image_tmp_phy_path()
{	
	global $upload_folder_path;
	$tmppath = $upload_folder_path;
	return $destination_path = ABSPATH . $tmppath."tmp/";
}

function move_original_image_file($src,$dest)
{
	copy($src, $dest);
	unlink($src);
	$dest = explode('/',$dest);
	$img_name = $dest[count($dest)-1];
	$img_name_arr = explode('.',$img_name);

	$my_post = array();
	$my_post['post_title'] = $img_name_arr[0];
	$wp_upload_dir = wp_upload_dir();
	$subdir = $wp_upload_dir['subdir'];
	
	//$my_post['guid'] = $subdir.'/'.$img_name;
	$my_post['guid'] = get_image_rel_destination_path().$img_name;
	return $my_post;
}
function get_image_size($src)
{
	$filextenson = stripExtension($src);
	if($filextenson == "jpeg" || $filextenson == "jpg")
	  {
		$img = imagecreatefromjpeg($src);  
	  }
	
	if($filextenson == "png")
	  {
		$img = imagecreatefrompng($src);  
	  }

	if($filextenson == "gif")
	  {
		$img = imagecreatefromgif($src);  
	  }


	/*if (!$img) {
		echo "ERROR:could not create image handle ". $src;
		exit(0);
	}*/
	$width = imageSX($img);
	$height = imageSY($img);
	return array('width'=>$width,'height'=>$height);
	
}

function stripExtension($filename = '') {
    if (!empty($filename)) 
	   {
        $filename = strtolower($filename);
        $extArray = split("[/\\.]", $filename);
        $p = count($extArray) - 1;
        $extension = $extArray[$p];
        return $extension;
    } else {
        return false;
    }
}
function get_attached_file_meta_path($imagepath)
{
	$imagepath_arr = explode('/',$imagepath);
	$imagearr = array();
	for($i=0;$i<count($imagepath_arr);$i++)
	{
		$imagearr[] = $imagepath_arr[$i];
		if($imagepath_arr[$i] == 'uploads')
		{
			break;
		}
	}
	$imgpath_ini = implode('/',$imagearr);
	return str_replace($imgpath_ini.'/','',$imagepath);
}
function image_resize_custom($src,$dest,$twidth,$theight)
{
	global $image_obj;
	// Get the image and create a thumbnail
	$img_arr = explode('.',$dest);
	$imgae_ext = strtolower($img_arr[count($img_arr)-1]);
	if($imgae_ext == 'jpg' || $imgae_ext == 'jpeg')
	{
		$img = imagecreatefromjpeg($src);
	}elseif($imgae_ext == 'gif')
	{
		$img = imagecreatefromgif($src);
	}
	elseif($imgae_ext == 'png')
	{
		$img = imagecreatefrompng($src);
	}
	
	if($img)
	{
		$width = imageSX($img);
		$height = imageSY($img);
	
		if (!$width || !$height) {
			echo "ERROR:Invalid width or height";
			exit(0);
		}
		
		if(($twidth<=0 || $theight<=0))
		{
			return false;
		}
		$image_obj->load($src);
		$image_obj->resize($twidth,$theight);
		$new_width = $image_obj->getWidth();
		$new_height = $image_obj->getHeight();
		$imgname_sub = '-'.$new_width.'X'. $new_height.'.'.$imgae_ext;
		$img_arr1 = explode('.',$dest);
		unset($img_arr1[count($img_arr1)-1]);
		$dest = implode('.',$img_arr1).$imgname_sub;
		$image_obj->save($dest);
		
		
		return array(
					'file' => basename( $dest ),
					'width' => $new_width,
					'height' => $new_height,
				);
	}else
	{
		return array();
	}
}

function get_property_cat_id_name($postid='')
{
	global $wpdb;

	$pn_categories_obj = $wpdb->get_var("SELECT GROUP_CONCAT(distinct($wpdb->terms.term_id)) as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms,  $wpdb->term_relationships
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->term_taxonomy.taxonomy = 'category'
								and $wpdb->term_relationships.term_taxonomy_id=$wpdb->term_taxonomy.term_taxonomy_id and $wpdb->term_relationships.object_id=\"$postid\"");
								
	$post_cats_arr = explode(',',$pn_categories_obj);
	if($post_cats_arr)
	{
		for($i=0;$i<count($post_cats_arr);$i++)
		{
			if($bed_catid_arr && in_array($post_cats_arr[$i],$bed_catid_arr))
			{
				$post_cat_info['bed'] = array('id'=>$post_cats_arr[$i],'name'=>$bed_catname_arr[$post_cats_arr[$i]]);
			}
			if($loc_catid_arr && in_array($post_cats_arr[$i],$loc_catid_arr))
			{
				$post_cat_info['location'] = array('id'=>$post_cats_arr[$i],'name'=>$loc_catname_arr[$post_cats_arr[$i]]);
			}
		}
	}
	return $post_cat_info;
}function get_cat_id_from_name($catname)
{
	global $wpdb;
	if($catname)
	{
	return $pn_categories_obj = $wpdb->get_var("SELECT $wpdb->terms.term_id as cat_ID 
	                            FROM $wpdb->term_taxonomy,  $wpdb->terms
                                WHERE $wpdb->term_taxonomy.term_id =  $wpdb->terms.term_id AND $wpdb->terms.name like \"$catname\"
                                AND $wpdb->term_taxonomy.taxonomy = 'category'");
	}
}


function get_blog_sub_cats_str($type='array')
{
	$catid_arr = get_option('ptthemes_blogcategory');
	$blogcatids = '';
	$subcatids_arr = array();
	for($i=0;$i<count($catid_arr);$i++)
	{
		if($catid_arr[$i])
		{
			$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
		}
	}
	if($subcatids_arr && $type=='string')
	{
		$blogcatids = implode(',',$subcatids_arr);
		return $blogcatids;	
	}else
	{
		return $subcatids_arr;
	}			
}
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(588, 250, true); // Normal post thumbnails
	add_image_size('loopThumb', 588, 125, true);
}
function get_post_info($pid)
{
	global $wpdb;
	$productinfosql = "select * from $wpdb->posts where ID=$pid";
	$productinfo = $wpdb->get_results($productinfosql);
	if($productinfo)
	{
		foreach($productinfo[0] as $key=>$val)
		{
			$productArray[$key] = $val; 
		}
	}
	return $productArray;
}
function plugin_is_active($plugin_var){
							$return_var = in_array($plugin_var.'/'.$plugin_var.'.php',apply_filters('active_plugins',get_option('active_plugins')));
							return $return_var;
						}
/*--Function to fetch time difference BOF--*/
function get_time_difference($start, $pid )
{
	
	if($start)
	{
		$alive_days = get_post_meta($pid,'alive_days',true);
		$uts['start']      =    strtotime( $start );
		$uts['end']        =    mktime(0,0,0,date('m',strtotime($start)),date('d',strtotime($start))+$alive_days,date('Y',strtotime($start)));
	
		$post_days = gregoriantojd(date('m'), date('d'), date('Y')) - gregoriantojd(date('m',strtotime($start)), date('d',strtotime($start)), date('Y',strtotime($start)));
		$days = $alive_days-$post_days;
	
		if($days>0)
		{
			return $days;	
		}else{
			return( false );
		}
	}
    
}
/*--Function to fetch time difference EOF--*/

function get_image_cutting_edge($args=array())
{
	if($args['image_cut'])
	{
		$cut_post =$args['image_cut'];
	}else
	{
		$cut_post = get_option('ptthemes_image_x_cut');
	}
	if($cut_post)
	{		
		if($cut_post=='top')
		{
			$thumb_url .= "&amp;a=t";	
		}elseif($cut_post=='bottom')
		{
			$thumb_url .= "&amp;a=b";	
		}elseif($cut_post=='left')
		{
			$thumb_url .= "&amp;a=l";
		}elseif($cut_post=='right')
		{
			$thumb_url .= "&amp;a=r";
		}elseif($cut_post=='top right')
		{
			$thumb_url .= "&amp;a=tr";
		}elseif($cut_post=='top left')
		{
			$thumb_url .= "&amp;a=tl";
		}elseif($cut_post=='bottom right')
		{
			$thumb_url .= "&amp;a=br";
		}elseif($cut_post=='bottom left')
		{
			$thumb_url .= "&amp;a=bl";
		}
	}
	return $thumb_url;
}

//This function would add propery to favorite listing and store the value in wp_usermeta table user_favorite field
function add_to_favorite($post_id)
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_favourite_post',true);
	$user_meta_data[]=$post_id;
	update_usermeta($current_user->ID, 'user_favourite_post', $user_meta_data);
	echo '<a href="javascript:void(0);" class="addtofav" onclick="javascript:addToFavourite(\''.$post_id.'\',\'remove\');">'.__('Remove from Favorites','templatic').'</a>';
	
}
//This function would remove the favorited property earlier
function remove_from_favorite($post_id)
{
	global $current_user;
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID,'user_favourite_post',true);
	if(in_array($post_id,$user_meta_data))
	{
		$user_new_data = array();
		foreach($user_meta_data as $key => $value)
		{
			if($post_id == $value)
			{
				$value= '';
			}else{
				$user_new_data[] = $value;
			}
		}	
		$user_meta_data	= $user_new_data;
	}
	update_usermeta($current_user->ID, 'user_favourite_post', $user_meta_data); 	
	echo '<a class="addtofav" href="javascript:void(0);"  onclick="javascript:addToFavourite(\''.$post_id.'\',\'add\');">'.ADD_FAVOURITE_TEXT.'</a>';
}
function favourite_html($user_id,$post_id)
{
	global $current_user;
	
	$user_meta_data = get_user_meta($current_user->ID,'user_favourite_post',true);
	if($user_meta_data && in_array($post_id,$user_meta_data))
	{
		?>
	<span id="favorite_property_<?php echo $post_id;?>" class="fav"  > <a href="javascript:void(0);" class="addtofav" onclick="javascript:addToFavourite('<?php echo $post_id;?>','remove');"><?php echo REMOVE_FAVOURITE_TEXT;?></a>   </span>    
		<?php
	}else{
	?>
	<span id="favorite_property_<?php echo $post_id;?>" class="fav"><a href="javascript:void(0);" class="addtofav"  onclick="javascript:addToFavourite(<?php echo $post_id;?>,'add');"><?php echo ADD_FAVOURITE_TEXT;?></a></span>
	<?php } 
}
function check_user_post($puser)
{
	if($puser){
		global $current_user,$site_url;
		if($current_user->ID==1 || $current_user->ID==$puser)
		{ 
		}else 
		{
			wp_redirect($site_url);exit;	
		}
	}
}
function set_property_status($pid,$status='publish')
{
	if($pid)	{
		global $wpdb;
		//$wpdb->query("update $wpdb->posts set post_status=\"$status\" where ID=\"$pid\"");
		$my_post = array();
		$my_post['post_status'] = $status;
		$my_post['ID'] = $pid;
		$last_postid = wp_update_post($my_post);
	}
}
function excerpt($limit=30) {
global $post;
  $excerpt = explode(' ', get_the_excerpt(),$limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'<a href="'.get_permalink($post->ID).'"  class="read_more">'.READ_MORE_LABEL.'</a>';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
/////////////////PLACE EXPIRY SETTINGS CODING START/////////////////
global $table_prefix, $wpdb;
$table_name = $table_prefix . "place_expire_session";
$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
   global $table_prefix, $wpdb,$table_name,$site_url;
	$sql = 'CREATE TABLE `'.$table_name.'` (
			`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`execute_date` DATE NOT NULL ,
			`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
			) ENGINE = MYISAM ;';
   mysql_query($sql);
}
$today_executed = $wpdb->get_var("select session_id from $table_name where execute_date=\"$current_date\"");
if($today_executed && $today_executed>0){ 
}else{ 
		if(get_option('listing_email_notification') != ""){
			$number_of_grace_days = get_option('listing_email_notification');
			$postid_str = $wpdb->get_results("select p.ID,p.post_author,p.post_date, p.post_title from $wpdb->posts p where (p.post_type='place' or p.post_type='event') and p.post_status='publish' and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')-$number_of_grace_days");
			
			foreach($postid_str as $postid_str_obj)
			{
				
				$ID = $postid_str_obj->ID;
				$auth_id = $postid_str_obj->post_author;
				$post_author = $postid_str_obj->post_author;
				$post_date = date('dS m,Y',strtotime($postid_str_obj->post_date));
				$post_title = $postid_str_obj->post_title;
				$userinfo = $wpdb->get_results("select user_email,display_name,user_login from $wpdb->users where ID=\"$auth_id\"");
				
				$user_email = $userinfo[0]->user_email;
				$display_name = $userinfo[0]->display_name;
				$user_login = $userinfo[0]->user_login;
				
				$fromEmail = get_site_emailId();
				$fromEmailName = get_site_emailName();
				$store_name = get_option('blogname');
				$alivedays = get_post_meta($ID,'alive_days',true);
				$productlink = get_permalink($ID);
				$loginurl = $site_url.'/?ptype=login';
				$siteurl = $site_url;
				$client_message = get_option('post_expiry_email_content');
				$subject = get_option('post_expiry_email_subject');
				if(!$client_message):
					$client_message = __("<p>Dear $display_name,<p><p>Your listing -<a href=\"$productlink\"><b>$post_title</b></a> posted on  <u>$post_date</u> for $alivedays days.</p>
					<p>It's going to expiry after $number_of_grace_days day(s). If the listing expire, it will no longer appear on the site.</p>
					<p> If you want to renew, Please login to your member area of our site and renew it as soon as it expire. You may like to login the site from <a href=\"$loginurl\">$loginurl</a>.</p>
					<p>Your login ID is <b>$user_login</b> and Email ID is <b>$user_email</b>.</p>
					<p>Thank you,<br />$store_name.</p>","templatic");
				endif;
				$client_message = stripslashes($client_message);
				if(!subject):
					$subject = __('Listing expiration Notification','templatic');
				endif;	
				
				$old_array = array("[#to_name#]","[#post_link#]","[#post_title#]","[#post_date#]","[#alive_days#]","[#grace_days#]","[#site_login_url_link#]","[#site_login_url#]","[#user_login#]","[#user_email#]","[#site_name#]");
				$new_array = array($display_name,$productlink,$post_title,$post_date,$alivedays,$number_of_grace_days,$loginurl,$loginurl,$user_login,$user_email,$store_name);
				$replace_array = str_replace($old_array,$new_array,$client_message);
				templ_sendEmail($fromEmail,$fromEmailName,$user_email,$display_name,$subject,$replace_array,$extra='');
			}
		}
		$postid_str = $wpdb->get_var("select group_concat(p.ID) from $wpdb->posts p where (p.post_type='place' or p.post_type='event') and p.post_status='publish' and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) = (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')");

		if($postid_str)
		{
			$listing_ex_status = strtolower(get_option('ptthemes_listing_ex_status'));
			if($listing_ex_status=='')
			{
				$listing_ex_status = 'draft';	
			}
				
			$wpdb->query("update $wpdb->posts set post_status=\"$listing_ex_status\" where ID in ($postid_str)");
		}

		$wpdb->query("insert into $table_name (execute_date,is_run) values (\"$current_date\",'1')");
	
}
if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') and !is_single()) /*--this condition is because plugin is conflict with comment box in backend --*/
{
 /*@Author: Boutros AbiChedid
* @Date:   March 20, 2011
* @Websites: http://bacsoftwareconsulting.com/
* http://blueoliveonline.com/
* @Description: Numbered Page Navigation (Pagination) Code.
* @Tested: Up to WordPress version 3.1.2 (also works on WP 3.3.1)
********************************************************************/
 
/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}

/////////////////PLACE EXPIRY SETTINGS CODING END/////////////////
/* Function that performs a Boxed Style Numbered Pagination (also called Page Navigation).
   Function is largely based on Version 2.4 of the WP-PageNavi plugin */
function pagenavi($before = '', $after = '') {
    global $wpdb, $wp_query;
	
    $pagenavi_options = array();
   // $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%:');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First Page');
    $pagenavi_options['last_text'] = ('Last Page');
    $pagenavi_options['next_text'] = 'Next &raquo;';
    $pagenavi_options['prev_text'] = '&laquo; Previous';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; //continuous block of page numbers
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;
 
    if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
 
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
 
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
        $half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
 
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
 
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        //round_num() custom function - Rounds To The Nearest Value.
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
 
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {

            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
			previous_posts_link($pagenavi_options['prev_text']);
 
		   echo $before.'<div class="Navi">'."\n";
 
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span>';
            }
       
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);

                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">1</a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }
 
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            for($i = $start_page; $i  <= $end_page; $i++) {
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="on">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
 
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$max_page.'</a>';
            }
           
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div>'.$after."\n";
			 next_posts_link($pagenavi_options['next_text'], $max_page);
        }
    }
}
}
if ( !function_exists( 'vt_resize') ) {
	function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

	// this is an attachment, so we have the ID
	if ( $attach_id ) {

	$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
	$file_path = get_attached_file( $attach_id );

	// this is not an attachment, let's use the image url
	} else if ( $img_url ) {

	$file_path = parse_url( $img_url );
	$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

	// Look for Multisite Path
	if(file_exists($file_path) === false){
	global $blog_id;
	$file_path = parse_url( $img_url );
	if (preg_match("/files/", $file_path['path'])) {
	$path = explode('/',$file_path['path']);
	foreach($path as $k=>$v){
	if($v == 'files'){
	$path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
	}
	}
	$path = implode('/',$path);
	}
	$file_path = $_SERVER['DOCUMENT_ROOT'].$path;
	}
	//$file_path = ltrim( $file_path['path'], '/' );
	//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];

	$orig_size = getimagesize( $file_path );

	$image_src[0] = $img_url;
	$image_src[1] = $orig_size[0];
	$image_src[2] = $orig_size[1];
	}
	if(isset( $file_path) &&  $file_path !=''){
		$file_info = pathinfo( $file_path ); }else{
		$file_info= '';
	}

	// check if file exists
	if(isset($file_info) && $file_info !=''){
	$base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
	}else{
		$base_file='';
	}
	if ( isset($image_src) && $image_src !=''){
	if(!file_exists($base_file))
	return; }else{
		$image_src =0;
	}
	if(isset($file_info) && $file_info !=''){
		$extension = '.'. $file_info['extension'];
	

	// the image path without the extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
	}else{
		$cropped_img_path ='';
	}
	// checking if the file size is larger than the target size
	// if it is smaller or the same size, stop right here and return
	if ( $image_src[1] > $width ) {

	// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
	if ( file_exists( $cropped_img_path ) ) {

	$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

	$vt_image = array (
	'url' => $cropped_img_url,
	'width' => $width,
	'height' => $height
	);

	return $vt_image;
	}

	// $crop = false or no height set
	if ( $crop == false OR !$height ) {

	// calculate the size proportionaly
	$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
	$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;

	// checking if the file already exists
	if ( file_exists( $resized_img_path ) ) {

	$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

	$vt_image = array (
	'url' => $resized_img_url,
	'width' => $proportional_size[0],
	'height' => $proportional_size[1]
	);

	return $vt_image;
	}
	}

	// check if image width is smaller than set width
	$img_size = getimagesize( $file_path );
	if ( $img_size[0] <= $width ) $width = $img_size[0];

	// Check if GD Library installed
	if (!function_exists ('imagecreatetruecolor')) {
	echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
	return;
	}

	// no cache files - let's finally resize it
	$new_img_path = image_resize( $file_path, $width, $height, $crop );	
	$new_img_size = getimagesize( $new_img_path );
	$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

	// resized output
	$vt_image = array (
	'url' => $new_img,
	'width' => $new_img_size[0],
	'height' => $new_img_size[1]
	);

	return $vt_image;
	}

	// default output - without resizing
	$vt_image = array (
	'url' => $image_src[0],
	'width' => $width,
	'height' => $height
	);

	return $vt_image;
	}
}
/* function to set the default city BOF */
function templ_set_my_city(){ 
global $wpdb;

if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && @$_REQUEST['noheader'] ==''){ 
	if(isset($_POST['multi_city']) && $_POST['multi_city'] != ''){ 
		$_SESSION['multi_city'] = $_POST['multi_city'];
		$_SESSION['multi_city1'] = $_POST['multi_city'];
	}elseif(isset($_REQUEST['front_post_city_id']) && $_REQUEST['front_post_city_id'] != "" ){
		setcookie("multi_city1", $_REQUEST['front_post_city_id'],time()+3600*24*30*12);
		$_COOKIE['multi_city1'] = $_REQUEST['front_post_city_id'];
		$_SESSION['multi_city1'] = $_COOKIE['multi_city1'];
		$_SESSION['multi_city'] = $_COOKIE['multi_city1'];
	}elseif($_SESSION['multi_city'] == "" && $_POST['multi_city'] == ""){ 
		if($_REQUEST['front_post_city_id'] == "" && get_option('splash_page') != "" && $_SESSION['multi_city1']=="" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "" && $_REQUEST['page']!='manage_settings') {
			if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
			//include_once(get_template_directory()."/tpl_splash.php");
			 }
		} else {
			$multicity_db_table_name = $wpdb->prefix."multicity"; 
			
			$my_city =$wpdb->get_row("select city_id from $multicity_db_table_name where is_default='1'");
			$_SESSION['multi_city'] = $my_city->city_id;
		}
	} else{ 
		$_SESSION['multi_city'] = $_SESSION['multi_city'];
		$_SESSION['multi_city1'] = $_SESSION['multi_city'];
	}
	if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
	 $cur_post_id = $_REQUEST['pid'];
	 $postdata = get_post($cur_post_id );
	 $post_author_id = $postdata->post_author;
	}
	} 
}

/* function to set the default city EOF */

/* function to show facebook share button BOF */

function facebook_meta_tags($post){
	global $post; 
	$post_title = $post->post_title;
	$img = bdw_get_images($post->ID,'thumb');
	echo '<meta property="og:title" content="'.$post_title.'" /> 
	<meta property="og:image" content="'.$img[0].'" /> ';
}
/* function to show facebook share button EOF */
/*
Name : templ_show_profile_fields
Description : Function returns the custom user fields for author box
*/
function templ_show_profile_fields($cur_author = ''){
	global $current_user,$wpdb,$custom_usermeta_db_table_name;	
	$custom_usermeta_db_table_name = $wpdb->prefix . "templatic_custom_usermeta";
	$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and on_profile='1' order by sort_order asc,admin_title asc");
	foreach($user_meta_info as $post_meta_info_obj){
		if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date'){
				if(get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true) != "" ){ 
						if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing" && $post_meta_info_obj->htmlvar_name != "video")
						{
								if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
									echo "<li>".$post_meta_info_obj->site_title." :".get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true)."</li>";
								} else {
									echo "<li>".$post_meta_info_obj->site_title." :".get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true)."</li>";
								}
						}
				}
		}else{
			/* if its multicheckbox or select box following condition will apply */
			if($post_meta_info_obj->ctype == 'multicheckbox'){
				$multiVal = get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true);
				$arrVal="";
				if($multiVal):
				foreach($multiVal as $_multiVal):
					$arrVal .= $_multiVal.",";
				endforeach;
				echo "<li>".$post_meta_info_obj->site_title." :".substr($arrVal,0,-1)."</li>";		
				endif;	
			}else if($post_meta_info_obj->ctype == 'select'){
				$Val = get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true);
				if($Val != $post_meta_info_obj->is_default){
					echo "<li>".$post_meta_info_obj->site_title." :".get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true)."</li>"; }
			}else if($post_meta_info_obj->ctype =='upload' && $post_meta_info_obj->htmlvar_name != 'user_photo'){
				/* if its upload field following condition will apply */
				$Val12 = get_user_meta($cur_author, $post_meta_info_obj->htmlvar_name, true ); 
				if($Val12 != ''){
					$photo = vt_resize('',$Val12,120,120);
					$str ="<li>".$post_meta_info_obj->site_title." : <img src=".$photo['url']." alt='' align='top'/></li>";
					echo $str;
				}
			}else{ 
					$value_1 = $_SESSION['place_info'][$post_meta_info_obj->htmlvar_name];
					if ($value_1 != '') {
						echo "<li>".$post_meta_info_obj->site_title." :".get_user_meta($cur_author,$post_meta_info_obj->htmlvar_name,true)."</li>"; }
					}
	} }
}
/*
Name : templ_wp_categories_listing
Args : taxonomy of the post and post id
Description : return the categories of posts
*/
function templ_wp_categories_listing($pid ,$taxonomy){
	$terms_list ='';
	$terms = wp_get_post_terms( $pid, $taxonomy, array("fields" => "all"));
	for($tm =0; $tm < count($terms) ; $tm++){
		if($tm == (count($terms)-1)){ $sep =''; }else{ $sep = ", "; }
		if($terms[$tm]->slug)
		$cat_name = "<a href=".get_term_link($terms[$tm]->slug, $taxonomy).">".$terms[$tm]->name."</a>";
		$terms_list .= $cat_name.$sep;
	}
	if(isset($terms_list) && $terms_list !='')
	echo "<span class='post-category'>".$terms_list."</span>";
}
/*
Name : templ_wp_tags_listing
Args : taxonomy of the post and post id
Description : return the tags of posts
*/
function templ_wp_tags_listing($pid ,$taxonomy){
	$terms = wp_get_post_terms( $pid, $taxonomy, array("fields" => "all"));
	$terms_list ='';
	for($tm =0; $tm < count($terms) ; $tm++){
		if($tm == (count($terms)-1)){ $sep =''; }else{ $sep = ", "; }
		if($terms[$tm]->slug)
		$cat_name = "<a href=".get_term_link($terms[$tm]->slug, $taxonomy).">".$terms[$tm]->name."</a>";
		$terms_list .= $cat_name.$sep;
	}
	if($terms_list)
	echo "<span class='post-tags'> ".$terms_list."</span>";
}

/*
Name : templ_event_detail_sidebar
Description : call place detail sidebar dislpay everything related to detail page post
*/

function templ_event_detail_sidebar($post,$sidebar_class,$sidebar_id=""){
	global $wpdb;
	echo '<div id="'.$sidebar_id.'" class="'.$sidebar_class.'">';
	$address = stripslashes(get_post_meta($post->ID,'geo_address',true));
	$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
	$timing1 = get_post_meta($post->ID,'st_time',true);
	$timing2 = get_post_meta($post->ID,'end_time',true);
	$contact = stripslashes(get_post_meta($post->ID,'contact',true));
	$email = get_post_meta($post->ID,'email',true);
	$website = get_post_meta($post->ID,'website',true);
	$twitter = get_post_meta($post->ID,'twitter',true);
	$facebook = get_post_meta($post->ID,'facebook',true);
	
	?>
	<div class="company_info">
		<?php global $site_url;
		$custom_user = wp_get_current_user(); 
		$cuid = $custom_user->ID;
		$paid = $post->post_author;
		
		if($cuid == $paid)
		{
		?>
		<p class="edit-link"><a href="<?php echo $site_url;?>/?ptype=post_event&pid=<?php echo $post->ID;?>" class="post-edit-link"><?php _e ('EDIT THIS','templatic');?></a></p>
		<?php } 
		/* claim to ownership Begin */
		global $post,$wpdb,$claim_db_table_name ;
		if(get_option('ptthemes_enable_claimownership') =='Yes'){
		$claimreq = $wpdb->get_results("select * from $claim_db_table_name where post_id= '".$post->ID."' and status = '1'");
		if(mysql_affected_rows() >0 || get_post_meta($post->ID,'is_verified',true) == 1)
		{
			_e('<p class="i_verfied">Owner Verified Listing</p>','templatic');
		}else{ ?>	
		<a href="javascript:void(0);" onclick="show_hide_popup('claim_listing');" title="<?php _e('Claim this post','templatic'); ?>" class="i_claim c_sendtofriend"><?php _e(CLAIM_OWNERSHIP); ?></a>
		<?php include_once (get_template_directory() .'/monetize/email_notification/popup_owner_frm.php'); ?>
		<?php } } 
		/* claim to ownership End */
		/* display address */
		if($address) {  ?>
		<p> <span class="i_location"><?php echo ADDRESS.": "; ?> </span> <?php echo get_post_meta($post->ID,'geo_address',true);?>   </p> 
		<?php } 
		/* display website url */	
		if($website){
				$website = $website;
				if(!strstr($website,'http')) {
					 $website = 'http://'.$website;
				} 
				if($website && get_post_meta($post->ID,'web_show',true) != 'No'){ ?>
				<p>  <span class="i_website"><a href="<?php echo $website;?>"  target="blank"><strong><?php  echo WEBSITE_TEXT; ?></strong></a>  </span> </p>
		<?php 	}
		}
		/* display event time */	
		if($timing1 && $timing2){ ?>
				<p> <span class="i_time">  <?php echo TIME.": "; ?> </span>  <?php echo $timing1." ".__('to','templatic')." ".$timing2; ?>  </p> <?php 
		}elseif($timing1 || $timing2){
			if($timing1): ?>
					<p> <span class="i_time">  <?php echo TIME.": "; ?> </span>  <?php echo $timing1; ?>  </p> 
			<?php elseif($timing1): ?>
					<p> <span class="i_time">  <?php echo TIME.": "; ?> </span>  <?php echo $timing2; ?>  </p> 
		<?php
				endif;
		}
		if($contact && get_option('ptthemes_contact_on_detailpage') == 'Yes') { ?>
					<p> <span class="i_contact"> <?php echo PHONE.": "; ?> </span>  <?php echo $contact;?>  </p> <?php } ?>
		<p><?php favourite_html($post->post_author,$post->ID); ?> </p>
	</div>  
	<!-- company info -->
    <div class="company_info2">
        <!-- Add to Calendar Link -->
        <div class="calendar_with_print">
        <a href="#" onclick="window.print();return false;" class="i_print"><?php echo PRINT1; ?></a> 
        <?php get_add_to_calender();?></div> 
      	<?php 
		/* Show Rating */	    
		if(get_option('ptthemes_disable_rating') == 'no') {  ?>
			<p> <span class="i_rating"><?php echo RATING.": "; ?></span> 
			<span class="single_rating"> 
			<?php  echo get_post_rating_star($post->ID); ?>
        	</span> 
			</p>
		<?php } 
		/* Display Share LINK */
		?>
		<div class="share clarfix"> 
			<div class="addthis_toolbox addthis_default_style">
				<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c873bb26489d97f" class="addthis_button_compact sharethis"><?php echo SHARE_TEXT; ?></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
		</div>
		<!-- Display twitter and facebook Links -->
		<div class="links">
		<?php if($twitter) {  ?>
				<a class="i_twitter" href="<?php echo $twitter ;?>"  target="blank"><?php echo TWITTER; ?></a>      <?php } 
			  if($facebook) { ?>
				<a class="i_facebook" href="<?php echo $facebook;?>"  target="blank"><?php echo FACEBOOK; ?> </a>  <?php } ?>
        </div>
         <?php /* Sent to friend */
		 if(get_option('ptthemes_email_on_detailpage') == 'Yes') { ?>
         <a href="javascript:void(0);" onclick=" show_hide_popup('basic-modal-content');" title="<?php echo MAIL_TO_FRIEND;?>" class="i_email2 b_sendtofriend"><?php echo MAIL_TO_FRIEND;?></a> 
		<?php include_once (get_template_directory() . '/monetize/email_notification/popup_frms.php'); } 
		/* post Inquiry */
		if(get_option('ptthemes_inquiry_on_detailpage') == 'Yes') { ?>
        <a href="javascript:void(0);" onclick=" show_hide_popup('Inquiry-content');" title="<?php echo SEND_INQUIRY;?>" class="i_email2 i_sendtofriend"><?php echo SEND_INQUIRY;?></a> 
        <?php include_once (get_template_directory() .'/monetize/email_notification/popup_inquiry_frm.php'); } 
		/* Display custom fields where show on detail = yes is selected */
		global $custom_post_meta_db_table_name;
		$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE2."' or post_type='both')";
		$sql .=  " order by sort_order asc,cid asc";
		$post_meta_info = $wpdb->get_results($sql);
		foreach($post_meta_info as $post_meta_info_obj){ 
			if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='upload'){
			if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" || get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != " "){
				if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "st_time" && $post_meta_info_obj->htmlvar_name != "end_time" && $post_meta_info_obj->htmlvar_name != "video")	{			
					if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
						if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)){
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>"; }
					} else {
						
						if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) !=''){
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>"; }
					}
					}
				}		
			}else{
				if($post_meta_info_obj->ctype == 'multicheckbox'):
					$multiVal = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true);
					$arrVal="";
					if($multiVal && $multiVal != ""):
						foreach($multiVal as $_multiVal):
							$arrVal .= $_multiVal.",";
							endforeach;
					endif;
						if($arrVal && $arrVal != ""):
							echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".substr($arrVal,0,-1)."</div>";
						endif;	
				else:
					if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) !=''){
					echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>"; }
				endif;
					}
		} ?>
	</div>
	
	<?php
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('event_detail_sidebar')){?><?php } else {?>  <?php }
	echo '</div>';
}
/*
Name : templ_place_detail_sidebar
Description : call place detail sidebar dislpay everything related to detail page post
*/

function templ_place_detail_sidebar($post,$sidebar_class,$sidebar_id="",$post_type=''){
	global $wpdb;
	echo '<div id="'.$sidebar_id.'" class="'.$sidebar_class.'">';
	
	$address = stripslashes(get_post_meta($post->ID,'geo_address',true));
	$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
	$timing = get_post_meta($post->ID,'timing',true);
	$contact = stripslashes(get_post_meta($post->ID,'contact',true));
	$email = get_post_meta($post->ID,'email',true);
	$website = get_post_meta($post->ID,'website',true);
	$twitter = get_post_meta($post->ID,'twitter',true);
	$facebook = get_post_meta($post->ID,'facebook',true);	
	?>
	<div class="company_info">
		<?php global $post,$site_url;
		$custom_user = wp_get_current_user(); 
		$cuid = $custom_user->ID;
		$paid = $post->post_author;
		if($cuid == $paid)
		{
		?>
		<p class="edit-link"><a href="<?php echo $site_url;?>/?ptype=post_listing&pid=<?php echo $post->ID;?>" class="post-edit-link"><?php _e ('EDIT THIS','templatic');?></a></p>
		<?php } ?>
		<?php /* claim to ownership Begin */
		if(get_option('ptthemes_enable_claimownership') =='Yes'){
			global $post,$wpdb,$claim_db_table_name ;
			$claimreq = $wpdb->get_results("select * from $claim_db_table_name where post_id= '".$post->ID."' and status = '1'");
				if(mysql_affected_rows() >0 && get_post_meta($post->ID,'is_verified',true) == 1)
				{
					_e('<p class="i_verfied">Owner Verified Listing</p>','templatic');
				}else{
		?>	
		<a href="javascript:void(0);" title="<?php _e(CLAIM_OWNERSHIP); ?>" class="i_claim c_sendtofriend"><?php _e(CLAIM_OWNERSHIP); ?></a>
		<?php include_once (get_template_directory() .'/monetize/email_notification/popup_owner_frm.php'); ?>
		<?php } }
		/* claim to ownership Begin */
		/* display address */
		if($address) {     ?>
		<p> <span class="i_location"><?php echo ADDRESS.": "; ?></span> <?php echo get_post_meta($post->ID,'geo_address',true);?>   </p>
		<?php } 
		/* display website address */
		if($website){
				$website = $website;
				if(!strstr($website,'http')) {
					 $website = 'http://'.$website;
				} 
		if($website && get_post_meta($post->ID,'web_show',true) != 'No'){?>
				<p>  <span class="i_website"><a href="<?php echo $website;?>" target="blank"><strong><?php echo WEBSITE_TEXT; ?></strong></a>  </span> </p>
		<?php 	}
		} 
		/* display timing */
		if($timing){?>
		<p> <span class="i_time"> <?php echo TIME.": " ; ?> </span>  <?php echo $timing; ?>  </p> <?php } 
		/* display contact detail  */
		if($contact && get_option('ptthemes_contact_on_detailpage') == 'Yes') { ?>
		<p> <span class="i_contact"><?php echo PHONE.": "; ?> </span>  <?php echo $contact;?>  </p> <?php } ?>
		<p><?php favourite_html($post->post_author,$post->ID); ?> </p>
	</div> 
	<!-- company info -->
                
    <div class="company_info2">
		<?php 
		/* Display rating */
		if(get_option('ptthemes_disable_rating') == 'no') {  ?>
				<p> <span class="i_rating"><?php echo RATING.": "; ?></span> 
					<span class="single_rating"> 
						<?php  echo get_post_rating_star($post->ID); ?>
						</span> 
				</p>
		<?php } 
		/* Display share link */
		?>
       <div class="share clarfix"> 
			<div class="addthis_toolbox addthis_default_style">
			<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c873bb26489d97f" class="addthis_button_compact sharethis"><?php echo SHARE_TEXT; ?></a>
			</div>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
	   </div>
        <?php /* Display twitter and facebook link */ ?>
		<?php if($twitter || $facebook ) {  ?>
       <div class="links">
	       <?php if($twitter) {  ?>
			<a class="i_twitter" href="<?php echo $twitter ;?>"  target="blank"> <?php echo TWITTER; ?></a>      <?php } 
			if($facebook) { ?>
				<a class="i_facebook" href="<?php echo $facebook;?>"  target="blank"><?php echo FACEBOOK; ?></a>  <?php } ?>
       </div>
		<?php }
		 /* Display sent to friend */
		if(get_option('ptthemes_email_on_detailpage') == 'Yes') { ?>
			<a href="javascript:void(0);"  title="<?php echo MAIL_TO_FRIEND;?>" class="b_sendtofriend i_email2"><?php echo MAIL_TO_FRIEND;?></a> 
		<?php include_once (get_template_directory() . '/monetize/email_notification/popup_frms.php'); } 
		/* post Inquiry */
		if(get_option('ptthemes_inquiry_on_detailpage') == 'Yes') { ?>
			<a href="javascript:void(0);" title="I"  class="i_email2 i_sendtofriend"><?php echo SEND_INQUIRY;?></a> 
		<?php include_once (get_template_directory() .'/monetize/email_notification/popup_inquiry_frm.php'); } 
		/* Display custom fileds where show on detail = yes */
		global $custom_post_meta_db_table_name,$wpdb;
		$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail=1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both') ";
		$sql .=  " order by sort_order asc,cid asc";
		$post_meta_info = $wpdb->get_results($sql);
		foreach($post_meta_info as $post_meta_info_obj){ 
			if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='upload'){
				if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true) != "" ){
				if($post_meta_info_obj->htmlvar_name != "gallery" && $post_meta_info_obj->htmlvar_name != "twitter"  && $post_meta_info_obj->htmlvar_name != "facebook" && $post_meta_info_obj->htmlvar_name != "contact" && $post_meta_info_obj->htmlvar_name != "listing_image" && $post_meta_info_obj->htmlvar_name != "available" && $post_meta_info_obj->htmlvar_name != "geo_address" && $post_meta_info_obj->htmlvar_name != "website" && $post_meta_info_obj->htmlvar_name != "timing" && $post_meta_info_obj->htmlvar_name != "video")
				{
					if($post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea') {
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
					} else {
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
					}
				}
				}
			}else{
				if($post_meta_info_obj->ctype == 'multicheckbox'):
					$multiVal = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true);
					$arrVal="";
					if($multiVal && $multiVal != ""):
						foreach($multiVal as $_multiVal):
							$arrVal .= $_multiVal.",";
						endforeach;
					endif;
					if($arrVal && $arrVal != ""):
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".substr($arrVal,0,-1)."</div>";
					endif;
				else:
				if($post_meta_info_obj->ctype == 'radio'):
					$multiVal = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true);
					
					if($multiVal && $multiVal != ""):
						echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".$multiVal."</div>";
					endif;
					else:
					if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)):
					echo "<div class='i_customlable'><span class='".$post_meta_info_obj->style_class."'>".$post_meta_info_obj->site_title.": "."</span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,true)."</div>";
					endif;
				endif;
				endif;
			}				 
		} ?>        
    </div>
	
	<?php

		if (function_exists('dynamic_sidebar') && dynamic_sidebar('place_detail_sidebar')){?><?php } else {?>  <?php }

	echo '</div>';
}

/*
 * Function Name: add_event_palce_postcode
 * Argument: None
 * 
 */
function add_event_palce_postcode()
{
	global $wpdb;
	$postcodes_table = $wpdb->prefix . "postcodes";
	//place CUSTOM_POST_TYPE1
	$arg=array(
		'post_type'  => CUSTOM_POST_TYPE1,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'ignore_sticky_posts'=> 1
	);
	$results_place=get_posts($arg);
	foreach($results_place as $res)
	{
		$post_id=$res->ID;		
		/* update the place geo_latitude and geo_longitude in postcodes table */		
		$sql="select post_id from $postcodes_table where post_id=".$post_id;		
		$postid = $wpdb->get_var($sql);	
		$geo_latitude=get_post_meta($post_id,'geo_latitude',true);
		$geo_longitude=get_post_meta($post_id,'geo_longitude',true);	
		
		if($postid=="")
		{
			$sql="insert into $postcodes_table (post_id,post_type,latitude,longitude) values(".$post_id.",'place','". $geo_latitude."','". $geo_longitude."')";	
			$wpdb->query($sql);	
		}	
		/*Finish the update place geo_latitude and geo_longitude in postcodes table */
	}
	//finish the places add or update latitude and longitude in postcodes table
	
	
	//event	 CUSTOM_POST_TYPE2
	$arg=array(
		'post_type'  => CUSTOM_POST_TYPE2,
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'ignore_sticky_posts'=> 1
	);	
	$results_event=get_posts($arg);
	foreach($results_event as $res)
	{
		$post_id=$res->ID;		
		/* update the event geo_latitude and geo_longitude in postcodes table */		
		$sql="select post_id from $postcodes_table where post_id=".$post_id;
		$postid = $wpdb->get_var($sql);	
		$geo_latitude=get_post_meta($post_id,'geo_latitude',true);
		$geo_longitude=get_post_meta($post_id,'geo_longitude',true);	
		
		if($postid=="")
		{
			$sql="insert into $postcodes_table(post_id,post_type,latitude,longitude) values(".$post_id.",'event','". $geo_latitude."','". $geo_longitude."')";				
			$wpdb->query($sql);	
		}	
		/*Finish the update event geo_latitude and geo_longitude in postcodes table */
	}	
	//finish the event add or update latitude and longitude in postcodes table 	
	
}
/*
 * create action for insert event, place latitude and longitude in postcodes table 
 */
add_action( 'admin_init', 'add_event_palce_postcode');

/*
Name :get_pagination
desc : pagination 
*/
function wp_get_pagination($targetpage,$total_pages,$limit=10,$page=0,$target_page)
{ 
	/* Setup page vars for display. */
			if ($page == 0) $page = 1;					//if no page var is given, default to 1.
			$prev = $page - 1;							//previous page is page - 1
			$next = $page + 1;							//next page is page + 1
			$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;						//last page minus 1
			
			if(strstr($targetpage,'?'))
			{
				$querystr = "&pagination";
			}else
			{
				$querystr = "?pagination";
			}
			$pagination = "";
			if($lastpage > 1)
			{	
				$pagination .= "<div class=\"pagination\">";
				//previous button
				if ($page > 1) 
					$pagination.= "<a class='pnav' href=\"$targetpage$querystr=$prev$target_page\">&laquo; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	
				
				//pages	
				if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage$querystr=$counter$target_page\">$counter</a>";					
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter$target_page\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage$querystr=$lpm1$target_page\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=$lastpage$target_page\">$lastpage</a>";		
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage$querystr=1$target_page\">1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=2$target_page\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter$target_page\">$counter</a>";					
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage$querystr=$lpm1$target_page\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=$lastpage$target_page\">$lastpage</a>";		
					}
					//close to end; only hide early pages
					else
					{
						$pagination.= "<a href=\"$targetpage$querystr=1$target_page\">1</a>";
						$pagination.= "<a href=\"$targetpage$querystr=2$target_page\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage$querystr=$counter$target_page\">$counter</a>";					
						}
					}
				}
				
				//next button
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage$querystr=$next$target_page\">next &raquo;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &raquo;</span>";
				$pagination.= "</div>\n";		
			}
			return $pagination;
}

/* NAME : ADD PRICE AND ICON FIELDS IN CATEGORIES
DESCRIPTION : THIS FUNCTION WILL ADD PRICE AND CATEGORY ICON FIELDS IN BACK END */
$taxonomies = array('place_cat' => 'placecategory',
					'event_cat' => 'eventcategory');
foreach( $taxonomies as $key => $taxonomy )
{
	add_action($taxonomy.'_edit_form_fields','edit_category_custom_fields');
	add_action($taxonomy.'_add_form_fields','add_categories_custom_fields');
	add_action('edited_term','alter_category_custom_fields');
	add_action('created_'.$taxonomy,'alter_category_custom_fields');
	/* FILTERS TO MANAGE PRICE COLUMNS */
	add_filter('manage_edit-'.$taxonomy.'_columns', 'edit_price_cat_col');	
	add_filter('manage_'.$taxonomy.'_custom_column', 'manage_price_cat_col', 10, 3);
}

/* 
NAME : ADD THE CATEGORY PRICE
ARGUMENTS : TAXONOMY NAME
DESCRIPTION : THIS FUNCTIONS IS USED TO ADD THE PRICE, ICON FIELD IN CATEGORY
*/
function add_categories_custom_fields($tax)
{
	add_category_field($tax,'add');
}
/* EOF - ADD CATEGORY PRICE */

/* NAME : FUNCTION TO ADD/EDIT CATEGORY PRICE FIELD
ARGUMENTS : TAXONOMY NAME, OPERATION
DESCRIPTION : THIS FUNCTION ADDS/EDITS THE CATEGORY PRICE, ICON FIELD IN BACK END */
function add_category_field($tax,$screen)
{
	$taxonomy = $tax->taxonomy;
	$term_price = $tax->term_price;	
	$currency_symbol = get_currency_sym();	
	$term_icon = $tax->term_icon;
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="cat_price"><?php _e("Category Price", 'templatic'); echo ' ('.$currency_symbol.')'?></label></th>
			<td><input type="text"  name="cat_price" id="category_price" value="<?php echo $term_price;?>"  size="20"/>
            <p class="description"><?php _e('This is  category price. category price value in ','templatic');echo $currency_symbol;?></p>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label for="cat_price"><?php _e("Icon", 'templatic'); ?></label></th>
			<td><input type="text"  name="cat_icon" id="category_icon" value="<?php echo $term_icon;?>"  size="20"/>
            <p class="description"><?php _e('You can upload the category icon from here.','templatic'); ?></p>
			</td>
		</tr>
<?php
}
/* EOF - ADD/EDIT CATEGORY PRICE FIELD */

/* NAME : EDIT THE CATEGORY PRICE
ARGUMENTS : TAXONOMY NAME
DESCRIPTION : THIS FUNCTIONS IS USED TO EDIT THE PRICE, ICON FIELD IN CATEGORY */
function edit_category_custom_fields($tax)
{
	add_category_field($tax,'edit');	
}
/* EOF - EDIT CATEGORY PRICE */

/* NAME : EDIT THE CATEGORY PRICE
ARGUMENTS : TERM ID
DESCRIPTION : THIS FUNCTIONS IS USED TO EDIT THE PRICE, ICON FIELD IN CATEGORY */
function alter_category_custom_fields($termId)
{
	global $wpdb;
	$term_table = $wpdb->prefix."terms";	
	$cat_price = $_POST['cat_price'];
	$cat_icon = $_POST['cat_icon'];
	if($cat_price != '')
	{
		$sql = "update $term_table set term_price=".$cat_price.", term_icon = '".$cat_icon."'  where term_id=".$termId;
		$wpdb->query($sql);
	}
}
/* EOF - EDIT CATEGORY PRICE */

/* NAME : ADD PRICE COLUMN IN TERMS TABLE
ARGUMENTS : COLUMN NAME
DESCRIPTION : THIS FUNCTION ADDS A COLUMN IN CATEGORY TABLE */
function edit_price_cat_col($columns)
{
	$args = array('place_cat' => CUSTOM_POST_TYPE1,
				  'event_cat' => CUSTOM_POST_TYPE2);

	foreach($args as $key => $val)
	{
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'name' => __('Name'),
			'price' =>  __('Price'),
			'icon' =>  __('Icon'),
			'description' => __('Description'),
			'slug' => __('Slug'),
			'posts' => __('Posts')
			);
	}
	return $columns;
}
/* EOF - ADD COLUMN */
	
/* NAME : DISPLAY PRICE COLUMN IN TERMS TABLE
ARGUMENTS : COLUMN NAME, OUTPUT, CATEGORU ID
DESCRIPTION : THIS FUNCTION DISPLAYS PRICE IN CATEGORY TABLE */
function manage_price_cat_col($out, $column_name, $cat_id)
{
	global $wpdb;
	$sql = "SELECT term_price, term_icon from $wpdb->terms WHERE term_id = '".$cat_id."'";
	$term_data = $wpdb->get_results($sql);
	foreach( $term_data as $term )
	{
		switch ($column_name)
		{
			case 'price':
					$currency_symbol = get_option('currency_sym');			
					$symbol_position = get_option('currency_pos');
					$amount = $term->term_price;
					if(!$amount){ $amount = 0; }
					$price = $amount.$currency_symbol;
					$out .= $price;
			break;
			case 'icon':
				$icon =  "<img src='".$term->term_icon."' />";
				$out .= $icon; 
			break;
		}
	}
	return $out;	
}
/* EOF - DISPLAY PRICE */
/*
name :wpml_insert_templ_post
desc : enter language details when wp_insert_post in process ( during insert the post )
*/
function wpml_insert_templ_post($last_post_id,$post_type){
		global $wpdb,$sitepress;
		$icl_table = $wpdb->prefix."icl_translations";
		$current_lang_code= ICL_LANGUAGE_CODE;
		$element_type = "post_".$post_type;
		$default_languages = ICL_LANGUAGE_CODE;
		$default_language = $sitepress->get_default_language();
		$trid = $wpdb->get_var($wpdb->prepare("select trid from $icl_table order by trid desc LIMIT 0,1"));
		//	echo $insert_tr = " INSERT INTO $icl_table (`translation_id` ,`element_type` ,`element_id` ,`trid` ,`language_code` ,`source_language_code`)VALUES ( '' , '".$element_type."', $last_post_id, $trid , '".$current_lang_code."', '".$current_lang_code."')";
		$update = "update $icl_table set language_code = '".$current_lang_code."' where element_id = '".$last_post_id."' and trid=$trid";
		$wpdb->query($update);		/* insert in transactions table */
}

add_action('templ_head_css','templ_responsive_map');
/*
Name :templ_responsive_map
Description : Map hide in responsive ,return the media query for css
*/
function templ_responsive_map(){
	$ptthemes_enable_responsivemap = get_option('ptthemes_enable_responsivemap'); 
	if(strtolower($ptthemes_enable_responsivemap) == strtolower('Yes')){ ?>
		<style>
			@media only screen and (max-width: 719px){
				.top_banner_section{ display:none; }
			}
		</style>
	<?php }	
}

add_action('wp_head','set_ie_cookies');

function set_ie_cookies(){ 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
}
/* FILTERS TO ADD A COLUMN ON ALL USRES PAGE */
add_filter('manage_users_columns', 'add_event_column');
add_filter('manage_users_custom_column', 'view_event_column', 10, 3);

/* FUNCTION TO ADD A COLUMN */
function add_event_column($columns) {
$columns['events'] = 'Events';
$columns['places'] = 'Places';
return $columns;

}

/* FUNCTION TO DISPLAY NUMBER OF ARTICLES */
function view_event_column($out, $column_name, $user_id)
{
	global $wpdb,$events;
	if( $column_name == 'events' )
	{
		$events = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '".CUSTOM_POST_TYPE2."' AND post_author = ".$user_id."");
	}
	if( $column_name == 'places' )
	{
		$events = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = '".CUSTOM_POST_TYPE1."' AND post_author = ".$user_id."");
	}
	return $events;
}
/* EOF - ADD COLUMN ON ALL USERS PAGE */





/* THEME UPDATE CODING START */


//Theme update templatic menu
function GeoPlaces_tmpl_theme_update(){
	require_once(get_template_directory()."/templatic_login.php");
}


/* Theme update templatic menu*/
function GeoPlaces_tmpl_support_theme(){
	echo "<h3>Need Help?</h3>";
	echo "<p>Here's how you can get help from templatic on any thing you need with regarding this theme. </p>";
	echo "<br/>";
	echo '<p><a href="http://templatic.com/docs/realtr-theme-guide-2/" target="blank">'."Take a look at theme guide".'</a></p>';
	echo '<p><a href="http://templatic.com/docs/" target="blank">'."Knowlegebase".'</a></p>';
	echo '<p><a href="http://templatic.com/forums/" target="blank">'."Explore our community forums".'</a></p>';
	echo '<p><a href="http://templatic.com/helpdesk/" target="blank">'."Create a support ticket in Helpdesk".'</a></p>';
}

/* Theme update templatic menu*/
function GeoPlaces_tmpl_purchase_theme(){
	wp_redirect( 'http://templatic.com/wordpress-themes-store/' ); 
	exit;
}

add_action('admin_menu','GeoPlaces_theme_menu',11); // add submenu page 
add_action('admin_menu','delete_GeoPlaces_templatic_menu',11);
function GeoPlaces_theme_menu(){
	
	add_menu_page('Templatic', 'Templatic', 'administrator', 'templatic_menu', 'GeoPlaces_tmpl_theme_update', ''); 
	
	add_submenu_page( 'templatic_menu', 'Theme Update','Theme Update', 'administrator', 'GeoPlaces_tmpl_theme_update', 'GeoPlaces_tmpl_theme_update',27 );
	
	add_submenu_page( 'templatic_menu', 'Get Support' ,'Get Support' , 'administrator', 'GeoPlaces_tmpl_support_theme', 'GeoPlaces_tmpl_support_theme',29 );
	
	add_submenu_page( 'templatic_menu', 'Purchase theme','Purchase theme', 'administrator', 'GeoPlaces_tmpl_purchase_theme', 'GeoPlaces_tmpl_purchase_theme',30 );
}

/*
	Realtr delete menu 
*/	
function delete_GeoPlaces_templatic_menu(){
	remove_submenu_page('templatic_menu', 'templatic_menu'); 
}
/* THEME UPDATE CODING END */


?>