<?php
/**
 *  Run on plugin install
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mobile_Menu_Builder_Activation Class
 */
class Mobile_Menu_Builder_Activation {

	/**
	 * Constructor
	 */
	public function __construct() {
		register_activation_hook( MOBILE_MENU_BUILDER_PLUGIN_FILE, array( $this, 'register_defaults' ) );
	}

	/*
	 * Register plugin defaults
	 */
	function register_defaults(){
		if( is_admin() ){
			if( !get_option( 'MOBILE_MENU_BUILDER_INSTALLED' ) ){
				add_option( 'MOBILE_MENU_BUILDER_INSTALLED', date( 'Y-m-d h:i:s' ) );

				$options  = get_option( 'mobile_menu_builder_customizer' );

				if( !$options ){
					$options = array(
						'enableMenu'		=>	false,
						'enableAnimation'	=>	true,
						'menuCount'			=>	'4',
						'position'			=>	'bottom',
						'hideIcon'			=>	false,
						'hideLabel'			=>	false,
						'containerbg'		=>	'#3498db',
						'containerbr'		=>	'#43494b',
						'iconColor'			=>	'#FFFFFF',
						'textColor'			=>	'#FFFFFF',
						'containerHover'	=>	'',
						'menuHoverBg'		=>	'#2073ab',
						'iconHoverColor'	=>	'#FFFFFF',
						'textHoverColor'	=>	'#FFFFFF',
						'font'				=>	'Hind',
						'iconSize'			=>	'26px',
						'labelSize'			=>	'10px',
						'cached'			=>	true,
						'enablePopup'		=>	true,
						'popupTextAlign'	=>	'left',
						'popupBg'			=>	'#1d2127',
						'popupHeadingColor'	=>	'#abb4be',
						'popupTextColor'	=>	'#FFFFFF',
						'menu-1-icon'		=>	'ion-ios-home',
						'menu-1-label'		=>	__( 'Home', 'mobile-menu-builder' ),
						'menu-1-link'		=>	'',
						'menu-1-popup'		=>	false,
						'menu-2-icon'		=>	'ion-ios-text',
						'menu-2-label'		=>	__( 'Blog', 'mobile-menu-builder' ),
						'menu-2-link'		=>	'',
						'menu-2-popup'		=>	false,
						'menu-3-icon'		=>	'ion-ios-mail',
						'menu-3-label'		=>	__( 'Contact Us', 'mobile-menu-builder' ),
						'menu-3-link'		=>	'',
						'menu-3-popup'		=>	false,
						'menu-4-icon'		=>	'ion-ios-menu',
						'menu-4-label'		=>	__( 'Menu', 'mobile-menu-builder' ),
						'menu-4-link'		=>	'',
						'menu-4-popup'		=>	true,
					);

					update_option( 'mobile_menu_builder_customizer', $options );
				}
			}
		}
	}

}

return new Mobile_Menu_Builder_Activation();
