<?php
set_time_limit(0);
global $wpdb,$one_time_insert;

$dummy_image_path = get_template_directory_uri().'/images/dummy/';


//====================================================================================//
/////////////// TERMS START ///////////////
//=============================CUSTOM TAXONOMY=======================================================//

$category_array = array('Blog');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array)
{
	global $wpdb;
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
					$last_catid = wp_insert_term( $catname, 'category' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'category');
					}
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'category');
			}
		}
	}
	
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'category', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

/////////////// TERMS END ///////////////
$post_info = array();
//////////// Blog /////////////

////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img1.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'Cleopatra: The Search for the Last Queen of Egypt',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Cleopatra: The Search for the Last Queen of Egypt',
					"post_content" 		 =>	'<h3>  The Experience </h3>

The world of Cleopatra, which has been lost to the sea and sand for nearly 2,000 years, will surface in a new exhibition, Cleopatra: The Search for the Last Queen of Egypt, making its world premiere in June 2010 at The Franklin Institute in Philadelphia, from June 5, 2010 – January 2, 2011. The exhibition will feature roughly 140 artifacts while taking visitors inside the present-day search for Cleopatra, which extends from the sands of Egypt to the depths of the Bay of Aboukir near Alexandria.
Cleopatra VIP Hotel Package

Cleopatra visitors looking to make it an overnight stay can book the Cleopatra VIP Hotel Package. Available at 11 hotels, the package includes overnight accommodations for two and two VIP (untimed, bypass-the-line) tickets to the exhibition. (VIP tickets are available only by purchasing a hotel package and are valued at up to $59.)

Click here to check rates and book the package.
<h3>The Search For Cleopatra </h3>

Cleopatra, the last great pharaoh of Egypt before it succumbed to Roman opposition, lived from 69 – 30 B.C., and her rule was marked with political intrigue and challenges to her throne. She captivated two of the most powerful men of her day, Julius Caesar and Mark Antony, as she attempted to restore Egypt to its former superpower status. Later, her Roman conquerors tried to rewrite her history and destroy all traces of her existence. Although her body has never been found, her story survives.

Visitors to the exhibition will be treated to an inside view of the search for Cleopatra through two ongoing expeditions by modern explorers Dr. Zahi Hawass, Egypt&acute;s pre-eminent archaeologist and Secretary General of the Supreme Council of Antiquities, and Franck Goddio, French underwater archaeologist and director of IEASM. Goddio&acute;s search has resulted in one of the most ambitious underwater expeditions ever undertaken, which has uncovered Cleopatra&acute;s royal palace and two ancient cities that had been lost beneath the sea for centuries after a series of earthquakes and tidal waves.

The artifacts in the exhibition — from the smallest gold pieces and coins to colossal statues more than 15-feet tall — provide a window into Cleopatra&acute;s story as well as the daily lives of her contemporaries, both powerful and humble. Artifacts on display will include magnificent black granite statues of a queen of Egypt dating from the Ptolemaic era in which Cleopatra ruled, which Goddio&acute;s team pulled from the sea.

',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img2.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'First Friday',
					"post_content" 		 =>	'<h3>When </h3>

The First Friday evening of each month, rain or shine, year-round. Hours: 5 to 9 p.m.
<h3>Where </h3>

Most galleries can be found between Front and Third, and Market and Vine Streets.
<h3>The Experience </h3>

Want proof of Philadelphia&acute;s happening art scene? Come down to Old City for First Fridays. On the first Friday evening of every month the streets fill with art lovers of all kinds who wander among the neighborhood&acute;s 40-plus galleries, most of them open from 5 until 9 p.m.

A casual atmosphere encourages art and people watching, eating at Old City&acute;s many restaurants and just plain mingling. There&acute;s diversity both in the crowd and among the galleries, adding flavor to the experience. Most galleries can be found between Front and Third, and Market and Vine Streets.
<h3>History </h3>

Started in 1991 by a group of galleries as a collaborative open house evening, First Fridays grew quickly into one of Philly&acute;s most vital, signature cultural events. Old City&acute;s historic commercial buildings have fostered a SoHo-like cultural ambience with the densest network of galleries in the city.

Some of the arts organizations you can visit on First Fridays include the Clay Studio; the Temple Gallery; the cooperative galleries Nexus, Highwire, Muse and Third Street Gallery; and collaborative Space 1026.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Philadelphia International Festival of the Arts',
					"post_content" 		 =>	'<h3>The Experience </h3>

April 7 through May 1, 2011, the Philadelphia International Festival of the Arts (PIFA) will shine a spotlight on the city&acute;s arts and cultural scene. For three weeks, audiences will revel in an array of one-time, only-in-Philadelphia productions by some of the region&acute;s top talents—many of whom will partner with or present international performers. PIFA will feature music, dance, fashion, fine arts, poetry, cuisine and more—all infused with the essence of Paris, circa 1910-1920.

Inspired by the Kimmel Center, PIFA promises to be an out-of-the-box arts festival that honors the vision of longtime Philadelphia resident and philanthropist Leonore Annenberg. Before she passed away in 2009, Mrs. Annenberg provided a generous grant through the Annenberg Foundation to ensure that her lifelong dream for a citywide arts celebration would be fulfilled.

As PIFA transforms the entire city into a giant stage, loyal fans and newcomers to the arts will have the opportunity to choose from among dozens of ticketed and free activities each day. Performances and exhibits will be held throughout Center City and beyond, many in Kimmel Center venues, as well as in theaters, performance halls and other venues, both large and small.

With more than 100 performances planned, three events serve as examples of the serendipitous moments and surprising performances audiences can look forward to. For the first time ever, the Philadelphia Orchestra and the Pennsylvania Ballet will perform together, collaborating on what promises to be an unforgettable presentation of the classic French ballet Pulcinella. In an innovative pairing, Philly&acute;s signature hip-hop band The Roots will play in an anything-can-happen concert with a French chanteuse. What&acute;s more, daring aerialists will swing from the rafters of the Kimmel Center and teach anybody who has ever wanted to join the circus how to fly the trapeze on the Avenue of the Arts.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Tags','Sample Tags')
					);
////post end///
////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Art of the American Soldier',
					"post_content" 		 =>	'<h3>The Experience </h3>

More than 15,000 paintings and sketches created by over 1,300 American soldiers in the line of duty have been in curatorial storage in Washington, D.C. for decades. Seldom have them been made available for public viewing. Art of the American Soldier will bring these powerful works of art into the spotlight at the National Constitution Center from September 24, 2010 through January 10, 2011.

The exhibition, featuring a never-before-seen collection, was created by the NCC in partnership with the U.S. Army Center of Military History and the National Museum of the United States Army. Following its world debut at the Center, the exhibition will begin a national tour. Tickets to the exhibition are currently available for purchase.

<h3>The Trailer </h3>
 <object height="325" width="500" id="Object1" viewastext="" data="http://constitutioncenter.org/artOfTheAmericanSoldier/_flash/embed.swf" type="application/x-shockwave-flash"><param value="sameDomain" name="allowScriptAccess"><param value="http://constitutioncenter.org/artOfTheAmericanSoldier/_flash/embed.swf" name="movie"><param value="false" name="menu"><param value="best" name="quality"></object>

<h3>History </h3>

The U.S. Army&acute;s art program began during World War I, and continued through World War II, resulting in the creation of over 2,000 pieces of art. In 1945, the Army established its Historical Division, with responsibilities including the preservation of these works. The collection also includes artwork by artists who were sent to document the Vietnam War, as well as works from soldier-artists who are currently deployed in Iraq and Afghanistan. For a complete history of the Army&acute;s art program, click here.
Tickets

Admission to Art of the American Soldier is FREE with regular museum admission of $12 for adults, $11 for seniors ages 65 and over, and $8 for children ages 4-12. Veterans and military families will receive $2 off admission. Active military personnel, career military retirees, and children ages 3 and under are free. Group rates are also available. For ticket information, call 215.409.6700 or visit www.constitutioncenter.org.
Buy Tickets Online In Advance

You can buy admission tickets to the National Constitution Center online through our partners at the Independence Visitor Center. Just click the button below
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Art')
					);
////post end///
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Late Renoir Exhibition at the PMA',
					"post_content" 		 =>	'June 17 – September 6, 2010

The Philadelphia Museum of Art continues its recent trend of focusing in on a significant artist and showcasing the ways in which they influenced the art world for generations. Late Renoir is the first exhibition to survey the achievement of the great Impressionist painter Pierre-Auguste Renoir (1841-1919) during the last three decades before his death. The exhibition will include some 80 of the artist&acute;s paintings, sculpture, and drawings will be on view, along with a selection of works by Henri Matisse, Pablo Picasso, Pierre Bonnard, and others who were inspired by his work.

<h3>About the Exhibition </h3>

A landmark exhibition, Late Renoir examines new directions that the artist explored several decades after he and others such as Claude Monet and Camille Pissarro created the new style of painting known as Impressionism. This new and widely admired phase in Renoir&acute;s career propelled him into the modern age and, at the same time, enabled him to recapture a classical past with expressive brushwork and a palette of sensuous colors that were both lyrical and decorative.

Late Renoir includes major works on loan from public and private collections in Europe, the United States, and Japan. The exhibition is co-organized by the Reunion des Musées nationaux, the Musée d’Orsay, and the Los Angeles County Museum of Art, in collaboration with the Philadelphia Museum of Art. It drew some 420,000 visitors in Paris before traveling to the Los Angeles County Museum of Art. The Philadelphia Museum of Art will be the only East Coast venue.

<h3>Barnes/Renoir Hotel Package </h3>

For the first time, two prestigious arts organization in the Philadelphia region, the Philadelphia Museum of Art and the Barnes Foundation are creating a joint hotel package that will be available June 17th through August 2010.

The 181 Renoir paintings at the Barnes Foundation in addition to the works collected in the Late Renoir exhibition at the Philadelphia Museum of Art allows Philadelphia to boast the largest number of works by Renoir in any city in the world!

Three city hotels — the Four Seasons Hotel, Embassy Suites and Best Western Center City Hotel — are offering a one or two-night package that includes two untimed tickets to see the Late Renoir exhibition at the Philadelphia Museum of Art (June 17 – September 6, 2010), AND two untimed tickets to visit the Barnes Foundation as well as parking at the Barnes and 10% discount to the gift shop. 
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Art')
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Free Library Festival',
					"post_content" 		 =>	'April 17-18, 2010
<h3>The Experience </h3>

Now in its fourth year, the Free Library Festival is the Library&acute;s annual burst of ideas and inspiration.

Well on its way to becoming a Philadelphia tradition, the Festival weekend is packed with free programming for all ages, including talks by bestselling authors, poetry readings, musical performances, tours of the Library&acute;s special collections and programs and activities just for children. A fun, free way to spend the day, the Free Library Festival connects book lovers from throughout the mid-Atlantic region.

For a full schedule of performances, view the Festival Program.
<h3>Meet the Authors </h3>

The Free Library will host more than 50 authors on-stage at the 2010 Free Library Festival, including Tina Campbell of the urban gospel duo Mary Mary, talk show host Chelsea Handler, Sapphire — author of Push, basis for the award-winning film Precious, Man Booker Prize winner Yann Martel, Edgar Award-winning mystery author Harlan Coben, Oprah Winfrey biographer Kitty Kelley, pop singer/songwriter Tommy James, a reading and performance by Antonino D’Ambrosio about the making of Johnny Cash&acute;s Bitter Tears album, New York Times bestselling novelist Chang-rae Lee, the story of a road trip with the late David Foster Wallace by David Lipsky, and many, many more.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Festival')
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'A Weekend in Historic Philadelphia…on a Budget',
					"post_content" 		 =>	'So you&acute;re on vacation. Believe it or not, that doesn&acute;t mean you have to splurge!

In Historic Philadelphia, you&acute;ll find plenty of places where prices haven&acute;t changed much since our Founding Fathers were milling about town.

And we have put an entire weekend itinerary together for you, a step-by-step guide full of budget-conscious meals, fun stuff for the family and even a few cost-effective cocktails.

Welcome to Philadelphia, "America&acute;s best beer-drinking city." To start your vacation on the right foot — rather, the right barstool — head to The Khyber, a charmingly gritty bar in the middle of 2nd Street.

This is a great spot to get a casual burger and fries, knock back a few local microbrews and catch an up-and-coming live act. And for authentic Philadelphia attitude, you really can&acute;t do much better than The Khyber.

Just up the street is National Mechanics, a newer bar known for its gastropub-esque menu and quirky decor. Try a delicious salad or a gourmet burger — everything is tasty and light on your wallet.

From Old City, it&acute;s just a short, breezy walk down to Penn&acute;s Landing where, on Friday nights, you can catch free concerts all summer long. Ranging from gospel to jazz to R&B, the music is family-friendly and the scenery — the Delaware River to the east and the Philadelphia skyline to the west — is pretty much unbeatable.

Extra credit: If you visit Philadelphia for a mid-week stay, you can get cinematic on Thursday nights in the Summer with Penn&acute;s Landing&acute;s free Screenings Under the Stars.

And if you visit during the colder months, lace up and skate at the Blue Cross RiverRink. This ice rink comes equipped with a heated pavilion, snack bar and lessons for the whole family.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Budget')
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'The Cleopatra Girlfriends Weekend Itinerary',
					"post_content" 		 =>	'Strong, shrewd, beautiful and beguiling, Cleopatra, the last Pharaoh to rule Egypt before the completion of the Roman conquest, has been portrayed reverently by historians and Hollywood alike, making her an enduring icon and role model to women. As such, the world debut of Cleopatra: The Search for the Last Queen of Egypt at The Franklin Institute, which runs from June 5, 2010 through January 2, 2011, will likely resonate with thousands of women who admire the ancient queen. It&acute;s also an ideal opportunity to gather friends together for a girlfriends’ getaway in Philly.
					
					<h3>Check In </h3>

Pamper yourselves like the royalty that you are by checking into one of 11 hotels offering the Cleopatra VIP Hotel Package. The package includes overnight accommodations for two and two VIP (untimed, bypass-the-line) tickets to the exhibition. Before you leave, dress in comfortable shoes and clothes that transition well from day to evening, as your day takes you from sightseeing to a sultry night out.

<h3>Diamonds Are A Girl&acute;s Best Friend </h3>

Take a pleasant walk through Washington Square, one of William Penn&acute;s original parks, to adorn your body in true Cleopatra fashion by picking up some baubles on Jewelers Row, the nation&acute;s oldest diamond district and also one of its largest. 
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Girlfriends')
					);
////post end///
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img9.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'Celebrate the Harvest Season at the Peter Wentz Farmstead',
					"post_content" 		 =>	'Looking for some autumnal, harvest-y activities to do with friends or family over the next few weeks? Consider paying a visit to the Peter Wentz Farmstead in Worcester, PA. Each fall, they host a series of weekend festivals. First up is an event that&acute;s part of their Laerenswaert series, this Saturday, September 11th. A German phrase that means “worth learning,” they&acute;ll be focusing in on the Farmstead&acute;s Colonial gardens from 1-3 p.m.

