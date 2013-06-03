<div class="wrapper" >
		<div class="clearfix container_message">
            	<h1 class="head2"><?php echo AUTHORISE_NET_MSG;?></h1>
            </div>

<?php
/*  Demonstration on using authorizenet.class.php.  This just sets up a
*  little test transaction to the authorize.net payment gateway.  You
*  should read through the AIM documentation at authorize.net to get
*  some familiarity with what's going on here.  You will also need to have
*  a login and password for an authorize.net AIM account and PHP with SSL and
*  curl support.
*
*  Reference http://www.authorize.net/support/AIM_guide.pdf for details on
*  the AIM API.
*/
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
if(isset($_SESSION['place_info']['price_select']) and $_SESSION['place_info']['price_select'] !=""){
$pkgopt = get_property_price_info($_SESSION['place_info']['price_select'],$_SESSION['place_info']['total_price']);
$desc = $_SESSION['place_info']['property_name'];
}else{
$pkgopt = get_property_price_info($_SESSION['event_info']['price_select'],$_SESSION['event_info']['total_price']);
$desc = $_SESSION['place_info']['property_name'];
}

$interval = $pkgopt->billing_num;
$unit = $pkgopt->billing_per;
if($unit == 'M'){
	$unit = "months";
}else if($unit == 'Y'){
	$unit = "years";
}else{
$unit = "days";
}
$unit;
global $payable_amount,$post_title,$last_postid,$current_user;
$display_name = $current_user->display_name;
$user_email = $current_user->user_email;
$user_phone = $current_user->user_phone;

$payable_amt = $payable_amount;

require_once(get_template_directory() . '/library/includes/payment/authorizenet/authorizenet.class.php');

$a = new authorizenet_class;

// You login using your login, login and tran_key, or login and password.  It
// varies depending on how your account is setup.
// I believe the currently reccomended method is to use a tran_key and not
// your account password.  See the AIM documentation for additional information.

$a->add_field('x_login', $paymentOpts['loginid']);
$a->add_field('x_tran_key', $paymentOpts['transkey']);
//$a->add_field('x_password', 'CHANGE THIS TO YOUR PASSWORD');

$a->add_field('x_version', '3.1');
$a->add_field('x_type', 'AUTH_CAPTURE');
//$a->add_field('x_test_request', 'TRUE');    // Just a test transaction
$a->add_field('x_relay_response', 'FALSE');

// You *MUST* specify '|' as the delim char due to the way I wrote the class.
// I will change this in future versions should I have time.  But for now, just
// make sure you include the following 3 lines of code when using this class.

$a->add_field('x_delim_data', 'TRUE');
$a->add_field('x_delim_char', '|');     
$a->add_field('x_encap_char', '');

// Using credit card number '4007000000027' performs a successful test.  This
// allows you to test the behavior of your script should the transaction be
// successful.  If you want to test various failures, use '4222222222222' as
// the credit card number and set the x_amount field to the value of the
// Response Reason Code you want to test. 
// For example, if you are checking for an invalid expiration date on the
// card, you would have a condition such as:
// if ($a->response['Response Reason Code'] == 7) ... (do something)
// Now, in order to cause the gateway to induce that error, you would have to
// set x_card_num = '4222222222222' and x_amount = '7.00'

//  Setup fields for payment information
$a->add_field('x_method', $_REQUEST['cc_type']);
$a->add_field('x_card_num', $_REQUEST['cc_number']);
//$a->add_field('x_card_num', '4007000000027');   // test successful visa
//$a->add_field('x_card_num', '370000000000002');   // test successful american express
//$a->add_field('x_card_num', '6011000000000012');  // test successful discover
//$a->add_field('x_card_num', '5424000000000015');  // test successful mastercard
// $a->add_field('x_card_num', '4222222222222');    // test failure card number
$a->add_field('x_amount', $payable_amt);
$a->add_field('x_invoice_num', $last_postid);
$a->add_field('x_exp_date', $_REQUEST['cc_month'].substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])));    // march of 2008
$a->add_field('x_card_code', $_REQUEST['cv2']);    // Card CAVV Security code
// Process the payment and output the results
switch ($a->process()) {

   case 1:  // Successs
     //payment_success
	$redirectUrl = home_url("/?ptype=payment_success&pid=".$last_postid);
	wp_redirect($redirectUrl);
	 break;     
   case 2:  // Declined
    $paymentFlag = 0;
	$_SESSION['display_message'] = $a->get_response_reason_text();
	  break;
     
   case 3:  // Error
     $paymentFlag = 0;
     $_SESSION['display_message'] = $a->get_response_reason_text();
	  break;
}

