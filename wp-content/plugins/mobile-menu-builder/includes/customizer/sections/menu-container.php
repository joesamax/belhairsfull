<?php

$wp_customize->add_section(
	'mobile_menu_builder--container', array(
		'priority' => 10,
		'title' => __( 'Mobile Menu Styling', 'mobile-menu-builder' ),
		'panel'  => 'mobile_menu_builder_panel',
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[enableMenu]', array(
		'default' 			=> false,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[enableMenu]', array(
			'label' 		=> __( 'Enable Menu', 'mobile-menu-builder' ),
			'description' 	=> __( 'Make sure you have the menu enabled in order to show it on your website.', 'mobile-menu-builder' ),
			'section' 		=> 'mobile_menu_builder--container',
			'settings' 		=> 'mobile_menu_builder_customizer[enableMenu]',
			'priority'  	=> 10,
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[enableAnimation]', array(
		'default' 			=> false,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[enableAnimation]', array(
			'label' 		=> __( 'On Scroll Animation', 'mobile-menu-builder' ),
			'description' 	=> __( 'Show and hide animation on user scroll to boosts user experience.', 'mobile-menu-builder' ),
			'section' 		=> 'mobile_menu_builder--container',
			'settings' 		=> 'mobile_menu_builder_customizer[enableAnimation]',
			'priority'  	=> 10,
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[menuCount]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'esc_html',
		'default'           => '4'
	)
);

$wp_customize->add_control( new O2_Customizer_Range_Slider_Control( 
	$wp_customize, 'mobile_menu_builder_customizer[menuCount]', array(
		'section'  => 'mobile_menu_builder--container',
		'settings' => 'mobile_menu_builder_customizer[menuCount]',
		'label'    => __( 'Menu Items', 'mobile-menu-builder' ),
		'choices' => array(
			'percent' => false,
		),
		'input_attrs' => array(
			'min'    => 1,
			'max'    => apply_filters( 'mobile-menu-builder/menu_items', 4 ),
			'step'   => 1,
	  	),
	  	'priority'   => 20,
) ) );

$wp_customize->add_setting( 
	'mobile_menu_builder_customizer[position]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'default' 	 		=> 'bottom',
		'transport' 		=> 'postMessage',
	) 
);

$wp_customize->add_control( 'mobile_menu_builder_customizer[position]', array(
	'type' 		 => 'select',
	'settings'   => 'mobile_menu_builder_customizer[position]',
	'section' 	 => 'mobile_menu_builder--container',
	'label' 	 => __( 'Position', 'mobile-menu-builder' ),
	'choices' 	 => array(
			'top' 		=> __( 'Top', 'mobile-menu-builder' ),
			'bottom' 	=> __( 'Bottom', 'mobile-menu-builder' ),
	),
	'priority'   => 30,
) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[hideIcon]', array(
		'default' 			=> false,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[hideIcon]', array(
			'label' 	=> __( 'Hide Menu Icon', 'mobile-menu-builder' ),
			'section' 	=> 'mobile_menu_builder--container',
			'settings' 	=> 'mobile_menu_builder_customizer[hideIcon]',
			'priority'  => 40,
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[hideLabel]', array(
		'default' 			=> false,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[hideLabel]', array(
			'label' 	=> __( 'Hide Menu Label', 'mobile-menu-builder' ),
			'section' 	=> 'mobile_menu_builder--container',
			'settings' 	=> 'mobile_menu_builder_customizer[hideLabel]',
			'priority'  => 50,
		)
	)
);