On Saturday, September 25th, they&acute;ll be showcasing the Fall Harvest, 18th century-style. Demonstrations will include preserving fruits and vegetables, apple cider pressing and the breaking, scutching and combing of flax, to eventually being spun into linen thread. This event runs 10 a.m. to 3 p.m.

The Peter Wentz Farmstead was built in 1758 and served as George Washington&acute;s headquarters during his attempt to keep the British out of Philadelphia in the fall of 1777. Currently, it is run by Montgomery County as a fully restored historical site and admission is free. 
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Celebrate')
					);
////post end///
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg" ;
$post_meta = array(
				   "templ_seo_page_title" =>'',
				   "templ_seo_page_kw"	  => '',
					"tl_dummy_content"	  => '1',
				   "templ_seo_page_desc"  => '',
				);
$post_info[] = array(
					"post_title"		 =>	'A Weekend on the Parkway',
					"post_content" 		 =>	'The Benjamin Franklin Parkway, or simply "the Parkway," is in many ways the cultural heart of Philadelphia. Designed in 1917 to emulate the Champs-Elysées, the Parkway has been host to the nation&acute;s oldest Thanksgiving Parade, Live 8, a free Bruce Springsteen concert and Sunoco Welcome America!, Philadelphia&acute;s July 4th party.

Lined with flags from around the world, the Parkway begins at City Hall and ends dramatically at the Philadelphia Museum of Art. Between these two points, you&acute;ll discover 4,000-year-old books, 120 sculptures by Auguste Rodin, America&acute;s most historic prison and much, much more.

Since water is the theme, seafood is especially apt for ordering — we recommend the Mediterranean-influenced grilled octopus. Thirsty? You&acute;re at the right place. In addition to a generous wine list, the restaurant offers an international list of waters to try.

After dinner, step outside to enjoy the promenade along the river, the sculptural gardens and the illuminated Philadelphia skyline.  
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog'),
					"post_tags" =>	array('Celebrate')
					);
////post end///



insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//=============================CUSTOM TAXONOMY=======================================================//
$post_info = array();
insert_taxonomy_category($category_array);

////////////////////////  || NEWYORK CITY PLACES ||   ///////////////////////////////
//////////////////////// |||  NEWYORK CITY PLACES (01)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/imgl1.jpg" ;
$image_array[1] = "dummy/imgl.jpg" ;
$image_array[2] = "dummy/img2.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '56 Beaver Street, NYC 10004',
					"geo_latitude"	        => '40.7179463',
					"geo_longitude"	        => '-74.0071461',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '10:00 to 06:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Landmarc',
					"post_content"	    =>	'Marc Murphy, who blazed across the New York dining scene with his acclaimed interpretation of haute cuisine that was equal parts reverence and iconoclasm, teamed up with his wife, Pamela Schein Murphy, to open their first restaurant, Landmarc [Tribeca] in March 2004, which has since become a neighborhood favorite, serving contemporary bistro fare that blends French and Italian favorites in a decidedly cool space worthy of its cutting-edge Tribeca setting. In describing Landmarc  wine list, The New York Times  Eric Asimov wrote, "open the hard-bound binder of 22 laminated pages, and you might just slap yourself to see whether you  dreaming." Indeed, the restaurant  300-bottle wine list features hand-picked, famed and esoteric selections from around the world, with a minimum mark-up per bottle, reflecting Murphy  belief that a great dinner should be accompanied by an equally great bottle of wine. To further that philosophy for small parties and solo diners, Murphy offers a selection of over 50 half bottles. Classic dishes and amazing wine served in a cutting-edge space: Landmarc [Tribeca] is the bistro for destination diners and neighborhood regulars alike.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  NEWYORK CITY PLACES (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img4.jpg" ;
$image_array[1] = "dummy/img5.jpg" ;
$image_array[2] = "dummy/img6.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '377 Greenwich St, New York, NY 10013 ',
					"geo_latitude"	        => '42.9363802',
					"geo_longitude"	        => '-73.2360883',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '10:00 to 06:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Locanda Verde',
					"post_content"	    =>	'Locanda Verde is a casual, energetic, affordable neighborhood Italian taverna in TriBeCa serving celebrated chef Andrew Carmellini soul-satisfying riffs on Italian cooking. It airy, bustling, and easy-going: a comfortable, light-flooded place open from dawn to late night; the food and service are as casual, as easygoing and as well-conceived as the space.

