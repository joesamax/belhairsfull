<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * white_label_Settings_Api Settings API wrapper class.
 *
 * @author Morgan H
 * @version 1.0.0
 */
class white_label_Settings_Api { // phpcs:ignore
	/**
	 * settings sections array.
	 *
	 * @var array
	 */
	protected $settings_sections = array();
	/**
	 * Settings fields array.
	 *
	 * @var array
	 */
	protected $settings_fields = array();

	/**
	 * Plugin config as array.
	 *
	 * @var array
	 */
	protected $plugin;

	/**
	 * Store args temp.
	 *
	 * @var array
	 */
	protected $nested_multicheck_args;

	/**
	 * Construct.
	 */
	public function __construct( $plugin ) {
		if ( ! is_admin() ) {
			return;
		}
		$this->plugin = $plugin;
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}
	/**
	 * Enqueue scripts and styles.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery' );
	}
	/**
	 * Set settings sections.
	 *
	 * @param array $sections setting sections array.
	 */
	public function set_sections( $sections ) {
		$this->settings_sections = $sections;
		return $this;
	}
	/**
	 * Set settings sidebar.
	 *
	 * @param array $sections setting sections array.
	 */
	public function set_sidebar( $sidebar ) {
		$this->settings_sidebar = $sidebar;
		return $this;
	}
	/**
	 * Add a single section.
	 *
	 * @param array $section.
	 */
	public function add_section( $section ) {
		$this->settings_sections[] = $section;
		return $this;
	}
	/**
	 * Set settings fields.
	 *
	 * @param array $fields settings fields array.
	 */
	public function set_fields( $fields ) {
		$this->settings_fields = $fields;
		return $this;
	}

