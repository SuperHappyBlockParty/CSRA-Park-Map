
<?php
if(!function_exists('get_my_event_calendar'))
{
function get_my_event_calendar()
{
	
	?> 
    <div id="eventcal" align="center">
    
    </div>
  
<?php }}?>
<script language='javascript'>
function change_calendar(mnth,yr)
{  	

	  document.getElementById("eventcal").innerHTML="<img src='<?php echo get_template_directory_uri()."/library/calendar/process.gif"; ?>' alt='Processing....'/>";
	
	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	   
	   xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("eventcal").innerHTML=xmlhttp.responseText;
		}
	  } 
	<?php 
		if(is_plugin_active('wpml-translation-management/plugin.php')){
			global $sitepress;
			$current_lang_code= ICL_LANGUAGE_CODE;
			$language="language=".$current_lang_code;
		}
	?>
	  url = "<?php echo get_template_directory_uri(); ?>/library/calendar/ajax_calendar.php?<?php echo $language;?>&mnth="+mnth+"&yr="+yr

	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
} 
</script>
<script language='javascript'>
function show_calendar()
{  	

	  document.getElementById("eventcal").innerHTML="<img src='<?php echo get_template_directory_uri()."/library/calendar/process.gif"; ?>' alt='Processing....'/>";
	
	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	   
	   xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("eventcal").innerHTML=xmlhttp.responseText;
		}
	  } 
	<?php 
		if(is_plugin_active('wpml-translation-management/plugin.php')){
			global $sitepress;
			$current_lang_code= ICL_LANGUAGE_CODE;
			$language="language=".$current_lang_code;
		}
	?>
	  url = "<?php echo get_template_directory_uri(); ?>/library/calendar/ajax_calendar.php?<?php echo $language;?>"

	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
} 
function display_data(data){
	 document.getElementById(data).style.display ='block';
}
</script>

<script>
//call after page loaded
window.onload = show_calendar ; 
</script>