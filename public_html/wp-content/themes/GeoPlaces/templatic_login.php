<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?php esc_html_e( 'GeoPlaces Updates' ); ?></title>
		<?php
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_style( 'jquery-tools', get_template_directory_uri( '/css/tabs.css', __FILE__ ) );
			wp_admin_css( 'global' );
			wp_admin_css( 'admin' );
			wp_admin_css();
			wp_admin_css( 'colors' );
			do_action('admin_print_styles');
			do_action('admin_print_scripts');
			do_action('admin_head');
			?>
	</head>
     <?php
	 session_start();
	 error_reporting(0);
	/*
	 * Get Theme Version
	 */
	function GeoPlaces_tmpl_get_theme_version () {		
		$theme_name = basename(get_stylesheet_directory());
		$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');			
		return $theme_version = $theme_data['Version'];	
	}

	/* GET REMOTE VERSION */

	function GeoPlaces_tmpl_get_remote_verison(){		
		global $theme_response,$wp_version;			
		$theme_name = basename(get_stylesheet_directory());
		$remote_version = get_option($theme_name."_theme_version");		
		return $remote_version = $remote_version[$theme_name]['new_version'];
	}

	global $current_user;
	$theme_name = basename(get_stylesheet_directory());
	$self_url = add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ), admin_url( 'admin-ajax.php' ) );

	if(isset($_POST['templatic_login']) && isset($_POST['templatic_username']) && $_POST['templatic_username']!=''  && isset($_POST['templatic_password']) && $_POST['templatic_password']!='')
	{ 
		$arg=array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => array( 'username' => $_POST['templatic_username'], 'password' => $_POST['templatic_password']),
			'cookies' => array()
		    );
		$warnning_message='';
		$response = wp_remote_post('http://templatic.com/members/login_api.php',$arg );	
	
		if( is_wp_error( $response ) ) {
		  	$warnning_message="Invalid UserName or password. Are you using templatic member's username and password?";
		} else { 
		  	$data = json_decode($response['body']);
		}
		
		/*Return error message */
		if(isset($data->error_message) && $data->error_message!='')
		{
			$warnning_message=$data->error_message;			
		}
		
		/*Finish error message */
		$data_product = (array)$data->product;
		if(isset($data_product) && is_array($data_product))
		{	
			foreach($data_product as $key=>$val)
			{
				$product[]=$key;
			}			
			if(in_array('Geo Places V4 - developer license',$product) || in_array('Geo Places V4 - standard license',$product))
			{
				$successfull_login=1;				
				$_SESSION['success_user_login'] = 'yes';
				$download_link=$data_product['Geo Places V4 - developer license'];
			}else
			{
				$warnning_message="We don't find GeoPlaces in your templatic account, you will not be able to update without a license";
			}			
		}
	}else{
		if(isset($_POST['templatic_login']) && ($_POST['templatic_username'] =='' || $_POST['templatic_password']=='')){
		$warnning_message="Invalid UserName or password. Please enter templatic member's username and password."; }
	}
			$theme_version = GeoPlaces_tmpl_get_theme_version();
			$remote_version = GeoPlaces_tmpl_get_remote_verison();
			/* set flag on updates */
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
				$flag =1;
			}else{
				$flag=0;
			}
			$the_name = get_current_theme();
			$session = $_SESSION['success_user_login'];

	?>
          <div class='wrap templatic_login'>
           <?php if($flag ==1){ ?>
			  <div id="update-nag">
			  <p style=" clear:both;"> <?php _e('The new version of '.$the_name.' is available.','supreme'); ?></p>
			  
			  <p><?php _e('You can update to the latest version automatically , or download the latest version of the theme.','supreme'); ?></p>
			  <p><span style="color:red; font-weight:bold;"><?php _e('Warning','supreme'); ?>: </span><?php _e('Updating will undo all your file customizations so make sure to keep backup of all files before updating.','supreme'); ?></p>
			  <a class="button-secondary" href="http://templatic.com/members/mydownloads/GeoPlaces/theme/GeoPlaces.zip" target="blank"><?php _e('Download latest Version','templatic'); ?></a> 
			  
			  </div>
		  <?php } ?>
           <div id='pblogo'>
               <img src="<?php echo esc_url( get_template_directory_uri()."/images/templatic.jpg"); ?>" style="margin-right: 50px;" />
		   </div> 

           <?php
		if(isset($warnning_message) && $warnning_message!='')
		{?>
			<div class='error'><p><strong><?php echo sprintf(__('%s','templatic'), $warnning_message);?></strong></p></div>	
		<?php
          }
		?>
            <?php if($flag ==1){
             if(!isset($successfull_login) && $successfull_login!=1 && !$session):?>
			   
               <p class="info">
			   
			   <?php _e('Enter your templatic login credentials to update your GeoPlaces theme to the latest version.',DOMAIN);?></p>
               <form action="<?php echo site_url()."/wp-admin/admin.php?page=GeoPlaces_tmpl_theme_update";?>" name="" method="post">
                   <table>
					<tr>
					<td><label><?php _e('User Name', DOMAIN)?></label></td>
					<td><input type="text" name="templatic_username"  /></td>
					</tr>
					<tr>
                    <td><label><?php _e('Password', DOMAIN)?></label></td>
					<td><input type="password" name="templatic_password"  /></td>
					</tr>
					<tr>
					<td><input type="submit" name="templatic_login" value="Sign In" class="button-secondary"/></td>
					<td><a title="Close" id="TB_closeWindowButton" href="#" class="button-secondary"><?php _e('Cancel',DOMAIN); ?></a></td>
					</tr>
				</table>
				
               </form>
          <?php else:								
				 $file=$theme_name;
				 $download= wp_nonce_url(admin_url('update.php?action=upgrade-theme&theme=').$file, 'upgrade-theme_' . $file);				
				 echo ' GeoPlaces <a id="TB_closeWindowButton" href="'.$download.'" target="_parent" class="button-secondary">Update Now</a>';
			 endif;
			}?>
          </div>
<?php
	if($flag == 0){
		echo '<h3>'.__('You have the latest version of '.$theme_name,THEME_DOMAIN).' theme.</h3>';
        echo '<p>&rarr;'.sprintf(__('<strong>Your version:</strong> %s',THEME_DOMAIN),$theme_version).'</p>';	
	}

do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
?>
</html>