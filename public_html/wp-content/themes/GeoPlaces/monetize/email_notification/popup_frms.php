<script type='text/javascript' src='<?php echo get_bloginfo('template_directory'); ?>/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='<?php echo get_bloginfo('template_directory'); ?>/js/basic.js'></script>
<?php if(get_option('ptthemes_inquiry_on_detailpage') == 'No') { ?>
 <div id="myrecap" style="display:none;">
		   <?php $display = get_option('ptthemes_captcha_dislay');
		   /* CONDITION IF NONE OF THEM SELECTED */
		   if($display != 'None of them')
		   {
				$a = get_option("recaptcha_options");
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if( file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')){
					//require_once(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
					echo '<label>'.WORD_VERIFICATION.' : </label>  <span>*</span>';
					$publickey = $a['public_key']; // you got this from the signup page
					echo recaptcha_get_html($publickey); 
				}
		   }?>
            </div>
            <input type="hidden" value="" id="capsaved"  />
            <script type="text/javascript">
				jQuery('#capsaved').val(jQuery('#myrecap').html());
			</script>
<?php } ?>
<div id="basic-modal-content" class="clearfix" style="display:none;">
<?php global $post,$wp_query; ?>
<form name="send_to_frnd" id="send_to_frnd" action="#" method="post">
 
<input type="hidden" id="post_id" name="post_id" value="<?php echo $post->ID;?>"/>
<input type="hidden" id="link_url" name="link_url" value="<?php	the_permalink();?>"/>
<input type="hidden" id="send_to_Frnd_pid" name="pid" />
<input type="hidden" name="sendact" value="email_frnd" />
	<h3><?php _e('Send To Friend','templatic');?></h3>
	
			<p id="reply_send_success" class="success_msg" style="display:none;"></p>
		
			<div class="row clearfix" ><label><?php _e('Friend&rsquo;s name','templatic');?> : <span>*</span></label> <input name="to_name_friend" id="to_name_friend" type="text"  /><span id="to_name_friendInfo"></span></div>
	
		 	<div class="row  clearfix" ><label> <?php _e('Friend&rsquo;s email','templatic');?> : <span>*</span></label> <input name="to_friend_email" id="to_friend_email" type="text"  value=""/><span id="to_friend_emailInfo"></span></div>
		
			<div class="row  clearfix" ><label><?php _e('Your name','templatic');?> : <span>*</span></label> <input name="yourname" id="yourname" type="text"  /><span id="yournameInfo"></span></div>
		
		 	<div class="row  clearfix" ><label> <?php _e('Your email','templatic');?> : <span>*</span></label> <input name="youremail" id="youremail" type="text"  /><span id="youremailInfo"></span></div>
		
			<div class="row  clearfix" ><label><?php _e('Subject','templatic');?> : </label> <input name="frnd_subject" value="<?php _e('About','templatic');?>" id="frnd_subject" type="text"  /></div>
		
			<div class="row textarea_row  clearfix" ><label><?php _e('Comments','templatic');?> : </label> <textarea name="frnd_comments" id="frnd_comments" cols="10" rows="5" ><?php _e('Hello, I just stumbled upon this listing and thought you might like it. Just check it out.','templatic'); ?></textarea></div>
			<div id="popup_frms"></div>
			<div class="row  clearfix" >
				<input name="Send" type="submit" value="<?php _e('Send','templatic')?> " class="button " />
            </div>
		
