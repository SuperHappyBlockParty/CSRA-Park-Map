<?php global $wpdb;
add_action('init', 'callback_on_init');
function callback_on_init()
{
    if (is_author() || (isset($_REQUEST['s']) && $_REQUEST['s'] != '') || @$_REQUEST['list'] =='favourite') {
        add_action('pre_get_posts', 'custom_post_author_archive');
    }
    add_action('pre_get_posts', 'search_filter');
    /* filter for different pages & feature in frontend */
}
/*
Name : search_post_status
Description : search page not show the post have draft status
*/
function search_post_status($where){
	global $wpdb;
	$where .= " AND $wpdb->posts.post_status != 'draft'";
	return $where; 
}
/*
Name : search_filter
Desc : filter for look results as per city + as per feature ordering
*/
function search_filter($local_wp_query) {
	if(isset($_REQUEST['sn']) && $_REQUEST['sn'] !=""){
	$sn = $_REQUEST['sn']; }
	/* apply filters only when user searching/sorting or in author page */
	if((isset($_REQUEST['sn']) && $_REQUEST['sn'] != "") || (isset($_REQUEST['s']) && $_REQUEST['s'] != "") || isset($_REQUEST['sort']) || isset($_REQUEST['etype']) || isset($_REQUEST['list']) || is_author()) { 
		if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && is_search() ){ 
			add_action('posts_where','search_post_status');
			if($_REQUEST['as'] !='' || $_REQUEST['adv_search'] !=''){
			add_filter('posts_where', 'searching_filter_where');
			}
			if($_REQUEST['s']=='cal_event'){
				add_filter('posts_where', 'search_cal_event_where');
			}else if(isset($_REQUEST['t']) && $_REQUEST['t'] != "") {
				add_filter('posts_orderby', 'feature_listing_orderby');
			}
		}else if(is_author())	{ 
			global $current_user,$wp_query;
			$qvar = $wp_query->query_vars;
			$authname = $qvar['author_name'];
			$nicename = $current_user->user_nicename;
			if(($authname == $nicename) || ($_REQUEST['author']== $current_user->ID))
			{	
				add_filter('posts_where', 'author_filter_where');
				add_filter('posts_orderby', 'author_filter_orderby');
			}else
			{

					add_filter('posts_where', 'author_filter_where');
			
				remove_filter('posts_orderby', 'author_filter_orderby');
				remove_filter('posts_where', 'searching_filter_where');	
			}
		} else {
			if($_REQUEST['sort'] == 'rating' || $_REQUEST['etype'] !="" || $_REQUEST['sort'] == 'review'){
			add_filter('posts_where', 'searching_filter_where');
			ratings_sorting($local_wp_query);
			}			
		}
	} else {
		if(is_tax() || is_home()){
			 /* apply filters only when it's taxonomy page */
			 global $wpdb,$wp_query;
			$current_term = $wp_query->get_queried_object();

			if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE2 || is_home())
			{ 
				add_filter('posts_where', 'searching_filter_where');	
				add_filter('posts_where', 'event_where');					
			}
			
			if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE1)
			{ 
				add_filter('posts_where', 'searching_filter_where');	
			}
			if($current_term->taxonomy == CUSTOM_TAG_TYPE2){
				add_filter('posts_where', 'event_where');		
			}			
			add_filter('posts_orderby', 'feature_listing_orderby');
		}
		
	}
}

