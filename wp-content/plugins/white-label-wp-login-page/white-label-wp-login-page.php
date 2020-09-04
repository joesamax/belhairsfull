<?php

/**
 * Plugin Name:       WP Admin White Label WordPress Login Page
 * Plugin URI:        http://wordpress.org/plugins/white-label-wp-login-page/
 * Description:       Change the default style of WordPress WP Admin login with a unique white-label style.
 * Version:           1.0.4
 * Author:            Ozan Canakli
 * Author URI:        http://www.ozanwp.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wtlbl-wp-login
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Defines
define( 'WHITELABEL_WP_LOGIN_VER', '1.0.4' );
define( 'WHITELABEL_WP_LOGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WHITELABEL_WP_LOGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

// Classes
require_once WHITELABEL_WP_LOGIN_DIR . '/includes/class-white-label-wp-login-page.php';

// Actions
add_action( 'login_enqueue_scripts', 'WHITELABEL_WP_LOGIN::white_label_wplogin_enqueue_scripts', 10 );
add_action( 'plugins_loaded',        'WHITELABEL_WP_LOGIN::load_plugin_textdomain' );