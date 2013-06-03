<?php
global $wpdb;
$currency_table = $wpdb->prefix . "currency";	
if($_REQUEST['pagetype'] == 'deletecuurency' && $_REQUEST['currency_id'] != '')
{
	$wpdb->query("DELETE from $currency_table where currency_id = '".$_REQUEST['currency_id']."'");
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#currency_setup" method=get name="currency_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="currencymsg" value="delsuccess"></form>';
	echo '<script>document.currency_success.submit();</script>';
	exit;
}
?>
<?php if($_POST['set_default_currency_opt'])	{ ?>
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
	<?php _e('Currency successfully set as default.','templatic'); ?>
	</div>
<?php 

 }	?>
<h4><?php _e('Set default currency','templatic');?></h4>
<?php
	if(isset($_REQUEST['currency_symbol']) && $_REQUEST['currency_symbol'] != '') {
	$set_currency_sql = "select option_value from $wpdb->options where option_name='currency_symbol'";
	$set_currencyinfo = $wpdb->get_row($set_currency_sql);
	if($set_currencyinfo){
		update_option('currency_symbol',$_REQUEST['currency_symbol']);
	} else {	
		$insertcurrency = "insert into $wpdb->options (option_name,option_value) values ('currency_symbol','".$_REQUEST['currency_symbol']."')";
		$wpdb->query($insertcurrency);
	}
	}
 	?>
<form method="post" action="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings';?>#currency_setup" name="default_currency_frm">
	<input type="hidden" name="set_default_currency_opt" value="1" />
    
     <div class="option option-select"  >
    <h3><?php _e('Select Currency : ','templatic');?></h3>
    <div class="section">
      <div class="element">
         <select name="currency_symbol" id="currency_symbol" style="width:200px;"><?php echo currency_cmb(get_option('currency_symbol'));?></select>
   		</div>
      <div class="description"><input type="submit" name="submit" value="<?php _e('Save','templatic'); ?>" class="button-framework-imp" /></div>
    </div>
  </div> <!-- #end -->
    
</form> 

<h4><?php _e('Manage Currency','templatic');?>

<a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&mod=currency#currency_setup';?>" title="<?php _e('Add New Currency','templatic');?>" name="btnviewlisting" class="l_add_new" /><?php _e('Add New Currency','templatic'); ?></a>
</h4>

 <p class="notes_spec"> <?php _e('Here you can edit,delete and manage currency values.','templatic');?></p>

 
<?php if($_REQUEST['currencymsg']=='success'){?>
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
		<?php if($_REQUEST['msgtype'] == 'add'){
				_e('Currency inserted successfully.','templatic');
			} else {
				_e('Currency updated successfully.','templatic');
		}?>
	</div>
	<?php }?>
	<?php if($_REQUEST['currencymsg']=='delsuccess'){?>
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
	  <?php _e('Currency deleted successfully.','templatic'); ?>
	</div>
	<?php
	}
	?>
	<table width="100%" cellpadding="5" class="widefat post fixed" >
		<thead>						
		<tr>
			<th align="left" style="width:20px;"><?php _e('ID','templatic'); ?></th>
			<th align="left"><?php _e('Currency','templatic'); ?></th>
			<th align="left"><?php _e('Code','templatic'); ?></th>
			<th align="left"><?php _e('Symbol','templatic'); ?></th>
			<th align="left" width="50"><?php _e('Action','templatic'); ?></th>						 
		</tr>
		<?php
		$currency_code =  get_option('currency_symbol');
		$currency_table = $wpdb->prefix . "currency";
		$currency_sql = mysql_query("select * from $currency_table");
		while($currency_data = mysql_fetch_array($currency_sql))	{?>
		<tr>
			<td><?php echo $currency_data['currency_id'];?></td>
			<td><?php echo $currency_data['currency_name'];?></td>
			<td><?php echo $currency_data['currency_code'];?></td>
			<td><?php echo $currency_data['currency_symbol'];?></td>
			<td><a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&mod=currency&currency_id='.$currency_data['currency_id'].'#currency_setup';?>" title="<?php _e('Edit Currency','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit Currency','templatic');?>" border="0" /></a>&nbsp;&nbsp;<a href="<?php echo home_url().'/wp-admin/admin.php?page=manage_settings&pagetype=deletecuurency&currency_id='.$currency_data['currency_id'];?>#currency_setup" onclick="return confirmSubmit();" title="<?php _e('Delete Currency','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete Currency','templatic');?>" border="0" /></a></td>
		</tr>
		<?php 	}	?>
	</thead>					
	</table>
	
<div class="legend_section">
<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit Currency','templatic');?>" border="0" /> <?php _e('Edit Currency','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete Currency','templatic');?>" border="0" /> <?php _e('Delete Currency','templatic');?></li>
</ul>
</div>
<script>
function setDefaultCurrency(currency_code)
{
	document.getElementById("currencyprocess").style.display = '';
	document.getElementById("set_default_currency").innerHTML = '';
	 if (currency_code=="")
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
			document.getElementById("currencyprocess").style.display = 'none';
			document.getElementById("set_default_currency").innerHTML=xmlhttp.responseText;
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_set_defalut_city.php?currency_code="+currency_code;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
}
</script>