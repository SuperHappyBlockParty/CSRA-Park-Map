<?php
// =============================== Google Map Single page======================================
class googlemmap_singlepage extends WP_Widget {
	function googlemmap_singlepage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map in Detail page Sidebar', 'description' => __('Google Map in Detail page Sidebar. It will show you google map V3 for detail page only.') );		
		$this->WP_Widget('googlemmapwidget_single', __('PT &rarr; Google Map V3 - Detail page'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$advt1 = empty($instance['advt1']) ? '' : apply_filters('widget_advt1', $instance['advt1']);
		$link1 = empty($instance['link1']) ? '' : apply_filters('widget_link1', $instance['link1']);
		 ?>						
 	    
                    	<div class="sidebar_map clearfix">
<?php
global $post,$wp_query;
$post = $wp_query->post;
if(is_single()){
if(get_post_meta($post->ID,'address',true))
{
	$address = get_post_meta($post->ID,'geo_address',true);
}else
{
	$address = get_post_meta($post->ID,'geo_address',true);
}
$address_latitude = get_post_meta($post->ID,'geo_latitude',true);
$address_longitude = get_post_meta($post->ID,'geo_longitude',true);
$map_type = get_post_meta($post->ID,'map_view',true);
if($map_type=='Default Map')
{
	$map_type='ROADMAP';
}elseif($map_type=='Satellite Map')
{
	$map_type='SATELLITE';
}elseif($map_type=='Hybrid Map')
{
	$map_type='TERRAIN';
} else {
	$map_type='ROADMAP';
}
if(get_post_meta($post->ID,'zooming_factor',true)){
$scale = get_post_meta($post->ID,'zooming_factor',true);
} else {
$scale = 14;
}

if( $post->post_type== CUSTOM_POST_TYPE1)
{
	$cagInfo = wp_get_object_terms($post->ID,CUSTOM_CATEGORY_TYPE1,$args);
}else
{
	$cagInfo = wp_get_object_terms($post->ID,CUSTOM_CATEGORY_TYPE2,$args);
}

$cat_icon = $cagInfo[count($cagInfo)-1]->term_icon;
if($cat_icon=='')
{
	//$cat_icon ='';	
	$cat_icon = get_template_directory_uri().'/images/default.png';	
}
$prdimage =  bdw_get_images($post->ID,'thumb',1);

$srch_arr = array("'",'"','\\');
$rpl_arr = array('','','');
$contact = trim(str_replace($srch_arr,$rpl_arr,get_post_meta($post->ID,'contact',true)));
$post_title = trim(str_replace($srch_arr,$rpl_arr,get_the_title($post->ID)));
$address = trim(str_replace($srch_arr,$rpl_arr,$address));
$pimgarr =  bdw_get_images_with_info($post->ID,'thumb');	
$attachment_id = $pimgarr[0]['id'];
$alt = str_replace($srcharr,$replarr,get_post_meta($attachment_id, '_wp_attachment_image_alt', true));
$attach_data = get_post($attachment_id);
$ititle = str_replace($srcharr,$replarr,$attach_data->post_title);
if($ititle ==''){ $ititle = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }
if($alt ==''){ $alt = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }

$pimg = $pimgarr[0]['file'];
$thumb = vt_resize($attachment_id,$pimg, 90,75, $crop = true );

$thumb = $thumb['url'];
if($thumb ==''){
$thumb = get_template_directory_uri()."/images/no-image.png";
}

$tooltip_message = '<div style="float:left;width:270px;"><div style="float:left;width:70px;">';
$tooltip_message = '<img src="'.$thumb.'"  style="float:left;margin:0 10px 5px 0;" alt="" /></div>';
$tooltip_message .= '<div style="float:left;width:100px;"><a href="'.get_permalink($post->ID).'" class="ptitle">'.$post_title.'</a>';
if($post->post_type == CUSTOM_POST_TYPE1) {
	$timing = str_replace($srcharr,$replarr,(get_post_meta($post->ID,'timing',true)));
} else {
	$timing = date('M d, Y',strtotime(get_post_meta($post->ID,'st_date',true))).' to '.date('M d, Y',strtotime(get_post_meta($post->ID,'end_date',true))).'<br />'.get_post_meta($post->ID,'st_time',true).' to '.get_post_meta($post->ID,'end_time',true);
}
if($address){
$tooltip_message .= '<br/><span class="pcontact">'.$address.'</span>';
}
if($timing){
$tooltip_message .= '<br/><span class="pcontact">'.$timing.'</span>';
}

if($contact){
$tooltip_message .= '<br/><span class="pcontact">'.wordwrap($contact,40,'<br/>\n').'</span>';
}
$tooltip_message .= '</div></div>';				
if($address_longitude && $address_latitude)
{

?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.5&sensor=false"></script>
<script type="text/javascript">
/* <![CDATA[ */

var basicsetting = {
    draggable: true
  };
  var directionsDisplay = new google.maps.DirectionsRenderer(basicsetting);
  var directionsService = new google.maps.DirectionsService();
  var map;
 
  var latLng = new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>);
 
  function initialize() {
 
    var myOptions = {
      zoom: <?php echo $scale;?>,
      mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>,
	   zoomControl: true,
      center: latLng	  
    };
    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
 
    var image = '<?php echo $cat_icon;?>';
	var myLatLng = new google.maps.LatLng(<?php echo $address_latitude;?>, <?php echo $address_longitude;?>);
	var Marker = new google.maps.Marker({
	  position: latLng,
	  map: map,
	  icon: image
	});
	var content = '<?php echo $tooltip_message;?>';
	infowindow = new google.maps.InfoWindow({
	  content: content
	});
	
	google.maps.event.addListener(Marker, 'click', function() {
      infowindow.open(map,Marker);
    });
	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
   
    });
 }
  
function getSelectedTravelMode() {
    var travelvalue =  document.getElementById('travel-mode-input').value;
	
    if (travelvalue == 'driving') {
      travelvalue = google.maps.DirectionsTravelMode.DRIVING;
    } else if (travelvalue == 'bicycling') {
      travelvalue = google.maps.DirectionsTravelMode.BICYCLING;
    } else if (travelvalue == 'walking') {
      travelvalue = google.maps.DirectionsTravelMode.WALKING;
    } else {
      alert('Unsupported travel mode.');
    }
    return travelvalue;
  }
  
  function calcRoute() {
		var destination_val = document.getElementById('fromAddress').value;
 
        var request = {
          origin: destination_val,
          destination: "<?php echo $address_latitude;?>, <?php echo $address_longitude;?>",
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }else {alert('<?php _e('Address not found for:','templatic');?>'+ destination_val);}
        });
      }
 
  google.maps.event.addDomListener(window, 'load', initialize);

