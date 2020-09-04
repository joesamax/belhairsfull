<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'wp_white_label_setup_sections' ) ):
function wp_white_label_setup_sections() {
	add_settings_section( 'wp_white_label_section_start', __( 'WP White Label', 'wp-white-label' ), array(), 'wp_white_label_callback' );
	add_settings_section( 'wp_white_label_section_email', __( 'Email Branding', 'wp-white-label' ), array(), 'wp_white_label_callback' );
	add_settings_section( 'wp_white_label_section_menu', __( 'Custom Menu', 'wp-white-label' ), array(), 'wp_white_label_callback' );
	add_settings_section( 'wp_white_label_section_branding', __( 'Login Page', 'wp-white-label' ), array(), 'wp_white_label_callback' );
	add_settings_section( 'wp_white_label_section_admin', __( 'Admin Area', 'wp-white-label' ), array(), 'wp_white_label_callback' );
	add_settings_section( 'wp_white_label_section_dashboard_widget', __( 'Add Dashboard Widgets', 'wp-white-label' ), array(), 'wp_white_label_callback_dashboard_widget' );
	add_settings_section( 'wp_white_label_section_custom_dashboard', __( 'Custom Dashboard Page', 'wp-white-label' ), array(), 'wp_white_label_callback_custom_dashboard' );
	add_settings_section( 'wp_white_label_section_enable_remove_dashboard_widgets', __( 'Default Dashboard Widgets', 'wp-white-label' ), array(), 'wp_white_label_callback_remove_dashboard_widgets' );
	add_settings_section( 'wp_white_label_section_remove_dashboard_widgets', __( 'Removes Dashboard Widgets', 'wp-white-label' ), array(), 'wp_white_label_callback_remove_dashboard_widgets' );
	add_settings_section( 'wp_white_label_section_script_styles', __( 'Scripts / Styles', 'wp-white-label' ), array(), 'wp_white_label_callback_script_styles' );
	add_settings_section( 'wp_white_label_section_hidden', __( 'Hidden WP White Label', 'wp-white-label' ), array(), 'wp_white_label_callback_hidden' );
}
endif;

