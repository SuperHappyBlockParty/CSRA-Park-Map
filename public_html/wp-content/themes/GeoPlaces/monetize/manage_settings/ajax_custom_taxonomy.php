<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$my_post_type = explode(",",$_REQUEST['post_type']);
echo $catid = $_REQUEST['mcatid'];
$term_icon = $_REQUEST['term_icon'];
$cprice = $_REQUEST['cprice'];
if($_REQUEST['caticon'] == 1)
{  ?>
 <table  style=" width:100%" cellpadding="5" class="widefat post sub_table" >
    <thead>
     <tr>
        <th width="170" align="center"><?php _e('Category','templatic'); ?></th>
        <th width="100" align="center"><?php _e('Price','templatic'); ?></th>
        <th width="120" align="center"><?php _e('Icon','templatic'); ?></th>
        <th><?php _e('Action','templatic'); ?></th>
      </tr>
		<?php 
		if($my_post_type[1] == "")
		{
		$catinfo = $wpdb->get_results("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy ='category'");
		}else{
		$catinfo = $wpdb->get_results("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy ='".$my_post_type[1]."'");
		}
		foreach($catinfo as $catinfo_obj){
		$term_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		$price = $catinfo_obj->term_price;
		if($price == "")
		{
			$price = 0;
		}
		$term_icon = $catinfo_obj->term_icon;
		$path= get_template_directory_uri().'/monetize/upload/index.php?img=term_icon'.$term_id.'&nonce=mktnonce&caticon=1';
		?>
      <tr>
        <td><?php echo $name;?> </td>
		<td><span id="pricecat<?php echo $term_id;?>"><?php echo $price; ?></span><span id="cat_price<?php echo $term_id;?>" style="display:none;"><input type="text" id="cprice_<?php echo $term_id;?>" name="cprice_<?php echo $term_id;?>" value="<?php echo $price; ?>" style="width:30px; display:inline;"/></span><?php echo " ".fetch_currency(get_option('currency_symbol'),'currency_symbol'); ?></td>
        <td ><?php if($term_icon != "") { ?><img id="term_icon<?php echo $term_id;?>_img" src="<?php echo $term_icon;?>" align="middle" height="34px" width="20px"><?php }else{ ?><img id="term_icon<?php echo $term_id;?>_img" src="<?php echo get_template_directory_uri()."/images/default.png"; ?>" align="middle" height="34px" width="20px"><?php } ?>
		<input size="50" type="hidden" value="<?php if($term_icon != "") { echo $term_icon; }else{ echo get_template_directory_uri()."/images/default.png"; }?>" name="term_icon<?php echo $term_id;?>" id="term_icon<?php echo $term_id;?>_text" style="width:260px;">
		<span style="display:none;" id="cat_edit_<?php echo $term_id;?>">
		<iframe name="mktlogoframe" id="upload_target" style="border: none; width:80px; height: 30px; " frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="<?php echo $path; ?>" ></iframe> 
		</span></td>
        <td ><span id="edit_cat<?php echo $term_id;?>"><a href="javascript:void(0);" onClick="edit_cat('<?php echo $term_id;?>','<?php echo $price;?>');" title="Edit settings"><img src="<?php echo get_template_directory_uri()."/images/edit.png"; ?>" alt = "<?php _e('Edit');?>"/></a></span>
		<span id="add_cat<?php echo $term_id;?>" style="display:none;"><a href="javascript:insert(<?php echo $term_id;?>);"title="Save settings"><img src="<?php echo get_template_directory_uri()."/images/save.png"; ?>" alt = "<?php _e('Save');?>"/></a></span>
		<span id="insert_response<?php echo $term_id;?>" style="display:none;"><img src="<?php echo get_template_directory_uri()."/images/loader.gif"; ?>"/></span>
		</td>
      </tr>
<?php }?>
    </thead>
  </table>
<?php }else if($term_icon !="" || $cprice != ""){
$field_check = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_icon'");
		if('term_icon' != $field_check)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_icon text NOT NULL");
		}
		$field_check2 = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_price'");
		if('term_price' != $field_check2)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_price varchar(100) NOT NULL");
		}
$wpdb->query("update $wpdb->terms set term_price = \"$cprice\",term_icon=\"$term_icon\"  where term_id=\"$catid \"");

}else{ 
	$my_post_type = explode(",",$_REQUEST['post_type']);
get_wp_category_checklist($my_post_type[1],'',$_REQUEST['mod'],'select_all');
}
?>
