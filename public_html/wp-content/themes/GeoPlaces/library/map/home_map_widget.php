<?php
function get_category_home()
{
	global $wpdb;
	$blog_cats = get_blog_sub_cats_str('string');
	$map_cat_arr = get_current_city_category();
	$map_cat_ids = trim($map_cat_arr);
	$args =array();
	$catinfo = get_terms(array(CUSTOM_CATEGORY_TYPE1,CUSTOM_CATEGORY_TYPE2),$args);	
	$cat_content_info = array();
	$cat_name_info = array();
	foreach ($catinfo as $catinfo_obj)
	{
		global $wpdb;
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$column_term = $wpdb->get_results("SELECT term_icon FROM $wpdb->terms");
		if(isset($catinfo_obj->term_icon) && $catinfo_obj->term_icon != '' && $column_term !=""){
		$term_icon = $catinfo_obj->term_icon;
		}
		$term_parent = $catinfo_obj->parent;
		if(!isset($term_icon))
		{
			$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
		}
		if($map_cat_ids)
		{
			$map_cat_ids_arr = explode(",",$map_cat_ids);
		}
		else
		{
			$map_cat_ids_arr = array($term_id);
		}
		if(in_array($term_id,$map_cat_ids_arr))
		{
			$content_data = array();
			$my_post_type = "'".CUSTOM_POST_TYPE1."','".CUSTOM_POST_TYPE2."'";
			if($_SESSION['multi_city'])
			{
				$multi_city_id = $_SESSION['multi_city'];	
				$icl_table = $wpdb->prefix."icl_translations";
				if(isset($_COOKIE['_icl_current_language']) && $_COOKIE['_icl_current_language'] !=''){
				$language = ICL_LANGUAGE_CODE;
				}else{ $language=''; }

				$sql = "select p.* from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where p.post_status = 'publish' and p.post_type in ($my_post_type) and ((pm.meta_key='post_city_id') and (pm.meta_value like \"%,$multi_city_id,%\" or pm.meta_value like \"$multi_city_id,%\" or pm.meta_value like \"%,$multi_city_id\" or pm.meta_value = \"$multi_city_id\")) and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" )";
				if(count($wpdb->get_results($sql)) <= 0 && $map_cat_arr){
					$sql = "select p.*,pm.* from $wpdb->posts p , $wpdb->postmeta  pm where pm.post_id=p.ID and p.post_type in ($my_post_type) and p.post_status = 'publish' and ((pm.meta_key='post_city_id') and (pm.meta_value like \"%,$multi_city_id,%\" or pm.meta_value like \"$multi_city_id,%\" or pm.meta_value like \"%,$multi_city_id\" or pm.meta_value = \"$multi_city_id\")) and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" )";
				}
			}else
			{
				$sql = "select * from $wpdb->posts p where p.post_type in ($my_post_type) and p.post_status = 'publish' and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$term_id\" )";
			}
			$postinfo = $wpdb->get_results($sql);
			
			$data_arr = array();
			if($postinfo)
			{
				$srcharr = array("'");
				$replarr = array("\'");
				foreach($postinfo as $postinfo_obj)
				{
					$ID = $postinfo_obj->ID;
					$title = str_replace($srcharr,$replarr,($postinfo_obj->post_title));
					$plink = get_permalink($postinfo_obj->ID);
					$lat = (get_post_meta($ID,'geo_latitude',true));
					$lng = (get_post_meta($ID,'geo_longitude',true));
					$address = str_replace($srcharr,$replarr,(get_post_meta($ID,'geo_address',true)));
					$contact = str_replace($srcharr,$replarr,(get_post_meta($ID,'contact',true)));
					if($postinfo_obj->post_type == CUSTOM_POST_TYPE1) {
						$timing = str_replace($srcharr,$replarr,(get_post_meta($ID,'timing',true)));
					} else {
						$timing = date('M d, Y',strtotime(get_post_meta($ID,'st_date',true))).' to '.date('M d, Y',strtotime(get_post_meta($ID,'end_date',true))).'<br />'.get_post_meta($ID,'st_time',true).' to '.get_post_meta($ID,'end_time',true);
					}
					$pimgarr =  bdw_get_images_with_info($ID,'thumb');				
					$attachment_id = $pimgarr[0]['id'];
					$alt = str_replace($srcharr,$replarr,get_post_meta($attachment_id, '_wp_attachment_image_alt', true));
					$attach_data = get_post($attachment_id);
					if(isset($attach_data) && $attach_data !=''){
						$ititle = str_replace($srcharr,$replarr,$attach_data->post_title);
					}else{
						$ititle='';
					}
					if($ititle ==''){ $ititle = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }
					if($alt ==''){ $alt = str_replace($srcharr,$replarr,$postinfo_obj->post_title); }
	
					$pimg = $pimgarr[0]['file'];
					$thumb = vt_resize($attachment_id,$pimg, 90,75, $crop = true );

					$thumb = $thumb['url'];
					if($thumb ==''){
					$thumb = get_template_directory_uri()."/images/no-image.png";
					}
					if($lat && $lng)
					{
						$retstr ="{";
						$retstr .= "'name':'$title',";
						$retstr .= "'location': [$lat,$lng],";
						$retstr .= "'message':'<img src=\"$thumb\" width=\"90\" height=\"70\" style=\"float:left; margin:0 11px 22px 0;\" alt=\"$alt\" title=\"$ititle\" />";
						$retstr .= "<a href=\"$plink\" class=ptitle>$title</a>";
						if($address){$retstr .= "<br/><span class=ptiming>$address</span>";}
						if($timing){$retstr .= "<br/><span class=pcontact>$timing</span>";}
						if($contact){$retstr .= "<br/><span class=pcontact>$contact</span>";}
						$retstr .= "',";
						$retstr .= "'icons':'$term_icon'";
						$retstr .= "}";
						$content_data[] = $retstr;
					}
				}
				if($content_data)
				{
					$arrsrch = array("'");
					$arrrep = array('');
					$catname = strtolower(str_replace($arrsrch,$arrrep,$name));
					$cat_content_info[]= "'$catname':[".implode(',',$content_data)."]";
					$cat_name_info[] = array($name,$catname,$term_icon,$term_parent);
				}
			}			
		}		
	}
	if($cat_content_info)
	{
		return array($cat_name_info,implode(',',$cat_content_info),$term_parent);
		//return $term_parent;
	}
}

