<?php 
if(isset($_REQUEST['backandedit']))
{
}else
{
	
}
?>
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/library/js/jqueryupload/ajaxupload.3.5.js" ></script>
<script language="javascript" type="text/javascript">
var temp = 1;
var html_var = '<?php echo $val['htmlvar_name']; ?>';
//var $uc = jQuery.noConflict();
jQuery(function()
{
	var btnUpload=jQuery('#uploadimage');
	var status=jQuery('#status');
	new AjaxUpload(btnUpload, {
	name: 'uploadfile[]',
	action: '<?php echo get_bloginfo('template_url'); ?>/monetize/general/uploadfile.php',

	onSubmit: function(file, ext)
	{
	 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
     // extension is not allowed 
	status.text('<?php _e('Only JPG, PNG or GIF files are allowed','templatic'); ?>');
	return false;
	}status.text('<?php _e('Uploading...','templatic'); ?>');
	},
	
	onComplete: function(file, response)
	{
			/*Image size validation*/
		 if(response == 'LIMIT'){
			status.text('<?php _e('your image size must be less then','templatic'); ?>'+'<?php echo  get_option('ptthemes_max_image_size'); ?><?php _e('bytes','templatic'); ?>');
			return false;
		 }
		// Start Limit Code
		  if(response > 10 )
		  {
			status.text('<?php _e('you can upload maximum 10 images','templatic'); ?>');
			return false;
		  }
		
		 var counter = 0;
		 jQuery('#files .success').each(function(){
				counter = counter + 1;
		 });
		 limit = (response.split(",").length + counter) - 1;
		if(parseFloat(limit) > 10)
	   	  {
			status.text('<?php _e('You can upload maximum 10 images','templatic'); ?>');
			return false;
	   	  }

		// End Limit Code
		
		var spl = response.split(",");
		//On completion clear the status
		status.text('');
		//Add uploaded file to list

		var counter = 0;
		jQuery('#files .success').each(function(){
				counter = parseFloat(this.id) + 1;
		});
		for(var i =0;i<spl.length;i++)
		  {
			if((spl.length-1) == i)
			  {
			  }
			else
			  {
				  	
				var img_name = '<?php echo get_bloginfo('template_url')."/images/tmp/"; ?>'+spl[i]+"";

				jQuery('<span id='+(i+counter)+'></span>').appendTo('#files').html('<span id=temp'+(i+counter)+' class="temp"><img src="'+img_name+'" name="'+spl[i]+'" alt="" style="margin:5px;" height="120" width="120" /></span><br><span id="del'+(i+counter)+'" ><img align="right" class="redcross" alt="delete" src="<?php echo get_bloginfo('template_url'); ?>/images/cross.png" onClick="deleteFile(\''+spl[i]+'\','+(i+counter)+');" id="cross'+(i+counter)+'" /></span><img align="middle" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_left.gif" id="left'+(i+counter)+'" style="margin-left:10px;margin-right:10px;cursor:pointer;" onclick="moveleft('+(i+counter)+')" /><img align="middle" id="right'+(i+counter)+'" style="cursor:pointer;" onclick="moveright('+(i+counter)+')" src="<?php echo bloginfo('template_url'); ?>/images/upload_right.gif" />').addClass('success');
			  }
		  }
		
		var counter = 0;
		jQuery('#files .success').each(function(){
				counter = counter + 1;
			});
		var cnt = 0;
		jQuery('#files .success').each(function(){
			cnt = cnt + 1;
			if(this.id)
			 {
				if(cnt == 1)
				 {
					if(counter > 1)
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).show();
					  }
					else
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).hide();
					  }
				 }
				 
				 if(counter == cnt)
				   {
					   jQuery('#right'+this.id).hide();
				   }
				 else
				   {
					   jQuery('#right'+this.id).show();
				   }
			 }
		 });
		
		var imgArr = new Array();
		var i = 0;

		jQuery('#files .success span.temp img').each(function(){
			imgArr[i] = this.name;
			i++;
		});
		document.getElementById('imgarr').value = imgArr;


	
	}});
});
</script>

<script language="javascript" type="text/javascript">
function deleteFile(id,idb,pid)
{
	var imgArr = new Array();
	var i = 0;
	var aurl="<?php echo bloginfo('template_url'); ?>/monetize/general/delete-file.php?imagename="+id+"&pid="+pid;
	var result=jQuery.ajax({
		type:"GET",
		data:"stuff=1",
		url:aurl,
		async:false
	}).responseText;
	if(result!="")
	{
		var parSpan = jQuery("#cross"+idb).parent().attr('id');
		var parSpan1 = jQuery("#"+parSpan).parent().attr('id');
		jQuery("#"+parSpan1).remove();
	}
	
		
		
		var counter = 0;
		jQuery('#files .success').each(function(){
				counter = counter + 1;
			});
		var cnt = 0;
		jQuery('#files .success').each(function(){
			cnt = cnt + 1;
			if(this.id)
			 {
				if(cnt == 1)
				 {
					if(counter > 1)
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).show();
					  }
					else
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).hide();
					  }
				 }
				 
				 if(counter == cnt)
				   {
					   jQuery('#right'+this.id).hide();
				   }
				 else
				   {
					   jQuery('#right'+this.id).show();
				   }
			 }
		 });
	
	jQuery('#files .success span.temp img').each(function(){
		imgArr[i] = this.name;
		i++;
	});
	document.getElementById('imgarr').value = imgArr;

}

