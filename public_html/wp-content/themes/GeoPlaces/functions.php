<?php session_start();
error_reporting(0);
load_theme_textdomain('templatic');
load_textdomain( 'templatic', get_template_directory().'/language/en_US.mo' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
define('TAGKW_TEXT_COUNT',40);

/*for theme update*/
$theme_name ='';
global $extension_file, $pagenow, $theme_name;

if(is_admin() && ($pagenow =='themes.php' || $pagenow =='post.php' || $pagenow =='edit.php'|| $pagenow =='admin-ajax.php'  || @$_REQUEST['page'] == 'GeoPlaces_tmpl_theme_update')){
	require_once('wp-updates-theme.php');
	$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');
	new WPUpdatesGeoPlacesUpdater( 'http://templatic.com/updates/api/index.php',basename(get_stylesheet_directory()));
}

if ( ! isset( $content_width ) ) $content_width = 900;

/* FUNCTION TO REMOVE WHITE SPACES FROM RSS PAGE */
function ___wejns_wp_whitespace_fix($input) {
    /* valid content-type? */
    $allowed = false;

    /* found content-type header? */
    $found = false;

    /* we mangle the output if (and only if) output type is text/* */
    foreach (headers_list() as $header) {
        if (preg_match("/^content-type:\\s+(text\\/|application\\/((xhtml|atom|rss)\\+xml|xml))/i", $header)) {
            $allowed = true;
        }

        if (preg_match("/^content-type:\\s+/i", $header)) {
            $found = true;
        }
    }

    /* do the actual work */
    if ($allowed || !$found) {
        return preg_replace("/\\A\\s*/m", "", $input);
    } else {
        return $input;
    }
}

/* start output buffering using custom callback */
ob_start("___wejns_wp_whitespace_fix");
/* END OF FUNCTION */

/* Set the file extension for allown only image/picture file extension in upload file*/
$extension_file=array('.jpg','.JPG','jpeg','JPEG','.png','.PNG','.gif','.GIF','.jpe','.JPE');  
global $extension_file;

/*** Theme setup ***/
global $blog_id,$site_url;
define('TT_ADMIN_FOLDER_NAME','admin');
define('TT_ADMIN_FOLDER_PATH',get_template_directory().'/'.TT_ADMIN_FOLDER_NAME.'/'); //admin folder path
update_option('thumbnail_size_w','150'); //admin folder path
update_option('thumbnail_size_h','105'); //admin folder path
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads')){
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else {
	$upload_folder_path = "wp-content/uploads/";
}
define('DOMAIN','templatic');
global $sitepress;
if(class_exists('sitepress')){
	$default_language = $sitepress->get_default_language();
}else{ $default_language ='en'; }
if(is_plugin_active('wpml-string-translation/plugin.php') && ICL_LANGUAGE_CODE !=$default_language){
				
				$siteurl = trailingslashit(home_url()).ICL_LANGUAGE_CODE;
				$site_url = $siteurl;
}else{
	$site_url = trailingslashit( home_url() );
}
global $site_url;


if(file_exists(TT_ADMIN_FOLDER_PATH . 'constants.php')){
	include_once(TT_ADMIN_FOLDER_PATH.'constants.php');  //ALL CONSTANTS FILE INTEGRATOR
}

add_action('init','templ_set_my_city'); 
include_once(TT_ADMIN_FOLDER_PATH.'admin_main.php');  //ALL ADMIN FILE INTEGRATOR
include_once (TT_FUNCTIONS_FOLDER_PATH . 'custom_functions.php');
if(file_exists(get_template_directory().'/language.php')){
include_once(get_template_directory().'/language.php');  //ALL CONSTANTS FILE INTEGRATOR
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php')){
	include_once (TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php'); // manage theme filters in the file
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'image_resizer.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'image_resizer.php');
}

// Theme admin functions

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'widgets.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'widgets.php'); // theme widgets in the file
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'meta_boxes.php')){
include_once (TT_FUNCTIONS_FOLDER_PATH . 'meta_boxes.php'); // theme meta boxes in the file
}

