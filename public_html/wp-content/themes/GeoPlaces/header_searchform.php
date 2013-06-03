<?php
if(isset($_REQUEST['s']) && $_REQUEST['s'] != ""){
	if($_REQUEST['s'] =='cal_event'){
	$s ='';
	}else{
	$s = $_REQUEST['s'];
	}
}
if(isset($_REQUEST['sn']) && $_REQUEST['sn'] != ""){
	$sn = $_REQUEST['sn'];
}
?>

<div class="searchform">
  <form method="get" id="searchform2" action="<?php echo get_bloginfo('url')."/"; ?>"> 
   <input type="hidden" name="t" value="1" />
    <span class="searchfor"><input type="text" name="s" id="sr" class="s" PLACEHOLDER="<?php echo SEARCH;?>" value="<?php echo $s; ?>" />
     <small class="text"><?php echo SEARCH_FOR_MSG;?> </small>
     </span>
  	 <span class="near">
	 <input name="sn" id="sn" type="text" class="s" PLACEHOLDER="<?php echo NEAR_TEXT;?>" value="<?php echo @$sn; ?>" /> 
	 <input name="as" id="as" type="hidden" class="s" PLACEHOLDER="<?php echo NEAR_TEXT;?>" value="1" /> 
      <small class="text"><?php echo SEARCH_NEAR_MSG;?></small>
     </span>
    <input type="image" class="search_btn" src="<?php echo get_bloginfo('template_url'); ?>/images/search_icon.png" alt="Submit button" onclick="set_srch();" />
  </form>
</div>
<script type="text/javascript">
function set_srch()
{
	if(document.getElementById('sr').value=='<?php echo get_option('ptthemes_search_name'); ?>')
	{
		document.getElementById('sr').value = ' ';	
	}
	if(document.getElementById('sn').value=='<?php echo NEAR_TEXT; ?>')
	{
		document.getElementById('sn').value = '';	
	}
}
</script>