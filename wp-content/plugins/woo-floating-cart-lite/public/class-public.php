<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    XT_Woo_Floating_Cart
 * @subpackage XT_Woo_Floating_Cart/public
 * @author     XplodedThemes
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
class XT_Woo_Floating_Cart_Public
{
    /**
     * Core class reference.
     *
     * @since    1.0.0
     * @access   private
     * @var      XT_Woo_Floating_Cart    $core
     */
    private  $core ;
    /**
     * Var that holds the menu class object.
     *
     * @since    1.0.0
     * @access   public
     * @var      XT_Woo_Floating_Cart_Theme_Fixes  $theme_fixes   Theme Fixes
     */
    public  $theme_fixes ;
    /**
     * Var that holds the menu class object.
     *
     * @since    1.0.0
     * @access   public
     * @var      XT_Woo_Floating_Cart_Menu  $menu   Menu
     */
    public  $menu ;
    /**
     * Initialize the class and set its properties.
     *
     * @param XT_Woo_Floating_Cart $core Plugin core class
     *
     * @since    1.0.0
     */
    public function __construct( &$core )
    {
        $this->core = $core;
        $this->core->plugin_loader()->add_filter( 'body_class', $this, 'body_class' );
        $this->core->plugin_loader()->add_action( 'wp_enqueue_scripts', $this, 'enqueue_vendors' );
        $this->core->plugin_loader()->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
        $this->core->plugin_loader()->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
        $this->core->plugin_loader()->add_filter(
            'wc_get_template',
            $this,
            'wc_get_template_cart_shipping',
            10,
            2
        );
        $this->core->plugin_loader()->add_action(
            'init',
            $this,
            'init_ajax',
            30
        );
        $this->core->plugin_loader()->add_action(
            'template_redirect',
            $this,
            'define_woocommerce_constants',
            10
        );
        $this->core->plugin_loader()->add_action( 'wp_footer', $this, 'render' );
        $this->core->plugin_loader()->add_action( 'init', $this, 'check_loop_add_to_cart_existence' );
        $this->init_frontend_dependencies();
    }
    
    // Init Ajax Instance
    public function init_ajax()
    {
        XT_Woo_Floating_Cart_AJAX::init();
    }
    
    // Init Frontend Dependencies
    public function init_frontend_dependencies()
    {
        $this->theme_fixes = new XT_Woo_Floating_Cart_Theme_Fixes( $this->core );
    }
    
    public function enabled()
    {
        if ( $this->is_checkout_page() || $this->is_cart_page() || $this->should_not_load() ) {
            return false;
        }
        $exclude_pages = $this->core->customizer()->get_option( 'hidden_on_pages', array() );
        if ( !empty($exclude_pages) ) {
            foreach ( $exclude_pages as $page ) {
                if ( !empty($page) && is_page( $page ) ) {
                    return false;
                }
            }
        }
        return true;
    }
    
    public function wc_get_template_cart_shipping( $template_name, $args = array() )
    {
        if ( strpos( $template_name, 'cart/cart-shipping.php' ) !== false && empty($args['show_shipping_calculator']) ) {
            if ( $this->core->frontend()->enabled() && ($this->core->customizer()->get_option_bool( 'enable_totals', false ) || $this->core->customizer()->get_option_bool( 'cart_checkout_form', false )) ) {
                $template_name = $this->core->get_template(
                    'parts/cart/shipping',
                    $args,
                    false,
                    true
                );
            }
        }
        return $template_name;
    }
    
    public function suggested_products_enabled()
    {
        $enabled = $this->core->customizer()->get_option_bool( 'suggested_products_enabled', false );
        $enabled_mobile = $this->core->customizer()->get_option_bool( 'suggested_products_mobile_enabled', false );
        return $enabled || $enabled_mobile && wp_is_mobile();
    }
    
    public function is_checkout_page()
    {
        $checkout_page_id = wc_get_page_id( 'checkout' );
        return is_page( $checkout_page_id );
    }
    
    public function is_cart_page()
    {
        $cart_page_id = wc_get_page_id( 'cart' );
        return is_page( $cart_page_id );
    }
    
    public function should_not_load()
    {
        $do_not_load = false;
        // skip if divi or elementor builder
        if ( !empty($_GET['et_fb']) || !empty($_GET['elementor-preview']) ) {
            $do_not_load = true;
        }
        return $do_not_load;
    }
    
