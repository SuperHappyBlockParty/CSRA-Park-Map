<?php
if(!function_exists('show_address_google_map'))
{
    function show_address_google_map($latitute,$longitute,$address,$map_view,$zooming_factor,$width='640',$height='350')
    {
	if($zooming_factor == ''){
		$zooming_factor = 13;	
	}
	if($map_view=='Default Map')
{
	$map_view='ROADMAP';
}elseif($map_view=='Satellite Map')
{
	$map_view='SATELLITE';
}elseif($map_view=='Hybrid Map')
{
	$map_view='TERRAIN';
} else {
	$map_view='ROADMAP';
}
$term_icon = get_bloginfo('template_directory').'/library/map/icons/pin.png';
    ?>
    <script src="http://maps.googleapis.com/maps/api/js?v=3.5&sensor=false" type="text/javascript"></script>
    <script type="text/javascript">
	/* <![CDATA[ */
	function initialize() {	
    var map = null;
    var geocoder = null;
	
    var lat = <?php echo $latitute;?>;
    var lng = <?php echo $longitute;?>;
	var latLng = new google.maps.LatLng(<?php echo $latitute;?>, <?php echo $longitute;?>);
	var myOptions = {
      zoom: <?php echo $zooming_factor;?>,
      mapTypeId: google.maps.MapTypeId.<?php echo $map_view;?>,
      center: latLng 
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
         
    var image = '<?php echo $term_icon;?>';
	var myLatLng = new google.maps.LatLng(<?php echo $latitute;?>, <?php echo $longitute;?>);
	var Marker = new google.maps.Marker({
	  position: latLng,
	  map: map,
	  icon: image
	});
	var content = '<?php echo $address;?>';
	infowindow = new google.maps.InfoWindow({
	  content: content
	});
	
	google.maps.event.addListener(Marker, 'click', function() {
      infowindow.open(map,Marker);
    });

 }
	
	
	

google.maps.event.addDomListener(window, 'load', initialize);
	/* ]]> */
    </script>
    <div id="map_canvas" style="width:100%; height:<?php echo $height;?>px"></div>
    <?php
    }
}
?>