Claim a spot in the cafe for a great cappuccino and one of pastry chef Karen DeMasco irresistible pastries, or order up a serious breakfast or brunch feast; relax over lunch at a sunny table by the window, or in our outdoor cafe seating; meet friends for a house cocktail or a specialty Italian beer and a snack or two at our generous, convivial bar; or settle into the banquets and kick back with a leisurely dinner, perhaps with a bottle of wine from our reasonably priced, wide-ranging Italian list.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  NEWYORK CITY PLACES (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img7.jpg";
$image_array[1] = "dummy/img8.jpg";
$image_array[2] = "dummy/img9.jpg";
$image_array[3] = "dummy/img10.jpg";
$image_array[4] = "dummy/img11.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '303 Madison Avenue, New York ',
					"geo_latitude"	        => '40.7523376',
					"geo_longitude"	        => '-73.9794756',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Pera',
					"post_content"	    =>	'Rated a Top 5 Newcomer by Zagat 2008, Pera Mediterranean Brasserie brings an authentic taste of eastern Mediterranean cuisine to Manhattan. Located at 303 Madison Avenue, Pera is the first venture from Burak Karacam of BK Restaurant Partners, LLC. Pera has enlisted Sezai Celikbas of internationally renowned Kosebasi restaurants in Turkey and Jason Avery, previously of the Regent Wall Street, as the restaurant’s co-executive chefs.

Pera derives its name from an elegant neighborhood in Istanbul that has served as the melting pot for many cultures and cuisines since the 17th century. The executive chefs lead a team of specialty cooks from Turkey and are collaboratively introducing lesser known mezes and meat preparations to a New York audience. Pera features numerous mezes, specially prepared and marinated cuts of grilled meats and seafood, traditional and modern Mediterranean side dishes and regional breads baked a la minute. ',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 3 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY PLACES (04)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg";
$image_array[1] = "dummy/img2.jpg";
$image_array[2] = "dummy/img3.jpg";
$image_array[2] = "dummy/img4.jpg";
$image_array[2] = "dummy/img5.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '230 Fifth Avenue, New York, NY 10001',
					"geo_latitude"	        => '40.7439779',
					"geo_longitude"	        => '-73.9878129',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'230-fifth',
					"post_content"	    =>	'230 Fifth is open to the public 365 days a year from 4:00PM to 4:00AM daily (closed only on certain days during December for Holiday Parties).

230 Fifth is different!

Created and controlled by the former owner of New York famous Roxy and Palladium nightclubs, 230 FIFTH opened on May 4, 2006 and in just one year of existence has received worldwide recognition as New York # 1 Rooftop Garden and Fully Enclosed Penthouse Lounge / Bar!

230 Fifth is New York largest (partially heated for winter) outdoor Rooftop Garden and fully enclosed Penthouse Lounge.

While open to the public seven days a week, 230 Fifth has hosted over 1,200 private receptions ranging in size from 20 up to 1,000 guests, including the following:

    - Goldman Sachs
    - The Devil Wears Prada Premier Party
    - Chanel Holiday Party
    - Opening Broadway Party for Kevin Spacey in "Moon For The Misbegotten"
    - Morgan Stanley Holiday Party
    - Google
    - Louis Vuitton Holiday Party
    - Microsoft
    - Sopranos Cast Holiday Party
    - IBM
    - Citigroup Holiday Party
    - Ford Modeling Agency Holiday Party
    - Bergdorf Goodman Holiday Party
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 4 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY PLACES (05)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img6.jpg";
$image_array[1] = "dummy/img7.jpg";
$image_array[2] = "dummy/img8.jpg";
$image_array[2] = "dummy/img4.jpg";
$image_array[2] = "dummy/img5.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '230 Fifth Avenue, New York, NY 10001',
					"geo_latitude"	        => '40.7439779',
					"geo_longitude"	        => '-73.9878129',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Great Jones',
					"post_content"	    =>	'The Great Jones Cafe opened in June of 1983 when Great Jones Street was such a desolate, forgotten block that writer Don DeLillo chose the street as a "hide-out" for the rock star main character of his book "Great Jones Street".  Back then, bar regulars could tumble out onto the quiet, empty block for impromptu games of whiffle ball. Cars were left unattended (and unticketed) for weeks on end.

28 years later, the Bowery is bustling. Our little cafe has seen a lot of change. People who met at the bar on their first date now come back to eat with their kids. Every night someone will come in who has not been by in years and someone else will come in for the first time.

Great Jones Cafe remains the same. Where once it was an outpost in a no man land, it is now one of the last down to earth neighborhood joints in the "new" Bowery. Drop in and wet your whistle!
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 5 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY PLACES (01 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img8.jpg";
$image_array[1] = "dummy/img9.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '150 West 17th Street, New York',
					"geo_latitude"	        => '40.7400185',
					"geo_longitude"	        => '-73.9977962',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Rubin Museum of Art',
					"post_content"	    =>	'The Rubin Museum of Art is a nonprofit cultural and educational institution dedicated to the art of the Himalayas. Its mission is to establish, present, preserve, and document a permanent collection that reflects the vitality, complexity, and historical significance of Himalayan art and to create exhibitions and programs designed to explore connections with other world cultures. The Rubin Museum is committed to addressing a diverse audience—from connoisseurs and scholars to the general public. Through its collection, exhibitions, and programs, the Rubin Museum is an international center for the preservation, study, and enjoyment of Himalayan art.
					
					The Rubin Museum of Art is home to a comprehensive collection of art from the Himalayas and surrounding regions. The artistic heritage of this vast and culturally varied area of the world remains relatively obscure. Through changing exhibitions and an array of engaging public programs, the museum offers opportunities to explore the artistic legacy of the Himalayan region and to appreciate its place in the context of world cultures.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY PLACES (02 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img10.jpg";
$image_array[1] = "dummy/img9.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '150 West 17th Street, New York',
					"geo_latitude"	        => '40.7400185',
					"geo_longitude"	        => '-73.9977962',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Rubin Museum of Art',
					"post_content"	    =>	'The Rubin Museum of Art is a nonprofit cultural and educational institution dedicated to the art of the Himalayas. Its mission is to establish, present, preserve, and document a permanent collection that reflects the vitality, complexity, and historical significance of Himalayan art and to create exhibitions and programs designed to explore connections with other world cultures. The Rubin Museum is committed to addressing a diverse audience—from connoisseurs and scholars to the general public. Through its collection, exhibitions, and programs, the Rubin Museum is an international center for the preservation, study, and enjoyment of Himalayan art.
					
					The Rubin Museum of Art is home to a comprehensive collection of art from the Himalayas and surrounding regions. The artistic heritage of this vast and culturally varied area of the world remains relatively obscure. Through changing exhibitions and an array of engaging public programs, the museum offers opportunities to explore the artistic legacy of the Himalayan region and to appreciate its place in the context of world cultures.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 


//////////////////////// |||  NEWYORK CITY PLACES (01 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img11.jpg";
$image_array[1] = "dummy/img12.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '280 Broadway, Manhattan, NY 10007, USA',
					"geo_latitude"	        => '40.714321',
					"geo_longitude"	        => '-74.00579',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Bryant Park',
					"post_content"	    =>	'Bryant Park Restoration Corporation (changed to Bryant Park Corporation (BPC) in 2006) was co-founded in 1980 by Dan Biederman and Andrew Heiskell, Chairman of Time Inc. and the New York Public Library. Initially supported by the Rockefeller Brothers Fund, BPC is now funded by assessments on property and businesses adjacent to the park, and by revenue generated from events held at the park. BPC is the largest U.S. effort to provide private management, with private funding, to a public park.

By the 1970s, Bryant Park had become a dangerous haven because of drug dealers and was widely seen as a symbol of New York City decline. BPC immediately brought significant changes that made the park once again a place that people wanted to visit. Biederman, a proponent of the "Broken Windows Theory" expounded by James Q. Wilson and George L. Kelling in a seminal 1982 article in Atlantic Monthly, instituted a rigorous program to clean the park, remove graffiti and repair the broken physical plant. BPC also created a private security staff to confront unlawful behavior immediately.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  NEWYORK CITY PLACES (02 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img3.jpg";
$image_array[1] = "dummy/img4.jpg";
$image_array[1] = "dummy/img5.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '26 E 23rd St, Manhattan, NY 10010, USA',
					"geo_latitude"	        => '40.7408452',
					"geo_longitude"	        => '-73.987976',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $newyork,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Madison Square Park',
					"post_content"	    =>	'The building that became the first Madison Square Garden at 26th Street and Madison Avenue was originally the passenger depot of the New York and Boston Rail Road. When the depot moved uptown in 1871, the building was leased to P.T. Barnum who converted it into the open-air "Hippodrome" for circus performances. In 1875 it was sub-let to the noted band leader Patrick Sarsfield Gilmore, who filled the space with trees, flowers and fountains and named it "Gilmore Concert Garden". Gilmore band of 100 musicians played 150 consecutive concerts there, and continued to perform in the Garden for two years. After he gave up his sub-let, others presented marathon races, temperance and revival meetings, balls, the first Westminster Kennel Club Dog Show (1877), as well as boxing "exhibitions" or "illustrated lectures", since competitive boxing matches were illegal at the time. It was finally renamed "Madison Square Garden" in 1879 by William Kissam Vanderbilt, the son of Commodore Vanderbilt, who continued to present sporting events, the National Horse Show, and more boxing, including bouts by John L. Sullivan that drew huge crowds. Vanderbilt eventually sold what Harper Weekly called his "patched-up grumy, drafty combustible, old shell" to a syndicate that included J. P. Morgan, Andrew Carnegie, James Stillman and W. W. Astor.

The building that replaced it was a Beaux-Arts structure designed by the noted architect Stanford White. White kept an apartment in the building, and was shot dead in the Garden rooftop restaurant by millionaire Harry K. Thaw over an affair White had with Thaw wife, the well-known actress Evelyn Nesbit, who White seduced when she was 16. The resulting sensational press coverage of the scandal caused Thaw trial to be one of the first Trials of the Century.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY PLACES End |||||| //////////////////////////////



////////////////////////  || PHILADELPHIA CITY PLACES ||   ///////////////////////////////
//////////////////////// |||  PHILADELPHIA CITY PLACES (01)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg" ;
$image_array[1] = "dummy/img2.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img6.jpg" ;
$image_array[4] = "dummy/img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '118 S. 20th Street, Philadelphia, PA 19103',
					"geo_latitude"	        => '39.951401',
					"geo_longitude"	        => '-75.173862',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '10:00 to 06:00 ',
					"contact"	        	=> '(243) 222-12344',
					"email"	        		=> 'info@villagewhiskey.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Village Whiskey',
					"post_content"	    =>	'Located in a Rittenhouse Square space evoking the free-wheeling spirit of a speakeasy, Village Whiskey is prolific Chef Jose Garces’ intimate, 30-seat tribute to the time-honored liquor.

In fact, Village Whiskey features a veritable library of 80-100 varieties of whiskey, bourbon, rye and scotch from Scotland, Canada, Ireland, United States and even Japan.

Much as Village Whiskey could be a scene for toasting and roasting, it also comes from the culinary imagination of Jose Garces (of Amada, Tinto, Distrito and Chifa fame), meaning the food is no less than outstanding.
<h3>Cuisine </h3>

Village Whiskey&acute;s specialty from the kitchen is “bar snacks,” but that doesn&acute;t mean a bowl of cashews. Rather, it means deviled eggs, spicy popcorn shrimp, soft pretzels and an à la carte raw bar, all treated with the culinary care that made Jose Garces a finalist on The Next Iron Chef.

Perhaps you seek something heartier. The lobster roll, raw bar selections and Kentucky fried quail are standouts, but you’d really ought to order the Whiskey King: a 10 oz patty of ground-to-order sustainable angus topped with maple bourbon glazed cipollini, Rogue blue cheese, applewood smoked bacon and foie gras. Bring your appetite.
<h3>Cocktails </h3>

Whiskey-based cocktails are divided into two categories: Prohibition (classic cocktails) and Repeal (more contemporary, modern takes). Meanwhile, the venerable Manhattan is a mainstay, mixed using house-made bitters.

Prohibition cocktails include: Old Fashioned (Bottle in Bond Bourbon and house bitters); Aviation (Creme de Violette and gin); and Philadelphia Fish House Punch (dark rum, peach brandy and tea). Repeal cocktails include: APA (hops-infused vodka, ginger and egg white); De Riguer (rye, aperol, grapefruit and mint); and Horse With No Name (scotch, Stone Pine Liqueur and pineapple).
<h3>Atmosphere </h3>

The speakeasy atmosphere is accomplished through dim lighting, posters for various alcohols, a tin ceiling and antique mirrors. Black-and-white white tiled floors, marble topped tables and wooden drink rails add to the traditional bar decor.

Behind the pewter bar, whiskies are proudly displayed like leather-bound books.

During the warmer months, diners can sit at large, wooden tables placed along Sansom Street for whiskey alfresco.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  PHILADELPHIA CITY PLACES (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/7.jpg" ;
$image_array[1] = "dummy/img3.jpg" ;
$image_array[2] = "dummy/img2.jpg" ;
$image_array[3] = "dummy/img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '112 S. 13th Street Philadelphia, PA',
					"geo_latitude"	        => '39.949945',
					"geo_longitude"	        => '-75.162178',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> 'Daily : 10 am to 11 pm',
					"contact"	        	=> '(243) 222-12344',
					"email"	        		=> 'info@zavino.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Zavino Pizzeria and Wine Bar',
					"post_content"	    =>	'Zavino is a new pizzeria and wine bar located at the epicenter of the city&acute;s trendy Midtown Village neighborhood. The restaurant features a seasonal menu, classic cocktails, an approachable selection of wine and beer and some of the best late night menu offerings in the area.

The restaurant&acute;s interior looks great - it has a simple, rustic feel with an original brick wall, large picture windows, a long bar and a large outdoor cafe coming this spring.

And the menu is great too - it boasts affordable snacks ranging from pizza to pasta to charcuterie to satisfy diners’ hunger, and then cocktails, including Italy&acute;s venerable Negroni and Bellini, and an ever-evolving assortment of wine and beer offerings, to quench their thirst.

Menu items vary seasonally, as is customary in Italy, and may include: House-Made Beef Ravioli with brown butter and sage; Roasted Red and Golden Beets with pistachios and goat cheese; Roasted Lamb with fried eggplant and mint; a delicious house-made gnocchi; and traditional Panzanella, a tomato and bread salad. There is also a nice selection of cheese and charcuterie available a la carte.

<h3>The Pizza </h3>

The gourmet pizzas are baked in a special wood-burning oven that reaches temperatures of up to 900 degrees. The pizzas are approximately 12 inches in diameter. And Chef Gonzalez describes the crust as neither too thin or too thick, but rather somewhere right between Neapolitan and Sicilian, “crunchy and tender, and just exactly right.”

Three classic pizzas will be available year-round: Rosa, with tomato sauce and roasted garlic; Margherita, with tomato sauce and buffalo mozzarella, topped with fresh basil; and Polpettini, tomato sauce and provolone cheese with veal mini-meatballs.

The specialty pizzas that are on the opening winter menu include: Philly, with bechamel, provolone, roasted onions and bresaola; Kennett, with bechamel, claudio&acute;s mozzarella, roasted onions with oyster, cremini and shitake mushrooms; Sopressata, with tomato sauce, claudio&acute;s mozzarella, sopressata olives, pickled red onion and pecorino; and Fratello, with bechamel, broccoli, roasted garlic and claudio&acute;s mozzarella.

Pizzas vary in price from $8 to $12.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  PHILADELPHIA CITY PLACES (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img3.jpg";
$image_array[1] = "dummy/img2.jpg";
$image_array[2] = "dummy/img1.jpg";
$image_array[3] = "dummy/img6.jpg";
$image_array[4] = "dummy/img7.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '227 S. 18th Street, Philadelphia, PA 19103',
					"geo_latitude"	        => '39.9489408',
					"geo_longitude"	        => '-75.1708782',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> 'Daily : 10 am to 12 pm',
					"contact"	        	=> '(143) 222-12344',
					"email"	        		=> 'info@parc-restaurant.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Parc',
					"post_content"	    =>	'If you love Paris in the springtime, Parc is a veritable grand cru.

With Parc, famed restaurateur Stephen Starr brings a certain je ne sais quoi to Rittenhouse Square. Parc offers an authentic French bistro experience, fully equipped with a chic Parisian ambiance and gorgeous sidewalk seating overlooking the Square.
<h3>Cuisine </h3>

Parc menu encourages a joyful dining experience, where croissants, champagne and conversation are enjoyed in equal measure.

Sample hors d’oeuvres include salade lyonnaise with warm bacon vinaigrette and poached egg, escargots served in their shells with hazelnut butter and a crispy duck confit with frisée salad and pickled chanterelles.

Outstanding entrées include boeuf bourguignon with fresh buttered pasta and steak frites with peppercorn sauce. A variety of plats du jour are also offered, including a seafood-rich bouillabaisse on Fridays and a sumptuous coq au vin, perfect for Sunday night suppers.

And what&acute;s an authentic French meal without wine? More than 160 expertly chosen varietals are offered by the bottle, with more than 20 available by the glass.
<h3>See and Be Seen </h3>

With seating for more than 75 at its sidewalk and window seating, Parc has instantly become one of the best places in Philadelphia for alfresco drinking and dining.

The awning-covered seating wraps around the restaurant&acute;s two sides and overlooks Rittenhouse Square, one of Philadelphia&acute;s most popular public spaces.
<h3>Atmosphere </h3>

The aroma of freshly baked breads fills the air as one enters Parc&acute;s casual front room, which is clad in hand-laid Parisian tiles in shades of ecru and green.

Red leather banquettes flanked by frosted glass offer subtle intimacy, while well-worn wooden chairs, reclaimed bistro tables and mahogany paneled walls give the room a sense of place.

The more formal dining room provides a slightly more sophisticated experience while maintaining the energy and emotion of a bustling brasserie.

To put it simply, Parc is nothing short of an authentic Parisian dining experience - right here in the heart of Rittenhouse Square.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 3 END  |||  //////////////////////////////////////////////////////////// 


//////////////////////// |||  PHILADELPHIA CITY PLACES (01 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img7.jpg";
$image_array[1] = "dummy/img8.jpg";
$image_array[1] = "dummy/img9.jpg";
$image_array[1] = "dummy/img10.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '321 Chestnut St, Philadelphia, PA 19106, USA',
					"geo_latitude"	        => '39.9488417',
					"geo_longitude"	        => '-75.146921',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> 'info@museum.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'National Liberty Museum ',
					"post_content"	    =>	'The United States Declaration of Independence guarantees us the inalienable rights of life, liberty, and the pursuit of happiness, and it is the National Liberty Museum proud mission to celebrate those freedoms. With approximately 30,000 square feet of exhibit space, the museum contains eight galleries, as well as a meeting hall, gift shop and education center – all centered around the concepts of freedom and liberty.

The "Flame of Liberty," created by Dale Chihuly, is the museum signature art piece featuring curly, fiery-red tubes of blown glass entangled with one another. Shimmering under the display lights, this abstract work of art spans two floors and is quite a spectacle.

Along the museum stairwell is a powerful 9/11 memorial, featuring pictures of police officers and firefighters who perished while saving others, a memorial that humanizes this tragedy by putting faces with names.

Walk through the "From Conflict to Harmony" exhibit and learn more about violence and how you can better cope with it. Part of this gallery focuses on bullying because it can do as much damage as a lethal weapon. One unique, symbolic art piece here is a metal sculpture of John Lennon constructed entirely of melted guns, a design that underscores the mindless destruction and violence behind his murder.

The gallery also has a unique work station where visitors take a piece of paper and write words of hate, which they then shred. They then write positive words on another piece of paper, and place it in the friendship box, illustrating the intangible strength of words.

Jellybean fanatics will love the "Jellybean People" statue by Sandy Skoglund. This one-of-a-kind work is made of 24,000 colorful jellybeans to illustrate that people of all colors inhabit the same human body.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  PHILADELPHIA CITY PLACES (02 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img6.jpg";
$image_array[1] = "dummy/img7.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1900 Benjamin Franklin Pkwy, Philadelphia, PA 19103',
					"geo_latitude"	        => '39.957262',
					"geo_longitude"	        => '-75.171129',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'The Academy of Natural Sciences',
					"post_content"	    =>	'Collections are the hallmark of museums and those at The Academy of Natural Sciences are among the more important of their kind. The size and scope of its collections have grown substantially since the early years. Currently, there are over 17 million biological specimens, and hundreds of thousands of volumes, journals, illustrations, photographs, and archival items in its library. These collections grew through a combination of means, including the donation or purchase of existing collections or individual items, the collection activities of Academy-sponsored expeditions, or those of individual scientists, whether or not they work at the Academy. Sometimes the Academy is also enlisted to house and care for collections originally gathered by other institutions. For example, a number of the natural history collections at the American Philosophical Society were relocated to the Academy by the end of the 19th century.

But these collections are not maintained just to collect dust. They provide a library of biodiversity. Traditionally, researchers at natural science (or natural history) institutions such as the Academy engaged in biological taxonomy, the science of discovering, describing, naming, and classifying species: in essence, the cataloging of Nature. In recent decades, research has shifted in emphasis to the science of systematics, the study of the evolutionary relationships among these species.

Either way, the collections are invaluable. They provide the type specimens, the reference material that helps establish a species identity. They also provide raw materials with which scientists can investigate the nature of these species, their relationships with other species, their evolutionary history, or even their conservation status. New questions and new technology illustrate the importance of these collections. Titian Peale (1799–1885) may not have been interested in the conservation biology of the butterflies he collected while Henry Pilsbry (1862–1957) probably did not consider comparing the DNA of his snails. Yet, modern scientists have such options because these specimens are part of the collections.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 


//////////////////////// |||  PHILADELPHIA CITY PLACES (01 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg";
$image_array[1] = "dummy/img2.jpg";
$image_array[2] = "dummy/img3.jpg";
$image_array[3] = "dummy/img4.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '4160 Horticultural Drive, Philadelphia, PA 19131',
					"geo_latitude"	        => '39.9839908',
					"geo_longitude"	        => '-75.2127805',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> 'info@parkname.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Fairmount Park',
					"post_content"	    =>	'The park system is named after its first park, Fairmount Park, which occupies nearly half the area of the whole system, at over 4,100 acres (17 km²). Today, the Commission divides the original park into East and West Fairmount parks. The original domain of Fairmount Park consisted of three areas: "South Park" or the South Garden immediately below the Fairmount Water Works extending to the Callowhill Street Bridge; East or "Old Park" which encompassed the former estates of Lemon Hill and Sedgeley; and West Park, the area now comprising the Philadelphia Zoo and the Centennial Exposition grounds. The South Garden predated the establishment of the Park Commission in 1867 and Lemon Hill and Sedgley were added in 1855–56. After the Civil War, work progressed on acquiring and laying out West Park. In the 1870s, the Fairmount Park Commission acquired industrial properties along the Wissahickon Creek although this is not considered Fairmount Park proper. Likewise the Schuylkill River Trail is a modern addition and was not included in 19th-century acquisitions.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  PHILADELPHIA CITY PLACES (02 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img9.jpg";
$image_array[1] = "dummy/img10.jpg";
$image_array[1] = "dummy/img11.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '4398 Chester Ave, Philadelphia, Pennsylvania 19104',
					"geo_latitude"	        => '39.9483588',
					"geo_longitude"	        => '-75.210323',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '0261 222 3232',
					"email"	        		=> '',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $philadelphia,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Clark Park',
					"post_content"	    =>	'Clark Park Advisory Council exists to promote the maintenance of Clark Park and adjacent properties as green space, various types of arboretums and gardens, protect wildlife habitat, and public recreational area stressing a natural river front, wild bird and flower sanctuary, and a protected low density natural space for the use of the public in sports and other pursuits requiring large open green space as part of the mix of the park.

Richard Clark Park comprises nearly ten acres of green space along the east bank of the Chicago River in the North Center neighborhood. Situated adjacent to DeVry University and Lane Technical High School, Clark Park provides Lane students room to practice football, baseball and field hockey. Dog walkers and bird watchers enjoy their pursuits in a convenient locations. The park soccer fields and bike trails sit on land once occupied by the fondly-remembered Riverview Amusement Park. Riverview, created in 1904 on the site of a former German hunting preserve, was for a time the world largest amusement park, with a massive roller coaster, a double Ferris wheel, a tunnel of love, a water slide, a parachute drop, and carnival games of skill and chance, among many other things. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  PHILADELPHIA CITY PLACES End |||||| //////////////////////////////

////////////////////////  || SAN FRANSISCO CITY PLACES ||   ///////////////////////////////
//////////////////////// ||| SAN FRANSISCO CITY PLACES (01)  start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img6.jpg" ;
$image_array[1] = "dummy/img7.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img4.jpg" ;
$image_array[4] = "dummy/img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '658 Market Street San Francisco, CA',
					"geo_latitude"	        => '37.7883246',
					"geo_longitude"	        => '-122.4027731',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '10:00 to 06:00 ',
					"contact"	        	=> '(243) 222-12344',
					"email"	        		=> 'info@villagewhiskey.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Zuni Cafe ',
					"post_content"	    =>	'Billy West opened Zuni Café in 1979, with a huge heart and exactly ten thousand dollars. In the early years, the restaurant consisted of a narrow storefront with a creaky mezzanine, roughly one quarter of its current size. To capitalize on the neighboring and highly visible corner cactus shop, (where Billy had been a partner, until it became clear cactus sales would not support three partners), he hand-plastered the walls and banquettes of his new space to give it a southwestern adobe-look. He chose the name Zuni, after the native American tribe, and decided to offer mostly simple and authentic Mexican food, drawing inspiration from Diana Kennedy cookbooks. A Weber grill was an important early investment, and was rolled on to the back sidewalk for each day service. Next came an espresso machine, which doubled as a stove since you could scramble eggs with the milk steamer. The waiters made this dish, to order. Barely two years later, Billy hired Vince Calcagno to help run his struggling café, when helping to run the café meant managing the books and entire front of house operations. Vince occasionally called friends to help cook when Billy was understaffed in the kitchen. (I received one of those calls and recall a frantic, but happy evening of making countless Caesar Salads, harvesting sizzling croutons from an undersized and overworked toaster oven, which was tethered to the single kitchen outlet with a daisy chain of extension cords.) But, ever resourceful and passionate, Billy and Vince made a success of the improbable restaurant. By 1986, Zuni had absorbed the adjacent storefront, and spilled into the former cactus shop.

When Billy and Vince, now partners in the business, asked me to be chef in 1987, the restaurant was very busy and well-respected. The food was delicious; milk-steamer eggs had gone away and there was an indoor grill and exhaust system. The menu still had a vaguely Mexican bent and the most popular dish was the made-to-order Caesar Salad. I accepted the job. I was confident that the owners affection for France and Italy, and for traditional food, would sanction lots of experimentation, and change. I told Billy and Vince that we really needed a brick oven, and within a few months there was a 12- by 8-foot hole in the middle of the main dining room, decorated with plenty of bright yellow caution tape. ',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  SAN FRANSISCO CITY PLACES (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img8.jpg" ;
$image_array[1] = "dummy/img9.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '300 Grove Street, San Francisco, CA 94102',
					"geo_latitude"	        => '37.778029',
					"geo_longitude"	        => '-122.421754',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> 'Daily : 10 am to 11 pm',
					"contact"	        	=> '(243) 222-12344',
					"email"	        		=> 'info@hotelname.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Jardiniere Restaurant ',
					"post_content"	    =>	'When Edward and I walked into Jardinière and saw the well-stocked horseshoe bar illuminated with Tiffany style lamps, we knew that was where we had to begin our evening. Ruben and Amy, the personable and talented duo behind the bar on the night we had dinner, made us feel like we were San Francisco regulars. After perusing their extensive cocktail menu list of Modern Classics, Classics, and Originals, we decided to sample two of Jardinière original cocktails, The Pony Express (Jardinière Barrel Selection of Sazerac, Rye, Qi White Tea Liqueur, Organic Maple Syrup, and Lemon), and Tippler Delight (Navip Slivovitz 8 Year, St. Germain Elderflower Liqueur, Lemon, Pernod Absinthe). Sitting at the bar, we were able to appreciate all of the subtle details of the restaurant, where the ebb and flow of the patrons kept the bartenders squeezing fresh citrus for the cocktails, and the servers delivering one gorgeous creation after another, deliciously tempting our palates.

Cocktail hour over, the hostess brought us to our table located on the second floor, reached by climbing a cream colored draped wrought iron stairway. The attractive restaurant features exposed brick walls, patterned sheers at the windows, pink tinged scallop shaped sconces on dark wood pillars, fairy lights illuminating the room, domed rotunda ceiling, dark carpet, and tables dressed with ivory linens and votive candles, with wine buckets ingeniously incorporated into the wrought iron railing.

Jardinière Amuse BoucheOur server, Michael, began our Jardinière dining experience with aperitifs of Veuve Fourny Brut Blanc de Blancs "Premier Cru" Vertus, France, NV, 12% alcohol, to accompany the Amuse Bouche of Blini topped with minced egg white, chopped herbs, and crowned with Tsar Nicoulai Estate Caviar from California sturgeon from a sustainable farm, which was a perfect little greeting from Chef Craig Patzer.

Edward continued with a first course of St. Simone and Chelsea Gem Oysters on the Half Shell with Champagne Mignonette and Fresh Horseradish attractively presented on a bed of salt with a strand of seaweed, lemon wedge, bowl of fresh horseradish, and a bowl of champagne mignonette. ',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  SAN FRANSISCO CITY PLACES (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img9.jpg";
$image_array[1] = "dummy/img10.jpg";
$image_array[2] = "dummy/img1.jpg";
$image_array[3] = "dummy/img4.jpg";
$image_array[4] = "dummy/img5.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '131 Gough Street, San Francisco, CA 94102',
					"geo_latitude"	        => '37.7746401',
					"geo_longitude"	        => '-122.4226546',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> 'Daily : 10 am to 12 pm',
					"contact"	        	=> '(143) 222-12344',
					"email"	        		=> 'info@parc-restaurant.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Sauce',
					"post_content"	    =>	'Chef Ben Paula and brothers Trip, Nate and Matt Hosley Welcome you to Sauce  131 Gough Street (between Oak and Page) in San Francisco  Hayes Valley.

At Sauce we serve what we like to call Social Cuisine American comfort fare so good youll want everyone at the table to try a bite. It shared food without the tiny plates. Come sample Chef Ben creations along with some drinks in the intimate Supper Club cozy up to the beautiful redwood bar for a signature cocktail or, enjoy a meal in the bustling main dining room. Experience what happens when Comfort Food meets California Cuisine — it could be our tomato bisque with white truffle grilled cheese sticks, Portobello mushroom fries, or our signature applewood-smoked-bacon wrapped meatloaf something is sure to tickle your fancy. Located just a few blocks from the Civic Center in Hayes Valley, Sauce is a comfortable spot for drinking and dining. Pre-Show, post-show and for all your private events Sauce is the place. Stop by for dinner any night between 5pm and 2 am and see for yourself what cooking at Sauce.',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Restaurants'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 3 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  SAN FRANSISCO CITY PLACES (01 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img7.jpg";
$image_array[1] = "dummy/img8.jpg";
$image_array[1] = "dummy/img1.jpg";
$image_array[1] = "dummy/img2.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '321 Chestnut St, Philadelphia, PA 19106, USA',
					"geo_latitude"	        => '39.9488417',
					"geo_longitude"	        => '-75.146921',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> 'info@museum.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Museum of Modern Art',
					"post_content"	    =>	'
					SFMOMA was founded in 1935 under director Grace L. McCann Morley as the San Francisco Museum of Art. For its first sixty years, the museum occupied the fourth floor of the War Memorial Veterans Building on Van Ness Avenue in the Civic Center. A gift of 36 artworks from Albert M. Bender, including The Flower Carrier (1935) by Diego Rivera, established the basis of the permanent collection. Bender donated more than 1,100 objects to SFMOMA during his lifetime and endowed the museum first purchase fund
					
					The museum began its second year with an exhibition of works by Henri Matisse. In this same year the museum established its photography collection, becoming one of the first museums to recognize photography as a fine art. SFMOMA held its first architecture exhibition, entitled Telesis: Space for Living, in 1940.
					
					SFMOMA was obliged to move to a temporary facility on Post Street in March 1945 to make way for the United Nations Conference on International Organization. The museum returned to its original Van Ness location in July, upon the signing of the United Nations Charter. Later that year SFMOMA hosted Jackson Pollock first solo museum exhibition
					
					Founding director Grace Morley held film screenings at the museum beginning in 1937, just two years after the institution opened. In 1946 Morley brought in filmmaker Frank Stauffacher to found SFMOMA influential Art in Cinema film series, which ran for nine years. SFMOMA continued its expansion into new media with the 1951 launch of a biweekly television program entitled Art in Your Life. The series, later renamed Discovery, ran for three years. Morley ended her 23-year tenure as museum director in 1958 and was succeeded by George D. Culler (1958–65) and Gerald Nordland (1966–72). The museum rose to international prominence under director Henry T. Hopkins (1974–86), adding "Modern" to its title in 1975. Since 1967, SFMOMA has honored San Francisco Bay Area artists with its biennial SECA Art Award.
					
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  SAN FRANSISCO CITY PLACES (02 - Musseum)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img9.jpg";
$image_array[1] = "dummy/img10.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '200 Larkin Street, San Francisco, CA 94102',
					"geo_latitude"	        => '37.7746401',
					"geo_longitude"	        => '-122.4226546',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> 'info@museumname.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Asian Art Museum',
					"post_content"	    =>	'The Asian Art Museum of San Francisco is a museum in San Francisco, California, United States. It has one of the most comprehensive collections of Asian art in the world.

Until 2003 the museum shared a space with the de Young Museum in Golden Gate Park; during its last year in the park it was closed for the purpose of moving to its new location, and it re-opened on March 20, 2003 in the former San Francisco city library building opposite the San Francisco Civic Center, renovated for the purpose under the direction of Italian architect Gae Aulenti. Lord Cultural Resources, a cultural professional practice, was also commissioned to undertake a three-part sequence of planning studies for the relocation of the Museum.

The collection has approximately 17,000 works of art and artifacts from all major Asian countries and traditions, some of which are as much as 6,000 years old. Major galleries are devoted to the arts of South Asia, West Asia (including Persia), Southeast Asia, the Himalayas, China, Korea and Japan. There are 2,500 works on display in the permanent collection.

The museum owes its origin to a donation to the city of San Francisco by Chicago millionaire Avery Brundage, who was a major collector of Asian art. The Society for Asian Art, incorporated in 1958, was the group that formed specifically to gain Avery Brundage collection. The museum opened in 1966 as a wing of the M. H. de Young Memorial Museum in Golden Gate Park. Brundage continued to make donations to the museum, including the bequest of all his remaining personal collection of Asian art on his death in 1975. In total, Brundage donated more than 7,700 Asian art objects to San Francisco.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Museum'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 


//////////////////////// |||  SAN FRANSISCO CITY PLACES (01 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img9.jpg";
$image_array[1] = "dummy/img7.jpg";
$image_array[2] = "dummy/img1.jpg";
$image_array[3] = "dummy/img2.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1601-1645 Market St, San Francisco, CA 94103, USA',
					"geo_latitude"	        => '37.774936',
					"geo_longitude"	        => '-122.4194229',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => 'info@parkname.com',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '1112223456',
					"email"	        		=> 'info@parkname.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Mission Dolores Park',
					"post_content"	    =>	'Mission Dolores Park (commonly called Dolores Park; formerly known as Mission Park) is a San Francisco, California, city park located in the neighborhood of Mission Dolores, at the western edge of the Mission District, which lies to the east of the park. To the west of the park is a hillside referred to as "Dolores Heights" or considered a part of the Castro neighborhood. Dolores Park is two blocks tall by one block wide, based on the configuration of north-south and east-west blocks in that part of San Francisco. It is bounded by 18th Street on the north, 20th Street to the south, Dolores Street to the east and Church Street to the west. The northern end of Dolores Park is located directly across the street from Mission High School.

Dolores park offers several features: several tennis courts and a basketball court, a soccer field, a children playground, and a dog play area. The southern half of the park is also notable for its views of the Mission district, downtown, the San Francisco Bay and the East Bay. Also notable is the routing of the Muni Metro J-Church streetcar line through the park.

The park lies east of Twin Peaks in the warm and sunny microclimate of the Mission neighborhood. The park is popular among San Franciscans looking for outdoor relaxation and recreation.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 

//////////////////////// |||  SAN FRANSISCO CITY PLACES (02 - Parks)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img10.jpg";
$image_array[1] = "dummy/img4.jpg";
$image_array[1] = "dummy/img5.jpg";
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '7 Hagiwara Tea Garden Drive, San Francisco, CA 94118',
					"geo_latitude"	        => '37.770104',
					"geo_longitude"	        => '-122.470286',
					"map_view"	        	=> 'Satellite Map',
					"add_feature"	        => '',
					"timing"	       		=> '11:00 to 08:00 ',
					"contact"	        	=> '0261 222 3232',
					"email"	        		=> 'info@parkname.com',
					"twitter"	        	=> 'http://twitter.com/',
					"facebook"	        	=> 'http://facebook.com/',
					"proprty_feature"	    => '',
					"post_city_id"	        => $sanfransisco,
					"video"	       			=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '',
					"paymentmethod"	        => '',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '1',
					"featured_type"	        => 'h',
					"home_featured_type"	        => 'h',
					"total_amount"	        => '',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    =>	'Japanese Tea Garden',
					"post_content"	    =>	'The Japanese Tea Garden in San Francisco, California, is a popular feature of Golden Gate Park, originally built as part of a sprawling World Fair, the California Midwinter International Exposition of 1894. For more than 20 years San Francisco Parks Trusts Park Guides have given free tours to San Francisco Parks trust members, providing context and history for this historic Japanese-style garden.

The oldest public Japanese garden in the United States, this complex of many paths, ponds and a teahouse features native Japanese and Chinese plants. The gardens 5 acres (2.0 ha) contain many sculptures and bridges.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Places','Parks'),
					"post_tags"		    =>	array('Park')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  SAN FRANSISCO CITY PLACES End |||||| //////////////////////////////


insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE1."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE1;
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy=CUSTOM_CATEGORY_TYPE1);
			wp_set_object_terms($last_postid,$post_info_arr['post_tags'], $taxonomy='cartags');

			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}


//=============================CUSTOM TAXONOMY=======================================================//
//////////////////////// |||  NEWYORK CITY EVENT START |||||| //////////////////////////////
$post_info = array();
insert_taxonomy_category($category_array);
//////////////////////// |||  NEWYORK CITY EVENT (01)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg" ;
$image_array[1] = "dummy/img2.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img4.jpg" ;
$image_array[4] = "dummy/img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '125 E 11th St, New York, NY',
					"geo_latitude"	        => '40.7316872',
					"geo_longitude"	        => '-73.9892914',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-12',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-15',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $newyork,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'CIRCUS SATURDAY',
					"post_content"	    	=>	'Dress to impress! *
* Neat and trendy appearence a must.
Webster Hall reserves the right to deny admission to anyone,
and is not required to specify cause for denial. 


4 Massive Floors, 3000 people
The Greatest Party On Earth
with The Flying Trapeze
Fire Breathers
Snake Charmers
Go Go Girls
4 Levels of Adventure
6 Dancefloors
In the Grand ballroom - house, electronic, DJ Mike chach + DJ Tengo
In the Marlin Room - top 40 mash ups, DJ Ray Roc
In the balcony lounge - hiphop, Sean Sharp + D.L.O
In the Studio - Live Bands
CIRCUS will bring back the shows
It will bring back the feeling
It will bring back the magic
It will inspire you to remember the first time
you set foot in a club and fell in love with the Night.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
/////////////////////// |||  NEWYORK CITY EVENT (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img6.jpg" ;
$image_array[1] = "dummy/img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '125 E 11th St, New York, NY',
					"geo_latitude"	        => '40.7316872',
					"geo_longitude"	        => '-73.9892914',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $newyork,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Halloween 2011',
					"post_content"	    	=>	'Since 1886, the people of New York City have entered the mysterious and hallowed walls of Webster Hall and commenced in a notorious display of exhibitionism, consumption and debauchery. By the turn of the century, Webster Hall was known to many as The Devil Playground. This Halloween, 101 years later, the Devil rises to dance amongst the people for one very special night....

Monday, October 31st 2011...Webster Hall presents the official NYC Halloween Parade Afterparty. WEBSTER HELL is a once in a lifetime event. All 4 massive floors of Webster Hall transform into a twisted mausoleum filled with heart-pounding dance music. Sensual fire performances mesmerize the crowd as flying Vampires soar high over their heads in the Grand Ballroom. Thousands of revelers, hidden behind masks and disguised as freakish inversions of their former selves, eagerly attend what is hands down the biggest Halloween party in NYC every year.

Throughout the evening, guests witness a series of mind-blowing spectacles. At the stroke of Midnight, with flames blazing, an innocent virgin is picked from the crowd. Stripped of her clothing and dignity, the crowd watches as she is ritualistically sacrificed on a massive pentagram hung 40 feet in the air. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Musical'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 2 END  |||  ////////////////////////////////////////////////////////////
/////////////////////// |||  NEWYORK CITY EVENT (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img11.jpg" ;
$image_array[1] = "dummy/img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '217 Bowery, Manhattan, NY 10002, USA',
					"geo_latitude"	        => '40.721682',
					"geo_longitude"	        => '-73.99311',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $newyork,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'DJ Big Ben and more w/ Gia Bella',
					"post_content"	    	=>	'217 Bowery (at Rivington St) , NYC
2 For 1 drinks for all 10-12 w/RSVP!. doors open at 10 pm. DJs SKI-HI and guests rock the best in hip-hop, house, reggae, rock, latin and old skool classics in 2 floors of music. We are taking over this party and management and show all how Cris A.C. and DJ SKI-HI does it in 2011. We will love your feed back as how we can make it a better experience for you and your friends. RSVP is required for entry and VIP courtesy. Make sure to mention my list, "CLUB PLANET Guest List", for free admission for everyone (Ladies til 1, Guys til 12, $10 after). Ask about our birthday & group packages with extension on FREE admission, free champagne &/or free liquor bottle (for VIP) for your party! Dress fashionable and chic please . 21+ID.
To get on the Guest List/ VIP/ Table at CrisAC  or call me direct at 917.653.0768 anytime to be on my list or upon arrival at the door.

Few of many specials (w/ advanced reservation) +tax & tip:
- 2 bottle of Stoli or Absolut Vodka = $465
- 2 bottle of Belvedere or Grey Goose Vodka = $500
- 2 bottle of MOET = $275
- 2 bottles of CIROC(.750 litre) = $390

- FREE bottle of Champagne with table service 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 3 END  |||  ////////////////////////////////////////////////////////////
/////////////////////// |||  NEWYORK CITY EVENT (04)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img11.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1271 Avenue of the Americas, Manhattan, NY 10020, USA',
					"geo_latitude"	        => '40.7602909',
					"geo_longitude"	        => '-73.9809017',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-22',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-30',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $newyork,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'An Evening of Art Under the Stars ',
					"post_content"	    	=>	'Please join the Young Leadership Council of Bottomless Closet for the 6th Annual Art Under the Stars event.  

The mission of Bottomless Closet is to help economically disadvantaged New York City women become self-sufficient through a comprehensive program that begins with business attire and interview preparation and continues with professional development, financial management, and personal enrichment. 

Help us support the work of Bottomless Closet while enjoying cocktails, hors doeuvres and a silent auction and raffle.

Please visit us at www.BottomlessClosetNYC.org to purchase tickets & packages and preview auction highlights. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Charity'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 4 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  NEWYORK CITY EVENT END |||||| //////////////////////////////


//////////////////////// |||  PHILADELPHIA CITY EVENT (01)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img8.jpg" ;
$image_array[1] = "dummy/img9.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img4.jpg" ;
$image_array[4] = "dummy/img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '3025 Walnut Street, Philadelphia, PA 19104-3402',
					"geo_latitude"	        => '39.9522059',
					"geo_longitude"	        => '-75.185114',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-12',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-15',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $philadelphia,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'World Cafe Live',
					"post_content"	    	=>	'This multi-level venue features a casual dining/listening space, 300-person bistro-style concert room, music shop and WXPN’s radio studios.

Settle into the sunny Upstairs Live Cafe where, through late-night eats and drinks, you can enjoy live music and food in a city-chic setting. Downstairs, past the enormous, colorful mural and WXPN’s studios (Go ahead and peek into the window. You might catch the namesake show being taped), is the main performance venue featuring nationally-known artists.

No sticky floors here. Downstairs Live’s muted colors, contemporary design, top-notch sound system and good sight lines create a lively, sophisticated atmosphere. Food and drinks are optional but advance tickets are required.

<h3>History</h3>

When a brainstorm hit a local entrepreneur/amateur musician simultaneously, he decided adults needed a place to hear live music. Turns out WXPN also needed new studios, especially for its nationally popular show, “World Cafe.” Mutual interests merged and six years later, World Cafe Live came to be.
Insider Tip

There’s not a bad seat in the house, but the best place to see a show is from the bar.


<h3>Kids Stuff</h3>

Peanut Butter and Jams is a family-friendly Saturday lunchtime program that offers a fun and interactive live music experience for kids and parents. For a complete schedule of performers and ticket information, visit World Café Live .

',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
/////////////////////// |||  PHILADELPHIA CITY EVENT (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img10.jpg" ;
$image_array[1] = "dummy/img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '125 E 11th St, New York, NY',
					"geo_latitude"	        => '40.7316872',
					"geo_longitude"	        => '-73.9892914',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $philadelphia,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Theatre of the Living Arts',
					"post_content"	    	=>	'One of the many concert venues in Philadelphia, this old movie theatre now serves up the latest, though not always the most renowned, musical acts in pop/ hip-hop culture. While equipped with a bar and bouncers with attitudes, there is also a balcony for the more "civilized" concert-goers. Artists ranging from Liz Phair to Transam have contributed their talents to TLA shows.
					
					Great sound stage. (maybe the best in philly) generally good acts. a couple of incredible shows were the mars volta, isis, ministry and buckethead. the layout of the place is also pretty sweet. upstairs balcony if you do not want to be on the floor.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Musical'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 
/////////////////////// |||  PHILADELPHIA CITY EVENT (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img3.jpg" ;
$image_array[1] = "dummy/img2.jpg" ;
$image_array[1] = "dummy/img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1399 W Somerville Ave, Philadelphia, PA 19141',
					"geo_latitude"	        => '40.0352879',
					"geo_longitude"	        => '-75.1455318',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $philadelphia,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Blue Cross Broad Street Run 10-Miler',
					"post_content"	    	=>	'The 10-mile, point-to-point course is a gentle downgrade that runs from the northern edge of Philadelphia down to its southern tip.

You’ll pass many of the city’s most important landmarks along the way, including Temple University, City Hall, Pennsylvania Academy of the Fine Arts, The Avenue of the Arts and the Philadelphia stadium complex.

Expect record-breaking times and a field of about 18,000 runners on this USATF-certified course, which rates as one of the fastest in the county by Runner’s World Magazine. The race finishes inside the Philadelphia Navy Yard.

<h3>Runners Info</h3>

There are eleven water stations, digital clocks at each mile market, aid stations, port-a-potties, entertainment and numerous ambulances on the course. The course is traffic-free in the south-bound lanes and monitored by police. This course is certified by USATF.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 3 END  |||  ////////////////////////////////////////////////////////////
/////////////////////// |||  PHILADELPHIA CITY EVENT (04)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img2.jpg" ;
$image_array[1] = "dummy/img1.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1448 Front St, Fredericktown, PA 15333',
					"geo_latitude"	        => '40.0008896',
					"geo_longitude"	        => '-79.9978765',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-22',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-30',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $philadelphia,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Independence Day Parade',
					"post_content"	    	=>	'The Wawa Welcome America! Independence Day Parade is bigger and better than ever in 2011 with more than 4,000 participants from a dozen states.

The parade kicks off at 11 a.m. and features 16 marching musical groups, nine floats, five military branches and plenty of special guests.

Among the performers this year: the Hoh Japanese Drummers, Minas Brazilian Dancers and Drummers and the oldest fife and drum band in America, the Mattatuck Drum Band founded in 1767.

Hundreds of active duty enlisted and veteran soldiers and officers from the Marines, Army, Navy, Air Force and Coast Guard will march down the nation’s historic mile as part of the “Salute to the Armed Forces” float.

<h3>Parade Route</h3>

The Independence Day Parade has been expanded two blocks in 2011, starting at 5th and Chestnut streets immediately following Independence Day Ceremony.

The parade will continue right on 9th Street, heading one block before turning right onto Market Street. The procession comes to an end at Front Street. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Charity'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 4 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  PHILADELPHIA CITY EVENT END |||||| //////////////////////////////

//////////////////////// |||  SAN FRANSISCO CITY EVENT (01)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img11.jpg" ;
$image_array[1] = "dummy/img9.jpg" ;
$image_array[2] = "dummy/img3.jpg" ;
$image_array[3] = "dummy/img4.jpg" ;
$image_array[4] = "dummy/img5.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1581 Webster St # 200, San Francisco, CA 94115-3616',
					"geo_latitude"	        => '37.785241',
					"geo_longitude"	        => '-122.4314451',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-12',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-15',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '+1 (0)415 928 24 56',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $sanfransisco,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Taiko Dojo',
					"post_content"	    	=>	'The International Taiko Festival, at San Francisco promotes an ancient art of Japan – the Taiko drum. Japenese considered it a sacred instrument. It was used in ancient Japan to drive away evil spirits and pests which may harm crops. It was also used to invoke the rain god to bless the earth. After each bountiful crop the Taiko was again played as a symbol of joy.
With the rapid modernization of Japan, ancient arts like Taiko have taken a back seat and relegated to a pleasant memory. However, a cultural renaissance has been taking place in Japan — a rediscovery of native arts. Today, every school child in Japan knows of Taiko. The drums are handmade by professional drum makers in Japan.
The most famous of these drums is the O-Daiko drum which is over 12 feet in height. It is regarded as a historical and cultural icon. Over the last decade Taiko enthusiasts, Seiichi Tanaka and the San Francisco Taiko Dojo have rediscovered Taiko from its primitive folk art roots to a powerful, sophisticated synthesis of rhythm, harmony, and body movement.
Today, at the festival a strenous, mental physical martial art training is harmonised with musical talent. Taiko Dojo, under the direction of Grand Master Tanaka, is a soul stirring experience. The performance is visual, audio, and visceral. The combination of traditional and contemporary rhythms, dance, and martial arts permeates your physical and spiritual being bringing lasting bliss.  

',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 1 END  |||  //////////////////////////////////////////////////////////// 
/////////////////////// |||  SAN FRANSISCO CITY EVENT (02)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg" ;
$image_array[1] = "dummy/img7.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '155 Fell Street, San Francisco, CA 94102-5106',
					"geo_latitude"	        => '37.7759504',
					"geo_longitude"	        => '-122.4204504',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $sanfransisco,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'FOSTER THE PEOPLE (DJ Set)',
					"post_content"	    	=>	'Foster The People came together in late 2009 when Mark Foster met band mates Cubbie Fink and Mark Ponitus through mutual friends in the Los Angeles music scene. Foster hailing from Cleveland, OH had been writing and recording music since his youth but it wasn’t until the three members came together that Foster’s music for the bands upcoming debut release, Torches, was ready for friends to hear.

In early 2010, Foster The People posted their first song Pumped Up Kicks on the internet. Days later it was used to score a friend’s fashion video, days after that it showed up on Hype Machine and a year later it had seemed to make its way into the ears of millions of listeners around the world.

Almost immediately upon forming last October, the band gained a critical mass among regulars of West Hollywood notorious Viper Room, National Public Radio subscribers and even, erm, Mark Ronson. Blessed with a knack for melody, boogie-time beats, and an ornate electronic detail, Foster The People craft a sound ideal for a fantasy backyard barbecue with The Strokes, Vampire Weekend, MGMT and Daft Punk as guests.
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Musical'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 2 END  |||  //////////////////////////////////////////////////////////// 
/////////////////////// |||  SAN FRANSISCO CITY EVENT (03)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img9.jpg" ;
$image_array[1] = "dummy/img10.jpg" ;
$image_array[1] = "dummy/img11.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '1500 Broadway, San Francisco, California 94109,',
					"geo_latitude"	        => '37.7959506',
					"geo_longitude"	        => '-122.421985',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-15',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-25',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $sanfransisco,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Rouge',
					"post_content"	    	=>	'Rouge has established itself as a social hotspot and has created a warm, welcoming environment for each of its guests. It is an unconventional blend of a casual and friendly atmosphere amidst an elegant, chic décor. The excellent customer service allows every patron to be a VIP. As Broadway’s discreet social lounge, Rouge offers a variety of diversions. Whether having a drink at the bar, enjoying a variety of sports events on any of the 5 plasma televisions, lounging with friends in one of the red velvet booths, listening to live jazz, viewing up-and-coming local artistry, or dancing to the rhythms of a celebrity DJ, Rouge is a diverse local for everyone. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Club'),
					"post_tags"		    =>	array('night, nightlife, mondays')
					);
//////////////  ||||   POST 3 END  |||  ////////////////////////////////////////////////////////////
/////////////////////// |||  SAN FRANSISCO CITY EVENT (04)   start |||||| //////////////////////////////
$image_array = array();
$image_array[0] = "dummy/img1.jpg" ;
$image_array[1] = "dummy/img2.jpg" ;
$post_meta = array();
$post_meta = array(
					"geo_address"	        => '401 Van Ness Ave. San Francisco, CA 94102',
					"geo_latitude"	        => '37.779649',
					"geo_longitude"	        => '-122.420552',
					"map_view"	        	=> 'Default view',
					"add_feature"	        => '',
					"st_date"	        	=> '2012-12-22',
					"st_time"	        	=> '10:00',
					"end_date"	        	=> '2012-12-30',
					"end_time"	        	=> '12:00',
					"reg_desc"	        	=> 'Click on the below link to register by going to our website. Just enter your detail and pay the registration fees.',
					"reg_fees"	        	=> '112',
					"contact"	        	=> '9987854678',
					"email"	        		=> 'info@eventname.com',
					"twitter"	        	=> 'http://twitter.com/myplace',
					"facebook"	        	=> 'http://facebook.com/myplace',
					"proprty_feature"		=> '',
					"post_city_id"	        => $sanfransisco,
					"video"	        		=> '',
					"is_featured"	        => '1',
					"paid_amount"	        => '',
					"alive_days"	        => '300',
					"paymentmethod"	        => 'paypal',
					"remote_ip"	        	=> getenv('REMOTE_ADDR'),
					"ip_status"	        	=> '0',
					"pkg_id"	        	=> '2',
					"featured_type"	        => 'c',
					"home_featured_type"	        => 'icat',
					"total_amount"	        => '10',
					"website"	        	=> 'http://templatic.com',
					"tl_dummy_content"		=> '1',
			);
$post_info[] = array(
					"post_title"	    	=>	'Runway to Happiness - A Charity Fashion Show To Benefit Project Happiness',
					"post_content"	    	=>	'Join us for a charity fashion show to benefit Project Happiness featuring top designers Dries Van Noten, Maison Martin Margiela, Yoshi Kondo, Comme des Garcons, Jil Sander, J.W. Brine, Miller Et Bertaux, Tsumori Chisato and many others, all courtesy of Modern Appealing Clothing.  
100% of the proceeds from this very special evening go to benefit Project Happiness, a 501(c)(3) nonprofit organization.  Complimentary hors douevres and two complimentary beverages included with ticket price.  There will be a cash bar available from 7 PM until 10:30 PM. 
',
 					"post_meta"		    =>	$post_meta,
					"post_image"	    =>	$image_array,
					"post_category"	    =>	array('Events','Charity'),
					"post_tags"		    =>	array('Sample Tags')
					);
//////////////  ||||   POST 4 END  |||  //////////////////////////////////////////////////////////// 
//////////////////////// |||  SAN FRANSISCO CITY EVENT END |||||| //////////////////////////////

insert_taxonomy_posts_event($post_info);
function insert_taxonomy_posts_event($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE2."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE2;
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy=CUSTOM_CATEGORY_TYPE2);
			wp_set_object_terms($last_postid,$post_info_arr['post_tags'], $taxonomy='cartags');

			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}


//====================================================================================//
/////////////////////////////////////////////////
$pages_array = array(array('Page Templates','Advanced Search','Archives','Full Width','Left Sidebar Page','Sitemap','Contact Us'),'Shortcodes',
array('Dropdowns','Sub Page 1','Sub Page 2'));
$page_info_arr = array();
$page_info_arr['Page Templates'] = '
In WordPress, you can write either posts or pages. When you writing a regular blog entry, you write a post. Posts automatically appear in reverse chronological order on your blog home page. Pages, on the other hand, are for content such as "About Me," "Contact Me," etc. Pages live outside of the normal blog chronology, and are often used to present information about yourself or your site that is somehow timeless -- information that is always applicable. You can use Pages to organize and manage any amount of content. WordPress can be configured to use different Page Templates for different Pages. 

To create a new Page, log in to your WordPress admin with sufficient admin privileges to create new page. Select the Pages &gt; Add New option to begin writing a new Page.


Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.
';
$page_info_arr['Advanced Search'] = '
This is the Advanced Search page template. See how it looks. Just select this template from the page attributes section and you&rsquo;re good to go.
';
$page_info_arr['Archives'] = '
This is Archives page template. Just select it from page templates section and you&rsquo;re good to go.
';
$page_info_arr['Shortcodes'] = '
This theme comes with built in shortcodes. The shortcodes make it easy to add stylised content to your site, plus they&rsquo;re very easy to use. Below is a list of shortcodes which you will find in this theme.
[ Download ]
[Download] Download: Look, you can use me for highlighting some special parts in a post. I can make download links more highlighted. [/Download]
[ Alert ]
[Alert] Alert: Look, you can use me for highlighting some special parts in a post. I can be used to alert to some special points in a post. [/Alert]
[ Note ]
[Note] Note: Look, you can use me for highlighting some special parts in a post. I can be used to display a note and thereby bringing attention.[/Note]
[ Info ]
[Info] Info: Look, you can use me for highlighting some special parts in a post. I can be used to provide any extra information. [/Info]
[ Author Info ]
[Author Info]<img src="'.$dummy_image_path.'no-avatar.png" alt="" />
<h4>About The Author</h4>
Use me for adding more information about the author. You can use me anywhere within a post or a page, i am just awesome. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing.
[/Author Info]
<h3>Button List</h3>
[ Small_Button class="red" ]
[Small_Button class="red"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="grey"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="black"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="blue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="lightblue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="purple"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="magenta"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="green"]<a href="#">Button Text</a>[/Small_Button]  [Small_Button class="orange"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="yellow"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="pink"]<a href="#">Button Text</a>[/Small_Button]
<hr />
<h3>Icon list view</h3>
[ Icon List ]
[Icon List]
<ul>
	<li> Use the shortcode to add this attractive unordered list</li>
	<li> SEO options in every page and post</li>
	<li> 5 detailed color schemes</li>
	<li> Fully customizable front page</li>
	<li> Excellent Support</li>
	<li> Theme Guide &amp; Tutorials</li>
	<li> PSD File Included with multiple use license</li>
	<li> Gravatar Support &amp; Threaded Comments</li>
	<li> Inbuilt custom widgets</li>
	<li> 30 built in shortcodes</li>
	<li> 8 Page templates</li>
	<li>Valid, Cross browser compatible</li>
</ul>
[/Icon List]
<h3>Dropcaps Content</h3>
[ Dropcaps ] 
[Dropcaps] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

[Dropcaps] Dropcaps can be so useful sometimes. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

<h3>Content boxes</h3>
We, the content boxes can be used to highlight special parts in the post. We can be used anywhere, just use the particular shortcode and we will be there.
[ Normal_Box ]
[Normal_Box]
<h3>Normal Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Normal_Box]

[ Warning_Box ]
[Warning_Box]
<h3>Warring Box</h3>
This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Warning_Box]

[ Download_Box ]
[Download_Box]
<h3>Download Box</h3>
This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Download_Box]

