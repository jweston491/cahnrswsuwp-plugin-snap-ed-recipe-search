<?php
/*
Plugin Name: CAHNRSWSUWP Snap-Ed Recipe Search
Version: 0.0.1
Description: A shortcode that generates a search and filter feature for Recipes. Requires "recipe" category to exist in Posts.
Author: washingtonstateuniversity, jweston491
Author URI: https://web.wsu.edu/
Plugin URI: https://github.com/washingtonstateuniversity/cahnrswsuwp-plugin-snap-ed-recipe-search
Text Domain: cahnrswsuwp-plugin-snap-ed-recipe-search
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// This plugin uses namespaces and requires PHP 5.3 or greater.
if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
	add_action( 'admin_notices', create_function( '', // phpcs:ignore WordPress.PHP.RestrictedPHPFunctions.create_function_create_function
	"echo '<div class=\"error\"><p>" . __( 'CAHNRSWSUWP Snap-Ed Recipe Search requires PHP 5.3 to function properly. Please upgrade PHP or deactivate the plugin.', 'cahnrswsuwp-plugin-snap-ed-recipe-search' ) . "</p></div>';" ) );
	return;
} else {
	include_once __DIR__ . '/cahnrswsuwp-plugin-snap-ed-recipe-search.php';
}
