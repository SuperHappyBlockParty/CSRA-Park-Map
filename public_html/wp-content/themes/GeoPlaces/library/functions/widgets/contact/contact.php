<?php
// =============================== Login Widget ======================================
class contact_widget extends WP_Widget {
	function contact_widget() {
	//Constructor
		$widget_ops = array('classname' => 'Contact Us', 'description' => apply_filters('templ_contact_widget_desc_filter',__('A simple contact form where site visitors can send you a message with their name and email address.','templatic')) );		
		$this->WP_Widget('widget_contact', apply_filters('templ_contact_widget_title_filter',__('T &rarr; Contact us','templatic')), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
			
    <div class="widget contact_widget" id="contact_widget">
    <?php if($title){?> <h3><?php _e($title,'templatic');?></h3><?php }?>
            
       		<?php
if($_POST && $_POST['contact_widget'])
{
	if($_POST['your-email'])
	{
		$toEmailName = get_option('blogname');
		$toEmail = get_site_emailId();
		
		$subject = $_POST['your-subject'];
		$message = '';
		$message .= '<p>Dear '.$toEmailName.',</p>';
		$message .= '<p>Name : '.$_POST['your-name'].',</p>';
		$message .= '<p>Email : '.$_POST['your-email'].',</p>';
		$message .= '<p>Message : '.nl2br($_POST['your-message']).'</p>';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
		$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
		$headers .= 'From: '.$_POST['your-name'].' <'.$_POST['your-email'].'>' . "\r\n";
		$message = stripslashes($message);
		// Mail it
		templ_sendEmail($_POST['your-email'],$_POST['your-name'],$toEmail,$toEmailName,$subject,$message);
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&msg=success'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?msg=success'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";
		
	}else
	{
		if(strstr($_REQUEST['request_url'],'?'))
		{
			$url =  $_REQUEST['request_url'].'&err=empty'	;	
		}else
		{
			$url =  $_REQUEST['request_url'].'?err=empty'	;
		}
		echo "<script type='text/javascript'>location.href='".$url."#contact_widget';</script>";	
	}
}
?>
<?php
if($_REQUEST['msg'] == 'success')
{
?>
	<p class="success_msg"><?php echo apply_filters('templ_contact_widget_successmsg_filter',__('Thank you, your information is sent successfully.','templatic'));?></p>
<?php
}elseif($_REQUEST['err'] == 'empty')
{
?>
	<p class="error_msg"><?php echo apply_filters('templ_contact_widget_errormsg_filter',__('Please fill out all the fields before submitting.','templatic'));?></p>
<?php
}
?>
  <script type="text/javascript">
  var $cwidget = jQuery.noConflict();
$cwidget(document).ready(function(){

	//global vars
	var contact_widget_frm = $cwidget("#contact_widget_frm");
	var your_name = $cwidget("#widget_your-name");
	var your_email = $cwidget("#widget_your-email");
	var your_subject = $cwidget("#widget_your-subject");
	var your_message = $cwidget("#widget_your-message");
	
	var your_name_Info = $cwidget("#widget_your_name_Info");
	var your_emailInfo = $cwidget("#widget_your_emailInfo");
	var your_subjectInfo = $cwidget("#widget_your_subjectInfo");
	var your_messageInfo = $cwidget("#widget_your_messageInfo");
	
	//On blur
	your_name.blur(validate_widget_your_name);
	your_email.blur(validate_widget_your_email);
	your_subject.blur(validate_widget_your_subject);
	your_message.blur(validate_widget_your_message);

	//On key press
	your_name.keyup(validate_widget_your_name);
	your_email.keyup(validate_widget_your_email);
	your_subject.keyup(validate_widget_your_subject);
	your_message.keyup(validate_widget_your_message);

	//On Submitting
	contact_widget_frm.submit(function(){
		if(validate_widget_your_name() & validate_widget_your_email() & validate_widget_your_subject() & validate_widget_your_message())
		{
			hideform();
			return true
		}
		else
		{
			return false;
		}
	});

	//validation functions
	function validate_widget_your_name()
	{
		if($cwidget("#widget_your-name").val() == '')
		{
			your_name.addClass("error");
			your_name_Info.text("<?php _e('Please Enter Name','templatic'); ?>");
			your_name_Info.addClass("message_error");
			return false;
		}
		else
		{
			your_name.removeClass("error");
			your_name_Info.text("");
			your_name_Info.removeClass("message_error");
			return true;
		}
	}

	function validate_widget_your_email()
	{
		var isvalidemailflag = 0;
		if($cwidget("#widget_your-email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($cwidget("#widget_your-email").val() != '')
		{
			var a = $cwidget("#widget_your-email").val();
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
			your_email.addClass("error");
			your_emailInfo.text("<?php _e('Please Enter valid Email','templatic'); ?>");
			your_emailInfo.addClass("message_error");
			return false;
		}else
		{
			your_email.removeClass("error");
			your_emailInfo.text("");
			your_emailInfo.removeClass("message_error");
			return true;
		}
	}

	

	function validate_widget_your_subject()
	{
		if($cwidget("#widget_your-subject").val() == '')
		{
			your_subject.addClass("error");
			your_subjectInfo.text("<?php _e('Please Enter Subject','templatic'); ?>");
			your_subjectInfo.addClass("message_error");
			return false;
		}
		else{
			your_subject.removeClass("error");
			your_subjectInfo.text("");
			your_subjectInfo.removeClass("message_error");
			return true;
		}
	}

	function validate_widget_your_message()
	{
		if($cwidget("#widget_your-message").val() == '')
		{
			your_message.addClass("error");
			your_messageInfo.text("<?php _e('Please Enter Message','templatic'); ?>");
			your_messageInfo.addClass("message_error");
			return false;
		}
		else{
			your_message.removeClass("error");
			your_messageInfo.text("");
			your_messageInfo.removeClass("message_error");
			return true;
		}
	}

});
  
  </script>          
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" id="contact_widget_frm" name="contact_frm" class="wpcf7-form">
    <input type="hidden" name="contact_widget" value="1" />
    <input type="hidden" name="request_url" value="<?php echo $_SERVER['REQUEST_URI'];?>" />

    <div class="form_row "> <label> <?php _e('Name','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-name" id="widget_your-name" value="" class="textfield" size="40" />
        <span id="widget_your_name_Info" class="error"><?php _e('','templatic'); ?></span>
   </div>
   
    <div class="form_row "><label><?php _e('Email','templatic');?>  <span class="indicates">*</span></label>
        <input type="text" name="your-email" id="widget_your-email" value="" class="textfield" size="40" /> 
        <span id="widget_your_emailInfo"  class="error"></span>
  </div>
          
       <div class="form_row "><label><?php _e('Subject','templatic');?> <span class="indicates">*</span></label>
        <input type="text" name="your-subject" id="widget_your-subject" value="" size="40" class="textfield" />
        <span id="widget_your_subjectInfo"></span>
        </div>     
          
    <div class="form_row"><label><?php _e('Message','templatic');?> <span class="indicates">*</span></label>
     <textarea name="your-message" id="widget_your-message" cols="40" class="textarea textarea2" rows="10"></textarea> 
    <span id="widget_your_messageInfo"  class="error"></span>
    </div>
        <input type="submit" value="<?php _e('Send','templatic');?>" class="b_submit" />  
  </form> 

</div>
        
 	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => '') );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
	}}
register_widget('contact_widget');
?>