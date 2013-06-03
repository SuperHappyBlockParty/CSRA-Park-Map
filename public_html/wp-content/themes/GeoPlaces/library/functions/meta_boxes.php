<?php
/********************************************************************
You can add your metaboxes in this file and it will affected in post area.
********************************************************************/
/* function to perform widget results */
	function meta_options(){ 
		global $wpdb,$post,$claim_db_table_name;
		
		if($_REQUEST['verified'] == 'yes')
		{	
			$clid = $_REQUEST['clid'];
			$wpdb->get_results("Update $claim_db_table_name set status ='1' where clid = '".$clid."'");
			update_post_meta($post->ID,'is_verified',1);
		}else if($_REQUEST['verified'] == 'no'){
			$clid = $_REQUEST['clid'];
			$wpdb->get_results("DELETE FROM $claim_db_table_name where clid = '".$clid."'");
			update_post_meta($post->ID,'is_verified',0);
		}
		if($_REQUEST['vpid'] == 1)
		{
			$wpdb->query("INSERT INTO $claim_db_table_name(`clid`, `post_id`, `post_title`, `user_id`, `full_name`, `your_email`, `contact_number`, `your_position`, `author_id`,`status`, `comments`) VALUES (NULL, '".$post->ID."', '".$post->post_title."', '', '', '', '', '', '".$post->post_author."', '1', '')");
			update_post_meta($post->ID,'is_verified',1);
		}
		$claimreq = $wpdb->get_row("select * from $claim_db_table_name where post_id = '".$post->ID."' and status = '1'");
		if(mysql_affected_rows() > 0 || get_post_meta($post->ID,'is_verified',true) == '1')
		{ ?>
		<h4><img src="<?php echo get_template_directory_uri(); ?>/images/verified.png" alt="<?php echo YES_VERIFIED;?>" border="0" align="middle" style="position:relative; top:-4px; margin-right:5px;" /> <?php echo POST_VERIFIED_TEXT; ?></h4>
		<a href="<?php echo home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&verified=no&clid='.$claimreq->clid;?>" title="<?php echo REMOVE_CLAIM_REQUEST; ?>"><?php echo REMOVE_CLAIM_REQUEST; ?></a>
	<?php }else{ echo "<p>" . NO_CLAIM . "<p/>"; ?>
		<a href="<?php echo home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&verified=yes&vpid=1';?>" title="<?php echo CLAIM_THIS; ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/images/accept.png" alt="<?php echo VERIFY_THIS; ?>" border="0" style="position:relative; top:-4px; margin-right:10px; float:left;" />  <strong><?php echo VERIFY_THIS; ?></strong></a>
	<?php	}
	}
	global $current_user;
	if(isset($current_user) && $current_user != "")
	{
	if(is_super_admin($current_user->ID)) {
		add_action('wp_dashboard_setup', 'claim_ownership_widgets' );
	}
	}
	if(get_option('ptthemes_enable_claimownership') =='Yes'){
	add_action("admin_init", "admin_init"); }

	function admin_init(){
		add_meta_box("Claim post", "Claim post", "meta_options", CUSTOM_POST_TYPE1, "side", "high");
		add_meta_box("Claim post", "Claim post", "meta_options", CUSTOM_POST_TYPE2, "side", "high");
		add_meta_box("Block IP", "Block IP", "blockip_options", CUSTOM_POST_TYPE1, "side", "high");
		add_meta_box("Block IP", "Block IP", "blockip_options", CUSTOM_POST_TYPE2, "side", "high");
	}
	if(isset($_REQUEST['poid']) && $_REQUEST['poid'] != "")
	{
		global $wpdb,$post;
		$claim_db_table_name = $wpdb->prefix."claim_ownership";
	  	$vclid = $_REQUEST['poid'];
		$wpdb->query("Delete from $claim_db_table_name where clid = '".$vclid."'");
		delete_post_meta($post->ID,'is_verified',0);
	}
	if(isset($_REQUEST['ptthemes_featured']) && $_REQUEST['ptthemes_featured'] != '')
		{
			 global $wpdb,$post;
			 if($_REQUEST['ptthemes_featured'] == 'none')
			 {
			 	update_post_meta($_REQUEST['post_ID'],'is_featured',0);
				update_post_meta($_REQUEST['post_ID'],'featured_type','n');
				update_post_meta($_REQUEST['post_ID'],'home_featured_type','n');
			 }
			else
			{
				update_post_meta($_REQUEST['post_ID'],'is_featured',1);
				$featured_type = $_REQUEST['ptthemes_featured'];
				if($featured_type == 'c' && $featured_type != 'both'){
				$featured_type  = "icat";
				update_post_meta($last_postid,'home_featured_type',$featured_type);
				}else{
				update_post_meta($last_postid,'home_featured_type',$featured_type);
				}
				
				update_post_meta($_REQUEST['post_ID'],'featured_type',$_REQUEST['ptthemes_featured']);
				update_post_meta($_REQUEST['post_ID'],'home_featured_type',$featured_type);
				
			}
		}

