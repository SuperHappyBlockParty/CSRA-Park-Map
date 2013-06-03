<?php
/*
Name :templ_is_show_listing_author
description : return the display author name option is enable or not
*/
function templ_is_show_listing_author()
{
	if(strtolower(get_option('ptthemes_listing_author'))=='yes' || get_option('ptthemes_listing_author')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_listing_date
description : return the display date option is enable or not
*/
function templ_is_show_listing_date()
{
	if(strtolower(get_option('ptthemes_listing_date'))=='yes' || get_option('ptthemes_listing_date')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_listing_comment
description : return the display comments option is enable or not
*/
function templ_is_show_listing_comment()
{
	if(strtolower(get_option('ptthemes_listing_comment'))=='yes' || get_option('ptthemes_listing_comment')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_listing_category
description : return the display categories on listing page option is enable or not
*/
function templ_is_show_listing_category()
{
	if(strtolower(get_option('ptthemes_listing_category'))=='yes' || get_option('ptthemes_listing_category')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_listing_tags
description : return the display tags on listing page option is enable or not
*/
function templ_is_show_listing_tags()
{
	if(strtolower(get_option('ptthemes_listing_tags'))=='yes' || get_option('ptthemes_listing_tags')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_listing_tags
description : return the display tags on listing page option is enable or not
*/
function templ_is_show_listing_views()
{
	if(strtolower(get_option('ptthemes_listing_views'))=='yes' || get_option('ptthemes_listing_views')=='')
	{
		return true;	
	}
	return false;
}

/* Function to fetch the settings for products detail page */

/*
Name :templ_is_show_post_author
description : return the display author name option is enable or not for detail page.
*/
function templ_is_show_post_author()
{
	if(strtolower(get_option('ptthemes_details_author'))=='yes' || get_option('ptthemes_details_author')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_post_date
description : return the display date option is enable or not for detail page.
*/
function templ_is_show_post_date()
{
	if(strtolower(get_option('ptthemes_details_date'))=='yes' || get_option('ptthemes_details_date')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_post_comment
description : return the display comments options is enable or not for detail page.
*/
function templ_is_show_post_comment()
{
	if(strtolower(get_option('ptthemes_details_comment'))=='yes' || get_option('ptthemes_details_comment')=='')
	{
		return true;	
	}
	return false;
}
/*
Name :templ_is_show_post_category
description : return the display categories on detail page options is enable or not.
*/
function templ_is_show_post_category()
{
	if(strtolower(get_option('ptthemes_details_category'))=='yes' || get_option('ptthemes_details_category')=='')
	{
		return true;	
	}
	return false;
}

function templ_is_show_post_tags()
{
	if(strtolower(get_option('ptthemes_details_tags'))=='yes' || get_option('ptthemes_details_tags')=='')
	{
		return true;	
	}
	return false;
}
/////////PRODUCT DETAIL PAGE FUNCTIONS END///////////////

/////////FOOTER FUNCTIONS START///////////////
function templ_is_footer_widgets_2colright()
{
	if(get_option('ptthemes_bottom_options')=='Two Column - Right(one third)')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_2colleft()
{
	if(get_option('ptthemes_bottom_options')=='Two Column - Left(one third)')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_eqlcol()
{
	if(get_option('ptthemes_bottom_options')=='Equal Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_3col()
{
	if(get_option('ptthemes_bottom_options')=='Three Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_4col()
{
	if(get_option('ptthemes_bottom_options')=='Four Column')
	{
		return true;	
	}
	return false;
}
function templ_is_footer_widgets_fullwidth()
{
	if(get_option('ptthemes_bottom_options')=='Full Width')
	{
		return true;	
	}
	return false;
}

///////////////OTHER FLAG SETTINGS START////////////////////
function templ_is_ajax_pagination()
{
	if (get_option('ptthemes_pagination') == 'AJAX-fetching posts')
	{
		return true;	
	}
	return false;
}
function templ_is_third_party_seo()
{
	if(strtolower(get_option('ptthemes_use_third_party_data'))=='yes')
	{
		return true;	
	}
	return false;		
}
function templ_is_top_home_link()
{
	if(strtolower(get_option('ptthemes_top_home_links'))=='yes' || get_option('ptthemes_top_home_links')=='' )
	{
		return true;
	}
	return false;
}
function templ_is_top_pages_nav()
{
	if(get_option('ptthemes_top_pages_nav')!="" && !strstr(get_option('ptthemes_top_pages_nav'),'none'))
	{
		return true;
	}
	return false;
}
function templ_is_top_category_nav()
{
	if(get_option('ptthemes_category_top_nav')!="" && !strstr(get_option('ptthemes_category_top_nav'),'none'))
	{
		return true;
	}
	return false;
}
function templ_is_facebook_button()
{
	if(strtolower(get_option('ptthemes_facebook_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function templ_is_tweet_button()
{
	if(strtolower(get_option('ptthemes_tweet_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function templ_is_show_blog_title()
{
	if(strtolower(get_option('ptthemes_show_blog_title'))=='yes')
	{
		return true;	
	}
	return false;
}
/*
Name: templ_is_php_mail
Description : Function to check is php mail is enable/disable in basic settings. it returns true/false.
*/
function templ_is_php_mail()
{
	if(get_option('ptthemes_notification_type')=='PHP Mail')
	{
		return true;	
	}
	return false;
}
function templ_is_auto_install()
{
	if(strtolower(get_option('ptthemes_auto_install'))=='yes')
	{
		return true;	
	}
	return false;
}



/*
FUNCTION NAME : templ_sendEmail
ARGUMENTS : from email ID,From email Name, To email ID, To email name, Mail Subject, Mail Content, Mail Header.
RETURNS : Send Mail to the email address.
*/
function templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$fromEmail = apply_filters('templ_send_from_emailid', $fromEmail);
	$fromEmailName = apply_filters('templ_send_from_emailname', $fromEmailName);
	$toEmail = apply_filters('templ_send_to_emailid', $toEmail);
	$toEmailName = apply_filters('templ_send_to_emailname', $toEmailName);

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	$headers .= 'From: '.get_option('blogname').' <'.$fromEmail.'>' . "\r\n";
		
	$subject = apply_filters('templ_send_email_subject', $subject);
	$message = apply_filters('templ_send_email_content', $message);
	$headers = apply_filters('templ_send_email_headers', $headers);
	
	// Mail it
	if(templ_is_php_mail())
	{
		@mail($toEmail, $subject, $message, $headers);	
	}else
	{
		wp_mail($toEmail, $subject, $message, $headers);	
	}	
}
/*
FUNCTION NAME : templ_getTinyUrl
ARGUMENTS :source url
RETURNS : Tiny URL created
*/
function templ_getTinyUrl($url) {
    //$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
	$tinyurl = $url;
    return $tinyurl;
}


/*
FUNCTION NAME : templ_get_date_format
ARGUMENTS :None
RETURNS : date format as per set from design settings
*/
function templ_get_date_format()
{
	return templ_date_format();
}

function templ_date_format()
{
	$date_format = get_option('ptthemes_date_format');
	if(!$date_format){$date_format = get_option('date_format');}
	if(!$date_format){$date_format = 'M j, Y';}
	return apply_filters('templ_date_formate_filter',$date_format);
}
/*
FUNCTION NAME : templ_get_time_format
ARGUMENTS :None
RETURNS : time format as per set from design settings
*/
function templ_get_time_format()
{
	return templ_time_format();
}

function templ_time_format()
{
	$time_format = get_option('ptthemes_time_format');
	if(!$time_format){ $time_format = get_option('time_format');}
	if($time_format==''){$time_format = 'g:s a';}
	return apply_filters('templ_time_formate_filter',$time_format);
}

/*
FUNCTION NAME : templ_get_formated_date
ARGUMENTS :Input date in 'Y-m-d' format (eg:- 2011-01-31)
RETURNS : formated date as per set from design settings
*/
function templ_get_formated_date($date)
{
	return templ_date_formated($date);	
}

function templ_date_formated($date)
{
	$date_format = templ_get_date_format();
	if($date)
	{
		return apply_filters('templ_get_formated_date_filter',date($date_format,strtotime($date)));	
	}
}

/*
FUNCTION NAME : templ_get_site_contact_email
ARGUMENTS :NONE
RETURNS : site email set from design settings or admin email
*/
function templ_get_site_contact_email()
{
	return templ_site_contact_email();
}

function templ_site_contact_email()
{
	$site_email = get_option('pttheme_contact_email');
	if($site_email=='')
	{
		$site_email = get_option('admin_email');	
	}
	return apply_filters('templ_get_site_contact_email_filter',$site_email);
}

/*
FUNCTION NAME : templ_set_breadcrumbs_navigation
ARGUMENTS :arg1=custom seperator, arg2=cutom breadcrumbs content
RETURNS : breadcrums for each pages
*/
function templ_set_breadcrumbs_navigation($arg1='',$arg2='')
{
	do_action('templ_set_breadcrumbs_navigation');
	if (strtolower(get_option('ptthemes_breadcrumbs'))=='Yes') {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in">
		<?php 
		ob_start();
		yoast_breadcrumb(''.$arg1,''.$arg2);
		$breadcrumb = ob_get_contents();
		ob_end_clean();
		echo apply_filters('templ_breadcrumbs_navigation_filter',$breadcrumb);
		?></div>
    </div>
    <?php }
}

/*
FUNCTION NAME : templ_get_excerpt
ARGUMENTS :string content, number of characters limit
RETURNS : string with limit of number of characters
*/
function templ_get_excerpt($finalstring, $limit='',$post_id='') {
	global $post;
	if(!$post_id)
	{
		$post_id=$post->ID;
	}
	$finalstring = strip_tags($finalstring);
	$read_more = stripslashes(get_option('ptthemes_content_excerpt_readmore'));
	$words = explode(" ",$finalstring);
	
	if ( count($words) >= $limit){
	if($read_more)
	{
		$read_more1 = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.$read_more.'</a>';
	}else
	{
		$read_more1 = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.__(READ_MORE_LABEL,'templatic').'</a>';
	}
	}
	$read_more1 = apply_filters('templ_get_excerpt_readmore_filter',$read_more1);
	if($limit)
	{
		$words = explode(" ",$finalstring);
		if ( count($words) >= $limit)
			return apply_filters('templ_get_excerpt_filter',implode(" ",array_splice($words,0,$limit)).$read_more1);
		else
			return apply_filters('templ_get_excerpt_filter',$finalstring.$read_more1);
		
	}else
	{
		return apply_filters('templ_get_excerpt_filter',$finalstring.$read_more1);
	}
}

/*
FUNCTION NAME : templ_listing_content
ARGUMENTS :NONE
RETURNS : display content or excerpt or sub part of it.
*/
function templ_listing_content($post)
{	
	global $post;
	if (apply_filters('templ_get_listing_content_filter', true))
	{
		if(get_option('ptthemes_postcontent_full')=='Full Content')
		{ 			
			echo $post->post_content;			
		}else
		{
			if($post->post_excerpt != ''){
				$string = $post->post_excerpt;		
			} else {
				$string = $post->post_content;		
			}

			$limit = get_option('ptthemes_content_excerpt_count');
			echo templ_get_excerpt($string, $limit);
		}
	}
}
add_action('templ_get_listing_content','templ_listing_content');


/*
FUNCTION NAME : templ_seo_meta_content
ARGUMENTS : None
RETURNS : Meta Content, Description and Noindex settings for SEO
*/
function templ_seo_meta_content()
{
	$description = '';
	$keywords = '';
	if (is_home() || is_front_page()) 
	{
		$description = stripslashes(get_option('ptthemes_home_desc_seo'));
		$keywords = stripslashes(get_option('ptthemes_home_keyword_seo'));
	}elseif (is_single() || is_page())
	{
		global $post;
		$description = get_post_meta($post->ID,'templ_seo_page_desc',true);
		$keywords = get_post_meta($post->ID,'templ_seo_page_kw',true);
	}else if (is_tax() || is_category() ) {
		$str_desc = str_replace(array('</p>','<br />'),',',category_description());
		$description = strip_tags($str_desc);
	}
	if(is_archive() && strtolower(get_option( 'ptthemes_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots" content="noindex" />';
	}elseif(is_tag() && strtolower(get_option( 'ptthemes_tag_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}elseif((is_archive() || is_tax() || is_category()) && strtolower(get_option('ptthemes_category_noindex'))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}
	if($description){ echo '<meta name="description" content="'.$description.'"  />';}
	if($keywords){ echo '<meta content="'.$keywords.'" name="keywords" />';}
	
}
add_action('templ_seo_meta','templ_seo_meta_content');

/*
FUNCTION NAME : templ_seo_title
ARGUMENTS : None
RETURNS : SEO page title
*/
function templ_seo_title() { 
	if(templ_is_third_party_seo()){
	}else
	{
		global $page, $paged;
		$sep = " | "; # delimiter
		$newtitle = get_bloginfo('name'); # default title
	
		# Single & Page ##################################
		if (is_single() || is_page())
		{
			global $post;
			$newtitle = get_post_meta($post->ID,'templ_seo_page_title',true);
			if($newtitle=='')
			{
				$newtitle = single_post_title("", false);
			}
		}
	
		# Category ######################################
		if (is_category())
			$newtitle = single_cat_title("", false);
	
		# Tag ###########################################
		if (is_tag())
		 $newtitle = single_tag_title("", false);
	
		# Search result ################################
		if (is_search())
		 $newtitle = __("Search Result ",'templatic') . $s;
	
		# Taxonomy #######################################
		if (is_tax()) {
			$curr_tax = get_taxonomy(get_query_var('taxonomy'));
			$curr_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); # current term data
			# if it's term
			if (!empty($curr_term)) {
				//$newtitle = $curr_tax->label . $sep . $curr_term->name;
				$newtitle = $curr_term->name;
			} else {
				$newtitle = $curr_tax->label;
			}
		}
	
		# Page number
		if ($paged >= 2 || $page >= 2)
				$newtitle .= $sep . sprintf('Page %s', max($paged, $page));

		# Home & Front Page ########################################
		if (is_home() || is_front_page()) {
			if(get_option('ptthemes_home_title_seo')){
				$newtitle = get_option('ptthemes_home_title_seo');
			}else
			{
				$newtitle = get_bloginfo('name') . $sep . get_bloginfo('description');
			}
		} else {
			$newtitle .=  $sep . get_bloginfo('name');
			
		}
		$pos = strpos($_SERVER['REQUEST_URI'], "feed");
		if($pos != '' || $pos != 0)
		{
			$newtitle = '';
		}
		return $newtitle;
	}
}
if(strtolower(get_option('ptthemes_use_third_party_data')) == 'no'){ 
		add_filter('wp_title','templ_seo_title');
}

/*
FUNCTION NAME : templ_main_header_navigation_content
ARGUMENTS : None
RETURNS : Get Header Main Menu Action Hook
*/
function templ_main_header_navigation_content()
{

	if(strtolower(get_option('ptthemes_main_pages_nav_enable'))!='deactivate'){?>
        <div class="main_nav">
            
            <div class="main_nav_in clear">
				<?php 
				/* if Uber menu not activated no need to show menu title in header */
				if(!is_plugin_active('ubermenu/ubermenu.php')) { ?>
         		<div class="currentmenu2"><span>Menu</span></div>
				<?php } ?>
            	<?php apply_filters('templ_main_header_nav_above_filter','');
				$theme_name = basename(get_template_directory());
				$nav_menu = get_option('theme_mods_'.$theme_name);
    				
                if(@$nav_menu['nav_menu_locations']['secondary'] == 0 && !is_active_widget( false, false, 'nav_menu', true) && !is_active_widget(false,false,'dc_jqmegamenu_widget',true)){
						global $wpdb; ?>
						<div class="menu-header">
						<ul class="menu sf-js-enabled" id="menu-main">
						<li class="hometab <?php if ( is_home() && @$_REQUEST['page']=='' && @$_REQUEST['ptype'] =='' ) { ?> current_page_item <?php } ?>"><a href="<?php echo home_url(); ?>/"><?php _e('Home','templatic'); ?></a></li>
						<li class="<?php if(@$page =='page'){ echo 'current-page-item';}?>" >
							<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");?>
							<a href="<?php echo get_permalink($page_id); ?>"><?php _e('Page Templates','templatic'); ?></a>
							<ul class="sub-menu">
							<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");
							wp_list_pages('title_li=&post_type=page&exclude=2,'.$page_id);?>
							</ul>
						</li>
						</ul>
						</div>
				<?php }else{
							if($nav_menu['nav_menu_locations']['secondary'] != 0)
							
							wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ));
				} 
				dynamic_sidebar('main_navigation'); /* call below header widget area */
					
				apply_filters('templ_main_header_nav_below_filter',''); ?>
				</div>
		</div>
    <?php
	}
}
add_action('templ_get_main_header_navigation','templ_main_header_navigation_content');


/*
FUNCTION NAME : templ_top_header_navigation_content
ARGUMENTS : None
RETURNS : Get Header Top Menu Action Hook
*/
function templ_top_header_navigation_content()
{
	?>
    <?php if(strtolower(get_option('ptthemes_top_pages_nav_enable'))!='deactivate'){?>
        <div class="top_navigation">
        <div class="top_navigation_in clearfix">
		
        <?php apply_filters('templ_top_header_nav_above_filter','');?>
       		   <?php if(!dynamic_sidebar('top_navigation')) {
			    $theme_name = basename(get_template_directory());
				$nav_menu = get_option('theme_mods_'.$theme_name);
			   if(isset($nav_menu['nav_menu_locations']['primary']) && $nav_menu['nav_menu_locations']['primary'] != 0)
			   {
			    ?><div class="currentmenu"><span>Menu</span></div>
         <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' )); } }?>
               
			<?php apply_filters('templ_top_header_nav_below_filter','');?>
        </div></div>
    <?php
	}
}
add_action('templ_get_top_header_navigation','templ_top_header_navigation_content');


/*
FUNCTION NAME : templ_show_facebook_button_action
ARGUMENTS : None
RETURNS : Facebook Button Detail page - Action Hook
*/
function templ_show_facebook_button_action()
{
	if(templ_is_facebook_button())
	{
		if (apply_filters('templ_facebook_button_script', true))
		{
			global $post;
			if (is_ssl()) {
				$url ="https://connect.facebook.net/en_US/all.js#xfbml=1";
			}else{
				$url ="http://connect.facebook.net/en_US/all.js#xfbml=1";
			}
			
		?>
     <div class="flike"> <div id="fb-root"></div><script src="<?php echo $url; ?>" type="text/javascript"></script><fb:like href="" send="false" layout="button_count" width="50" show_faces="false" font="arial"></fb:like></div>
        <?php	
		}
	}
}
add_action('templ_show_facebook_button','templ_show_facebook_button_action');


/*
FUNCTION NAME : templ_show_twitter_button_action
ARGUMENTS : None
RETURNS : Twitter Button Detail page - Action Hook
*/
function templ_show_twitter_button_action()
{
	if(templ_is_tweet_button())
	{
		if (apply_filters('templ_tweet_button_script', true))
		{
			if (is_ssl()) {
				$t_url ="https://twitter.com/share";
				$t2_ssl = "https://platform.twitter.com/widgets.js";
			}else{
				$t_url ="http://twitter.com/share";
				$t2_ssl ="http://platform.twitter.com/widgets.js";
			}
		?>
        <a href="<?php echo $t_url; ?>" class="twitter-share-button"><?php _e('Tweet','templatic');?></a>
		<script type="text/javascript" src="<?php echo $t2_ssl; ?>"></script> 
        <?php	
		}
	}
}
add_action('templ_show_twitter_button','templ_show_twitter_button_action');


/*
FUNCTION NAME : templ_add_site_logo
ARGUMENTS : None
RETURNS : Text as site logo with description
*/
function templ_add_site_logo()
{
	if (templ_is_show_blog_title()) 
	{  
		global $site_url;
		if ( is_home()){
			echo apply_filters('templ_blog_title_text','<div class="site-title"><h1><a href="'.$site_url.'" style="display:block; color:black; text-decoration:none; font-weight:normal; font-size:40px;">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			echo apply_filters('templ_blog_title_text','<div class="site-title"><a href="'.$site_url.'">'.get_bloginfo( 'name', 'display' ).'</a> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}
	}else
	{
		echo templ_get_site_logo();
	}	
}
add_action('templ_site_logo','templ_add_site_logo'); //site logo action + filters

/*
FUNCTION NAME : templ_get_site_logo
ARGUMENTS : None
RETURNS : Site Header logo with Hyper link
*/
function templ_get_site_logo() {
	global $site_url;
	if(get_option('ptthemes_logo_url'))
	{
		$logo_url = get_option('ptthemes_logo_url');	
	}else
	{
		$logo_url = get_bloginfo('template_directory').'/images/logo.png';
	}
    if($logo_url)
	{		
		$return_str = '<a href="'.$site_url.'">';
		$return_str .= '<img src="'.apply_filters('templ_logo',$logo_url).'" alt="" />';
		$return_str .= '</a>';
		if (is_home() && get_option('ptthemes_show_blog_title') != 'No'){ 
			$return_str .= apply_filters('templ_blog_title_text','<div class="site-title none"><h1><a href="'.$site_url.'">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			if(get_option('ptthemes_show_blog_title') != 'No'){
			$return_str .=apply_filters('templ_blog_title_text','<div class="site-title none" ><a href="'.$site_url.'">'.get_bloginfo( 'name', 'display' ).'</a>
			<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
			}
		}	
	}
    return apply_filters( 'templ_get_site_logo', $return_str );
}


/*
FUNCTION NAME : templ_home_page_slider
ARGUMENTS : None
RETURNS : Widgets of Slider Above,Home Slider and Slider Below for home page
*/
function templ_home_page_slider()
{
	do_action('templ_slider_above');
	if (apply_filters('templ_home_page_slider_filter', true))
	{
		if (function_exists('dynamic_sidebar')){ dynamic_sidebar('home_slider'); }
	}
	do_action('templ_slider_below');
}

/*
FUNCTION NAME : get_currency_sym
ARGUMENTS : None
RETURNS : Currency symbol for the system
*/
if(!function_exists('get_currency_sym'))
{
	function get_currency_sym()
	{
		if(get_option('ptthemes_default_currency_symbol'))
		{
			return get_option('ptthemes_default_currency_symbol');	
		}
		return '$';
	}
}

/*
FUNCTION NAME : get_currency_code
ARGUMENTS : None
RETURNS : Currency code for the system
*/
if(!function_exists('get_currency_code'))
{
	function get_currency_code()
	{
		if(get_option('currency_symbol'))
		{
			return get_option('currency_symbol');	
		}
		return 'USD';
	}
}

/*
FUNCTION NAME : bdw_get_images_with_info
ARGUMENTS : posi id and image size
RETURNS : Retung the post images with attachement information
*/
function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}
/* Rerturns user currently in admin area or in front end */
function is_wp_admin()
{
	if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	{
		return true;
	}
	return false;
}

add_action("admin_head", "templ_add_admin_custom_css");
function templ_add_admin_custom_css()
{?>
 <link rel="stylesheet" type="text/css" media="all" href="<?php echo TT_ADMIN_FOLDER_URL; ?>admin_style.css" />
<?php
}
?>