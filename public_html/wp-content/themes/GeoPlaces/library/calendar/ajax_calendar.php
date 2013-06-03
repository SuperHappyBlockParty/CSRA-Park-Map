<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
global $post,$wpdb;
if(is_plugin_active('wpml-translation-management/plugin.php'))
{
	global $sitepress;
	$sitepress->switch_lang($_REQUEST['language']);
}

	$monthNames = array(__('January','templatic'), __('February','templatic'), __('March','templatic'), __('April','templatic'), __('May','templatic'), __('June','templatic'), __('July','templatic'), __('August','templatic'), __('September','templatic'), __('October','templatic'), __('November','templatic'), __('December','templatic'));
	
	if (!isset($_REQUEST["mnth"])) $_REQUEST["mnth"] = date("n");
	if (!isset($_REQUEST["yr"])) $_REQUEST["yr"] = date("Y");
	
	$cMonth = $_REQUEST["mnth"];
	$cYear = $_REQUEST["yr"];
	
	$prev_year = $cYear;
	$next_year = $cYear;
	$prev_month = $cMonth-1;
	$next_month = $cMonth+1;
	
	if ($prev_month == 0 ) {
		$prev_month = 12;
		$prev_year = $cYear - 1;
	}
	if ($next_month == 13 ) {
		$next_month = 1;
		$next_year = $cYear + 1;
	}
	$mainlink = $_SERVER['REQUEST_URI'];
	if(strstr($_SERVER['REQUEST_URI'],'?mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "?mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}elseif(strstr($_SERVER['REQUEST_URI'],'&mnth') && strstr($_SERVER['REQUEST_URI'],'&yr'))
	{
		$replacestr = "&mnth=".$_REQUEST['mnth'].'&yr='.$_REQUEST['yr'];
		$mainlink = str_replace($replacestr,'',$mainlink);
	}
	if(strstr($_SERVER['REQUEST_URI'],'?') && !strstr($_SERVER['REQUEST_URI'],'?mnth'))
	{
		$pre_link = $mainlink."&mnth=". $prev_month . "&yr=" . $prev_year;
		$next_link = $mainlink."&mnth=". $next_month . "&yr=" . $next_year;
	}else
	{
		$pre_link = $mainlink."?mnth=". $prev_month . "&yr=" . $prev_year;	
		$next_link = $mainlink."?mnth=". $next_month . "&yr=" . $next_year;
	}

	
	?> 
 <table width="100%">
	<tr align="center">
	<td > 
    
   <table width="100%">
    <tr align="center" class="title">
    <td width="10%" class="title"> <a href="javascript:void(0);" onclick="change_calendar(<?php echo $prev_month; ?>,<?php echo $prev_year; ?>)"> <img src="<?php bloginfo('template_directory'); ?>/library/calendar/previous.png" alt=""  /></a></td>
	<td   class="title"><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></td>
    <td width="10%" class="title"><a href="javascript:void(0);"  onclick="change_calendar(<?php echo $next_month; ?>,<?php echo $next_year; ?>)">  <img src="<?php bloginfo('template_directory'); ?>/library/calendar/next.png" alt=""  /></a> </td>
	</tr>
            </table>
    
     </td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td  ></td>
	<td align="right"  ></td>
	</tr>
	</table>
	</td>
	</tr>
	<tr>
	<td align="center">
	<table width="100%" border="0" cellpadding="2" cellspacing="2"  class="calendar_widget">
	
	<tr>
	<td align="center" class="days"><?php _e('Sun','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Mon','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Tue','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Wed','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Thu','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Fri','templatic'); ?></td>
	<td align="center" class="days"><?php _e('Sat','templatic'); ?></td>
	</tr> 
	<?php
	add_filter('posts_where', 'searching_filter_where');	
	$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
	$maxday = date("t",$timestamp);
	$thismonth = getdate ($timestamp);
	$startday = ($thismonth['wday'] + 1);
	
	if($_GET['m'])
	{
		$m = $_GET['m'];	
		$py=substr($m,0,4);
		$pm=substr($m,4,2);
		$pd=substr($m,6,2);
		$monthstdate = "$cYear-$cMonth-01";
		$monthenddate = "$cYear-$cMonth-$maxday";
	}
	global $wpdb;
		global $wpdb;
	for ($i=1; $i<($maxday+$startday); $i++) {
		if(($i % 7) == 1 ) echo "<tr>\n";
		if($i < $startday){
			echo "<td class='date_n'></td>\n";
		}
		else 
		{
			$cal_date = $i - $startday + 1;
			$calday = $cal_date;
			if(strlen($cal_date)==1)
			{
				$calday="0".$cal_date;
			}
			$the_cal_date = $cal_date;
			$cMonth_date = $cMonth;
			if(strlen($the_cal_date)==1){$the_cal_date = '0'.$the_cal_date;}
			if(strlen($cMonth_date)==1){$cMonth_date = '0'.$cMonth_date;}
			global $post,$wpdb;
			$urlddate = "$cYear$cMonth_date$calday";
			$thelink = get_option('home')."/?s=cal_event&amp;m=$urlddate";
			/* create todat date - pass in query for fetching evnets day in calendar */
			$todaydate = "$cYear-$cMonth_date-$the_cal_date";
			
			/* Set the style left as per par calendar */
			global $todaydate;
				$args=
				array( 'post_type' => 'event',
				'posts_per_page' => -1	,
				'post_status' => array('publish','private'),
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'st_date',
						'value' => $todaydate,
						'compare' => '<=',
						'type' => 'DATE'
					),
					array(
						'key' => 'end_date',
						'value' => $todaydate,
						'compare' => '>=',
						'type' => 'DATE'
					)
				)
				);

			set_query_var( 'orderby','meta_value' );
			set_query_var( 'meta_key', 'st_date' );

				$my_query1 = null;
				$my_query1 = new WP_Query($args);
		
				$post_info = '';
				$test = get_post_meta($post->ID,'address',true);
				if( $my_query1->have_posts() )
				{
					$location_str = "Location:";
					if(function_exists('icl_register_string')){
						$location = icl_register_string('templatic',$location_str,$location_str);
					}

					if(function_exists('icl_t')){
						$location1 = icl_t('templatic',$location_str,$location_str);
					}else{
						$location1 = __($location_str,'templatic'); 
					}
					
					$st_date_str = "Start Date:";
					if(function_exists('icl_register_string')){
						$st_date = icl_register_string('templatic',$st_date_str,$st_date_str);
					}

					if(function_exists('icl_t')){
						$st_date1 = icl_t('templatic',$st_date_str,$st_date_str);
					}else{
						$st_date1 = __($st_date_str,'templatic'); 
					}
					
					$end_date_str = "End Date:";
					if(function_exists('icl_register_string')){
						$end_date = icl_register_string('templatic',$end_date_str,$end_date_str);
					}

					if(function_exists('icl_t')){
						$end_date1 = icl_t('templatic',$end_date_str,$end_date_str);
					}else{
						$end_date1 = __($end_date_str,'templatic'); 
					}
					
					$post_info .='<span class="popup_event">';
					while ($my_query1->have_posts()) : $my_query1->the_post();
						$post_info .=' 
						   <a class="event_title" href="'.get_permalink($post->ID).'">'.$post->post_title.'</a><small><b>'.
						  $location1.' </b>'.get_post_meta($post->ID,'geo_address',true) .'<br><b>'.
						  $st_date1.' </b>'.get_formated_date(get_post_meta($post->ID,'st_date',true)).' '.get_formated_time(get_post_meta($post->ID,'st_time',true)) .'<br /><b>'. 
						  $end_date1.' </b>'.get_formated_date(get_post_meta($post->ID,'end_date',true)).' '.get_formated_time(get_post_meta($post->ID,'end_time',true)) .'</small>';
					endwhile;
					$post_info .='</span>';
				}
				echo "<td class='date_n' >";
				if($my_query1->have_posts())
				{
					echo "<div><a class=\"event_highlight\" href=\"$thelink\">". ($cal_date) . "</a>".$post_info;
				}else
				{
						echo "<span class=\"no_event\" >". ($cal_date) . "</span>";
				}
				echo "</div></td>\n";
		}
		if(($i % 7) == 0 ) echo "</tr>\n";
	}?>
	</table>
	</td>
	</tr>
	</table>
  