    public function define_woocommerce_constants()
    {
        do_action( 'xt_woofc_before_woocommerce_constants' );
        
        if ( $this->enabled() && $this->core->access_manager()->can_use_premium_code__premium_only() ) {
            if ( wp_doing_ajax() && (xt_woofc_option_bool( 'enable_totals', false ) || xt_woofc_option_bool( 'cart_checkout_form', false )) ) {
                wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );
            }
            if ( $this->core->customizer()->get_option_bool( 'cart_checkout_form', false ) ) {
                add_filter( 'woocommerce_is_checkout', '__return_true' );
            }
        }
    
    }
    
    function body_class( $classes )
    {
        
        if ( $this->enabled() ) {
            $trigger_hide_view_cart = $this->core->customizer()->get_option( 'trigger_hide_view_cart', false );
            if ( !empty($trigger_hide_view_cart) ) {
                $classes[] = 'xt_woofc-hide-view-cart';
            }
        }
        
        return $classes;
    }
    
    /**
     * Register vendors assets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_vendors()
    {
        wp_enqueue_style(
            'xt-woo-custom',
            $this->core->plugin_url( 'public/assets/css', 'woo-custom.css' ),
            array(),
            $this->core->plugin_version(),
            'all'
        );
        if ( !$this->enabled() ) {
            return;
        }
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script(
            'xt-jquery-ajaxqueue',
            $this->core->plugin_url( 'public' ) . 'assets/vendors/jquery.ajaxqueue' . XTFW_SCRIPT_SUFFIX . '.js',
            array( 'jquery' ),
            $this->core->plugin_version(),
            false
        );
        wp_enqueue_script(
            'xt-jquery-touch',
            $this->core->plugin_url( 'public' ) . 'assets/vendors/jquery.touch' . XTFW_SCRIPT_SUFFIX . '.js',
            array( 'jquery' ),
            $this->core->plugin_version(),
            false
        );
        wp_enqueue_script(
            'xt-jquery-serializejson',
            $this->core->plugin_url( 'public' ) . 'assets/vendors/jquery.serializejson' . XTFW_SCRIPT_SUFFIX . '.js',
            array( 'jquery' ),
            $this->core->plugin_version(),
            false
        );
        wp_enqueue_script(
            'xt-cookie',
            $this->core->plugin_url( 'public' ) . 'assets/vendors/js.cookie' . XTFW_SCRIPT_SUFFIX . '.js',
            array( 'jquery' ),
            $this->core->plugin_version(),
            false
        );
        
        if ( $this->core->access_manager()->can_use_premium_code__premium_only() && $this->core->customizer()->get_option_bool( 'flytocart_animation', false ) ) {
            wp_enqueue_script(
                'xt-gsap',
                $this->core->plugin_url( 'public' ) . 'assets/vendors/gsap.min.js',
                array( 'jquery' ),
                $this->core->plugin_version(),
                false
            );
            wp_add_inline_script( 'xt-gsap', '
				window.xt_gsap = window.gsap;
			' );
        }
        
        if ( $this->core->customizer()->get_option_bool( 'active_cart_body_lock_scroll', false ) ) {
            wp_enqueue_script(
                'xt-body-scroll-lock',
                $this->core->plugin_url( 'public' ) . 'assets/vendors/bodyScrollLock' . XTFW_SCRIPT_SUFFIX . '.js',
                array(),
                $this->core->plugin_version(),
                false
            );
        }
        
        if ( $this->suggested_products_enabled() ) {
            wp_enqueue_script(
                'xt-lightslider',
                $this->core->plugin_url( 'public/assets/vendors/lightslider/js', 'lightslider' . XTFW_SCRIPT_SUFFIX . '.js' ),
                array( 'jquery' ),
                $this->core->plugin_version(),
                false
            );
            wp_enqueue_style(
                'xt-lightslider',
                $this->core->plugin_url( 'public/assets/vendors/lightslider/css', 'lightslider.css' ),
                array(),
                $this->core->plugin_version(),
                'all'
            );
        }
        
        wp_enqueue_style(
            'xt-icons',
            xtfw_dir_url( XTFW_DIR_CUSTOMIZER ) . '/controls/xt_icons/css/xt-icons.css',
            array(),
            $this->core->framework_version(),
            'all'
        );
        if ( !$this->is_cart_page() ) {
            wp_dequeue_script( 'wc-cart' );
        }
        wp_enqueue_script( 'wc-add-to-cart' );
        wp_enqueue_script( 'wc-cart-fragments' );
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        if ( !$this->enabled() ) {
            return;
        }
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in XT_Woo_Floating_Cart_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The XT_Woo_Floating_Cart_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_register_style(
            $this->core->plugin_slug(),
            $this->core->plugin_url( 'public/assets/css', 'frontend.css' ),
            array(),
            filemtime( $this->core->plugin_path( 'public/assets/css', 'frontend.css' ) ),
            'all'
        );
        wp_enqueue_style( $this->core->plugin_slug() );
        
        if ( $this->core->access_manager()->can_use_premium_code__premium_only() && is_rtl() ) {
            wp_register_style(
                $this->core->plugin_slug( 'rtl' ),
                $this->core->plugin_url( 'public/assets/css', 'rtl.css' ),
                array( $this->core->plugin_slug() ),
                filemtime( $this->core->plugin_path( 'public/assets/css', 'rtl.css' ) ),
                'all'
            );
            wp_enqueue_style( $this->core->plugin_slug( 'rtl' ) );
        }
    
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        if ( !$this->enabled() ) {
            return;
        }
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in XT_Woo_Floating_Cart_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The XT_Woo_Floating_Cart_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        // MAIN SCRIPT
        wp_register_script(
            $this->core->plugin_slug(),
            $this->core->plugin_url( 'public/assets/js', 'frontend' . XTFW_SCRIPT_SUFFIX . '.js' ),
            array( 'jquery', 'wc-add-to-cart', 'wc-cart-fragments' ),
            filemtime( $this->core->plugin_path( 'public/assets/js', 'frontend' . XTFW_SCRIPT_SUFFIX . '.js' ) ),
            false
        );
        $wc_ajax_url = add_query_arg( 'wc-ajax', '%%endpoint%%', home_url( '/' ) );
        $vars = array(
            'wc_ajax_url'                => urldecode( $wc_ajax_url ),
            'layouts'                    => $this->core->customizer()->breakpointsJson(),
            'can_use_premium_code'       => $this->core->access_manager()->can_use_premium_code__premium_only(),
            'can_checkout'               => xt_woofc_can_checkout(),
            'body_lock_scroll'           => $this->core->customizer()->get_option_bool( 'active_cart_body_lock_scroll', false ),
            'suggested_products_enabled' => $this->suggested_products_enabled(),
            'suggested_products_arrow'   => $this->core->customizer()->get_option( 'suggested_products_arrow', 'xt_wooqvicon-arrows-18' ),
            'cart_autoheight'            => xt_woofc_option_bool( 'cart_autoheight_enabled', false ),
            'cart_menu_enabled'          => xt_woofc_option_bool( 'cart_menu_enabled', false ),
            'cart_menu_click_action'     => xt_woofc_option( 'cart_menu_click_action', 'toggle' ),
            'lang'                       => array(
            'wait'              => esc_html__( 'Please wait', 'woo-floating-cart' ),
            'loading'           => esc_html__( 'Loading', 'woo-floating-cart' ),
            'min_qty_required'  => esc_html__( 'Min quantity required', 'woo-floating-cart' ),
            'max_stock_reached' => esc_html__( 'Stock limit reached', 'woo-floating-cart' ),
        ),
        );
        wp_localize_script( $this->core->plugin_slug(), 'XT_WOOFC', $vars );
        wp_enqueue_script( $this->core->plugin_slug() );
    }
    
    public function woocommerce_loop_add_to_cart_args( $args, $product )
    {
        $image_data = $this->get_product_image_data( $product );
        
        if ( !empty($image_data) ) {
            $args['attributes']['data-product_image_src'] = $image_data[0];
            $args['attributes']['data-product_image_width'] = $image_data[1];
            $args['attributes']['data-product_image_height'] = $image_data[2];
        }
        
        return $args;
    }
    
    public function woocommerce_single_add_product_image_info()
    {
        global  $product ;
        $image_data = $this->get_product_image_data( $product );
        if ( !empty($image_data) ) {
            echo  '<meta class="xt_woofc-product-image" data-product_id="' . esc_attr( $product->get_id() ) . '" data-product_image_src="' . esc_attr( $image_data[0] ) . '" data-product_image_width="' . esc_attr( $image_data[1] ) . '" data-product_image_height="' . esc_attr( $image_data[2] ) . '" />' ;
        }
    }
    
    public function get_product_image_data( $product )
    {
        $image_id = $product->get_image_id();
        return wp_get_attachment_image_src( $image_id, 'woocommerce_thumbnail', 0 );
    }
    
    function check_loop_add_to_cart_existence()
    {
        if ( $this->enabled() && $this->core->customizer()->get_option_bool( 'show_archive_add_to_cart_button' ) && !has_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' ) ) {
            add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20 );
        }
    }
    
    public function render()
    {
        if ( !$this->enabled() ) {
            return false;
        }
        WC()->cart->calculate_totals();
        echo  '<div id="xt_woofc">' ;
        $this->core->get_template( 'minicart' );
        echo  '</div>' ;
    }

}