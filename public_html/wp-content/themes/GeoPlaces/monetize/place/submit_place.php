<?php /*
Template Name: Add place Form
*/
?>
<?php
global $current_user;
$cat_display=get_option('ptthemes_category_dislay');
$post_category = CUSTOM_CATEGORY_TYPE1;
if(isset($_REQUEST['backandedit']))
{
}else
{
	$_SESSION['place_info'] = array();
}
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
 $cur_post_id = $_REQUEST['pid'];
 $postdata = get_post($cur_post_id );
 $post_author_id = $postdata->post_author;
}
if(isset($_REQUEST['pid']) )
{
	if(!$current_user->ID)
	{
		wp_redirect(get_settings('home').'/index.php?ptype=login');
		exit;
	}
	$pid = $_REQUEST['pid'];
	$proprty_type = $catid_info_arr['type']['id'];
	$post_info = get_post_info($_REQUEST['pid']);

	check_user_post($post_info['post_author']);  //security settings

	$property_name = $post_info['post_title'];
	$proprty_desc = $post_info['post_content'];
	$proprty_excerpt = $post_info['post_excerpt'];
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$address = $post_meta['geo_address'][0];
	$geo_address = $post_meta['geo_address'][0];
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];
	$map_view = $post_meta['map_view'][0];
	$timing = $post_meta['timing'][0];
	$contact = $post_meta['contact'][0];
	$email = $post_meta['email'][0];
	$website = $post_meta['website'][0];
	$twitter = $post_meta['twitter'][0];
	$facebook = $post_meta['facebook'][0];
	$kw_tags = $post_meta['kw_tags'][0];
	$ip_status = $post_meta['ip_status'][0];
	$proprty_feature =$post_meta['proprty_feature'][0];
	$post_city_id = $post_meta['post_city_id'][0];
	$zooming_factor = $post_meta['zooming_factor'][0];
	$cat_array = array();
	if($pid) {
	
		$cat_array = wp_get_post_terms($_REQUEST['pid'],CUSTOM_CATEGORY_TYPE1);
		$tc = count($cat_array);
		for($i=0; $i<=$tc; $i++ ){
			$allc = explode(',',$cat_array[$i]->term_id);
			if($allc[0] != ""){
				$allc1 .= $allc[0].","; 
			}
		}
		$cat_array = explode(',',$allc1);
	}
	
	$thumb_img_arr = bdw_get_images_with_info($_REQUEST['pid'],'large');
}

if($_SESSION['place_info'] && $_REQUEST['backandedit'])
{
	$property_name = $_SESSION['place_info']['property_name'];
	$proprty_desc = $_SESSION['place_info']['proprty_desc'];
	$proprty_feature = $_SESSION['place_info']['proprty_feature'];
	$address = $_SESSION['place_info']['address'];
	$geo_address = $_SESSION['place_info']['address'];
	$geo_latitude = $_SESSION['place_info']['geo_latitude'];
	$geo_longitude = $_SESSION['place_info']['geo_longitude'];
	$map_view = $_SESSION['place_info']['map_view'];
	$timing = $_SESSION['place_info']['timing'];
	$contact = $_SESSION['place_info']['contact'];
	$email = $_SESSION['place_info']['email'];
	$website = $_SESSION['place_info']['website'];
	$twitter = $_SESSION['place_info']['twitter'];
	$facebook = $_SESSION['place_info']['facebook'];
	$kw_tags = $_SESSION['place_info']['kw_tags'];
	$post_city_id = $_SESSION['place_info']['post_city_id'];
	
	$user_fname = $_SESSION['place_info']['user_fname'];
	$user_phone = $_SESSION['place_info']['user_phone'];
	$user_email = $_SESSION['place_info']['user_email'];
	$user_login_or_not = $_SESSION['place_info']['user_login_or_not'];
	$featured_h = $_SESSION['place_info']['featured_h']; 
	$featured_c = $_SESSION['place_info']['featured_c']; 
	$zooming_factor = $_SESSION['place_info']['zooming_factor'];
	if(($cat_display == 'checkbox' || $cat_display == '') && $_SESSION['place_info']['category'] != ''){ 
		$cat_array1 = implode("-",$_SESSION['place_info']['category']);
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ ){
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
				$allc1 .= $allc[0].","; 
			}
		}
		$cat_array = explode(',',$allc1);
	}else{
		$cat_array = $_SESSION['place_info']['category'];
	}
	$proprty_add_coupon = $_SESSION['place_info']['proprty_add_coupon'];
	$price_select = $_SESSION['place_info']['price_select'];
	global $price_db_table_name;
	$pricesql = $wpdb->get_row("select * from $price_db_table_name where pid='".$price_select."'"); 
	if($_SESSION['place_info']['featured_h']!= "" && $_SESSION['place_info']['featured_h']==""){
		$fprice = $pricesql->feature_amount;
		$hprice = $pricesql->feature_amount;
	}else if($_SESSION['place_info']['featured_h']== "" && $_SESSION['place_info']['featured_h']!=""){
		$fprice = $pricesql->feature_cat_amount;
		$cprice = $pricesql->feature_cat_amount;
	}else if($_SESSION['place_info']['featured_h']!= "" && $_SESSION['place_info']['featured_h']!=""){
		$fprice = $pricesql->feature_cat_amount + $pricesql->feature_amount;
	}
	$packprice = $pricesql->package_cost;
	$is_feature = $pricesql->is_featured;
	$cat_price = $_SESSION['place_info']['all_cat_price'];
	$total_price = $_SESSION['place_info']['total_price'];
	$none = 0;
}
if(isset($_REQUEST['category']) && $_REQUEST['category'] != ''){
	$user_fname = $_REQUEST['user_fname'];
	$user_phone = $_REQUEST['user_phone'];
	$user_email = $_REQUEST['user_email'];
	$user_login_or_not = $_REQUEST['user_login_or_not'];
}
if(isset($proprty_desc)=='')
{
	$proprty_desc = __("Enter description for your listing.",'templatic');
}
if(isset($_REQUEST['renew']))
{
	$property_list_type = get_post_meta($_REQUEST['pid'],'list_type',true);
}
if($_REQUEST['ptype']=='post_event')
{
	if(isset($_REQUEST['pid'])){
		if($_REQUEST['renew'])
		{
			$page_title = RENEW_EVENT_TEXT;
		}else
		{
			$page_title = EDIT_EVENT_TEXT;
		}
	}else
	{
		$page_title = POST_EVENT_TITLE;
	}
}else
{
	if(isset($_REQUEST['pid']))
	{
		if(isset($_REQUEST['renew']))
		{
			$page_title = RENEW_LISING_TEXT;
		}else
		{
			$page_title = EDIT_LISING_TEXT;
		}
	}else
	{
		$page_title = POST_PLACE_TITLE;
	}
}
global $page_title;
 $cat_display=get_option('ptthemes_category_dislay');