// =============================== Google Map V3 Home page======================================
class googlemmap_homepage extends WP_Widget {
	function googlemmap_homepage() {
	//Constructor
		$widget_ops = array('classname' => 'widget Google Map in Home page', 'description' => __('Google Map in Home page. It will show you google map V3 for Home page with category checkbox selection.','templatic') );		
		$this->WP_Widget('googlemmapwidget_home', __('PT &rarr; Google Map V3 - Home page','templatic'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
	extract($args, EXTR_SKIP);
	$width = empty($instance['width']) ? '940' : apply_filters('widget_width', $instance['width']);
	$heigh = empty($instance['heigh']) ? '425' : apply_filters('widget_heigh', $instance['heigh']);
	$catarr = get_category_home();
	$catname_arr = $catarr[0];
	$catinfo_arr = $catarr[1];

	?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.5&sensor=false"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markermanager.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/map/markerclusterer_packed.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var CITY_MAP_CENTER_LAT= '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG= '<?php echo get_current_city_lng();?>';
var CITY_MAP_ZOOMING_FACT= <?php echo get_current_city_scale_factor();?>;
<?php if(get_current_city_map_type() != '') { 
$maptype = get_current_city_map_type();
} else { 
$maptype = 'ROADMAP';
} ?>
var infowindow;
<?php if(get_current_city_set_zooming_opt() == '1') { ?>
 var multimarkerdata = new Array();
<?php } ?>
/**
 * Data for the markers consisting of a name, a LatLng and a pin image, message box content for
 * the order in which these markers should display on top of each
 * other.
 */
var markers = {<?php echo $catinfo_arr;?>};

var map = null;
var mgr = null;
var mc = null;
var markerClusterer = null;
var showMarketManager = false;

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
	var CITY_MAP_ZOOMING_FACT = 13;
}else if(CITY_MAP_ZOOMING_FACT == '')
{
	var CITY_MAP_ZOOMING_FACT = 3;
} 
var PIN_POINT_ICON_HEIGHT = 32;
var PIN_POINT_ICON_WIDTH = 20;

if(MAP_DISABLE_SCROLL_WHEEL_FLAG)
{
	var MAP_DISABLE_SCROLL_WHEEL_FLAG = 'No';	
}


function setCategoryVisiblity( category, visible ) {
   var i;
   if ( mgr && category in markers ) {
      for( i = 0; i < markers[category].length; i += 1 ) {
         if ( visible ) {
            mgr.addMarker( markers[category][i], 0 );
         } else {
            mgr.removeMarker( markers[category][i], 0 );
         }
      }
      mgr.refresh();
   }
}

function initialize() {
	
  var myOptions = {
    zoom: CITY_MAP_ZOOMING_FACT,
    center: new google.maps.LatLng(CITY_MAP_CENTER_LAT, CITY_MAP_CENTER_LNG),
    mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>
  }
   map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
   mgr = new MarkerManager( map );
   google.maps.event.addListener(mgr, 'loaded', function() {
      if (markers) {
    	 var k = 0;
         for (var level in markers) {
            google.maps.event.addDomListener( document.getElementById( level ), 'click', function() {
               setCategoryVisiblity( this.id, this.checked );
            });
            for (var i = 0; i < markers[level].length; i++) {
		
               var details = markers[level][i];
               var image = new google.maps.MarkerImage(details.icons,new google.maps.Size(PIN_POINT_ICON_WIDTH, PIN_POINT_ICON_HEIGHT));
               var myLatLng = new google.maps.LatLng(details.location[0], details.location[1]);
			   <?php if(get_current_city_set_zooming_opt() == '1') { ?>
			     multimarkerdata[i]  = new google.maps.LatLng(details.location[0], details.location[1]);
				 k++;
			   <?php } ?>
               markers[level][i] = new google.maps.Marker({
                  title: details.name,
                  position: myLatLng,
                  icon: image,
                  clickable: true,
                  draggable: false,
                  flat: true
               });
			  
               
            attachMessage(markers[level][i], details.message);
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
	function attachMessage(marker, msg) {
	  var myEventListener = google.maps.event.addListener(marker, 'click', function() {
		 if (infowindow) infowindow.close();
		infowindow = new google.maps.InfoWindow(
		  { content: String(msg) 
		  });
         infowindow.open(map,marker);
      });
	}
	
}

google.maps.event.addDomListener(window, 'load', initialize);
/* ]]> */
</script>
<div class="top_banner_section_in clearfix">
        <div id="map_canvas" style="width: 100%; height:<?php echo $heigh;?>px" class="map_canvas"></div>
        <?php if($catname_arr){  ?>
        <div class="map_category" id="toggleID">
        <?php for($c=0;$c<count($catname_arr);$c++){ ?>
         <label><input type="checkbox" value="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>" checked="checked" id="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>" name="<?php echo str_replace("&",'&amp;',$catname_arr[$c][1]);?>"><img height="14" width="8" alt="" src="<?php echo $catname_arr[$c][2];?>"> <?php echo $catname_arr[$c][0];?></label>
 
		<?php }?>
        </div>
		<div id="toggle" class="toggleoff" onclick="toggle();"></div>
        <?php }?>
</div>
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
      <label for="<?php echo $this->get_field_id('heigh'); ?>"><?php _e('Map Height <small>(Default is : 425px)</small>','templatic');?>:
      <input class="widefat" id="<?php echo $this->get_field_id('heigh'); ?>" name="<?php echo $this->get_field_name('heigh'); ?>" type="text" value="<?php echo attribute_escape($heigh); ?>" />
      </label>
    </p>
    <?php
	}}
register_widget('googlemmap_homepage');
?>