/*******
 Create the function to output the contents of block ip Widget in add place area-BOF
 *****/
	function blockip_options()
	{ ?>
		<script type="text/javascript" language="javascript">
		/* <![CDATA[ */
		function blockIp(postid)
		{
			window.location = "<?php echo home_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit&blockip="+postid;	
		}
		function unblockIp(postid)
		{
			window.location = "<?php echo home_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit&unblockip="+postid;
		}
		/* ]]> */
		</script>
	<?php
		global $post;
		if($_REQUEST['post_type'] != "")
		{
			echo "<p><strong>" . IP_IS . "</strong>: ".getenv("REMOTE_ADDR") . "</p>";
			echo "<input type='hidden' name='remote_ip' id='remote_ip' value='".getenv("REMOTE_ADDR")."'/>";
			echo "<input type='hidden' name='ip_status' id='ip_status' value='0'/>";
		}else{
		$rip =get_post_meta($post->ID,'remote_ip',true); 
		$ipstatus = get_post_meta($post->ID,'ip_status',true);
		if($rip != "")
		{
		echo "<strong>" . SUBMITTED_IP . "</strong> ".$rip;
		
		global $wpdb,$post; 
			$ipstatus = get_post_meta($post->ID,'ip_status',true);
				if($ipstatus == 0 || $ipstatus == ""){
				$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post->ID."' and meta_value='".$rip."'");
				
					foreach($parray as $pa)
					{ 
						$blocked = get_post_meta($pa->post_id,'ip_status',true);
						if($blocked == 1)
						{
							break;
							return $blocked;
						}
					}
					if($blocked != 0)
					{
						echo "<a href='javascript:void(0)' onclick='unblockIp(".$post->ID.")'> (" . UNBLOCK_IP . ")</a>";
						update_post_meta($post->ID,'ip_status',1);
					}else{ 
						echo "<a href='javascript:void(0)' onclick='blockIp(".$post->ID.")'> (" . BLOCK_IP . ")</a>";
					}
				}else{
				echo "<a href='javascript:void(0)' onclick='unblockIp(".$post->ID.")'> (" . UNBLOCK_IP . ")</a>";
				}
			}else{
			echo IP_NOT_DETECTED;
		}
		}
	}
	if(isset($_REQUEST['blockip']) && $_REQUEST['blockip'] != "")
	{
		global $post,$wpdb;
		$post_id = $_REQUEST['blockip'];
		$rip = get_post_meta($post_id,'remote_ip',true);
		if($rip =="")
		{
			$rip = getenv("REMOTE_ADDR");
			add_post_meta($post_id,'remote_ip',$rip); 
		}
		$ipstatus = get_post_meta($post_id,'ip_status',true);
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post_id."' and meta_value='".$rip."'");
		if(mysql_affected_rows() > 0)
		{ 		
			foreach($parray as $parrayobj){ 
			$ips = get_post_meta($parrayobj->post_id,'ip_status',true);
			if($ips == 1)
			{ ?>
				<script> 
				alert("<?php echo IP_BLOCKED; ?>"); 
				window.location = "<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo $post_id; ?>&action=edit";
				</script>	
			<?php }
			}
		}
		if($rip =="")
		{
			$rip = getenv("REMOTE_ADDR");
			add_post_meta($post_id,'remote_ip',$rip); 
		}
		if($rip != "")
		{ 
			if(!isset($ipstatus)){
				add_post_meta($post_id,'ip_status','1'); 
			}else{ 	
				update_post_meta($post_id,'ip_status','1'); 
			} 
			global $wpdb,$ip_db_table_name;
			$ip_db_table_name = $wpdb->prefix."ip_settings";
			$wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".$rip."'");
			if(mysql_affected_rows() > 0)
			{	
				$wpdb->query("update $ip_db_table_name set ipstatus = '1' where ipaddress = '".$rip."'");
			}else{ 
				$wpdb->query("INSERT INTO $ip_db_table_name (`ipid`, `ipaddress`, `ipstatus`) VALUES (NULL, '".$rip."', '1')");
			}
		} ?>
		<script>location.href = "<?php echo home_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit";</script>
	<?php }elseif(isset($_REQUEST['unblockip']) != "")
	{
		
		$post_id = $_REQUEST['unblockip'];
		update_post_meta($post_id,'ip_status',0);
		$rip = get_post_meta($post_id ,'remote_ip',true);
		$ipstatus = get_post_meta($post_id ,'ip_status',true);
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post_id."' and meta_value='".$rip."'");
			global $wpdb,$ip_db_table_name;
			$ip_db_table_name = $wpdb->prefix."ip_settings";
			$wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".$rip."'");
			if(mysql_affected_rows() > 0)
			{
				$wpdb->query("update $ip_db_table_name set ipstatus = '0' where ipaddress = '".$rip."'");
			}else{
				$wpdb->query("INSERT INTO $ip_db_table_name (`ipid`, `ipaddress`, `ipstatus`) VALUES (NULL, '".$rip."', '0')");
			}
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where meta_value='".$rip."'");

		if(mysql_affected_rows() > 0)
		{ 	
			foreach($parray as $parrayobj){ 
			$ips = get_post_meta($parrayobj->post_id,'ip_status',true);
			if($ips == 1)
			{ 
				update_post_meta($parrayobj->post_id,'ip_status',0);
			}
			}
		}
		if($rip != "")
		{	if(!isset($ipstatus)){
					add_post_meta($post_id ,'ip_status','0'); 
			}else{ 	update_post_meta($post_id ,'ip_status','0'); 
			}
		} ?>
		<script>window.location = "<?php echo home_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit";</script>