/*
Name :custom_post_author_archive
Desc : Filter to set the posttype on author page and when searching 
*/
function custom_post_author_archive( &$query )
{
   // if ( $query->is_author )
	if(@$_REQUEST['t'] !='' && is_search()){
    $query->set('post_type', array('place', 'event','attachment'));
	}else if(@$_REQUEST['list'] =='favourite'){
	 $query->set('post_type', array('place', 'event','attachment'));
	}else{
	$query->set('post_type', array('post','place', 'event','attachment'));
	}
    $query->set('post_status', array('publish', 'draft'));
    $query->set('post_city_id',$_SESSION['multi_city']);
	if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/')) {
		add_filter('posts_orderby', 'archive_filter_orderby');
	}
    remove_action( 'pre_get_posts', 'custom_post_author_archive' ); // run once!
	
}
/*
Name :ratings_sorting
Desc : Return ordering as per rating of the post
*/
function ratings_sorting($local_wp_query) {
global $wp_query, $post;
		$current_term = $wp_query->get_queried_object();
		$blog_cat = get_blog_sub_cats_str($type='array');
	
		if(in_array($current_term->term_id,$blog_cat))
		{
			add_filter('posts_orderby', 'blog_filter_orderby');	
			remove_filter('posts_orderby', 'review_highest_orderby');
			remove_filter('posts_where', 'event_where');
		}else {
			add_filter('posts_where', 'event_where');
			if($_REQUEST['sort']=='review') { 
				add_filter('posts_orderby', 'review_highest_orderby');
				remove_filter('posts_orderby', 'ratings_most_orderby');
			} elseif($_REQUEST['sort']=='rating') {
				add_filter('posts_orderby', 'ratings_most_orderby');
				remove_filter('posts_orderby', 'review_highest_orderby');	
			}else	{
				add_filter('posts_orderby', 'archive_filter_orderby');
				remove_filter('posts_orderby', 'ratings_most_orderby');
				remove_filter('posts_orderby', 'review_highest_orderby');
			}
		}
}

/*
Name : archive_filter_orderby
Desc : feature listing order by in archive pages
*/
function archive_filter_orderby($orderby) {
	global $wpdb,$wp_query;
	$current_term = $wp_query->get_queried_object();
	if(!isset($_REQUEST['sort']) && @$_REQUEST['sort'] == ""){
	if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE2)
	{ 
		if(get_option('ptthemes_listing_order') == ALPHA_ORDER_TEXT ){ 
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.post_title ASC";	
		}else if(get_option('ptthemes_listing_order') == RANDOM_ORDER_TEXT) {  
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,rand()";
		}else{ 
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,$wpdb->posts.ID DESC";	
		}
	}else{
		if(get_option('ptthemes_listing_order') == ALPHA_ORDER_TEXT){
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.post_title asc";	
		 }else if(get_option('ptthemes_listing_order') == RANDOM_ORDER_TEXT) { 
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,rand()";
		 }else{  
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.ID DESC";	
		 }
	}
	}
	return $orderby;	
}

