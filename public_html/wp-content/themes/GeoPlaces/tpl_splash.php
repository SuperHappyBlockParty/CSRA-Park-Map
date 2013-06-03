<?php 
/*
Template Name: Page - Splash
*/
if(!isset($_POST['front_post_city_id'])  && isset($_REQUEST) && $_REQUEST!='' ) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php echo get_bloginfo('html_type'); ?>; charset=<?php echo get_bloginfo('charset'); ?>" />
     <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <title><?php wp_title ( '|', true,'right' ); ?></title>
   <?php do_action('templ_head_meta');?>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php /*?><link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" /><?php */?>
    <?php do_action('templ_head_css');?>
	<?php
    wp_enqueue_script('jquery');
    wp_enqueue_script('cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', 'jquery', false);
    wp_enqueue_script('cookie', get_template_directory_uri() . '/js/jquery.cookie.js', 'jquery', false);
    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
    do_action('templ_head_js');
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	wp_head();
	
	?>	<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/customSelect.jquery.js"></script>
    <style type="text/css">
		body { margin:0; padding:0; background:#00a3d3; border-top:5px solid #0880a3; font-family:Georgia, "Times New Roman", Times, serif; }
		img { outline:none; border:0; }
		.header { border-bottom:2px solid #0298c5; padding:40px 0; text-align:center;   }
		.header .site-title a { display:none;  }
		.header .site-description { font:bold 14px Arial, Helvetica, sans-serif; color:#b3dafa; padding-left:45px; }
		
		.select_city { margin: 40px auto 0; position: relative; text-align: center; width: 322px;  }
		.select_city h3 { margin:0; padding:0 0 20px 0; font-size:36px; color:#fff; font-weight:normal; text-shadow:1px 1px 1px #333; }
		.select_city p { margin:0 0 20px 0; padding:0; font-size:16px; color:#ececec;  }
		
		.styled-select select {
		   width: 268px;
		   padding: 12px 20px 17px;
		   font: 16px Georgia, "Times New Roman", Times, serif;
 		   height:45px !important;
		   padding:10px 0;
		   border:none;
		   color:#b2b2b2;
		   float:left;
		}
		
		.styled-select select:focus { color:#333; }
		.styled-select {
		   background:url(<?php echo get_bloginfo('template_directory'); ?>/images/canvas-arrow.png) no-repeat 229px center;
		   background-color:#fff;
		   width: 267px !important;
		   height: 45px !important;
		   margin: 0 auto 0 auto !important;
		   overflow: hidden;
		  
			border-radius: 24px;
			border-radius: 24px;
			margin-left:34px;
		   cursor:pointer;
		   *height:auto;
	  
		}
		.b_go { display:block; width:89px; height:48px; background:url(<?php echo get_bloginfo('template_directory'); ?>/images/b_go.png) no-repeat left top;  
		position: absolute; text-indent:-9009px; right:0px; border:none; cursor:pointer;  } 
		.b_go:hover { background-position:left -48px; }
		
		
		
	</style>
    
</head>

<?php


function multisite_body_classes($classes) {
        $id = get_current_blog_id();
        $slug = strtolower(str_replace(' ', '-', trim(get_bloginfo('name'))));
        $classes[] = $slug;
		if ( is_home() && !isset($_REQUEST['page'])) {
        $classes[] = 'homebg';
		}
        return $classes;
}
add_filter('body_class', 'multisite_body_classes'); 
global $site_url;
?>
<body <?php body_class(); ?>>

	<div class="header">
    	<?php  do_action('templ_site_logo');  ?> 
    </div>
	 
     
     <div class="select_city">
     	<h3><?php echo SELECT_CITY_TPL;?></h3>
        <p><?php echo SELECT_CITY_DESC_TPL;?></p>
          <div class="styled-select">
           <form name="frmcity" id="frmcity" action="<?php echo $site_url;?>" method="post">
		   <?php echo get_multicit_select_dl('front_post_city_id','front_post_city_id','','onchange="document.frmcity.submit();" style="position: absolute; opacity: 0; left:34px;" ');?>
           </form>
         </div>
      </div>
    
    
</body>
</html>
<?php } else  {
	setcookie("multi_city1", $_POST['front_post_city_id'],time()+3600*24*30*12);
	$_SESSION['multi_city1'] = $_COOKIE['multi_city1'];
	wp_redirect($site_url);
	exit;
}

/* function to add class for home page*/
?>

