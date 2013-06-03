<?php 
global $wpdb;
$currency_table = $wpdb->prefix . "currency";
/* Update Query BOF */
if(isset($_GET['pagetype']) && $_GET['pagetype'] == 'update_currency'){
	if($_REQUEST['currency_id'] == '') {
		$insert_currency = "insert into $currency_table(currency_id,currency_name,currency_code,currency_symbol,symbol_position) values(null,'".$_POST['currency_name']."','".$_POST['currency_code']."','".$_POST['currency_symbol']."','".$_POST['symbol_position']."')";
		$wpdb->query($insert_currency);
		$msgtype = 'add';
	} else {
		$update_currency = "update $currency_table set currency_name = '".$_POST['currency_name']."',currency_code = '".$_POST['currency_code']."',currency_symbol = '".$_POST['currency_symbol']."',symbol_position = '".$_POST['symbol_position']."' where currency_id = '".$_POST['currency_id']."'" ;
		$wpdb->query($update_currency);
		$msgtype = 'edit';
	}
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#currency_setup" method=get name="currency_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="currencymsg" value="success"><input type=hidden name="msgtype" value="'.$msgtype.'"></form>';
	echo '<script>document.currency_success.submit();</script>';
	exit;
}	
/* Update Query EOF */
if(isset($_REQUEST['currency_id']) && $_REQUEST['currency_id'] != ''){
	$fetch_currency_res = $wpdb->get_row("select * from $currency_table where currency_id = '".$_REQUEST['currency_id']."'");
	$currency_title = 'Edit Currency Detail';
} else {
	$currency_title = 'Add New Currency';
}
?>
 
<form name="frm_settings" id="frm_settings" action="<?php echo home_url()?>/wp-admin/admin.php?page=manage_settings&&mod=currency&pagetype=update_currency" method="post" onsubmit="return currency_validation();">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_top">
<h4><?php _e($currency_title,'templatic');?> 

<a href="<?php echo home_url();?>/wp-admin/admin.php?page=manage_settings#currency_setup" name="btnviewlisting" class="l_back" title="<?php _e('Back to Currency List','templatic');?>"/><?php _e('&laquo; Back to Currency List','templatic'); ?></a>
</h4>
<p class="notes_spec"><?php _e('Give the details about the currency you wish to use.','templatic');?></p>
<input type="hidden" name="currency_id" id="currency_id" value="<?php echo $fetch_currency_res->currency_id;?>">

<div class="option option-select"  >
    <h3><?php _e('Currency Name','templatic');?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="currency_name" id="currency_name" value="<?php echo $fetch_currency_res->currency_name;?>" style="width:200px;">
   		</div>
      <div class="description"><?php _e('Currency Name','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Currency Code','templatic');?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="currency_code" id="currency_code" value="<?php echo $fetch_currency_res->currency_code;?>" style="width:200px;">
   		</div>
      <div class="description"><?php _e('(USD, GBP, etc.)','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Currency Symbol','templatic');?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="currency_symbol" id="currency_symbol" style="width:200px;" value="<?php echo $fetch_currency_res->currency_symbol;?>">
   		</div>
      <div class="description">(<?php _e('$, &euro;, etc.)','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php _e('Currency Symbol Position','templatic');?></h3>
    <div class="section">
      <div class="element">
         <select name="symbol_position" style="width:200px;" id="symbol_position"><?php _e(position_cmb($fetch_currency_res->symbol_position),'templatic');?></select>
   		</div>
      <div class="description"><?php _e('Example','templatic');?> : <span id="ex_position"><?php _e('500','templatic');?></span> </div>
    </div>
  </div> <!-- #end -->
  
  <input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_bottom">
  
</form>