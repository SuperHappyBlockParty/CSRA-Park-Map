<?php 
if(@$zooming_factor != ''){
	$zooming_factor = $zooming_factor;
} else {
	$zooming_factor = 13;
} ?>

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
if(stripslashes($geo_latitude) && stripslashes($geo_longitude)) {
?>
var CITY_MAP_CENTER_LAT = '<?php echo $geo_latitude;?>';
var CITY_MAP_CENTER_LNG = '<?php echo $geo_longitude;?>';
<?php
$maptype = 'ROADMAP';
} else if($_SESSION['multi_city']) {
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_current_city_lat();?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_current_city_lng();?>';
<?php if(get_current_city_scale_factor() != '') {?>
var CITY_MAP_ZOOMING_FACT='<?php echo get_current_city_scale_factor();?>';
<?php }
if(get_current_city_map_type() != '') { 
$maptype = get_current_city_map_type();
} else { 
$maptype = 'ROADMAP';
} 
}else {
$maptype = 'ROADMAP';
?>
var CITY_MAP_CENTER_LAT = '<?php echo get_option('ptthemes_latitute');?>';
var CITY_MAP_CENTER_LNG = '<?php echo get_option('ptthemes_longitute');?>';
<?php if(get_option('ptthemes_scaling_factor') != '') { ?>
var CITY_MAP_ZOOMING_FACT= '<?php echo get_option('ptthemes_scaling_factor');?>';
<?php }
else { ?>
var CITY_MAP_ZOOMING_FACT=  '13';
<?php }

 }?>

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
      mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    geocoder = new google.maps.Geocoder();
	google.maps.event.addListener(map, 'zoom_changed', function() {
		document.getElementById("zooming_factor").value = map.getZoom();
			
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
			//document.getElementById("zooming_factor").value = map.getZoom();
		});
	}

  function getCenterLatLngText() {
    return '(' + map.getCenter().lat() +', '+ map.getCenter().lng() +')';
  }

  function centerChanged() {
    centerChangedLast = new Date();
    var latlng = getCenterLatLngText();
    //document.getElementById('latlng').innerHTML = latlng;
    document.getElementById('geo_address').value = '';
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
        document.getElementById('geo_address').value = 'None';
      } else {
        document.getElementById('geo_address').value = results[0].formatted_address;
      }
    } else {
      document.getElementById('geo_address').value = 'Error';
    }
  }


  function geocode() {
    var address = document.getElementById("geo_address").value;

    
		
	 if(address) {
	  var address = document.getElementById("geo_address").value;
    geocoder.geocode( { 'address': address}, geocodeResult);
	}
  }

  function geocodeResult(results, status) {
  map.setCenter(results[0].geometry.location);
    if (status == google.maps.GeocoderStatus.OK) {
       map.setCenter(results[0].geometry.location);
	  var marker = new google.maps.Marker({
        position: results[0].geometry.location,
		draggable: true,
        map: map
    });
	  addMarkerAtCenter(marker);
	  
    } else {
      alert("Geocode was not successful for the following reason: " + status);
    }
	
}

  function addMarkerAtCenter(marker) {
	
	
	updateMarkerAddress('Dragging...');
	updateMarkerPosition(marker.getPosition());
	geocodePosition(marker.getPosition());

	google.maps.event.addListener(marker, 'dragstart', function() {
    	updateMarkerAddress('Dragging...');
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
	 //document.getElementById('geo_address').value = str;
   }
   
  function updateMarkerStatus(str)
   {
  	 document.getElementById('markerStatus').innerHTML = str;
   }
   
  function updateMarkerPosition(latLng)
   {
	 document.getElementById('geo_latitude').value = latLng.lat();
	 document.getElementById('geo_longitude').value = latLng.lng();
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
		var newlatlng = document.getElementById('geo_latitude').value;
		var newlong = document.getElementById('geo_longitude').value;
		var latlng = new google.maps.LatLng(newlatlng,newlong);
		var map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: CITY_MAP_ZOOMING_FACT,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.<?php echo $maptype;?>
	  });
	
		var marker = new google.maps.Marker({
		position: latlng,
		title: 'Point A',
		map: map,
		draggable: true
	  });
		
	google.maps.event.addListener(map, 'zoom_changed', function() {
		document.getElementById("zooming_factor").value = map.getZoom();
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
	
google.maps.event.addDomListener(window, 'load', initialize);
<?php if(isset($_REQUEST['pid']) || isset($_REQUEST['post']) || isset($_REQUEST['renew'])):?>
	google.maps.event.addDomListener(window, 'load', changeMap);
<?php else: ?>
	google.maps.event.addDomListener(window, 'load', geocode);
<?php endif; ?>

/* ]]> */
</script>
<input type="button" class="b_submit" value="<?php echo SET_ADDRESS_ON_MAP; ?>" onclick="geocode();initialize();" />
<div id="map_canvas" style="height:350px; position:relative; width:450px;border:1px solid #4d4d4d;"  class="form_row clearfix"></div>