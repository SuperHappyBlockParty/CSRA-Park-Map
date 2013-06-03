<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
//<![CDATA[
<?php
global $validation_info;
$js_code = '';
//$js_code .= '//global vars ';
$js_code .= 'var propertyform = jQuery("#propertyform"); 
'; //form Id
$jsfunction = array();
for($i=0;$i<count($validation_info);$i++) {
	$title = $validation_info[$i]['title'];
	$name = $validation_info[$i]['name'];
	$espan = $validation_info[$i]['espan'];
	$type = $validation_info[$i]['type'];
	$context = get_option('blogname');
	if(function_exists('icl_register_string')){	
		$text = $validation_info[$i]['text'];
		icl_register_string($context,'field_require_desc',$text);
		$text = $validation_info[$i]['text'];
	}else{
		$text = $validation_info[$i]['text'];
	}	
	$validation_type = $validation_info[$i]['validation_type'];
	
	
	$js_code .= '
	dml = document.forms[\'propertyform\'];
	var '.$name.' = jQuery("#'.$name.'"); ';
	$js_code .= '
	var '.$espan.' = jQuery("#'.$espan.'"); 
	';

	if($type=='selectbox' || $type=='checkbox')
	{
		$msg = sprintf($text);
	}else
	{
		$msg = sprintf($text);
	}
	
	if($type == 'multicheckbox' || $type=='checkbox' || $type=='radio'|| $type=='image_uploader')
	{
		$js_code .= '
		function validate_'.$name.'()
		{
			var chklength = jQuery("#'.$name.'").length;
			if("'.$type.'" =="multicheckbox")
			  {
			chklength = document.getElementsByName("'.$name.'[]").length;
			}
			if("'.$name.'" == "category"){
				chklength = document.getElementsByName("'.$name.'[]").length;
			}
			if("'.$type.'" =="radio")
			  {
				if (!jQuery("input:radio[name='.$name.']:checked").val()) {
					flag = 1;
				}
			  }
			  if("'.$type.'" == "image_uploader")
			  { 
				if (!jQuery("#imgarr").val()) { 
					flag = 1;
				}
			  }
			var temp	  = "";
			var i = 0;
			chk_'.$name.' = document.getElementsByName("'.$name.'[]");
			if("'.$name.'" == "category"){
				chk_'.$name.' = document.getElementsByName("'.$name.'[]");
			}
			if(chklength == 0){
			
				if ((chk_'.$name.'.checked == false)) {
					flag = 1;	
				} 
			} else {
				var flag      = 0;
			
				for(i=0;i<chklength;i++) {
					
					if ((chk_'.$name.'[i].checked == false)) { ';
						$js_code .= '
						flag = 1;
					} else {
						flag = 0;
						break;
					}
				}
				
			}
			if(flag == 1)
			{ 
				'.$espan.'.addClass("message_error2");
				'.$espan.'.text("'.$msg.'");
				if("'.$name.'" == "category")
				 {
					jQuery("#category_span").html("'.$msg.'");	 
				 }
				 if("'.$name.'" == "listing_image")
				 {
					jQuery("#listing_image_error").html("'.$msg.'");	 
				 }
				return false;
			}
			else{	
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
		}
	';
	}else {
		$js_code .= '
		function validate_'.$name.'()
		{
			if("'.$name.'" == "category"){
				chklength = jQuery("[name=category]").val();
				if(chklength == 0)
				 {
					jQuery("#category_span").html("Please select Category");
					return false;
				 }
			}
			';
			
			if($validation_type == 'email') {
				$js_code .= '
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = __("Please provide your email address","templatic");
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!emailReg.test(jQuery("#'.$name.'").val())) { ';
					$msg = __("Please provide valid email address","templatic");
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			} if($validation_type == 'phone'){
				$js_code .= '
				var phonereg = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = $text;
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!phonereg.test(jQuery("#'.$name.'").val())) { ';
					$msg = "Enter Valid Phone No.";
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			}if($validation_type == 'digit'){
				$js_code .= '
				var digitreg = /^[0-9.,]/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = $text;
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!digitreg.test(jQuery("#'.$name.'").val())) { ';
					$msg = "This field allow only digit.";
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			}
			$js_code .= 'if(jQuery("#'.$name.'").val() == "")';
			
		
			$js_code .= '
			{
				'.$name.'.addClass("error");
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else{
				'.$name.'.removeClass("error");
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
		}
		';
	}
	//$js_code .= '//On blur ';
	$js_code .= $name.'.blur(validate_'.$name.'); ';
	
	//$js_code .= '//On key press ';
	$js_code .= $name.'.keyup(validate_'.$name.'); ';
	
	$jsfunction[] = 'validate_'.$name.'()';

}

if($jsfunction)
{
	$jsfunction_str = implode(' & ', $jsfunction);	
}

//$js_code .= '//On Submitting ';
$js_code .= '	
propertyform.submit(function()
{ 
	if (document.getElementsByName("price_select").length >0){
		if (!jQuery("input:radio[name=price_select]:checked").val())
		 {
			jQuery("#price_package_error").html("Please Select Price Package");
			return false;
		 }
		else
		{
			jQuery("#price_package_error").html("");
		}
	} 
	
	if('.$jsfunction_str.')
	{
		jQuery("#common_error").html("");
		return true
	}
	else
	{
		jQuery("#common_error").html("Ooops, looks like you forgot to enter a value inside the field");
		return false;
	}

});
';

$js_code .= '
});';

echo $js_code;
?>
//]]>

</script>