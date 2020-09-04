<?php
/**
 * Plugin Name: OoohBoi Steroids for Elementor
 * Description: An awesome set of tools, options and settings that expand Elementor defaults. Instead of creating new Elementor Widgets, these act like an upgrade of existing options or the self-standing panels.
 * Version:     1.3.3
 * Author:      OoohBoi
 * Author URI:  https://www.youtube.com/c/OoohBoi
 * Text Domain: ooohboi-steroids
 * Domain Path: /lang
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main OoohBoi Steroids Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class OoohBoi_Steroids {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.3.3';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	*/
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var OoohBoi_Steroids The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return OoohBoi_Steroids An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	
	public function __construct() {	
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'ooohboi-steroids', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by 'plugins_loaded' action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version			
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// load common stuff functions
		require plugin_dir_path( __FILE__ ) . 'inc/common-functions.php';

		// Editor Styles
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'ooohboi_register_styles_editor' ] );

		// Register/Enqueue Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'ooohboi_register_scripts_front' ] );
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'ooohboi_register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', function() { 
			wp_enqueue_style( 'ooohboi-steroids-styles' ); 
			wp_enqueue_script( 'ooohboi-steroids' ); 
		} );

		// editor preview styles
		add_action( 'elementor/preview/enqueue_styles', function() {
			wp_enqueue_style(
				'ooohboi-steroids-preview',
				plugins_url( 'assets/css/preview.css', __FILE__ ),
				[ 'editor-preview' ],
				self::VERSION
			);
		} ); 

		// Include extension classes
		self::ooohboi_take_steroids();

		// Init Extensions
		OoohBoi_Overlay_Underlay::init(); // OoohBoi Overlay Underlay
		OoohBoi_Overlaiz::init(); // OoohBoi Overlaiz
		OoohBoi_Harakiri::init(); // OoohBoi Harakiri
		OoohBoi_Paginini::init(); // OoohBoi Paginini
		OoohBoi_Breaking_Bad::init(); // OoohBoi Breaking Bad
		OoohBoi_Glider::init(); // OoohBoi Glider Slider
		OoohBoi_PhotoGiraffe::init(); // OoohBoi PhotoGiraffe 
		OoohBoi_Teleporter::init(); // OoohBoi Teleporter
		OoohBoi_SearchCop::init(); // OoohBoi Search Cop

	}

	/*
		* Init styles for Elementor Editor
		*
		* Include css files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_styles_editor() {
		
		wp_enqueue_style( 'ooohboi-steroids-styles-editor', plugins_url( 'assets/css/editor.css', __FILE__ ), [ 'elementor-editor' ], self::VERSION );

	}

	/*
		* Init styles
		*
		* Include css files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_styles() {
		
		wp_register_style( 'ooohboi-steroids-styles', plugins_url( 'assets/css/main.css', __FILE__ ), NULL, self::VERSION );

	}

	/*
		* Init Scripts
		*
		* Include js files and register them
		*
		* @since 1.0.0				
		*
		* @access public
	*/
	public function ooohboi_register_scripts_front() {
		
		wp_register_script( 'ooohboi-steroids', plugins_url( 'assets/js/ooohboi-steroids-min.js', __FILE__ ), [ 'jquery' ], self::VERSION, true );

	}

	/**
	 *
	 * Include extensions
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public static function ooohboi_take_steroids() {

		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-overlay-underlay.php'; // OoohBoi Overlay Underlay
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-overlaiz.php'; // OoohBoi Overlaiz
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-harakiri.php'; // OoohBoi Harakiri
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-paginini.php'; // OoohBoi Paginini
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-breaking-bad.php'; // OoohBoi Breaking Bad
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-glider.php'; // OoohBoi Glider Slider
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-photogiraffe.php'; // OoohBoi PhotoGiraffe
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-teleporter.php'; // OoohBoi Teleporter
		include_once plugin_dir_path( __FILE__ ) . 'controls/ooohboi-searchcop.php'; // OoohBoi Search Cop

	}

}

OoohBoi_Steroids::instance();