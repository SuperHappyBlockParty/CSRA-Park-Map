<?php
include(get_template_directory()."/monetize/custom_post_type/custom_post_type_lang.php");
global $wpdb;

if(isset($_POST['save_icons']) && $_POST['save_icons'] != ""){
if($_POST['save_icons'])
{
	$ptype = explode(',',$_POST['post_type']);
	$my_post_type = $ptype[1];
	if($ptype[1] == "")
	{
	$catinfo = $wpdb->get_col("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'category'");
	}else{
	$catinfo = $wpdb->get_col("SELECT t.*  FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON tt.term_id = t.term_id WHERE tt.taxonomy = '".$my_post_type."'");
	}

	for($i=0;$i<count($catinfo);$i++)
	{
		$post_var = "term_icon".$catinfo[$i];
		$t_price = "cprice_".$catinfo[$i];
		$term_id=$catinfo[$i];
		$cat_icon = $_POST["$post_var"];
		$term_price = $_POST["$t_price"];
		$field_check = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_icon'");
		if('term_icon' != $field_check)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_icon text NOT NULL");
		}
		$field_check2 = $wpdb->get_var("SHOW COLUMNS FROM $wpdb->terms LIKE 'term_price'");
		if('term_price' != $field_check2)	{
			$dbuser_table_alter = $wpdb->query("ALTER TABLE $wpdb->terms ADD term_price varchar(100) NOT NULL");
		}
		
		if($term_price != ""){
		$wpdb->query("update $wpdb->terms set term_price = \"$term_price\"  where term_id=\"$term_id\"");
		}else{
		$wpdb->query("update $wpdb->terms set term_price ='0'  where term_id=\"$term_id\"");
		}
		
		if($cat_icon != ""){ 
		$wpdb->query("update $wpdb->terms set term_icon=\"$cat_icon\" where term_id=\"$term_id\"");
		}
	}
	$location = home_url()."/wp-admin/admin.php";
		echo '<form action="'.$location.'#option_display_icons" method=get name="icon_success">
		<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="icon_success"></form>';
		echo '<script>document.icon_success.submit();</script>';
		exit;
	
}
}
?>
<script type="text/javascript">
function showicon_cat(str)
{  	
	if (str=="")
	  {
	  document.getElementById("categories_icon").innerHTML="";
	  return;
	  }else{
	  document.getElementById("categories_icon").innerHTML="";
	  document.getElementById("iprocess").style.display ="block";
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
		document.getElementById("iprocess").style.display ="none";
		document.getElementById("categories_icon").innerHTML=xmlhttp.responseText;
		}
	  } 
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_custom_taxonomy.php?post_type="+str+"&caticon=1&noheader=1"
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
} 
/*--Insert record--*/

var http = createObject();
var nocache = 0;
function insert(cid) {

document.getElementById('insert_response'+cid).style.display = ""

var cprice= document.getElementById('cprice_'+cid).value;
var term_icon = encodeURI(document.getElementById('term_icon'+cid+'_text').value);

http.open('get', '<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_custom_taxonomy.php?cprice='+cprice+'&mcatid='+cid+'&term_icon=' +term_icon+'&i=1');
http.onreadystatechange = insertReply;
http.send(cprice);
}
function insertReply() {
if(http.readyState == 4){ 
var response = http.responseText;
// else if login is ok show a message: "Site added+ site URL".
document.getElementById('cat_edit_'+response).style.display = 'none';	
document.getElementById('cat_price'+response).style.display = 'none';
document.getElementById('pricecat'+response).style.display = '';
document.getElementById('add_cat'+response).style.display = 'none';
document.getElementById('edit_cat'+response).style.display = '';
document.getElementById('pricecat'+response).innerHTML = document.getElementById('cprice_'+response).value;
document.getElementById('insert_response'+response).style.display = "none";
document.getElementById('insert_response'+cid).innerHTML = "Inserted"
}
}

function show_categories()
{  	
	document.getElementById("category_list_icon").innerHTML="<tr><td colspan=3><img src='<?php echo get_template_directory_uri()."/library/calendar/process.gif"; ?>' alt='Processing....'/></td></tr>";
	  
	if (window.XMLHttpRequest)
	{
	  	xmlhttp=new XMLHttpRequest();
	}
	else
	{
	 	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  	if(xmlhttp == null)
	{
		alert("Your browser not support the AJAX");	
		return;
	}
	
	  
	var url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_category_list.php?noheader=1";
	//xmlhttp.onreadystatechang = handleResponce();

	xmlhttp.onreadystatechange=function()
	{
	   	if(xmlhttp.readyState==4 && xmlhttp.status==200)
	   	{
			document.getElementById("category_list_icon").innerHTML=xmlhttp.responseText;			
		}
	} 
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
} 

</script>

<form action="<?php echo home_url();?>/wp-admin/admin.php?page=manage_settings#option_display_icons" method="post" name="payoptsetting_frm">
 <input type="submit" name="submit" class="button-framework-imp right position_top" value="<?php _e('Save all changes');?>">

<h4><?php echo MANAGE_CAT_SET_TEXT; ?></h4>
<p class="notes_spec"><?php echo CAT_SECTION_TITLE;?></p>

<?php if($_REQUEST['msg'] == 'icon_success'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php _e('Category settings saved successfully.');?>
</div>
<?php }?>
<div class="option option-select">
    <h3><?php _e('Filter by: ','templatic');?></h3>
    <div class="section">
      <div class="element">
	  <?php
				$custom_post_types_args = array();  
                $custom_post_types = get_post_types($custom_post_types_args,'objects');   
				//print_r($custom_post_types);
				$url = str_replace('http://','',get_template_directory_uri());
	  ?>
                 <select name="post_type" id="post_type"  <?php if($post_val->is_delete=='1'){?> disabled="disabled" <?php }?> onChange="showicon_cat(this.value)">
				  <?php
					foreach ($custom_post_types as $content_type) {
                    if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post' && $content_type->name!='option-tree'){
                  ?>
                  <option value="<?php echo $content_type->name.",".$content_type->taxonomies[0].",".$post_val->field_category; ?>" <?php if($post_val->post_type==$content_type->name){ echo 'selected="selected"';}?>><?php echo $content_type->label;?></option>
                 <?php }}?>
                  </select>
      	   </div>
      <div class="description"><?php _e('Select the post-type to show categories associated with that post-type.','templatic');?></div>
    </div>
  </div>
<span id='iprocess' style='display:none;margin-left:150px;'><img src="<?php echo get_template_directory_uri()."/images/loader.gif"; ?>" alt='Filtering results...' /></span>

 <input type="hidden" name="save_icons" value="1">
 <div id="categories_icon">
  <table  style=" width:100%" cellpadding="5" class="widefat post sub_table" id="category_list_icon">
	<script>
	//call after page loaded
	//window.onload = show_categories ; 
	</script> 
  </table>
 </div>
 <input type="submit" name="submit" class="button-framework-imp right position_bottom" value="<?php _e('Save all changes');?>">
</form>