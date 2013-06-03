<?php
if(!function_exists('get_search_listing')) {
function get_search_listing()
{
	global $wpdb,$wp_query, $post;
	$category_info_arr = array();
	$post_content_info = array();
	if ( have_posts() ) 
	{
		$srch_posts = array();
		while ( have_posts() ){ the_post();
			$srch_posts[] = $post->ID;
			$args = wp_parse_args( $args, array('fields' => 'ids') );
			if( $post->post_type==CUSTOM_POST_TYPE1)
			{
				$category_arr = wp_get_object_terms($post->ID,CUSTOM_CATEGORY_TYPE1,$args);
				$category_info_arr[$category_arr[count($category_arr)-1]][]=$post;
			}else
			{
				$category_arr = wp_get_object_terms($post->ID,CUSTOM_CATEGORY_TYPE2,$args);
				$category_info_arr[$category_arr[count($category_arr)-1]][]=$post;
			}
		}
		foreach($category_info_arr as $term_id=>$postinfo)
		{
			if(trim($term_id))
			{
				$map_cat_ids = $map_cat_arr;
				$catsql = "select c.term_icon from $wpdb->terms c  where c.term_id in ($term_id)";	
			}
			$term_icon = $wpdb->get_var($catsql);
			if(!$term_icon)
			{
				$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
			}
			$content_data = array();
			if(is_array($postinfo))
			{
				//$srcharr = array("'","/","-",'"','\\');
				//$replarr = array("&prime;","&frasl;","&ndash;","&ldquo;",'');
				$srcharr = array("'");
				$replarr = array("\'");
				for($p=0;$p<count($postinfo);$p++)
				{
					$postinfo_obj = $postinfo[$p];
					$ID = $postinfo_obj->ID;
					$post_content_info[] = $ID;
					$title = str_replace($srcharr,$replarr,$postinfo_obj->post_title);
					$plink = get_permalink($postinfo_obj->ID);
					$lat = get_post_meta($ID,'geo_latitude',true);
					$lng = get_post_meta($ID,'geo_longitude',true);
					$address = str_replace($srcharr,$replarr,get_post_meta($ID,'geo_address',true));
					$contact = str_replace($srcharr,$replarr,get_post_meta($ID,'contact',true));
					$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					$pimgarr =  bdw_get_images_with_info($ID,'medium');				
					$attachment_id = $pimgarr[0]['id'];
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$ititle = $attach_data->post_title;
					if($ititle ==''){ $ititle = $postinfo_obj->post_title; }
					$ititle = str_replace($srcharr,$replarr,$ititle);
					$pimg = $pimgarr[0]['file'];
					
					if($pimg){
					$thumb = vt_resize($attachment_id,$pimg, 90,75, $crop = true );
					$thumb = $thumb['url'];
					}else{
					$thumb = get_template_directory_uri()."/images/no-image.png";
					}
					if($lat && $lng)
					{
						$retstr ="{";
						$retstr .= "'name':'$title',";
						$retstr .= "'location': [$lat,$lng],";
						$retstr .= "'message':'<img src=\"$thumb\" width=\"90\" height=\"70\" style=\"float:left; margin:0 11px 22px 0;\" alt=\"$alt\" title=\"$ititle\" />";
						$retstr .= "<a href=\"$plink\" class=\"ptitle\">$title</a>";
						if($address){$retstr .= "<br/><span class=\"ptiming\">$address</span>";}
						if($timing){$retstr .= "<br/><span class=\"pcontact\">$timing</span>";}
						if($contact){$retstr .= "<br/><span class=\"pcontact\">$contact</span>";}
						$retstr .= "',";
						$retstr .= "'icons':'$term_icon',";
						$retstr .= "'pid':'$ID'";
						$retstr .= "}";
						$content_data[] = $retstr;
					}
				}
			}
			if($content_data)
			{
				if(trim($term_id))
				{
					$name =  "select c.name from $wpdb->terms c  where c.term_id in ($term_id)";
				}
				
				$arrsrch = array("'",'"','/',',',".",' ');
				$arrrep = array('','','','','','');
				$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
				$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
				$cat_name_info[] = array($name,$catname,$term_icon);
			}
			
		}
	}
	if($cat_content_info)
	{
		return array(implode(',',$cat_content_info),$post_content_info);
	}
}
}
if(!function_exists('get_category_map_listing')) {
function get_category_map_listing()
{
	return get_search_listing();	
}
}
if(!function_exists('get_category_listing')) {
function get_category_listing()
{
	if(is_search() || is_tag() || is_date() || is_month() || is_day() || is_year())
	{
		$catarr = get_search_listing();
	}else
	{
		$catarr = get_category_map_listing();
	}
	return $catarr;
}
}
// =============================== Google Map V3 Listing page======================================
class googlemmap_listingpage extends WP_Widget {
	function googlemmap_listingpage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map for Listing page', 'description' => __('Google Map for Listing page. It will show you google map V3 for Listing page.') );		
		$this->WP_Widget('googlemmapwidget_listing', __('PT &rarr; Google Map V3 - Listing page'), $widget_ops);
	}
	function widget($args, $instance) {
	global $map_display_category;
	if($map_display_category == 'yes') {
	// prints the widget
	extract($args, EXTR_SKIP);
	$width = empty($instance['width']) ? '294' : apply_filters('widget_width', $instance['width']);
	$heigh = empty($instance['heigh']) ? '370' : apply_filters('widget_heigh', $instance['heigh']);
	$catarr = get_category_listing();
	$catinfo = $catarr[0];
	$postinfo = $catarr[1];
	?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.5&sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markermanager.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markerclusterer_packed.js"></script>
<script type="text/javascript">
/* <![CDATA[ */

var CITY_MAP_CENTER_LAT= '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG= '<?php echo get_current_city_lng();?>';
<?php if(get_current_city_scale_factor() != '') {?>
var CITY_MAP_ZOOMING_FACT= <?php echo get_current_city_scale_factor();?>;
<?php } 
if(get_current_city_map_type() != '') { 
$maptype = get_current_city_map_type();
} else { 
$maptype = 'ROADMAP';
} ?>
/**
 * Data for the markers consisting of a name, a LatLng and a pin image, message box content for
 * the order in which these markers should display on top of each
 * other.
 */
var markers = {<?php echo $catinfo;?>};

var map = null;
var mgr = null;
var mc = null;
var markerClusterer = null;
var showMarketManager = false;
var infoWindow = null;
<?php if(get_current_city_set_zooming_opt() == '1') { ?>
 var multimarkerdata = new Array();
<?php } ?>
if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT =='')
{
	var CITY_MAP_ZOOMING_FACT = 1;
}else if(CITY_MAP_ZOOMING_FACT == '')
{
	var CITY_MAP_ZOOMING_FACT = 13;	
}
var PIN_POINT_ICON_HEIGHT = 32;
var PIN_POINT_ICON_WIDTH = 20;


if(MAP_DISABLE_SCROLL_WHEEL_FLAG)
{
	var MAP_DISABLE_SCROLL_WHEEL_FLAG = 'No';	
}

function initialize() {
  var myOptions = {
    zoom: CITY_MAP_ZOOMING_FACT,
    center: new google.maps.LatLng(CITY_MAP_CENTER_LAT, CITY_MAP_CENTER_LNG),
    mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>
  }
   map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
   google.maps.event.addListener(map, 'center_changed', function() {
      // The marker manager doesn't listen to this event, so we have to trigger the event it does listen to
      google.maps.event.trigger(map, 'dragend');
   });
	infoWindow = new google.maps.InfoWindow();
   mgr = new MarkerManager( map );
 
   google.maps.event.addListener(mgr, 'loaded', function() {
      if (markers) {
         for (var level in markers) {
            for (var i = 0; i < markers[level].length; i++) {
               var details = markers[level][i];
               var image = new google.maps.MarkerImage(details.icons,new google.maps.Size(PIN_POINT_ICON_WIDTH, PIN_POINT_ICON_HEIGHT));
               var myLatLng = new google.maps.LatLng(details.location[0], details.location[1]);
			     <?php if(get_current_city_set_zooming_opt() == '1') { ?>
			     multimarkerdata[i]  = new google.maps.LatLng(details.location[0], details.location[1]);
			   <?php } ?>
               markers[level][i] = new google.maps.Marker({
                  title: details.name,
                  position: myLatLng,
                  icon: image,
                  clickable: true,
                  draggable: false,
                  flat: true
               });
               attachSecretMessage(markers[level][i], details.message);

               var pinpointElement = document.getElementById( 'pinpoint_'+details.pid );
               if ( pinpointElement ) {
                  google.maps.event.addDomListener( pinpointElement, 'click', (function( theMarker ) {
                     return function() {
                        google.maps.event.trigger( theMarker, 'click' );
                     };
                  })(markers[level][i]) );
               }
            }
            mgr.addMarkers( markers[level], 0 );
         }
		<?php if(get_current_city_set_zooming_opt() == '1') { ?>
			 var latlngbounds = new google.maps.LatLngBounds();

			for ( var j = 0; j < multimarkerdata.length; j++ )
			    {
				 latlngbounds.extend( multimarkerdata[ j ] );
			    }
			   map.fitBounds( latlngbounds );
		  <?php } ?>
         mgr.refresh();
      }
   });
	
	// but that message is not within the marker's instance data
	function attachSecretMessage(marker, msg) {
		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.setContent( msg );
         infoWindow.open(map,this);
      });
	}
}
google.maps.event.addDomListener(window, 'load', initialize);
/* ]]> */
</script>
<div class="sidebar_map"><div id="map_canvas" style="width: <?php echo $width;?>px; height:<?php echo $heigh;?>px"></div></div>
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['heigh'] = ($new_instance['heigh']);

		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'width' => '', 'heigh' => '') );		
		$width = strip_tags($instance['width']);
		$heigh = strip_tags($instance['heigh']);
	?>
    <p>
      <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Map Width <small>(Default is : 294px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" />
      </label>
    </p>
     <p>
      <label for="<?php echo $this->get_field_id('heigh'); ?>"><?php _e('Map Heigh <small>(Default is : 370px)</small>');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('heigh'); ?>" name="<?php echo $this->get_field_name('heigh'); ?>" type="text" value="<?php echo attribute_escape($heigh); ?>" />
      </label>
    </p>
    <?php
	}}
}	
register_widget('googlemmap_listingpage');

?>