<?php

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[widgetPlaceholder]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[widgetPlaceholder]',
  array(
  	'label' 	 	=> __( 'Mobile Menu Builder Popup', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[widgetPlaceholder]',
    'section' 	 	=> 'sidebar-widgets-mobile-menu-builder-1',
) ) );


$wp_customize->selective_refresh->add_partial( 'mobile_menu_builder_customizer[widgetPlaceholder]', array(
    'selector'            => '.mobile-menu-builder-popup--inner',
    'container_inclusive' => true,
    // 'render_callback'     => false,
    'fallback_refresh'    => false, // Prevents refresh loop when document does not contain .mobile-menu-builder-customizer--container selector. This should be fixed in WP 4.7.
) );
?>