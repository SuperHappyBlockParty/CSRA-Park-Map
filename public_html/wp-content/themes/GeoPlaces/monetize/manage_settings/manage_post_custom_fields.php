<?php
//Custom Settings
if(!function_exists('templ_get_post_custom_fields_array')){
function templ_get_post_custom_fields_array()
{
	$pt_metaboxes = array();
	return apply_filters('templ_admin_post_custom_fields_filter',$pt_metaboxes);
}
}
global $post;

if(!function_exists('ptthemes_meta_box_content')){
function ptthemes_meta_box_content($post, $metabox ) {
    global $post,$wpdb;
	$city_id = get_post_meta($post->ID,'post_city_id',true);
	$pt_metaboxes = get_post_custom_fields_templ($metabox['args']['post_types'],'admin','admin_side','');
    $output = '';
    if($pt_metaboxes){
	if(get_post_meta($post->ID,'remote_ip',true)  != ""){
		$remote_ip = get_post_meta($post->ID,'remote_ip',true);
	} else {
		$remote_ip= getenv("REMOTE_ADDR");
	}
	if(get_post_meta($post->ID,'ip_status',true)  != ""){
		$ip_status = get_post_meta($post->ID,'ip_status',true);
	} else {
		$ip_status= '0';
	}
	$geo_latitude= get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude= get_post_meta($post->ID,'geo_longitude',true);
	$zooming_factor= get_post_meta($post->ID,'zooming_factor',true);
	$multicity_table = $wpdb->prefix."multicity";
	$multicity_id = $wpdb->get_results("select * from $multicity_table");

	$output1 = "Enter City ID. In case of Multi city settings, The posts will display as per City ID.<br/>
<strong>The city Id Information as per theme design settings : </strong> ";
	foreach($multicity_id as $mid){
		$output1 .= "<strong>".$mid->cityname." - ".$mid->city_id.", </strong>";
	}
   echo '<div class="pt_metaboxes_table">'."\n";
   echo '<script>var rootfolderpath = "'.get_template_directory_uri().'/images/";</script>'."\n";
   echo '<script type="text/javascript" src="'.get_template_directory_uri().'/js/dhtmlgoodies_calendar.js"></script>'."\n";
   echo ' <link href="'.get_template_directory_uri().'/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />'."\n";
   echo '<input type="hidden" name="templatic_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />
   <input type="hidden" name="remote_ip" value="'.$remote_ip.'" />
    <input type="hidden" name="zooming_factor" id="zooming_factor" value="'.$zooming_factor.'" />
   <input type="hidden" name="ip_status" value="'.$ip_status.'" />';
    echo  "\t".'<div class="row" style="float:none;margin-left:0px;">';
    echo  "\t\t".'<p><label for="country">'.SELECT_CITY_TEXT.'</label></p>'."\n";
    echo  "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$city_id.'" name="post_city_id" id="post_city_id" /></p>'."\n";
    echo  "\t\t".'<p class="note">'.$output1.'</p>'."\n";
    echo  "\t".'</div>'."\n";
                              
   foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'radio' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'texteditor')
            $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
            if (@$pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {
			if($pt_metabox['type'] != 'multicheckbox'){
                $pt_metaboxvalue = $pt_metabox['default']; }
            }
			
            if($pt_metabox['type'] == 'text'){
				if($pt_metabox["name"] == 'geo_latitude' || $pt_metabox["name"] == 'geo_longitude') {
					$extra_script = 'onblur="changeMap();"';
				} else {
					$extra_script = '';
				}
                echo  "\t".'<div class="row" style="float:none;margin-left:0px;">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'" '.$extra_script.'/></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }
            
            elseif ($pt_metabox['type'] == 'textarea'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }
			
			elseif ($pt_metabox['type'] == 'texteditor'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }

            elseif ($pt_metabox['type'] == 'select'){
                            
                echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'"></p>'."\n";
                echo  '<option value="">Select a '.$pt_metabox['label'].'</option>';
                
                $array = $pt_metabox['options'];
                
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
                        echo  '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                echo  '</select><p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
            }
			elseif ($pt_metabox['type'] == 'multicheckbox'){
				
					echo  "\t".'<div class="row">';
					echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						    $checked='';
							if($pt_metaboxvalue != ""){
							$fval_arr = $pt_metaboxvalue;
							if(in_array($option,$fval_arr)){ $checked='checked="checked"';}
							}/* else{
							$fval_arr = $pt_metabox['default'];
							if($fval_arr !=""){
							if(in_array($option,$fval_arr)){$checked = 'checked="checked"';}  }
							} */
							echo  "\t\t".'<div class="multicheckbox"><input type="checkbox" '.$checked.' class="pt_input_radio" value="'.$option.'" name="ptthemes_'. $pt_metabox["name"] .'[]" />  ' . $option .'</div>'."\n";
						}
					}
					echo  '<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
					echo  "\t".'</div>'."\n";
			}
			 elseif ($pt_metabox['type'] == 'date'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><input size="40" class="pt_input_text" type="text" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" /><img src="'.get_template_directory_uri().'/images/cal.gif" class="calendar_img" alt="Calendar"  onclick="displayCalendar(document.post.ptthemes_'.$pt_metabox["name"].',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" /></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }
			elseif ($pt_metabox['type'] == 'radio'){
					echo  "\t".'<div class="row">';
					echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						   
						   $checked='';
						   if($pt_metabox['default'] == $option){$checked = 'checked="checked"';} 
							if(trim($pt_metaboxvalue) == trim($option)){$checked = 'checked="checked"';}
							echo  "\t\t".'<div class="input_radio"><input type="radio" '.$checked.' class="pt_input_radio" value="'.$option.'" name="ptthemes_'. $pt_metabox["name"] .'" />  ' . $option .'</div>'."\n";
						}
					}
					echo  '<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
					echo  "\t".'</div>'."\n";
			}
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == '1') { $checked = 'checked="checked"';} else {$checked='';}
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p class="value"><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" value="1" name="ptthemes_'. $pt_metabox["name"] .'" />'."\n";
                echo  "\t\t".''.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
            }
			 elseif ($pt_metabox['type'] == 'upload'){
               $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
			   if($pt_metaboxvalue!=""):
			   		$up_class="upload ".$pt_metaboxvalue;
			   else:
			    $up_class="upload has-file";
				echo  "\t\t".'<div class="row option option-upload">';
				echo  "\t\t".'<div class="section">';
      			echo  "\t\t".'<div class="element">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  '<input type="file" class="'.$up_class.'"  id="ptthemes_'. $pt_metabox["name"] .'" name="ptthemes_'. $pt_metabox["name"] .'" value="'.$pt_metaboxvalue.'"/>';
				//echo  '<input id="upload_'.$pt_id.'" class="upload_button" type="button" value="Upload" rel="'.$pt_id.'" />';
				echo  '<div class="screenshot" id="ptthemes_'. $pt_metabox["name"] .'_image">';
				 if ( isset( $pt_metaboxvalue ) && $pt_metaboxvalue != '' ) 
				     { 
						$remove = '<a href="javascript:(void);" class="remove">Remove</a>';
						$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $pt_metaboxvalue );
						if ( $image ) 
						{
							echo '<img src="'.$pt_metaboxvalue.'" alt="" />'.$remove.'';
						} 
						else 
						{
							$parts = explode( "/", $pt_metaboxvalue );
							for( $i = 0; $i < sizeof($parts); ++$i ) 
							{
								$title = $parts[$i];
							}
							echo '<div class="no_image"><a href="'.$pt_metaboxvalue.'">'.$title.'</a>'.$remove.'</div>';
						}
					 }
					echo  '<div class="description">'.$pt_metabox['desc'].' </div>';
					echo  '</div></div></div></div>'."\n";
			  endif;		
            }else {
			if($pt_metabox['type'] == 'geo_map'){
			
				$geo_address = get_post_meta($post->ID,'geo_address',true);
                echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="geo_address">'.__('Geo Address','templatic').'</label></p>'."\n";
                echo  "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$geo_address.'" name="ptthemes_geo_address" id="geo_address"/></p>'."\n";
                echo  "\t\t".'<p class="note">'.@$pt_metabox['admin_desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
				
				echo  "\t\t".'<div class="row">';
				include_once(get_template_directory() . "/library/map/location_add_map.php");
				echo  "\t\t".'<p class="note">'.GET_MAP_MSG.'</p>'."\n";
				 echo  "\t".'</div>'."\n";
				
				              
            }
			}
        }
		
	if(get_post_meta($post->ID,'featured_type',true) == "h"){ $checked = "checked=checked"; }
		elseif(get_post_meta($post->ID,'featured_type',true) == "c"){ $checked1 = "checked=checked";  $checked2=''; $checked3='';}
		elseif(get_post_meta($post->ID,'featured_type',true) == "both"){ $checked2 = "checked=checked"; $checked1='';  $checked3='';}
		elseif(get_post_meta($post->ID,'featured_type',true) == "none" || get_post_meta($post->ID,'featured_type',true) == "n"){ $checked3 = "checked=checked"; $checked1=''; $checked2='';  }
		else{
		if(get_post_meta($post->ID,'featured_type',true)=='')
		 {
			$checked3 = "checked=checked"; 
		  }
		$checked1=''; $checked2=''; 
		}

	
	echo "\t".'<div class="row">';
	echo  "\t".'<div><p><label for="map_view">Select feature listing for this post</label></p></div>';
	echo  "\t\t".'<p><input size="100" type="radio" '.$checked.' value="h" name="ptthemes_featured"/>&nbsp; Featured for home page</p>'."\n";
	echo  "\t\t".'<p><input size="100" type="radio"   '.$checked1.' value="c" name="ptthemes_featured"/>&nbsp; Featured for category page</p>'."\n";
	echo  "\t\t".'<p><input size="100" type="radio"   '.$checked2.' value="both" name="ptthemes_featured"/>&nbsp; Both</p>'."\n";
	echo  "\t\t".'<p><input size="100" type="radio"  '.$checked3.' value="none" name="ptthemes_featured" />&nbsp; None of above</p>'."\n";
	echo  "\t".'</div>'."\n";
	echo '</div>'."\n\n";
    }

	$pt_metaaliv = get_post_meta($post->ID,'alive_days',true);
		  echo  "\t".'<div class="row" style="float:none;margin-left:0px;">';
                echo  "\t\t".'<p><label>Alive days :</label></p>'."\n";
                echo  "\t\t".'<p><input size="100" class="pt_input_text" type="text" value="'.$pt_metaaliv.'" name="alive_days" id="alive_days" /></p>'."\n";
                echo  "\t\t".'<p class="note">Enter alive days for this post. eg. 2,3 etc</p>'."\n";
                echo  "\t".'</div>'."\n";
	
	
}
}

