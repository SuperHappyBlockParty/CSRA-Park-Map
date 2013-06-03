<?php
$notification_email = array();

$content = array();
$content['title'] = __('Successful post submission email to the administrator','templatic');
$content['subject'] = array('post_submited_success_email_subject',__('Listing submitted successfully ','templatic'));
$content['content'] = array('post_submited_success_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>'.__('Following informations have been submitted. </p><p>This email is just for your knowledge.','templatic').'.</p><p>[#information_details#]</p><br><p>'.__('We hope you enjoy. Thanks','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;


$content = array();
$content['title'] = __('Successful post submission email to the user','templatic');
$content['subject'] = array('post_submited_success_email_user_subject',__('Listing submitted successfully','templatic'));
$content['content'] = array('post_submited_success_email_user_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>'.__('You Submitted below information. </p><p>This email is just for your knowledge','templatic').'.</p><p>[#information_details#]</p><br><p>'.__('We hope you enjoy. Thanks','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Payment success email to client','templatic');
$content['subject'] = array('post_payment_success_client_email_subject',__('Payment received thank you','templatic'));
$content['content'] = array('post_submited_success_admin_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>[#transaction_details#]</p><br><p>'.__('Payment received thank you !','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Payment success email to administrator ','templatic');
$content['subject'] = array('post_payment_success_admin_email_subject',__('Payment received successfully','templatic'));
$content['content'] = array('post_payment_success_admin_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>[#transaction_details#]</p><br><p>'.__('Payment received successfully!','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Registration success email','templatic');
$content['subject'] = array('registration_success_email_subject',__('Your login details','templatic'));
$content['content'] = array('registration_success_email_content','<p>'.__('Dear','templatic').' [#user_name#],</p>
<p>'.__('You can login with the following information','templatic').':</p><p>'.__('Username','templatic').': [#user_login#]</p><p>'.PASSWORD_TEXT.': [#user_password#]</p>
<p>'.__('You can login from ','templatic').' [#site_login_url#] '.__('or the URL is','templatic').' : [#site_login_url_link#] .</p><br><p>'.__('Thank you for registering !','templatic').'!</p>
<p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Send inquiry email','templatic');
$content['subject'] = array('send_inquiry_email_subject',__('Listing inquiry','templatic'));
$content['content'] = array('send_inquiry_email_content','<p>Dear [#to_name#],</p><p>'.__('You have received an inquiry for','templatic').' <b>[#post_title#]</b>. </p><p>'.__('Below is the message.','templatic').'. </p><p><b>'.__('Subject','templatic').' : [#frnd_subject#]</b>.</p><p>[#frnd_comments#]</p><p>'.__('Thank you,','templatic').',<br /> [#your_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Post expiry notification email','templatic');
$content['subject'] = array('post_expiry_email_subject',__('Listing expiration Notification','templatic'));
$content['content'] = array('post_expiry_email_content',"<p>Dear [#to_name#],<p><p>Your listing -<a href=\"[#post_link#]\"><b>[#post_title#]</b></a> posted on  <u>[#post_date#]</u> for [#alive_days#].</p><p>It's going to expiry after [#grace_days#] day(s). If the listing expire, it will no longer appear on the site.</p><p> If you want to renew, Please login to your member area of our site and renew it as soon as it expire. You may like to login the site from <a href=\"[#site_login_url_link#]\">[#site_login_url#]</a>.</p><p>Your login ID is <b>[#user_login#]</b> and Email ID is <b>[#user_email#]</b>.</p><p>Thank you,<br />[#site_name#].</p>");
$content['status'] = '1';
$notification_email[] = $content;

$notification_email = apply_filters('templ_email_notifications_filter',$notification_email);  //wp-admin email notification content controller filter

//////////////////////////////////////////////////////////////////////////
$notification_msg = array();

$content = array();
$content['title'] = __('Successful listing submission notification','templatic');
$content['content'] = array('post_added_success_msg_content','<p>'.__('Thank you for your submission, your information has been successfully received.','templatic').'.</p><p><a href="[#submited_information_link#]" >'.__('View your submitted information','templatic').' &raquo;</a></p>
<p>'.__('Thank you for visiting us at','templatic').' [#site_name#].</p>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment successful notification','templatic');
$content['content'] = array('post_payment_success_msg_content','<h4>'.__('Your payment has been successfully received and your listing has now been published.','templatic').'.</h4><p><a href="[#submited_information_link#]" >'.__('View your submitted information','templatic').' &raquo;</a></p>
<h5>'.__('Thank you for registering at','templatic').' [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment canceled notification','templatic');
$content['content'] = array('post_payment_cancel_msg_content','<h3>'.__('Your listing has been cancelled !','templatic').'.</h3>
<h5>'.__('Thank you for visiting','templatic').' [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment via bank transfer success notification','templatic');
$content['content'] = array('post_pre_bank_trasfer_msg_content','<p>'.__('Thank you, your request has been successfully received.','templatic').'.</p>
<p>'.__('To publish the listing, please transfer the amount of','templatic').' <u>[#order_amt#]</u> '.__('at our bank with the following information','templatic').' :</p><p>'.__('Bank Name','templatic').' : [#bank_name#]</p><p>'.__('Account Number','templatic').' : [#account_number#]</p><br><p>'.__('Please include the Submission ID as reference ','templatic').' :#[#orderId#]</p><p><a href="[#submited_information_link#]" >'.__('View your submitted listing','templatic').' &raquo;</a>
<br><p>Thank you for visiting [#site_name#].</p>');
$notification_msg[] = $content;

$notification_msg = apply_filters('templ_msg_notifications_filter',$notification_msg);  //wp-admin message notification content controller filter
?>