get_header(); 
if(get_option('ptthemes_add_place_nav') == 'Yes'){

global $ip_db_table_name,$site_url;
$ip = $wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".getenv("REMOTE_ADDR")."' and ipstatus=1");
if($ip == ""){
if($cat_display==''){$cat_display='checkbox';}
?>
<!-- TinyMCE -->
<script type="text/javascript">var rootfolderpath = '<?php echo get_bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/monetize/place/place.js"></script>
<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		width:450,
		height:400,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script><!-- /TinyMCE -->
<script type="text/javascript">
function show_featuredprice(pkid)
{
	if (pkid=="")
	  {
	  document.getElementById("featured_h").innerHTML="";
	  return;
	  }else{
	  //document.getElementById("featured_h").innerHTML="";
	  document.getElementById("process").style.display ="block";
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("process").style.display ="none";
		var myString =xmlhttp.responseText;
		var myStringArray = myString.split("###RAWR###");  
		if(myStringArray[5] == 1){
		if(document.getElementById('is_featured').style.display == "none")
		{
			document.getElementById('is_featured').style.display="";
		}
			document.getElementById('featured_c').value = myStringArray[1];
			document.getElementById('featured_h').value = myStringArray[0];
			var positionof = document.getElementById('c_position').value;
			if(positionof == 1){ 
			document.getElementById('ftrhome').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>"+myStringArray[0]+")";

			document.getElementById('ftrcat').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>"+myStringArray[1]+")";
			}else if(positionof == 2){
			document.getElementById('ftrhome').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?> "+myStringArray[0]+")";
			document.getElementById('ftrcat').innerHTML = "(<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?> "+myStringArray[1]+")";
			}else if(positionof == 3){
			document.getElementById('ftrhome').innerHTML = "("+myStringArray[0]+"<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			document.getElementById('ftrcat').innerHTML = "("+myStringArray[1]+"<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			}else{
			document.getElementById('ftrhome').innerHTML = "("+myStringArray[0]+" <?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			document.getElementById('ftrcat').innerHTML = "("+myStringArray[1]+" <?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)";
			}
			document.getElementById('pkg_price').innerHTML = myStringArray[4];   
		}else{
			document.getElementById('pkg_price').innerHTML = myStringArray[4];  
			document.getElementById('featured_c').value=0;
			document.getElementById('ftrcat').innerHTML	= "<?php echo display_amount_with_currency(0);?>";		
			document.getElementById('featured_h').value=0;
			document.getElementById('ftrhome').innerHTML = "<?php echo display_amount_with_currency(0);?>";		
			document.getElementById('is_featured').style.display = "none"; 
		 	document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4]).toFixed( 2 );
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4]).toFixed( 2 );
		
		}
		if((document.getElementById('featured_h').checked== true) && (document.getElementById('featured_c').checked== true))
		{	
			
			document.getElementById('feture_price').innerHTML = parseFloat(parseFloat(myStringArray[0]) + parseFloat(myStringArray[1])).toFixed( 2 ) ;
			
			document.getElementById('total_price').value = parseFloat(parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
			
			document.getElementById('result_price').innerHTML = parseFloat(parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
			
		}else if((document.getElementById('featured_h').checked == true) && (document.getElementById('featured_c').checked == false)){
			
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[0]).toFixed( 2 );
			
			document.getElementById('total_price').value = parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
			
			document.getElementById('result_price').innerHTML = parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
		}else if((document.getElementById('featured_h').checked == false) && (document.getElementById('featured_c').checked == true)){
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[1]).toFixed( 2 );
			document.getElementById('total_price').value = parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
			
			document.getElementById('result_price').innerHTML = parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
		}else{
			document.getElementById('total_price').value = parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
			
			document.getElementById('result_price').innerHTML =parseFloat(parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('cat_price').innerHTML) + parseFloat(myStringArray[4])).toFixed( 2 );
		}
	  } 
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/place/ajax_price.php?pkid="+pkid
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	 
}