	public function add_field( $section, $field ) {
		$defaults = array(
			'name'  => '',
			'label' => '',
			'desc'  => '',
			'type'  => 'text',
		);

		$arg = wp_parse_args( $field, $defaults );

		$this->settings_fields[ $section ][] = $arg;

		return $this;
	}
	/**
	 * Initialize and registers the settings sections and fileds to WordPress.
	 *
	 * Usually this should be called at `admin_init` hook.
	 *
	 * This function gets the initiated settings sections and fields. Then
	 * registers them to WordPress and ready for use.
	 */
	public function admin_init() {

		// register settings sections.
		foreach ( $this->settings_sections as $section ) {
			if ( false == get_option( $section['id'] ) ) {
				add_option( $section['id'] );
			}
			if ( isset( $section['desc'] ) && ! empty( $section['desc'] ) ) {
				$section['desc'] = '<div class="inside white_label-tab-description">' . $section['desc'] . '</div>';
				$callback        = function() use ( $section ) {
					echo $section['desc'];
				};
			} elseif ( isset( $section['callback'] ) ) {
				$callback = $section['callback'];
			} else {
				$callback = null;
			}
			add_settings_section( $section['id'], $section['title'], $callback, $section['id'] );
		}
		// register settings fields.
		foreach ( $this->settings_fields as $section => $field ) {
			foreach ( $field as $option ) {
				$name     = $option['name'];
				$type     = isset( $option['type'] ) ? $option['type'] : 'text';
				$label    = isset( $option['label'] ) ? $option['label'] : '';
				$callback = isset( $option['callback'] ) ? $option['callback'] : array( $this, 'callback_' . $type );
				$args     = array(
					'id'                => $name,
					'class'             => isset( $option['class'] ) ? $option['class'] : $name,
					'label_for'         => "{$section}[{$name}]",
					'desc'              => isset( $option['desc'] ) ? $option['desc'] : '',
					'name'              => $label,
					'section'           => $section,
					'size'              => isset( $option['size'] ) ? $option['size'] : null,
					'options'           => isset( $option['options'] ) ? $option['options'] : '',
					'std'               => isset( $option['default'] ) ? $option['default'] : '',
					'sanitize_callback' => isset( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : '',
					'type'              => $type,
					'placeholder'       => isset( $option['placeholder'] ) ? $option['placeholder'] : '',
					'min'               => isset( $option['min'] ) ? $option['min'] : '',
					'max'               => isset( $option['max'] ) ? $option['max'] : '',
					'step'              => isset( $option['step'] ) ? $option['step'] : '',
				);
				add_settings_field( "{$section}[{$name}]", $label, $callback, $section, $section, $args );
			}
		}
		// creates our settings in the options table.
		foreach ( $this->settings_sections as $section ) {
			register_setting( $section['id'], $section['id'], array( $this, 'sanitize_options' ) );
		}
	}
	/**
	 * Get field description for display.
	 *
	 * @param array $args settings field args.
	 */
	public function get_field_description( $args ) {
		if ( ! empty( $args['desc'] ) ) {
			$desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
		} else {
			$desc = '';
		}

		return $desc;
	}
	/**
	 * Displays a  2 colspan subheading field for a settings field.
	 *
	 *   @param array $args settings field args.
	 */
	public function callback_subheading( $args ) {
		$html  = '<h3 class="white_label-subheading">' . $args['name'] . '</h3>';
		$html .= $this->get_field_description( $args );
		$html .= '<hr />';
		echo $html;
	}
	/**
	 * Displays a text field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_text( $args ) {
		$value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$type        = isset( $args['type'] ) ? $args['type'] : 'text';
		$placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
		$html        = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder );
		$html       .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays a url field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_url( $args ) {
		$this->callback_text( $args );
	}
	/**
	 * Displays a number field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_number( $args ) {
		$value       = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$type        = isset( $args['type'] ) ? $args['type'] : 'number';
		$placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
		$min         = ( $args['min'] == '' ) ? '' : ' min="' . $args['min'] . '"';
		$max         = ( $args['max'] == '' ) ? '' : ' max="' . $args['max'] . '"';
		$step        = ( $args['step'] == '' ) ? '' : ' step="' . $args['step'] . '"';
		$html        = sprintf( '<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step );
		$html       .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays a checkbox for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_checkbox( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$html  = '<fieldset>';
		$html .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $args['section'], $args['id'] );
		$html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="off" />', $args['section'], $args['id'] );
		$html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />', $args['section'], $args['id'], checked( $value, 'on', false ) );
		$html .= sprintf( '%1$s</label>', $args['desc'] );
		$html .= '</fieldset>';
		echo $html;
	}
	/**
	 * Displays a multicheckbox for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_multicheck( $args ) {
		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$html  = '<fieldset>';
		$html .= sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
		foreach ( $args['options'] as $key => $label ) {
			$checked = isset( $value[ $key ] ) ? $value[ $key ] : '0';
			$html   .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
			$html   .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $checked, $key, false ) );
			$html   .= sprintf( '%1$s</label><br>', $label );
		}
		$html .= $this->get_field_description( $args );
		$html .= '</fieldset>';
		echo $html;
	}
	/**
	 * Displays a nested multicheckbox for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_nested_multicheck( $args ) {
		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$html  = '<fieldset>';
		$html .= sprintf( '<input type="hidden" name="%1$s[%2$s][parents]" value="" />', $args['section'], $args['id'] );
		$html .= sprintf( '<input type="hidden" name="%1$s[%2$s][children]" value="" />', $args['section'], $args['id'] );

		foreach ( $args['options'] as $key => $label ) {

			$checked = isset( $value['parents'][ $key ] ) ? $value['parents'][ $key ] : '0';

			$name     = isset( $label['name'] ) ? $label['name'] : '';
			$submenus = isset( $label['submenus'] ) ? $label['submenus'] : ' ';

			$html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s][%4$s]">', $args['section'], $args['id'], 'parents', $key );
			$html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s][%4$s]" name="%1$s[%2$s][%3$s][%4$s]" value="%4$s" %5$s />', $args['section'], $args['id'], 'parents', $key, checked( $checked, $key, false ) );
			$html .= sprintf( '%1$s</label><br>', $name );

			$parent = $key;
			// Submenus.
			if ( $submenus && is_array( $submenus ) ) {
				foreach ( $submenus as $slug => $name ) {

					$checked = isset( $value['children'][ $parent ] ) && isset( $value['children'][ $parent ][ $slug ] ) ? $value['children'][ $parent ][ $slug ] : '0';

					$html .= sprintf( '<label class="wpuf-nested-checkbox" for="wpuf-%1$s[%2$s][%3$s][%4$s][%5$s]">', $args['section'], $args['id'], 'children', $parent, $slug );
					$html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s][%4$s][%4$s]" name="%1$s[%2$s][%3$s][%4$s][%5$s]" value="%5$s" %6$s />', $args['section'], $args['id'], 'children', $parent, $slug, checked( $checked, $slug, false ) );
					$html .= sprintf( '%1$s</label><br>', $name );

				}
			}
		}
		$html .= $this->get_field_description( $args );
		$html .= '</fieldset>';
		echo $html;
	}

	public function callback_admin_bar_multicheck( $args ) {
		$this->nested_multicheck_args = $args;
		echo '<fieldset>';
		echo sprintf( '<input type="hidden" name="%1$s[%2$s]" value="" />', $args['section'], $args['id'] );
		echo $this->admin_bar_multicheck_inner( $args['options'] );
		echo $this->get_field_description( $args );
		echo '</fieldset>';
	}


	public function admin_bar_multicheck_inner( $menu = false, $depth = 0 ) {

		$args = $this->nested_multicheck_args;
		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$value = empty( $value ) ? array() : $value;

		$out = '';

		if ( empty( $menu ) ) {
			return $out;
		}

		if ( ! is_array( $menu ) && $depth > 0 ) {
			return $out;
		}

		$ul_class_wrapper = 'class ="white_label-depth-' . $depth . '"';

		$out .= '<ul ' . $ul_class_wrapper . '>';

		foreach ( $menu as $menu_props ) {

			if ( empty( $menu_props ) || ! is_object( $menu_props ) ) {
				continue;
			}

			$menu_key = $menu_props->id;

			$admin_bar_menu_setting = $this->admin_bar_multicheck_inner();

			$disabled = '';

			if ( in_array( $menu_key, array( 'top-secondary', 'my-account', 'user-actions', 'logout' ) ) ) {
				$disabled = ' disabled';
			}

			$sub_html = ( isset( $menu_props->sub ) ) ? $this->admin_bar_multicheck_inner( $menu_props->sub, ( $depth + 1 ) ) : '';

			$checked = isset( $value[ $menu_key ] ) ? $value[ $menu_key ] : '0';

			$out .= sprintf(
				'
					<li>
					<input class="wpuf-true-nested-multicheck" id="%6$s[%7$s][%1$s]" %5$s name="%6$s[%7$s][%1$s]" value="%1$s" type="checkbox" %2$s/>
						<label for="%6$s[%7$s][%1$s]">%3$s</label> 
                       %4$s
                    </li>
                ',
				$menu_key,
				checked( $checked, $menu_key, false ),
				$this->get_menu_title( $menu_props ),
				$sub_html,
				$disabled,
				$args['section'],
				$args['id']
			);
		}

		$out .= '</ul>';
		return $out;
	}

	public function get_menu_title( $menu ) {
		if ( ! isset( $menu->title ) ) {
			return '';
		}

		$title = trim( wp_strip_all_tags( $menu->title ) );

		return ( ( ! $title || empty( $title ) ) ? '-' : $title ) . ' <small>(' . $menu->id . ')</small>';
	}

	/**
	 * Displays a radio button for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_radio( $args ) {
		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$html  = '<fieldset>';
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf( '<label for="wpuf-%1$s[%2$s][%3$s]">', $args['section'], $args['id'], $key );
			$html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />', $args['section'], $args['id'], $key, checked( $value, $key, false ) );
			$html .= sprintf( '%1$s</label><br>', $label );
		}
		$html .= $this->get_field_description( $args );
		$html .= '</fieldset>';
		echo $html;
	}
	/**
	 * Displays a selectbox for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_select( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$html  = sprintf( '<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $args['section'], $args['id'] );
		foreach ( $args['options'] as $key => $label ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
		}
		$html .= sprintf( '</select>' );
		$html .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays a textarea for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_textarea( $args ) {
		$value       = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$value       = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size        = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$placeholder = empty( $args['placeholder'] ) ? '' : ' placeholder="' . $args['placeholder'] . '"';
		$html        = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>', $size, $args['section'], $args['id'], $placeholder, $value );
		$html       .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays the html for a settings field
	 *
	 * @param array $args settings field args
	 * @return string
	 */
	public function callback_html( $args ) {
		echo $this->get_field_description( $args );
	}
	/**
	 * Displays a rich text textarea for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_wysiwyg( $args ) {
		$value = $this->get_option( $args['id'], $args['section'], $args['std'] );
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '500px';
		echo '<div style="max-width: ' . $size . ';">';
		$editor_settings = array(
			'teeny'         => true,
			'textarea_name' => $args['section'] . '[' . $args['id'] . ']',
			'textarea_rows' => 10,
		);
		if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
			$editor_settings = array_merge( $editor_settings, $args['options'] );
		}
		wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );
		echo '</div>';
		echo $this->get_field_description( $args );
	}
	/**
	 * Displays a file upload field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_file( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$id    = $args['section'] . '[' . $args['id'] . ']';
		$label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );
		$html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
		$html .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays a password field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_password( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s"/>', $size, $args['section'], $args['id'], $value );
		$html .= $this->get_field_description( $args );
		echo $html;
	}
	/**
	 * Displays a color picker field for a settings field.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_color( $args ) {
		$value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) );
		$size  = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';
		$html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s[%3$s]" name="%2$s[%3$s]" value="%4$s" data-default-color="%5$s" />', $size, $args['section'], $args['id'], $value, $args['std'] );
		$html .= $this->get_field_description( $args );
		echo $html;
	}

	/**
	 * Displays a select box for creating the pages select box.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_pages( $args ) {
		$dropdown_args = array(
			'selected' => esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'] ) ),
			'name'     => $args['section'] . '[' . $args['id'] . ']',
			'id'       => $args['section'] . '[' . $args['id'] . ']',
			'echo'     => 0,
		);
		$html          = wp_dropdown_pages( $dropdown_args );
		echo $html;
	}

	/**
	 * Displays a licence field for EDD.
	 *
	 * @param array $args settings field args.
	 */
	public function callback_edd_license( $args ) {
		do_action( 'white_label_callback_edd_license', $args );
	}

	/**
	 * Sanitize callback for Settings API.
	 *
	 * @return mixed
	 */
	public function sanitize_options( $options ) {
		if ( ! $options ) {
			return $options;
		}
		foreach ( $options as $option_slug => $option_value ) {
			$sanitize_callback = $this->get_sanitize_callback( $option_slug );
			// If callback is set, call it
			if ( $sanitize_callback ) {
				$options[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
				continue;
			}
		}
		return $options;
	}
	/**
	 * Get sanitization callback for given option slug.
	 *
	 * @param string $slug option slug.
	 *
	 * @return mixed string or bool false.
	 */
	public function get_sanitize_callback( $slug = '' ) {
		if ( empty( $slug ) ) {
			return false;
		}
		// Iterate over registered fields and see if we can find proper callback.
		foreach ( $this->settings_fields as $section => $options ) {
			foreach ( $options as $option ) {
				if ( $option['name'] != $slug ) {
					continue;
				}
				// Return the callback name
				return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
			}
		}
		return false;
	}
	/**
	 * Get the value of a settings field
	 *
	 * @param string $option  settings field name
	 * @param string $section the section name this field belongs to
	 * @param string $default default text if it's not found
	 * @return string
	 */
	public function get_option( $option, $section, $default = '' ) {
		$options = get_option( $section );
		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}
		return $default;
	}
	/**
	 * Show navigations as tab.
	 *
	 * Shows all the settings section labels as tab.
	 */
	public function show_navigation() {
		$html  = '<h2 class="nav-tab-wrapper white_label-nav-wrapper">';
		$count = count( $this->settings_sections );
		// don't show the navigation if only one section exists.
		if ( $count === 1 ) {
			return;
		}
		foreach ( $this->settings_sections as $tab ) {
			$html .= sprintf( '<a href="#%1$s" class="white_label-tab nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
		}
		$html .= '</h2>';
		echo $html;
	}
	/**
	 * Show the section settings forms.
	 *
	 * This function displays every sections in a different form.
	 */
	public function show_forms() {

		echo '<div class="white_label-metabox-wrapper white_label-form-wrapper">';

		foreach ( $this->settings_sections as $form ) {

			echo '<div id="' . $form['id'] . '" class="group" style="display: none;">';

			if ( isset( $form['custom_tab'] ) && $form['custom_tab'] === true ) {
				// Allow custom tabs.
				do_action( 'white_label_settings_tab_' . $form['id'], $form );
			} else {
				// Standard form.
				echo '<form method="post" action="options.php">';
				// Display something at the top of the form.
				do_action( 'white_label_form_top_' . $form['id'], $form );
				// Display the settings.
				settings_fields( $form['id'] );
				do_settings_sections( $form['id'] );
				// Display something at the bottom of the form.
				do_action( 'white_label_form_bottom_' . $form['id'], $form );

				if ( isset( $this->settings_fields[ $form['id'] ] ) ) {
					echo '<div class="white_label-submit-button">';
					submit_button( __( 'Save Settings', 'white-label' ), 'primary', 'submit', true, array( 'id' => $form['id'] ) );
					echo '</div>';
				}
					echo '</form>';
					echo '</div>';

			}
		}

		echo '</div>'; // end wrap.

		$this->script();
	}


	/**
	 * Display sidebar and each box.
	 */
	public function show_sidebar() {

		if ( ! $this->settings_sidebar ) {
			return;
		}

		echo '<div class="white_label-sidebar">';

		do_action( 'white_label' . '_above_settings_sidebars' );

		foreach ( $this->settings_sidebar as $sidebar ) {

			echo '<div class="white_label-metabox">';
			echo '<h3>' . $sidebar['title'] . '</h3>';
			echo '<p>' . $sidebar['content'] . '</p>';
			echo '</div> ';
		}

		echo '</div> ';

		do_action( 'white_label' . '_below_settings_sidebars' );

	}
	/**
	 * Tabbable JavaScript codes & Initiate Color Picker
	 *
	 * This code uses localstorage for displaying active tabs
	 */
	// phpcs:disable
	public function script() {
		?> <script>
jQuery(document).ready(function($) {
	//make the subheading single row
	$('.white_label-subheading').each(function(index, element) {
		var $element = $(element);
		var $element_parent = $element.parent('td');
		$element_parent.attr('colspan', 2);
		$element_parent.prev('th').remove();
	});
	$('tr.subheading').each(function() {
		$(this).nextUntil('tr.subheading').andSelf().wrapAll('<div class="white_label-subsection"></div>');
	});
	//Initiate Color Picker
	$('.wp-color-picker-field').wpColorPicker();
	// Switches option sections
	$('.group').hide();
	//if url has section id as hash then set it as active or override the current local storage value
	$('.group:first').fadeIn(100);
	$('.group .collapsed').each(function() {
		$(this).find('input:checked').parent().parent().parent().nextAll().each(function() {
			if ($(this).hasClass('last')) {
				$(this).removeClass('hidden');
				return false;
			}
			$(this).filter('.hidden').removeClass('hidden');
		});
	});
	$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
	$('.nav-tab-wrapper a').click(function(evt) {
		$('.nav-tab-wrapper a').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active').blur();
		var clicked_group = $(this).attr('href');
		$('.group').hide();
		$(clicked_group).fadeIn(100);
		evt.preventDefault();
	});
	$('.wpsa-browse').on('click', function(event) {
		event.preventDefault();
		var self = $(this);
		// Create the media frame.
		var file_frame = wp.media.frames.file_frame = wp.media({
			title: self.data('uploader_title'),
			button: {
				text: self.data('uploader_button_text'),
			},
			multiple: false
		});
		file_frame.on('select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
			self.prev('.wpsa-url').val(attachment.url).change();
		});
		// Finally, open the modal
		file_frame.open();
	});
});
</script>
<style>
.white_label-tab {
	color: #101010;
	border: none;
    background-color: #ffffff6e;
	box-shadow: 4px 8px 7px -7px rgba(0,0,0,0.19);
}

.white_label-nav-wrapper.nav-tab-wrapper {
	border:none !important;
}

.white_label-subsection {
	-webkit-box-shadow: 10px 10px 4px -8px rgba(0,0,0,0.19);
-moz-box-shadow: 10px 10px 4px -8px rgba(0,0,0,0.19);
box-shadow: 10px 10px 4px -8px rgba(0,0,0,0.19);
}

.nav-tab-active.white_label-tab {
	color: #000000;
	background-color: #ffffff !important;
	border-bottom: 2px solid #000;
}
a.button.white_label-check-license {
    padding: 5px 15px;
	height: 38px;
}
.form-table div.white_label-subsection th {
	width: 200px !important;
	display: inline-block;
	margin-left: 20px;
}
ul.white_label-depth-1 {
    padding-left: 20px;
}
ul.white_label-depth-2 {
    padding-left: 20px;
}
ul.white_label-depth-3 {
    padding-left: 20px;
}
ul.white_label-depth-4 {
    padding-left: 20px;
}

.white_label-metabox a {
    font-weight: 700;
    color: #0052cc;
}
.form-table div.white_label-subsection td {
	width: 100%;
}

#wpbody-content .white_label-metabox-wrapper {
	padding-top: 10px;
	width: 70%;
	float: left;
}

.white_label-subsection {
	background: white;
	margin-bottom: 25px;
	padding: 10px 20px 30px 20px;
}

.white_label-sidebar {
	width: 30%;
	float: right;
	margin-top: 62px;
	clear: both;
}

.white_label-metabox {
	background: white;
	padding: 10px 40px;
	margin-left: 25px;
	margin-bottom: 20px;
}

.white_label-submit-button {
	clear: both;
}

.white_label-tab-description {
	margin-bottom: 20px;
}
.form-table td fieldset label.wpuf-nested-checkbox {
    padding-left: 25px;
}

@media screen and (max-width: 782px) {
	#wpbody-content .white_label-metabox-wrapper {
		padding-top: 10px;
		width: 100%;
		float: none;
	}
	.white_label-sidebar {
		width: 100%;
		float: none;
		margin-top: 40px;
		clear: both;
	}
	.white_label-metabox {
		margin-left: 0px;
	}
}
</style> <?php
}

}
