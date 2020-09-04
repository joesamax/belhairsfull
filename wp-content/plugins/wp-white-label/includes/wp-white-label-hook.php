<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_menu', 'wp_white_label_create_settings' );
add_action( 'admin_init', 'wp_white_label_setup_sections', 1 );
add_action( 'admin_init', 'wp_white_label_setup_fields' );
add_action( 'admin_enqueue_scripts', 'wp_white_label_enqueue_scripts' );