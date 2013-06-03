<?php
global $wpdb,$price_db_table_name;
if($_POST['priceact'] == 'addprice')
{
	$id = $_POST['price_id'];
	$price_title = $_POST['price_title'];
	$price_desc = $_POST['price_desc'];
	$price_post_type1 = $_POST['post_type'];
	if( $price_post_type1 != "")
	{
	$ptype = explode(',',$price_post_type1);
	for($p =0; $p<=count($ptype); $p++){
	$price_post_type= $ptype[0];
	}	}
	$package_cost = $_POST['amount'];
	$validity = $_POST['validity'];
	$validity_per = $_POST['validity_per'];
	$is_recurring = $_POST['recurring'];
	$billing_num = $_POST['billing_num'];
	$billing_per = $_POST['billing_per'];
	$status = $_POST['status'];
	$cat = $_POST['category'];
	$is_show = $_POST['is_show'];
	$billing_cycle = $_POST['billing_cycle'];
	if($cat){
		$price_post_cat = implode(",",$cat);
		if($_POST['selectall'] !=''){
			$price_post_cat = $price_post_cat.",all";
		}
	}
	$is_featured = $_POST['is_featured'];
	$feature_amount = $_POST['feature_amount'];
	$feature_cat_amount = $_POST['feature_cat_amount'];

	if($id)	{
		$wpdb->query("update $price_db_table_name set price_title=\"$price_title\", price_desc=\"$price_desc\", price_post_cat=\"$price_post_cat\", is_show=\"$is_show\", price_post_type=\"$price_post_type\",package_cost=\"$package_cost\",validity=\"$validity\",validity_per=\"$validity_per\",is_recurring=\"$is_recurring\",billing_num=\"$billing_num\",billing_per=\"$billing_per\",billing_cycle=\"$billing_cycle\",status=\"$status\",is_featured=\"$is_featured\",feature_amount=\"$feature_amount\",feature_cat_amount=\"$feature_cat_amount\" where pid=\"$id\"");
		$msgtype = 'edit_price';
	}else	{
		$insertprice = "insert into $price_db_table_name (price_title,price_desc,price_post_cat,is_show,price_post_type,package_cost,validity,validity_per,is_recurring,billing_num,billing_per,billing_cycle,status,is_featured,feature_amount,feature_cat_amount) values ('".$price_title."','".$price_desc."','".$price_post_cat."','".$is_show."','".$price_post_type."','".$package_cost."','".$validity."','".$validity_per."','".$is_recurring."','".$billing_num."','".$billing_per."','".$billing_cycle."','".$status."','".$is_featured."','".$feature_amount."','".$feature_cat_amount."')";
		$wpdb->query($insertprice);
		$msgtype = 'add_price';
	}
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_price" method=get name="price_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="pricesuccess"><input type=hidden name="msgtype" value="'.$msgtype.'"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;

}
if($_REQUEST['price_id']!='')
{
	$pid = $_REQUEST['price_id'];
	$pricesql = "select * from $price_db_table_name where pid=\"$pid\"";
	$addpriceinfo = $wpdb->get_results($pricesql);
	$price_title = 'Edit price';
	$price_msg = PRICE_EDIT_MOD_TITLE;
} else {
	$price_title = PRICE_MOD_TITLE;
	$price_msg = PRICE_MOD_MSG;
}
?>
<!-- Function to fetch categories -->
<script>
function showcat1(str)
{  	
	if (str=="")
	  {
	  document.getElementById("field_category").innerHTML="";
	  return;
	  }else{
	  document.getElementById("field_category").innerHTML="";
	  document.getElementById("process").style.display ="block";
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
		document.getElementById("process").style.display ="none";
		document.getElementById("field_category").innerHTML=xmlhttp.responseText;
		}
	  } 
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_price_taxonomy.php?post_type="+str
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
} 
</script>
<form action="<?php echo home_url()?>/wp-admin/admin.php?page=manage_settings&mod=price&pagetype=addedit" method="post" name="price_frm">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" onclick="return price_validation();" class="button-framework-imp right position_top" />
<h4><?php _e($price_title,'templatic');?> 

<a href="<?php echo home_url();?>/wp-admin/admin.php?page=manage_settings#option_display_price" name="btnviewlisting" class="l_back" title="<?php _e('Back to manage price list','templatic');?>"/><?php _e(PRICE_BACK_LABLE,'templatic'); ?></a>
</h4>
 <p class="notes_spec"><?php _e($price_msg,'templatic');?></p>
