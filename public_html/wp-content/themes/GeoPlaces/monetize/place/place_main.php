<?php
/******************************************************************
=======  PLEASE DO NOT CHANGE BELOW CODE  =====
You can add in below code but don't remove original code.
This code to include add post,edit and preview from front end.
This file is included in functions.php of theme root at very last php coding line.

You can call add post,edit and preview page by the link 
********************************************************************/
define('TEMPL_PLACE_FOLDER',TT_MODULES_FOLDER_PATH . "place/");
define('TEMPL_PLACE_URI',get_bloginfo('template_directory') . "/monetize/place/");

////////filter to retrive the page HTML from the url.
//add_filter('templ_add_template_page_filter','templ_add_template_place_page'); //filter to add pages like addpost,preveiw,delete and etc....

include_once(TT_MODULES_FOLDER_PATH.'general/multi_city_functions.php'); // function file

?>