if(file_exists(TT_WIDGET_FOLDER_PATH . 'widgets_main.php')){
include_once (TT_WIDGET_FOLDER_PATH . 'widgets_main.php'); // theme widgets in the file
}
if(file_exists(get_template_directory() . '/library/rating/post_rating.php')) {
	include_once (get_template_directory() . '/library/rating/post_rating.php');
}
if(file_exists(TT_FUNCTIONS_FOLDER_PATH.'listing_filters.php') && !strstr($_SERVER['REQUEST_URI'],'/wp-admin/')) {
	include_once (TT_FUNCTIONS_FOLDER_PATH.'listing_filters.php');
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'modules_main.php')){
include_once (TT_MODULES_FOLDER_PATH . 'modules_main.php'); // Theme moduels include file
}

if(file_exists(TT_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php')){
include_once (TT_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php'); // sample data insert file
}


if(file_exists(TT_FUNCTIONS_FOLDER_PATH . "general_functions.php")){
require(TT_FUNCTIONS_FOLDER_PATH . "general_functions.php");
$General = new General();
global $General;
}

if(file_exists(get_template_directory() . '/library/functions/mega_menu_widget.php')) {
	include_once (get_template_directory() . '/library/functions/mega_menu_widget.php');
}
/* Below included file contains problem solution for taxonomy seo url BOF */
if(!file_exists(ABSPATH.'wp-content/plugins/taxonomic-seo-permalinks/taxonomic-seo-permalink.php') && !plugin_is_active('taxonomic-seo-permalinks') && file_exists(get_template_directory() . '/library/functions/taxonomic-seo-permalinks/taxonomic-seo-permalink.php')) {
	include_once (get_template_directory() . '/library/functions/taxonomic-seo-permalinks/taxonomic-seo-permalink.php');
}
/* Below included file contains problem solution for taxonomy seo url BOF */
add_theme_support( 'post-formats', array( 'aside', 'gallery','link', 'image','quote', 'status','video', 'audio','chat') );

if(get_option('ptthemes_alt_stylesheet') == '' || get_option('ptthemes_alt_stylesheet') == '1-default.css'){
update_option("ptthemes_alt_stylesheet",'1-default');
}
if(get_option('ptthemes_enable_claimownership') == ''){
update_option("ptthemes_enable_claimownership",'Yes');
}
/*
name : theme_post_author_override
description : fetch all the users for back end dropdown list.
*/
add_filter('wp_dropdown_users', 'theme_post_author_override');
function theme_post_author_override($output) { 
	global $post; // return if this isn't the theme author override dropdown 
	if (!preg_match('/post_author_override/', $output)) return $output; // return if we've already replaced the list (end recursion) 
	if (preg_match ('/post_author_override_replaced/', $output)) return $output; // replacement call to wp_dropdown_users
	$output = wp_dropdown_users(array( 'echo' => 0, 'name' => 'post_author_override_replaced', 'selected' => empty($post->ID) ? $user_ID : $post->post_author, 'include_selected' => true )); // put the original name back 
	$output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output); return $output;
	}

	
	if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && !strstr($_SERVER['REQUEST_URI'],'/monetize/')  && !strstr($_SERVER['REQUEST_URI'],'wp-login.php')) {
		if (isset($_POST['multi_city']) && $_POST['multi_city'] != '' && $_SESSION['multi_city']=='') { 
			$_SESSION['multi_city'] = $_POST['multi_city'];
			$_SESSION['multi_city1'] = $_POST['multi_city'];
		} else if (isset($_REQUEST['front_post_city_id']) && $_REQUEST['front_post_city_id'] != "" ) {
			setcookie("multi_city1", $_REQUEST['front_post_city_id'],time()+3600*24*30*12);
			$_COOKIE['multi_city1'] = $_REQUEST['front_post_city_id'];
			$_SESSION['multi_city1'] = $_COOKIE['multi_city1'];
			$_SESSION['multi_city'] = $_COOKIE['multi_city1'];
		} else if ($_SESSION['multi_city'] == "" && $_POST['multi_city'] == "") {
			if ($_REQUEST['front_post_city_id'] == "" && get_option('splash_page') != "" && $_SESSION['multi_city1']=="" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "") {
				include_once("tpl_splash.php");
				exit;
			} else {
				global $multicity_db_table_name;
				$my_city =$wpdb->get_row("select city_id from $multicity_db_table_name where is_default='1'");
				$_SESSION['multi_city'] = $my_city->city_id;
			}
		} else {
			$_SESSION['multi_city'] = $_SESSION['multi_city'];
			$_SESSION['multi_city1'] = $_SESSION['multi_city'];
		}
	}