if ( ! function_exists( 'wp_white_label_setup_fields' ) ):
function wp_white_label_setup_fields() {
	$fields = array(
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_start',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_start',
			'options' => array(
				'on' => __( 'Enable WP White Label', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_email_enable',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_email',
			'desc'    => __( 'Change the sender address and name in WordPress outgoing emails.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Email Branding', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Forms Name', 'wp-white-label' ),
			'id'      => 'wp_white_label_forms_name',
			'type'    => 'textfield',
			'section' => 'wp_white_label_section_email',
		),
		array(
			'label'   => __( 'Forms Email', 'wp-white-label' ),
			'id'      => 'wp_white_label_forms_email',
			'type'    => 'textfield',
			'section' => 'wp_white_label_section_email',
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_menu_enable',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_menu',
			'desc'    => __( 'This function is available on the White Label Pro version.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Custom Admin Menu', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Menu Background Color', 'wp-white-label' ),
			'id'      => 'wp_white_label_menu_background_color',
			'class'   => 'wp-white-label-menu-background-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_menu',
			'placeholder' => '#1C1E1F',
		),
		array(
			'label'   => __( 'Menu Color', 'wp-white-label' ),
			'id'      => 'wp_white_label_menu_color',
			'class'   => 'wp-white-label-menu-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_menu',
			'placeholder' => '#fff',
		),
		array(
			'label'   => __( 'SubMenu Background Color', 'wp-white-label' ),
			'id'      => 'wp_white_label_submenu_background_color',
			'class'   => 'wp-white-label-submenu-background-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_menu',
			'placeholder' => '#32373c',
		),
		array(
			'label'   => __( 'SubMenu Color', 'wp-white-label' ),
			'id'      => 'wp_white_label_submenu_color',
			'class'   => 'wp-white-label-submenu-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_menu',
			'placeholder' => '#fff',
		),
		array(
			'label'   => __( 'Menu Border Color', 'wp-white-label' ),
			'id'      => 'wp_white_label_menuborder_color',
			'class'   => 'wp-white-label-menuborder-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_menu',
			'placeholder' => 'transparent',
		),
		array(
			'label'   => __( 'Company name', 'wp-white-label' ),
			'id'      => 'wp_white_label_company_name',
			'type'    => 'textfield',
			'section' => 'wp_white_label_section_branding',
		),
		array(
			'label'   => __( 'Your Website', 'wp-white-label' ),
			'id'      => 'wp_white_label_company_url',
			'type'    => 'url',
			'section' => 'wp_white_label_section_branding',
		),
		array(
			'label'   => __( 'Logo', 'wp-white-label' ),
			'id'      => 'wp_white_label_custom_logo',
			'type'    => 'media',
			'section' => 'wp_white_label_section_branding',
		),
		array(
			'label'   => __( 'Background image', 'wp-white-label' ),
			'id'      => 'wp_white_label_login_background_image',
			'type'    => 'media',
			'section' => 'wp_white_label_section_branding',
		),
		array(
			'label'   => __( 'or background color', 'wp-white-label' ),
			'id'      => 'wp_white_label_login_background',
			'class'   => 'wp-white-label-color',
			'type'    => 'text',
			'section' => 'wp_white_label_section_branding',
			'desc'    => __( 'choose a color or image do background', 'wp-white-label' ),
			'placeholder' => '#fff',
		),
		array(
			'label'   => __( 'Remove Admin bar', 'wp-white-label' ),
			'id'      => 'wp_white_label_remove_adminbar',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_admin',
			'desc'    => __( 'Remove WordPress Admin Bar on the front of the site.</br>Except administrator', 'wp-white-label' ),
			'options' => array(
				'on' => '',
			),
		),
		array(
			'label'   => __( 'Remove WordPress Logo in Admin bar', 'wp-white-label' ),
			'id'      => 'wp_white_label_admin_area',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_admin',
			'options' => array(
				'on' => '',
			),
		),
		array(
			'label'   => __( 'or use your own logo', 'wp-white-label' ),
			'id'      => 'wp_white_label_admin_bar_logo',
			'type'    => 'media',
			'section' => 'wp_white_label_section_admin',
		),
		array(
			'label'       => __( 'Replace Howdy in Admin Bar', 'wp-white-label' ),
			'id'          => 'wp_white_label_admin_howdy',
			'type'        => 'textfield',
			'placeholder' => 'Howdy',
			'section'     => 'wp_white_label_section_admin',
		),
		array(
			'label'       => __( 'Admin footer credit', 'wp-white-label' ),
			'id'          => 'wp_white_label_admin_footer',
			'type'        => 'textfield',
			'placeholder' => 'Thank you for creating with WordPress.',
			'section'     => 'wp_white_label_section_admin',
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_dashboard_widget_switch',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_dashboard_widget',
			'options' => array(
				'on' => __( 'Enable Add Dashboard Widgets', 'wp-white-label' ),
			),
		),
		array(
			'label'       => __( 'Widget title', 'wp-white-label' ),
			'id'          => 'wp_white_label_dashboard_widget_title',
			'type'        => 'textfield',
			'desc'        => '',
			'placeholder' => 'Support',
			'section'     => 'wp_white_label_section_dashboard_widget',
		),
		array(
			'label'   => __( 'Widget content', 'wp-white-label' ),
			'id'      => 'wp_white_label_dashboard_widget_content',
			'type'    => 'wysiwyg',
			'section' => 'wp_white_label_section_dashboard_widget',
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_custom_dashboard_switch',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_custom_dashboard',
			'desc'    => __( 'This will delete all widgets, It replaces the default dashboard page.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Custom Dashboard Page', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Dashboard Page Title', 'wp-white-label' ),
			'id'      => 'wp_white_label_custom_dashboard_title',
			'type'    => 'textfield',
			'section' => 'wp_white_label_section_custom_dashboard',
		),
		array(
			'label'   => __( 'Dashboard Content', 'wp-white-label' ),
			'id'      => 'wp_white_label_custom_dashboard',
			'type'    => 'wysiwyg',
			'section' => 'wp_white_label_section_custom_dashboard',
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_enable_remove_dashboard_widgets',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_enable_remove_dashboard_widgets',
			'desc'    => __( 'To remove Dashboard Widgets below this feature needs to be enabled.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Removes Default Dashboard Widgets', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets0',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'desc'    => __( 'Select this function, there is no need to select the function below.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Remove All Dashboard Widgets', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets1',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Activity', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets2',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Right Now', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets3',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Recent Comments', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets4',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Incoming Links', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets5',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Plugins', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets6',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets WordPress.com Blog', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets7',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Other WordPress News', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets8',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Quick Press widget', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets9',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Recent Drafts', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets10',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Multi Language Plugin', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets11',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Elementor', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets12',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets BBpress', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets13',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Yoast Seo', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_remove_dashboard_widgets14',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_remove_dashboard_widgets',
			'options' => array(
				'on' => __( 'Remove Dashboard Widgets Gravity Forms', 'wp-white-label' ),
			),
		),
		array(
			'label'       => __( 'Scripts / Styles 1', 'wp-white-label' ),
			'id'          => 'wp_white_label_script_styles',
			'placeholder' => '<script>add script here</script>',
			'type'        => 'textarea',
			'section'     => 'wp_white_label_section_script_styles',
			'desc'        => __( 'Add a Styles, or run any JS script.', 'wp-white-label' ),
		),
		array(
			'label'       => __( 'Scripts / Styles 2', 'wp-white-label' ),
			'id'          => 'wp_white_label_script_style',
			'placeholder' => '<script>add script here</script>',
			'type'        => 'textarea',
			'section'     => 'wp_white_label_section_script_styles',
			'desc'        => __( 'Add a Styles, or run any JS script.', 'wp-white-label' ),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_disable_editor',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_hidden',
			'desc'    => __( 'Prevent editing themes and editing plugins.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Disable Theme and Plugin Editors', 'wp-white-label' ),
			),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_hidden_menu',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_hidden',
			'desc'    => __( 'Hide the WP White Label admin menus for all users.</br>Not hidden from the website creator "Super Admin".</br>This function is available on the White Label Pro version.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Hidden The White Label Menu', 'wp-white-label' ),
			),
		),
		array(
			'label'       => __( 'Hidde Specific User ', 'wp-white-label' ),
			'id'          => 'wp_white_label_hidden_menu_specific_user',
			'placeholder' => '1',
			'type'        => 'textfield',
			'section'     => 'wp_white_label_section_hidden',
			'desc'        => __( 'Add One ID The user is not hidden.', 'wp-white-label' ),
		),
		array(
			'label'   => __( 'Enable / Disable', 'wp-white-label' ),
			'id'      => 'wp_white_label_section_hidden_plugin',
			'type'    => 'checkbox',
			'section' => 'wp_white_label_section_hidden',
			'desc'    => __( 'Hidden the White Label on the Plugins page "wp-admin/plugins.php". Prevent users from activating or deactivating.</br>Not hidden from the website creator "Super Admin".</br>This function is available on the White Label Pro version.', 'wp-white-label' ),
			'options' => array(
				'on' => __( 'Enable Hidden The White Label on the Plugins page', 'wp-white-label' ),
			),
		),
		array(
			'label'       => __( 'Hidde Specific User ', 'wp-white-label' ),
			'id'          => 'wp_white_label_hidden_plugin_specific_user',
			'placeholder' => '1',
			'type'        => 'textfield',
			'section'     => 'wp_white_label_section_hidden',
			'desc'        => __( 'Add One ID The user is not hidden.', 'wp-white-label' ),
		),
	);
	foreach ( $fields as $field ) {
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback', $field['section'], $field );
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback_dashboard_widget', $field['section'], $field );
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback_custom_dashboard', $field['section'], $field );
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback_remove_dashboard_widgets', $field['section'], $field );
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback_script_styles', $field['section'], $field );
		add_settings_field( $field['id'], $field['label'], 'wp_white_label_field_callback', 'wp_white_label_callback_hidden', $field['section'], $field );
		register_setting( 'wp_white_label_callback', $field['id'] );
	}
}
endif;

if ( ! function_exists( 'wp_white_label_field_callback' ) ):
function wp_white_label_field_callback( $field ) {
	$placeholdercheck = '';
	$class            = '';

	if ( isset( $field['class'] ) ) {
		$class = $field['class'];
	}

	if ( isset( $field['placeholder'] ) ) {
		$placeholdercheck = $field['placeholder'];
	}

	$value = get_option( $field['id'] ) ;

	switch ( $field['type'] ) {
		case 'textarea':
			printf(
				'<textarea name="%1$s" id="%1$s" placeholder="%2$s" class="%3$s" rows="5" cols="50">%4$s</textarea></br>',
				$field['id'],
				$placeholdercheck,
				$class,
				$value
			);
			break;
		case 'select':
		case 'multiselect':
			if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
				$attr    = '';
				$options = '';
				foreach ( $field['options'] as $key => $label ) {
						  // Fix for PHP notice array_search
					if ( is_array( $value ) || is_object( $value ) ) {
						$selectcheck = selected( true, in_array( $key, $value ), false );
					} else {
						$selectcheck = selected( $value, $key, false );
					}

					$options .= sprintf(
						'<option value="%s" %s>%s</option>',
						$key,
						$selectcheck,
						$label
					);
				}
				if ( $field['type'] === 'multiselect' ) {
						  $attr = ' multiple="multiple" ';
				}
				printf(
					'<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>',
					$field['id'],
					$attr,
					$options
				);
			}
			break;
		case 'radio':
		case 'checkbox':
			if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
				$options_markup = '';
				$iterator       = 0;

				foreach ( $field['options'] as $key => $label ) {
					// checks if the value is in array. it was throwing a error because second value of array search was a string, when no checkbox was selected.
					if ( is_array( $value ) || is_object( $value ) ) {
						$checkboxcheck = checked( true, in_array( $key, $value ), false );
					} else {
						$checkboxcheck = checked( $value, $key, false );
					}
					++$iterator;
					$options_markup .= sprintf(
						'<label for="%1$s_%6$s"><div class="wp-white-label-switch"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /><span class="toogle"></span></div> %5$s</label><br/>',
						$field['id'],
						$field['type'],
						$key,
						$checkboxcheck,
						$label,
						$iterator
					);
				}
				printf(
					'<fieldset>%s</fieldset>',
					$options_markup
				);
			}
			break;
		case 'media':
			printf(
				'<input style="width: 400px;" id="%s" name="%s" type="text" value="%s"> <input class="button button-primary wpwl-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
				$field['id'],
				$field['id'],
				$value,
				$field['id'],
				$field['id']
			);
			break;

		case 'wysiwyg':
			wp_editor( $value, $field['id'] );
			break;
		default:
		
		// fixes html escape
		if (is_string( $value)) {
		$value = htmlspecialchars($value);
		}
			printf(
				'<input name="%1$s" id="%1$s" type="%2$s" value="%3$s" placeholder="%4$s" class="%5$s"  />',
				$field['id'],
				$field['type'],
				$value,
				$placeholdercheck,
				$class
			);
	}
	if ( isset( $field['desc'] ) ) {
		printf( '<p class="description">%s </p>', $field['desc'] );
	}
}
endif;

if ( ! function_exists( 'wp_white_label_enqueue_scripts' ) ):
function wp_white_label_enqueue_scripts() {
	if ( isset( $_GET['page'] ) && $_GET['page'] == 'wp-white-label' || 'wpwl-hidden-plugin' || 'wp-white-label-pro' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wp-white-label-js', plugins_url( '../assets/js/wp-white-label.js', __FILE__ ) );
		wp_enqueue_style( 'wp-white-label-css', plugins_url( '../assets/css/wp-white-label.css', __FILE__ ) );
	} else {
		wp_dequeue_script( 'wp-white-label-css' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_dequeue_script( 'wp-color-picker' );
		wp_dequeue_script( 'wp-white-label-js' );
	}
}
endif;