<?php
//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type
//----------------------------------------------------------------------//

add_action("init", "custom_posttype_menu_wp_admin");
function custom_posttype_menu_wp_admin()
{
//===============Place Listing SECTION START================
$custom_post_type = CUSTOM_POST_TYPE1;
$custom_cat_type = CUSTOM_CATEGORY_TYPE1;
$custom_tag_type = CUSTOM_TAG_TYPE1;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM,
														'edit' 					=>  CUSTOM_MENU_EDIT,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM,
														'new_item' 				=>  CUSTOM_MENU_NEW,
														'view_item'				=>  CUSTOM_MENU_VIEW,
														'search_items' 			=>  CUSTOM_MENU_SEARCH,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), // Permalinks
						'query_var' 		=> "$custom_post_type", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);

// Register custom taxonomy
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME,	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD,	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);


add_filter( 'manage_edit-place_columns', 'templatic_edit_place_columns' ) ;

function templatic_edit_place_columns( $columns ) {

	unset($columns['comments']);
	unset($columns['date']);
 
	$columns['post_city_id'] = __( 'City' );
	$columns['geo_address'] = __( 'Address' );
	$columns['post_category'] = __( 'Categories' );
	$columns['post_tags'] = __( 'Tags' );
	$columns['date'] = __( 'Date' );

	return $columns;
}

add_action( 'manage_place_posts_custom_column', 'templatic_manage_place_columns', 10, 2 );

function templatic_manage_place_columns( $column, $post_id ) {
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {
	case 'post_category' :
			/* Get the post_category for the post. */
			
			$templ_places = get_the_terms($post_id,CUSTOM_CATEGORY_TYPE1);
			if (is_array($templ_places)) {
				foreach($templ_places as $key => $templ_place) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_CATEGORY_TYPE1."=".$templ_place->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_places[$key] = '<a href="'.$edit_link.'">' . $templ_place->name . '</a>';
				}
				echo implode(' , ',$templ_places);
			}else {
				_e( 'Uncategorized' ,'templatic');
			}

			break;
			
		case 'post_tags' :
			/* Get the post_tags for the post. */
			$templ_place_tags = get_the_terms($post_id,CUSTOM_TAG_TYPE1);
			if (is_array($templ_place_tags)) {
				foreach($templ_place_tags as $key => $templ_place_tag) {
					$edit_link = home_url()."/wp-admin/edit.php?".CUSTOM_TAG_TYPE1."=".$templ_place_tag->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_place_tags[$key] = '<a href="'.$edit_link.'">' . $templ_place_tag->name . '</a>';
				}
				echo implode(' , ',$templ_place_tags);
			}else {
				_e( '','templatic' );
			}
				
			break;
		case 'post_city_id' :
			/* Get the address for the post. */
			$post_city_name='';
			 $post_city_id = get_post_meta( $post_id, 'post_city_id', true );
				if($post_city_id != ''&& !strstr($post_city_id,',')){
					$post_city_name = get_city_name($post_city_id);
				}elseif(strstr($post_city_id,',')){
					$postcityid = explode(',',$post_city_id);
					for($ci = 0; $ci < count($postcityid); $ci++){
						if($ci == (count($postcityid)-1)){
						$sep =' ';
						}else{ $sep =",";}
						$post_city_name .= get_city_name($postcityid[$ci]).$sep;
					}	
				}else {
					$post_city_name = ' ';
				}
				echo $post_city_name;
			break;
		case 'geo_address' :
			/* Get the address for the post. */
			$geo_address = get_post_meta( $post_id, 'geo_address', true );
				if($geo_address != ''){
					$geo_address = $geo_address;
				} else {
					$geo_address = ' ';
				}
				echo $geo_address;
			break;

	
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
add_filter( 'manage_edit-place_sortable_columns', 'templatic_place_sortable_columns' );
function templatic_place_sortable_columns( $columns ) {
	$columns['post_category'] = 'Categories';
	$columns['post_city_id'] = 'City';
	$columns['geo_address'] = 'Address';
	return $columns;
}

//////////////////////////////////////////////////////////////////////////////////////
//===============Events Listing SECTION START================
$custom_post_type = CUSTOM_POST_TYPE2;
$custom_cat_type = CUSTOM_CATEGORY_TYPE2;
$custom_tag_type = CUSTOM_TAG_TYPE2;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE2,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME2,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME2,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW2,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM2,
														'edit' 					=>  CUSTOM_MENU_EDIT2,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM2,
														'new_item' 				=>  CUSTOM_MENU_NEW2,
														'view_item'				=>  CUSTOM_MENU_VIEW2,
														'search_items' 			=>  CUSTOM_MENU_SEARCH2,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND2,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH2),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), // Permalinks
						'query_var' 		=> "$custom_post_type", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);