if(!function_exists('ptthemes_metabox_insert')){
function ptthemes_metabox_insert($post_id) {
    global $globals,$wpdb;
	// verify nonce
    if (!wp_verify_nonce($_POST['templatic_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
   $pt_metaboxes = get_post_custom_fields_templ($_POST['post_type']);
   $pID = $_POST['post_ID'];
    $counter = 0;
	if($_POST['post_city_id'] != ""){
		update_post_meta($pID ,'post_city_id',$_POST['post_city_id']);
	}else{
		update_post_meta($pID ,'post_city_id','');
	}if($_POST['zooming_factor'] != ""){
		update_post_meta($pID ,'zooming_factor',$_POST['zooming_factor']);
	}else{
		update_post_meta($pID ,'zooming_factor','13');
	}
    
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'radio'  OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'geo_map' OR $pt_metabox['type'] == 'texteditor') // Normal Type Things...
        {
			
            $var = "ptthemes_".$pt_metabox["name"];
			if($pt_metabox['type'] == 'geo_map'){ 
		
				update_post_meta($pID, 'geo_address', $_POST['ptthemes_geo_address']);
				update_post_meta($pID, 'geo_latitude', $_POST['ptthemes_geo_latitude']);
				update_post_meta($pID, 'geo_longitude', $_POST['ptthemes_geo_longitude']);
				
				/* update the event geo_latitude and geo_longitude in postcodes table */
				$postcode=$wpdb->prefix."postcodes";
				$sql="select post_id from $postcode where post_id=".$pID;
				$postid = $wpdb->get_var($sql);		 				
				if($postid=="")
				{
					$sql="insert into $postcode(post_id,post_type,latitude,longitude) values(".$pID.",'".$_POST['post_type']."','". $_POST['ptthemes_geo_latitude']."','". $_POST['ptthemes_geo_longitude']."')";					
					$wpdb->query($sql);	
				}else
				{
					$sql="update $postcode set post_type='".$_POST['post_type']."', latitude='".  $_POST['ptthemes_geo_latitude']."',longitude='".$_POST['ptthemes_geo_longitude']."' where post_id=".$pID;					
					$wpdb->query($sql);
				}
				
				/*Finish the update event geo_latitude and geo_longitude in postcodes table */
			}
			
           // if (isset($_POST[$var])) {            
                if( get_post_meta( $pID, $pt_metabox["name"] ) == "" )
                    add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true))
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "")
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
          // } 
				if( get_post_meta( $pID, 'remote_ip' ) == "" )
                    add_post_meta($pID, 'remote_ip', $_POST['remote_ip'], true );
                elseif($_POST['remote_ip'] != get_post_meta($pID, 'remote_ip', true))
                    update_post_meta($pID, 'remote_ip', $_POST['remote_ip']);
                elseif($_POST['remote_ip'] == "")
                    delete_post_meta($pID, 'remote_ip', get_post_meta($pID, 'remote_ip', true));
				
				if( get_post_meta( $pID, 'ip_status' ) == "" )
                    add_post_meta($pID, 'ip_status', $_POST['ip_status'], true );
                elseif($_POST['ip_status'] != get_post_meta($pID, 'ip_status', true))
                    update_post_meta($pID, 'ip_status', $_POST['ip_status']);
                elseif($_POST['ip_status'] == "")
                    delete_post_meta($pID, 'ip_status', get_post_meta($pID, 'ip_status', true));	
					
				if( !get_post_meta( $pID, 'alive_days' ) ){
                    add_post_meta($pID, 'alive_days', $_POST['alive_days'], true );
                }else{
                    update_post_meta($pID, 'alive_days', $_POST['alive_days']);
				}
              
        } 
    }
}
}


if(!function_exists('ptthemes_meta_box')){
	
	function ptthemes_meta_box() {
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');   
		
		foreach ($custom_post_types as $content_type) 
		{
		
			if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post')
			{
				
				$post_types = $content_type->name;
				//$pt_metaboxes = get_post_custom_fields_templ($post_types,'0','admin_side');
				if ( function_exists('add_meta_box')) {
					apply_filters('templ_admin_post_type_custom_filter',add_meta_box('ptthemes-settings',apply_filters('templ_admin_post_custom_fields_title_filter','Custom Settings'),'ptthemes_meta_box_content',$post_types,'normal','high',array( 'post_types' => $post_types)));
				}
			}
		}
	}
}
add_action('admin_menu', 'ptthemes_meta_box');
add_action('save_post', 'ptthemes_metabox_insert');
?>