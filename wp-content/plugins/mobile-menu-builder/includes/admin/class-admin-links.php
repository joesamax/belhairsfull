<?php
/**
 *  Register Widgets
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mobile_Menu_Builder_Plugin_Links Class
 */
class Mobile_Menu_Builder_Plugin_Links {

	/**
	 * The base URL path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_url;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->_url = add_query_arg(
			array(
				'autofocus[section]' => 'mobile_menu_builder--container',
				'url' 				=> esc_url( home_url() ) ,
			),
			admin_url( 'customize.php' )
		);

		add_action( 'admin_menu', array( $this, 'plugin_setting_links' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( MOBILE_MENU_BUILDER_PLUGIN_DIR . 'plugin.php' ), array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Add links to the settings page to the plugin.
	 *
	 * @param       array|array $actions The plugin.
	 * @return      array
	 */
	public function plugin_action_links( $actions ) {

		// Add the Settings link.
		$settings = array( 'settings' => sprintf( '<a href="%s">%s</a>', $this->_url, esc_html__( 'Go to Builder', 'mobile-menu-builder' ) ) );

		return array_merge(
			$settings,
			$actions
		);
	}

	public function plugin_setting_links( $actions ) {
		global $submenu;

	    $submenu['themes.php'][] = array( esc_html__( 'Mobile Menu Builder', 'mobile-menu-builder' ) , 'manage_options', $this->_url );
	}

}

return new Mobile_Menu_Builder_Plugin_Links();
