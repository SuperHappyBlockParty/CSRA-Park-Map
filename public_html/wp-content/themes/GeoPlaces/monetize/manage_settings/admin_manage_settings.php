<?php
if(isset($_REQUEST['mod']) && $_REQUEST['mod'] != ""){
if($_REQUEST['mod'] == 'bulkupload_export'){
		include_once('export_to_CSV.php');
	}
	}
	?>
<?php
include 'tab_header.php';
?>
<!-- Add /Edit Form For Custom Fields BOF -->
<link rel="stylesheet" href="<?php echo PLUGIN_URL_MANAGE_SETTINGS;?>css/style.css">
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo PLUGIN_URL_MANAGE_SETTINGS;?>js/manage_settings.js"></script>
<script type="text/javascript">
function displaychk_frm(){
	dml = document.forms['city_frm'];
	chk = dml.elements['category[]'];
	len = dml.elements['category[]'].length;
	
	if(document.getElementById('selectall').checked == true) { 
		for (i = 0; i < len; i++)
		chk[i].checked = true ;
	} else { 
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}
function displaychk_custom(){
	dml = document.forms['custom_fields_frm'];
	chk = dml.elements['category[]'];
	len = dml.elements['category[]'].length;
	
	if(document.getElementById('selectall').checked == true) { 
		for (i = 0; i < len; i++)
		chk[i].checked = true ;
	} else { 
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}
function displaychk_price(){
	dml = document.forms['price_frm'];
	chk = dml.elements['category[]'];
	len = dml.elements['category[]'].length;
	
	if(document.getElementById('selectall').checked == true) { 
		for (i = 0; i < len; i++)
		chk[i].checked = true ;
	} else { 
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}
</script>
<div class="block" id="option_emails">
<?php include_once('admin_notification.php');?>
</div>
<div class="block" id="option_display_icons">
<?php include( 'admin_category_icons.php' );  ?>
</div>
<div class="block" id="option_display_custom_fields">
<?php if($_REQUEST['mod'] == 'custom_fields'){
		include_once('admin_manage_custom_fields_edit.php');
	} else {
		include( 'admin_manage_custom_fields_list.php' ); 
	} ?>
</div>
<div class="block" id="option_set_role">
<?php include_once('admin_manage_permission.php');?>
</div>
<div class="block" id="option_display_custom_usermeta">
<?php if($_REQUEST['mod'] == 'user_meta'){
		include_once('admin_custom_usermeta_edit.php');
	} else {
		include( 'admin_custom_usermeta_list.php' ); 
	} ?>
</div>
<div class="block" id="option_display_price">
<?php if($_REQUEST['mod'] == 'price'){
		include_once('admin_price_add.php');
	} else {
		include( 'admin_package_list.php' ); 
	} ?>
</div>
<div class="block" id="option_display_city">	
<?php 

if($_REQUEST['mod'] == 'city'){
		include_once('admin_add_city.php');
	} else {
		include('admin_manage_city.php' ); 
	} ?>
</div>
<div class="block" id="currency_setup">	
	<?php if($_GET['mod']=='currency')
	{
		include_once('admin_currency.php');
	} else {
		include( 'admin_manage_currency.php' ); 
	} ?>
</div>
<div class="block" id="option_display_coupon">
	<?php if($_GET['mod']=='coupon')
	{
		include_once('admin_coupon.php');
	} else {
		include('admin_manage_coupon.php' ); 
	} ?>
</div>
<div class="block" id="option_bulk_upload">	
	<?php include_once('admin_bulk_upload.php');?>
</div>
<div class="block" id="option_payment">	
<?php if($_GET['payact']=='setting' && $_GET['id']!='')
	{
		include_once('admin_paymethods_add.php');
	} else {
		include( 'admin_paymethods_list.php' ); 
	} ?>
</div>

<div class="block" id="option_transaction_settings">	
	<?php include_once('admin_transaction_report.php');?>
</div>
<div class="block" id="option_ip_settings">	
	<?php include_once('admin_ip_settings.php');?>
</div>
<?php include TT_ADMIN_TPL_PATH.'footer.php';?>