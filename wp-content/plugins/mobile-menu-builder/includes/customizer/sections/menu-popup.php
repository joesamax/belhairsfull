<?php

$wp_customize->add_section(
	'mobile_menu_builder--popup', array(
		'priority' 	=> 10,
		'title' 	=> __( 'Mobile Menu Popup', 'mobile-menu-builder' ),
		'panel'  	=> 'mobile_menu_builder_panel',
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[enablePopup]', array(
		'default' 			=> false,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[enablePopup]', array(
			'label' 		=> __( 'Enable Popup', 'mobile-menu-builder' ),
			'description' 	=> __( 'Make sure you have popup enabled in order to show it on your website.', 'mobile-menu-builder' ),
			'section' 		=> 'mobile_menu_builder--popup',
			'settings' 		=> 'mobile_menu_builder_customizer[enablePopup]',
			'priority'  	=> 10,
		)
	)
);

$wp_customize->add_setting( 
	'mobile_menu_builder_customizer[popupTextAlign]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'default' 	 		=> '',
		'transport' 		=> 'postMessage',
	) 
);

$wp_customize->add_control( 'mobile_menu_builder_customizer[popupTextAlign]', array(
	'type' 		 => 'select',
	'settings'   => 'mobile_menu_builder_customizer[popupTextAlign]',
	'section' 	 => 'mobile_menu_builder--popup',
	'label' 	 => __( 'Alignment', 'mobile-menu-builder' ),
	'choices' 	 => array(
		''		 	 => esc_html__( 'Default', 'mobile-menu-builder' ),
		'left'		 => esc_html__( 'Left', 'mobile-menu-builder' ),
		'center'	 => esc_html__( 'Center', 'mobile-menu-builder' ),
		'right'	 	 => esc_html__( 'Right', 'mobile-menu-builder' ),
	),
	'priority' 	 => 20,
) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[popupBg]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#1d2127'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[popupBg]',
  array(
    'label' 	 	=> __( 'Background Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select menu background color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[popupBg]',
    'section' 	 	=> 'mobile_menu_builder--popup',
    'priority' 		=> 30,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[popupHeadingColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#abb4be'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[popupHeadingColor]',
  array(
    'label' 	 	=> __( 'Title Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select widget title color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[popupHeadingColor]',
    'section' 	 	=> 'mobile_menu_builder--popup',
    'priority' 		=> 40,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[popupTextColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#FFFFFF'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[popupTextColor]',
  array(
    'label' 	 	=> __( 'Text Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select text and link color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[popupTextColor]',
    'section' 	 	=> 'mobile_menu_builder--popup',
    'priority' 		=> 50,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[popupFont]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[popupFont]',
  array(
    'label' 	 	=> __( 'Fonts & More Styling', 'mobile-menu-builder' ),
    'description' 	=> sprintf( esc_html__( 'Stay tuned for more styling options. %sSign up here%s to get notified. %s', 'mobile-menu-builder' ), '<a href="https://menubuilderwp.com/?utm_source=customizer_popup" target="_blank">', '</a>', '<i class="ion-ios-rocket"></i>' ),
    'settings'   	=> 'mobile_menu_builder_customizer[popupFont]',
    'section' 	 	=> 'mobile_menu_builder--popup',
    'priority' 		=> 60,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[rate-6]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[rate-6]',
  array(
    'description' 	=> sprintf( esc_html__( 'Loving Mobile Menu Builder? Give us %s5-star rating%s to help spread the words. Thank you very much!', 'mobile-menu-builder' ), '<a href="https://wordpress.org/support/plugin/mobile-menu-builder/reviews/?filter=5" target="_blank">', '</a>' ),
    'settings'   	=> 'mobile_menu_builder_customizer[rate-6]',
    'section' 	 	=> 'mobile_menu_builder--popup',
    'priority' 		=> 500,
) ) );


$wp_customize->selective_refresh->add_partial( 'mobile_menu_builder_customizer[enablePopup]', array(
    'selector'            => '.mobile-menu-builder-popup--container',
    'container_inclusive' => true,
    // 'render_callback'     => false,
    'fallback_refresh'    => false, // Prevents refresh loop when document does not contain .mobile-menu-builder-customizer--container selector. This should be fixed in WP 4.7.
) );
?>