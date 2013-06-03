<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");

$fname = get_option('post_type_export')."_report_".strtotime(date('Y-m-d')).".csv";
header('Content-Description: File Transfer');
header("Content-type: application/force-download; charset=ISO-8859-2;");

header('Content-Disposition: inline; filename="'.$fname.'"'); 
ob_start();
$f = fopen('php://output', 'w') or show_error("Can't open php://output");
$n = 0;
		function get_post_images($pid)
		{
			$image_array = array();
			$pmeta = get_post_meta($pid, 'key', $single = true);
			if($pmeta['productimage'])
			{
				$image_array[] = $pmeta['productimage'];
			}
			if($pmeta['productimage1'])
			{
				$image_array[] = $pmeta['productimage1'];
			}
			if($pmeta['productimage2'])
			{
				$image_array[] = $pmeta['productimage2'];
			}
			if($pmeta['productimage3'])
			{
				$image_array[] = $pmeta['productimage3'];
			}
			if($pmeta['productimage4'])
			{
				$image_array[] = $pmeta['productimage4'];
			}
			if($pmeta['productimage5'])
			{
				$image_array[] = $pmeta['productimage5'];
			}
			if($pmeta['productimage6'])
			{
				$image_array[] = $pmeta['productimage6'];
			}
			return $image_array;
		}
		
		function get_post_image($post,$img_size='thumb',$detail='',$numberofimgs=6)
		{
			$return_arr = array();
			if($post->ID)
			{
				$images = get_post_images($post->ID);
				if(is_array($images))
				{
					$return_arr = $images;
				}
			}
			$arrImages =&get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
			if($arrImages) 
			{
				$counter=0;
			   foreach($arrImages as $key=>$val)
			   {
					$counter++;
					$id = $val->ID;
					if($img_size == 'large')
					{						
						$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'medium')
					{
						$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'thumb')
					{
						$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}						
					}
					/* if($numberofimgs && $numberofimgs==$counter)
					{
						break;	
					} */
			   }
			  return $return_arr;
			}			
		}

global $wpdb,$current_user;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";
$my_post_type = get_option('post_type_export');
$authorsql_select = "select DISTINCT p.ID,p.*";
$authorsql_from= " from $post_table p,$post_meta_table pm";
if($_REQUEST['city_id'] != ""){
$authorsql_conditions= " where p.ID = pm.post_id and p.post_type = '".get_option('post_type_export')."' and p.post_status='publish' and pm.meta_key = 'post_city_id' and pm.meta_value Like '%".$_REQUEST['city_id']."%'";
}else{
$authorsql_conditions= " where p.post_type = '".$my_post_type."' and p.post_status='publish' and p.ID = pm.post_id";
}
		$authorinfo = $wpdb->get_results($authorsql_select.$authorsql_from.$authorsql_conditions);
if(get_option('post_type_export') == CUSTOM_POST_TYPE1)
{
	$post_cat_type = CUSTOM_CATEGORY_TYPE1;
	$post_tag_type = CUSTOM_TAG_TYPE1;
}else{
	$post_cat_type = CUSTOM_CATEGORY_TYPE2;
	$post_tag_type = CUSTOM_TAG_TYPE2;
}

$old_pattern = array("/[^a-zA-Z0-9-:;<>`'žàÐedŽ\/=.& ]/", "/_+/", "/_$/");
$new_pattern = array("_", "_", "");

$file_name = strtolower(preg_replace($old_pattern, $new_pattern , $text_title));