// Register custom taxonomy
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL2, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE2,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT2,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH2,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH2,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL2,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT2,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL2,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT2,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE2,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW2,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME2,	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL2, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE2,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME2,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH2,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR2,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL2,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT2,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL2,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT2,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE2,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW2,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD2,),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);


}
add_filter( 'manage_edit-event_columns', 'templatic_edit_event_columns' ) ;

function templatic_edit_event_columns( $columns ) {

	unset($columns['comments']);
	unset($columns['date']);
 
	$columns['post_city_id'] = __( 'City' );
	$columns['geo_address'] = __( 'Address' );
	$columns['start_timing'] = EVENT_ST_TIME;
	$columns['end_timing'] = EVENT_END_TIME;
	$columns['post_category'] = __( 'Categories' );
	$columns['post_tags'] = __( 'Tags' );
	$columns['date'] = __( 'Date' );
	return $columns;
}

add_action( 'manage_event_posts_custom_column', 'templatic_manage_event_columns', 10, 2 );

function templatic_manage_event_columns( $column, $post_id ) {
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {
	case 'post_category' :
			/* Get the post_category for the post. */
			$templ_events = get_the_terms($post_id,CUSTOM_CATEGORY_TYPE2);
			if (is_array($templ_events)) {
				foreach($templ_events as $key => $templ_event) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_CATEGORY_TYPE2."=".$templ_event->slug."&post_type=".CUSTOM_POST_TYPE2;
					$templ_events[$key] = '<a href="'.$edit_link.'">' . $templ_event->name . '</a>';
					}
				echo implode(' , ',$templ_events);
			}else {
				_e( 'Uncategorized' );
			}
			break;
			
		case 'post_tags' :
			/* Get the post_tags for the post. */
			$templ_event_tags = get_the_terms($post_id,CUSTOM_TAG_TYPE2);
			if (is_array($templ_event_tags)) {
				foreach($templ_event_tags as $key => $templ_event_tag) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_TAG_TYPE2."=".$templ_event_tag->slug."&post_type=".CUSTOM_POST_TYPE2;
					$templ_event_tags[$key] = '<a href="'.$edit_link.'">' . $templ_event_tag->name . '</a>';
				}
				echo implode(' , ',$templ_event_tags);
			}else {
				_e( '' );
			}
				
			break;
		case 'post_city_id' :
			/* Get the address for the post. */
			 $post_city_id = get_post_meta( $post_id, 'post_city_id', true );
				if($post_city_id != ''){
					$post_city_id = get_city_name($post_city_id);
				} else {
					$post_city_id = ' ';
				}
				echo $post_city_id;
			break;
		case 'geo_address' :
			/* Get the address for the post. */
			$geo_address = get_post_meta( $post_id, 'geo_address', true );
				if($geo_address != ''){
					$geo_address = $geo_address;
				} else {
					$geo_address = ' ';
				}
				echo $geo_address;
			break;
		case 'start_timing' :
			/* Get the start_timing for the post. */
			$st_date = get_post_meta( $post_id, 'st_date', true );
				if($st_date != ''){
					$st_date = $st_date.' '.get_post_meta( $post_id, 'st_time', true );
				} else {
					$st_date = ' ';
				}
				echo $st_date;
			break;
		case 'end_timing' :
			/* Get the end_timing for the post. */
			$end_date = get_post_meta( $post_id, 'end_date', true );
				if($end_date != ''){
					$end_date = $end_date.' '.get_post_meta( $post_id, 'end_time', true );
				} else {
					$end_date = ' ';
				}
				echo $end_date;
			break;
		
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
add_filter( 'manage_edit-event_sortable_columns', 'templatic_event_sortable_columns' );
function templatic_event_sortable_columns( $columns ) {
	$columns['post_category'] = 'Categories';
	$columns['post_city_id'] = 'City';
	$columns['geo_address'] = 'Address';
	$columns['start_timing'] = 'Start time';
	$columns['end_timing'] = 'End time';
	return $columns;
}
//===============Event Listing END================
/////The filter code to get the custom post type in the RSS feed
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');

function get_city_name($city_id){
	global $wpdb,$multicity_db_table_name;
	$city_qry = $wpdb->get_row("select cityname from $multicity_db_table_name where city_id = '".$city_id."'");
	return $city_qry->cityname;
}
?>