function fetch_packages(pkgid,form,pri)
{ 
	var total = 0;
	var t=0;
	//var c= form['category[]'];
	var dml = document.forms['propertyform'];
	var c = dml.elements['category[]'];
	var cats = document.getElementById('all_cat').value;
	document.getElementById('all_cat').value = "";
	document.getElementById('all_cat_price').value = 0;
	document.getElementById('cat_price').innerHTML = 0;
	for(var i=0;i<c.length;i++){
		c[i].checked?t++:null;
		if(c[i].checked)
		{	
			var a = c[i].value.split(",");
		
			document.getElementById('all_cat').value += a[0]+"|";
			
			
			document.getElementById('all_cat_price').value = parseFloat(document.getElementById('all_cat_price').value) + parseFloat(a[1]);
			
			document.getElementById('cat_price').innerHTML = parseFloat(document.getElementById('all_cat_price').value);

		}
		
			document.getElementById('total_price').value =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);

			
			document.getElementById('result_price').innerHTML =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	}
	var cats = document.getElementById('all_cat').value ;
	
	  document.getElementById("packages_checkbox").innerHTML="";
	  document.getElementById("process2").style.display ="";
	 
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("packages_checkbox").innerHTML =xmlhttp.responseText;;
		document.getElementById("process2").style.display ="none";
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/place/ajax_price.php?pckid="+cats
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();		
}
function allplaces_packages(cp_price) {
	var total = 0;
	var t=0;
	//var c= form['category[]'];
	var dml = document.forms['propertyform'];
	var c = dml.elements['category[]'];
	var selectall = dml.elements['selectall'];
	if(selectall.checked == false){
		cp_price = 0;
	} else {
		cp_price = cp_price;
	}
	var cats = document.getElementById('all_cat').value;
	document.getElementById('all_cat').value = "";
	document.getElementById('all_cat_price').value = 0;
	document.getElementById('cat_price').innerHTML = 0;
	
		for(var i=0 ;i < c.length;i++){
		c[i].checked?t++:null;
		if(c[i].checked){	
			var a = c[i].value.split(",");
			if(i ==  (c.length - 1) ){
				document.getElementById('all_cat').value += a[0];
			} else {
				document.getElementById('all_cat').value += a[0]+"|";
			}
		}
	}

	document.getElementById('all_cat_price').value = parseFloat(cp_price);
	document.getElementById('cat_price').innerHTML = parseFloat(document.getElementById('all_cat_price').value);
	document.getElementById('total_price').value =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	document.getElementById('result_price').innerHTML =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	
	var cats = document.getElementById('all_cat').value ;
	
	  document.getElementById("packages_checkbox").innerHTML="";
	  document.getElementById("process2").style.display ="";
	
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("packages_checkbox").innerHTML =xmlhttp.responseText;;
		document.getElementById("process2").style.display ="none";
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/place/ajax_price.php?pckid="+cats
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();	

	}

function validate_coupon_places()
{
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	if(xmlhttp == null)
	{
		alert("Your browser not support the AJAX");	
		return;
	}
	if(document.getElementById("proprty_add_coupon"))
		add_coupon = document.getElementById("proprty_add_coupon").value;
		total_price = document.getElementById("total_price").value;
		var url = "<?php echo get_template_directory_uri(); ?>/monetize/place/ajax_check_coupon_places.php?add_coupon="+add_coupon+"&total_price="+total_price;

		xmlhttp.open("GET",url,true);
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText.length > 2 && xmlhttp.responseText.length < 50)
				{
					document.getElementById("msg_coudon_code").style.display = '';
					document.getElementById("msg_coudon_code").innerHTML = xmlhttp.responseText;
					jQuery("#msg_coudon_code").removeClass('error_msg');
					jQuery("#msg_coudon_code").addClass('success_msg');
				}
				else if(xmlhttp.responseText.length > 50)
				{
					document.getElementById("msg_coudon_code").style.display = '';
					document.getElementById("msg_coudon_code").innerHTML = xmlhttp.responseText;
					jQuery("#msg_coudon_code").removeClass('success_msg');
					jQuery("#msg_coudon_code").addClass('error_msg');
				}
				else
				{
					document.getElementById("msg_coudon_code").style.display = '';
					document.getElementById("msg_coudon_code").innerHTML = '<?php _e('Sorry! coupon code does not exist.Please try an aother coupon code.','templatic'); ?>';
					jQuery("#msg_coudon_code").removeClass('success_msg');
					jQuery("#msg_coudon_code").addClass('error_msg');
				}
			}
		}
		return true;
}

</script>
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes' ) {  ?>
<div class="breadcrumb_in"><a href="<?php echo $site_url; ?>"><?php _e(HOME,'templatic'); ?></a> &raquo; <?php echo $page_title; ?></div>
<?php } ?>

	<div class="steps">
        	<span class="current"><?php _e(ENTER_PLACE,'templatic'); ?></span>
            <span><?php _e(PREVIEW_PLACE,'templatic'); ?></span>
            <span><?php _e(SUCCESS_PLACE,'templatic'); ?></span>
    </div>


 <?php $a = get_option('recaptcha_options');
	 ?>
			   <script type="text/javascript">
 var RecaptchaOptions = {
    theme : '<?php echo $a['comments_theme']; ?>',
	lang : '<?php echo $a['recaptcha_language']; ?>',
    tabindex :'<?php echo $a['comments_tab_index']?>'
 };
 </script>
<div  class="<?php templ_content_css();?>" >