$wp_customize->add_setting(
	'mobile_menu_builder_customizer[containerbg]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#3498db'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[containerbg]',
  array(
    'label' 	 	=> __( 'Background Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select menu background color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[containerbg]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 60,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[containerbr]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#43494b'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[containerbr]',
  array(
    'label' 	 	=> __( 'Border Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select menu background color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[containerbr]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'  	=> 70,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[iconColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#FFFFFF'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[iconColor]',
  array(
    'label' 	 	=> __( 'Icon Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select menu icons color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[iconColor]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 80,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[textColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => '#FFFFFF'
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[textColor]',
  array(
    'label' 	 	=> __( 'Text Color', 'mobile-menu-builder' ),
    'description' 	=> __( 'Select menu text/label color.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[textColor]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 90,
) ) );


$wp_customize->add_setting(
	'mobile_menu_builder_customizer[containerHover]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[containerHover]',
  array(
    'label' 	 	=> __( 'Current Page & Hover State Styling', 'mobile-menu-builder' ),
    'description' 	=> __( 'The options below will be applied on each menu mouseover and current page. Preview only available when you are on current menu link.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[containerHover]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 100,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[menuHoverBg]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => ''
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[menuHoverBg]',
  array(
    'description' 	=> __( 'Link Background Color', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[menuHoverBg]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 110,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[iconHoverColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => ''
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[iconHoverColor]',
  array(
    'description' 	=> __( 'Icon Color', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[iconHoverColor]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 120,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[textHoverColor]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'default'           => ''
	)
);

$wp_customize->add_control(
  new WP_Customize_Color_Control( $wp_customize, 'mobile_menu_builder_customizer[textHoverColor]',
  array(
    'description' 	=> __( 'Text Color', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[textHoverColor]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 130,
) ) );


$wp_customize->add_setting(
	'mobile_menu_builder_customizer[fontStyling]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[fontStyling]',
  array(
    'label' 	 	=> __( 'Font Styling', 'mobile-menu-builder' ),
    'description' 	=> __( 'This option will let you set custom font and sizes for the menu links.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[fontStyling]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 150,
) ) );

$wp_customize->add_setting( 
	'mobile_menu_builder_customizer[font]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'default' 	 		=> 'default',
		'transport' 		=> 'postMessage',
	) 
);

$wp_customize->add_control( 'mobile_menu_builder_customizer[font]', array(
	'type' 		 => 'select',
	'settings'   => 'mobile_menu_builder_customizer[font]',
	'section' 	 => 'mobile_menu_builder--container',
	'label' 	 => __( 'Font Family', 'mobile-menu-builder' ),
	'choices' 	 => $fonts,
	'priority'   => 160,
) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[iconSize]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'esc_html',
		'default'           => '26px'
	)
);

$wp_customize->add_control( new O2_Customizer_Range_Slider_Control( 
	$wp_customize, 'mobile_menu_builder_customizer[iconSize]', array(
		'section'  => 'mobile_menu_builder--container',
		'settings' => 'mobile_menu_builder_customizer[iconSize]',
		'label'    => __( 'Icon Font Size', 'mobile-menu-builder' ),
		'choices' => array(
			'percent' => false,
		),
		'input_attrs' => array(
			'min'    => 1,
			'max'    => 100,
			'step'   => 1,
	  	),
	  	'priority'   => 170,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[labelSize]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
		'sanitize_callback' => 'esc_html',
		'default'           => '10px',
	)
);

$wp_customize->add_control( new O2_Customizer_Range_Slider_Control( 
	$wp_customize, 'mobile_menu_builder_customizer[labelSize]', array(
		'section'  => 'mobile_menu_builder--container',
		'settings' => 'mobile_menu_builder_customizer[labelSize]',
		'label'    => __( 'Label Font Size', 'mobile-menu-builder' ),
		'choices' => array(
			'percent' => false,
		),
		'input_attrs' => array(
			'min'    => 1,
			'max'    => 100,
			'step'   => 1,
	  	),
	  	'priority'   => 180,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[caching]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[caching]',
  array(
    'label' 	 	=> __( 'Caching Option', 'mobile-menu-builder' ),
    'description' 	=> __( 'Enable or disable menu and pop-up cache output. Using this option, the menu will be cached using transient and will make it load even faster.', 'mobile-menu-builder' ),
    'settings'   	=> 'mobile_menu_builder_customizer[caching]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority'   	=> 190,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[cached]', array(
		'default' 			=> true,
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
	new O2_Customizer_Toggle_Control(
		$wp_customize, 'mobile_menu_builder_customizer[cached]', array(
			'label' 		=> __( 'Enable Output Cache', 'mobile-menu-builder' ),
			'section' 		=> 'mobile_menu_builder--container',
			'settings' 		=> 'mobile_menu_builder_customizer[cached]',
			'priority'  	=> 192,
		)
	)
);

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[containerMore]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[containerMore]',
  array(
    'label' 	 	=> __( 'Plus More..', 'mobile-menu-builder' ),
    'description' 	=> sprintf( esc_html__( 'Stay tuned for more styling options. %sSign up here%s to get notified. %s', 'mobile-menu-builder' ), '<a href="https://menubuilderwp.com/?utm_source=customizer_container" target="_blank">', '</a>', '<i class="ion-ios-rocket"></i>' ),
    'settings'   	=> 'mobile_menu_builder_customizer[containerMore]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority' 		=> 200,
) ) );

$wp_customize->add_setting(
	'mobile_menu_builder_customizer[rate-1]', array(
		'type'      		=> 'option',
		'capability' 		=> 'edit_theme_options',
		'transport' 		=> 'postMessage',
	)
);

$wp_customize->add_control(
  new Mobile_Menu_builder_Heading_Control( $wp_customize, 'mobile_menu_builder_customizer[rate-1]',
  array(
    'description' 	=> sprintf( esc_html__( 'Loving Mobile Menu Builder? Give us %s5-star rating%s to help spread the words. Thank you very much!', 'mobile-menu-builder' ), '<a href="https://wordpress.org/support/plugin/mobile-menu-builder/reviews/?filter=5" target="_blank">', '</a>' ),
    'settings'   	=> 'mobile_menu_builder_customizer[rate-1]',
    'section' 	 	=> 'mobile_menu_builder--container',
    'priority' 		=> 500,
) ) );


$wp_customize->selective_refresh->add_partial( 'mobile_menu_builder_customizer[enableMenu]', array(
    'selector'            => '.mobile-menu-builder-customizer--container',
    'container_inclusive' => true,
    // 'render_callback'     => false,
    'fallback_refresh'    => false, // Prevents refresh loop when document does not contain .mobile-menu-builder-customizer--container selector. This should be fixed in WP 4.7.
) );

?>