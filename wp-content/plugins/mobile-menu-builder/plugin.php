<?php
/**
 * Plugin Name: Mobile Menu Builder
 * Plugin URI: https://wordpress.org/support/plugin/mobile-menu-builder/
 * Description: The easiest way to create your website's perfect mobile menu.
 * Version: 1.0
 * Author: Phpbits Creative Studio
 * Author URI: https://phpbits.net/
 * Text Domain: mobile-menu-builder
 * Domain Path: languages
 *
 * @category Login
 * @author Jeffrey Carandang
 * @version 1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Mobile_Menu_Builder' ) ) :

/**
 * Main Mobile_Menu_Builder Class.
 *
 * @since  1.0
 */
final class Mobile_Menu_Builder {
	/**
	 * @var Mobile_Menu_Builder The one true Mobile_Menu_Builder
	 * @since  1.0
	 */
	private static $instance;

	/**
	 * Main Mobile_Menu_Builder Instance.
	 *
	 * Insures that only one instance of Mobile_Menu_Builder exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since  1.0
	 * @static
	 * @staticvar array $instance
	 * @uses Mobile_Menu_Builder::setup_constants() Setup the constants needed.
	 * @uses Mobile_Menu_Builder::includes() Include the required files.
	 * @uses Mobile_Menu_Builder::load_textdomain() load the language files.
	 * @see Mobile_Menu_Builder()
	 * @return object|Mobile_Menu_Builder The one true Mobile_Menu_Builder
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Mobile_Menu_Builder ) ) {
			self::$instance = new Mobile_Menu_Builder;
			self::$instance->setup_constants();

			// add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			self::$instance->includes();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 4.1
	 * @return void
	 */
	private function setup_constants() {

		// Plugin version.
		if ( ! defined( 'MOBILE_MENU_BUILDER_PLUGIN_NAME' ) ) {
			define( 'MOBILE_MENU_BUILDER_PLUGIN_NAME', 'Mobile Menu Builder' );
		}

		// Plugin version.
		if ( ! defined( 'MOBILE_MENU_BUILDER_VERSION' ) ) {
			define( 'MOBILE_MENU_BUILDER_VERSION', '1.0' );
		}

		// Plugin Folder Path.
		if ( ! defined( 'MOBILE_MENU_BUILDER_PLUGIN_DIR' ) ) {
			define( 'MOBILE_MENU_BUILDER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		}

		// Plugin Folder URL.
		if ( ! defined( 'MOBILE_MENU_BUILDER_PLUGIN_URL' ) ) {
			define( 'MOBILE_MENU_BUILDER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		// Plugin Root File.
		if ( ! defined( 'MOBILE_MENU_BUILDER_PLUGIN_FILE' ) ) {
			define( 'MOBILE_MENU_BUILDER_PLUGIN_FILE', __FILE__ );
		}
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		global $mobile_menu_Builder;

		//make sure selective refresh for widgets are enabled
		add_theme_support( 'customize-selective-refresh-widgets' );

		require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/class-menu-display.php';
		require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/admin/class-widgets.php';

		if( is_admin() ){	
			require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/admin/class-admin-links.php';
			require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/admin/class-plugin-activation.php';
			require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/admin/class-dashboard-welcome.php';
		}

		//load files for customizer use
		// if( is_customize_preview() ){
			require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/customizer/customizer.php';
			require_once MOBILE_MENU_BUILDER_PLUGIN_DIR . 'includes/customizer/class-customizer-assets.php';
		// }
	}

}

endif; // End if class_exists check.


/**
 * The main function for that returns Mobile_Menu_Builder
 *
 * The main function responsible for returning the one true Mobile_Menu_Builder
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $widgetopts = Mobile_Menu_Builder(); ?>
 *
 * @since 1.0
 * @return object|Mobile_Menu_Builder The one true Mobile_Menu_Builder Instance.
 */
if( !function_exists( 'Mobile_Menu_Builder_FN' ) ){
	function Mobile_Menu_Builder_FN() {
		return Mobile_Menu_Builder::instance();
	}
	// Get Plugin Running.
	Mobile_Menu_Builder_FN();
}
?>
