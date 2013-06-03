<?php 
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['merchantid'];
$returnUrl = $paymentOpts['returnUrl'];
$cancel_return = $paymentOpts['cancel_return'];
$notify_url = $paymentOpts['notify_url'];
$currency_code = get_option('currency_symbol');
global $payable_amount,$post_title,$last_postid,$trans_id,$is_recurring,$package_id;
?>
<form name="frm_payment_method" action="https://secure.paypal.com/cgi-bin/webscr" method="post">
<?php if($is_recurring == '1') { ?>
<input type="hidden" value="<?php echo $payable_amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $payable_amount;?>" name="a3"/>
<input type="hidden" value="<?php echo $billing_per;?>" name="t3"/>
<input type="hidden" value="<?php echo $billing_num;?>" name="p3"/>
<input type="hidden" value="<?php echo $billing_cycle;?>" name="srt"/>
<input type="hidden" value="1" name="src"/>
<input type="hidden" value="<?php echo $returnUrl;?>&pid=<?php echo $last_postid;?>&trans_id=<?php echo $trans_id; ?>" name="return"/>
<input type="hidden" value="<?php echo $cancel_return;?>&pid=<?php echo $last_postid;?>&trans_id=<?php echo $trans_id; ?>" name="cancel_return"/>
<input type="hidden" value="<?php echo $notify_url;?>" name="notify_url"/>
<input type="hidden" value="subscr_cancel" name="txn_type"/>
<input type="hidden" value="_xclick-subscriptions" name="cmd"/>
<?php }  else { ?>
<input type="hidden" value="<?php echo $payable_amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $returnUrl;?>&pid=<?php echo $last_postid;?>&trans_id=<?php echo $trans_id; ?>" name="return"/>
<input type="hidden" value="<?php echo $cancel_return;?>&pid=<?php echo $last_postid;?>&trans_id=<?php echo $trans_id; ?>" name="cancel_return"/>
<input type="hidden" value="<?php echo $notify_url;?>" name="notify_url"/>
<input type="hidden" value="_xclick" name="cmd"/>
<?php }?>
<input type="hidden" value="<?php echo $post_title;?>" name="item_name"/>
<input type="hidden" value="<?php echo $merchantid;?>" name="business"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency_code"/>
<input type="hidden" value="<?php echo $last_postid;?>" name="custom" />
<input type="hidden" name="no_note" value="1"/>
<input type="hidden" name="no_shipping" value="1"/>
<input type="hidden" name="rm" value="1"/>
</form>
<div class="wrapper" >
	<div class="clearfix container_message">
       	<center><h1 class="head2"><?php echo PAYPAL_MSG;?></h1></center>
    </div>
</div>
<script>
	setTimeout("document.frm_payment_method.submit()",50); 
</script> 