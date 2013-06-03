<table style=" width:100%" id="city" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
		<th align="left" style="width:20px;"><?php _e('ID','templatic'); ?></th>
		<th align="left"><?php _e('City','templatic'); ?></th>
		<th align="left"><?php _e('Country','templatic'); ?></th>
		<th align="left"><?php _e('State','templatic'); ?></th>
		<th align="left"><?php _e('Scaling Factor','templatic'); ?></th>
		<th align="left"><?php _e('Action','templatic'); ?></th>
    </tr>
<?php
$citysql = "select * from $multicity_db_table_name";
$cityinfo = $wpdb->get_results($citysql);
if($cityinfo) {
	foreach($cityinfo as $cityinfoObj)	{ ?>
    <tr>
		<td><?php echo $cityinfoObj->city_id;?></td>
		<td><?php echo $cityinfoObj->cityname;?></td>
		<td><?php echo fecth_country_name($cityinfoObj->country_id);?></td>
		<td><?php echo fecth_zone_name($cityinfoObj->zones_id);?></td>
		<td><?php echo $cityinfoObj->scall_factor;?></td>
		<td><a href="javascript:void(0);showcitydetail('<?php echo $cityinfoObj->city_id;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; <a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&mod=city&city_id='.$cityinfoObj->city_id;?>#option_display_city" title="<?php _e('Edit City','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit City','templatic');?>" border="0" /></a> &nbsp;&nbsp;<a href="javascript:void(0);" title="<?php _e('Delete City','templatic');?>" onclick="return confirmDelete(<?php echo $cityinfoObj->city_id;?>);"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete City','templatic');?>" border="0" /></a></td>
    </tr>
	<tr id="citydetail_<?php echo $cityinfoObj->city_id;?>" style="display:none;">
		<td colspan="5">
			<table style="background:#eee;" width="100%">
				<tr>
					<td><?php _e('City Name','templatic')?> : <strong><?php echo $cityinfoObj->cityname;?></strong></td>
					<td><?php _e('Country','templatic')?> : <strong><?php echo fecth_country_name($cityinfoObj->country_id);?></strong></td>
					<td><?php _e('Zone','templatic')?> : <strong><?php echo fecth_zone_name($cityinfoObj->zones_id);?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Latitude','templatic')?> : <strong><?php echo $cityinfoObj->lat;?></strong></td>
					<td colspan="2"><?php _e('Longitude','templatic')?> : <strong><?php echo $cityinfoObj->lng;?></strong></td>
				</tr>
				<tr>    
					<td><?php _e('Scaling Factor','templatic')?> : <strong><?php echo $cityinfoObj->scall_factor;?></strong></td>
					<td colspan="2"><?php _e('Zooming Home?','templatic')?> : <strong><?php echo $cityinfoObj->is_zoom_home;?></strong></td>
				</tr>
				<tr>    
					<td colspan="3"><?php _e('Categories ID(s)','templatic')?> : <strong><?php echo $cityinfoObj->categories;?></strong></td>
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