</form>
</div>
<?php 
if(@$_POST['yourname'])
{
	$display = get_option('ptthemes_captcha_dislay');
	if(file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && plugin_is_active('wp-recaptcha')&& $display != 'None of them'){ 
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) { 
		echo "<script> alert('Invalid captcha');</script>";
		return false;	
		} 
	}
	$yourname = $_POST['yourname'];
	$youremail = $_POST['youremail'];
	$frnd_subject = $_POST['frnd_subject'];
	$frnd_comments = $_POST['frnd_comments'];
	$to_friend_email = $_POST['to_friend_email'];
	$to_name = $_POST['to_name_friend'];
	///////Inquiry EMAIL START//////
	global $General,$wpdb;
	global $upload_folder_path;
	$post_title = $post->post_title;
	$email_content = get_option('post_send_to_friend_email_content');
	$email_subject = get_option('post_send_to_friend_email_subject');
	
	
	if($email_content == "" && $email_subject=="")
	{
		$message1 =  __('[SUBJECT-STR]You might be interested in [SUBJECT-END]
		<p>Dear [#$to_name#],</p>
		<p>[#$frnd_comments#]</p>
		<p>Link : <b>[#$post_title#]</b> </p>
		<p>From, [#$your_name#]</p>','templatic');
		$filecontent_arr1 = explode('[SUBJECT-STR]',$message1);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		if($subject == '')
		{
			$subject = $frnd_subject;
		}
		$client_message = $filecontent_arr2[1];
	}
	$subject = $frnd_subject;
	
	$post_url_link = '<a href="'.$_REQUEST['link_url'].'">'.$post_title.'</a>';
	/////////////customer email//////////////
	$yourname_link = __($yourname.'<br>Sent from - <b><a href="'.get_option('home').'">'.get_option('blogname').'</a></b>.','templatic');
	$search_array = array('[#$to_name#]','[#$post_title#]','[#$frnd_comments#]','[#$your_name#]','[#$post_url_link#]');
	$replace_array = array($to_name,$post_url_link,nl2br($frnd_comments),$yourname_link,$post_url_link);
	$client_message = str_replace($search_array,$replace_array,$client_message);
	$client_message = stripslashes($client_message);
	templ_sendEmail($youremail,$yourname,$to_friend_email,$to_name,$subject,$client_message,$extra='');///To clidne email
	//////Inquiry EMAIL END////////	
	echo "<script>alert('Email sent successfully');location.href='".$_REQUEST['link_url']."'</script>";
	
	
}
?>
<script type="text/javascript">
var $q = jQuery.noConflict();
$q(document).ready(function(){

//global vars
	var send_to_frnd = $q("#send_to_frnd");
	var to_name_friend = $q("#to_name_friend");
	var to_name_friendInfo = $q("#to_name_friendInfo");
	var to_friend_email = $q("#to_friend_email");
	var to_friend_emailInfo = $q("#to_friend_emailInfo");

	var yourname = $q("#yourname");

	var yournameInfo = $q("#yournameInfo");

	var youremail = $q("#youremail");

	var youremailInfo = $q("#youremailInfo");

	var frnd_comments = $q("#frnd_comments");

	var frnd_commentsInfo = $q("#frnd_commentsInfo");

	

	//On blur

	to_name_friend.blur(validate_to_name_friend);

	to_friend_email.blur(validate_to_email_to);

	yourname.blur(validate_yourname);

	youremail.blur(validate_youremail);

	frnd_comments.blur(validate_frnd_comments);

	

	//On key press

	to_name_friend.keyup(validate_to_name_friend);

	to_friend_email.keyup(validate_to_email_to);

	yourname.keyup(validate_yourname);

	youremail.keyup(validate_youremail);

	frnd_comments.keyup(validate_frnd_comments);

	

	//On Submitting

	send_to_frnd.submit(function(){

		if(validate_to_name_friend() & validate_to_email_to() & validate_yourname() & validate_youremail() & validate_frnd_comments())

		{

			function reset_send_email_agent_form()
			{
				document.getElementById('to_name_friend').value = '';
				document.getElementById('to_friend_email').value = '';
				document.getElementById('yourname').value = '';
				document.getElementById('youremail').value = '';	
				document.getElementById('frnd_subject').value = '';
				document.getElementById('frnd_comments').value = '';	
			}
			return true

		}

		else

		{

			return false;

		}

	});



	//validation functions

	function validate_to_name_friend()
	{
		if($q("#to_name_friend").val() == '')
		{
			to_name_friend.addClass("error");
			to_name_friendInfo.text("<?php _e('Please enter your friend\'s name','templatic'); ?>");
			to_name_friendInfo.addClass("message_error2");
			return false;
		}else{
			to_name_friend.removeClass("error");
			to_name_friendInfo.text("");
			to_name_friendInfo.removeClass("message_error2");
			return true;
		}
	}
	function validate_to_email_to()
	{
		var isvalidemailflag = 0;

		if(to_friend_email.val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($q("#to_friend_email").val() != '')
		{
			var a = $q("#to_friend_email").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			to_friend_email.addClass("error");
			to_friend_emailInfo.text("<?php _e('Please enter your friend\'s valid email address','templatic'); ?>");

			to_friend_emailInfo.addClass("message_error2");
			return false;
		}else
		{
			to_friend_email.removeClass("error");
			to_friend_emailInfo.text("");
			to_friend_emailInfo.removeClass("message_error");
			return true;
		}
	}
	function validate_yourname()
	{
		if($q("#yourname").val() == '')
		{
			yourname.addClass("error");
			yournameInfo.text("<?php _e('Please Enter Your Name','templatic'); ?>");
			yournameInfo.addClass("message_error2");
			return false;
		}
		else{
			yourname.removeClass("error");
			yournameInfo.text("");
			yournameInfo.removeClass("message_error2");
			return true;
		}
	}
	function validate_youremail()
	{
		var isvalidemailflag = 0;
		if($q("#youremail").val() == '')
		{
			isvalidemailflag = 1;

		}else
		if($q("#youremail").val() != '')
		{
			var a = $q("#youremail").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			youremail.addClass("error");
			youremailInfo.text("<?php _e('Please enter your valid email address','templatic'); ?>");
			youremailInfo.addClass("message_error2");
			return false;
		}else
		{
			youremail.removeClass("error");
			youremailInfo.text("");
			youremailInfo.removeClass("message_error");
			return true;
		}
	}
	function validate_frnd_comments()
	{
		if($q("#frnd_comments").val() == '')
		{
			frnd_comments.addClass("error");
			frnd_commentsInfo.text("<?php _e('Please Enter Comments','templatic'); ?>");
			frnd_commentsInfo.addClass("message_error2");
			return false;
		}else{
			frnd_comments.removeClass("error");
			frnd_commentsInfo.text("");
			frnd_commentsInfo.removeClass("message_error2");
			return true;
		}
	}
});
</script>
<!-- here -->