/*
Name : event_where
Desc : call a function when click on day in calender to see the events
*/
function event_where($where)
{
	global $wpdb,$wp_query;
	$current_term = $wp_query->get_queried_object();
	if(is_tax()){
		if($current_term->taxonomy == CUSTOM_TAG_TYPE2){
			if($_REQUEST['etype']=='upcoming'){
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')>='".$today."')) ";
			}elseif($_REQUEST['etype']=='past'){
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')<='".$today."')) ";
			}
		}
		if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE2){	
			if($_REQUEST['etype']=='upcoming'){
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')>='".$today."')) ";
				
			}elseif($_REQUEST['etype']=='past'){
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')<='".$today."')) ";
			}
		}
	}elseif(is_archive())
	{ 
		global $wp_query, $post;
		$current_term = $wp_query->get_queried_object();
		$blog_cat = get_blog_sub_cats_str($type='array');
		if($_SESSION['multi_city'])
		{
			$multi_city_id = $_SESSION['multi_city'];
			$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))) ";
		}
		if($current_term->taxonomy == CUSTOM_CATEGORY_TYPE2)
		{	
			if($_REQUEST['etype']=='')
			{
				$_REQUEST['etype']='upcoming';
			}
			if($_REQUEST['etype']=='upcoming')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')>='".$today."')) ";
				
			}elseif($_REQUEST['etype']=='past')
			{
				$today = date('Y-m-d');
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='end_date' and date_format($wpdb->postmeta.meta_value,'%Y-%m-%d %H:%i')<='".$today."')) ";
			}
		}
	}
	return $where;
}
/*
Name : ratings_most_orderby
desc : order by as per most comments/reviews
*/
function review_highest_orderby($content) {
	global $wpdb;
	$orderby = 'desc';
	$content = "comment_count $orderby,(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"is_featured\")+0 desc";
	return $content;
}
/*
Name : ratings_most_orderby
desc : order by filter most rated posts comes first
*/
function ratings_most_orderby($content) {
	global $wpdb,$rating_table_name;
	$content = "(select avg(rt.rating_rating) as rating_counter from $rating_table_name as rt where rt.comment_id in (select cm.comment_ID from $wpdb->comments cm where cm.comment_post_ID=$wpdb->posts.ID and cm.comment_approved=1)) desc, comment_count desc";
	return $content;	
}
/*
Name : blog_filter_orderby
desc : order by filter for blog listing page
*/
function blog_filter_orderby($content)
{
	global $wpdb;
	return "$wpdb->posts.post_date DESC,$wpdb->posts.post_title ";
}
/*
Name : search_cal_event_where
Description : where filter to show events on day we selected from calendar
*/
function search_cal_event_where($where)
{
	global $wpdb,$wp_query;
	$m = $wp_query->query_vars['m'];
	$py = substr($m,0,4);
	$pm = substr($m,4,2);
	$pd = substr($m,6,2);
	$the_req_date = "$py-$pm-$pd";
	$event_of_month_sql = $wpdb->get_col("select p.ID from $wpdb->posts p where p.post_type in ('".CUSTOM_POST_TYPE2."','attachment') and p.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'st_date' and pm.meta_value <= \"$the_req_date\" and pm.post_id in ((select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'end_date' and pm.meta_value>=\"$the_req_date\"))) ");
	$multi_city_id = $_SESSION['multi_city'];
	$event_of_month_sql1 = $wpdb->get_col("select p.ID from $wpdb->posts p where p.post_type in ('".CUSTOM_POST_TYPE2."','attachment') AND  p.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0')) ");
	$tq = array_intersect($event_of_month_sql,$event_of_month_sql1);

	if(count($tq) >0){
		$total_id = implode(',',$tq);
	}else{
		$total_id = $tq[0];
	}	
	$where = " AND $wpdb->posts.post_type in ('".CUSTOM_POST_TYPE2."','attachment') AND $wpdb->posts.ID in ($total_id) and $wpdb->posts.post_status in ('publish','private','attachment') ";
	return $where;
}

