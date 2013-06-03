<?php error_reporting(0);

global $theme_name;
$theme_name = basename(get_stylesheet_directory_uri());


if( !class_exists('WPUpdatesGeoPlacesUpdater') ) {
    class WPUpdatesGeoPlacesUpdater {
    
		var $api_url;		
		var $theme_slug;
		function GeoPlaces_clear_update_transient() {

			delete_transient( $theme_name.'-update' );
		}
		function __construct( $api_url,  $theme_slug ) {
			global $theme_name;
			$this->api_url = $api_url;    		
			$this->theme_slug = $theme_slug;
			if(is_multisite())
			{
				add_action( 'load-themes.php', 'wp_update_themes' );	
			}
			
			add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'GeoPlaces_check_for_update_') );
			add_action( 'after_theme_row_'.$theme_name, array(&$this, 'GeoPlaces_child_theme_row') );
			// This is for testing only!
			//set_site_transient('update_themes', null);
			if(!strstr($_SERVER['REQUEST_URI'],'plugin-install.php') && !strstr($_SERVER['REQUEST_URI'],'update.php'))
			{
				add_filter( 'plugins_api_result', array(&$this, 'debug_result'), 10, 3 );
				add_action( 'load-update-core.php', array(&$this,'GeoPlaces_clear_update_transient') );
				add_action( 'load-themes.php', array(&$this, 'GeoPlaces_clear_update_transient') );
				if(!strstr($_SERVER['REQUEST_URI'],'/network/')){
					add_action( 'admin_notices', array(&$this, 'GeoPlaces_child_update_nag') );
				}
				delete_transient( $theme_name.'-update' );
				add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
			}
		}
    	
		function GeoPlaces_child_update_nag($transient) {
			global $theme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_stylesheet_directory());
    		$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');			
			$theme_version = $theme_data['Version'];
			$remote_version = (!empty($update_themes) && $update_themes!="" && !empty($update_themes->response))?$update_themes->response[$theme_name]['new_version']:$theme_response[$theme_name]['new_version'];			
			//compare theme version				
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
				echo '<div id="update-nag">';
				 $new_version = version_compare($theme_version, $remote_version, '<') ? __('There is a new version of GeoPlaces available.', T_DOMAIN) .' <a class="thickbox" title="GeoPlaces Forms" href="http://templatic.com/members/mydownloads/GeoPlaces/theme/change_log.txt">'. sprintf(__('View version %s Details', T_DOMAIN), $remote_version) . '</a>. ' : '';		  			
			          $theme_name = basename(get_stylesheet_directory_uri());
					//$ajax_url = esc_url( add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
					$ajax_url=site_url('/wp-admin/admin.php?page=GeoPlaces_tmpl_theme_update');
					$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$theme_name, 'upgrade-theme_' . $theme_name);
					echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version . __( 'or <a href="'.$ajax_url.'" title="GeoPlaces Update">update now</a>.', T_DOMAIN) .'</div></td>';
				echo '</div>';
			}

		}

	
		function GeoPlaces_check_for_update_( $transient ) {
			global $theme_response,$wp_version;
			if (empty($transient->checked)) return $transient;
			
			$request_args = array(
				'slug' => $this->theme_slug,
				'version' => $transient->checked[$this->theme_slug]
				);
			$request_string = $this->GeoPlaces_prepare_request( 'templatic_theme_update', $request_args );
			$raw_response = wp_remote_post( $this->api_url, $request_string );			
			$response = null;
			if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) )
				$response = json_decode($raw_response['body']);
			
			if( !empty($response) ) {// Feed the update data into WP updater
				$transient->response[$this->theme_slug] = (array)$response; 
				$theme_response[$this->theme_slug] = (array)$response; 			
				update_option($this->theme_slug.'_theme_version',$theme_response);
			}	
			return $transient;
		}        
		
		
		/*
		 * add action for set the auto update for tevolution plugin
		 * Functio Name: tevolution_plugin_row
		 * Return : Display the plugin new version update message
		 */
		function GeoPlaces_child_theme_row()
		{
			global $theme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_stylesheet_directory());
    		$theme_data = get_theme_data(get_stylesheet_directory().'/style.css');			
			$theme_version = $theme_data['Version'];
			$theme_name=$theme_data['Name'];
			$remote_version = (!empty($update_themes) && $update_themes!="")?$update_themes->response[$theme_name]['new_version']:$theme_response[$theme_name]['new_version'];			
			//compare theme version			
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
			   	echo '<div id="update-nag">';
				 $new_version = version_compare($theme_version, $remote_version, '<') ? __('There is a new version of GeoPlaces available.', T_DOMAIN) .' <a class="thickbox" title="GeoPlaces Forms" href="http://templatic.com/members/mydownloads/GeoPlaces/theme/change_log.txt">'. sprintf(__('View version %s Details', T_DOMAIN), $remote_version) . '</a>. ' : '';		  			
			          $theme_name = basename(get_stylesheet_directory_uri());
					//$ajax_url = esc_url( add_query_arg( array( 'slug' => $theme_name, 'action' => $theme_name , '_ajax_nonce' => wp_create_nonce( $theme_name ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
					$ajax_url=site_url('/wp-admin/admin.php?page=GeoPlaces_tmpl_theme_update');
					$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$theme_name, 'upgrade-theme_' . $theme_name);
					echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version . __( 'or <a href="'.$ajax_url.'" title="GeoPlaces Update">update now</a>.', T_DOMAIN) .'</div></td>';
				echo '</div>';
	
			}
		}
		
		function GeoPlaces_prepare_request( $action, $args ) {
			global $wp_version;
			
			return array(
				'body' => array(
					'action' => $action, 
					'request' => serialize($args),
					'api-key' => md5(get_bloginfo('url'))
				),
				'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
			);	
		}//finish the prepare requst function

    }
}

?>