<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e(PRICE_SETTING_TITLE,'templatic'); ?></b></p>

  <input type="hidden" name="priceact" value="addprice">
  <input type="hidden" name="price_id" value="<?php echo $_REQUEST['price_id'];?>">
  
  <div class="option option-select"  >
    <h3><?php _e(PRICE_PACK_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="price_title" id="title" value="<?php echo $addpriceinfo[0]->price_title;?>">
   		</div>
      <div class="description"><?php _e(PRICE_TITLE_NOTE,'templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e(PRICE_DESC_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element">
         <textarea name="price_desc" cols="40" rows="5" id="title_desc"><?php echo stripslashes($addpriceinfo[0]->price_desc);?></textarea>
   		</div>
      <div class="description"><?php _e(PRICE_DESC_NOTE,'templatic');?></div>
    </div>
  </div> <!-- #end -->
  <div  class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e(PRICE_POST_TYPE_LABLE,'templatic');?>:</h3>
    <div class="section">
      <div class="element">
	  <?php
				$custom_post_types_args = array();  
                $custom_post_types = get_post_types($custom_post_types_args,'objects'); ?>
                 <select name="post_type" id="post_type"  onChange="showcat1(this.value)">
				  <?php
					foreach ($custom_post_types as $content_type) {
                    if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page'){
					if( $content_type->label != "Posts"){
                  ?>
                  <option value="<?php echo $content_type->name.",".$content_type->taxonomies[0].",".$post_val->field_category; ?>" <?php if($addpriceinfo[0]->price_post_type==$content_type->name){ echo 'selected="selected"';}?>><?php echo $content_type->label;?></option>
                 <?php }
				 }}?>
					<option value="both" <?php if($addpriceinfo[0]->price_post_type=='both'){ echo 'selected="selected"';}elseif($addpriceinfo[0]->price_post_type == ""){ echo 'selected="selected"'; } ?>><?php _e('Both','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e(PRICE_POST_TYPE_NOTE,'templatic');?></div>
	  
    </div>
  </div> <!-- #end -->

 <div class="option option-select">
    <h3><?php _e(PRICE_CAT_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element" id="field_category" style="height:100px; overflow-y:scroll;">
		<?php 
		$pctype = $addpriceinfo[0]->price_post_type;
		if($pctype == "both")
		{
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE1,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod'],'select_all'); 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE2,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod']); 
		}elseif($pctype == CUSTOM_POST_TYPE1){ 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE1,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod'],'select_all'); 
		}elseif($pctype == CUSTOM_POST_TYPE2){
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE2,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod'],'select_all');
		}else{ 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE1,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod'],'select_all'); 
			get_wp_category_checklist(CUSTOM_CATEGORY_TYPE2,$addpriceinfo[0]->price_post_cat,$_REQUEST['mod']); 
		}
		?>
      </div><span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
      <div class="description"><?php _e(PRICE_POST_CAT_NOTE,'templatic');?></div>
	   <div class="description"><label><input type="checkbox" name="is_show" id="is_show" value="1" <?php if($addpriceinfo[0]->is_show ==1){ echo "checked=checked";} ?>/><?php echo NO_CTA_PKG; ?></label></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e(PRICE_AMOUNT_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element">
          <input type="text" name="amount" value="<?php echo $addpriceinfo[0]->package_cost;?>">
   		</div>
      <div class="description"><?php _e(PRICE_AMOUNT_NOTE,'templatic');?> </div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e(VALIDITY_TITLE,'templatic');?></h3>
    <?php $vper = $addpriceinfo[0]->validity_per;
			if($vper == "D")
			{	$selected_d =  'selected=selected';
			
			}else if($vper == "M"){ $selected_m =  'selected=selected';
			}else if($vper == "Y"){ $selected_y =  'selected=selected';
			}
			
			?>
    <div class="section">
      <div class="element">
			  <input type="text" class="textfield billing_num" name="validity" id="validity" value="<?php echo $addpriceinfo[0]->validity;?>">
			  <select name="validity_per" id="validity_per" class="textfield billing_per">
			  <option value="D" <?php echo $selected_d; ?> ><?php _e('days','templatic'); ?></option>
			  <option value="M" <?php echo $selected_m; ?> ><?php _e('months','templatic'); ?></option>
			  <option value="Y"  <?php echo $selected_y; ?> ><?php _e('years','templatic'); ?></option>
			  </select>
   		</div>
      <div class="description"><?php _e(VALIDITY_NOTE,'templatic');?></div>
    </div>
  </div> <!-- #end -->
  
   <div class="option option-select"  >
    <h3><?php _e('Status','templatic');?></h3>
    <div class="section">
      <div class="element">
         <select name="status" >
          <option value="1" <?php if($addpriceinfo[0]->status=='1'){ echo 'selected="selected"';}?> ><?php _e("Active",'templatic');?></option>
          <option value="0" <?php if($addpriceinfo[0]->status=='0'){ echo 'selected="selected"';}?> ><?php _e("Inactive",'templatic');?></option>
          </select>
   		</div>
      <div class="description"><?php _e(STATUS_NOTE,'templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e(REC_TITLE,'templatic'); ?></h3>
    <div class="section">
      <div class="element">
		<div class="input_wrap">
		 <select name="recurring" id="recurring" onChange="rec_div_show(this.value)">
          <option value="1" <?php if($addpriceinfo[0]->is_recurring ==1){ echo 'selected=selected';}?> ><?php _e("Yes",'templatic');?></option>
          <option value="0" <?php if($addpriceinfo[0]->is_recurring==0){ echo 'selected=selected';}?> ><?php _e("No",'templatic');?></option>
          </select>
			</div>
   	</div>
      <div class="description"><?php _e(REC_NOTE,'templatic');?></div>
		
    </div>
		
   </div> <!-- #end -->
	<div class="option option-select" id="rec_div" <?php if($addpriceinfo[0]->is_recurring!='1'){ echo "style=display:none"; }?> >
    
	 <div class="section change_user">
			<h4><?php _e(BILLING_PERIOD_TITLE,'templatic'); ?></h4>
			  <span class="option_label"><?php _e(CHARGES_USER,'templatic'); ?> </span>
			  <input type="text" class="textfield billing_num" name="billing_num" id="billing_num" value="<?php echo $addpriceinfo[0]->billing_num; ?>">
			  <select name="billing_per" id="billing_per" class="textfield billing_per">
			  <option value="D" <?php if($addpriceinfo[0]->billing_per =='D'){ echo 'selected=selected';}?> ><?php _e('days','templatic'); ?></option>
			  <option value="M" <?php if($addpriceinfo[0]->billing_per =='M'){ echo 'selected=selected';}?> ><?php _e('months','templatic'); ?></option>
			  <option value="Y" <?php if($addpriceinfo[0]->billing_per =='Y'){ echo 'selected=selected';}?> ><?php _e('years','templatic'); ?></option>
			  </select>
	
			  <div class="description"><?php _e(BILLING_PERIOD_NOTE,'templatic'); ?></div>
	 </div>	
	<div class="section change_user">
			<h4><?php _e(BILLING_CYCLE_TITLE,'templatic'); ?></h4>
			  <input type="text" class="textfield" name="billing_cycle" id="billing_cycle" value="<?php echo $addpriceinfo[0]->billing_cycle; ?>">
			  <div class="description"><?php _e(BILLING_CYCLE_NOTE,'templatic'); ?></div>
	 </div>		 
	</div><!-- #end -->
	<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e(FEATURE_HEAD_TITLE,'templatic'); ?></b></p>
	<p><?php _e(FEATURE_HEAD_NOTE,'templatic'); ?></p><!-- End -->
	
     <div class="option option-select">
		<h3><?php _e('Status','templatic'); ?></h3>
		  <div class="section">
		  <div class="element">
			 <select name="is_featured" id="is_featured">
			  <option value="1"  <?php if($addpriceinfo[0]->is_featured ==1){ echo 'selected=selected';}?> ><?php _e('Active','templatic'); ?></option>
			  <option value="0" <?php if($addpriceinfo[0]->is_featured ==0){ echo 'selected=selected';}?> ><?php _e('Deactive','templatic'); ?></option>
			 
			  </select>
			</div>
		  <div class="description"><?php _e(FEATURE_STATUS_NOTE,'templatic'); ?></div>
		</div>
	</div> <!-- #end -->
	
	<div class="option option-select"  >
    <h3><?php _e(FEATURE_AMOUNT_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="feature_amount" id="feature_amount" value="<?php if($addpriceinfo[0]->feature_amount != "") { echo $addpriceinfo[0]->feature_amount; }else{ echo "0";}?>">
   		</div>
      <div class="description"><?php _e(FEATURE_AMOUNT_NOTE,'templatic');?></div>
    </div>
	</div> <!-- #end -->
	
	<div class="option option-select"  >
    <h3><?php _e(FEATURE_CAT_TITLE,'templatic');?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="feature_cat_amount" id="feature_cat_amount" value="<?php if($addpriceinfo[0]->feature_cat_amount != "") { echo $addpriceinfo[0]->feature_cat_amount; }else{ echo "0"; } ?>">
   		</div>
      <div class="description"><?php _e(FEATURE_CAT_NOTE,'templatic');?></div>
    </div>
	</div> <!-- #end -->
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" onclick="return price_validation();" class="button-framework-imp right position_bottom" />
</form>
