<?php ob_start(); ?>
<script>
function fill_state_cmb(str)
{  	
	var w = document.city_frm.country_id.selectedIndex;
   var selected_text = document.city_frm.country_id.options[w].text;
   document.getElementById("country").value = selected_text+",";
	if (str=="")  {
		document.getElementById("zones_id").innerHTML="";
		return;
	}else{
		document.getElementById("zones_id").innerHTML="";
		document.getElementById("stateprocess").style.display ="block";
	}
	if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else {// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("stateprocess").style.display ="none";
		document.getElementById("zones_id1").innerHTML=xmlhttp.responseText;
		}
	} 
	url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_manage_settings.php?country_id="+str
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
} 
</script>

<script>
function fill_city_cmb(str)
{
	var w = document.price_frm.zones_id.selectedIndex;
    var selected_text = document.price_frm.zones_id.options[w].text;
    document.getElementById("state").value = selected_text+",";
}
</script>
<?php
global $wpdb,$multicity_db_table_name,$site_url; 
if($_REQUEST['cityact'] == 'addcity')
{
	$id  = $_REQUEST['city_id'];
	$ptype = $_REQUEST['post_type'];
	$lat = $_REQUEST['latitude'];
	$lng = $_REQUEST['longitude'];
	$scall_factor = $_REQUEST['zooming_factor'];
	$cat  = $_POST['category'];
	$country_id  = $_REQUEST['country_id'];
	$zones_id  = $_REQUEST['zones_id'];
	
	if(function_exists('icl_register_string')){
		$context = get_option('blogname');
		$name = $_REQUEST['cityname'];
		$value = $_REQUEST['cityname'];
		icl_register_string($context,$name,$value);
		$cityname = $_REQUEST['cityname'];
	}else{
		$cityname = $_REQUEST['cityname'];
	}
	$geo_address = $_REQUEST['geo_address'];
	$map_type = $_REQUEST['map_type'];
	$set_zooming_opt = $_REQUEST['set_zooming_opt'];
	$citysql = "select * from $multicity_db_table_name ";
	$cityinfo = $wpdb->get_row($citysql);
	if($cityinfo)
		$default  = "0";
	else
		$default = "1";
	if($cat){
		$categories = implode(',',$cat);
	}
	$is_zoom_home = $_POST['is_zoom_home'];
	if($default){
		//$wpdb->query("update $multicity_db_table_name set is_default='0'");
	}
	if($_POST['city_id'] != '')	{
		$msg_type = 'edit';
		$wpdb->query("update $multicity_db_table_name set country_id=\"$country_id\",zones_id=\"$zones_id\",ptype=\"$ptype\",cityname=\"$cityname\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\",geo_address=\"$geo_address\",set_zooming_opt=\"$set_zooming_opt\",map_type=\"$map_type\" where city_id=\"$id\"");
	}else	{
		$msg_type = 'add';
		$wpdb->query("insert into $multicity_db_table_name (country_id,zones_id,ptype,cityname,lat,lng,scall_factor,categories,is_zoom_home,is_default,geo_address,set_zooming_opt, map_type,sortorder) values (\"$country_id\",\"$zones_id\",\"$ptype\",\"$cityname\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$is_zoom_home\",\"$default\",\"$geo_address\",\"$set_zooming_opt\",\"$map_type\",'')");
	}
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_city" method=get name="city_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="success"><input type=hidden name="msg_type" value="'.$msg_type.'"></form>';
	echo '<script>document.city_success.submit();</script>';
	exit;
}
if($_REQUEST['city_id'] != ''){
	$pid = $_REQUEST['city_id'];
	$citysql = "select * from $multicity_db_table_name where city_id=\"$pid\"";
	$cityinfo = $wpdb->get_row($citysql);
	$city_msg = 'For accurate results, please enter as much information as possible.';
} else {
	$city_msg = 'For accurate results, please enter as much information as possible.';
}	
?>
<h4><?php if($_REQUEST['city_id']){  _e('Edit city details','templatic'); }else { _e('Add a city','templatic'); }?>

