**********************************************************
========MANAGE BOOKING SETTINGS MODULE================
**********************************************************

This is the module which will give you the manage_settings management module integrated from wp-admin.

You need to follow steps as mention below to know how to install this module ::-

1)Get the complete folder "manage_settings".


2)insert the database include line to admin/admin_main.php file. 
It will give you functions available for user at front end of theme.
The php code need to add is :
---------------------------------------------
include_once (TT_ADMIN_FOLDER_PATH . 'manage_settings/function_manage_settings.php');
---------------------------------------------


3)You also need to add some code in admin/admin_menu.php file,
to show the hyperlink for "Manage Booking Setting" from  sidebar.

-->Add the below php code in "templ_add_admin_menu()" function of the admin_menu.php file. This code will call the function "manage_settings()" which is mention in the next point.
---------------------------------------------
if(file_exists(TT_ADMIN_FOLDER_PATH . 'manage_settings/admin_manage_manage_settings.php'))
{
		add_submenu_page('templatic_wp_admin_menu', __("Booking Settings",'templatic'), __("Booking Settings",'templatic'), TEMPL_ACCESS_USER, 'manage_settings', 'manage_settings');
}
---------------------------------------------

-->also need to add "manage_settings()" function in the same admin_menu.php file which is called while the link of "Manage Booking Setting" is clicked.
----------------------------------------------

function manage_settings()
{
	global $templ_module_path;
		include_once($templ_module_path . 'admin_manage_settings.php');

}
----------------------------------------------
++++++++++++++++++++++++Thank You+++++++++++++++++++++++++++++++++++++