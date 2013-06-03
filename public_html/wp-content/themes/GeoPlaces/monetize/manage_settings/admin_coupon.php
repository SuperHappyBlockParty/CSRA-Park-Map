<?php
global $wpdb;
if($_POST['couponact'] == 'addcoupon')
{
	$couponcode = $_POST['couponcode'];
	$coupondisc = $_POST['coupondisc'];
	$couponamt = $_POST['couponamt'];
	if($couponcode)
	{
		$discount_coupons['couponcode'] = $couponcode;
		$discount_coupons['dis_per'] = $coupondisc;
		$discount_coupons['dis_amt'] = $couponamt;
		
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
			foreach($couponinfo as $couponinfoObj)
			{
				$option_value = json_decode($couponinfoObj->option_value);
			}
			if($_POST['code'] != '')
			{
				$option_value[$_POST['code']]  = $discount_coupons;
			}else
			{
				for($i=0;$i<count($option_value);$i++)
				{
					if($option_value[$i]->couponcode == $couponcode)
					{
						echo $location = home_url()."/wp-admin/admin.php";
						echo '<form action="'.$location.'#option_add_coupon" method=get name="coupon_success">
						<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="exist"></form>';
						echo '<script>document.coupon_success.submit();</script>';
						//wp_redirect($location);
						exit;
					}
				}
				$option_value[count($option_value)]  = $discount_coupons;
			}			
			$option_value_str = json_encode($option_value);
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_name='discount_coupons'";
			$wpdb->query($updatestatus);
			$msg_type = 'update';
		}else		{
			$option_value[] = $discount_coupons;
			$option_value_str = json_encode($option_value);
			$insertcoupon = "insert into $wpdb->options (option_name,option_value) values ('discount_coupons','$option_value_str')";
			$wpdb->query($insertcoupon);
			$msg_type = 'create';
		}
		$location = home_url()."/wp-admin/admin.php";
		echo '<form action="'.$location.'#option_display_coupon" method=get name="coupon_success">
		<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="success"><input type=hidden name="msg_type" value="'.$msg_type.'"></form>';
		echo '<script>document.coupon_success.submit();</script>';
		//wp_redirect($location);
		exit;
	}
}
if($_REQUEST['code']!='')
{
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = json_decode($couponinfoObj->option_value);
		}
		$coupon = $option_value[$_REQUEST['code']];
	}	
	$coupon_title = 'Edit coupon details';
	$coupon_msg = 'Here you can edit coupon details.';
	
} else {
	$coupon_title = 'Add New Coupon';
	$coupon_msg = 'Here you can add a new coupon.';
}
?>

<form action="<?php echo home_url()?>/wp-admin/admin.php?page=manage_settings&mod=coupon&pagetype=addedit&code=<?php echo $_REQUEST['code'];?>" method="post" name="coupon_frm">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_top" onclick="return check_frm();">
<h4><?php _e($coupon_title,'templatic');?><a title="Back to manage coupons" class="l_back" name="btnviewlisting" href="<?php echo home_url()?>/wp-admin/admin.php?page=manage_settings#option_display_coupon"><?php _e('&laquo; Back to manage coupons','templatic'); ?></a></h4>
 <p class="notes_spec"><?php _e($coupon_msg,'templatic');?></p>

	<input type="hidden" name="couponact" value="addcoupon">
	<input type="hidden" name="code" value="<?php echo $_REQUEST['code'];?>">
	<?php if($_REQUEST['msg']=='exist'){?>
		<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
			<?php _e('Coupon code already exists, Please use different one.','templatic');?></p>
		</div>
	<?php }?>
    
    
    <div class="option option-select"  >
    <h3><?php _e('Coupon Code : ','templatic');?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="couponcode" id="couponcode" value="<?php echo $coupon->couponcode;?>">
   		</div>
      <div class="description"><?php _e('Enter Coupon code','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Discount Type : ','templatic');?></h3>
    <div class="section">
      <div class="element">
         <div class="input_wrap"> <input type="radio" id="coupondiscper" name="coupondisc" value="per" <?php if($coupon->dis_per == 'per' || $coupon->dis_per==''){?>checked="checked"<?php }?> /> <?php _e('Percentage','templatic');?>(%) </div>
         
         <div class="input_wrap"> <input type="radio" id="coupondiscamt" name="coupondisc" <?php if($coupon->dis_per == 'amt'){?> checked="checked"<?php }?> value="amt" /> <?php _e('Amount','templatic');?> </div>
   		</div>
      <div class="description"><?php _e('Select Discount Type','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Discount amount : ','templatic');?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="couponamt" id="couponamt" value="<?php echo $coupon->dis_amt; ?>">
   		</div>
      <div class="description"><?php _e('Enter Discount Amount','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_bottom" onclick="return check_coupon_frm();">
</form>
<script>
function check_coupon_frm()
{
	if(document.getElementById('coupondiscper').checked)
	{
		if(document.getElementById('couponamt').value > 100)
		{
			alert("<?php _e('Percentage should be less than or equal to 100','templatic');?>");
			return false;
		}
	}
	if(document.getElementById('couponcode').value=='')
	{
		alert("<?php _e('Please Enter Coupon Code','templatic');?>");
		return false;
	}
	return true;
}
</script>
