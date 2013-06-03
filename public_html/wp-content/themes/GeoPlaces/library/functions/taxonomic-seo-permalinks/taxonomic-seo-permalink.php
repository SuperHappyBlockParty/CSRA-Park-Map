<?php
/*
Plugin Name: Taxonomic SEO Permalink
Plugin URI: http://rakesh.tembhurne.com/projects/taxonomic-seo-permalinks/
Description: Creates Taxonomies and changes url structure for displaying results
Version: 0.2.1
Author: Rakesh Tembhurne
Author URI: http://rakesh.tembhurne.com
License: GPL2
*/
/*  Copyright 2010  Rakesh Tembhurne  (email : rakesh@tembhurne.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.
*/

add_filter('rewrite_rules_array','tsp_createRewriteRules');
add_filter('wp_loaded','flushRules');
add_filter('post_link', 'tsp_write_link_addresses', 10, 3);
add_filter('post_type_link', 'tsp_write_link_addresses', 10, 3);

// Remember to flush_rules() when adding rules
function flushRules(){
	global $wp_rewrite;
   	$wp_rewrite->flush_rules();
}

function tsp_createRewriteRules($rewrite) {
	global $wp_rewrite;
	
	// loop through custom taxonomies
		// create tokens from each custom taxonomy
	$args = array(
		'public'   => true,
		'_builtin' => false 
	);
	$output 			= 'names'; // or objects
	$operator 			= 'and'; // 'and' or 'or'
	$custom_taxonomies 	= get_taxonomies($args, $output, $operator); 
	if ($custom_taxonomies) {
		foreach ($custom_taxonomies as $tax_name ) {
			$tax_token = '%'.$tax_name.'%';
			$wp_rewrite->add_rewrite_tag($tax_token, '(.+)', $tax_name.'=');
		}
	}
	
	// read current permalink structure and set the same structre
	$keywords_rewrite = $wp_rewrite->generate_rewrite_rules($wp_rewrite->root.$wp_rewrite->permalink_structure);
	return ( $rewrite + $keywords_rewrite );
}

function tsp_write_link_addresses($permalink, $post_id, $leavename)
{
	global $blog_id,$wpdb;
	global $wp_rewrite;
	// this is user's permalink structure set in options
	$permastruct = $wp_rewrite->permalink_structure;
	
	$args = array(
		'public'   => true,
		'_builtin' => false 
	);
	$output 			= 'names'; // or objects
	$operator 			= 'and'; // 'and' or 'or'
	$custom_taxonomies 	= get_taxonomies($args, $output, $operator);
	
	if ($custom_taxonomies) {
		foreach ($custom_taxonomies as $tax_name ) { 
			$tax_token = '%'.$tax_name.'%';
			global $post;
			
			if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/') && isset($post)){
			$tax_terms = get_the_terms($post->ID, $tax_name );
			}
			//var_dump($tax_terms);
			if ( !empty($tax_terms) )
			{
				foreach($tax_terms as $a_term)
				{
					$permalink = str_replace($tax_token, $a_term->slug, $permalink);
					break;
				}
			} else {$permalink = str_replace($tax_token, 'no-'.$tax_name, $permalink); }
		}
	}

	return $permalink;
}