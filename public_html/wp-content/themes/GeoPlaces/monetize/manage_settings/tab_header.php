<?php include TT_ADMIN_TPL_PATH.'header.php'; ?>
<div class="info top-info"></div>
<div class="ajax-message<?php if ( isset( $message ) ) { echo ' show'; } ?>">
	<?php if ( isset( $message ) ) { echo $message; } ?>
</div>
	<div id="content">
		<div id="options_tabs">
			<ul class="options_tabs">
				<li><a href="#option_emails"><?php _e('E-mail Notifications &amp; Messages','templatic');?></a><span></span></li>
				<li><a href="#option_set_role"><?php _e('Permissions Settings','templatic');?></a><span></span></li>
				<li><a href="#option_display_custom_fields"><?php _e('Custom Fields Settings','templatic');?></a><span></span></li>
				<li><a href="#option_display_custom_usermeta"><?php _e('User Profile Fields Settings','templatic');?></a><span></span></li>
				<li><a href="#option_display_icons" onclick="show_categories();"><?php _e('Category Settings','templatic');?></a><span></span></li>					
				<li><a href="#option_display_city"><?php _e('City Settings','templatic');?></a><span></span></li>					
				<li><a href="#option_display_price"><?php _e('Price Packages Settings','templatic');?></a><span></span></li>
				<li><a href="#currency_setup"><?php _e('Currency Settings','templatic');?></a><span></span></li>					
				<li><a href="#option_payment"><?php _e('Payment Settings','templatic');?></a><span></span></li>
				<li><a href="#option_transaction_settings"><?php _e('Transaction Reports','templatic');?></a><span></span></li>				
				<li><a href="#option_display_coupon"><?php _e('Coupons Settings','templatic');?></a><span></span></li>	
				<li><a href="#option_bulk_upload"><?php _e('Bulk Uploads','templatic');?></a><span></span></li>
				<li><a href="#option_ip_settings"><?php _e('IP Manager','templatic');?></a><span></span></li>
			
			</ul> 