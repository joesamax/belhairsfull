<?php 

/**
 * White Label WordPress Login Final Class
 *
 * @link       http://www.ozanwp.com
 * @since      1.0.0
 *
 * @package    WHITELABEL_WP_LOGIN
 * @author     Ozan Canakli <ozan@ozanwp.com>
 */

final class WHITELABEL_WP_LOGIN {

	/**
	 * Register the enqueue scripts
	 *
	 * @since    1.0.0
	 */
	static public function white_label_wplogin_enqueue_scripts()
	{	
		// Enqueue Styles & Scripts
	    wp_enqueue_style( 'white-label-admin-style', WHITELABEL_WP_LOGIN_URL . 'assets/css/style.css', array(), WHITELABEL_WP_LOGIN_VER );
	    wp_enqueue_script( 'white-label-admin-js', WHITELABEL_WP_LOGIN_URL . 'assets/js/script.js', array('jquery'), WHITELABEL_WP_LOGIN_VER, true );
	    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,700&amp;subset=latin-ext', array(), null, 'all' );

	    // Localization
	    $translation_array = array(
	    	'accountloginText'  => __( 'Account Login', 'wtlbl-wp-login' ),
	    	'lostpasswordText'  => __( 'Reset Password', 'wtlbl-wp-login' ),
	    	'registerText'      => __( 'Create Your Account', 'wtlbl-wp-login' ),
	    );
	    wp_localize_script( 'white-label-admin-js', 'object_name', $translation_array );
	}

	static public function load_plugin_textdomain()
    {

		load_plugin_textdomain(
			'wtlbl-wp-login',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}