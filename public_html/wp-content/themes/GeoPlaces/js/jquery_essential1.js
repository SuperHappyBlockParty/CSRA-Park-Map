jQuery.noConflict();

jQuery(document).ready(function() { 

jQuery('ul.cart_top li:has(> ul)').addClass('cart_child');
jQuery('#content ul.thumb_view li:nth-child(3n+3)').addClass('last_thumb');
jQuery('#content ul.thumb_view li:nth-child(3n+3)').after('<div class="clearfix"></div>');
//jQuery('#content ul.realated_products .clearfix').remove();
jQuery('ul.cart_top li.cart_child').click(function () {

	jQuery(this).toggleClass('active');
	jQuery('ul .cart_content').toggle('fast');
	return false;

});

jQuery("ul.cart_content").hide();
jQuery('ul.cart_top li ul:has(> li.current-cat)').css({'display':'block'});
jQuery('ul.cart_top li:has(> ul li.current-cat)').addClass('heyHover');

// Tabs code on registration page
jQuery('.active_tab').fadeIn();
jQuery('.tab_link').live('click', function(event){

	event.preventDefault();
	
	jQuery('.tab_link_selected').removeClass('tab_link_selected');
	
	jQuery(this).addClass('tab_link_selected');

	var container_id = jQuery(this).attr('title');
	
	jQuery('.active_tab').animate({ 
		
		opacity : 'toggle' 
		
	},function(){
	
		jQuery(this).removeClass('active_tab');
		
		jQuery(container_id).addClass('active_tab');
		
		jQuery('.active_tab').animate({
		   
			opacity : 'toggle'
			
		});
	});
	
});

});