<a href="<?php echo home_url();?>/wp-admin/admin.php?page=manage_settings#option_display_city" name="btnviewlisting" class="l_back" title="<?php _e('Back to &lsquo;Manage cities&rsquo; list','templatic');?>"/><?php _e('&laquo; Back to &lsquo;Manage cities&rsquo; list','templatic'); ?></a>
</h4>

<p class="notes_spec"><?php _e($city_msg,'templatic');?></p>


<form action="<?php echo home_url()?>/wp-admin/admin.php?page=manage_settings&mod=city&pagetype=update_city#option_display_city" method="post" name="city_frm" id="city_frm">
  <input type="hidden" name="cityact" value="addcity">
  <input type="hidden" name="city_id" value="<?php echo $_REQUEST['city_id'];?>">
  

  <div class="option option-select"  >
    <h3><?php _e('Select country','templatic');?></h3>
    <div class="section">
      <div class="element">

           <select name="country_id" id="country_id" onchange="fill_state_cmb(this.value);">
		   <?php if($cityinfo->zones_id != "") { ?>
			   <option value="0"><?php _e('Select country','templatic'); ?></option>
		   <?php } else{ ?>
                <option selected="selected" value="0"><?php _e('Select country','templatic'); ?></option>
		   <?php } ?>
		   <?php echo country_cmb($cityinfo->country_id);?></select>
   		</div>
      
    </div>
  </div> <!-- #end -->
  <input type="hidden" name="country" id="country" value="<?php echo fetch_country_name($cityinfo->country_id).","; ?>" />
  <div class="option option-select">
    <h3><?php _e('Select state/region','templatic');?></h3>
    <div class="section">
      <div class="element" id="zones_id1" >
	   <?php if($cityinfo->zones_id != "") { 
			   echo zones_cmb($cityinfo->country_id,$cityinfo->zones_id);
		   } else{ ?>
	       <select name="zones_id" id="zones_id" onchange="fill_city_cmb(this.value);" >
                <option selected="selected" value="0"><?php _e('Select state','templatic'); ?></option>
			</select>
			<?php } ?>
      </div><span id='stateprocess' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
      
    </div>
  </div> <!-- #end -->
  <input type="hidden" name="state" id="state" value="<?php echo fetch_state_name($cityinfo->zones_id).","; ?>">
  <div class="option option-select"  >
    <h3><?php _e('City name','templatic');?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="cityname" id="cityname" value="<?php echo $cityinfo->cityname;?>" /> 
           <input type="hidden" name="geo_address" id="geo_address" value="<?php echo $cityinfo->geo_address;?>" /> 
		   <input type="button" class="b_submit" value="set address on map" onclick="geocode_click();initialize();" />
  
   		</div>
    </div>
  </div> <!-- #end -->
     <div class="option option-select"  >
     		 <div class="section">
      <div class="element">
             <?php include_once(get_template_directory() . "/library/map/city_location_add_map.php");?>
              </div>
             
			   <div class="description"  style="margin-left:153px;"><?php echo GET_MAP_MSG;?></div>
             
              </div></div>
  
  
  
   <div class="option option-select"  >
    <h3><?php _e('City latitude','templatic');?></h3>
    <div class="section">
      <div class="element">
			<label id="lat" style="font-weight:bold;"><?php echo $cityinfo->lat;?></label>
           <input type="hidden" name="latitude" id="latitude" value="<?php echo $cityinfo->lat;?>">
		  
   		</div>
      
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('City longitude','templatic');?></h3>
    <div class="section">
      <div class="element">
			<label id="lng" style="font-weight:bold;"><?php echo $cityinfo->lng;?></label>
           <input type="hidden" name="longitude" id="longitude" value="<?php echo $cityinfo->lng;?>">
   		</div>
      
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Map type','templatic');?></h3>
    <div class="section">
		<div class="element">
			<span id="map_type_txt" style="font-weight:bold;"><?php if($cityinfo->map_type != '') { echo $cityinfo->map_type;} else { echo 'ROADMAP'; }?></span>
			<input type="hidden" name="map_type" id="map_type" value="<?php if($cityinfo->map_type != '') { echo $cityinfo->map_type;} else { echo 'ROADMAP'; }?>">
		</div>
		<div class="description"><?php _e('This is the zoom level of the map with 1 being minimum and 19 being maximum zoom. Recommended level: 13','templatic');?></div>
    </div>
  </div> <!-- #end -->
  <div class="option option-select"  >
    <h3><?php _e('Map scaling factor','templatic');?></h3>
    <div class="section">
		<div class="element">
			<span id="zooming" style="font-weight:bold;"><?php if($cityinfo->scall_factor != '') { echo $cityinfo->scall_factor;} else { echo '13'; }?></span>
			<input type="hidden" name="zooming_factor" id="zooming_factor" value="<?php if($cityinfo->scall_factor != '') { echo $cityinfo->scall_factor;} else { echo '13'; }?>">
		</div>
		<div class="description"><?php _e('This is the zoom level of the map with 1 being minimum and 19 being maximum zoom. Recommended level: 13','templatic');?></div>
    </div>
  </div> <!-- #end -->
  <div class="option option-select"  >
    <h3><?php _e('Map display','templatic');?></h3>
    <div class="section">
      <div class="element">
         <div class="input_wrap"> <input type="radio" id="set_zooming_opt" name="set_zooming_opt" value="0" <?php if($cityinfo->set_zooming_opt == '0' || $cityinfo->set_zooming_opt == ''){?>checked="checked"<?php }?> /> <?php _e('As per zoom level','templatic');?></div>
         
         <div class="input_wrap"> <input type="radio" id="set_zooming_opt" name="set_zooming_opt" <?php if($cityinfo->set_zooming_opt == '1'){?> checked="checked"<?php }?> value="1" /> <?php _e('Fit all available listings','templatic');?> </div>
   		</div>
      <div class="description">&nbsp;</div>
    </div>
  </div> <!-- #end -->
  <div class="option option-select"  >
    <h3><?php _e('Select categories to display on homepage','templatic');?></h3>
    <div class="section">
      <!--<div class="element">
           <?php
		   if($cityinfo->categories)
		   {
				$catarr = explode(',',$cityinfo->categories);   
		   }
		   
		  ?>
		  <select name="cat[]" multiple="multiple" style="height: 100px;" id="field_cat">
		  <?php 
		  _e(display_wpcategories_options('1',''),'templatic') ; 
		  ?>
		  </select><span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
   		</div>--> <div class="element" id="field_category" style="height:100px; overflow-y:scroll;">
		<?php 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE1,$cityinfo->categories,'select_all'); 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE2,$cityinfo->categories); 
		?>
      </div><span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
      <div class="description"><?php _e('Selected categories will be displayed in the bottom right corner of this city map on the homepage.<br/><b>Requirements to show categories on the map :</b> <br/>1) &lsquo;Google Map V3 - Home page&rsquo; widget must be enabled.<br/> 2) The category should have at least one place or event within it.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <!--<div class="option option-select"  >
    <h3><?php _e('Map zooming home-page','templatic');?></h3>
    <div class="section">
      <div class="element">
           <select name="is_zoom_home">
          <option value="Yes" <?php if($cityinfo->is_zoom_home=='Yes'){ echo 'selected="selected"';}?>>Yes</option>
          <option value="No" <?php if($cityinfo->is_zoom_home=='No'){ echo 'selected="selected"';}?>>No</option>
          </select>
   		</div>
      <div class="description"><?php _e('Map zooming home-page','templatic');?></div>
    </div>
  </div>--> <!-- #end -->
  
  <!--<div class="option option-select"  >
    <h3><?php _e('Set as default City','templatic');?></h3>
    <div class="section">
      <div class="element">
           <input type="checkbox" name="default" value="1" <?php if($cityinfo->is_default){echo 'checked="checked"';}?>  />
   		</div>
      <div class="description"><?php _e('Set as default City','templatic');?></div>
    </div>
  </div>--> <!-- #end -->
  
  	<input type="submit" name="submit" value="<?php _e('Save All Changes','templatic');?>" onclick="return city_validation();" class="button-framework-imp right position_bottom"  >
</form>