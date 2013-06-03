/*
 * SimpleModal Basic Modal Dialog
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2009 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: basic.js 212 2009-09-03 05:33:44Z emartin24 $
 *
 */
var $c = jQuery.noConflict();
$c(document).ready(function () {
	$c('a.c_sendtofriend').click(function (e) {
   		jQuery(document).ready(function() {
			// Duplicate our reCapcha 
			var captcha = jQuery('#capsaved').val();
			jQuery('#owner_frm').html(captcha);
			jQuery('#myrecap').html('');
			jQuery('#inquiry_frm_popup').html('');
			jQuery('#popup_frms').html('');
			
		});
		e.preventDefault();
		$c('#claim_listing').modal();
	});

	
});

var $s = jQuery.noConflict();

	$s('a.i_sendtofriend').click(function (e) {
			jQuery(document).ready(function() {
			// Duplicate our reCapcha 
			var captcha = jQuery('#capsaved').val();
			jQuery('#inquiry_frm_popup').html(captcha);
			jQuery('#myrecap').html('');
			jQuery('#owner_frm').html('');
			jQuery('#popup_frms').html('');
		});

		e.preventDefault();
		$s('#inquiry_div').modal();
	});
	
var $m = jQuery.noConflict();

	$m('a.b_sendtofriend').click(function (e) {

			var captcha = jQuery('#capsaved').val();
			jQuery('#popup_frms').html(captcha);
			jQuery('#myrecap').html('');
			jQuery('#inquiry_frm_popup').html('');
			jQuery('#owner_frm').html('');

		e.preventDefault();
		$m('#basic-modal-content').modal();
	});