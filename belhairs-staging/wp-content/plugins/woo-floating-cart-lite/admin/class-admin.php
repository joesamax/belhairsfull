<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    XT_Woo_Floating_Cart
 * @subpackage XT_Woo_Floating_Cart/admin
 * @author     XplodedThemes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class XT_Woo_Floating_Cart_Admin {

	/**
	 * Core class reference.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      XT_Woo_Floating_Cart    core    Core Class
	 */
	private $core;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param XT_Woo_Floating_Cart $core Plugin core class.
	 *
	 * @since    1.0.0
	 */
	public function __construct( &$core ) {

		$this->core = $core;

		$this->core->plugin_loader()->add_filter( $this->core->plugin_prefix( 'customizer_panels' ), $this, 'customizer_panels', 1, 1 );
		$this->core->plugin_loader()->add_filter( $this->core->plugin_prefix( 'customizer_sections' ), $this, 'customizer_sections', 1, 1 );
		$this->core->plugin_loader()->add_filter( $this->core->plugin_prefix( 'customizer_fields' ), $this, 'customizer_fields', 1, 2 );

		$this->core->plugin_loader()->add_action( 'admin_notices', $this, 'woocommerce_settings', 1 );
	}

	public function customizer_panels( $panels ) {

		$panels[] = array(
			'title'    => $this->core->plugin_menu_name(),
			'icon'     => $this->core->plugin_icon()
		);

		return $panels;
	}

	public function customizer_sections( $sections ) {

		$sections[] = array(
			'id'    => 'general',
			'title' => esc_html__( 'General', 'woo-floating-cart' ),
			'icon'  => 'dashicons-admin-generic'
		);

		$sections[] = array(
			'id'    => 'visibility',
			'title' => esc_html__( 'Visibility', 'woo-floating-cart' ),
			'icon'  => 'dashicons-visibility'
		);

		$sections[] = array(
			'id'    => 'typography',
			'title' => esc_html__( 'Typography', 'woo-floating-cart' ),
			'icon'  => 'dashicons-editor-bold'
		);

		$sections[] = array(
			'id'    => 'trigger',
			'title' => esc_html__( 'Cart Trigger', 'woo-floating-cart' ),
			'icon'  => 'dashicons-external'
		);

		$sections[] = array(
			'id'    => 'header',
			'title' => esc_html__( 'Cart Header', 'woo-floating-cart' ),
			'icon'  => 'dashicons-arrow-up-alt2'
		);

		$sections[] = array(
			'id'    => 'body',
			'title' => esc_html__( 'Cart Body', 'woo-floating-cart' ),
			'icon'  => 'dashicons-feedback'
		);

		$sections[] = array(
			'id'    => 'footer',
			'title' => esc_html__( 'Cart Footer', 'woo-floating-cart' ),
			'icon'  => 'dashicons-arrow-down-alt2'
		);

		$sections[] = array(
			'id'    => 'extras',
			'title' => esc_html__( 'Cart Extras', 'woo-floating-cart' ),
			'icon'  => 'dashicons-plus'
		);

		$sections[] = array(
			'id'    => 'menu-item',
			'title' => esc_html__( 'Cart Menu Item', 'woo-floating-cart' ),
			'icon'  => 'dashicons-cart'
		);

        $sections[] = array(
            'id'    => 'api',
            'title' => esc_html__( 'JS API', 'woo-floating-cart' ),
            'icon'  => 'dashicons-editor-code'
        );

		return $sections;
	}

	public function customizer_fields( $fields, $customizer ) {

		require $this->core->plugin_path('admin/customizer/fields', 'general.php');
		require $this->core->plugin_path('admin/customizer/fields', 'visibility.php');
		require $this->core->plugin_path('admin/customizer/fields', 'typography.php');
		require $this->core->plugin_path('admin/customizer/fields', 'trigger.php');
		require $this->core->plugin_path('admin/customizer/fields', 'header.php');
		require $this->core->plugin_path('admin/customizer/fields', 'body.php');
		require $this->core->plugin_path('admin/customizer/fields', 'footer.php');
		require $this->core->plugin_path('admin/customizer/fields', 'extras.php');
		require $this->core->plugin_path('admin/customizer/fields', 'menu-item.php');
		require $this->core->plugin_path('admin/customizer/fields', 'api.php');

		return $fields;
	}

	public function woocommerce_settings() {

		$wc_ajax_cart_enabled = get_option( 'woocommerce_enable_ajax_add_to_cart' ) === 'yes';
		if ( ! $wc_ajax_cart_enabled ) {
			update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );

			$class   = 'notice notice-error';
			$message = sprintf(
				__( '<strong>%1$s</strong> plugin requires that WooCommerce "enable ajax add to cart" option to be enabled', 'woo-floating-cart' ),
				$this->core->plugin_name()
			);
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}

		$wc_cart_redirect_after_add = get_option( 'woocommerce_cart_redirect_after_add' ) === 'yes';
		if ( $wc_cart_redirect_after_add ) {
			update_option( 'woocommerce_cart_redirect_after_add', 'no' );

			$class   = 'notice notice-error';
			$message = sprintf(
				__( '<strong>%1$s</strong> plugin requires that WooCommerce "cart redirect after to cart" option to be enabled', 'woo-floating-cart' ),
				$this->core->plugin_name()
			);
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}
	}

}