[ About_Box ]
[About_Box]
<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

[/About_Box]

[ Info_Box ]

[Info_Box]
<h3>Info Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Info_Box]

[ Alert_Box ]
[Alert_Box]
<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Alert_Box]

[Info_Box_Equal]
<h3>Info Box</h3>
This is how info content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of Info box.<strong> [ Info_Box_Equal ]</strong>
[/Info_Box_Equal]


[Alert_Box_Equal]

<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of alert box.<strong> [ Alert_Box_Equal ]</strong>


[/Alert_Box_Equal]

[About_Box_Equal]

<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, molestie in, commodo  porttitor. Use this shortcode for this type of about box. <strong>[ About_Box_Equal ]</strong>

[/About_Box_Equal]


[One_Half]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half ]</strong>

[/One_Half]


[One_Half_Last]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half_Last ]</strong>

[/One_Half_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam ut lacus. <strong>[ One_Third ]</strong>

[/One_Third]


[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in. Commodo  porttitor, felis. Nam lacus. <strong> [ One_Third ]</strong>

[/One_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. <strong>[ One_Third_Last ]</strong>

[/One_Third_Last]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong> [ One_Fourth ]</strong>

[/One_Fourth]


[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth_Last]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth_Last ]</strong>

[/One_Fourth_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus. <strong>[ One_Third ]</strong>

[/One_Third]



[Two_Third_Last]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus.  <strong> [ Two_Third_Last ]</strong>

[/Two_Third_Last]



[Two_Third]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. <strong>[ Two_Third ]</strong>

[/Two_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, commodo  porttitor, felis.  <strong> [ One_Third_Last ]</strong>

[/One_Third_Last]
';
$page_info_arr['Full Width'] = '
Do you know how easy it is to use Full Width page template ? Just add a new page and select full width page template and you are good to go. Here is a preview of this easy to use page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.

See, there no sidebar in this template, and that why we call this a full page template. Yes, its this easy to use page templates. Just write any content as per your wish.
';
$page_info_arr['Left Sidebar Page'] = '
This is <strong>left sidebar page template</strong>. To use this page template, just select - page left sidebar template from Pages and publish the post. Its so easy using a page template.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec libero.

Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id, libero. In eget purus.

Vestibulum ut nisl. Donec eu mi sed turpis feugiat feugiat. Integer  turpis arcu, pellentesque eget, cursus et, fermentum ut, sapien. Fusce  metus mi, eleifend sollicitudin, molestie id, varius et, nibh. Donec nec  libero. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus  tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam  leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et  ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce varius urna  id quam.
<blockquote>Blockquote text looks like this</blockquote>
See, using left sidebar page template is so easy. Really.
';
$page_info_arr['Sitemap'] = '
See, how easy is to use page templates. Just add a new page and select <strong>Sitemap</strong> from the page templates section. Easy peasy, isn&rsquo;t it.
';
$page_info_arr['Contact Us'] = '
What do you think about this Contact page template ? Have anything to say, any suggestions or any queries ? Feel free to contact us, we&rsquo;re here to help you. You can write any text in this page and use the Contact Us page template. Its very easy to use page templates.
';
$page_info_arr['Dropdowns'] = '
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
';
$page_info_arr['Sub Page 1'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Sub Page 2'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';

set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					echo '';
				}else
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('home')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}
//=====================================================================
$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Advanced Search' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_advanced_search.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Web Hosting Plan' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Shortcodes' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_archives.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Full Width' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Left Sidebar Page' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_left_sidebar_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sitemap' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_sitemap.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contact Us' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'tpl_contact.php' );

global $upload_folder_path;
global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
$folderpath = $upload_folder_path . "dummy/";
$strpost = strpos(get_template_directory(),'wp-content');
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/dummy"; 
full_copy( get_template_directory()."/images/dummy/", $target );
 
function full_copy( $source, $target ) 
{
	$imagepatharr = explode('/',str_replace(ABSPATH,'',$target));
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path = ABSPATH.$imagepatharr[$i]."/";
		  if (!file_exists($year_path) && strstr($year_path,"wp-content")){
			 @mkdir($year_path, 0777);
		  }     
		}
	}
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			@copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		@copy( $source, $target );
	}
}