<div class="content-title">
	<?php echo $page_title; ?>
   </div>
 <?php  if(isset($_REQUEST['ecptcha']) == 'captch') {
$a = get_option("recaptcha_options");
	$blank_field = $a['no_response_error'];
	$incorrect_field = $a['incorrect_response_error'];
	
	echo '<div class="error_msg">'.$incorrect_field.'</div>';
}
 if(is_allow_user_register()){?>
            <?php if(isset($_REQUEST['usererror'])==1)
			{
				if(isset($_SESSION['userinset_error']))
				{
					for($i=0;$i<count($_SESSION['userinset_error']);$i++)
					{
						echo '<div class="error_msg">'.$_SESSION['userinset_error'][$i].'</div>';
					}
					echo "<br>";
				}
			}
			?>   
             <?php
			if(isset($_REQUEST['emsg']) && $_REQUEST['emsg']==1)
			{
			?>
			<div class="error_msg"><?php echo INVALID_USER_PW_MSG;?></div>
			<?php
			}
			if($current_user->ID=='') {	 ?>
			 
			 
			 <h5 class="form_title spacer_none"><?php _e(LOGINORREGISTER,'templatic');?>  </h5>
			 
              <div class="form_row clearfix">
             	<label><?php _e(IAM_TEXT,'templatic');?> </label>
             	 <span class=" user_define"> <label class="radio_lbl"><input name="user_login_or_not" type="radio" value="existing_user" <?php if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}else{ echo 'checked="checked"'; }?> onclick="set_login_registration_frm('existing_user');" /> <?php _e(EXISTING_USER_TEXT,'templatic' );?> </label></span>
				<?php if ( get_option('users_can_register') ) { ?>				 
				 <span class="user_define"> <label class="radio_lbl"><input name="user_login_or_not" type="radio" value="new_user" <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm('new_user');" /> <?php _e(NEW_USER_TEXT);?> </label></span>
				 <?php } ?>
              </div>
              <div class="login_submit clearfix" id="login_user_frm_id">
              <form name="loginform" id="loginform" action="<?php echo get_ssl_normal_url(get_settings('home').'/index.php?ptype=login&ptype1='.$_REQUEST['ptype']); ?>" method="post" >
              <div class="form_row clearfix">
             	<label><?php _e(LOGIN_TEXT);?>  <span>*</span> </label>
             	<input type="text" class="textfield " id="user_login" name="log" />
              </div>
              
               <div class="form_row clearfix">
             	<label><?php _e(PASSWORD_TEXT);?>  <span>*</span> </label>
             	<input type="password" class="textfield " id="user_pass" name="pwd" />
              </div>
              
              <div class="form_row clearfix">
              <input name="submit" type="submit" value="<?php _e(SUBMIT_BUTTON);?>" class="b_submit" />
			  
			   </div>
			
			  <?php	$login_redirect_link = get_settings('home').'/?ptype=post_listing';?>
			  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
			  <input type="hidden" name="testcookie" value="1" />
			  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
			  </form>
			  
			  <!-- Enable social media(gigya plugin) if activated-->
			  <div id="componentDiv"><?php if(is_plugin_active('gigya-socialize-for-wordpress/gigya.php') && get_option('users_can_register')){ 
				dynamic_sidebar('below_registration'); } ?></div>
				<!--End of plugin code-->
              </div>
             <?php }?>
             <?php }?>
			
			  <?php
			  if(isset($_REQUEST['renew']) && $_REQUEST['renew']!= '')
				$form_renew_action_url = $site_url.'/?ptype=post_listing&renew=1&pid='.$_REQUEST['pid'];
			else
				$form_renew_action_url  = $site_url.'/?ptype=post_listing';
			 if(isset($_REQUEST['pid']) || isset($_POST['renew'])){
					$form_action_url = $site_url.'/?ptype=preview';
				
			 }else
			 {
				 $reqPid  = '';
				 if(isset($_REQUEST['pid']))
				   {
					  $reqPid = $_REQUEST['pid']; 
				   }
				 $form_action_url = get_ssl_normal_url($site_url.'/?ptype=preview',$reqPid);
			 }if($cat_display == 'select'){  ?>
			 <form name="categoryform" id="categoryform" action="<?php echo $form_renew_action_url; ?>" method="post" >
			 <?php	if($current_user->ID=='')	 {
				 ?>
				 
				<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "new_user";}?>" />		
				<div id="contact_detail_id" style="display:none;"> 
					<h5 class="form_title"><?php echo CONTACT_DETAIL_TITLE; ?></h5>
					 
					   <div class="form_row clearfix">
						<label><?php echo CONTACT_NAME_TEXT; ?> <span>*</span></label>
						 <input name="user_fname" id="user_fname" value="<?php echo $user_fname;?>" type="text" class="textfield" onBlur="myfields(this.id)" />
					  </div>
					  <div class="form_row clearfix">
						<label><?php echo CONTACT_TEXT; ?></label>
						 <input  name="user_phone" id="user_phone" value="<?php echo $user_phone;?>" type="text" class="textfield" onBlur="myfields(this.id)"/>
					  </div>
					  <div class="form_row clearfix">
						<label><?php echo EMAIL_TEXT; ?> <span>*</span></label>
						 <input name="user_email" id="user_email" value="<?php echo $user_email;?>" type="text" class="textfield" onBlur="myfields(this.id)"/>
					  <span class="message_note"><?php echo EMAIL_TEXT_MSG;?></span>
					  </div>
				</div>
				<?php } else { ?>
				<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "existing_user";}?>" />		
				<?php }?> 
			
			  <h5 class="form_title "> <?php _e(LISTING_DETAILS_TEXT);?> </h5>
             
             
			  <div class="form_row clearfix" >
             	<label><?php echo EVENT_CITY_TEXT;?> </label>
             	<?php if($post_city_id){$city_id = $post_city_id;} else if(isset($_REQUEST['post_city_id']) && $_REQUEST['post_city_id'] != '0') {$city_id = $_REQUEST['post_city_id'];} else {$city_id = $_SESSION['multi_city'];}
				
				echo get_multicit_select_dl('post_city_id','post_city_id',$city_id,' class="textfield textfield_x" ');?>
             
             </div>
             <?php if(!$_REQUEST['pid']){ ?>
             <div class="form_row clearfix">
             	<label><?php echo EVENT_CATETORY_TEXT;?> <span>*</span> </label>
            	<div><?php require_once (TT_MODULES_FOLDER_PATH.'place/places_category.php');?></div>
                <span class="message_note"><?php echo CATEGORY_MSG;?></span>
                <span id="category_span" class="message_error2"></span>
            </div>
			<?php }else if(isset($_REQUEST['renew']) && $_REQUEST['renew'] !=''){ 
					if(is_array($cat_array) && $cat_display =='select'){
					$category_id = implode(',',$cat_array) ;
					$category_renew = $cat_array[0]; 
					}else{
					$cat_array =$cat_array;
					$category_renew = $cat_array;
					}	
					
			?>
				<div class="form_row clearfix">
             	<label><?php echo EVENT_CATETORY_TEXT;?> <span>*</span> </label>
            	<div><?php require_once (TT_MODULES_FOLDER_PATH.'place/places_category.php');?></div>
                <span class="message_note"><?php echo CATEGORY_MSG;?></span>
                <span id="category_span" class="message_error2"></span>
				</div>
		
			<?php } ?> </form><?php } ?>
			 
            <form name="propertyform" id="propertyform" action="<?php echo $form_action_url; ?>" method="post" enctype="multipart/form-data">
			<?php 
			if(@$_REQUEST['action'] =='edit'){ ?>
				<input type="hidden" name="action" value="edit"/>
			<?php }
			$currency_table = $wpdb->prefix."currency";
			$cur_pos = $wpdb->get_var("select symbol_position from ".$currency_table." where currency_code = '".get_option('currency_symbol')."'");?>
			<input type='hidden' name='c_position' id='c_position' value='<?php echo $cur_pos; ?>'/>
			 <?php 
			 /*--When going to renew the package ---*/
			 if(isset($_REQUEST['renew']) && $_REQUEST['renew'] != ''){ ?>
			 <input type="hidden" name="renew" id="renew" value="1"/>
			 <?php } 
			 /*----Package information for edit BOC -----------*/
			 if((isset($_REQUEST['pid']) && $_REQUEST['pid'] != "") && (!isset($_REQUEST['renew']) && $_REQUEST['renew'] == '')){ ?>
			<?php /*?><input type="hidden" name="price_select" id="price_select" value="<?php echo get_post_meta($_REQUEST['pid'],'pkg_id',true); ?>"/><?php */?>
			<input type="hidden" name="total_price" id="total_price" value="<?php echo get_post_meta($_REQUEST['pid'],'paid_amount',true); ?>"/>
			<input type="hidden" name="featured_type" id="featured_type" value="<?php echo get_post_meta($_REQUEST['pid'],'featured_type',true); ?>"/>
			<?php }  /*----Package information for edit EOC -----------*/ ?>
			
		   <input type="hidden" name="all_cat" id="all_cat" value=""/>
			<input type="hidden" name="all_cat_price" id="all_cat_price" value="<?php if(@$_REQUEST['category'] !=""){ $cat = explode(",",$_REQUEST['category']); echo $cat[2]; }else{ echo "0";}?>"/>
            <input type="hidden" name="pid" id="pid" value="<?php echo @$_REQUEST['pid'];?>" />
            <?php 
		if(((isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') && (!isset($_REQUEST['renew']) && $_REQUEST['renew'] == '')) && $cat_display == 'select') { ?>
			<input type="hidden" name="category" value="<?php echo $cat_array[0];?>" />
			<input type="hidden" name="post_city_id" value="<?php echo $post_city_id;?>" />
<?php	}else if(((isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') && (!isset($_REQUEST['renew']) && $_REQUEST['renew'] == '')) && $cat_display == 'checkbox') {
			echo "<div class='form_row clearfix'><label>Categories</label>";
 			for($c=0 ; $c < count($cat_array) ; $c++){ $term = get_term($cat_array[$c],'placecategory'); 
				if($cat_array[$c] !=''){ ?>
				<input type="checkbox" name="category[]" value="<?php echo $cat_array[$c]; ?>" checked="checked"/><?php echo $term->name;?>
			<?php }
			} 	echo "</div>";?>
			<input type="hidden" name="post_city_id" value="<?php echo $post_city_id;?>" />
<?php	} else {
			if($cat_display != 'select' && !isset($_REQUEST['category'])){ ?>
<?php			if($current_user->ID=='')	{	 ?>
					<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "new_user";}?>" />				
					<div id="contact_detail_id" style="display:none;"> 
						<h5 class="form_title"><?php echo CONTACT_DETAIL_TITLE; ?></h5>
					    <div class="form_row clearfix">
							<label><?php echo CONTACT_NAME_TEXT; ?> <span>*</span></label>
							<input name="user_fname" id="user_fname" value="<?php echo $user_fname;?>" type="text" class="textfield" />
						</div>
						<div class="form_row clearfix">
							<label><?php echo CONTACT_TEXT; ?></label>
							<input  name="user_phone" id="user_phone" value="<?php echo $user_phone;?>" type="text" class="textfield" />
						</div>
						<div class="form_row clearfix">
							<label><?php echo EMAIL_TEXT; ?> <span>*</span></label>
							<input name="user_email" id="user_email" value="<?php echo $user_email;?>" type="text" class="textfield" />
							<span class="message_note"><?php echo EMAIL_TEXT_MSG;?></span>
						</div>
					</div>
<?php 			} else { ?>
					<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if(@$user_login_or_not != '') {echo $user_login_or_not; } else { echo "existing_user";}?>" />
<?php 			} ?> 
				<h5 class="form_title "> <?php _e(LISTING_DETAILS_TEXT);?> </h5>
				<div class="form_row clearfix" >
					<label><?php echo EVENT_CITY_TEXT;?> </label>
					<?php if(@$post_city_id){$city_id = $post_city_id;} else if(isset($_REQUEST['post_city_id']) && $_REQUEST['post_city_id'] != '0') {$city_id = $_REQUEST['post_city_id'];} else {$city_id = $_SESSION['multi_city'];}
					echo get_multicit_select_dl('post_city_id','post_city_id',$city_id,' class="textfield textfield_x" ');?>
                </div>
				<?php if(!isset($_REQUEST['pid'])){ ?>
				<div class="form_row clearfix">
					<label><?php echo EVENT_CATETORY_TEXT;?> <span>*</span> </label>
					<div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'place/places_category.php');?></div>
					<span class="message_note"><?php echo CATEGORY_MSG;?></span>
					<span id="category_span" class="message_error2"></span>
				</div>
				<?php }else if(isset($_REQUEST['renew'])){
					if(is_array($cat_array) && $cat_display !='select'){

					$category_id = implode(',',$cat_array) ;
					$category_renew = $cat_array; 
					global $category_renew;
					}				?>
				<div class="form_row clearfix">
					<label><?php echo EVENT_CATETORY_TEXT;?> <span>*</span> </label>
					<div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'place/places_category.php');?></div>
					<span class="message_note"><?php echo CATEGORY_MSG;?></span>
					<span id="category_span" class="message_error2"></span>
				</div>
				<?php } ?>
<?php 		} else { 
			if($_REQUEST['category'] != "" && isset($_REQUEST['category'])){
			$cat = explode(",",$_REQUEST['category']); }
			?>
				<input type="hidden" name="renew" value="<?php echo $_REQUEST['renew'];?>" />
                <input type="hidden" name="user_fname" id="user_fname_hidden" value="<?php echo $_REQUEST['user_fname'];?>" />
				<input type="hidden" name="user_phone" id="user_phone_hidden" value="<?php echo $_REQUEST['user_phone'];?>" />
				<input type="hidden" name="user_email" id="user_email_hidden" value="<?php echo $_REQUEST['user_email'];?>" />
				<input type="hidden" name="post_city_id" value="<?php echo $_REQUEST['post_city_id'];?>" id="post_city_assign" />
				<input type="hidden" name="category" id="category_assign" value="<?php if(isset($_SESSION['place_info']['category']) && $_SESSION['place_info']['category'] != '') { echo $_SESSION['place_info']['category'];} else { echo $cat[0]; }?>" />
<?php 		} 
		}
			if(!isset($geo_longitude)){$geo_longitude = '';	}
			if(!isset($geo_latitude)){$geo_latitude = '';	}
			if(!isset($geo_address)){$geo_address = '';	}
			
			if($cat_display == 'select'){
			if($_REQUEST['category'] != "" && isset($_REQUEST['category'])){
			$cat = explode(",",$_REQUEST['category']); }
			
				if(isset($_REQUEST['category']) && $_REQUEST['category'] != '0'){
				$category_id = $cat[1];	
				} else if(isset($_SESSION['place_info']['category']) && $_SESSION['place_info']['category'] != '0'){
					$category_id = $_SESSION['place_info']['category'];	
				} else if(isset($cat_array) && $cat_array != '0'){
					if(is_array($cat_array)){
					$category_id = implode(',',$cat_array) ;
					}else{
					$cat_array =$cat_array;
					}					
				}
				
				if((isset($_REQUEST['category']) && $_REQUEST['category'] != '0') || (isset($_SESSION['place_info']['category']) && $_SESSION['place_info']['category'] != '0')){ 
					$default_custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,$category_id,'user_side');
					display_custom_post_field($default_custom_metaboxes,'place_info',$geo_latitude,$geo_longitude,$geo_address);
				}else{ 
					if($category_id){
					$custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,$category_id,'user_side');
					}else{
					$custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'','user_side');
					}
					display_custom_post_field($custom_metaboxes,'place_info',$geo_latitude,$geo_longitude,$geo_address);
				}
			}else {
				$default_custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'0','user_side');
			
				display_custom_post_field($default_custom_metaboxes,'place_info',$geo_latitude,$geo_longitude,$geo_address);
			}?> 
			<input name="remote_ip" id="remote_ip" value="<?php echo getenv("REMOTE_ADDR"); ?>" type="hidden" class="textfield medium" />
			<input name="ip_status" id="ip_status" value="<?php if(@$ip_status != ""){ echo $ip_status; }else{ echo "0"; }?>" type="hidden" class="textfield medium" />