require_once(get_template_directory() . '/library/includes/payment/authorizenet/php_sdk/AuthorizeNet.php'); // Include the SDK you downloaded in Step 2
/*
$api_login_id = '44d9sFF6';
$transaction_key = '4326uXt933Tn2vEB';
*/
$api_login_id = $paymentOpts['loginid'];
$transaction_key = $paymentOpts['transkey'];
$amount = $payable_amt;
$fp_timestamp = time();
$fp_sequence = "123" . time(); // Enter an invoice or other unique number.
$fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id,
  $transaction_key, $amount, $fp_sequence, $fp_timestamp)
?>

<form  name="frm_payment_auth"  method='post' action="https://test.authorize.net/gateway/transact.dll">
<input type="hidden" name="x_response_code" value="1"/>
<input type="hidden" name="x_response_subcode" value="1"/>
<input type="hidden" name="x_response_reason_code" value="1"/>
<input type="hidden" name="x_response_reason_text" value="This transaction has been approved."/>
<input type='hidden' name="x_login" value="<?php echo $api_login_id; ?>" />
<input type='hidden' name="x_email" value="<?php echo $user_email; ?>" />
<input type='hidden' name="x_Description" value="<?php echo $desc ; ?>" />
<input type='hidden' name="x_intervalLength" value="<?php echo $interval; ?>" />
<input type='hidden' name="x_intervalUnit" value="<?php echo $unit; ?>" />
<input type='hidden' name="x_first_name" value="<?php echo $display_name; ?>" />
<input type='hidden' name="x_phone" value="<?php echo $user_phone; ?>" />
<input type='hidden' name="x_fp_hash" value="<?php echo $fingerprint; ?>" />
<input type='hidden' name="x_amount" value="<?php echo $amount; ?>" />
<input type='hidden' name="x_fp_timestamp" value="<?php echo $fp_timestamp; ?>" />
<input type='hidden' name="x_fp_sequence" value="<?php echo $fp_sequence; ?>" />
<input type='hidden' name="x_version" value="3.1">
<input type='hidden' name="x_show_form" value="payment_form">
<input type='hidden' name="x_test_request" value="false" />
<input type='hidden' name="x_invoice_num" value="<?php echo $last_postid; ?>">
<input type='hidden' name="x_method" value="<?php echo $_REQUEST['cc_type']; ?>">
<input type='hidden' name="x_card_num" value="<?php echo $_REQUEST['cc_number']; ?>">
<input type='hidden' name="x_exp_date" value="<?php echo $_REQUEST['cc_month'].substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])); ?>">
</form>
<script>
	setTimeout("document.frm_payment_auth.submit()",20); 
</script> 

