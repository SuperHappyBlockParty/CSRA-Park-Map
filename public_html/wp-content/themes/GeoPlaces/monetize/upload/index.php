<?php
$action = $_GET['img']; 
?><head>
   
<script language="javascript" type="text/javascript">
<!--
function toggle(o){
var e = document.getElementById(o);
e.style.display = (e.style.display == 'none') ? 'block' : 'none';
}

function goform()
{  
	  if(document.forms.ajaxupload.myfile.value==""){
	  alert('Please choose an image');
	  return;
	  }else{

		  document.ajaxupload.submit();
		  }
}
function goUpload(){
 
	  if(document.forms.ajaxupload.myfile.value==""){
	  return;
	  }else{
	
	  	
      document.getElementById('f1_upload_process').style.visibility = 'visible';
	  document.getElementById('f1_upload_process').style.display = '';
	  document.getElementById('f1_upload_success').style.display = 'none';
      return true; }
}

function noUpload(success, path, imgNumb, imgsize1){
      var result = '';
      if (success == 1){ 
	 
         document.getElementById('f1_upload_process').style.display = 'none';
		 // parent.document.getElementById(imgNumb+'_delete').style.display = '';
		  var theImage = parent.document.getElementById(imgNumb);
		   var theImagepath = parent.document.getElementById(imgNumb+'_text');
		   var theImage = parent.document.getElementById(imgNumb+'_img');
		    theImagepath.value = path;
			theImage.style.display = '';
			theImage.src = path;
			
		   document.getElementById('myfile').value = '';
		   document.getElementById('f1_upload_success').style.display = '';
          }
      else {  
          document.getElementById('f1_upload_process').style.display = 'none';
		  document.getElementById('f1_upload_form').style.display = 'none'; 
          document.getElementById('no_upload_form').style.display = '';
      }
      return true;     
}
//-->
</script>   
</head>

<?php 
if(isset($_REQUEST['caticon']) &&  $_REQUEST['caticon']!=""){ ?>
<style>

#upload_target
{
	 width:				100%;
	 height:			80px;
	 text-align: 		center;
	 border:			none;
	 background-color: 	#642864;	
	 margin:			0px auto;
}

/* <![CDATA[ */

.SI-FILES-STYLIZED label.cabinet
{
	width: 63px;
	height: 27px;
	background: url(btn-choose.png) no-repeat top left;
	display: block;
	overflow: hidden;
	cursor: pointer !important;
}
.SI-FILES-STYLIZED label.cabinet:hover { background:url(btn-choose.png) no-repeat bottom left;  }


.SI-FILES-STYLIZED label.cabinet input.file
{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	top:0;
	-moz-opacity: 0;
	cursor:pointer;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}


@media screen and (-webkit-min-device-pixel-ratio:0) {
.SI-FILES-STYLIZED label.cabinet { margin-top:5px; }
}

/* ]]> */

</style>


<?php }else { ?>
<style>

#upload_target
{
	 width:				100%;
	 height:			80px;
	 text-align: 		center;
	 border:			none;
	 background-color: 	#642864;	
	 margin:			0px auto;
}

/* <![CDATA[ */

.SI-FILES-STYLIZED label.cabinet
{
	width: 63px;
	height: 27px;
	background: url(btn-choose-file.png) no-repeat top left;
	display: block;
	overflow: hidden;
	cursor: pointer !important;
}
.SI-FILES-STYLIZED label.cabinet:hover { background:url(btn-choose-file.png) no-repeat bottom left;  }


.SI-FILES-STYLIZED label.cabinet input.file
{
	position: relative;
	width: auto;
	opacity: 0;
	top:0;
	-moz-opacity: 0;
	cursor:pointer;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}
@media screen and (-webkit-min-device-pixel-ratio:0) {
.SI-FILES-STYLIZED label.cabinet { margin-top:5px; }
}

/* ]]> */

</style>
<?php } ?>

<body>


	<script type="text/javascript" src="si.files.js"></script>
	
                <form name="ajaxupload" action="<?php echo "upload.php?img=".$action."&nonce=".$_GET['nonce']; ?>" method="post" enctype="multipart/form-data" target="upload_target" onSubmit="" >
                     
                      <div id="f1_upload_form" align="left"><!--Select Image You want to upload:-->
                         <table border="0" cellpadding="0" cellspacing="0"><tr><td>
                         <label class="cabinet">
						  <input name="myfile" size="35" id="myfile"  class="file" value = ""  type="file"  onChange="goform();goUpload();" tabindex="2" /></label>
						  <input type="hidden" name="my_file_" value="1"/>
                         <p id="f1_upload_success" style="display:none; font-weight:bold;"></p>
                         </td><td><div id="f1_upload_process" style=" display:none;"><img src="loader.gif" /></div></td></tr></table>
                     </div>
                     
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0; border:0; background:#fff;" ></iframe>
                 </form>
               
                 
                 <script type="text/javascript" language="javascript">
// <![CDATA[

SI.Files.stylizeAll();

/*
--------------------------------
Known to work in:
--------------------------------
- IE 5.5+
- Firefox 1.5+
- Safari 2+
                          
--------------------------------
Known to degrade gracefully in:
--------------------------------
- Opera
- IE 5.01

--------------------------------
Optional configuration:

Change before making method calls.
--------------------------------
SI.Files.htmlClass = 'SI-FILES-STYLIZED';
SI.Files.fileClass = 'file';
SI.Files.wrapClass = 'cabinet';

--------------------------------
Alternate methods:
--------------------------------
SI.Files.stylizeById('input-id');
SI.Files.stylize(HTMLInputNode);

--------------------------------
*/

// ]]>
</script>
             
</body>   