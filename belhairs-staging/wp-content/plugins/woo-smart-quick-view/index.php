<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'activate_plugin' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$old_slug = 'woo-smart-quick-view/index.php';
$new_slug = 'woo-smart-quick-view/wpc-smart-quick-view.php';

if ( ! is_plugin_active( $new_slug ) ) {
	// activate new slug
	activate_plugin( $new_slug );
	// deactivate old slug
	deactivate_plugins( $old_slug );
}