///////////////////////////////////////////////////////////////////////////////////
//====================================================================================//

/////////////// WIDGET SETTINGS START ///////////////

$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();


//////////////// Header Logo Right Side //////////////////////
$listing_link = array();
$listing_link[1] = array(
					"title"			=>	'',
					"category"		=>	'',
					"post_number"	=>	'',
					"post_link"		=>	'',
					"video_link"	=>	'',
					);						
$listing_link['_multiwidget'] = '1';
update_option('widget_listing_link',$listing_link);
$listing_link = get_option('widget_listing_link');
krsort($listing_link);
foreach($listing_link as $key1=>$val1)
{
	$listing_link_key = $key1;
	if(is_int($listing_link_key))
	{
		break;
	}
}

$sidebars_widgets["header_logo_right_side"] = array("listing_link-$listing_link_key");

//////////////// Main Navigation //////////////////////
$widget_multi_city = array();
$widget_multi_city[1] = array(
					"title"			=>	'',
					"desc1"		=>	'',					
					);						
$widget_multi_city['_multiwidget'] = '1';
update_option('widget_widget_multi_city',$widget_multi_city);
$widget_multi_city = get_option('widget_widget_multi_city');
krsort($widget_multi_city);
foreach($widget_multi_city as $key1=>$val1)
{
	$widget_multi_city_key = $key1;
	if(is_int($widget_multi_city_key))
	{
		break;
	}
}

