<?php
/**
 * Load @@pkg.title block assets.
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @link      @@pkg.author_uri
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main @@pkg.title Class
 *
 * @since 1.0.0
 */
class Mobile_Menu_Builder_Customizer_Assets {


	/**
	 * This plugin's instance.
	 *
	 * @var Mobile_Menu_Builder_Customizer_Assets
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Mobile_Menu_Builder_Customizer_Assets();
		}
	}

	/**
	 * The base directory path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_dir;

	/**
	 * The base URL path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_url;

	/**
	 * The Plugin version.
	 *
	 * @var string $_version
	 */
	private $_version;

	/**
	 * The Plugin version.
	 *
	 * @var string $_slug
	 */
	private $_slug;

	/**
	 * The Constructor.
	 */
	private function __construct() {
		$this->_version = MOBILE_MENU_BUILDER_VERSION;
		$this->_slug    = 'mobile_menu_builder';
		$this->_dir     = MOBILE_MENU_BUILDER_PLUGIN_DIR;
		$this->_url     = MOBILE_MENU_BUILDER_PLUGIN_URL;

		add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ) );
	}

	/**
	 * Add actions to enqueue assets to customizer.
	 *
	 * @access public
	 */
	public function customize_preview_init() {
		wp_enqueue_style( 'mobile-menu-builder-preview', $this->_url . 'assets/css/customizer-preview.css', false );
		wp_enqueue_script( 'mobile-menu-builder-customizer-preview', $this->_url . 'assets/js/customizer-preview.js',  array( 'jquery', 'customize-preview' ), false, true );
	}

	public function customize_controls_print_scripts(){
		wp_enqueue_style( 'mobile-menu-builder-customizer', $this->_url . 'assets/css/customizer.css', false );
		wp_enqueue_script( 'mobile-menu-builder-customizer-js', $this->_url . 'assets/js/customizer.js',  array( 'jquery', 'customize-preview'  ), false, true );
	}
}

Mobile_Menu_Builder_Customizer_Assets::register();