<?php
   $errors = array();
    if ('POST' === $_SERVER['REQUEST_METHOD'])
    {
        $credit_card           = sanitize($_POST['cc_number']);
        $expiration_month      = (int) sanitize($_POST['cc_month']);
        $expiration_year       = (int) sanitize(substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])));
        $cvv                   = sanitize($_POST['cv2']);
        $cardholder_first_name = sanitize($user_fname);
        $cardholder_last_name  = sanitize('');

        $email                 = sanitize($user_email);
       

        if (!validateCreditcard_number($credit_card))
        {
            $errors['credit_card'] = "Please enter a valid credit card number";
        }
        if (!validateCreditCardExpirationDate($expiration_month, $expiration_year))
        {
            $errors['expiration_month'] = "Please enter a valid exopiration date for your credit card";
        }
        if (!validateCVV($credit_card, $cvv))
        {
            $errors['cvv'] = "Please enter the security code (CVV number) for your credit card";
        }
        if (empty($cardholder_first_name))
        {
            $errors['cardholder_first_name'] = "Please provide the card holder's first name";
        }
        if (empty($cardholder_last_name))
        {
            $errors['cardholder_last_name'] = "Please provide the card holder's last name";
        }
        
        // If there are no errors let's process the payment
        if (count($errors) === 0)
        {
            // Format the expiration date
            $expiration_date = sprintf("%04d-%02d", $expiration_year, $expiration_month);

            // Include the SDK
            require_once('./config.php');

            // Process the transaction using the AIM API
            $transaction = new AuthorizeNetAIM;
            $transaction->setSandbox(AUTHORIZENET_SANDBOX);
            $transaction->setFields(
                array(
                'amount' => '1.00',
                'card_num' => $credit_card,
                'exp_date' => $expiration_date,
                'first_name' => $cardholder_first_name,
                'last_name' => $cardholder_last_name,
                'address' => $billing_address,
                'city' => $billing_city,
                'state' => $billing_state,
                'zip' => $billing_zip,
                'email' => $email,
                'card_code' => $cvv,
                'ship_to_first_name' => $recipient_first_name,
                'ship_to_last_name' => $recipient_last_name,
                'ship_to_address' => $shipping_address,
                'ship_to_city' => $shipping_city,
                'ship_to_state' => $shipping_state,
                'ship_to_zip' => $shipping_zip,
                )
            );
            if ($response->approved)
            {
                // Transaction approved. Collect pertinent transaction information for saving in the database.
                $transaction_id     = $response->transaction_id;
                $authorization_code = $response->authorization_code;
                $avs_response       = $response->avs_response;
                $cavv_response      = $response->cavv_response;

                // Put everything in a database for later review and order processing
                // How you do this depends on how your application is designed
                // and your business needs.

                // Once we're finished let's redirect the user to a receipt page
               	$redirectUrl = home_url("/?ptype=payment_success&pid=".$last_postid);
				wp_redirect($redirectUrl);
                exit;
            }
            else if ($response->declined)
            {
                // Transaction declined. Set our error message.
                $errors['declined'] = 'Your credit card was declined by your bank. Please try another form of payment.';
            }
            else
            {
                // And error has occurred. Set our error message.
                $errors['error'] = 'We encountered an error while processing your payment. Your credit card was not charged. Please try again or contact customer service to place your order.';
            }
        }
    }

    function sanitize($value)
    {
        return trim(strip_tags($value));
    }

    function validateCreditcard_number($credit_card_number)
    {
        $firstnumber = substr($credit_card_number, 0, 1);

        switch ($firstnumber)
        {
            case 3:
                if (!preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 4:
                if (!preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 5:
                if (!preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            case 6:
                if (!preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
                {
                    return false;
                }
                break;
            default:
                return false;
        }

        $credit_card_number = str_replace('-', '', $credit_card_number);
        $map = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 2, 4, 6, 8, 1, 3, 5, 7, 9);
        $sum = 0;
        $last = strlen($credit_card_number) - 1;
        for ($i = 0; $i <= $last; $i++)
        {
            $sum += $map[$credit_card_number[$last - $i] + ($i & 1) * 10];
        }
        if ($sum % 10 != 0)
        {
            return false;
        }

        return true;
    }

    function validateCreditCardExpirationDate($month, $year)
    {
        if (!preg_match('/^\d{1,2}$/', $month))
        {
            return false;
        }
        else if (!preg_match('/^\d{4}$/', $year))
        {
            return false;
        }
        else if ($year < date("Y"))
        {
            return false;
        }
        else if ($month < date("m") && $year == date("Y"))
        {
            return false;
        }
        return true;
    }

    function validateCVV($cardNumber, $cvv)
    {
        $firstnumber = (int) substr($cardNumber, 0, 1);
        if ($firstnumber === 3)
        {
            if (!preg_match("/^\d{4}$/", $cvv))
            {
                return false;
            }
        }
        else if (!preg_match("/^\d{3}$/", $cvv))
        {
            return false;
        }
        return true;
    }
if (count($errors) === 0)
{
    // Format the expiration date
    $expiration_date = sprintf("%04d-%02d", $expiration_year, $expiration_month);

    // Include the SDK
    require_once('./config.php');

    // Process the transaction using the AIM API
    $transaction = new AuthorizeNetAIM;
    $transaction->setSandbox(AUTHORIZENET_SANDBOX);
    $transaction->setFields(
        array(
        'amount' => '1.00',
        'card_num' => $credit_card,
        'exp_date' => $expiration_date,
        'first_name' => $cardholder_first_name,
        'last_name' => $cardholder_last_name,
        'address' => $billing_address,
        'city' => $billing_city,
        'state' => $billing_state,
        'zip' => $billing_zip,
        'email' => $email,
        'card_code' => $cvv,
        'ship_to_first_name' => $recipient_first_name,
        'ship_to_last_name' => $recipient_last_name,
        'ship_to_address' => $shipping_address,
        'ship_to_city' => $shipping_city,
        'ship_to_state' => $shipping_state,
        'ship_to_zip' => $shipping_zip,
        )
    );
    $response = $transaction->authorizeAndCapture();
    if ($response->approved)
    {
        // Transaction approved. Collect pertinent transaction information for saving in the database.
        $transaction_id     = $response->transaction_id;
        $authorization_code = $response->authorization_code;
        $avs_response       = $response->avs_response;
        $cavv_response      = $response->cavv_response;

        // Put everything in a database for later review and order processing
        // How you do this depends on how your application is designed
        // and your business needs.

        // Once we're finished let's redirect the user to a receipt page
        header('Location: thank-you-page.php');
        exit;
    }
    else if ($response->declined)
    {
        // Transaction declined. Set our error message.
        $errors['declined'] = 'Your credit card was declined by your bank. Please try another form of payment.';
    }
    else
    {
        // And error has occurred. Set our error message.
        $errors['error'] = 'We encountered an error while processing your payment. Your credit card was not charged. Please try again or contact customer service to place your order.';

        // Collect transaction response information for possible troubleshooting
        // Since our application won't be doing this we'll comment this out for now.
        //
        // $response_subcode     = $response->response_subcode;
        // $response_reason_code = $response->response_reason_code;
    }
}