$sidebars_widgets["main_navigation"] = array("widget_multi_city-$widget_multi_city_key");

//////////////// Front Top Banner //////////////////////
$googlemmapwidget_home = array();
$googlemmapwidget_home = get_option('widget_googlemmapwidget_home');
$googlemmapwidget_home[1] = array(
					"width"			=>	'',
					"heigh"		=>	'',					
					);						
$googlemmapwidget_home['_multiwidget'] = '1';
update_option('widget_googlemmapwidget_home',$googlemmapwidget_home);
$googlemmapwidget_home = get_option('widget_googlemmapwidget_home');
krsort($googlemmapwidget_home);
foreach($googlemmapwidget_home as $key1=>$val1)
{
	$googlemmapwidget_home_key = $key1;
	if(is_int($googlemmapwidget_home_key))
	{
		break;
	}
}

$sidebars_widgets["front_top_banner"] = array("googlemmapwidget_home-$googlemmapwidget_home_key");


//////////////// Front Content //////////////////////
$latest_posts_list_view = array();
$latest_posts_list_view = get_option('widget_latest_posts_list_view');
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Attractions'");
$latest_posts_list_view[1] = array(
					"title"			=>	'Attraction',
					"category"		=>	$category,					
					"number"		=>	'3',					
					"post_type"		=>	'place',					
					"link"			=>	'#',					
					"text"			=>	'View All',					
					);						
$latest_posts_list_view['_multiwidget'] = '1';
update_option('widget_latest_posts_list_view',$latest_posts_list_view);
$latest_posts_list_view = get_option('widget_latest_posts_list_view');
krsort($latest_posts_list_view);
foreach($latest_posts_list_view as $key1=>$val1)
{
	$latest_posts_list_view_key = $key1;
	if(is_int($latest_posts_list_view_key))
	{
		break;
	}
}

$latest_posts_grid_view = array();
$latest_posts_grid_view = get_option('widget_latest_posts_grid_view');
$category = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Events'");
$latest_posts_grid_view[1] = array(
					"title"			=>	'Events',
					"category"		=>	'' ,					
					"number"		=>	'3',					
					"post_type"		=>	'event',					
					"link"			=>	'#',					
					"text"			=>	'View All',					
					);						
$latest_posts_grid_view['_multiwidget'] = '1';
update_option('widget_latest_posts_grid_view',$latest_posts_grid_view);
$latest_posts_grid_view = get_option('widget_latest_posts_grid_view');
krsort($latest_posts_grid_view);
foreach($latest_posts_grid_view as $key1=>$val1)
{
	$latest_posts_grid_view_key = $key1;
	if(is_int($latest_posts_grid_view_key))
	{
		break;
	}
}


$sidebars_widgets["front_content"] = array("latest_posts_list_view-$latest_posts_list_view_key","latest_posts_grid_view-$latest_posts_grid_view_key");

//////////////// Front Sidebar //////////////////////
$widget_ads = array();
$widget_ads[1] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /></a>',								
					);						
$widget_ads['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads);
$widget_ads = get_option('widget_widget_ads');
krsort($widget_ads);
foreach($widget_ads as $key1=>$val1)
{
	$widget_ads_key = $key1;
	if(is_int($widget_ads_key))
	{
		break;
	}
}

$widget_comment = array();
$widget_comment[1] = array(
					"title"			=>	'Recent Reviews',
					"post_type"		=>	'place',
					"count"			=>	'3',						
							
					);						
$widget_comment['_multiwidget'] = '1';
update_option('widget_widget_comment',$widget_comment);
$widget_comment = get_option('widget_widget_comment');
krsort($widget_comment);
foreach($widget_comment as $key1=>$val1)
{
	$widget_comment_key = $key1;
	if(is_int($widget_comment_key))
	{
		break;
	}
}

$widget_werecommend = array();
$widget_werecommend[1] = array(
					"title"				=>	'We Recommend',
					"s1"				=>	$dummy_image_path.'img1.jpg',
					"s1link"			=>	'#',
					"s2"				=>	$dummy_image_path.'img2.jpg',
					"s2link"			=>	'#',
					"s3"				=>	$dummy_image_path.'img3.jpg',
					"s3link"			=>	'#',
					"s4"				=>	$dummy_image_path.'img4.jpg',
					"s4link"			=>	'#',
					"s5"				=>	$dummy_image_path.'img5.jpg',
					"s5link"			=>	'#',
					"s6"				=>	'',
					"s6link"			=>	'',
					"s7"				=>	'',
					"s7link"			=>	'',
					"s8"				=>	'',
					"s8link"			=>	'',
					"s9"				=>	'',
					"s9link"			=>	'',
					"s10"				=>	'',
					"s10link"			=>	'',
					"effect"			=>	'random',
					"slices"			=>	'10',
					"animSpeed"			=>	'',
					"pauseTime"			=>	'',
					"startSlide"		=>	'',
					"directionNavHide"	=>	'',
					"slider_img"		=>	'',
					"width"				=>	'',
					"height"			=>	'',
							
					);						
$widget_werecommend['_multiwidget'] = '1';
update_option('widget_widget_werecommend',$widget_werecommend);
$widget_werecommend = get_option('widget_widget_werecommend');
krsort($widget_werecommend);
foreach($widget_werecommend as $key1=>$val1)
{
	$widget_werecommend_key = $key1;
	if(is_int($widget_werecommend_key))
	{
		break;
	}
}

$eventwidget = array();
$eventwidget[1] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'post',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',						
							
					);						
