<?php
$city_id = $_REQUEST['city_id'];
$lat = $cityinfo->lat;
$lng = $cityinfo->lng; 
$zooming_factor = $cityinfo->scall_factor;
if( $cityinfo->map_type != ''){
	$map_type = $cityinfo->map_type;
} elseif($_SESSION['multi_city'] != '') {
	$map_type = get_current_city_map_type();
} else {
	$map_type = 'ROADMAP';
}

if($zooming_factor == ''){
	$zooming_factor = 14;
}?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.5&sensor=false&libraries=places"></script>
<script type="text/javascript">
/* <![CDATA[ */
var map;
var latlng;
var geocoder;
var address;
var lat;
var lng;
var centerChangedLast;
var reverseGeocodedLast;
var currentReverseGeocodeResponse;
<?php

if($city_id)
{
?>
var CITY_MAP_CENTER_LAT = "<?php echo $lat;?>";
var CITY_MAP_CENTER_LNG = "<?php echo $lng;?>";
var CITY_MAP_ZOOMING_FACT= <?php echo $zooming_factor;?>;
<?php
}

elseif($_SESSION['multi_city'])
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_current_city_lng();?>';
<?php if(get_current_city_scale_factor() != '') {?>
var CITY_MAP_ZOOMING_FACT='<?php echo get_current_city_scale_factor();?>';
<?php
	}
}else
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_option('ptthemes_latitute');?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_option('ptthemes_longitute');?>';
<?php if(get_option('ptthemes_scaling_factor') != '') {?>
var CITY_MAP_ZOOMING_FACT= '<?php echo get_option('ptthemes_scaling_factor');?>';
<?php }
}?>
<?php
global $geo_latitude,$geo_longitude;
if(esc_attr(stripslashes($geo_latitude)) && esc_attr(stripslashes($geo_longitude)))
{
?>
var CITY_MAP_CENTER_LAT = '<?php echo $geo_latitude;?>';
var CITY_MAP_CENTER_LNG = '<?php echo $geo_longitude;?>';
<?php
}
?>
if(CITY_MAP_CENTER_LAT=='')
{
	var CITY_MAP_CENTER_LAT = 34;	
}
if(CITY_MAP_CENTER_LNG=='')
{
	var CITY_MAP_CENTER_LNG = 0;	
}
if(CITY_MAP_CENTER_LAT!='' && CITY_MAP_CENTER_LNG!='' && CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 13;
}else if(CITY_MAP_ZOOMING_FACT!='')
{
	var CITY_MAP_ZOOMING_FACT = 3;	
}
 function initialize() {
    var latlng = new google.maps.LatLng(CITY_MAP_CENTER_LAT,CITY_MAP_CENTER_LNG);
    var myOptions = {
      zoom: CITY_MAP_ZOOMING_FACT,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    geocoder = new google.maps.Geocoder();
	google.maps.event.addListener(map, 'zoom_changed', function() { 
		document.getElementById("zooming_factor").value = map.getZoom();
		document.getElementById("zooming").innerHTML = map.getZoom();
			
		});
		google.maps.event.addListener(map, 'maptypeid_changed', function() {
			document.getElementById("map_type").value = (map.getMapTypeId()).toUpperCase();
			document.getElementById("map_type_txt").innerHTML = (map.getMapTypeId()).toUpperCase();
		});
	setupEvents();
   // centerChanged();
  }

  function setupEvents() {
    reverseGeocodedLast = new Date();
    centerChangedLast = new Date();
	
    setInterval(function() {
      if((new Date()).getSeconds() - centerChangedLast.getSeconds() > 1) {
        if(reverseGeocodedLast.getTime() < centerChangedLast.getTime())
          reverseGeocode();
      }
    }, 1000);
google.maps.event.addListener(map, 'zoom_changed', function() {
			document.getElementById("zooming_factor").value = map.getZoom();
			document.getElementById("zooming").innerHTML = map.getZoom();
		});
		google.maps.event.addListener(map, 'maptypeid_changed', function() {
			document.getElementById("map_type").value = (map.getMapTypeId()).toUpperCase();
			document.getElementById("map_type_txt").innerHTML = (map.getMapTypeId()).toUpperCase();
		});
	}

  function getCenterLatLngText() {
    return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
  }

  function centerChanged() {
    centerChangedLast = new Date();
    var latlng = getCenterLatLngText();
    //document.getElementById('latlng').innerHTML = latlng;
    document.getElementById('geo_address').innerHTML = '';
    currentReverseGeocodeResponse = null;
  }

  function reverseGeocode() {
    reverseGeocodedLast = new Date();
    geocoder.geocode({latLng:map.getCenter()},reverseGeocodeResult);
  }

  function reverseGeocodeResult(results, status) {
    currentReverseGeocodeResponse = results;
    if(status == 'OK') {
      if(results.length == 0) {
        document.getElementById('geo_address').innerHTML = 'None';
      } else {
        document.getElementById('geo_address').innerHTML = results[0].formatted_address;
      }
    } else {
      document.getElementById('geo_address').innerHTML = 'Error';
    }
  }


  function geocode() {
       var address = document.getElementById("country").value + document.getElementById("state").value + document.getElementById("cityname").value;
	var cityname = document.getElementById("cityname").value;
    if(address && cityname) {
		geocoder.geocode({
		'address': address,
		'partialmatch': true}, geocodeResult);
	 }
  }

  function geocode_click() {
    var address = document.getElementById("country").value + document.getElementById("state").value + document.getElementById("cityname").value;
	var cityname = document.getElementById("cityname").value;
    if(address && cityname) {
		geocoder.geocode({
		'address': address,
		'partialmatch': true}, geocodeResult);
	 }
  }

  function geocodeResult(results, status) {
    if (status == 'OK' && results.length > 0) {
      map.fitBounds(results[0].geometry.viewport);
	  map.setZoom(<?php echo $zooming_factor;?>);
	  addMarkerAtCenter();	  
    } else {
      alert("Geocode was not successful for the following reason: " + status);
    }
	
}

  function addMarkerAtCenter() {
	var marker = new google.maps.Marker({
        position: map.getCenter(),
		draggable: true,
        map: map
    });
	updateMarkerAddress('Dragging...');
	updateMarkerPosition(marker.getPosition());
	geocodePosition(marker.getPosition());

	google.maps.event.addListener(marker, 'dragstart', function() {
    	//updateMarkerAddress('Dragging...');
    });
	
    google.maps.event.addListener(marker, 'drag', function() {
    	updateMarkerPosition(marker.getPosition());
    });
	
    google.maps.event.addListener(marker, 'dragend', function() {
    	geocodePosition(marker.getPosition());
   });



    var text = 'Lat/Lng: ' + getCenterLatLngText();
    if(currentReverseGeocodeResponse) {
      var addr = '';
      if(currentReverseGeocodeResponse.size == 0) {
        addr = 'None';
      } else {
        addr = currentReverseGeocodeResponse[0].formatted_address;
      }
      text = text + '<br>' + 'address: <br>' + addr;
    }

    var infowindow = new google.maps.InfoWindow({ content: text });

    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
  }
  
  function updateMarkerAddress(str)
   {
	 document.getElementById('geo_address').value = str;
   }
   
  function updateMarkerStatus(str)
   {
  	 document.getElementById('markerStatus').innerHTML = str;
   }
   
  function updateMarkerPosition(latLng)
   {

	 document.getElementById('lat').innerHTML = latLng.lat();
	 document.getElementById('latitude').value = latLng.lat();
	 document.getElementById('lng').innerHTML = latLng.lng();
	 document.getElementById('longitude').value = latLng.lng();
  }
 
	var geocoder = new google.maps.Geocoder();

	function geocodePosition(pos) {
	  geocoder.geocode({
		latLng: pos
	  }, function(responses) {
		if (responses && responses.length > 0) {
			updateMarkerAddress(responses[0].formatted_address);
		} else {
		  updateMarkerAddress('Cannot determine address at this location.');
		}
	  });
	}

	  function changeMap()
   {
		var newlatlng = document.getElementById('latitude').value;
		var newlong = document.getElementById('longitude').value;
		var latlng = new google.maps.LatLng(newlatlng,newlong);
		var map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: CITY_MAP_ZOOMING_FACT,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.<?php echo $map_type;?>
	  });
	
		var marker = new google.maps.Marker({
		position: latlng,
		title: 'Point A',
		map: map,
		draggable: true
	  });
		
	updateMarkerAddress('Dragging...');
	updateMarkerPosition(marker.getPosition());
	geocodePosition(marker.getPosition());

    google.maps.event.addListener(marker, 'dragstart', function() {
    	updateMarkerAddress('Dragging...');
    });
	
    google.maps.event.addListener(marker, 'drag', function() {
    	//updateMarkerStatus('Dragging...');
    	updateMarkerPosition(marker.getPosition());
    });
	
    google.maps.event.addListener(marker, 'dragend', function() {
    	//updateMarkerStatus('Drag ended');
    	geocodePosition(marker.getPosition());
   });
	
   }
<?php if(isset($_REQUEST['city_id'])):?>
	google.maps.event.addDomListener(window, 'load', changeMap);
<?php else: ?>
	google.maps.event.addDomListener(window, 'load', geocode);
<?php endif; ?>
google.maps.event.addDomListener(window, 'load', initialize);


/* ]]> */
</script>

<div class="form_row clearfix">
<div id="map_canvas" style="float:left; height:400px; margin-left:40px; position:relative; width:500px;"  class="form_row clearfix"></div>
</div>