<?php 		if(@$_REQUEST['pid']=='' || @$_REQUEST['renew']=='1'){
			  	 $place_price_info = get_property_price_info();
				 if($place_price_info) { ?>
			<h5 class="form_title"> <?php echo SELECT_PACKAGE_TEXT;?></h5> 
			<?php if($cat_display == 'select'){ ?>
			<div class="form_row clearfix">
				<?php $catid = $category_id ;
				if($catid != "")
				{
				get_price_info($price_select,$catid,CUSTOM_POST_TYPE1); }else{
				get_price_info($price_select,'',CUSTOM_POST_TYPE1);
				}
				if($cat_array != ""){

					$catid = $cat_array;
				}else{
					$catid = $_REQUEST['category'];
				}
				?>
            <span class="message_error2" id="price_package_error"></span>    
            </div>
			<?php }else{ ?>
			<span id='process2' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span>
			<div class="form_row clearfix" id="packages_checkbox">
			<?php 
			if(@!$_REQUEST['pid']){ 
			if($cat_array !="")
			$cat_chk = implode("|",$cat_array);
			if(!isset($catid)){ $catid = ''; }
			if($catid != ""){ 
				get_price_info($price_select,$catid,CUSTOM_POST_TYPE1); 
			}else if($cat_array !=""){
				get_price_info($price_select,$cat_chk,CUSTOM_POST_TYPE1);
			}else{
				if(!isset($price_select)){ $price_select = ''; }
				get_price_info($price_select,'',CUSTOM_POST_TYPE1);	}
			}
			if(@$_REQUEST['renew'] !=''){ 
			if($cat_array !="")
			$cat_chk = implode("|",$cat_array);
			if(!isset($catid)){ $catid = ''; }
			if($catid != ""){ echo "asdsadasd";
				get_price_info($price_select,$catid,CUSTOM_POST_TYPE1); 
			}else if($cat_array !=""){
				get_price_info($price_select,$cat_chk,CUSTOM_POST_TYPE1);
			}else{
				if(!isset($price_select)){ $price_select = ''; }
				get_price_info($price_select,'',CUSTOM_POST_TYPE1);	}
			} ?>			
			</div>
            <span class="message_error2" id="price_package_error"></span>		
			<?php } ?>
			<div class="form_row clearfix" id="is_featured" style="display:none;">
					<label><?php echo FEATURED_TEXT;?> </label>
					<div class="feature_label">
					<label style="clear:both;width:430px;"><input type="checkbox" name="featured_h" id="featured_h" value="0" onclick="featured_list(this.id)" <?php if($featured_h !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_H,'templatic'); ?> <span id="ftrhome"><?php if($featured_h !=""){ echo "(".display_amount_with_currency($featured_h).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
					<label style="clear:both;width:430px;"><input type="checkbox" name="featured_c" id="featured_c" value="0" onclick="featured_list(this.id)" <?php if($featured_c !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_C,'templatic'); ?><span id="ftrcat"><?php if($featured_c !=""){ echo "(".display_amount_with_currency($featured_c).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
					<input type="hidden" name="featured_type" id="featured_type" value="n"/>
					<span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span> 
					</div>
					<span class="message_note"><?php echo FEATURED_MSG;?></span>
					<span id="category_span" class="message_error2"></span>
			</div>
			  <div class="form_row clearfix">
             	<label><?php echo TOTAL_TEXT;?> <span>*</span> </label>
            	<div class="form_row clearfix">
                <?php 
					
					if(!isset($total_price)){ $total_price = ''; }
					if(!isset($fprice)){ $fprice = ''; }
				?>
				<?php $currency = fetch_currency(get_option('currency_symbol'),'currency_symbol');
				$position = fetch_currency(get_option('currency_symbol'),'symbol_position');
				?>
				<?php if($position == '1'){ echo $currency; }else if($position == '2'){ echo $currency.' '; } ?>
				 <span id="cat_price"><?php if(@$catid != "") { $catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt,  $wpdb->terms t where tt.term_taxonomy_id = '".$catid."' and tt.term_id = t.term_id"); if($catprice->term_price !=""){ echo $catprice->term_price; }else{ echo "0"; } }else{ if($cat_price !="") { echo $cat_price; }else{ echo "0"; } } ?></span>
				 <?php if($position == '3'){ echo $currency; }else if($position != 1 && $position != 2 && $position !=3){ echo ' '.$currency; } ?>
				 + 
				 <?php if($position == '1'){ echo $currency; }else if($position == '2'){ echo $currency.' '; } ?>
				 <span id="pkg_price"><?php if(isset($price_select) && $price_select !=""){ echo $packprice; } else{ echo "0";}?></span>
				 <?php if($position == '3'){ echo $currency; }else if($position != 1 && $position != 2 && $position !=3){ echo ' '.$currency; } ?>
				 + 
				 <?php if($position == '1'){ echo $currency; }else if($position == '2'){ echo $currency.' '; } ?>
				 <span id="feture_price"><?php if($fprice !=""){ echo $fprice ; }else{ echo "0"; }?></span>
				  <?php if($position == '3'){ echo $currency; }else if($position != 1 && $position != 2 && $position !=3){ echo ' '.$currency; } ?>
				 = 
				 <?php if($position == '1'){ echo $currency; }else if($position == '2'){ echo $currency.' '; } ?>
				 <span id="result_price"><?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?></span>
				  <?php if($position == '3'){ echo $currency; }else if($position != 1 && $position != 2 && $position !=3){ echo ' '.$currency; } ?>
				<input type="hidden" name="total_price" id="total_price" value="<?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?>"/>
				</div>
                <span class="message_note"> </span>
                <span id="category_span" class="message_error2"></span>
            </div>
			 <?php if(get_option('is_allow_coupon_code')){ ?>
			 <h5 class="form_title"><?php echo COUPON_CODE_TITLE_TEXT;?></h5> 
              <div class="form_row clearfix">
             	<label><?php echo PRO_ADD_COUPON_TEXT;?> </label>
				<input type="text" name="proprty_add_coupon" id="proprty_add_coupon" class="textfield" value="<?php echo esc_attr(stripslashes($proprty_add_coupon)); ?>" />
				<input class="validate_btn" type="button" name="validate_coupon_code" id="validate_coupon_code" value="<?php _e('Validate','templatic');?>" onclick="return validate_coupon_places();"  />
				 <span class="message_note"><?php echo COUPON_NOTE_TEXT; ?></span>
				<span style="display:none;margin:5px 0 0 145px;float:left;padding:5px;"  class="success_msg" id="msg_coudon_code"></span>		
             </div>
			 <?php }?>
			 <?php }?>
             <?php }?>
			 <script type="text/javascript">
			 function show_value_hide(val)
			 {
			 	document.getElementById('property_submit_price_id').innerHTML = document.getElementById('span_'+val).innerHTML;
			 }
			 </script>
         <p><span class="message_error2" id="common_error"></span></p>    
		<?php if(get_option('accept_term_condition') && get_option('accept_term_condition') == 'yes'){	?>
			<div class="form_row clearfix">
             	<label>&nbsp;</label>
             	 <input name="term_and_condition" id="term_and_condition" value="" type="checkbox" class="chexkbox" />
                 <?php echo stripslashes(get_option('term_condition_content'));?>
            </div>
            <script type="text/javascript">
              function check_term_condition()
			  {
				if(eval(document.getElementById('term_and_condition')))  
				{
					if(document.getElementById('term_and_condition').checked)
					{	
						return true;
					}else
					{
						alert('<?php _e('Please accept Term and Conditions','templatic');?>');
						return false;
					}
				}
			  }
            </script>
            
		<?php 
		$submit_button = 'onclick="return check_term_condition();"';
		}
		$pcd = explode(',',get_option('ptthemes_captcha_dislay'));	
		if((in_array('Add Place/Event submission page',$pcd) || in_array('Both',$pcd)) && file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')  ){
			echo '<div class="form_row clearfix">';
			require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php'); 
			$a = get_option("recaptcha_options");
			echo '<label>'.WORD_VERIFICATION.'</label>';
			$publickey = $a['public_key']; // you got this from the signup page
			echo recaptcha_get_html($publickey); 
			echo '</div>';
		}
		
		if(!isset($submit_button)){ $submit_button = ''; }?>
               
			  <input type="submit" name="Update" value="<?php echo PRO_PREVIEW_BUTTON;?>" class="b_review" <?php echo $submit_button;?>/>
			  
			  <div class="form_row clear_both">
			  	 <span class="message_note"> <?php _e('Note: You will be able to see a preview in the next page','templatic');?>  </span>
			  </div>
              <input type="hidden" name="zooming_factor" id="zooming_factor" value="<?php echo $zooming_factor;?>">
    </form>  
</div> <!-- content #end -->
<?php if(templ_is_layout('2_col_right'))  ////Sidebar 2 column right
{ ?>
<div class="sidebar right">
<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('add_place_sidebar'); } ?>
</div>
<?php }else{ ?>
<div class="sidebar left">
<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('add_place_sidebar'); } ?>
</div>
<?php } ?>
</div>


<script language="javascript" type="text/javascript">

function set_login_registration_frm(val)
{

	if(val=='existing_user')
	{
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = '';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}
<?php 
if($current_user->ID=='')
{
	if($user_login_or_not)
	{ ?>
	set_login_registration_frm('<?php echo $user_login_or_not;?>');
	<?php
	}
}
?>
var ptthemes_category_dislay = '<?php echo get_option('ptthemes_category_dislay');?>';
</script>
<?php 
$form_fields = array();

$form_fields['category'] = array(
				   'name'	=> 'category',
				   'espan'	=> 'category_span',
				   'type'	=> get_option('ptthemes_category_dislay'),
				   'text'	=> 'Please select Category',
				   'validation_type' => 'require');
global $custom_post_meta_db_table_name;
if(get_option('ptthemes_category_dislay') == 'select'){
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') and (field_category = '$category_id' or field_category = '0') order by sort_order");
} else {
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') order by sort_order");
}
while($res = mysql_fetch_array($extra_field_sql)){
	$title = $res['site_title'];
	$name = $res['htmlvar_name'];
	$type = $res['ctype'];
	//$require_msg = $res['field_require_desc'];
	if(function_exists('icl_register_string')){		
					$context = get_option('blogname');
					$require_msg = $res['field_require_desc'];
				
					$require_msg = icl_t($context,$require_msg,$require_msg);
				}else{
					$require_msg = $res['field_require_desc'];
				}
	$validation_type = $res['validation_type'];
	$form_fields[$name] = array(
				   'title'	=> $title,
				   'name'	=> $name,
				   'espan'	=> $name.'_error',
				   'type'	=> $type,
				   'text'	=> $require_msg,
				   'validation_type' => $validation_type);	
	
}
$validation_info = array();
 foreach($form_fields as $key=>$val)
			{			
				$str = ''; $fval = '';
				$field_val = $key.'_val';
				if(!isset($val['title']))
				   {
					 $val['title'] = '';   
				   }	
				$validation_info[] = array(
											   'title'	=> $val['title'],
											   'name'	=> $key,
											   'espan'	=> $key.'_error',
											   'type'	=> $val['type'],
											   'text'	=> $val['text'],
											   'validation_type'	=> $val['validation_type']);
			}
			
include_once(TT_MODULES_FOLDER_PATH.'general/submition_validation.php'); 
}else{ ?>
<div class="error_msg">
<?php _e(IP_BLOCK,'templatic'); ?>
</div>
<?php } 
  }else{ ?>
	<div class="error_msg">
<?php _e('Invalid token','templatic'); ?>
</div>
<?php
 } 
?>
<script type="text/javascript">
	<?php if(get_option('ptthemes_category_dislay') == 'select'){ ?>
		jQuery("#post_city_assign").val(jQuery('#post_city_id').val());
		jQuery("#category_assign").val(jQuery('#category_0').val());
	<?php } ?>	
	jQuery('#post_city_id').change(function() {
	  jQuery("#post_city_assign").val(this.value);
	});
	
</script>
<?php get_footer(); ?>