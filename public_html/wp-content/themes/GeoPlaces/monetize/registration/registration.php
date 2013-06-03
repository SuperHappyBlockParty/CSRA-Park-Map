<?php $page_title = SIGN_IN_PAGE_TITLE;
global $page_title;
global $current_user; if($current_user->ID){wp_redirect(get_author_posts_url($current_user->ID));}?>
<?php 
include_once( ABSPATH.'wp-load.php' );
include_once(ABSPATH.'wp-includes/registration.php');

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && !is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']));
		exit();
	} else { 
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit();
	}
}

	$message = apply_filters('login_message', $message);
	if ( !empty( $message ) ) echo $message . "\n";


/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb;

	$errors = new WP_Error();
	if ( empty( $_POST['user_login'] ) && empty( $_POST['user_email'] ) )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.','templatic'));

	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['user_login']));
		if ( empty($user_data) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.','templatic'));
	} else {
		$login = trim($_POST['user_login']);
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

	$user_email = $_POST['user_email'];
	$user_login = $_POST['user_login'];
	
	$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_login like \"$user_login\" or user_email like \"$user_login\"");
	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key','templatic'));
		
	$new_pass = wp_generate_password(7,false);

	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);
	update_usermeta($user->ID, 'default_password_nag', true); //Set up the Password change nag.
	$message  = __('<p><b>Your login Information :</b></p>','templatic');
	$message  .= '<p>'.sprintf(__('Username: ','templatic').'%s', $user->user_login) . "</p>";
	$message .= '<p>'.sprintf(__('Password: ','templatic').'%s', $new_pass) . "</p>";
	$message .= __('<p>You can login to : <a href="'.home_url().'/?ptype=login">Login</a> or the URL is :  '.home_url().'/?ptype=login</p>','templatic');
	$message .= __('<p>Thank You,<br> '.get_option('blogname').'</p>','templatic');
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

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user($user_login, $user_email) {
	global $wpdb,$site_url;
	$errors = new WP_Error();
	$pcd = explode(',',get_option('ptthemes_captcha_dislay'));
		
	
	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.','templatic'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.','templatic'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.','templatic'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.','templatic'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.','templatic'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.','templatic'));
	
	do_action('register_post', $user_login, $user_email, $errors);

	$errors = apply_filters( 'registration_errors', $errors );

	if ( $errors->get_error_code() )
		return $errors;
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if((in_array('User registration page',$pcd) || in_array('Both',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) {
			wp_redirect($site_url.'/?ptype=register&ecptcha=captch');
			exit;
		} 
	}
	
	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	$activation_key = md5($user_login).rand().time();
	global $upload_folder_path;
	global $form_fields_usermeta;
	foreach($form_fields_usermeta as $fkey=>$fval)
	{
		$fldkey = "$fkey";
		$$fldkey = $_POST["$fkey"];
		
		if($fval['type']=='upload')
		{
			if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0)
			{
				$dirinfo = wp_upload_dir();
				$path = $dirinfo['path'];
				$url = $dirinfo['url'];
				$destination_path = $path."/";
				$destination_url = $url."/";
				
				$src = $_FILES[$fkey]['tmp_name'];
				$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
				$target_file = $destination_path.$file_ame;
				if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
				{
					$image_path = $destination_url.$file_ame;
				}else
				{
					$image_path = '';	
				}
				
				$_POST[$fkey] = $image_path;
				$$fldkey = $image_path;
			}
			
		}
		update_usermeta($user_id, $fkey, $$fldkey); // User Custom Metadata Here
	}

	$userName = $_POST['user_fname'];
	update_usermeta($user_id, 'first_name', $_POST['user_fname']); // User First Name Information Here
	update_usermeta($user_id, 'last_name', $_POST['user_lname']); // User Last Name Information Here
	update_usermeta($user_id,'activation_key',$activation_key); // User activation key here
	update_usermeta($user_id,'userpassword',$user_pass);
	$user_nicename = get_user_nice_name($_POST['user_fname'],$_POST['user_lname']); //generate nice name
	$updateUsersql = "update $wpdb->users set user_url=\"$user_web\", user_nicename=\"$user_nicename\", display_name=\"$userName\"  where ID=\"$user_id\"";
	$wpdb->query($updateUsersql);
	if ( $user_id ) {
		$user_info = get_userdata($user_id);
		$user_login = $user_info->user_login;
		$user_pass = get_user_meta($user_id,'userpassword',true);	
		$activation_key = get_user_meta($user_id,'activation_key',true);	
		$subject = stripslashes(get_option('registration_success_email_subject'));
		$client_message = stripslashes(get_option('registration_success_email_content'));
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();	
		$store_name = get_option('blogname');
		if($subject=="" && $client_message=="")
		{
			//registration_email($user_id);
			$client_message = __('[SUBJECT-STR]Registration Email[SUBJECT-END]<p>Dear [#user_name#],</p>
			<p>Your login information:</p>
			<p>Username: [#user_login#]</p>
			<p>Password: [#user_password#]</p>
			<p>You can login from [#site_login_url#] or</p><p> the URL is : [#site_login_url_link#].</p>
			<p>We hope you enjoy. Thanks!</p>
			<p>[#site_name#]</p>','templatic');
			$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
			$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
			$subject = $filecontent_arr2[0];
			if($subject == '')
			{
				$subject = __("Registration Email",'templatic');
			}
			
			$client_message = $filecontent_arr2[1];
		}
		$store_login_link = '<a href="'.$site_url.'/?ptype=login&akey='.$activation_key.'&uid='.base64_encode($user_id).'">'.$site_url.'/?ptype=login&akey='.$activation_key.'&uid='.base64_encode($user_id).'</a>';
		$store_login = sprintf(__('<a href="'.$site_url.'/?ptype=login&akey='.$activation_key.'&uid='.base64_encode($user_id).'">'.'Click Login'.'</a>','templatic'));
	
		/////////////customer email//////////////
		$search_array = array('[#user_name#]','[#user_login#]','[#user_password#]','[#site_name#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($user_login,$user_login,$user_pass,$store_name,$store_login,$store_login_link);
		$client_message = str_replace($search_array,$replace_array,$client_message);
		$client_message = stripslashes($client_message);
		templ_sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');
	}
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the ','templatic').'<a href="mailto:%s">webmaster</a> !', get_option('admin_email')));
		return $errors;
	}else{
			$redirect_to = wp_redirect($site_url.'/?reg=1&ptype=login');
	}	
	
	return array($user_id,$user_pass);
}			
?>
<?php
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login')) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

//header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined('RELOCATE') ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
	if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != $site_url )
		update_option('home', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
}

//Set a cookie now to see if they are supported by the browser.
//setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action('login_form_' . $action);

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

switch ($action) {

case 'logout' :

	wp_logout();

	$redirect_to =  $_SERVER['HTTP_REFERER']."/";
	//echo $redirect_to = home_url().'/?ptype=login&loggedout=true'; exit;
	if ( isset( $_REQUEST['redirect_to'] ) ){
		$redirect_to = $_REQUEST['redirect_to']."/";
		$redirect_to = $site_url;
		wp_safe_redirect($redirect_to);
		exit();
	}
	
	
break;

case 'lostpassword' :
case 'retrievepassword' :
	if ( $http_post ) {
		$errors = retrieve_password();
		$error_message = $errors->errors['invalid_email'][0];
		if ( !is_wp_error($errors) ) {
			wp_redirect($site_url.'/?ptype=login&page1=sign_in&checkemail=confirm');
			exit();
		}else
		{
			wp_redirect($site_url.'/?ptype=login&page1=sign_in&emsg=fw');
			exit();
		}
	}
	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.','templatic'));
	do_action('lost_password');
	$message = '<div class="success_msg">'.ENTER_USER_EMAIL_NEW_PW_MSG.'</div>';
	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);

	if ( ! is_wp_error($errors) ) {
		wp_redirect($site_url.'/?ptype=login&action=login&checkemail=newpass');
		exit();
	}

	wp_redirect($site_url.'/?ptype=login&action=lostpassword&page1=sign_in&error=invalidkey');
	exit();

break;

case 'register' :
	
	$user_login = '';
	$user_email = '';
	if ( !get_option('users_can_register') ) {
		wp_redirect($site_url.'?ptype=login&page1=sign_up&emsg=regnewusr');
		exit();
	}
	if ( $http_post ) {
		$user_login = $_POST['user_fname'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		
		$errors = register_new_user($user_login, $user_email);
		
		if ( !is_wp_error($errors) ) 
		{
			$_POST['log'] = $user_login;
			$_POST['pwd'] = $errors[1];
			$_POST['testcookie'] = 1;
			
			$secure_cookie = '';
			// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['log']) && !force_ssl_admin() )
			{
				$user_name = sanitize_user($_POST['log']);
				if ( $user = get_userdatabylogin($user_name) )
				{
					if ( get_user_option('use_ssl', $user->ID) )
					{
						$secure_cookie = true;
						force_ssl_admin(true);
					}
				}
			}
			if(isset( $_REQUEST['redirect_to'] ) || $_REQUEST['redirect_to'] != "")	{ 
				$redirect_to = $_REQUEST['reg_redirect_link'];
			} else {
				$redirect_to = get_author_posts_url($errors[0]);	
			}
			
			if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
				$secure_cookie = false;
				$user = wp_signon('', $secure_cookie);
				if ( !is_wp_error($user) ) 	{
					wp_safe_redirect($redirect_to);
					exit();
				}
				exit();
		}
	}

break;

case 'login' :
default:
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
	

	if ( isset( $_REQUEST['redirect_to'] ) || $_REQUEST['redirect_to'] != "") {
		$redirect_to = $_REQUEST['redirect_to']; 
		
		if($_REQUEST['ptype1'] != '' ) {
			if( isset($_REQUEST['redirect_to']) && $_REQUEST['redirect_to'] != '')
				$redirect_to = $_REQUEST['redirect_to']; 
			else
				$redirect_to = $site_url."/?ptype=".$_REQUEST['ptype1'];
		}else{
			$redirect_to = 	get_author_posts_url($user->data->ID);
		}
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') ) {
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
		}
	} else {
		//$redirect_to = admin_url();
		$_REQUEST['redirect_to']=get_author_posts_url($user->ID);
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if(is_wp_error($user))
	{
		if(strstr($_SERVER['HTTP_REFERER'],'ptype=submition') && $_POST['log']!='' && $_POST['pwd']!='')
		{
			wp_redirect($_SERVER['HTTP_REFERER'].'&logemsg=1');
		}
	}
	if ( !is_wp_error($user) ) {

	if(!strstr($_SERVER['HTTP_REFERER'],'ptype=submition'))
	{  
		if($_REQUEST['ptype1'] != '') {
		if( isset($_REQUEST['redirect_to']) && $_REQUEST['redirect_to'] != '')
				$redirect_to = $_REQUEST['redirect_to']; 
			else
				$redirect_to = $site_url."/?ptype=".$_REQUEST['ptype1'];		

		}else{
		//$redirect_to = 	get_author_posts_url($user->data->ID);
		}
	}

	$redirect_to = apply_filters('templ_login_redirect_filter',$redirect_to);
	wp_redirect($redirect_to);
	exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();
	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress.",'templatic'));

	// Some parts of this script use the main login form to display a message
	if( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
	{
		$successmsg = '<div class="success_msg">'.YOU_ARE_LOGED_OUT_MSG.'</div>';
	}
	elseif( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
	{
		$successmsg = USER_REG_NOT_ALLOW_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
	{
		$successmsg = EMAIL_CONFIRM_LINK_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
	{
		$successmsg = NEW_PW_EMAIL_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
	{
		$successmsg = REG_COMPLETE_MSG;
	}
	
	if(($_POST['log'] && $errors) || ($_POST['log']=='' && $_REQUEST['testcookie']))
	{	
		if(isset($_REQUEST['pagetype']))
		{ 
			wp_redirect($_REQUEST['pagetype'].'&emsg=1');
		}else if(isset($_REQUEST['ptype'])){
			wp_redirect("?ptype=".$_REQUEST['ptype'].'&logemsg=1');
		
		}else
		{ 
			wp_redirect($site_url.'?ptype=login&page1=sign_in&emsg=1');
		}
		exit;
	}
break;
} // end action switch
 get_header(); ?>
<script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
<script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>

<div class="<?php templ_content_css();?>">
	
    
  <div class="entry">
    <div  id="post_<?php the_ID(); ?>">
      <div class="post-meta">
		  <?php if ( get_option('ptthemes_breadcrumbs' ) == 'Yes' ) {  ?>
			<div class="breadcrumb clearfix">
				<div class="breadcrumb_in"><a href="<?php echo $site_url; ?>"><?php _e('Home','templatic'); ?></a> &raquo; <?php _e(SIGN_IN_PAGE_TITLE,'templatic'); ?> </div>
			</div>
		<?php } ?>
        <?php //templ_page_title_above(); //page title above action hook?>
        <?php 
		
		echo templ_page_title_filter(SIGN_IN_PAGE_TITLE); //page tilte filter?>
        <?php templ_page_title_below(); //page title below action hook?>
      </div>
      <div class="post-content">
	  <?php
	  if($_REQUEST['akey'] != "" && $_REQUEST['uid'] != "")
	  {
	    echo $uid = $_REQUEST['uid'];
		$activation_key = get_user_meta($uid,'activation_key',true);
		$user_info = get_userdata($uid);
		$user_info->ID."uid=".$uid;
		$activation_key."akey=".$_REQUEST['akey'];
		if($_REQUEST['akey'] == $activation_key && $uid == $user_info->ID)
		{ 
		echo "<p class=\"error_msg\"> ".REGISTRATION_SUCCESS_MSG."</p>";
		registration_email($user_info->ID);
		}		
	  }
		foreach($errors as $errorsObj)
		{
		foreach($errorsObj as $key=>$val)
		{
			for($i=0;$i<count($val);$i++)
			{
				echo "<div class=error_msg>".$val[$i].'</div>';	
				$registration_error_msg = 1;
			}
		} 
		}
	if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_in')
	{
	?>
			<div class="login_form">
          <?php 
	include (TEMPL_REGISTRATION_FOLDER . "login_form.php");
 	?>
        </div>
        <?php
	}
	elseif($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
	{
	?>
        <div class="registration_form">
          <?php include (TEMPL_REGISTRATION_FOLDER . "registration_form.php");?>
        </div>
        <?php
	}else
	{
?>
        <div class="login_form_l">
          <?php include (TEMPL_REGISTRATION_FOLDER . "login_form.php");?>
        </div>
        <div class="registration_form_r">
          <?php include (TEMPL_REGISTRATION_FOLDER . "registration_form.php");?>
        </div>
        <?php }?>
      </div>
      <!-- content #end -->
      <script type="text/javascript">
try{document.getElementById('user_login').focus();}catch(e){}
</script>
     
      <?php
if($errors->errors['invalidcombo'] || $errors->errors['empty_username'])
{
?>
      <script language="javascript">document.getElementById('lostpassword_form').style.display = '';</script>
      <?php
}
?>
    </div>
  </div>
</div> <!-- content end -->
<div class="sidebar right">
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('login_page')){?><?php } else {?>  <?php }?> 
</div>
<?php if($_REQUEST['ptype'] == 'register'): ?>
	<script type="text/javascript">
    document.getElementById('user_email').focus();
    </script>
<?php endif; ?>
<?php get_footer(); ?>