/*
Name : feature_listing_orderby
Description : Order by filter for different pages with different options BOF 
*/
function feature_listing_orderby($orderby) {
	global $wpdb,$current_term;	
	$post_type = get_post_type();
	if(isset($current_term) && $current_term->taxonomy == CUSTOM_CATEGORY_TYPE2)
	{ 
		if(get_option('ptthemes_listing_order') == ALPHA_ORDER_TEXT ){ 
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.post_title ASC";	
		}else if(get_option('ptthemes_listing_order') == RANDOM_ORDER_TEXT) {  
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,rand()";
		}else{ 
		$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"st_date\") asc,$wpdb->posts.ID DESC";	
		}
	}else{
	$orderby = '';
		if(is_home()){
			if(get_option('ptthemes_listing_order') == ALPHA_ORDER_TEXT){
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"home_featured_type\") asc,$wpdb->posts.post_title asc";	
			}else if(get_option('ptthemes_listing_order') == RANDOM_ORDER_TEXT) { 
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"home_featured_type\") ASC,rand()";
			} else {
				$orderby.= "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"home_featured_type\") asc,$wpdb->posts.ID DESC";	
			}
		}else{
		 if(get_option('ptthemes_listing_order') == ALPHA_ORDER_TEXT){
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.post_title asc";	
		 }else if(get_option('ptthemes_listing_order') == RANDOM_ORDER_TEXT) { 
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") ASC,rand()";
			
		 }else{  
			$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\") asc,$wpdb->posts.ID DESC";	
		 }
		 }
	}

	return $orderby;	
}
/*
Name : author_filter_where
Description : author page filter for favourite posts listing and author sumitions
*/
function author_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	
	$where = '';
	$query_var = $wp_query->query_vars;
	$user_id = $query_var['author'];
	$post_ids = get_user_meta($current_user->ID,'user_favourite_post',true);
	$final_ids = '';
	if($post_ids)
	  {
		  $post_ids = implode(",",$post_ids);
	  }

	$qvar = $wp_query->query_vars;
	$authname = $qvar['author_name'];
	$curauth = get_userdata($qvar['author']);
	$nicename = $current_user->user_nicename;
	if($curauth->ID == $current_user->ID)
	{ 
		$post_status = " ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'attachment')";
		
	}else{
		if ($curauth->ID == $current_user->ID ) {
			$post_status = " ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'attachment')";
		}else{
			$post_status = " ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'attachment')";
		}
	}

	if($_REQUEST['list']=='favourite')	{
		$where .= " AND ($wpdb->posts.ID in ($post_ids)) AND ($wpdb->posts.post_type in('place','event','attachment') OR $wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."' OR  $wpdb->posts.post_type = '".CUSTOM_POST_TYPE2."') AND  $post_status";			
	}else
	{	
		if(is_plugin_active('wpml-string-translation/plugin.php')){
			$language = ICL_LANGUAGE_CODE;
			$where = " AND ($wpdb->posts.post_author = $user_id) AND ( $wpdb->posts.post_type ='place' OR $wpdb->posts.post_type ='event' ) AND $post_status  AND t.language_code='".$language."'";
		}else{
			$where = " AND ($wpdb->posts.post_author = $user_id) AND ( $wpdb->posts.post_type ='place' OR $wpdb->posts.post_type ='event' ) AND $post_status";
		}
	}

	return $where;
	
}
/* 
Name : searching_filter_where
description : function for filtering posts as per user search and as per city
*/
function searching_filter_where($where) {

	global $wpdb;
	if(isset($_REQUEST['sn']) && $_REQUEST['sn'] !=''){
		$sn = trim($_REQUEST['sn']);
	}else{ $sn =''; }
	
	if(isset($_REQUEST['s']) && $_REQUEST['s'] !=''){
		$s = trim($_REQUEST['s']);
	}else{ $s=''; }
	
	if(isset($_REQUEST['catdrop']) && $_REQUEST['catdrop'] !=''){
		$scat = trim($_REQUEST['catdrop']);
	}else{ $scat =''; }
	
	if(isset($_REQUEST['tag_s']) && $_REQUEST['tag_s'] !=''){
		$stag = trim($_REQUEST['tag_s']);
	}else{ $stag =''; }
	
	if(isset($_REQUEST['todate']) && $_REQUEST['todate'] !=''){
		$todate = trim($_REQUEST['todate']);
	}else{ $todate =''; }
	
	if(isset($_REQUEST['frmdate']) && $_REQUEST['frmdate'] !=''){
		$frmdate = trim($_REQUEST['frmdate']);
	}else{ $frmdate =''; }
	
	if(isset($_REQUEST['articleauthor']) && $_REQUEST['articleauthor'] !=''){
		$articleauthor = trim($_REQUEST['articleauthor']);
	}else{
		$articleauthor = '';
	}
	
	if(isset($_REQUEST['exactyes']) && $_REQUEST['exactyes'] !=''){
		$exactyes = trim($_REQUEST['exactyes']);
	}else{ $exactyes = ''; }

	if($_SESSION['multi_city'])
	{	if(isset($_REQUEST['sn']) && $_REQUEST['sn'] !=''){
		$multi_city_name = $_REQUEST['sn'];
		}else{ $multi_city_name =''; }
		$citytable = $wpdb->prefix."multicity";
		/* fetch city ID from searched city name */
		if($multi_city_name){
			$cityid = $wpdb->get_row("select * from $citytable where cityname LIKE '%".$multi_city_name."%'");
			$multi_city_id = $cityid->city_id;
		}else{
			$multi_city_id = $_SESSION['multi_city'];
		}
		if($multi_city_id == ''){
			$multi_city_id = $_SESSION['multi_city'];
		
		}
		if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
			$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))) AND $wpdb->posts.post_status='publish' ";
		} else { 
			 /* search as per address */
			if($sn !=""){
			$qry = " AND $wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='geo_address' and $wpdb->postmeta.meta_value like \"%$sn%\") ";
			}else{ $qry='';	}
			/* city search if find cityname in table else search in default city   */
			if($multi_city_name !=""){
			
				$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or  $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\") $qry )) AND $wpdb->posts.post_status='publish' ";
			}else{
				$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or  $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\") $qry ))";
			}
			if($todate!="" && $frmdate!="")
			{
				$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') BETWEEN '".$todate."' and '".$frmdate."'";
			}else if($scat>0)
			{
				 /* filtering for sorting as per start date and enddate of event*/
				$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
			}else if($stag >0)
			{
				/* filtering for sorting as per satgs you entered */
				$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$stag\" ) ";
			}
			else if($todate!="")
			{
				$where .= " AND   DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') >='".$todate."'";
			}
		}
	}else if($scat>0)
	{
		 /* filtering for category wise search*/
		$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
	}else if($stag >0)
			{
				$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$stag\" ) ";
			}
	else if($todate!="")
	{
		$where .= " AND   DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') >='".$todate."'";
	}
	else if($frmdate!="")
	{
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') <='".$frmdate."'";
	}
	else if($todate!="" && $frmdate!="")
	{
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') BETWEEN '".$todate."' and '".$frmdate."'";
	}
	 if ($articleauthor != "") {
        /* advance search - if enter exact author name && select exact author or not  */
        if ($exactyes == 1) {
            $where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  = '" . $articleauthor . "') ";
        } else {
            $where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  like '" . $articleauthor . "') ";
        }
    }
	  /* custom field wise searching */
	$serch_post_types = "'place','event','attachment'";
	$custom_metaboxes = get_post_custom_fields_templ($serch_post_types,'','user_side','1');
	foreach($custom_metaboxes as $key=>$val) {
	$name = $key;
		if(isset($_REQUEST[$name]) && $_REQUEST[$name] !=''){ 
			$value = $_REQUEST[$name];
			if($name == 'proprty_desc' || $name == 'event_desc'){
				$where .= " AND ($wpdb->posts.post_content like \"%$value%\" )";
			} else if($name == 'property_name'){
				$where .= " AND ($wpdb->posts.post_title like \"%$value%\" )";
			}else {
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='$name' and ($wpdb->postmeta.meta_value like \"%$value%\" ))) ";
				/* Placed "AND" instead of "OR" because of Vedran said results are ignoring address field */
			}
		}
	}
	
	 /* Added for tags searching */
	if(is_search() && !@$_REQUEST['catdrop']){
	$where .= " OR  ($wpdb->posts.ID in (select p.ID from $wpdb->terms c,$wpdb->term_taxonomy tt,$wpdb->term_relationships tr,$wpdb->posts p ,$wpdb->postmeta t where c.name like '".$s."' and c.term_id=tt.term_id and tt.term_taxonomy_id=tr.term_taxonomy_id and tr.object_id=p.ID and p.ID = t.post_id and p.post_status = 'publish' group by  p.ID)) AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or  $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\") $qry )) AND $wpdb->posts.post_status='publish'";
	}

	return $where;
}

/*
Name :author_filter_orderby
Desc : Return orderby filter for author page 
*/
function author_filter_orderby($orderby) {
	global $wpdb;
	$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key like \"featured_type\")+0 desc"; 
	
	return $orderby;
}

/*
Name : popular_posts_where
Description : return popular posts city wise */
function popular_posts_where($where){

		$multi_city_id = $_SESSION['multi_city'];
		global $wpdb;

		if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/')){
			$where .= " AND  ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='post_city_id' and ($wpdb->postmeta.meta_value like \"%,$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"$multi_city_id,%\" or $wpdb->postmeta.meta_value like \"%,$multi_city_id\" or $wpdb->postmeta.meta_value like \"$multi_city_id\" or $wpdb->postmeta.meta_value='' or $wpdb->postmeta.meta_value='0'))) AND $wpdb->posts.post_status='publish' ";
		}
		return $where;
}

?>