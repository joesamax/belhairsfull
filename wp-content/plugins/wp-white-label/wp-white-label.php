<?php
/**
 * Plugin Name:       WP White Label
 * Plugin URI: 	      https://longvietweb.com/plugins/wp-white-label
 * Description:       WP White Label allows your agency to customise WP branding, admin area, dashboard, and login logo.
 * Tags: 			  WP White Label, White Label, Custom Admin, Custom dashboard, WP branding
 * Author URI: 	      https://longvietweb.com/
 * Author: 		      LongViet
 * Version: 		  1.0.2
 * License: 		  GPLv2 or later
 * Text Domain:       wp-white-label
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'WP_WHITE_LABEL_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_WHITE_LABEL_URL', plugin_dir_url( __FILE__ ) );

// Load plugin textdomain
add_action( 'plugins_loaded', 'wp_white_label_load_textdomain' );
function wp_white_label_load_textdomain() {
	load_plugin_textdomain( 'wp-white-label', false, basename( WP_WHITE_LABEL_DIR ) . '/languages/' );
}

// Start White label
add_action( 'init', 'wp_white_label_run_admin' );
function wp_white_label_run_admin() {
	require plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-setting-page.php';
	require plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-hook.php';
	require plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-functions.php';
	require plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-hidden-plugin.php';
}

// Start WL settings if enabled and exists
add_action( 'init', 'wp_white_label_run_functions' );
function wp_white_label_run_functions() {

	$wp_white_label_section_start = get_option( 'wp_white_label_section_start' );
	// Start WL settings if enabled and exists
	if ( $wp_white_label_section_start && in_array( 'on', $wp_white_label_section_start ) ) {
		include plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-custom-start.php';
	}
	$wp_white_label_section_enable_remove_dashboard_widgets = get_option( 'wp_white_label_section_enable_remove_dashboard_widgets' );
	// Start WL settings if enabled and exists
	if ( $wp_white_label_section_enable_remove_dashboard_widgets && in_array( 'on', $wp_white_label_section_enable_remove_dashboard_widgets ) ) {
		include plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-remove-widgets.php';
	}
}

// Custom Dashboard if turned on
$wp_white_label_custom_dashboard = get_option( 'wp_white_label_custom_dashboard_switch' );

if ( $wp_white_label_custom_dashboard && in_array( 'on', $wp_white_label_custom_dashboard ) ) {
	include plugin_dir_path( __FILE__ ) . 'includes/wp-white-label-dashboard-page.php';
}

register_uninstall_hook( __FILE__, 'wp_white_label_delete_all_options' );
// Delete all options on uninstall
function wp_white_label_delete_all_options() {

	foreach ( wp_load_alloptions() as $option => $value ) {
		if ( strpos( $option, 'wp_white_label_' ) === 0 ) {
			delete_option( $option );
		}
	}
}