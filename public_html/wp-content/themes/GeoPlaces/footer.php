</div>
<!-- /Container #end -->
<?php templ_content_end(); // content end hooks?>
<?php get_template_part( 'footer_bottom' ); // footer bottom. ?>
 
 

</div>




<script type="text/javascript">
/* <![CDATA[ */
function addToFavourite(post_id,action)
{
 	<?php 
	global $current_user;
	if($current_user->ID==''){ 
	?>
	window.location.href="<?php echo home_url(); ?>/?ptype=login&amp;page1=sign_in";
	<?php 
	} else {
	?>
	var fav_url; 
	if(action == 'add')
	{
		 
		fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=add&pid='+post_id;
	}
	else
	{
		fav_url = '<?php echo home_url(); ?>/index.php?ptype=favorite&action=remove&pid='+post_id;
		
	}
	var $ac = jQuery.noConflict();
	$ac.ajax({	
		url: fav_url ,
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			alert('Error loading agent favorite property.');
		},
		success: function(html){	
		<?php 
		if($_REQUEST['list']=='favourite')
		{ ?>
			//document.getElementById('list_property_'+post_id).style.display='none';	
			document.getElementById('post_'+post_id).style.display='none';	
			<?php
		}
		?>	
			document.getElementById('favorite_property_'+post_id).innerHTML=html;								
		}
	});
	return false;
	<?php } ?>
}
/* ]]> */
</script>
<?php wp_footer(); ?>
<?php echo (get_option('ga')) ? get_option('ga') : '' ?>
<?php templ_body_end(); // Body end hooks?>

	</body>
</html>