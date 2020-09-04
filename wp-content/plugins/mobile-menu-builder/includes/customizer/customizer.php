<?php
/**
 *  Run on plugin install
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mobile_Menu_Builder_Customizer Class
 */
class Mobile_Menu_Builder_Customizer {

	/**
	 * This plugin's instance.
	 *
	 * @var Mobile_Menu_Builder_Customizer
	 */
	private static $instance;
	private $transient_name = 'mobile_menu_builder_cache';

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Mobile_Menu_Builder_Customizer();
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
	 * Constructor
	 */
	public function __construct() {
		$this->_version = MOBILE_MENU_BUILDER_VERSION;
		$this->_slug    = 'mobile_menu_builder';
		$this->_dir     = MOBILE_MENU_BUILDER_PLUGIN_DIR;
		$this->_url     = MOBILE_MENU_BUILDER_PLUGIN_URL;

		if( !class_exists( 'O2_Customizer_Range_Slider_Control' ) ){
			require_once $this->_dir  . 'includes/customizer/controls/range-slider/range-slider-control.php';
		}

		add_action( 'customize_register', array( $this, 'customize_register' ), 11 );
		add_action( 'customize_save_after', array( $this, 'clear_cache' ) );
		add_action( 'after_switch_theme', array( $this, 'clear_cache' ) );
	}

	function customize_register( $wp_customize ){

		//Main Login Styler Panel
		$wp_customize->add_panel(
			'mobile_menu_builder_panel', array(
				'title'       => esc_html__( 'Mobile Menu Builder', 'mobile-menu-builder' ),
				'capability'  => 'edit_theme_options',
				'description' => esc_html__( 'Customizer your mobile menu easily.', 'mobile-menu-builder' ),
				'priority'    => 150,
			)
		);

		if( !class_exists( 'TM_Customize_Iconpicker_Control' ) ){
			require_once $this->_dir . 'includes/customizer/controls/icon-picker/icon-picker-control.php';
		}
		if( !class_exists( 'Mobile_Menu_Builder_Heading_Control' ) ){
			require_once $this->_dir . 'includes/customizer/controls/heading/heading.php';
		}
		if( !class_exists( 'O2_Customizer_Radio_Images_Control' ) ){
			require_once $this->_dir  . 'includes/customizer/controls/radio-images/radio-images-control.php';
		}
		if( !class_exists( 'O2_Customizer_Toggle_Control' ) ){
			require_once $this->_dir  . 'includes/customizer/controls/toggle/toggle-control.php';
		}

		$fonts = array(
			'default'             => esc_html__( 'Default', 'mobile-menu-builder' ),
			'Abril Fatface'       => 'Abril Fatface',
			'Arvo'       		  => 'Arvo',
			'Alegreya'       	  => 'Alegreya',
			'Lato'                => 'Lato',
			'Lora'                => 'Lora',
			'Karla'               => 'Karla',
			'Hind'                => 'Hind',
			'Josefin Sans'        => 'Josefin Sans',
			'Montserrat'          => 'Montserrat',
			'Open Sans'           => 'Open Sans',
			'Open Sans Condensed' => 'Open Sans Condensed',
			'Oswald'              => 'Oswald',
			'Overpass'            => 'Overpass',
			'Poppins'             => 'Poppins',
			'Quicksand'           => 'Quicksand',
			'PT Sans'             => 'PT Sans',
			'PT Sans Narrow'      => 'PT Sans Narrow',
			'Roboto'              => 'Roboto',
			'Fira Sans Condensed' => 'Fira Sans',
			'Frank Ruhl Libre' 	  => 'Frank Ruhl Libre',
			'Nunito'              => 'Nunito',
			'Merriweather'        => 'Merriweather',
			'Rubik'               => 'Rubik',
			'Krub'                => 'Krub',
			'Playfair Display'    => 'Playfair Display',
			'Spectral'            => 'Spectral',
			'Fjalla One'          => 'Fjalla One',
			'Ubuntu'          	  => 'Ubuntu',
			'Asap'          	  => 'Asap',
			'Archivo Narrow'      => 'Archivo Narrow',
			'Encode Sans Condensed' => 'Encode Sans Condensed',
		);

		$fonts = apply_filters( 'mobile_menu_builder_fonts', $fonts );

		require_once $this->_dir . 'includes/customizer/sections/menu-container.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-link-1.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-link-2.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-link-3.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-link-4.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-templates.php';
		require_once $this->_dir . 'includes/customizer/sections/menu-popup.php';
		require_once $this->_dir . 'includes/customizer/sections/popup-widgets.php';

	}

	function clear_cache(){
		delete_transient( $this->transient_name );
	}

}

Mobile_Menu_Builder_Customizer::register();
