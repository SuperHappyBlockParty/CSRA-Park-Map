<?php
global $wpdb,$multicity_db_table_name;
if($_REQUEST['pagetype'] == 'delete' && $_REQUEST['city_id'] != '') {
	$pid = $_REQUEST['city_id'];
	$wpdb->query("delete from $multicity_db_table_name where city_id=\"$pid\"");
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'" method=get name="price_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;
}
if($_REQUEST['pagetype'] == 'update_city') { 
	$id  = $_POST['city_id'];
	$cityname = $_POST['cityname'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$scall_factor = $_POST['zooming_factor'];
	$cat  = $_POST['cat'];
	$default  = $_POST['default'];
	if($cat){
		$categories = implode(',',$cat);
	}
	$is_zoom_home = $_POST['is_zoom_home'];
	if($default){
		$wpdb->query("update $multicity_db_table_name set is_default='0'");
	}
	if($id)	{
		$wpdb->query("update $multicity_db_table_name set cityname=\"$cityname\", lat=\"$lat\", lng=\"$lng\", scall_factor=\"$scall_factor\",categories=\"$categories\",is_zoom_home=\"$is_zoom_home\",is_default=\"$default\" where city_id=\"$id\"");
	}else	{
		$wpdb->query("insert into $multicity_db_table_name (cityname,lat,lng,scall_factor,categories,is_zoom_home,is_default) values (\"$cityname\",\"$lat\",\"$lng\",\"$scall_factor\",\"$categories\",\"$is_zoom_home\",\"$default\")");
	}
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_city" method=get name="city_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="success"></form>';
	echo '<script>document.city_success.submit();</script>';
	exit;
}
?>

<h4><?php _e('Manage city','templatic');?>
<a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&mod=city#option_display_city';?>" title="<?php _e('Add a new city','templatic');?>" name="btnviewlisting" class="l_add_new" /><?php _e('Add a new city','templatic'); ?></a>
</h4>
<p class="notes_spec"><?php _e('Add, edit and manage city details here. To add a new city, click the &quot;Add a new city&quot; link above. <br/><b>Note:</b> You should select any one city as the default city to show its map on the homepage.','templatic');?></p>


<?php if($_REQUEST['msg']=='success'){?>
<div class="updated fade below-h2" id="message" style="padding:5px;" >
  <?php 
  if($_GET['msg_type'] == 'edit') {
  _e('City updated successfully.','templatic');
  } else {
  _e('City added successfully.','templatic');
  } ?>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php _e('City deleted successfully.','templatic'); ?>
</div>
<?php }?>
<p style="display:none" id="delete"></p>
<script>
function default_city(city)
{
	document.getElementById("defaultcity").value = city;
	if(city == "default_city")
	{
		document.getElementById("default_city_frm").style.display ='';
		var city_id = document.getElementById("is_default").value;
		 url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?city_id="+city+"&cityid="+city_id;
	}
	else if(city == 'splash_city')
	{
		document.getElementById("default_city_frm").style.display ='none';
		 url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?city_id="+city
	
	}	
}

</script>
<?php
if(isset($_REQUEST['submit']) && $_REQUEST['submit'] != '')
{
	global $wpdb,$multicity_db_table_name;
	if($_REQUEST['is_default'] != '')	{
		update_option('splash_page','');
		$wpdb->query("update $multicity_db_table_name set is_default='0'  ");
		$set_city_default = $wpdb->query("update $multicity_db_table_name set is_default='1' where city_id=".$_REQUEST['is_default']." ");
	}
}

?>

<table style="border:0">
<tr>
	<td>
    
    
  <div class="mange_city_check" >  
 <label><input type="radio" name="default_city" id="default_city" <?php if(get_option('splash_page') == "") { ?> checked="checked" <?php } ?> onclick="return default_city(this.value)" value="default_city"/> <?php _e('Display Default City to User','templatic');?> </label>
 </div>

<form method="post" action="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings';?>#option_display_city" <?php if(get_option('splash_page') != "") { ?> style="display:none" <?php } ?> name="default_city_frm" id="default_city_frm">
	<input type="hidden" name="set_default_city_opt" value="1" />
    
     <div class="option option-select" style="padding-bottom:0;" >
    <h3><?php echo SELECT_CITY_TEXT." : "?></h3>
    <div class="section">
      
         <select name="is_default" id="is_default" style="width:200px; float:left; margin-right:10px;">
		<?php $citysql = "select * from $multicity_db_table_name";
$cityinfo = $wpdb->get_results($citysql);
if($cityinfo) {
	foreach($cityinfo as $cityinfoObj)	{?>
		<option  <?php if($cityinfoObj->is_default =='1' ){?> selected="selected" <?php } ?> value="<?php echo $cityinfoObj->city_id;?>" ><?php echo $cityinfoObj->cityname;?></option>
		 <?php } } ?>
		 </select>
         
         
   		 
		
      <div class="description">
	  <p ><?php echo _e('Current default city is: ','templatic'); ?><span id='cityprocess' style='display:none;'><?php _e('Saving changes...','templatic'); ?>&nbsp;<img style="position:absolute;" src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='<?php _e('Saving changes...','templatic'); ?>' /></span><strong id="set_default_city"><?php if($cityinfo) {
	foreach($cityinfo as $cityinfoObj)	{ if($cityinfoObj->is_default =='1' ){?><?php echo $cityinfoObj->cityname;?> <?php } } } ?></strong></p>
    </div>
	</div>
  </div> <!-- #end -->
</form> 
</td>
</tr>
<tr>
<td>
<div class="mange_city_check" >  
 <label> <input type="radio" name="default_city" id="default_city" <?php if(get_option('splash_page') != "") { ?> checked="checked" <?php } ?> onclick="return default_city(this.value)" value="splash_city" /> <?php _e('Show a splash page to let user select a city when they land on your website','templatic');?> </label><span id='cityprocess1' style='display:none;'>&nbsp;<img style="position:absolute;" src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='<?php _e('Saving changes...','templatic'); ?>' /></span>
 <input type="hidden" name="defaultcity" id="defaultcity" <?php if(get_option('splash_page') == "") { ?>value="default_city" <?php } else { ?> value="splash_page" <?php } ?> />
</div> 

</td>
</tr>
</table>
<div id="city">

<table style=" width:100%"  cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
		<th align="left"><?php _e('ID','templatic'); ?></th>
		<th align="left"><?php _e('City','templatic'); ?></th>
		<th align="left"><?php _e('Country','templatic'); ?></th>
		<th align="left"><?php _e('State','templatic'); ?></th>
		<th align="left"><?php _e('Scaling Factor','templatic'); ?></th>
		<th align="left"><?php _e('Action','templatic'); ?></th>
    </tr>
<?php
$citysql = "select * from $multicity_db_table_name";
$targetpage = home_url('/wp-admin/admin.php?page=manage_settings');
$recordsperpage = 15;
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$recordsperpage;
$endlimit = $recordsperpage;
$orderby =" order by city_id desc limit $strtlimit,$endlimit";
$total_pages = $wpdb->get_var("select count(city_id) from $multicity_db_table_name");

$cityinfo = $wpdb->get_results($citysql.$orderby);
if($cityinfo) {
	foreach($cityinfo as $cityinfoObj)	{ ?>
    <tr>
		<td><?php echo $cityinfoObj->city_id;?></td>
		<td><?php 
		if(function_exists('icl_t')){
			$context = get_option('blogname');
			echo icl_t($context,$cityinfoObj->cityname,$cityinfoObj->cityname);
		}else{
			echo $cityinfoObj->cityname; } ?></td>
		<td><?php echo fecth_country_name($cityinfoObj->country_id);?></td>
		<td><?php echo fecth_zone_name($cityinfoObj->zones_id);?></td> 
		<td><?php echo $cityinfoObj->scall_factor;?></td>
		<td><a href="javascript:void(0);showcitydetail('<?php echo $cityinfoObj->city_id;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; <a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&mod=city&city_id='.$cityinfoObj->city_id;?>#option_display_city" title="<?php _e('Edit City','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit City','templatic');?>" border="0" /></a> &nbsp;&nbsp;<a href="javascript:void(0);" title="<?php _e('Delete City','templatic');?>" onclick="return confirmDelete(<?php echo $cityinfoObj->city_id;?>);"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete City','templatic');?>" border="0" /></a></td>
    </tr>
	<tr id="citydetail_<?php echo $cityinfoObj->city_id;?>" style="display:none;">
		<td colspan="6">
			<table style="background:#eee;" width="100%">
				<tr>
					<td><?php _e('City name','templatic')?> : <strong><?php echo $cityinfoObj->cityname;?></strong></td>
					<td><?php _e('Country','templatic')?> : <strong><?php echo fecth_country_name($cityinfoObj->country_id);?></strong></td>
					<td><?php _e('State','templatic')?> : <strong><?php echo fecth_zone_name($cityinfoObj->zones_id);?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Latitude','templatic')?> : <strong><?php echo $cityinfoObj->lat;?></strong></td>
					<td colspan="2"><?php _e('Longitude','templatic')?> : <strong><?php echo $cityinfoObj->lng;?></strong></td>
				</tr>
				<tr>    
					<td><?php _e('Scaling Factor','templatic')?> : <strong><?php echo $cityinfoObj->scall_factor;?></strong></td>
					<td colspan="2"><?php _e('Categories','templatic')?> : <strong>
					<?php 
				if($cityinfoObj->categories != "")
				{
				
				$pcat = explode(',',$cityinfoObj->categories);
				$pc = count($pcat);
				$catque ="";
				for($c =0 ; $c <= count($pcat); $c ++)
				{
					$catq = $wpdb->get_row("select * from $wpdb->terms where term_id = '".$pcat[$c]."'");
					
					if($catq->name != "" && $c != ($pc-1)){ $catque .= $catq->name." , "; }else{
							$catque .= $catq->name;
					}					
				}echo $catque;
				
				} ?></strong></td>
				</tr>
				
				
			</table>
		</td>
    </tr>
    <?php
	}
}
?>
	</thead>
</table>

<?php
			if($total_pages>$recordsperpage)
			{
			echo wp_get_pagination($targetpage,$total_pages,$recordsperpage,$pagination,'#option_display_city');
			}
?>
</div>


<div class="legend_section">

<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit city','templatic');?>" border="0" />  <?php _e('Edit city','templatic');?> </li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete city','templatic');?>" border="0" /></label> <?php _e('Delete city','templatic');?></li>
</ul>
<input type="submit" style="float:right;" name="submit" onclick="return setDefaultCity();" value="<?php _e('Save all changes','templatic'); ?>" class="button-framework-imp" />
</div>
<script type="text/javascript">
function showcitydetail(city_id)
{
	if(document.getElementById('citydetail_'+city_id).style.display=='none')
	{
		document.getElementById('citydetail_'+city_id).style.display='';
	}else
	{
		document.getElementById('citydetail_'+city_id).style.display='none';	
	}
}
function setDefaultCity()
{
	var city = document.getElementById("defaultcity").value;
	if(city == "default_city")
	{
		document.getElementById("default_city_frm").style.display ='';
		var city_id = document.getElementById("is_default").value;
		document.getElementById("cityprocess").style.display = '';
		url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?city_id="+city+"&city="+city_id;
	}
	else if(city == 'splash_city')
	{
		document.getElementById("default_city_frm").style.display ='none';
		document.getElementById("cityprocess1").style.display = '';
		url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?city_id="+city
	
	}
	
		
	document.getElementById("set_default_city").innerHTML = '';
	 if (city_id=="")
	  {
	  document.getElementById("set_default_city").innerHTML="";
	  return;
	  }
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(document.getElementById("cityprocess"))
				document.getElementById("cityprocess").style.display = 'none';
			if(document.getElementById("cityprocess1"))
				document.getElementById("cityprocess1").style.display = 'none';
			document.getElementById("set_default_city").innerHTML=xmlhttp.responseText;
		}
	  }
	 
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
}
function confirmDelete(cityid)
{

	if(confirm("Are you sure you want to delete?"))
	{
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("delete").style.display = '';
		document.getElementById("city").innerHTML=xmlhttp.responseText;
	
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?cityid="+cityid;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	}

}

</script>