if($authorinfo)
{
$header_top =  "Post_author,post_date,post_date_gmt,post_title,category,IMAGE,tags,post_content,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,menu_order,post_type,post_mime_type,comment_count,geo_address,geo_latitude,geo_longitude,map_view,add_feature,timing,contact,email,twitter,facebook,proprty_feature,post_city_id,video,is_featured,paid_amount,alive_days,paymentmethod,remote_ip,ip_status,pkg_id,featured_type,total_amount,website";
if(strtolower(get_option('post_type_export')) == CUSTOM_POST_TYPE2)
{
	$header_top .= ",reg_desc,reg_fees,st_date,st_time,end_date,end_time"; 
}
$header_top .= ",comments_data,rating_data";
echo $header_top." \r\n";
	foreach($authorinfo as $postObj)
	{
	  global $post,$wpdb;
	  $product_image_arr = get_post_image($postObj,'large','',5);
	  $image = basename($product_image_arr[0]);
	  $imageArr = '';
	  //$image = basename($product_image_arr[0]);
	  if(count($product_image_arr)>1)
	   {
		 for($im=0;$im<=count($product_image_arr);$im++)
		 {
			$ext_arr = explode('.',$product_image_arr[$im]);
			$fileext = strtolower($ext_arr[count($ext_arr)-1]);
			if(in_array($fileext,array('jpg','jpeg','gif','png')))
			{
				//$product_image_arr[$im] .= $product_image_arr[$im];
				$imageArr .= basename($product_image_arr[$im]).";";
			}
		}
		$image = substr($imageArr,0,-1);
		//$product_image_arr = implode(";",$product_image_arr);
	}
	//$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
	$post_title =  iconv("UTF-8", "ISO-8859-1//IGNORE", $postObj->post_title); 
	$post_date =  $postObj->post_date;
	$post_date_gmt = $postObj->post_date_gmt;
	
	/*
	 *Remove The preg_replace funcion by dishant: date:2012-08-06
	 */
	//$post_content = preg_replace($old_pattern, $new_pattern , $postObj->post_content);
	$post_content = $postObj->post_content;
	
	//$post_excerpt =   preg_replace($old_pattern, $new_pattern , $postObj->post_excerpt);
	$post_excerpt =   $postObj->post_excerpt;
	//$is_featured =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'is_featured',true));
	$is_featured =  get_post_meta($postObj->ID,'is_featured',true);
	//$geo_address =    preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'geo_address',true));
	$geo_address =  get_post_meta($postObj->ID,'geo_address',true);
	$geo_latitude = get_post_meta($postObj->ID,'geo_latitude',true);
	$geo_longitude =   get_post_meta($postObj->ID,'geo_longitude',true);
	$map_view = get_post_meta($postObj->ID,'map_view',true);
	$add_feature = get_post_meta($postObj->ID,'add_feature',true);
	//$timing = preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'timing',true));
	$timing = get_post_meta($postObj->ID,'timing',true);
	$contact =  get_post_meta($postObj->ID,'contact',true);
	$email =  get_post_meta($postObj->ID,'email',true);
	$twitter =  get_post_meta($postObj->ID,'twitter',true);
	$facebook =  get_post_meta($postObj->ID,'facebook',true);
	//$proprty_feature =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'proprty_feature',true));
	$proprty_feature =  get_post_meta($postObj->ID,'proprty_feature',true);
	if(isset($_REQUEST['city_id']) || $_REQUEST['city_id'] !=""){
	$post_city_id = $_REQUEST['city_id'];
	}else{
	$post_city_id =  explode(',',get_post_meta($postObj->ID,'post_city_id',true));
	$post_city_id =  $post_city_id[0];
	}
	$video =  get_post_meta($postObj->ID,'video',true);
	//$is_featured =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'is_featured',true));
	$is_featured =  get_post_meta($postObj->ID,'is_featured',true);
	//$paid_amount =   preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paid_amount',true));
	$paid_amount =   get_post_meta($postObj->ID,'paid_amount',true);
	//$alive_days =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'alive_days',true));
	$alive_days =  get_post_meta($postObj->ID,'alive_days',true);
	//$paymentmethod =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paymentmethod',true));
	$paymentmethod = get_post_meta($postObj->ID,'paymentmethod',true);
	$remote_ip = get_post_meta($postObj->ID,'remote_ip',true);
	$ip_status =  get_post_meta($postObj->ID,'ip_status',true);
	$ip_status =  get_post_meta($postObj->ID,'ip_status',true);
	$pkg_id =  get_post_meta($postObj->ID,'pkg_id',true);
	$featured_type =  get_post_meta($postObj->ID,'featured_type',true);
	$total_amount = get_post_meta($postObj->ID,'total_amount',true);
	$website =  get_post_meta($postObj->ID,'website',true);
	//$reg_desc =   preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'reg_desc',true));
	$reg_desc =   get_post_meta($postObj->ID,'reg_desc',true);
	$reg_fees =  htmlspecialchars(stripslashes(get_post_meta($postObj->ID,'reg_fees',true)),ENT_QUOTES,'UTF-8',true);
	$st_date =  get_post_meta($postObj->ID,'st_date',true);
	$st_time =  get_post_meta($postObj->ID,'st_time',true);
	$end_date = get_post_meta($postObj->ID,'end_date',true);
	$end_time = get_post_meta($postObj->ID,'end_time',true);
	
	$udata = get_userdata($postObj->post_author);
	$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
	$category = '';
	if($category_array){
		$category =implode('&',$category_array);
	}
	$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
	$tags = '';
	if($tag_array){
		$tags =implode('&',$tag_array);
	}
	$args = array('post_id'=>$postObj->ID);
	$comments_data = get_comments( $args );
	//*--fetch comments ----*//;

	if($comments_data){
	foreach($comments_data as $comments_data_obj){
		foreach($comments_data_obj as $_comments_data_obj)
		  {
			if($_comments_data_obj ==""){
			$_comments_data_obj = "null";
			}
			 $newarray .= $_comments_data_obj."~";
		  }
		  $newarray .="##";
	}
	$newarray = str_replace(','," ",$newarray);
	}else{
	$newarray = "";
	}
	/*--fetch ratings----*/;
	$rating_table = $wpdb->prefix."ratings";
	$rating_data = $wpdb->get_results("select * from $rating_table where rating_postid ='".$postObj->ID."'");
	if($rating_data){
	foreach($rating_data as $rating_data_obj){
		foreach($rating_data_obj as $_rating_data_obj)
		  {
			if($_rating_data_obj ==""){
			$_rating_data_obj = "null";
			}
			 $rating .= $_rating_data_obj."~";
		  }
		  $rating .="##";
	}
	$rating = str_replace(','," ",$rating);
	}else{
	$rating = "";
	}


	
	
	 
	$csv_array=array("$postObj->post_author","$post_date","$post_date_gmt","$post_title","$category","$image","$tags","$post_content","$post_excerpt","$postObj->post_status","$postObj->comment_status","$postObj->ping_status","$postObj->post_password","$postObj->post_name","$postObj->to_ping","$postObj->pinged","$postObj->post_modified","$postObj->post_modified_gmt","$postObj->post_content_filtered","$postObj->post_parent","$postObj->menu_order","$postObj->post_type","$postObj->post_mime_type","$postObj->comment_count","$geo_address","$geo_latitude","$geo_longitude","$map_view","$add_feature","$timing","$contact","$email","$twitter","$facebook","$proprty_feature","$post_city_id","$video","$is_featured","$paid_amount","$alive_days","$paymentmethod","$remote_ip","$ip_status","$pkg_id","$featured_type","$total_amount","$website");
	if(strtolower(get_option('post_type_export')) == CUSTOM_POST_TYPE2)
		{			
			$content_1_array=array("$reg_desc","$reg_fees","$st_date","$st_time","$end_date","$end_time");
			$csv_array=array_merge($csv_array,$content_1_array);
		}	
	$content_1_array=array("$newarray","$rating");
	$new_csv_array=array_merge($csv_array,$content_1_array);
	if ( !fputcsv($f, $new_csv_array))
	{
		echo "Can't write line $n: $line";
	}

	
	//echo $content_1." \r\n";
	}	
	
	fclose($f) or show_error("Can't close php://output");
	$csvStr = ob_get_contents();
	ob_end_clean();

	echo $csvStr;		
}else
{
echo "No record available";

}?>  