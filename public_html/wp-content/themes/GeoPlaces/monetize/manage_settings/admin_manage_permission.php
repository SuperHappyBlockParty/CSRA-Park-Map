<?php 
if(isset($_REQUEST['peract']) && $_REQUEST['peract'] == 'true'){
	if($_REQUEST['set_permission'] != '') {
		$permission_array = implode(',',$_POST['set_permission']);
		set_option_selling('set_permission',$permission_array);
	} else {
		set_option_selling('set_permission','administrator');
	}
	$location = home_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_set_role" method=get name="per_success">
		<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="per_success"></form>';
		echo '<script>document.per_success.submit();</script>';
		exit;
}
?>
<h4><?php echo MANAGE_PERMISSION_TEXT;?></h4>
<p class="notes_spec"><?php _e('Check mark the group of users to disable their access to the back-end of this site.  <b>Administrators</b> are allowed access at all times.','templatic');?></p>

<?php if($_REQUEST['msg']=='per_success'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
<?php _e('Permissions updated successfully.','templatic'); ?>
</div>
<?php } if($_REQUEST['error_msg']=='per_erromsg'){ ?>
<div class="updated fade below-h2" id="erro_message" style="padding:5px; font-size:11px;" >
<?php _e('Please select atleast one role','templatic'); ?>
</div>
<?php }?>

<form action="<?php echo home_url();?>/wp-admin/admin.php?page=manage_settings#option_set_role" name="manage_permission" method="post">
<input type="submit" name="submit" value="<?php echo SAVE_ALL_CHANGES_TEXT; ?>" class="button-framework-imp position_top">
<input type="hidden" name="peract" value="true" />
<div class="option option-radio">
    <h3><?php echo DISABLE_ACCESS_TEXT; ?></h3>
    
    
    <div class="section">
      <div class="element">
      <?php
		$permission = explode(',',get_option('set_permission'));
		global $wp_roles;
foreach( $wp_roles->role_names as $role => $name ) {
  $name = translate_with_context($name);
  if(in_array($role,$permission)){
	$chck = 'checked';
  } else {
	$chck = '';
  }
   if($role != 'administrator') {
  echo '<div class="input_wrap2 " ><label><input type="checkbox" name="set_permission[]" value="'.$role.'" '.$chck.'>'.$name.'</label></div>';
	}
 }?>
        </div>
      
    </div>
  </div>
<input type="submit" name="submit" value="<?php echo SAVE_ALL_CHANGES_TEXT;?>" class="button-framework-imp position_bottom">
</form>