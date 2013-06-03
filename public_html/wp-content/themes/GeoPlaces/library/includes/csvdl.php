<?php
$csvfilepath = home_url() ."/wp-content/themes/".get_option( 'template' )."/post_sample.csv";
wp_redirect($csvfilepath);
exit;
?>