if(!function_exists('customAdmin')){
function customAdmin() {
    echo "<style>
	
	.table_tnews {
		float: right;
		width: 63%;
		}
		
	.t_theme {
		float: left;
		width: 34%;
		margin-right: 3%;
		}
		
	.t_theme img {
		max-width: 100%;
		}
		
	.clearfix { clear:both; }

	.clearfix:after{
		clear: both;
		content: ".";
		display: block;
		font-size: 0;
		height: 0;
		line-height: 0;
		visibility: hidden;
		}
	
	.theme_meta .more a.btn_viewdetails,
	.theme_meta .more a.btn_viewdemo {
		margin: 10px 10px 0px 0px;
		}
		
	.table_tnews .news li p {
		margin-top: 0;
		}
	.templatic-dismiss {
		background: url('images/xit.gif') no-repeat scroll 0px 2px transparent;
		position: absolute;
		right: 60px;
		top: 8px;
		width: 0px;
		font-size: 13px;
		line-height: 1;
		padding: 0 0 0 10px;
		text-decoration: none;
		text-indent: 3px;
	}

	.templatic-dismiss:hover {
		background-position: -10px 2px;
	}
	
	.templatic_autoinstall{
		position:relative;
	}
	div.updated, .login .message,
	{
		background: #FFFBE4;
		border-color: #DFDFDF;
		}
	
	.postbox .inside {
		margin: 15px 0 !important;
		}
	
	.themeunit{
		margin-bottom: 10px;
		}
	
	
	
/* Theme Autoupdate css start */
	.templatic_login {
		background: none repeat scroll 0 0 #FFFFFF;
		border:0 !important;
		margin:0 !important;
		font-size: 14px;
		font-weight: normal;
		padding: 15px;
		padding-top:20px;
		width:40%;
		}
		
	.templatic_login label {
		color: #777777;
		font-size: 14px;
		}
		
	.templatic_login form .input, .templatic_login input[type='text'], .templatic_login input[type='password'] {
		background: none repeat scroll 0 0 #FBFBFB;
		border: 1px solid #E5E5E5;
		box-shadow: 1px 1px 2px rgba(200, 200, 200, 0.2) inset;
		color: #555555;
		font-size: 24px;
		font-weight: 200;
		line-height: 1;
		margin-bottom: 16px;
		margin-right: 6px;
		margin-top: 2px;
		outline: 0 none;
		padding: 10px 8px 6px;
		width: 100%;
		}
		
	.templatic_login input[type='submit'] {
		background-color: #21759b;
		background-image: -webkit-gradient(linear, left top, left bottom, from(#2a95c5), to(#21759b));
		background-image: -webkit-linear-gradient(top, #2a95c5, #21759b);
		background-image:    -moz-linear-gradient(top, #2a95c5, #21759b);
		background-image:     -ms-linear-gradient(top, #2a95c5, #21759b);
		background-image:      -o-linear-gradient(top, #2a95c5, #21759b);
		background-image:   linear-gradient(to bottom, #2a95c5, #21759b);
		border-color: #21759b;
		box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset;
		color: #FFFFFF;
		text-decoration: none;
		text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
		height: 30px;
		line-height: 28px;
		padding: 0 12px 2px;
		border-radius: 3px 3px 3px 3px;
		border-style: solid;
		border-width: 1px;
		cursor: pointer;
		display: inline-block;
		font-size: 12px;
		margin-right: 10px;
		}
		
	.templatic_login p.info {
		margin-top: 0; 
	}
	body {
	min-width: 380px !important;
	}

	#pblogo {
	margin-top: 10px;
	text-align:left !important;
	}

	#TB_window {
	left: 53% !important;
	top: 100px !important;
	}
	
	</style>";
}
}
add_action('admin_head', 'customAdmin', 11);
?>