/* ]]> */
</script>
<div id="map-canvas" style="width:100%; height:360px;"></div>
<div class="search_location">
<input id="to-input" type="hidden" value="<?php echo get_post_meta($post->ID,'address',true);?>"/>
<select id="travel-mode-input" style="display:none;">
  <option value="driving" selected="selected"><?php _e('By car','templatic');?></option>
  <option value="bicycling"><?php _e('Bicycling','templatic');?></option>
  <option value="walking"><?php _e('Walking','templatic');?></option>
</select>
<input type="text"  id="fromAddress" name="from" class="textfield"  value="<?php _e('Enter Your Location','templatic');?>"  onblur="if (this.value == '') {this.value = '<?php _e('Enter Your Location','templatic');?>';}" onfocus="if (this.value == '<?php _e('Enter Your Location','templatic');?>') {this.value = '';}" />
<input type="button" value="" class="b_getdirection" onclick="calcRoute()" />
</div>

 <div id="directionsPanel" style="width: 275px"></div>
<?php
	} 
}
?>
</div> 
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['advt1'] = ($new_instance['advt1']);
		$instance['link1'] = ($new_instance['link1']);

		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '', 'link1' => '') );		
		$title = strip_tags($instance['title']);
		$advt1 = ($instance['advt1']);
		$link1 = ($instance['link1']);
	}}
register_widget('googlemmap_singlepage');
?>