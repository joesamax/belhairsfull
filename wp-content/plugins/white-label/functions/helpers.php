<?php
/**
 * General helper functions for White Label.
 *
 * @package white-label
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Reset White Label General Options & White Label Administrators via AJAX.
 *
 * Https://dev.local/wp-admin/admin-ajax.php?action=white_label_reset_wl_admins .
 *
 * @return void
 */
function white_label_reset_wl_admins() {

	// Make sure it's on the admin side and the caller is an administrator.
	if ( is_admin() && current_user_can( 'administrator' ) ) {

		delete_option( 'white_label_general' );

		$url = admin_url( '/options-general.php?page=white-label' );

		wp_safe_redirect( $url );
	}
	exit();
}

add_action( 'wp_ajax_white_label_reset_wl_admins', 'white_label_reset_wl_admins' );