function moveright(idb)
{
	var imgArr = new Array();
	var nextid = jQuery('#'+idb).next('span').attr('id');
	var str = jQuery('#temp'+idb).html();
	var str1 = jQuery('#temp'+nextid).html();
	var i = 0;
	jQuery('#temp'+(idb)).html(str1);
	jQuery('#temp'+nextid).html(str);
	
	var delstr = jQuery('#del'+idb).html();
	var delstr1 = jQuery('#del'+nextid).html();
	jQuery('#del'+idb).html(delstr1);
	jQuery('#del'+nextid).html(delstr);

	
	jQuery('#files .success span.temp img').each(function(){
		imgArr[i] = this.name;
		i++;
	});
	document.getElementById('imgarr').value = imgArr;
}

function moveleft(idb)
{
	var imgArr = new Array();
	var previd = jQuery('#'+idb).prev('span').attr('id');
	var str = jQuery('#temp'+idb).html();
	var str1 = jQuery('#temp'+previd).html();
	var i = 0;
	jQuery('#temp'+(idb)).html(str1);
	jQuery('#temp'+previd).html(str);
	
	
	var delstr = jQuery('#del'+idb).html();
	var delstr1 = jQuery('#del'+previd).html();
	jQuery('#del'+idb).html(delstr1);
	jQuery('#del'+previd).html(delstr);

	
	jQuery('#files .success span.temp img').each(function(){
		imgArr[i] = this.name;
		i++;
	});
	document.getElementById('imgarr').value = imgArr;

}

