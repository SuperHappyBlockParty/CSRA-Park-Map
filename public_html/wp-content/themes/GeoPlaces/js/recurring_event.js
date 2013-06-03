jQuery("#event_type_1").click(function(){
	jQuery("#recurring_event").slideUp();
});
jQuery("#event_type_2").click(function(){
	jQuery('#recurrence-occurs').val('daily');
	jQuery("#recurring_event").slideDown();
	jQuery("#recurrence-perdays").hide();
	jQuery("#recurrence-perweek").hide();
	jQuery("#recurrence-perweeks").hide();
	jQuery("#recurrence-permonth").hide();
	jQuery("#recurrence-permonths").hide();
	jQuery("#recurrence-peryear").hide();
	jQuery("#recurrence-peryears").hide();
	jQuery("#weekly-days").hide();
	jQuery("#monthly-recurring").hide();
	jQuery("#monthly_opt_container").hide();
});

/** Below function will call on change of select box which returns recurrence frequencies **/
jQuery("#recurrence-per").keyup(function(){
	var rec_occurs = jQuery('#recurrence-occurs').val();
	var rec_per = jQuery("#recurrence-per").val();
	if(rec_occurs == 'daily' ){
			jQuery('#recurrence-perweek').hide();
			if(rec_per > 1){
				jQuery("#recurrence-perday").hide();
				jQuery("#recurrence-perdays").show();
			}else{
				jQuery("#recurrence-perday").show();
				jQuery("#recurrence-perdays").hide();
			}
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").hide();
			jQuery("#monthly_opt_container").hide();
	}else if(rec_occurs == 'weekly'){
			if(rec_per > 1){
				jQuery('#recurrence-perweek').hide();
				jQuery("#recurrence-perweeks").show();
			}else{
				jQuery('#recurrence-perweek').show();
				jQuery("#recurrence-perweeks").hide();
			}
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();			
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").show();
			jQuery("#monthly-recurring").hide();
			jQuery("#monthly_opt_container").hide();
	}else if(rec_occurs == 'monthly'){  	
			if(rec_per > 1){
				jQuery("#recurrence-permonth").hide();
				jQuery("#recurrence-permonths").show();
			}else{
				jQuery("#recurrence-permonth").show();
				jQuery("#recurrence-permonths").hide();
			}
			
			jQuery('#monthly_opt_container').show();
			jQuery('#recurrence-perweek').hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();			
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").hide();
	}else if(rec_occurs == 'yearly'){
			if(rec_per > 1){
				jQuery("#recurrence-peryear").hide();
				jQuery("#recurrence-peryears").show();
			}else{
				jQuery("#recurrence-peryear").show();
				jQuery("#recurrence-peryears").hide();
			}
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery('#recurrence-perweek').hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();			
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").show();
			jQuery("#monthly_opt_container").hide();
	}
});

/** Below function will call on change of select box which returns recurrence frequencies **/
jQuery("#recurrence-occurs").change(function(){
	var val =  jQuery("#recurrence-occurs").val();
	if(val == 'weekly'){
			jQuery('#recurrence-perweek').show();
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").show();
			jQuery("#monthly-recurring").hide();
			jQuery("#monthly_opt_container").hide();
	}else if(val == 'monthly'){
			jQuery('#recurrence-perweek').hide();
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-permonth").show();
			jQuery("#monthly_opt_container").show();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").show();
	}else if(val == 'yearly'){
			jQuery('#recurrence-perweek').hide();
			jQuery("#recurrence-perday").hide();
			jQuery("#recurrence-perdays").hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").show();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").hide();
			jQuery("#monthly_opt_container").hide();
	}else if(val == 'daily'){
			jQuery('#recurrence-perweek').hide();
			jQuery("#recurrence-perday").show();
			jQuery("#recurrence-perdays").hide();
			jQuery("#recurrence-perweeks").hide();
			jQuery("#recurrence-permonth").hide();
			jQuery("#recurrence-permonths").hide();
			jQuery("#recurrence-peryear").hide();
			jQuery("#recurrence-peryears").hide();
			jQuery("#weekly-days").hide();
			jQuery("#monthly-recurring").hide();
			jQuery("#monthly_opt_container").hide();
	}
});

jQuery(document).ready(function() {

	if(jQuery('.header_right .children ul li.current-menu-item a').html() == null) {
		jQuery('.currentmenu div').html('Menu');
	} else {
		jQuery('.currentmenu div').html(jQuery('.header_right .children ul li.current-menu-item a').html());
	}
	
	if(jQuery('.header_right div.menu ul li.current-menu-item a').html() == null) {
		jQuery('.currentmenu div').html('Menu');
	} else {
		jQuery('.currentmenu div').html(jQuery('.header_right div.menu ul li.current-menu-item a').html());
	}

    jQuery('.currentmenu,.currentmenu div').click(function(){
		jQuery(this).parent().find('.children').slideToggle('slow', function() {});
		jQuery(this).parent().find('.menu-header').slideToggle('slow', function() {});
		jQuery(this).parent().find('.menu-menu-container').slideToggle('slow', function() {});
	});

	if(jQuery('#main_navi .menu-header ul li.current-menu-item a').html() == null) {
		jQuery('.currentmenu2 span').html('Menu');
	} else {
		jQuery('.currentmenu2 span').html(jQuery('#main_navi .menu-header ul li.current-menu-item a').html());
	}

    jQuery('.currentmenu2,.currentmenu2 span').click(function(){
		jQuery(this).parent().find('.menu-header').slideToggle('slow', function() {});
		jQuery(this).parent().find('.menu-menu-container').slideToggle('slow', function() {});
	});
});