$eventwidget['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget);
$eventwidget = get_option('widget_eventwidget');
krsort($eventwidget);
foreach($eventwidget as $key1=>$val1)
{
	$eventwidget_key = $key1;
	if(is_int($eventwidget_key))
	{
		break;
	}
}

$sidebars_widgets["front_sidebar"] = array("widget_ads-$widget_ads_key","widget_comment-$widget_comment_key","widget_werecommend-$widget_werecommend_key","eventwidget-$eventwidget_key");

//////////////// Place Listing Sidebar //////////////////////
$widget_ads2 = array();
$widget_ads2 = get_option('widget_widget_ads');
$widget_ads2[2] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /></a>',							
					);						
$widget_ads2['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads2);
$widget_ads2 = get_option('widget_widget_ads');
krsort($widget_ads2);
foreach($widget_ads2 as $key1=>$val1)
{
	$widget_ads2_key = $key1;
	if(is_int($widget_ads2_key))
	{
		break;
	}
}


$widget_comment2 = array();
$widget_comment2 = get_option('widget_widget_comment');
$widget_comment2[2] = array(
					"title"			=>	'Recent Reviews',
					"post_type"		=>	'place',
					"count"			=>	'3',						
							
					);						
$widget_comment2['_multiwidget'] = '1';
update_option('widget_widget_comment',$widget_comment2);
$widget_comment2 = get_option('widget_widget_comment');
krsort($widget_comment2);
foreach($widget_comment2 as $key1=>$val1)
{
	$widget_comment2_key = $key1;
	if(is_int($widget_comment2_key))
	{
		break;
	}
}


$widget_werecommend2 = array();
$widget_werecommend2 = get_option('widget_widget_werecommend');
$widget_werecommend2[2] = array(
					"title"				=>	'',
					"s1"				=>	$dummy_image_path.'img2.jpg',
					"s1link"			=>	'#',
					"s2"				=>	$dummy_image_path.'img5.jpg',
					"s2link"			=>	'#',
					"s3"				=>	$dummy_image_path.'img1.jpg',
					"s3link"			=>	'#',
					"s4"				=>	$dummy_image_path.'img3.jpg',
					"s4link"			=>	'#',
					"s5"				=>	$dummy_image_path.'img4.jpg',
					"s5link"			=>	'#',
					"s6"				=>	'',
					"s6link"			=>	'',
					"s7"				=>	'',
					"s7link"			=>	'',
					"s8"				=>	'',
					"s8link"			=>	'',
					"s9"				=>	'',
					"s9link"			=>	'',
					"s10"				=>	'',
					"s10link"			=>	'',
					"effect"			=>	'',
					"slices"			=>	'',
					"animSpeed"			=>	'',
					"pauseTime"			=>	'',
					"startSlide"		=>	'',
					"directionNavHide"	=>	'',
					"slider_img"		=>	'',
					"width"				=>	'',
					"height"			=>	'',	
					);						
$widget_werecommend2['_multiwidget'] = '1';
update_option('widget_widget_werecommend',$widget_werecommend2);
$widget_werecommend2 = get_option('widget_widget_werecommend');
krsort($widget_werecommend2);
foreach($widget_werecommend2 as $key1=>$val1)
{
	$widget_werecommend2_key = $key1;
	if(is_int($widget_werecommend2_key))
	{
		break;
	}
}

$eventwidget2 = array();
$eventwidget2 = get_option('widget_eventwidget');
$eventwidget2[2] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'post',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',							
					);						
$eventwidget2['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget2);
$eventwidget2 = get_option('widget_eventwidget');
krsort($eventwidget2);
foreach($eventwidget2 as $key1=>$val1)
{
	$eventwidget2_key = $key1;
	if(is_int($eventwidget2_key))
	{
		break;
	}
}

$sidebars_widgets["place_listing_sidebar"] = array("widget_ads-$widget_ads2_key","widget_comment-$widget_comment2_key","widget_werecommend-$widget_werecommend2_key","eventwidget-$eventwidget2_key");

//////////////// Place Detail Sidebar //////////////////////
$neighborhood = array();
$neighborhood[1] = array(
					"title"			=>	'In the neighborhood',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',
					"closer_factor"	=>	'1',
					);						
$neighborhood['_multiwidget'] = '1';
update_option('widget_neighborhood',$neighborhood);
$neighborhood = get_option('widget_neighborhood');
krsort($neighborhood);
foreach($neighborhood as $key1=>$val1)
{
	$neighborhood_key = $key1;
	if(is_int($neighborhood_key))
	{
		break;
	}
}

$sidebars_widgets["place_detail_sidebar"] = array("neighborhood-$neighborhood_key");


//////////////// Event Listing Sidebar //////////////////////
$widget_ads3 = array();
$widget_ads3 = get_option('widget_widget_ads');
$widget_ads3[3] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt300x250px.jpg" alt="" /></a>',						
					);						
$widget_ads3['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads3);
$widget_ads3 = get_option('widget_widget_ads');
krsort($widget_ads3);
foreach($widget_ads3 as $key1=>$val1)
{
	$widget_ads3_key = $key1;
	if(is_int($widget_ads3_key))
	{
		break;
	}
}

$widget_comment3 = array();
$widget_comment3 = get_option('widget_widget_comment');
$widget_comment3[3] = array(
					"title"			=>	'Recent Review',
					"post_type"		=>	'event',
					"count"			=>	'3',						
							
					);						
$widget_comment3['_multiwidget'] = '1';
update_option('widget_widget_comment',$widget_comment3);
$widget_comment3 = get_option('widget_widget_comment');
krsort($widget_comment3);
foreach($widget_comment3 as $key1=>$val1)
{
	$widget_comment3_key = $key1;
	if(is_int($widget_comment3_key))
	{
		break;
	}
}

$widget_werecommend3 = array();
$widget_werecommend3 = get_option('widget_widget_werecommend');
$widget_werecommend3[3] = array(
					"title"				=>	'',
					"s1"				=>	$dummy_image_path.'img5.jpg',
					"s1link"			=>	'#',
					"s2"				=>	$dummy_image_path.'img2.jpg',
					"s2link"			=>	'#',
					"s3"				=>	$dummy_image_path.'img3.jpg',
					"s3link"			=>	'#',
					"s4"				=>	$dummy_image_path.'img1.jpg',
					"s4link"			=>	'#',
					"s5"				=>	$dummy_image_path.'img4.jpg',
					"s5link"			=>	'#',
					"s6"				=>	'',
					"s6link"			=>	'',
					"s7"				=>	'',
					"s7link"			=>	'',
					"s8"				=>	'',
					"s8link"			=>	'',
					"s9"				=>	'',
					"s9link"			=>	'',
					"s10"				=>	'',
					"s10link"			=>	'',
					"effect"			=>	'',
					"slices"			=>	'',
					"animSpeed"			=>	'',
					"pauseTime"			=>	'',
					"startSlide"		=>	'',
					"directionNavHide"	=>	'',
					"slider_img"		=>	'',
					"width"				=>	'',
					"height"			=>	'',
							
					);						
$widget_werecommend3['_multiwidget'] = '1';
update_option('widget_widget_werecommend',$widget_werecommend3);
$widget_werecommend3 = get_option('widget_widget_werecommend');
krsort($widget_werecommend3);
foreach($widget_werecommend3 as $key1=>$val1)
{
	$widget_werecommend3_key = $key1;
	if(is_int($widget_werecommend3_key))
	{
		break;
	}
}

$eventwidget3 = array();
$eventwidget3 = get_option('widget_eventwidget');
$eventwidget3[3] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'post',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',						
					);						
$eventwidget3['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget3);
$eventwidget3 = get_option('widget_eventwidget');
krsort($eventwidget3);
foreach($eventwidget3 as $key1=>$val1)
{
	$eventwidget3_key = $key1;
	if(is_int($eventwidget3_key))
	{
		break;
	}
}

$sidebars_widgets["event_listing_sidebar"] = array("widget_ads-$widget_ads3_key","widget_comment-$widget_comment3_key","widget_werecommend-$widget_werecommend3_key","eventwidget-$eventwidget3_key");

//////////////// Event Detail Sidebar //////////////////////
$neighborhood2 = array();
$neighborhood2 = get_option('widget_neighborhood');
$neighborhood2[2] = array(
					"title"			=>	'In the neighborhood',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',
					"closer_factor"	=>	'1',
					);						
$neighborhood2['_multiwidget'] = '1';
update_option('widget_neighborhood',$neighborhood2);
$neighborhood2 = get_option('widget_neighborhood');
krsort($neighborhood2);
foreach($neighborhood2 as $key1=>$val1)
{
	$neighborhood2_key = $key1;
	if(is_int($neighborhood2_key))
	{
		break;
	}
}

$sidebars_widgets["event_detail_sidebar"] = array("neighborhood-$neighborhood2_key");

//////////////// Contact Googlemap //////////////////////
$widget_location_map = array();
$widget_location_map[1] = array(
					"title"				=>	'',
					"address"			=>	'230 Vine street, Old city, Philadelphia, PA 19106',
					"address_latitude"	=>	'39.95',
					"address_longitude"	=>	'-75.14',
					"map_width"			=>	'300',
					"map_height"		=>	'300',
					"map_type"			=>	'ROADMAP',
					"scale"				=>	'13',
					);						
$widget_location_map['_multiwidget'] = '1';
update_option('widget_widget_location_map',$widget_location_map);
$widget_location_map = get_option('widget_widget_location_map');
krsort($widget_location_map);
foreach($widget_location_map as $key1=>$val1)
{
	$widget_location_map_key = $key1;
	if(is_int($widget_location_map_key))
	{
		break;
	}
}

$sidebars_widgets["contact_googlemap"] = array("widget_location_map-$widget_location_map_key");

//////////////// Blog Listing Sidebar //////////////////////
$search = array();
$search[1] = array(
					"title"				=>	'',
					);						
$search['_multiwidget'] = '1';
update_option('widget_search',$search);
$search = get_option('widget_search');
krsort($search);
foreach($search as $key1=>$val1)
{
	$search_key = $key1;
	if(is_int($search_key))
	{
		break;
	}
}


$eventwidget4 = array();
$eventwidget4 = get_option('widget_eventwidget');
$eventwidget4[4] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',						
					);						
$eventwidget4['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget4);
$eventwidget4 = get_option('widget_eventwidget');
krsort($eventwidget4);
foreach($eventwidget4 as $key1=>$val1)
{
	$eventwidget4_key = $key1;
	if(is_int($eventwidget4_key))
	{
		break;
	}
}

$archives = array();
$archives[1] = array(
					"title"	=>	'Archives',
					);						
$archives['_multiwidget'] = '1';
update_option('widget_archives',$archives);
$archives = get_option('widget_archives');
krsort($archives);
foreach($archives as $key1=>$val1)
{
	$archives_key = $key1;
	if(is_int($archives_key))
	{
		break;
	}
}

$categories = array();
$categories[1] = array(
					"title"	=>	'Category',
					);						
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}

$sidebars_widgets["blog_listing_sidebar"] = array("search-$search_key","eventwidget-$eventwidget4_key","archives-$archives_key","categories-$categories_key");

//////////////// Blog Detail Sidebar //////////////////////
$search2 = array();
$search2 = get_option('widget_search');
$search2[1] = array(
					"title"				=>	'',
					);						
$search2['_multiwidget'] = '1';
update_option('widget_search',$search2);
$search2 = get_option('widget_search');
krsort($search2);
foreach($search2 as $key1=>$val1)
{
	$search2_key = $key1;
	if(is_int($search2_key))
	{
		break;
	}
}

$eventwidget5 = array();
$eventwidget5 = get_option('widget_eventwidget');
$eventwidget5[5] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',					
					);						
