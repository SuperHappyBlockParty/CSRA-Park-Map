<?php
global $wpdb;

global $price_db_table_name;
$catinfo = $catinfo = get_terms(CUSTOM_CATEGORY_TYPE2,array('hide_empty'=>0,'parent'=>0));
global $cat_array,$category_renew;

if(@$_REQUEST['backandedit'] != ''){
	$place_cat_arr = $cat_array;
}else if(@$_REQUEST['renew'] != ''){
	$place_cat_arr = $category_renew;

}else {
for($i=0; $i < count($cat_array); $i++){
	$place_cat_arr[] = $cat_array[$i]->term_taxonomy_id;
}
}
$total_cp_price = 0;
$total_price_sql = $wpdb->get_results("select * from $wpdb->terms c,$wpdb->term_taxonomy tt  where tt.term_id=c.term_id and tt.taxonomy='".CUSTOM_CATEGORY_TYPE2."' and c.name != 'Uncategorized' and c.name != 'Blog' order by c.name");
foreach($total_price_sql as $objtotal_price_sql){
	$total_cp_price += $objtotal_price_sql->term_price;
}
if($catinfo) {
	$cat_display=get_option('ptthemes_category_dislay');
	if($cat_display==''){$cat_display='checkbox';}
	$counter = 0;
	if($cat_display == 'select'){?>
	<div class="form_cat" >
    <select name="category" id="category_<?php echo $counter;?>" class="textfield" onChange='document.forms["categoryform"].submit(this.value);' style="margin-left:&minus;" >
	<option value="0"><?php _e('Select category','templatic'); ?></option>

	<?php } else if($cat_display=='checkbox'){ ?>
		<div class="form_cat" ><label><input type="checkbox" name="selectall" onclick="displaychk(); allevent_packages('<?php echo $total_cp_price;?>');" id="selectall" /><?php echo SELECT_ALL;?></label></div>
	<?php }
	foreach($catinfo as $catinfo_obj)
	{
		$counter++;
		$termid = $catinfo_obj->term_id;
		$term_tax_id = $catinfo_obj->term_id;
		$name = $catinfo_obj->name;
		if($cat_display=='checkbox'){
		$catprice = $catinfo_obj->term_price;

		$cp = @$catprice->term_price; 

		?>

		 <div class="form_cat" ><label><input type="checkbox" name="category[]" id="category_<?php echo $counter; ?>" value="<?php if($cp != ""){ echo $termid.",".$catprice->term_price; }else{ echo $termid.",".'0'; }?>" class="checkbox" <?php if(isset($place_cat_arr) && in_array($termid,$place_cat_arr)){echo 'checked="checked"'; }?>  onclick="event_packages('<?php echo $catinfo_obj->term_id; ?>',this.form,'<?php echo $cp; ?>')"/>&nbsp;<?php if($cp > 0){ echo $name."<span style='color:#990000;'> (".display_amount_with_currency($cp).")</span> "; }else{ echo $name; } ?></label></div>
		
		<?php
		 $child = get_term_children( $term_tax_id ,CUSTOM_CATEGORY_TYPE2);
		 $args = array(
				'type'                     => 'place,event',
				'child_of'                 => $term_tax_id,
				'hide_empty'               => 0,
				'taxonomy'                 => CUSTOM_CATEGORY_TYPE2
				);
		 $categories = get_categories( $args );
		 
		 foreach($categories as $child_of)
		 { 
			$child_of = $child_of->term_id; 
			$p = 0;
			$term = get_term_by( 'id', $child_of, CUSTOM_CATEGORY_TYPE2);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$name = $term->name;
			$cp = $term->term_price; 
			if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p++;
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			$p = $p*15;
			
		 ?>
			<div class="form_cat" style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="category_<?php echo $counter; ?>" value="<?php if($cp != ""){ echo $termid.",".$catprice->term_price; }else{ echo $termid.",".'0'; }?>" class="checkbox" <?php if(isset($place_cat_arr) && in_array($termid,$place_cat_arr)){echo 'checked="checked"'; }?>  onclick="event_packages('<?php echo $catprice->term_id; ?>',this.form,'<?php echo $catprice->term_price; ?>')"/>&nbsp;<?php if($cp > 0){ echo $name."<span style='color:#990000;'> (".display_amount_with_currency($cp).")</span>"; }else{ echo $name; } ?></label></div>
		<?php }
		}elseif($cat_display=='radio')
		{
		?>
        <div class="form_cat" ><label class="r_lbl"><input type="radio" name="category[]" id="category_<?php echo $counter;?>" value="<?php echo $termid; ?>" class="checkbox" <?php if(isset($place_cat_arr) && in_array($termid,$place_cat_arr)){echo 'checked="checked"'; }?> />&nbsp;<?php echo $name; ?></label></div>
		<?php
		}elseif($cat_display=='select')
		{ 
		$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catinfo_obj->term_id."' and t.term_id = tt.term_id");
		$cp = $catinfo_obj->term_price;; 
			if((isset($_REQUEST['category']) && $_REQUEST['category'] != '') || (isset($_SESSION['event_info']['category']) && $_SESSION['event_info']['category'] != '') || (isset($_REQUEST['renew']) && $_REQUEST['renew']!= '') ) { 
				if($_REQUEST['category'] !=""){
				$cat_term = explode(',',$_REQUEST['category']); 
				}elseif($_REQUEST['renew']!=''){
				$cat_term = $category_renew; 
				}else{
				$cat_term = explode(',',$_SESSION['event_info']['category']);
				}
				if(is_array($cat_term)){ $cat_term = $cat_term[0]; }else{ $cat_term =$cat_term; }
				if($cat_term == $termid){ ?>
					<option <?php if($cat_term == $termid){echo 'selected=selected'; }?> value="<?php if($cp != "" && $cp != "0"){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $name."(".display_amount_with_currency($cp).") "; }else{ echo $name; } ?></option>
				<?php } else { ?>
					<option <?php if(isset($_SESSION['event_info']['category']) && $_SESSION['event_info']['category'] == $termid){echo 'selected="selected"'; }?> value="<?php if($cp != ""){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $name." (".display_amount_with_currency($cp).")"; }else{ echo $name; } ?></option>
					<?php
				 $child = get_term_children( $term_tax_id ,CUSTOM_CATEGORY_TYPE2);
				  $args = array(
				'type'                     => 'place,event',
				'child_of'                 => $term_tax_id,
				'hide_empty'               => 0,
				'taxonomy'                 => CUSTOM_CATEGORY_TYPE2
				);
				 $categories = get_categories( $args );
				 
				 foreach($categories as $child_of)
				 { 
					$child_of = $child_of->term_id; 
					$p = "";
					$term = get_term_by( 'id', $child_of, CUSTOM_CATEGORY_TYPE2);
					$termid = $term->term_taxonomy_id;
					$term_tax_id = $term->term_id;
					$name = $term->name;
					$cp = $term->term_price; 
					if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p .= " - ";
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			//$p = $p*15;
		
		 ?>
					<option <?php  if($cat_term == $termid){ echo 'selected="selected"'; } ?> value="<?php if($cp != ""){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $p.$name."(".display_amount_with_currency($cp).")"; }else{ echo $p.$name; } ?></option>
				<?php }
			 }
				?>
				
			<?php } else if($_REQUEST['pid'] != ''){ ?>
				<option <?php  if($cat_array[0]->term_taxonomy_id == $termid){ echo 'selected="selected"'; } ?> value="<?php if($cp != ""){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $name."(".display_amount_with_currency($cp).")"; }else{ echo $name; } ?></option>
				<?php
				 $child = get_term_children( $term_tax_id ,CUSTOM_CATEGORY_TYPE2);
				 $args = array(
				'type'                     => 'place,event',
				'child_of'                 => $term_tax_id,
				'hide_empty'               => 0,
				'taxonomy'                 => CUSTOM_CATEGORY_TYPE2
				);
				 $categories = get_categories( $args );
				 
				 foreach($categories as $child_of)
				 { 
					$child_of = $child_of->term_id;
					$p = "";
					$term = get_term_by( 'id', $child_of, CUSTOM_CATEGORY_TYPE2);
					$termid = $term->term_taxonomy_id;
					$term_tax_id = $term->term_id;
					$name = $term->name;
					$cp = $term->term_price; 
					if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p .= " - ";
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			//$p = $p*15;

		 ?>
					<option <?php  if($cat_term == $termid){ echo 'selected="selected"'; } ?> value="<?php if($cp != "" && $cp != "0"){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $p.$name."(".display_amount_with_currency($cp).")"; }else{ echo $p.$name; } ?></option>
				<?php }
		 } else {
         
		$currency = fetch_currency(get_option('currency_symbol'),'currency_symbol');
		$position = fetch_currency(get_option('currency_symbol'),'symbol_position');
		$amount =0;
		if($position == '1'){
		$amt_display = $currency.$amount;
		} else if($position == '2'){
		$amt_display = $currency.' '.$amount;
		} else if($position == '3'){
		$amt_display = $amount.$currency;
		} else {
		$amt_display = $amount.' '.$currency;
		}
      ?>   
				<option  value="<?php if($cp != ""){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp != "" && $cp != "0"){ echo $name."(".display_amount_with_currency($cp).")"; }else{ echo $name; } ?></option>
				<?php
				 $child = get_term_children( $term_tax_id ,CUSTOM_CATEGORY_TYPE2);
			
				  $args = array(
				'type'                     => 'place,event',
				'child_of'                 => $term_tax_id,
				'hide_empty'               => 0,
				'taxonomy'                 => CUSTOM_CATEGORY_TYPE2
				);
				 $categories = get_categories( $args );
				 
				 foreach($categories as $child_of)
				 { 
					$child_of = $child_of->term_id; 
					$p = "";
					$term = get_term_by( 'id', $child_of, CUSTOM_CATEGORY_TYPE2);
					$termid = $term->term_taxonomy_id;
					$term_tax_id = $term->term_id;
					$name = $term->name;
					$cp = $term->term_price; 
					if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p .= " - ";
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".CUSTOM_CATEGORY_TYPE2."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			//$p = $p*15;

		 ?><option <?php  if($cat_term[0]  == $termid){ echo 'selected="selected"'; } ?> value="<?php if($cp != ""){ echo $termid.",".$term_tax_id.",".$catprice->term_price; }else{ echo $termid.",".$term_tax_id.","."0"; }?>"><?php if($cp > 0){ echo $p.$name."(".display_amount_with_currency($cp).")"; }else{ echo $p.$name; } ?></option>
				<?php }
		}
		?>
        
       <?php
		}
	}
	if($cat_display=='select'){?>
	 </select></div>
	<?php }
}
?>
<script type="text/javascript">
function displaychk(){
	dml=document.forms['propertyform'];
	chk = dml.elements['category[]'];
	len = dml.elements['category[]'].length;
	if(document.propertyform.selectall.checked == true) {
		for (i = 0; i < len; i++)
		chk[i].checked = true ;
	} else {
		for (i = 0; i < len; i++)
		chk[i].checked = false ;
	}
}
</script>