<?php /* set multicity is in session */
if (isset($_REQUEST['pid']) && $_REQUEST['pid'] !='') {
    $cur_post_id = $_REQUEST['pid'];
    $postdata = get_post($cur_post_id );
    $post_author_id = $postdata->post_author;
}
if (isset($_REQUEST['front_post_city_id']) =="" && get_option('splash_page') != "" && $_SESSION['multi_city1'] == "" && $_SESSION['multi_city'] == "" && $_COOKIE['multi_city1'] == "") {
    /* show slash page if selected slash page from backend */
    include_once("tpl_splash.php");
    exit;
} else {
    if ($_SESSION['multi_city'] == "") {
        $_SESSION['multi_city']= $_COOKIE['multi_city1'];
    }
    if (isset($_REQUEST['ptype']) && $_REQUEST['ptype']!="") {
        if ($_REQUEST['ptype'] == 'favorite') {
            if ($_REQUEST['action']=='add') {
                add_to_favorite($_REQUEST['pid']);
            } else {
                remove_from_favorite($_REQUEST['pid']);
            }
        } else if ($_REQUEST['ptype']=='profile') {
            global $current_user,$site_url;
            if (!$current_user->ID) {
                wp_redirect($site_url.'/?ptype=login');
                exit;
            }
            include_once(TT_MODULES_FOLDER_PATH . "registration/registration.php");
            exit;
        } else if ($_REQUEST['ptype'] == 'phpinfo') {
            echo phpinfo();
            exit;
        } else if ($_REQUEST['ptype'] == 'csvdl') {
            include(get_template_directory(). "/library/includes/csvdl.php");
        } else if ($_REQUEST['ptype'] == 'register' || $_REQUEST['ptype'] == 'login') {
            include(TT_MODULES_FOLDER_PATH . "registration/registration.php");
        } else if ($_REQUEST['ptype']=='post_listing') {
            include_once(TT_MODULES_FOLDER_PATH.'place/submit_place.php');
            exit;
        } else if ($_REQUEST['ptype']=='post_event') {
            include_once(TT_MODULES_FOLDER_PATH.'event/submit_event.php');
            exit;
        } else if ($_REQUEST['ptype'] == 'preview') {
            include(TT_MODULES_FOLDER_PATH . "place/preview.php");
            exit;
        } else if ($_REQUEST['ptype'] == 'preview_event') {
            include(TT_MODULES_FOLDER_PATH . "event/preview_event.php");
            exit;
        } else if ($_REQUEST['ptype'] == 'paynow') {
            include(TT_MODULES_FOLDER_PATH . "place/paynow.php");
        } else if ($_REQUEST['ptype'] == 'paynow_event') {
            include(TT_MODULES_FOLDER_PATH . "event/paynow_event.php");
        } else if ($_REQUEST['ptype'] == 'cancel_return') {
            include_once(TT_MODULES_FOLDER_PATH . 'general/cancel.php');
            if ($post_author_id == $current_user->ID) {
                set_property_status($_REQUEST['pid'],'trash');
            }
            exit;
        } else if($_GET['ptype'] == 'return' || $_GET['ptype'] == 'payment_success')  // PAYMENT GATEWAY RETURN
        {
            if ($post_author_id == $current_user->ID) {
                $status = get_property_default_status();
                set_property_status($cur_post_id,$status);
                include_once(TT_MODULES_FOLDER_PATH . 'general/return.php');
            }
            exit;
        } else if($_GET['ptype'] == 'success')  // PAYMENT GATEWAY RETURN
        {
            include_once(TT_MODULES_FOLDER_PATH . "general/success.php");
            exit;
        } else if($_GET['ptype'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
        {
            if ($_GET['pmethod'] == 'paypal') {
                include_once(TT_MODULES_FOLDER_PATH . 'general/ipn_process.php');
            } else if ($_GET['pmethod'] == '2co') {
                include_once(TT_MODULES_FOLDER_PATH . 'general/ipn_process_2co.php');
            }
            exit;
        } else if ($_REQUEST['ptype'] == 'sort_image') {
            global $wpdb;
            $arr_pid = explode(',',$_REQUEST['pid']);
            for ($j=0; $j<count($arr_pid); $j++) {
                $media_id = $arr_pid[$j];
                if (strstr($media_id,'div_')) {
                    $media_id = str_replace('div_','',$arr_pid[$j]);
                }
                $wpdb->query('update '.$wpdb->posts.' set  menu_order = "'.$j.'" where ID = "'.$media_id.'" ');
            }
            echo 'Image order saved successfully';
        } else if ($_REQUEST['ptype'] == 'delete') {
            global $current_user;
            if ($post_author_id == $current_user->ID) {
                wp_delete_post($_REQUEST['pid']);
                wp_redirect(get_author_link($echo = false, $current_user->ID));
            }
        } else if ($_REQUEST['ptype'] == 'att_delete') {
            if ($_REQUEST['remove'] == 'temp') {
                if ($_SESSION["file_info"]) {
                    $tmp_file_info = array();
                    foreach($_SESSION["file_info"] as $image_id=>$val)	{
                        if ($image_id == $_REQUEST['pid']) {
                            @unlink(ABSPATH."/".$upload_folder_path."tmp/".$_REQUEST['pid'].".jpg");
                        } else {
                            $tmp_file_info[$image_id] = $val;
                        }
                    }
                    $_SESSION["file_info"] = $tmp_file_info;
                }
            } else {
                if ($post_author_id == $current_user->ID) {
                    wp_delete_attachment($_REQUEST['pid']);
                }
            }
        }
    } else {
        get_header();
        ?>
        <div  class="<?php templ_content_css();?>" >
        <!--  CONTENT AREA START -->
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('front_content')) {
        ?><?php } else {
        ?>  <?php }
        ?>
        <!--  CONTENT AREA END -->
        </div>
        <?php include_once('library/includes/sidebar_front_page.php');
        ?>
        <?php get_footer();
    }
}
?>