<?php
	if(isset($_GET['img']) && $_GET['img'] !='' && $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['my_file_'])){
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
				
				$dirinfo = wp_upload_dir();
				$path = $dirinfo['path'];
				$url = $dirinfo['url'];
				$destination_path = $path."/";
				$destination_url = $url."/";
   
   $name = $_FILES['myfile']['name'];
   $name = strtolower($name);
   
   $filename = $_FILES["myfile"]["name"];
   $filesize = ($_FILES["myfile"]["size"] / 1048576);
	$exts = ''; 
	function findexts1 ($filename) 
	{ 
			return substr(strrchr($filename,'.'),1);
	}
  
	$exts = findexts1($filename);
	$iname = time().rand().".".$exts;
	$target_file = $destination_path.$iname;
	
			 
   if(isset($_GET['img'])) // digital products
   {
   		$target_path = $destination_path. $iname;
		$user_path = $destination_url.$iname;
   }else
   {
   		$target_path = $destination_path. $iname;
		$user_path = $destination_url.$iname;
   }
	global $extension_file;
	$file_ext= substr($target_path, -4, 4);
	if(in_array($file_ext,$extension_file))
	{
		if(@move_uploaded_file($_FILES["myfile"]["tmp_name"],$target_path)) {
			$result = 1;
		}else{	
			$result = 0;
		}
	}else{
		$result = 0;
	}
   $imgNumb = "image".$_GET['img'];
   }
?>
<script language="javascript" type="text/javascript">window.parent.window.noUpload(<?php echo $result.", '". $user_path."', '".$_GET['img']."', '".$filesize."'"; ?>);</script>