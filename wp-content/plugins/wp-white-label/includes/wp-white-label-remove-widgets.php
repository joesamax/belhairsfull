<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Disable Default Dashboard Widgets
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);
function disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	// Removes all dashboard widgets.
	$wp_white_label_section_remove_dashboard_widgets0 = get_option( 'wp_white_label_section_remove_dashboard_widgets0' );
	if ( $wp_white_label_section_remove_dashboard_widgets0 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets0 ) ) {
		// Left side metaboxes.
		unset($wp_meta_boxes['dashboard']['normal']['core']);
		// Right side metaboxes.
		unset($wp_meta_boxes['dashboard']['side']['core']);
	}
	// Activity
	$wp_white_label_section_remove_dashboard_widgets1 = get_option( 'wp_white_label_section_remove_dashboard_widgets1' );
	if ( $wp_white_label_section_remove_dashboard_widgets1 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets1 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	}
	//  Right Now
	$wp_white_label_section_remove_dashboard_widgets2 = get_option( 'wp_white_label_section_remove_dashboard_widgets2' );
	if ( $wp_white_label_section_remove_dashboard_widgets2 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets2 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	}
	// Recent Comments
	$wp_white_label_section_remove_dashboard_widgets3 = get_option( 'wp_white_label_section_remove_dashboard_widgets3' );
	if ( $wp_white_label_section_remove_dashboard_widgets3 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets3 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	}
	// Incoming Links
	$wp_white_label_section_remove_dashboard_widgets4 = get_option( 'wp_white_label_section_remove_dashboard_widgets4' );
	if ( $wp_white_label_section_remove_dashboard_widgets4 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets4 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	}
	// Plugins
	$wp_white_label_section_remove_dashboard_widgets5 = get_option( 'wp_white_label_section_remove_dashboard_widgets5' );
	if ( $wp_white_label_section_remove_dashboard_widgets5 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets5 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	}
	// WordPress.com Blog
	$wp_white_label_section_remove_dashboard_widgets6 = get_option( 'wp_white_label_section_remove_dashboard_widgets6' );
	if ( $wp_white_label_section_remove_dashboard_widgets6 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets6 ) ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	}
	// Other WordPress News
	$wp_white_label_section_remove_dashboard_widgets7 = get_option( 'wp_white_label_section_remove_dashboard_widgets7' );
	if ( $wp_white_label_section_remove_dashboard_widgets7 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets7 ) ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
	// Quick Press widget
	$wp_white_label_section_remove_dashboard_widgets8 = get_option( 'wp_white_label_section_remove_dashboard_widgets8' );
	if ( $wp_white_label_section_remove_dashboard_widgets8 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets8 ) ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	}
	// Recent Drafts
	$wp_white_label_section_remove_dashboard_widgets9 = get_option( 'wp_white_label_section_remove_dashboard_widgets9' );
	if ( $wp_white_label_section_remove_dashboard_widgets9 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets9 ) ) {
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	}
	// Multi Language Plugin
	$wp_white_label_section_remove_dashboard_widgets10 = get_option( 'wp_white_label_section_remove_dashboard_widgets10' );
	if ( $wp_white_label_section_remove_dashboard_widgets10 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets10 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['icl_dashboard_widget']);
	}
	// elementor
	$wp_white_label_section_remove_dashboard_widgets11 = get_option( 'wp_white_label_section_remove_dashboard_widgets11' );
	if ( $wp_white_label_section_remove_dashboard_widgets11 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets11 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['e-dashboard-overview']);
	}
	// bbpress
	$wp_white_label_section_remove_dashboard_widgets12 = get_option( 'wp_white_label_section_remove_dashboard_widgets12' );
	if ( $wp_white_label_section_remove_dashboard_widgets12 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets12 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
	}
	// yoast seo
	$wp_white_label_section_remove_dashboard_widgets13 = get_option( 'wp_white_label_section_remove_dashboard_widgets13' );
	if ( $wp_white_label_section_remove_dashboard_widgets13 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets13 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview']);
	}
	
	// gravity forms
	$wp_white_label_section_remove_dashboard_widgets14 = get_option( 'wp_white_label_section_remove_dashboard_widgets14' );
	if ( $wp_white_label_section_remove_dashboard_widgets14 && in_array( 'on', $wp_white_label_section_remove_dashboard_widgets14 ) ) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
	}
}