<?php	}
function recent_events_dashboard_widgets() {
global $current_user;
	if(is_super_admin($current_user->ID)) {
	wp_add_dashboard_widget('claim_ownership_widgets', RECENT_EVENTS_TEXT, 'recent_events_dashboard_widget');

	global $wp_meta_boxes;

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	$example_widget_backup = array('claim_ownership_widgets' => $normal_dashboard['claim_ownership_widgets']);
	unset($normal_dashboard['claim_ownership_widgets']);

	$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}
add_action('wp_dashboard_setup', 'recent_events_dashboard_widgets' );
function recent_events_dashboard_widget() { ?>
<script type="text/javascript">
function change_poststatus(str)
{ 
	if (str=="")
	  {
	  document.getElementById("p_status_"+str).innerHTML="";
	  return;
	  }
	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("p_status_"+str).innerHTML=xmlhttp.responseText;
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/library/functions/ajax_update_status.php?post_id="+str
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
}

</script>
<?php
	$event_args = array('post_status'=>'draft,publish','post_type' => CUSTOM_POST_TYPE2,'order'=>'DESC');
	$recent_events = get_posts( $event_args );

	if($recent_events){
		echo '<table class="widefat"  width="100%" >
			<thead>	';
		$th='	<tr>
				<th valign="top" align="left">'.__('ID','templatic').'</th>
				<th valign="top" align="left">'.__('Event title','templatic').'</th>
				<th valign="top" align="left">'.__('Address','templatic').'</th>
				<th valign="top" align="left">'.__('Duration','templatic').'</th>
				<th valign="top" align="left">'.__('Daily views','templatic').'</th>
				<th valign="top" align="left">'.__('Total views','templatic').'</th>
				<th valign="top" align="left">'.__('Status','templatic').'</th>';
		
		$th .=	'</tr>';   
		echo $th;
		foreach($recent_events as $event) {
			echo '<tr>
				<td valign="top" align="left">'.$event->ID.'</td>
				<td valign="top" align="left"><a href="'.home_url().'/wp-admin/post.php?post='.$event->ID.'&action=edit">'.$event->post_title.'</a></td>
				<td valign="top" align="left">'.get_post_meta($event->ID,'geo_address',true).'</td>';
			if(get_post_meta($event->ID,'st_date',true) !="" && get_post_meta($event->ID,'st_time',true) !="")	{
			echo '<td valign="top" align="left">'.get_post_meta($event->ID,'st_date',true).' '.get_post_meta($event->ID,'st_time',true).' <strong>to</strong> '.get_post_meta($event->ID,'end_date',true).' '.get_post_meta($event->ID,'end_time',true).'</td>';
			}else{
			echo '<td valign="top" align="left">'.get_post_meta($event->ID,'end_date',true).'-'.get_post_meta($event->ID,'end_time',true).'</td>';
			}
			echo '<td valign="top" align="left">';
				if(get_post_meta($event->ID,'viewed_count_daily',true)) { echo get_post_meta($event->ID,'viewed_count_daily',true);} else { echo '0';} echo '</td>
				<td valign="top" align="left">';
				if(get_post_meta($event->ID,'viewed_count',true)) { echo get_post_meta($event->ID,'viewed_count',true);} else { echo '0';} echo '</td>';
			if(get_post_status($event->ID) =='draft'){
			echo '<td valign="top" align="left" id="p_status_'.$event->ID.'"><a href="javascript:void(0);" onclick="change_poststatus('.$event->ID.')"  style="color:#E66F00">Pending</a></td>';
			}else if(get_post_status($event->ID) =='publish'){
			echo '<td valign="top" align="left" style="color:green" id="p_status_'.$event->ID.'">'.PUBLISHED_TEXT.'</td>';
            }			
			echo '</tr>';
			
			} 
		echo '</thead>	</table>';	
	} else {
		_e('No recent event available','templatic');
	}
}   	

function recent_places_dashboard_widgets() { 
global $current_user;
	if(is_super_admin($current_user->ID)) {
	wp_add_dashboard_widget('recent_events_dashboard_widgets', RECENT_PLACES_TEXT, 'recent_places_dashboard_widget');

	global $wp_meta_boxes;

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	$example_widget_backup = array('recent_events_dashboard_widgets' => $normal_dashboard['recent_events_dashboard_widgets']);
	unset($normal_dashboard['recent_events_dashboard_widgets']);

	$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
}
add_action('wp_dashboard_setup', 'recent_places_dashboard_widgets' );
function recent_places_dashboard_widget() {
	$place_args = array('numberposts'=> 5,'post_status'=>'draft,publish','post_type' => CUSTOM_POST_TYPE1,'order'=>'desc');
	$recent_place = get_posts( $place_args );

	if($recent_place){
		$thp=  '<table class="widefat"  width="100%" >
			<thead>	
			<tr>
				<th valign="top" align="left">'.__('ID','templatic').'</th>
				<th valign="top" align="left">'.__('Place title','templatic').'</th>
				<th valign="top" align="left">'.__('Address','templatic').'</th>
				<th valign="top" align="left">'.__('Daily views','templatic').'</th>
				<th valign="top" align="left">'.__('Total views','templatic').'</th>
				<th valign="top" align="left">'.__('Status','templatic').'</th>';
		
				
		$thp .=	'</tr>';  
		echo $thp;		
		foreach($recent_place as $recent_places) {
			echo '<tr>
				<td valign="top" align="left">'.$recent_places->ID.'</td>
				<td valign="top" align="left"><a href="'.home_url().'/wp-admin/post.php?post='.$recent_places->ID.'&action=edit">'.$recent_places->post_title.'</a></td>
				<td valign="top" align="left">';
				if(get_post_meta($recent_places->ID,'geo_address',true)) { echo get_post_meta($recent_places->ID,'geo_address',true);} else { echo '-';} echo '</td>
				<td valign="top" align="left">';
				if(get_post_meta($recent_places->ID,'viewed_count_daily',true)) { echo get_post_meta($recent_places->ID,'viewed_count_daily',true);} else { echo '0';} echo '</td>
				<td valign="top" align="left">';
				if(get_post_meta($recent_places->ID,'viewed_count',true)) { echo get_post_meta($recent_places->ID,'viewed_count',true);} else { echo '0';} echo '</td>';
			if(get_post_status($recent_places->ID) =='draft'){
			echo '<td valign="top" align="left" style="color:#E66F00" id="p_status_'.$recent_places->ID.'"><a href="javascript:void(0);" onclick="change_poststatus('.$recent_places->ID.')"  style="color:#E66F00">Pending</a></td>';
			}else if( get_post_status($recent_places->ID) =='publish'){
			echo '<td valign="top" align="left" style="color:green" id="p_status_'.$recent_places->ID.'">'.PUBLISHED_TEXT.'</td>';
            }		
			echo '</tr>';
			} 
		echo '</thead>	</table>';	
	} else {
		_e('No recent place available','templatic');
	}
} 

?>
