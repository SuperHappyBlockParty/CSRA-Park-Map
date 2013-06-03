<?php
// =============================== Login Widget ======================================
function widget_register_new_user( $user_login, $user_email ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters('user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ,'templatic') );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ,'templatic') );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.','templatic' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ,'templatic') );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ,'templatic') );
		$user_email = '';
	} elseif (email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ,'templatic') );
	}

	//do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ($errors->get_error_code()){
		return $errors;
	}

	if(!empty($errors)){
	$user_pass = wp_generate_password();
	$user_id = wp_create_user($sanitized_user_login, $user_pass, $user_email ); 
	}
	if (!$user_id ) {
		//$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the ' ,'templatic').'<a href="mailto:%s">webmaster</a> !', get_option( 'admin_email' ) ) );
		return $errors;
	}
	
	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.
		

	if($user_id>0)
	{
	global $site_url;
	$creds['user_login'] = $user_login;
	$creds['user_password'] = $user_pass;
	$user = wp_signon($creds, $secure_cookie); 
	//wp_new_user_notification( $user_id, $user_pass );
	wp_redirect($site_url);
	
	$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
		$store_name = get_option('blogname');
		
		$subject = stripslashes(get_option('registration_success_email_subject'));
		$client_message = stripslashes(get_option('registration_success_email_content'));
		if($client_message ==''){
		$client_message = '[SUBJECT-STR]'.__('Registration Email','templatic').'[SUBJECT-END]<p>'.__('Dear','templatic').' [#$user_name#],</p>
		<p>'.__('Your login information:','templatic').'</p>
		<p>'.__('Username:','templatic').' [#$user_login#]</p>
		<p>'.__('Password:','templatic').' [#$user_password#]</p>
		<p>'.__('You can login from','templatic').' [#$store_login_url#] '.__('or the URL is','templatic').' : [#$store_login_url_link#].</p>
		<p>'.__('We hope you enjoy. Thanks!','templatic').'</p>
		<p>[#$store_name#]</p>';
		$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		
		$client_message = $filecontent_arr2[1];
		}
		if($subject == '')
		{
			$subject = __('Registration Email','templatic');
		}
		$store_login = '<a href="'.$site_url.'/?ptype=login">Click Login</a>';
		$store_login_link = $site_url.'/?ptype=login';
		/////////////customer email//////////////
		$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]','[#$store_login_url#]','[#$store_login_url_link#]');
		$replace_array = array($user_login,$user_login,$user_pass,$store_name,$store_login,$store_login_link);
		$client_message = str_replace($search_array,$replace_array,$client_message);	
		sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra=''); //To clidne email
	}
	return $user_id;
}
function widget_retrieve_password() {

	global $wpdb;
	$errors = new WP_Error();
	if ( empty( $_POST['widget_user_rlogin'] ) && empty( $_POST['user_email'] ) )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.','templatic'));

	if ( strpos($_POST['widget_user_rlogin'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['widget_user_rlogin']));
		if ( empty($user_data) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.','templatic'));
	} else {
		$login = trim($_POST['widget_user_rlogin']);
		$user_data = get_userdatabylogin($login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.','templatic'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	////////////////////////////////////
	$user_email = $_POST['widget_user_remail'];
	$user_login = $_POST['widget_user_rlogin'];
	
	$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_login like \"$user_login\" or user_email like \"$user_login\"");
	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key','templatic'));
		
	$new_pass = wp_generate_password(12,false);

	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);
	update_usermeta($user->ID, 'default_password_nag', true); //Set up the Password change nag.
	$message  = '<p><b>'.__('Your login Information :','templatic').'</b></p>';
	$message  .= '<p>'.sprintf(__('Username: ','templatic').'%s', $user->user_login) . "</p>";
	$message .= '<p>'.sprintf(__('Password: ','templatic').'%s', $new_pass) . "</p>";
	$message .= '<p>You can login to : <a href="'.get_option( 'home' ).'/' . "\">Login</a> or the URL is :  ".get_option( 'home' )."/?ptype=login</p>";
	$message .= '<p>Thank You,<br> '.get_option('blogname').'</p>';
	$user_email = $user_data->user_email;
	$user_name = $user_data->user_nicename;
	$fromEmail = get_site_emailId();
	$fromEmailName = get_site_emailName();
	$title = sprintf('[%s]'.__(' Your new password','templatic'), get_option('blogname'));
	$title = apply_filters('password_reset_title', $title);
	$message = apply_filters('password_reset_message', $message, $new_pass);
	$message = stripslashes($message);
	templ_sendEmail($fromEmail,$fromEmailName,$user_email,$user_name,$title,$message,$extra='');///forgot password email
	return true;
}

if(isset($_REQUEST['widgetptype']) == 'login')
{	
	$secure_cookie = '';
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}
	///////////////////////////
	if($_REQUEST['redirect_to']=='')
	{
		$_REQUEST['redirect_to'] = get_author_posts_url($user->ID);
	}
	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	
	if (!is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	
	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress.",'templatic'));

	
			if ( !is_wp_error($user) ) 
			{
				wp_safe_redirect($redirect_to);
				exit();
			}
}
if(isset($_REQUEST['widgetptype']) == 'register')
{
	if ( !get_option('users_can_register') ) {
		$reg_msg = __('User registration is currently not allowed.','templatic');
	}else{
	$user_login = '';
	$user_email = '';
		require_once( ABSPATH . WPINC . '/registration.php');
		$pcd = explode(',',get_option('ptthemes_captcha_dislay'));	
		if((in_array('Add Place/Event submission page',$pcd) || in_array('Both',$pcd)) && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha') ){
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) {
			echo "<script>alert('Invalid recaptcha');</script>";
			exit;
		} 
		}

		$user_login = $_POST['widget_user_rlogin'];
		$user_email = $_POST['widget_user_remail'];
		$errors = widget_register_new_user($user_login, $user_email);
		if ( !is_wp_error($errors) ) {
			$reg_msg = __('Registration complete. Please check your e-mail.','templatic');
		}
		if($errors){
			$errors = $errors;
		}
	}	
}
if(isset($_REQUEST['widgetptype']) && $_REQUEST['widgetptype'] == 'forgetpass')
{
		$errors = widget_retrieve_password();
		if ( !is_wp_error($errors) ) {
			$for_msg = __('Check your e-mail for the new password.','templatic');
		}
}

class loginwidget extends WP_Widget {
	function loginwidget() {
	//Constructor
		$widget_ops = array('classname' => 'Loginbox', 'description' => apply_filters('templ_login_widget_desc_filter',__('Loginbox Widget','templatic')) );		
		$this->WP_Widget('widget_login', apply_filters('templ_login_widget_title_filter',__('T &rarr; Loginbox','templatic')), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			<script  type="text/javascript" >
        function showhide_forgetpw()
        {
			if(document.getElementById('lostpassword_form').style.display=='none')
			{
				document.getElementById('lostpassword_form').style.display = ''
				document.getElementById('register_form').style.display = 'none'
			}else
			{
				document.getElementById('lostpassword_form').style.display = 'none';
				document.getElementById('register_form').style.display = 'none'
			}	
        }
		 function showhide_register()
        {
			if(document.getElementById('register_form').style.display=='none')
			{
				document.getElementById('register_form').style.display = ''
				document.getElementById('lostpassword_form').style.display = 'none'
			}else
			{
				document.getElementById('register_form').style.display = 'none';
				document.getElementById('lostpassword_form').style.display = 'none'
			}	
        }
        </script>
		<?php if($_REQUEST['ptype'] != 'login' && $_REQUEST['ptype'] != 'register'){ ?>
            <div class="widget login_widget" id="login_widget">
          <?php
			global $current_user;
			if($current_user->ID)
			{
			?>
			<h3><?php echo apply_filters('templ_login_widget_myaccount_text_filter',__('Dashboard','templatic'));?></h3>
			<ul class="xoxo blogroll">
            	<?php 
				$authorlink = get_author_posts_url($current_user->ID);
				if(is_plugin_active('wpml-string-translation/plugin.php') && @$_COOKIE['_icl_current_language'] !='en'){
					$language = ICL_LANGUAGE_CODE;
					$site_url = home_url()."/".$language;
				}else{
					$site_url = home_url();
				}
					echo apply_filters('templ_login_widget_dashboardlink_filter','<li><a href="'. get_author_posts_url($current_user->ID).'">'.DASHBOARD_TEXT.'</a></li>');
					echo apply_filters('templ_login_widget_editprofilelink_filter','<li><a href="'.$site_url.'/?ptype=profile'.'">'.EDIT_PROFILE_PAGE_TITLE.'</a></li>');
					echo apply_filters('templ_login_widget_editprofilelink_filter','<li><a href="'.$site_url.'/?ptype=profile'.'">'.CHANGE_PW_TEXT.'</a></li>');
					$user_link = get_author_posts_url($current_user->ID);
					if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
					//echo apply_filters('templ_login_widget_editprofilelink_filter','<li><a href="'.$user_link.'">'.MY_FAVOURITE_TEXT.'</a></li>');
					if(get_option('ptthemes_add_place_nav')=='Yes'){
					echo apply_filters('templ_login_widget_editprofilelink_filter','<li><a href="'.$site_url.'/?ptype=post_listing'.'">'.__('Add place','templatic').'</a></li>');
					}
					if(get_option('ptthemes_add_event_nav')=='Yes'){
					echo apply_filters('templ_login_widget_editprofilelink_filter','<li><a href="'.$site_url.'/?ptype=post_event'.'">'.__('Add Event','templatic').'</a></li>');
					}
					echo apply_filters('templ_login_widget_logoutlink_filter','<li><a href="'.wp_logout_url(get_option('home')."/").'">'.LOGOUT_TEXT.'</a></li>');
				?>
			</ul>
			<?php
			}else
			{
			?>
			<?php if($title){?><h3><?php echo $title; ?></h3><?php }?>
            <?php 
			global $errors,$reg_msg ;
			if($_REQUEST['widgetptype'] == 'login')
			{
				if(is_object($errors))
				{
					foreach($errors as $errorsObj)
					{
						foreach($errorsObj as $key=>$val)
						{
							for($i=0;$i<count($val);$i++)
							{
							echo "<p class=\"error_msg\">".$val[$i].'</p>';	
							}
						} 
					}
				}
				$errors = new WP_Error();
			}
			?>
<script type="text/javascript">
var $cwidget = jQuery.noConflict();
$cwidget(document).ready(function(){
	//global vars
	var loginform = $cwidget("#loginwidgetform");
	var your_name = $cwidget("#widget_user_login");
	var your_pass = $cwidget("#widget_user_pass");

	
	var your_name_Info = $cwidget("#user_login_info");
	var your_pass_Info = $cwidget("#your_pass_info");

	
	//On blur
	your_name.blur(validate_widget_your_name);
	your_pass.blur(validate_widget_your_pass);
	

	//On key press
	your_name.keyup(validate_widget_your_name);
	your_pass.keyup(validate_widget_your_pass);


	//On Submitting
	loginform.submit(function(){
		if(validate_widget_your_name() & validate_widget_your_pass() )
		{
			hideform();
			return true
		}
		else
		{
			return false;
		}
	});

	//validation functions
	function validate_widget_your_name()
	{
		if($cwidget("#widget_user_login").val() == '')
		{
			your_name.addClass("error");
			your_name_Info.text("<?php _e('Please Enter Name','templatic'); ?>");
			your_name_Info.addClass("message_error");
			return false;
		}
		else
		{
			your_name.removeClass("error");
			your_name_Info.text("");
			your_name_Info.removeClass("message_error");
			return true;
		}
	}

	
	function validate_widget_your_pass()
	{ 
		if($cwidget("#widget_user_pass").val() == '')
		{ 
			your_pass.addClass("error");
			your_pass_Info.text("<?php _e('Please Enter password','templatic'); ?>");
			your_pass_Info.addClass("message_error");
			return false;
		}
		else{
			your_pass.removeClass("error");
			your_pass_Info.text("");
			your_pass_Info.removeClass("message_error");
			return true;
		}
	}

	/**registration form validation**/
	var registerform = $cwidget("#registerform");
	//On blur

	$cwidget('#widget_user_rlogin').blur(validate_widget_your_ulogin);
	$cwidget('#widget_user_remail').blur(validate_widget_your_remail);
	
	var your_rname_Info = $cwidget("#your_rname_Info");
	var your_remail_Info = $cwidget("#your_remail_Info");

	function validate_widget_your_ulogin()
	{ 
		if($cwidget("#widget_user_rlogin").val() == '')
		{ 
			$cwidget('#widget_user_rlogin').addClass("error");
			your_rname_Info.text("<?php _e('Please Enter User name','templatic'); ?>");
			your_rname_Info.addClass("message_error");
			return false;
		}
		else{
			$cwidget('#widget_user_rlogin').removeClass("error");
			your_rname_Info.text("");
			your_rname_Info.removeClass("message_error");
			return true;
		}
	}
	
	function validate_widget_your_remail()
	{ 
		if($cwidget("#widget_user_remail").val() == '')
		{ 
			$cwidget('#widget_user_remail').addClass("error");
			your_remail_Info.text("<?php _e('Please Enter Email ID','templatic'); ?>");
			your_remail_Info.addClass("message_error");
			return false;
		}
		else{
			$cwidget('#widget_user_remail').removeClass("error");
			your_remail_Info.text("");
			your_remail_Info.removeClass("message_error");
			return true;
		}
	}
	//On Submitting
		registerform.submit(function(){
		if(validate_widget_your_ulogin() & validate_widget_your_remail() )
		{
			hideform();
			return true
		}
		else
		{
			return false;
		}
		});
});			
			</script>
		    <form name="loginwidgetform" id="loginwidgetform" action="#login_widget" method="post" >
            <input type="hidden" name="widgetptype" value="login" />
           		<div class="form_row"><label><?php _e('Username','templatic');?>  <span>*</span></label>  <input name="log" id="widget_user_login" type="text" class="textfield" /> <span id="user_login_info"></span> </div>
                <div class="form_row"><label><?php _e('Password','templatic');?>  <span>*</span></label>  <input name="pwd" id="widget_user_pass" type="password" class="textfield" /><span id="your_pass_info"></span>  </div>
                
               	<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
				<input type="hidden" name="testcookie" value="1" />
                
				<div class="form_row clearfix">
                <input type="submit" name="submit" value="<?php _e('Sign In','templatic');?>" class="b_signin" /> 
				</div>
				
				<?php do_action('login_form');?>
				</form> 
            <p class="forgot_link">
            <a href="javascript:void(0);showhide_register();" class="lw_new_reg_lnk"><?php _e('New User? Register Now','templatic');?> </a>  <br /> 
            <a href="javascript:void(0);showhide_forgetpw();" class="lw_fpw_lnk"><?php echo FORGOT_PW_TEXT;?></a> </p>            
           
            <?php 
			
			if($_REQUEST['widgetptype'] == 'login')
			{
				if($reg_msg )
			    echo "<p class=\"error_msg\">".$reg_msg.'</p>';	
				if(is_object($errors))
				{
					foreach($errors as $errorsObj)
					{
						foreach($errorsObj as $key=>$val)
						{
							for($i=0;$i<count($val);$i++)
							{
							echo "<p class=\"error_msg\">".$val[$i].'</p>';	
							}
						} 
					}
				}
				$errors = new WP_Error();
			}
			?>
            <!--  registerartion form -->
            <div id="register_form" <?php if($_REQUEST['widgetptype'] == 'register'){?> style="display:block;" <?php }else{?> style="display:none;" <?php }?>>
            
             <?php
			
			if($_REQUEST['widgetptype'] == 'register')
			{
				 if($reg_msg )
			     echo "<p class=\"error_msg\">".$reg_msg.'</p>';	
				if(is_object($errors))
				{
					foreach($errors as $errorsObj)
					{
						foreach($errorsObj as $key=>$val)
						{
							for($i=0;$i<count($val);$i++)
							{
							echo "<p class=\"error_msg\">".$val[$i].'</p>';	
							}
						} 
					}
				}
				$errors = new WP_Error();
			}
			?>
            <h4> <?php _e('New User Register Here','templatic');?> </h4> 
            <form name="registerform" id="registerform" method="post" action="#login_widget">
            <input type="hidden" name="reg_redirect_link" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />	 
             <input type="hidden" name="widgetptype" value="register" />
            
            <div class="form_row clearfix">
            <label><?php _e('Username','templatic');?> <span class="indicates">*</span></label>
            <input type="text" name="widget_user_rlogin" id="widget_user_rlogin" class="textfield" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" />
           <span id="your_rname_Info"></span>
            </div>
            <div class="row_spacer_registration clearfix" >
            <div class="form_row clearfix">
            <label>
            <?php _e('Email','templatic');?>
            <span class="indicates">*</span></label>
            <input type="text" name="widget_user_remail" id="widget_user_remail" class="textfield" value="<?php echo esc_attr(stripslashes($user_fname)); ?>" size="25"  />
			 <span id="your_remail_Info"></span>
            </div>
            </div> 
			<?php $pcd = explode(',',get_option('ptthemes_captcha_dislay'));	
			 if((in_array('Add Place/Event submission page',$pcd) || in_array('Both',$pcd)) && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')  ){
						  echo '<div class="form_row clearfix">';
						 	require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php'); 
						$a = get_option("recaptcha_options");
						echo '<label>'.WORD_VERIFICATION.'</label>';
						$publickey = $a['public_key']; // you got this from the signup page
						echo recaptcha_get_html($publickey); 
						
						 echo '</div>';
						 } ?>
            <input type="submit" name="wp-submit"  id="wp-submit" value="<?php _e('Register','templatic');?>" class="b_signin" />
            </form>
            </div>
            <!--  registerartion #end  -->
            
            
             <div id="lostpassword_form" <?php if($_REQUEST['widgetptype'] == 'forgetpass'){?> style="display:block;" <?php }else{?> style="display:none;" <?php }?>>
            <?php 
			
			if($_REQUEST['widgetptype'] == 'forgetpass')
			{
				if($for_msg )
			    echo "<p class=\"error_msg\">".$for_msg.'</p>';	
				if(is_object($errors))
				{
					foreach($errors as $errorsObj)
					{
						foreach($errorsObj as $key=>$val)
						{
							for($i=0;$i<count($val);$i++)
							{
							echo "<p class=\"error_msg\">".$val[$i].'</p>';	
							}
						} 
					}
				}
				$errors = new WP_Error();
			}
			?>
            <!--  forgot password   -->
            <h4><?php echo FORGOT_PW_TEXT; ?> </h4> 
            <form name="lostpasswordform" id="lostpasswordform" method="post" action="#login_widget">
				<div class="form_row clearfix"> <label>
				<input type="hidden" name="widgetptype" value="forgetpass" />
			   <?php _e('Email','templatic');?>: </label>
				<input type="text" name="user_login" id="user_login1" value="<?php echo esc_attr($user_login); ?>" size="20" class="textfield" />
				<?php do_action('lostpassword_form'); ?>
				</div>
				<input type="submit" name="wp-submit" value="<?php _e('Get New Password','templatic');?>" class="b_forgotpass " />
            </form>   
            </div>     
            <!--  forgot password #end  -->      
             <?php }?>
            </div>
 	<?php
	}

	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
	}}
register_widget('loginwidget');
?>