</script>
<div id="uploadimage" class="upload" ><span><?php _e("Upload Photo",'templatic'); ?></span></div><span id="status"></span>
<table width="100%" align="center" border="0">
<tr>
    <td>
       
        <input name="imgarr" id="imgarr" value="" type="hidden"/>
        <table><tr><td id="files">
        <?php
        $i = 0;
		if(isset($_SESSION["file_info"]) && $_SESSION["file_info"][0] != '' &&  $_SESSION["file_info"] != '' && $_REQUEST['backandedit'] && !$_REQUEST['pid'] )
        {
            foreach($_SESSION["file_info"] as $image_id=>$val)
            {
                $thumb_src = get_template_directory_uri().'/thumb.php?src='.get_template_directory_uri().'/images/tmp/'.$val;
           ?>
                <span id="<?php echo $i; ?>" class="success"><span class="temp" id="temp<?php echo $i; ?>"><img src="<?php echo $thumb_src; ?>" width="120" height="120" name="<?php echo $val; ?>" style="margin:5px;" alt="" /></span><br><span id="del<?php echo $i; ?>"><img align="right" id="cross<?php echo $i; ?>" onclick="deleteFile('<?php echo $val; ?>','<?php echo $i; ?>','');" src="<?php echo get_bloginfo('template_url'); ?>/images/cross.png" alt="delete" class="redcross" /></span><img align="middle" onclick="moveleft('<?php echo $i; ?>')" style="margin-left: 10px; margin-right: 10px; cursor: pointer;" id="left<?php echo $i; ?>" src="<?php echo bloginfo('template_url'); ?>/images/upload_left.gif"><img align="middle" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_right.gif" onclick="moveright('<?php echo $i; ?>')" style="cursor: pointer;" id="right<?php echo $i; ?>"></span>
           <?php
             $i++;
            }
        }
       ?>
       <?php
       if(isset($_REQUEST['pid']) && $_REQUEST['pid']!='' && !$_REQUEST['backandedit']) :
            global $thumb_img_arr;
            $i = 0;
            if($thumb_img_arr):
                foreach ($thumb_img_arr as $val) :
                $name = end(explode("/",$val['file']));
               //$thumb_src = get_template_directory_uri().'/thumb.php?src='.$val['file'];
           ?>
                    <span id="<?php echo $i; ?>" class="success"><span class="temp" id="temp<?php echo $i; ?>"><img src="<?php echo $val['file']; ?>" height = "120px" width = "120px" name="<?php echo $name; ?>" style="margin:5px;" alt="" /></span><br><span id="del<?php echo $i; ?>"><img align="right" id="cross<?php echo $i; ?>" onclick="deleteFile('<?php echo $name; ?>','<?php echo $i; ?>','<?php echo $val['id']; ?>');" src="<?php echo get_bloginfo('template_url'); ?>/images/cross.png" alt="delete" class="redcross" /></span><img align="middle" onclick="moveleft('<?php echo $i; ?>')" style="margin-left: 10px; margin-right: 10px; cursor: pointer;" id="left<?php echo $i; ?>" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_left.gif"><img align="middle" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_right.gif" onclick="moveright('<?php echo $i; ?>')" style="cursor: pointer;" id="right<?php echo $i; ?>"></span>
            <?php
                 $i++;
                 endforeach;
            endif;
        endif;
       ?>
        <?php 
            if(isset($_SESSION["file_info"]) && $_REQUEST['backandedit'] && $_REQUEST['pid'] ):
                global $upload_folder_path;
                $i = 0;
                foreach($_SESSION["file_info"] as $image_id=>$val):
                    $src = get_template_directory().'/images/tmp/'.$val;
                    //$thumb_src = get_template_directory_uri().'/thumb.php?src='.get_template_directory_uri().'/images/tmp/'.$val;
                    if($val):
                    if(file_exists($src)):
        ?>
                       <span id="<?php echo $i; ?>" class="success"><span class="temp" id="temp<?php echo $i; ?>"><img src="<?php echo get_template_directory_uri().'/images/tmp/'.$val; ?>" name="<?php echo $val; ?>" style="margin:5px;" height = "120px" width = "120px" alt="" /></span><br><span id="del<?php echo $i; ?>"><img align="right" id="cross<?php echo $i; ?>" onclick="deleteFile('<?php echo $val; ?>','<?php echo $i; ?>','');" src="<?php echo bloginfo('template_url'); ?>/images/cross.png" alt="delete" class="redcross" /></span><img align="middle" onclick="moveleft('<?php echo $i; ?>')" style="margin-left: 10px; margin-right: 10px; cursor: pointer;" id="left<?php echo $i; ?>" src="<?php echo bloginfo('template_url'); ?>/images/upload_left.gif"><img align="middle" src="<?php echo bloginfo('template_url'); ?>/images/upload_right.gif" onclick="moveright('<?php echo $i; ?>')" style="cursor: pointer;" id="right<?php echo $i; ?>"></span>
                   <?php else: ?>
                   <?php
                   global $thumb_img_arr;
                        foreach($thumb_img_arr as $value):
                            $name = end(explode("/",$value['file']));
                            if($name == $val):
                   ?>
                        <span id="<?php echo $i; ?>" class="success"><span class="temp" id="temp<?php echo $i; ?>"><img src="<?php echo $value['file']; ?>" height = "120px" width = "120px" name="<?php echo $val; ?>" style="margin:5px;" alt="" /></span><br><span id="del<?php echo $i; ?>"><img align="right" id="cross<?php echo $i; ?>" onclick="deleteFile('<?php echo $val; ?>','<?php echo $i; ?>','<?php echo $value['id']; ?>');" src="<?php echo bloginfo('template_url'); ?>/images/cross.png" alt="delete" class="redcross" /></span><img align="middle" onclick="moveleft('<?php echo $i; ?>')" style="margin-left: 10px; margin-right: 10px; cursor: pointer;" id="left<?php echo $i; ?>" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_left.gif"><img align="middle" src="<?php echo get_bloginfo('template_url'); ?>/images/upload_right.gif" onclick="moveright('<?php echo $i; ?>')" style="cursor: pointer;" id="right<?php echo $i; ?>"></span>
                    <?php
                            endif;
                       endforeach;
                    ?>
             
             <?php 
                    endif;
                    endif;
                    $i++;
                endforeach; 
            endif;
             ?>
	</td>
   </tr>
  </table>
</td>
</tr>
</table>
<?php if(isset($_SESSION["file_info"]) && $_REQUEST['backandedit'] || isset($_REQUEST['pid'])) : ?>
<script type="text/javascript">
		var counter = 0;
		jQuery('#files .success').each(function(){
				counter = counter + 1;
			});
		var cnt = 0;
		jQuery('#files .success').each(function(){
			cnt = cnt + 1;
			if(this.id)
			 {
				if(cnt == 1)
				 {
					if(counter > 1)
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).show();
					  }
					else
					  {
						jQuery('#left'+this.id).hide();
						jQuery('#right'+this.id).hide();
					  }
				 }
				 
				 if(counter == cnt)
				   {
					   jQuery('#right'+this.id).hide();
				   }
				 else
				   {
					   jQuery('#right'+this.id).show();
				   }
			 }
		 });
		
		var imgArr = new Array();
		var i = 0;

		jQuery('#files .success span.temp img').each(function(){
			imgArr[i] = this.name;
			i++;
		});
		document.getElementById('imgarr').value = imgArr;
</script>
<?php endif; ?>