$eventwidget5['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget5);
$eventwidget5 = get_option('widget_eventwidget');
krsort($eventwidget5);
foreach($eventwidget5 as $key1=>$val1)
{
	$eventwidget5_key = $key1;
	if(is_int($eventwidget5_key))
	{
		break;
	}
}

$archives2 = array();
$archives2 = get_option('widget_archives');
$archives2[2] = array(
					"title"	=>	'Archives',
					);						
$archives2['_multiwidget'] = '1';
update_option('widget_archives',$archives2);
$archives2 = get_option('widget_archives');
krsort($archives2);
foreach($archives2 as $key1=>$val1)
{
	$archives2_key = $key1;
	if(is_int($archives2_key))
	{
		break;
	}
}

$categories2 = array();
$categories2 = get_option('widget_categories');
$categories2[2] = array(
					"title"	=>	'Category',
					);						
$categories2['_multiwidget'] = '1';
update_option('widget_categories',$categories2);
$categories2 = get_option('widget_categories');
krsort($categories2);
foreach($categories2 as $key1=>$val1)
{
	$categories2_key = $key1;
	if(is_int($categories2_key))
	{
		break;
	}
}

$sidebars_widgets["blog_detail_sidebar"] = array("search-$search2_key","eventwidget-$eventwidget5_key","archives-$archives2_key","categories-$categories2_key");

//////////////// Login Page //////////////////////
$widget_login = array();
$widget_login[1] = array(
					"title"				=>	'Member Login',
					);						
$widget_login['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login);
$widget_login = get_option('widget_widget_login');
krsort($widget_login);
foreach($widget_login as $key1=>$val1)
{
	$widget_login_key = $key1;
	if(is_int($widget_login_key))
	{
		break;
	}
}

$text = array();
$text[1] = array(
					"title"			=>	'100% Satisfaction Guaranteed',
					"text"			=>	'<p> If you&acute;re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#"> frequently asked questions</a>.</p>',
					);						
$text['_multiwidget'] = '1';
update_option('widget_text',$text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key1=>$val1)
{
	$text_key = $key1;
	if(is_int($text_key))
	{
		break;
	}
}

$text2 = array();
$text2 = get_option('widget_text');
$text2[2] = array(
					"title"			=>	'Payment Info',
					"text"			=>	'<p> $250 Full-time listing (60 days) </p><p>$75 Freelance listing (30 days) </p><p>Visa, Mastercard, American Express, and Discover cards accepted  </p><p><img src="'.$dummy_image_path.'cards.gif" alt="" /> </p><p> All major credit cards  accepted. Payments are processed by PayPal, but you do not need an account with PayPal to complete your transaction. (Contact us with any questions.) </p>',
					);						
$text2['_multiwidget'] = '1';
update_option('widget_text',$text2);
$text2 = get_option('widget_text');
krsort($text2);
foreach($text2 as $key1=>$val1)
{
	$text2_key = $key1;
	if(is_int($text2_key))
	{
		break;
	}
}

$text3 = array();
$text3 = get_option('widget_text');
$text3[3] = array(
					"title"			=>	'Need Help?',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. </p>',
					);						
$text3['_multiwidget'] = '1';
update_option('widget_text',$text3);
$text3 = get_option('widget_text');
krsort($text3);
foreach($text3 as $key1=>$val1)
{
	$text3_key = $key1;
	if(is_int($text3_key))
	{
		break;
	}
}

$sidebars_widgets["login_page"] = array("widget_login-$widget_login_key","text-$text_key","text-$text2_key","text-$text3_key");


//////////////// Sidebar1 //////////////////////
$eventwidget6 = array();
$eventwidget6 = get_option('widget_eventwidget');
$eventwidget6[6] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'post',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',										
					);						
$eventwidget6['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget6);
$eventwidget6 = get_option('widget_eventwidget');
krsort($eventwidget6);
foreach($eventwidget6 as $key1=>$val1)
{
	$eventwidget6_key = $key1;
	if(is_int($eventwidget6_key))
	{
		break;
	}
}


$widget_comment4 = array();
$widget_comment4 = get_option('widget_widget_comment');
$widget_comment4[4] = array(
					"title"			=>	'Recent Review',
					"post_type"		=>	'event',
					"count"			=>	'3',						
							
					);						
$widget_comment4['_multiwidget'] = '1';
update_option('widget_widget_comment',$widget_comment4);
$widget_comment4 = get_option('widget_widget_comment');
krsort($widget_comment4);
foreach($widget_comment4 as $key1=>$val1)
{
	$widget_comment4_key = $key1;
	if(is_int($widget_comment4_key))
	{
		break;
	}
}

$widget_ads4 = array();
$widget_ads4 = get_option('widget_widget_ads');
$widget_ads4[4] = array(
					"title"			=>	'',
					"ads"			=>	'',							
					);						
$widget_ads4['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads4);
$widget_ads4 = get_option('widget_widget_ads');
krsort($widget_ads4);
foreach($widget_ads4 as $key1=>$val1)
{
	$widget_ads4_key = $key1;
	if(is_int($widget_ads4_key))
	{
		break;
	}
}

$sidebars_widgets["sidebar1"] = array("eventwidget-$eventwidget6_key","widget_comment-$widget_comment4_key","widget_ads-$widget_ads4_key");

//////////////// Footer1 //////////////////////
$text4 = array();
$text4 = get_option('widget_text');
$text4[4] = array(
					"title"			=>	'About Geo Places',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam.  aliquam,  justo convallis luctus rutrum  justo convallis</p>',
					);						
$text4['_multiwidget'] = '1';
update_option('widget_text',$text4);
$text4 = get_option('widget_text');
krsort($text4);
foreach($text4 as $key1=>$val1)
{
	$text4_key = $key1;
	if(is_int($text4_key))
	{
		break;
	}
}

$sidebars_widgets["footer1"] = array("text-$text4_key");


//////////////// Footer2 //////////////////////
$eventwidget7 = array();
$eventwidget7 = get_option('widget_eventwidget');
$eventwidget7[7] = array(
					"title"			=>	'Latest News',
					"post_type"		=>	'post',
					"category"		=>	'',
					"post_number"	=>	'3',
					"post_link"		=>	'',										
					);						
$eventwidget7['_multiwidget'] = '1';
update_option('widget_eventwidget',$eventwidget7);
$eventwidget7 = get_option('widget_eventwidget');
krsort($eventwidget7);
foreach($eventwidget7 as $key1=>$val1)
{
	$eventwidget7_key = $key1;
	if(is_int($eventwidget7_key))
	{
		break;
	}
}

$sidebars_widgets["footer2"] = array("eventwidget-$eventwidget7_key");


//////////////// Footer3 //////////////////////
$tag_cloud = array();
$tag_cloud[1] = array(
					"title"			=>	'Tag Cloud',
					"taxonomy"		=>	'post_tag',								
					);						
$tag_cloud['_multiwidget'] = '1';
update_option('widget_tag_cloud',$tag_cloud);
$tag_cloud = get_option('widget_tag_cloud');
krsort($tag_cloud);
foreach($tag_cloud as $key1=>$val1)
{
	$tag_cloud_key = $key1;
	if(is_int($tag_cloud_key))
	{
		break;
	}
}

$sidebars_widgets["footer3"] = array("tag_cloud-$tag_cloud_key");


//////////////// Footer4 //////////////////////
$widget_subscribe = array();
$widget_subscribe[1] = array(
					"id"			=>	'',
					"title"			=>	'Newsletter',
					"text"			=>	'If you did like to stay updated with all our latest news please enter your e-mail address here ',							
					);						
$widget_subscribe['_multiwidget'] = '1';
update_option('widget_widget_subscribe',$widget_subscribe);
$widget_subscribe = get_option('widget_widget_subscribe');
krsort($widget_subscribe);
foreach($widget_subscribe as $key1=>$val1)
{
	$widget_subscribe_key = $key1;
	if(is_int($widget_subscribe_key))
	{
		break;
	}
}

$sidebars_widgets["footer4"] = array("widget_subscribe-$widget_subscribe_key");

//////////////// place_detail_content_banner //////////////////////

$widget_ads5 = array();
$widget_ads5 = get_option('widget_widget_ads');
$widget_ads5[5] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',			
					);						
$widget_ads5['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads5);
$widget_ads5 = get_option('widget_widget_ads');
krsort($widget_ads5);
foreach($widget_ads5 as $key1=>$val1)
{
	$widget_ads5_key = $key1;
	if(is_int($widget_ads5_key))
	{
		break;
	}
}

$sidebars_widgets["place_detail_content_banner"] = array("widget_ads-$widget_ads5_key");

//////////////// event_detail_content_banner //////////////////////

$widget_ads6 = array();
$widget_ads6 = get_option('widget_widget_ads');
$widget_ads6[6] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',			
					);						
$widget_ads6['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads6);
$widget_ads6 = get_option('widget_widget_ads');
krsort($widget_ads6);
foreach($widget_ads6 as $key1=>$val1)
{
	$widget_ads6_key = $key1;
	if(is_int($widget_ads6_key))
	{
		break;
	}
}

$sidebars_widgets["event_detail_content_banner"] = array("widget_ads-$widget_ads6_key");

//////////////// blog_detail_content_banner //////////////////////

$widget_ads7 = array();
$widget_ads7 = get_option('widget_widget_ads');
$widget_ads7[7] = array(
					"title"			=>	'',
					"ads"			=>	'<a href="#"><img src="'.$dummy_image_path.'advt468x60px.jpg" alt="" /></a>',			
					);						
$widget_ads7['_multiwidget'] = '1';
update_option('widget_widget_ads',$widget_ads7);
$widget_ads7 = get_option('widget_widget_ads');
krsort($widget_ads7);
foreach($widget_ads7 as $key1=>$val1)
{
	$widget_ads7_key = $key1;
	if(is_int($widget_ads7_key))
	{
		break;
	}
}

$sidebars_widgets["blog_detail_content_banner"] = array("widget_ads-$widget_ads7_key");

//////////////// add_place_sidebar //////////////////////

$widget_login2 = array();
$widget_login2 = get_option('widget_widget_login');
$widget_login2[2] = array(
					"title"				=>	'Member Login',
					);						
$widget_login2['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login2);
$widget_login2 = get_option('widget_widget_login');
krsort($widget_login2);
foreach($widget_login2 as $key1=>$val1)
{
	$widget_login2_key = $key1;
	if(is_int($widget_login2_key))
	{
		break;
	}
}

$text4 = array();
$text4 = get_option('widget_text');
$text4[4] = array(
					"title"			=>	'100% Satisfaction Guaranteed',
					"text"			=>	'<p> If you&acute;re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#"> frequently asked questions</a>.</p>',
					);						
$text4['_multiwidget'] = '1';
update_option('widget_text',$text4);
$text4 = get_option('widget_text');
krsort($text4);
foreach($text4 as $key1=>$val1)
{
	$text4_key = $key1;
	if(is_int($text4_key))
	{
		break;
	}
}

$text5 = array();
$text5 = get_option('widget_text');
$text5[5] = array(
					"title"			=>	'Payment Info',
					"text"			=>	'<p> $250 Full-time listing (60 days) </p><p>$75 Freelance listing (30 days) </p><p>Visa, Mastercard, American Express, and Discover cards accepted  </p><p><img src="'.$dummy_image_path.'cards.gif" alt="" /> </p><p> All major credit cards  accepted. Payments are processed by PayPal, but you do not need an account with PayPal to complete your transaction. (Contact us with any questions.) </p>',
					);						
$text5['_multiwidget'] = '1';
update_option('widget_text',$text5);
$text5 = get_option('widget_text');
krsort($text5);
foreach($text5 as $key1=>$val1)
{
	$text5_key = $key1;
	if(is_int($text5_key))
	{
		break;
	}
}

$text6 = array();
$text6 = get_option('widget_text');
$text6[6] = array(
					"title"			=>	'Need Help?',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. </p>',
					);						
$text6['_multiwidget'] = '1';
update_option('widget_text',$text6);
$text6 = get_option('widget_text');
krsort($text6);
foreach($text6 as $key1=>$val1)
{
	$text6_key = $key1;
	if(is_int($text6_key))
	{
		break;
	}
}

$sidebars_widgets["add_place_sidebar"] = array("widget_login-$widget_login2_key","text-$text4_key","text-$text5_key","text-$text6_key");

//////////////// add_event_sidebar //////////////////////

$widget_login3 = array();
$widget_login3 = get_option('widget_widget_login');
$widget_login3[3] = array(
					"title"				=>	'Member Login',
					);						
$widget_login3['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login3);
$widget_login3 = get_option('widget_widget_login');
krsort($widget_login3);
foreach($widget_login3 as $key1=>$val1)
{
	$widget_login3_key = $key1;
	if(is_int($widget_login3_key))
	{
		break;
	}
}

$text7 = array();
$text7 = get_option('widget_text');
$text7[7] = array(
					"title"			=>	'100% Satisfaction Guaranteed',
					"text"			=>	'<p> If you&acute;re not 100% satisfied with the results from your listing, request a full refund within 30 days after your listing expires. No questions asked. Promise.</p><p>See also our <a href="#"> frequently asked questions</a>.</p>',
					);						
$text7['_multiwidget'] = '1';
update_option('widget_text',$text7);
$text7 = get_option('widget_text');
krsort($text7);
foreach($text7 as $key1=>$val1)
{
	$text7_key = $key1;
	if(is_int($text7_key))
	{
		break;
	}
}

$text8 = array();
$text8 = get_option('widget_text');
$text8[8] = array(
					"title"			=>	'Payment Info',
					"text"			=>	'<p> $250 Full-time listing (60 days) </p><p>$75 Freelance listing (30 days) </p><p>Visa, Mastercard, American Express, and Discover cards accepted  </p><p><img src="'.$dummy_image_path.'cards.gif" alt="" /> </p><p> All major credit cards  accepted. Payments are processed by PayPal, but you do not need an account with PayPal to complete your transaction. (Contact us with any questions.) </p>',
					);						
$text8['_multiwidget'] = '1';
update_option('widget_text',$text8);
$text8 = get_option('widget_text');
krsort($text8);
foreach($text8 as $key1=>$val1)
{
	$text8_key = $key1;
	if(is_int($text8_key))
	{
		break;
	}
}

$text9 = array();
$text9 = get_option('widget_text');
$text9[9] = array(
					"title"			=>	'Need Help?',
					"text"			=>	'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. </p>',
					);						
$text9['_multiwidget'] = '1';
update_option('widget_text',$text9);
$text9 = get_option('widget_text');
krsort($text9);
foreach($text9 as $key1=>$val1)
{
	$text9_key = $key1;
	if(is_int($text9_key))
	{
		break;
	}
}

$sidebars_widgets["add_event_sidebar"] = array("widget_login-$widget_login3_key","text-$text7_key","text-$text8_key","text-$text9_key");




//echo '<pre>'; print_r($sidebars_widgets);exit;
//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END /////////////

//=====================================================================
/////////////// Design Settings START ///////////////


// General settings start  /////
update_option("ptthemes_alt_stylesheet",'1-default');
update_option("ptthemes_show_blog_title",'No');
update_option("ptthemes_feedburner_url",'http://feeds2.feedburner.com/templatic');
update_option("ptthemes_feedburner_id",'templatic/ekPs');
update_option("ptthemes_tweet_button",'Yes');
update_option("ptthemes_facebook_button",'Yes');
update_option("ptthemes_date_format",'M j, Y');
update_option("pttheme_contact_email",'info@mysite.com');
update_option("ptthemes_breadcrumbs",'Yes');
update_option("ptthemes_auto_install",'No');
update_option("ptthemes_postcontent_full",'Excerpt');
update_option("ptthemes_content_excerpt_count",'40');
update_option("ptthemes_content_excerpt_readmore",'Read More &rarr;');
// General settings End  /////

// Navigation settings
update_option("ptthemes_main_pages_nav_enable",'Activate');
// Navigation settings

// Seo option
update_option("pttheme_seo_hide_fields",'No');
update_option("ptthemes_use_third_party_data",'No');
// Seo option 

// Post  option
update_option("ptthemes_home_page",'6');
update_option("ptthemes_cat_page",'6');
update_option("ptthemes_search_page",'6');
update_option("ptthemes_pagination",'Default + WP Page-Navi support');
// Post  option 

//Navigation  
$page_id1 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'About' and post_type='page'");
$page_id2 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contcat Us' and post_type='page'");
$page_id3 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 1' and post_type='page'");
$page_id4 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sub Page 2' and post_type='page'");

$page_id5 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
$page_id6 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Gallery' and post_type='page'");
$page_id7 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Site Map' and post_type='page'");
$page_id8 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Left Sidebar' and post_type='page'");

$pages_ids = $page_id1.",".$page_id2.",".$page_id3.",".$page_id4.",".$page_id5.",".$page_id6.",".$page_id7.",".$page_id8;
update_option("ptthemes_top_pages_nav",$pages_ids);
//Navigation  

// Page Layout
update_option("ptthemes_page_layout",'Page 2 column - Right Sidebar');
update_option("ptthemes_bottom_options",'Three Column');
update_option("ptthemes_enable_claimownership",'Yes');
// Page Layout

/////////////// Design Settings END ///////////////
if(get_option('set_permission') == '') {
 set_option_selling('set_permission','administrator');
}
if(get_option('currency_symbol') == '') {
 set_option_selling('currency_symbol','USD');
} 
?>