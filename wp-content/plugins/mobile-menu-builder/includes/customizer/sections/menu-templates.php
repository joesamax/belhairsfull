<?php

$wp_customize->add_section(
	'mobile_menu_builder--templates', array(
		'priority'    => 10,
		'title'       => __( 'Predesigned Themes', 'mobile-menu-builder' ),
		'panel'       => 'mobile_menu_builder_panel',
	)
);


$wp_customize->add_setting(
    'mobile_menu_builder_customizer[themes]', array(
        'default'           => 'default',
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
    )
);



$wp_customize->add_control( new O2_Customizer_Radio_Images_Control(
    $wp_customize, 'mobile_menu_builder_customizer[themes]', array(
        'label'         => __( 'Select Themes', 'mobile-menu-builder' ),
        'section'       => 'mobile_menu_builder--templates',
        'settings'      => 'mobile_menu_builder_customizer[themes]',
        'choices'       => array(
            'default'       => MOBILE_MENU_BUILDER_PLUGIN_URL . 'assets/images/themes/default.jpg',
        ),
    )
) );

$wp_customize->add_setting(
    'mobile_menu_builder_customizer[moreThemes]', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'transport'         => 'postMessage',
    )
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[moreThemes]',
  array(
    'label'         => __( 'More Templates Coming Soon', 'mobile-menu-builder' ),
    'description'   => sprintf( esc_html__( 'Stay tuned for more mobile menu themes. %sSign up here%s to get notified. %s', 'mobile-menu-builder' ), '<a href="https://menubuilderwp.com/?utm_source=customizer_themes" target="_blank">', '</a>', '<i class="ion-ios-rocket"></i>' ),
    'settings'      => 'mobile_menu_builder_customizer[moreThemes]',
    'section'       => 'mobile_menu_builder--templates',
) ) );


$wp_customize->selective_refresh->add_partial( 'mobile_menu_builder_customizer[themes]', array(
    'selector'            => '.mobile-menu-builder-customizer--templates',
    'container_inclusive' => true,
    'fallback_refresh'    => false, // Prevents refresh loop when document does not contain .cta-wrap selector. This should be fixed in WP 4.7.
) );

?>