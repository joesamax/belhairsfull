<?php
/*
* Plugin Name: Ultimate Add To Cart Button For WooCommerce
* Plugin URI:  https://www.binarycarpenter.com/ultimate-add-to-cart-button-for-woocommerce/
* Description: All you need to customize add to cart button for WooCommerce
* Version: 1.118
* Author: BinaryCarpenter.com
* Author URI: https://www.binarycarpenter.com/
* License: GPL2
* WC tested up to: 3.9.2
*/

//pro 2.31
//free 1.116
namespace BinaryCarpenter\BC_ATC;

//include_once 'vendor/autoload.php';
include_once 'inc/Config.php';
include_once 'inc/BC_ATC_Options.php';
include_once 'inc/BC_ATC_Styles.php';
include_once 'inc/Activation.php';
include_once 'inc/BC_Static_UI.php';

namespace BinaryCarpenter\BC_ATC;

use WC_Product;
use \BinaryCarpenter\BC_ATC\Config as Config;
use \BinaryCarpenter\BC_ATC\Core as Core;
use \BinaryCarpenter\BC_ATC\BC_ATC_Options as Options;
use \BinaryCarpenter\BC_ATC\Activation as Activation;


/**
 * Class Initiator
 * @package BinaryCarpenter\BC_ATC
 */
class Initiator
{
    private static $instance;
    public function __construct()
    {
	    add_action('admin_enqueue_scripts', array($this, 'load_backend_scripts'), 10);
        add_action('wp_enqueue_scripts', array($this, 'load_frontend_scripts'), 10);
        add_filter( 'woocommerce_locate_template', array($this, 'locate_template'), 10, 3 );

        //set add to cart button text on single product page
        add_filter('woocommerce_product_single_add_to_cart_text', array($this, 'set_button_text'));
        add_filter('woocommerce_product_add_to_cart_text', array($this, 'change_add_to_cart_in_shop'), 10, 2);

        add_action('init', array($this, 'register_theme_type'), 10 , 2);

        add_action('wp_ajax_bc_uatc_save_options', array($this, 'save_options_cb') );
        add_action('wp_head', array($this, 'wp_head_print_style') );
        add_action('wp_ajax_bc_uatc_save_table', array($this, 'save_theme_cb') );
        add_action('wp_ajax_bc_uatc_get_themes', array($this, 'get_themes_cb') );
        add_action('wp_ajax_bc_uatc_edit_theme', array($this, 'edit_theme_cb'));
        add_action('wp_ajax_bc_uatc_delete_table', array($this, 'delete_table_cb'));
        add_action('admin_menu', array(&$this, 'add_to_menu'));

        //add support for woocommerce deposit products, by default, products with deposit enabled
        //have the text select option
        add_filter('woocommerce_deposits_add_to_cart_text', array($this, 'change_add_to_cart_in_shop'), 10, 2);


        //Only for woocommerce booking pluing
        add_action('woocommerce_booking_single_add_to_cart_text', array($this, 'change_booking_text'));

        //only add on pro
        if (Config::BC_ULTIMATE_ATC_IS_PRO)
            add_filter('woocommerce_quantity_input_classes', array($this, 'add_class_to_quantity_input'), 10, 2);

        //add the class to normal posts too
        add_filter('body_class', array($this, 'add_custom_body_class'), 10, 2);

        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
         global $uatcOptions;
        $showQuantityBoxShopPage = Options::bc_atc_get_option($uatcOptions, 'showQuantityBoxShopPage') === 'true';

        if ($showQuantityBoxShopPage)
        {
//            add_action( 'woocommerce_after_shop_loop_item', array($this, 'add_quantity_field'), 8 );
            add_action( 'init', array($this, 'shop_page_quantity_add_to_cart_handler' ));
         }

        if (Config::BC_ULTIMATE_ATC_IS_PRO)
            add_filter('pre_set_site_transient_update_plugins', array($this, 'check_for_plugin_update'));

        add_action('wp_ajax_bc_atc_add_product', array($this, 'ajax_add_product_to_cart'));
        add_action('wp_ajax_nopriv_bc_atc_add_product', array($this, 'ajax_add_product_to_cart'));

    }


    public static function get_instance()
    {
        if (self::$instance == null)
            self::$instance = new Initiator();

        return self::$instance;
    }

	public function ajax_add_product_to_cart() {

		try{
			WC()->cart->add_to_cart( intval($_POST["product_id"]), intval($_POST["quantity"]));

		} catch (\Exception $ex)
		{
			echo $ex->getMessage();
		}

		// Fragments and mini cart are returned
		$data = array(
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array()
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}

	// Take over the update check
	function check_for_plugin_update($checked_data) {
		global $wp_version;

		$plugin_folder = basename(plugin_dir_path(__FILE__));
		$plugin_index_file_name = basename((__FILE__));

		//Comment out these two lines during testing.
		if (empty($checked_data->checked))
			return $checked_data;

		$license_data = Activation::get_license_details();

		if ( (!isset($license_data['key']) || $license_data['key'] == '') ||
		     (!isset($license_data['email']) || $license_data['email'] == '')
        )
		    return $checked_data;

		$args = array(
			'slug' => Config::UPDATE_SLUG,
			'version' => $checked_data->checked[$plugin_folder .'/' . $plugin_index_file_name],
            'key' => $license_data['key'],
            'email' => $license_data['email'],
            'site_url' => get_site_url(),
		);

		$request_string = array(
			'body' => array(
				'action' => 'basic_check',
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		// Start checking for an update
		$raw_response = wp_remote_post(Config::UPDATE_CHECK_URL, $request_string);

		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
			$response = unserialize($raw_response['body']);

		if (is_object($response) && !empty($response)) // Feed the update data into WP updater
			$checked_data->response[$plugin_folder .'/' . $plugin_index_file_name] = $response;

		return $checked_data;
	}

	/**
	 * Add required JavaScript.
	 */
	function shop_page_quantity_add_to_cart_handler() {
	    $qty_code = '<div style="display: flex; align-items: center;" class="quantity bc-atc-qty-container"><span class="bc-atc-qty bc-atc-qty-changer bc-atc-qty-decrease">-</span><input type="number" class="input-text qty text bc-atc-text-input bc-atc-qty-input bc-atc-qty" step="1" min="1" max="" name="quantity" value="1" title="Qty" size="4" inputmode="numeric"><span class="bc-atc-qty bc-atc-qty-changer bc-atc-qty-increase">+</span></div>';
		wc_enqueue_js( '
	
		    $(\''.$qty_code.'\').insertBefore(".ajax_add_to_cart");
			$(".woocommerce .products").on("click", ".quantity input", function() {
				return false;
			});
			$(".woocommerce .products").on("change input", ".quantity .qty", function() {
				var add_to_cart_button = $(this).parents( ".product" ).find(".add_to_cart_button");
				// For AJAX add-to-cart actions
				add_to_cart_button.data("quantity", $(this).val());
				// For non-AJAX add-to-cart actions
				add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + $(this).val());
			});
			
			//for gutenberg blocks products
			$(".wc-block-grid__product").on("change input", ".quantity .qty", function() {
				var add_to_cart_button = $(this).parents( ".wc-block-grid__product" ).find(".add_to_cart_button");
				// For AJAX add-to-cart actions
				add_to_cart_button.data("quantity", $(this).val());
				// For non-AJAX add-to-cart actions
				add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + $(this).val());
			});
			
			
			// Trigger on Enter press
			$(".woocommerce .products").on("keypress", ".quantity .qty", function(e) {
				if ((e.which||e.keyCode) === 13) {
					$( this ).parents(".product").find(".add_to_cart_button").trigger("click");
				}
			});
		' );
	} 

	function add_quantity_field() {
		/** @var WC_Product $product */
		$product = wc_get_product( get_the_ID() );
		if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
			woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
		}
	}


	public function change_booking_text($default)
    {
        global $uatcOptions;
	    return Options::bc_atc_get_option($uatcOptions, 'wooBookingText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'wooBookingText') : $default;
    }

    function action_links($links)
    {
        $custom_links = array();
        $custom_links[] = '<a href="' . admin_url( 'admin.php?page=bc_ultimate_atc_entry_page' ) . '">' . __( 'Get started', Config::TEXT_DOMAIN ) . '</a>';
        $custom_links[] = '<a target="_blank" href="https://tickets.binarycarpenter.com/open.php">' . __( 'Supports', Config::TEXT_DOMAIN ) . '</a>';
        if (!Config::BC_ULTIMATE_ATC_IS_PRO)
            $custom_links[] = '<a target="_blank" href="https://www.binarycarpenter.com/app/ultimate-add-to-cart-button-plugin/">' . __( 'Get PRO', Config::TEXT_DOMAIN ) . '</a>';
        return array_merge( $custom_links, $links );
    }

    public function add_class_to_quantity_input($classes, $product)
    {
        //check if the user wants to hide the arrow, if yes, add the hide arrow class
        global $uatcOptions;
        $useATCQuantityBox = Options::bc_atc_get_option($uatcOptions, 'useATCQuantityStyle') === 'true';


        if ($useATCQuantityBox)
        {
            $hideInputNumberArrows = Options::bc_atc_get_option($uatcOptions, 'hideQtyInputArrows') === 'true';

            if ($hideInputNumberArrows)
                $classes[] = 'bc-atc-text-input';
            $classes[] = 'bc-atc-qty-input';
            $classes[] = 'bc-atc-qty'; //this class is for the minus and the increase buttons
        }


        return $classes;
    }

    public function add_custom_body_class($classes, $class)
    {
        global $uatcOptions;
        $style_class = Options::bc_atc_get_option($uatcOptions, 'style');

        $loading_icon_style_class = Options::bc_atc_get_option($uatcOptions, 'loadingIconStyleClass');
        $added_icon_style_class = Options::bc_atc_get_option($uatcOptions, 'addedIconStyleClass');
        //get the style classes here
        $classes[] = $style_class;
        $classes[] = 'bc-uatc-custom-button';
        if ($loading_icon_style_class !== '')
            $classes[] = $loading_icon_style_class;


        if ($added_icon_style_class !== '')
            $classes[] = $added_icon_style_class;


        //add the quantity box style to the front

        $quantity_box_style = Options::bc_atc_get_option($uatcOptions, 'quantityBoxStyle');

        $useATCQuantityBox = Options::bc_atc_get_option($uatcOptions, 'useATCQuantityStyle') === 'true';

        if ($useATCQuantityBox && $quantity_box_style != '')
        {
            $classes[] = 'bc-uatc-custom-qty-container';
            $classes[] = $quantity_box_style;
        }

        return $classes;
    }


    public function add_class_to_button_loop($classes, $product)
    {
        global $uatcOptions;
        $style_class = Options::bc_atc_get_option($uatcOptions, 'style');
        //get the style classes here
        $classes[] = $style_class;
        $classes[] = 'bc-uatc-custom-button';


        //add the quantity box style to the front

        $quantity_box_style = Options::bc_atc_get_option($uatcOptions, 'quantityBoxStyle');

        $useATCQuantityBox = Options::bc_atc_get_option($uatcOptions, 'useATCQuantityStyle') === 'true';

        if ($useATCQuantityBox && $quantity_box_style != '')
        {
            $classes[] = 'bc-uatc-custom-qty-container';
            $classes[] = $quantity_box_style;
        }

        return $classes;
    }


    public function save_options_cb()
    {
        //check if the plugin is activated. If not, send a notice to the user

        if (!Activation::activate(Config::KEY_CHECK_OPTION))
        {
            echo json_encode(array(
                'error' => true,
                'message' => 'Plugin is not activated. Please activate it now'
            ));



            die();
        }
        //save to an option
        update_option(Config::BC_ULTIMATE_ATC_BUTTON_OPTIONS, file_get_contents("php://input"));

        //update the generated css
        $this->process_css();

        echo json_encode(array(
            'error' => false,
            'message' => 'Button\'s settings are saved!'
        ));

        die();
    }


    private function add_modifier($input, $modifier)
    {
        return $input . $modifier;
    }

    /**
     *
     * This function process the css to print to the header. It will save the css into an option to save processing
     * This function is called every time the user save the settings
     */
    private function process_css()
    {

        $uatcOptions  = Options::get_options();

        $css          = '';
        $icon         = Options::bc_atc_get_option($uatcOptions, 'icon');
        $initialImage = Options::bc_atc_get_option($uatcOptions, 'initialImage');


        $border_width = Options::bc_atc_get_option($uatcOptions, 'buttonBorderWidth');
        $borderColor = Options::bc_atc_get_option($uatcOptions, 'buttonBorderColor');
	    $borderStyle = Options::bc_atc_get_option($uatcOptions, 'buttonBorderStyle');


	    $textSize = Options::bc_atc_get_option($uatcOptions, 'textSize');
	    $textSizeUnit = Options::bc_atc_get_option($uatcOptions, 'textSizeUnit');





	    //only add loading image and added image if loading icon style class and added icon style class is blank

        //this option is obsolete
	    //$loading_icon_style_class = Options::bc_atc_get_option($uatcOptions, 'loadingIconStyleClass');

	    //this option is obsolete
	    //$added_icon_style_class = Options::bc_atc_get_option($uatcOptions, 'addedIconStyleClass');

	    $loadingIcon = Options::bc_atc_get_option($uatcOptions, 'loadingIcon');
	    $addedIcon = Options::bc_atc_get_option($uatcOptions, 'addedIcon');

        $loadingImage = Options::bc_atc_get_option($uatcOptions, 'loadingImage');
        $addedImage = Options::bc_atc_get_option($uatcOptions, 'addedImage');

        $button_width = intval(Options::bc_atc_get_option($uatcOptions, 'buttonWidth'));
        $button_height = intval(Options::bc_atc_get_option($uatcOptions, 'buttonHeight'));

        $button_height_unit = Options::bc_atc_get_option($uatcOptions, 'buttonHeightUnit') !== '' ? Options::bc_atc_get_option($uatcOptions, 'buttonHeightUnit') : 'px';
        $button_width_unit = Options::bc_atc_get_option($uatcOptions, 'buttonWidthUnit') !== '' ? Options::bc_atc_get_option($uatcOptions, 'buttonWidthUnit') : 'px' ;

        $button_presets_style_class = Options::bc_atc_get_option($uatcOptions, 'style') != '' ? '.' .Options::bc_atc_get_option($uatcOptions, 'style') : '';


        $useCustomBackground = Options::bc_atc_get_option($uatcOptions, 'useCustomBackground') === 'true';
        $useCustomPadding = Options::bc_atc_get_option($uatcOptions, 'useCustomPadding') === 'true';
        $useCustomMargin = Options::bc_atc_get_option($uatcOptions, 'useCustomMargin') === 'true';
        $useCustomBorderRadius = Options::bc_atc_get_option($uatcOptions, 'useCustomBorderRadius') === 'true';
        $useCustomButtonSizes = Options::bc_atc_get_option($uatcOptions, 'useCustomButtonSizes') === 'true';

        $iconFontSize =  intval(Options::bc_atc_get_option($uatcOptions, 'iconFontSize'));
	    $iconFontSizeUnit = Options::bc_atc_get_option($uatcOptions, 'iconFontSizeUnit') !== '' ? Options::bc_atc_get_option($uatcOptions, 'iconFontSizeUnit') : 'px';

	    $buttonIconColor = Options::bc_atc_get_option($uatcOptions, 'buttonIconColor');


        //all buttons
        $only_button_selectors = array(
                '.button.product_type_simple.add_to_cart_button.ajax_add_to_cart',
                '.button.product_type_grouped',
                '.button.product_type_variable.add_to_cart_button',
                '.button.product_type_simple.add_to_cart_button',
                '.button.add_to_cart_button',
                '.single_add_to_cart_button.button.alt',
                '.add_to_cart_button',
                '.button.product_type_simple',
                '.button.product_type_external'
        );


        $button_containers_classes = array(
            '.woocommerce.bc-uatc-custom-button'.$button_presets_style_class.' .product',
            '.woocommerce.bc-uatc-custom-button'.$button_presets_style_class,
            '.bc-uatc-custom-button'.$button_presets_style_class.' .product',
            '.bc-uatc-custom-button'.$button_presets_style_class,
            '.bc-uatc-custom-button'.$button_presets_style_class,
        );

        $full_button_selector_classes = array();



        //generate the selectors for default button too since it's sensible to add icon and size to that option
        foreach ($button_containers_classes as $container)
        {
            foreach ($only_button_selectors as $button_selector)
                $full_button_selector_classes[] = $container . ' ' . $button_selector;
        }




        $quantity_box_container_selector = array(
            '.bc-uatc-custom-qty-container form .quantity',
            '.bc-uatc-custom-qty-container .product .quantity',
            '.bc-uatc-custom-qty-container .wc-block-grid__product .quantity',
            '.woocommerce.bc-uatc-custom-qty-container form .quantity',
        );


        //quantity selectors
        //these classes are used to print the icon


        $full_button_hover_selectors = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), ':hover'));


        //selector for :before pseudo
	    $button_before_selectors = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), ':before'));
	    $button_loading_class_before = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), '.loading:before'));
	    $button_added_class_before = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), '.added:before'));

	    //selectors for :after pseudo
	    $button_after_selectors = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), ':after'));
	    $button_loading_class_after = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), '.loading:after'));
	    $button_added_class_after = array_map(array($this, 'add_modifier'), $full_button_selector_classes, array_fill(0, count($full_button_selector_classes), '.added:after'));

	    $buttonIconPosition = Options::bc_atc_get_option($uatcOptions, 'buttonIconPosition');



	    $paddingLeft = (Options::bc_atc_get_option($uatcOptions, 'buttonPaddingLeft'));
	    $paddingRight = (Options::bc_atc_get_option($uatcOptions, 'buttonPaddingRight'));
	    $paddingTop = (Options::bc_atc_get_option($uatcOptions, 'buttonPaddingTop'));
	    $paddingBottom = (Options::bc_atc_get_option($uatcOptions, 'buttonPaddingBottom'));

	    $brTopLeft = (Options::bc_atc_get_option($uatcOptions, 'buttonRadiusTopLeft'));
	    $brTopRight = (Options::bc_atc_get_option($uatcOptions, 'buttonRadiusTopRight'));
	    $brBottomLeft = (Options::bc_atc_get_option($uatcOptions, 'buttonRadiusBottomLeft'));
	    $brBottomRight = (Options::bc_atc_get_option($uatcOptions, 'buttonRadiusBottomRight'));

	    $marginLeft = intval(Options::bc_atc_get_option($uatcOptions, 'buttonMarginLeft'));
	    $marginRight = intval(Options::bc_atc_get_option($uatcOptions, 'buttonMarginRight'));
	    $marginTop = intval(Options::bc_atc_get_option($uatcOptions, 'buttonMarginTop'));
	    $marginBottom = intval(Options::bc_atc_get_option($uatcOptions, 'buttonMarginBottom'));


	    //check if the user wants to use the quantity style box by the plugin
        $useATCQuantityBox = Options::bc_atc_get_option($uatcOptions, 'useATCQuantityStyle') === 'true';
        if ($useATCQuantityBox && Config::BC_ULTIMATE_ATC_IS_PRO) {

                //first, hide the increase and decrease buttons by the theme, if any

                //these are the span inside the quantity selector of the theme, not generated by bc-uatc
                $themes_span_selectors = array_map(array($this, 'add_modifier'), $quantity_box_container_selector, array_fill(0, count($quantity_box_container_selector), ' span:not(.bc-atc-qty)'));

                //these are the input inside the quantity selector of the theme, not generated by bc-uatc
                $theme_quantity_input_selector = array_map(array($this, 'add_modifier'), $quantity_box_container_selector, array_fill(0, count($quantity_box_container_selector), ' input:not(.bc-atc-qty)'));

                $css.= '/* hide the inputs */';
                $css.=($this->print_style($themes_span_selectors, 'display: none !important;'));
                $css.=($this->print_style($theme_quantity_input_selector, 'display: none !important;'));


                $quantity_input_selector = array_map(array($this, 'add_modifier'), $quantity_box_container_selector, array_fill(0, count($quantity_box_container_selector), ' .bc-atc-qty-input.bc-atc-qty'));

                $increase_decrease_buttons_selector = array_map(array($this, 'add_modifier'), $quantity_box_container_selector, array_fill(0, count($quantity_box_container_selector), ' .bc-atc-qty-changer'));


                $quantityInputWidth = intval(Options::bc_atc_get_option($uatcOptions, 'qtyBoxWidth'));
                $quantityInputHeight = intval(Options::bc_atc_get_option($uatcOptions, 'qtyBoxHeight'));

                $increaseDescreaseWidth = intval(Options::bc_atc_get_option($uatcOptions, 'minusAddWidth'));
                $increaseDescreaseHeight = intval(Options::bc_atc_get_option($uatcOptions, 'minusAddHeight'));



                $quantity_input_rules = '';

                $increase_decrease_input_rules = '';
                //then print the button sizes
                if ($quantityInputWidth > 0)
                {
                    $quantity_input_rules .= sprintf('width: %1$s  !important;', $quantityInputWidth.'px');
                }


                if ($quantityInputHeight > 0)
                {

                    $quantity_input_rules .= sprintf('height: %1$s !important;', $quantityInputHeight.'px');
                    $quantity_input_rules .= sprintf('line-height: %1$s  !important;', $quantityInputHeight.'px');

                    //make the quantity input height match the increase and decrease buttons

                }

                //add the quantity input rule to css
                $css .= $this->print_style($quantity_input_selector, $quantity_input_rules);


                if ($increaseDescreaseWidth > 0)
                {
                    $increase_decrease_input_rules .=  sprintf('width: %1$s !important;', $increaseDescreaseWidth.'px');
                }

                if ($increaseDescreaseHeight > 0)
                {
                    $increase_decrease_input_rules .= sprintf('height: %1$s !important;', $increaseDescreaseHeight.'px');
                    $increase_decrease_input_rules .= sprintf('line-height: %1$s !important;', $increaseDescreaseHeight.'px');
                }

                $css .= $this->print_style($increase_decrease_buttons_selector, $increase_decrease_input_rules);

            }


        //make the button position relative to contain the icon
	    $css.= $this->print_style($full_button_selector_classes, 'position: relative; box-sizing: border-box;');


	    $icon_margin_horizontal = $button_height != 0? ($button_height / 2) . $button_height_unit : '10px';
	    if ($buttonIconPosition == 'after')
        {
            $pseudoClass = $button_after_selectors;
            $loadingPseudoClass = $button_loading_class_after;
            $addedPseudoClass = $button_added_class_after;

	        //margin rules are to adjust the display, position of the button depends on where the icon is
	        $margin_rules = 'left: unset; margin: 0; right: ' . $icon_margin_horizontal . ';';
        }
	    else
        {
            $pseudoClass = $button_before_selectors;
	        $loadingPseudoClass = $button_loading_class_before;
	        $addedPseudoClass = $button_added_class_before;
	        $margin_rules = 'right: unset; margin: 0; left: '.$icon_margin_horizontal.';';
        }

	    $icon_font_and_color = '';
	    if ($iconFontSize != 0)
		    $icon_font_and_color .= sprintf('font-size: %1$s;', $iconFontSize . $iconFontSizeUnit);

	    if ($buttonIconColor !== '')
		    $icon_font_and_color .= sprintf('color: %1$s !important;', $buttonIconColor);



	    //reset :before or :after to '' if the icon is displayed at the oposite direction
        if ($buttonIconPosition == 'after')
        {
	        $css.= $this->print_style($button_loading_class_before, 'content: "" !important; display: none  !important;');
	        $css.= $this->print_style($button_added_class_before, 'content: "" !important; display: none !important;');
	        $css.= $this->print_style($button_before_selectors, 'content: "" !important; display: none !important;');
        } else
        {
	        $css.= $this->print_style($button_added_class_after, 'content: "" !important; display: none !important;');
	        $css.= $this->print_style($button_loading_class_after, 'content: "" !important; display: none !important;');
	        $css.= $this->print_style($button_after_selectors, 'content: "" !important; display: none !important;');
        }



	    $image_icon_height = $button_height * .6;
	    $image_icon_css_top = ($button_height - $image_icon_height - $border_width * 2) /2; //use this to center the image

        //print icon to all buttons, including default shop style
        if ($icon != '') {

            $css.= $this->print_style($pseudoClass,
                'content: "' . $icon . '" !important;'
                . 'font-family: "fontello_atc" !important;'
                . 'opacity: 1; '
                . 'display: block; '
                . 'position: absolute; '
                . 'top: 0; '
                . $icon_font_and_color
                . $margin_rules
                . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
                . 'height: ' . $button_height . $button_height_unit . '; '
                . 'box-shadow: none; '
                . '-webkit-box-shadow: none; '
                . '-moz-box-shadow: none; '
                . '-o-box-shadow: none; '
                . 'z-index: 10;'
                . 'transition: none !important; '
                . '-webkit-transition-property: none !important;'
                . '-moz-transition-property: none !important;'
                . '-o-transition-property: none !important;'
                . 'transition-property: none !important;'

            );

        } else if ( $initialImage != '') {
	        //decrease image size a bit

		    $css.= $this->print_style($pseudoClass,
			    'content: "" !important;'.
			    'background: url(' . $initialImage . ') no-repeat;'
                .'background-size: contain;'
			    . 'opacity: 1; '
			    . 'display: block; '
			    . 'position: absolute; '
			    . $margin_rules
			    . 'width: ' . $image_icon_height . $button_height_unit . '; '
			    . 'height: ' . $image_icon_height . $button_height_unit . '; '
			    . 'top: ' . $image_icon_css_top . $button_height_unit . '; '
			    . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
			    . 'box-shadow: none; '
			    . '-webkit-box-shadow: none; '
			    . '-moz-box-shadow: none; '
			    . '-o-box-shadow: none; '
			    . 'z-index: 10; '
			    . 'transition: none !important; '
			    . '-webkit-transition-property: none !important;'
			    . '-moz-transition-property: none !important;'
			    . '-o-transition-property: none !important;'
			    . 'transition-property: none !important;'
		    );
	    }

        if ($loadingIcon != '')
        {
	        $css.= $this->print_style($loadingPseudoClass,
		        'content: "' . $loadingIcon . '" !important;'
		        . 'font-family: "fontello_atc" !important; '
		        . 'opacity: 1; '
		        . 'display: block; '
		        .'-moz-animation: atc_spin 2s infinite linear;'
		        .'-o-animation: atc_spin 2s infinite linear;'
		        .'-webkit-animation: atc_spin 2s infinite linear;'
		        .'animation: atc_spin 2s infinite linear;'
		        . 'position: absolute; '
                . 'margin-top: 0;'
		        . $icon_font_and_color
		        . $margin_rules
		        . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
		        . 'height: ' . $button_height . $button_height_unit . '; '
		        . 'box-shadow: none; '
		        . '-webkit-box-shadow: none; '
		        . '-moz-box-shadow: none; '
		        . '-o-box-shadow: none; '
		        . 'z-index: 10; '
		        . 'transition: none !important; '
		        . '-webkit-transition-property: none !important;'
		        . '-moz-transition-property: none !important;'
		        . '-o-transition-property: none !important;'
		        . 'transition-property: none !important;'

	        );
        } else if ($loadingImage !== '')
        {
            //decrease image size a bit
	        $css.= $this->print_style($loadingPseudoClass,
		        'content: "" !important;'.
		        'background: url(' . $loadingImage . ') no-repeat;'
		        .'background-size: contain;'
		        .'-moz-animation: atc_spin 2s infinite linear;'
                .'-o-animation: atc_spin 2s infinite linear;'
                .'-webkit-animation: atc_spin 2s infinite linear;'
                .'animation: atc_spin 2s infinite linear;'
                .'display: inline-block;'
		        . 'opacity: 1; '
		        . 'display: block; '
		        . 'position: absolute; '
		        . 'margin-top: 0;'
		        . $margin_rules
		        . 'width: ' . $image_icon_height . $button_height_unit . '; '
		        . 'height: ' . $image_icon_height . $button_height_unit . '; '
		        . 'top: ' . $image_icon_css_top . $button_height_unit . '; '
		        . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
		        . 'box-shadow: none; '
		        . '-webkit-box-shadow: none; '
		        . '-moz-box-shadow: none; '
		        . '-o-box-shadow: none; '
		        . 'z-index: 10; '
		        . 'transition: none !important; '
		        . '-webkit-transition-property: none !important;'
		        . '-moz-transition-property: none !important;'
		        . '-o-transition-property: none !important;'
		        . 'transition-property: none !important;'

	        );
        }


        if ($addedIcon !=='' )
        {
	        $css.= $this->print_style($addedPseudoClass,
		        'content: "' . $addedIcon . '" !important;'
		        . 'font-family: "fontello_atc" !important; '
		        . 'opacity: 1; '
		        . 'display: block; '
		        . 'position: absolute; '
		        . 'top: 0; '
		        . $margin_rules
		        . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
		        . 'height: ' . $button_height . $button_height_unit . '; '
		        . 'box-shadow: none; '
		        . 'margin-top: 0;'
		        . '-webkit-box-shadow: none; '
		        . '-moz-box-shadow: none; '
		        . '-o-box-shadow: none; '
		        . 'z-index: 10; '
		        . 'transition: none !important; '
		        . '-webkit-transition-property: none !important;'
		        . '-moz-transition-property: none !important;'
		        . '-o-transition-property: none !important;'
		        . 'transition-property: none !important;'

	        );
        } else if ($addedImage !== '' )
	    {
		    $css.= $this->print_style($addedPseudoClass,
			    'content: "" !important;'
			    . 'background: url(' . $addedImage . ') no-repeat;'
			    .'background-size: contain;'
			    . 'opacity: 1;'
			    . 'display: block;'
			    . 'position: absolute;'
			    . 'margin-top: 0;'
			    . $icon_font_and_color
			    . $margin_rules
			    . 'width: ' . $image_icon_height . $button_height_unit . '; '
			    . 'height: ' . $image_icon_height . $button_height_unit . '; '
			    . 'top: ' . $image_icon_css_top . $button_height_unit . '; '
			    . 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '; '
			    . 'box-shadow: none; '
			    . '-webkit-box-shadow: none; '
			    . '-moz-box-shadow: none; '
			    . '-o-box-shadow: none; '
			    . 'z-index: 10; '
			    . 'transition: none !important; '
			    . '-webkit-transition-property: none !important;'
			    . '-moz-transition-property: none !important;'
			    . '-o-transition-property: none !important;'
			    . 'transition-property: none !important;'

		    );
	    }

            $advanced_style_rules = '';
            $advanced_style_hover_rules = '';

            if ($useCustomBorderRadius)
            {


                $brTopLeftRule = $brTopLeft != '' ? sprintf('border-top-left-radius: %1$s  !important;', $brTopLeft . 'px') : '';
                $brTopRightRule = $brTopRight != '' ? sprintf('border-top-right-radius: %1$s  !important;', $brTopRight . 'px') : '';
                $brBottomLeftRule = $brBottomLeft != '' ? sprintf('border-bottom-left-radius: %1$s  !important;', $brBottomLeft . 'px') : '';
                $brBottomRightRule = $brBottomRight != '' ? sprintf('border-bottom-right-radius: %1$s  !important;', $brBottomRight . 'px') : '';


                $advanced_style_rules .=
                    $brTopLeftRule
                    .$brTopRightRule
                    .$brBottomLeftRule
                    .$brBottomRightRule;
            }


            if ($useCustomPadding)
            {


                $paddingLeftRule = $paddingLeft != '' ? 'padding-left: ' . $paddingLeft . 'px !important;' : '';
                $paddingRightRule = $paddingRight != '' ? 'padding-right: ' . $paddingRight . 'px  !important;' : '';
                $paddingTopRule = $paddingTop != '' ? 'padding-top: ' . $paddingTop . 'px  !important;' : '';
                $paddingBottomRule = $paddingBottom != '' ? 'padding-bottom: ' . $paddingBottom . 'px  !important;' : '';

                $advanced_style_rules .= $paddingLeftRule . $paddingRightRule . $paddingTopRule . $paddingBottomRule;

            }



            if ($useCustomButtonSizes)
            {
                $button_width_rule = $button_width != '' ? 'width: ' . $button_width . $button_width_unit . '  !important;' : '';
                $button_height_rule = $button_height != '' ? 'height: ' . $button_height . $button_height_unit . '  !important;' : '';
                $button_line_height_rule = $button_height != '' ? 'line-height: ' . ($button_height - $border_width * 2) . $button_height_unit . '  !important;' : '';

	            $button_display_block = Options::bc_atc_get_option($uatcOptions, 'buttonDisplayBlock') === 'true';
	            if ($button_display_block)
                    $button_display_block_rule = 'display: block;';
	            else
	                $button_display_block_rule = 'display: inline-block;';

                $advanced_style_rules .= $button_width_rule . $button_height_rule . $button_line_height_rule . 'min-height: unset !important;' . $button_display_block_rule;
            }

            if ($textSize !== '')
            {
                $sizeUnit = $textSizeUnit !== '' ? $textSizeUnit : 'px';

                $advanced_style_rules .= sprintf('font-size: %1$s%2$s;', $textSize, $sizeUnit);
            }

            if ($useCustomMargin)
            {
                $marginLeftRule = $marginLeft != '' ? 'margin-left: ' . $marginLeft . 'px  !important;' : '';
                $marginRightRule = $marginRight != '' ? 'margin-right: ' . $marginRight . 'px  !important;' : '';
                $marginTopRule = $marginTop != '' ? 'margin-top: ' . $marginTop . 'px  !important;' : '';
                $marginBottomRule = $marginBottom != '' ? 'margin-bottom: ' . $marginBottom . 'px  !important;' : '';

                $advanced_style_rules .= $marginLeftRule . $marginRightRule . $marginTopRule . $marginBottomRule;
            }


            if ($useCustomBackground)
            {
                //do some reset
	            //if no border is set then on hover and normal state, set border to 0
                if ($borderColor == '' && $border_width == '')
                {
	                $advanced_style_rules .= 'border: 0 !important;';
	                $advanced_style_hover_rules .= 'border: 0 !important;';
                }

                if (Options::bc_atc_get_option($uatcOptions, 'buttonBackgroundType') == 'solid'):


                    $advanced_style_rules .=
                        'background-color: ' . Options::bc_atc_get_option($uatcOptions, 'buttonSolidBackgroundColor') . ' !important;'
                        . 'color: ' . Options::bc_atc_get_option($uatcOptions, 'buttonSolidTextColor') . ' !important;';


                    //print the hover style

                    $advanced_style_hover_rules .=
                        'background-color: ' . Options::bc_atc_get_option($uatcOptions, 'buttonSolidHoverBackgroundColor') . ' !important;'
                        . 'color: ' . Options::bc_atc_get_option($uatcOptions, 'buttonSolidHoverTextColor') . ' !important;';


                elseif (Options::bc_atc_get_option($uatcOptions, 'buttonBackgroundType') == 'gradient'):
                    $advanced_style_rules .=
                        'background-image: -webkit-linear-gradient('
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientDegree') . 'deg,'
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientFirstBackgroundColor') . ', '
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientSecondBackgroundColor')

                        . ')  !important;'

                        .'background: linear-gradient('
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientDegree') . 'deg,'
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientFirstBackgroundColor') . ', '
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientSecondBackgroundColor')

                        . ') !important;'
                        . 'color: '
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientTextColor') . ';';


                    $advanced_style_hover_rules .=
                        'background: linear-gradient('
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientHoverDegree') . 'deg,'
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientHoverFirstBackgroundColor') . ', '
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientHoverSecondBackgroundColor')

                        . ') !important;'
                        . 'color: '
                        . Options::bc_atc_get_option($uatcOptions, 'buttonGradientHoverTextColor') . ';';


                elseif (Options::bc_atc_get_option($uatcOptions, 'buttonBackgroundType') == 'image'):


                    $advanced_style_rules .=
                        'background-image: url(' . Options::bc_atc_get_option($uatcOptions, 'buttonImageBackgroundURL') . ');'
                        . 'background-repeat:' . Options::bc_atc_get_option($uatcOptions, 'buttonImageBackgroundRepeat') . ';'

                        . 'background-size:' . Options::bc_atc_get_option($uatcOptions, 'buttonImageBackgroundSize') . ' ;';


                endif; //end the background type styles
            }


            if ($borderColor != '' && $border_width != '')
            {
	            $advanced_style_rules .= sprintf('border-width: %1$s !important;', $border_width . 'px');
	            $advanced_style_rules .= sprintf('border-color: %1$s !important;', $borderColor);
	            $advanced_style_rules .= sprintf('border-style: %1$s !important;', $borderStyle);

            }



            $css .= $this->print_style($full_button_selector_classes, $advanced_style_rules);
            $css .= $this->print_style($full_button_hover_selectors, $advanced_style_hover_rules);




        update_option(Config::HEAD_CSS_META, $css);


        return $css;

    }


    public function wp_head_print_style()
    {



        ?>

        <style>


            /* Print the advanced styles options when user select advanced style */
            /*  */
            <?php

                //make this to compatible with the previous version, where the option is blank
                $css = get_option(Config::HEAD_CSS_META, '');
                if ($css == '')
                {
                    echo $this->process_css();
                } else
                {
                    echo $css;
                }

                ?>



        </style>

    <?php }



    public function print_style($selectors,  $rule)
    {


        $final_rule = implode(",", $selectors) . '{'.$rule.'}';


        return $final_rule;
    }

    public function save_theme_cb()
    {

        $content = file_get_contents("php://input");
        parse_str($content, $data);

        wp_insert_post(array(
            'ID' => $data['ID'],
            'post_title' => $data['title'],
            'post_content' => $data['content'],
            'meta_input' => array(
                Config::BC_ULTIMATE_ATC_THEME_CLASS_META => $data['css_class']
            )
        ));

        die();
    }



    public function get_themes_cb()
    {
        $themes = get_posts([
            'post_type' => Config::BC_ULTIMATE_ATC_CUSTOM_THEME,
            'post_status' => 'publish',
            'numberposts' => -1

            // 'order'    => 'ASC'
        ]);
        $data = array();
        foreach ($themes as $t)
        {
            $data[]  = array(
                'title' => $t->post_title,
                'ID' => $t->ID
            );
        }

        echo json_encode($data);

        die();

    }




    public function edit_table_cb()
    {
        parse_str(file_get_contents("php://input") , $data);
        $theme = get_post($data['ID']);
        echo json_encode(array(
            'title' => $theme->post_title,
            'content' => $theme->post_content,
            'css_class' => get_post_meta($data['ID'], Config::BC_ULTIMATE_ATC_THEME_CLASS_META, true)
        ));

        die();
    }




    public function delete_table_cb()
    {
        parse_str(file_get_contents("php://input"), $data);

        wp_delete_post($data['id']);
        die();
    }



    public function add_to_menu() {
        if (!class_exists('BinaryCarpenterCore'))
            include_once 'inc/bc_core.php';
        $core = new Core();
        $core->admin_menu();

        add_submenu_page(
                Core::MENU_SLUG,
                'Ultimate ATC Buttons',
                '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAYAAABccqhmAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyNpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQwIDc5LjE2MDQ1MSwgMjAxNy8wNS8wNi0wMTowODoyMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChNYWNpbnRvc2gpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkM0NjNDRDhEQTU3MTExRTk5NzkyQjEwNkZGNUVBOTlDIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkM0NjNDRDhFQTU3MTExRTk5NzkyQjEwNkZGNUVBOTlDIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QzQ2M0NEOEJBNTcxMTFFOTk3OTJCMTA2RkY1RUE5OUMiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QzQ2M0NEOENBNTcxMTFFOTk3OTJCMTA2RkY1RUE5OUMiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz68O1DPAAAkEElEQVR42uydCXQd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" style="display: inline-block; width: 14px; height: 14px;"> Ultimate ATC buttons',
                'edit_posts',
                Config::BC_ULTIMATE_ATC_BUTTON_ENTRY_SLUG,
                array($this, 'bc_uatc_ui_entry'));
    }

    public function bc_uatc_ui_entry()
    {
        ?>

        <div class="bc-root">
            <ul class="bc-uk-tab" data-uk-tab="{connect:'#uatc-main-entry-tabs'}">
                <li><a href="#">General</a></li>
                <li><a href="#">Configure buttons</a></li>
            </ul>

            <ul  class="bc-uk-switcher" id="uatc-main-entry-tabs">
                <li id="t1">
                    <?php include_once(plugin_dir_path(__FILE__) . 'ui/main-ui.php'); ?>
                </li>

                <li id="t2">
                    <?php include_once(plugin_dir_path(__FILE__) . 'ui/manage-buttons.php'); ?>
                </li>
            </ul>
        </div>
        <?php

    }

    public function bc_uatc_create_style()
    {
        include_once 'ui/create-style.php';
    }



    public function load_backend_scripts()
    {
        wp_register_style(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-backend-bundle-style', plugins_url( 'bundle/css/backend.css', __FILE__ ));


        wp_register_script( Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-backend-bundle-handler', plugins_url( 'bundle/js/backend-bundle.js', __FILE__ ), array(
            'jquery',
            'jquery-ui-core',
            'jquery-effects-core',
            'jquery-ui-widget',
            'jquery-ui-draggable',
            'jquery-ui-droppable',
            'jquery-ui-sortable',
            'jquery-ui-autocomplete',
            'jquery-ui-tabs',
            'underscore',
            'backbone'
        ), false, true );
        wp_enqueue_media();
        $base = get_current_screen()->base;
        if (stripos($base, 'bc_ultimate_atc'))
        {
            wp_enqueue_script(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-backend-bundle-handler', '', array(), false, true);
            wp_enqueue_style(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-backend-bundle-style');
        }

    }






    public function load_frontend_scripts()
    {
        wp_register_style(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-frontend-bundle-style', plugins_url( 'bundle/css/bc-uatc-front.css', __FILE__ ));
        wp_enqueue_style(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-frontend-bundle-style');

        wp_register_script( Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-frontend-bundle-handler', plugins_url( 'bundle/js/frontend-bundle.js', __FILE__ ), array(
            'jquery',
            'underscore',
            'backbone'
        ), false, true );


        global $uatcOptions;
        //print the settings to frontend
        $uatcOptions['ajaxurl'] = admin_url( 'admin-ajax.php' );
        wp_localize_script(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-frontend-bundle-handler', 'bc_uatc_settings', $uatcOptions);

        wp_enqueue_script(Config::BC_ULTIMATE_ATC_BUTTON_PREFIX . '-frontend-bundle-handler', '', array(), false, true);

    }


    public function bc_ultimate_atc_plugin_path() {

        // gets the absolute path to this plugin directory

        return untrailingslashit( plugin_dir_path( __FILE__ ) );
    }




    public function locate_template( $template, $template_name, $template_path ) {
        global $woocommerce;

        $_template = $template;

        if ( ! $template_path ) $template_path = $woocommerce->template_url;

        $plugin_path  = $this->bc_ultimate_atc_plugin_path() . '/woocommerce/';

        // Look within passed path within the theme - this is priority
        $template = locate_template(

            array(
                $template_path . $template_name,
                $template_name
            )
        );

        // Modification: Get the template from this plugin, if it exists
        if ( ! $template && file_exists( $plugin_path . $template_name ) )
            $template = $plugin_path . $template_name;

        // Use default template
        if ( ! $template )
            $template = $_template;

        // Return what we found
        return $template;
    }

	/**
     * Set the text for single product page. This function hooked in to  'woocommerce_product_single_add_to_cart_text'
	 * @param $name
	 *
	 * @return mixed|string
	 */
    public function set_button_text($name)
    {
        global $uatcOptions;
        global $product;

        if ($product == null)
        {
	        if (Options::bc_atc_get_option($uatcOptions, 'text') !== '')
		        return Options::bc_atc_get_option($uatcOptions, 'text');
	        else
	            return $name;
        }

        $type = '';

        try
        {
	        $type = $product->get_type();
        } catch (\Exception $e)
        {
            return $name;
        }




	    if ($type == 'simple')
	    {
		    return Options::bc_atc_get_option($uatcOptions, 'text') !== '' ? Options::bc_atc_get_option($uatcOptions, 'text') : $name;
	    }

	    else if ($type == 'variable')
		    return Options::bc_atc_get_option($uatcOptions, 'variableText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'variableText') : $name;

	    else if ($type == 'grouped')
		    return Options::bc_atc_get_option($uatcOptions, 'groupedText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'groupedText') : $name;

	    else if ($type == 'external')
	    {
		    return Options::bc_atc_get_option($uatcOptions, 'externalText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'externalText') : $name;
	    }

	    else if ($type == 'booking')
		    return Options::bc_atc_get_option($uatcOptions, 'wooBookingText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'wooBookingText') : $name;


        return $name;
    }


	/**
	 * @param $name
	 * @param null $product
	 *
	 * @return mixed|string
	 */
    public function change_add_to_cart_in_shop($name, $product = null)
    {
        global $uatcOptions;

        if ($product == null)
        {
            //if the passed in product is null, try to get the product from global variable
            global $product;

            if ($product == null)
                return $name;
        }

        if (method_exists($product, 'get_type'))
        {
            $type = $product->get_type();
        } else
        {
            return $name;
        }



        // create a log channel
        //	    $log = new Logger('name');
        //	    $log->pushHandler(new StreamHandler(plugin_dir_path(__FILE__). '/your.log', Logger::WARNING));
        //
        //	    $log->error('Type is: '.  $type);

        if ($type == 'simple')
        {
            return Options::bc_atc_get_option($uatcOptions, 'text') !== '' ? Options::bc_atc_get_option($uatcOptions, 'text') : $name;
        }

        else if ($type == 'variable')
            return Options::bc_atc_get_option($uatcOptions, 'variableText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'variableText') : $name;

        else if ($type == 'grouped')
            return Options::bc_atc_get_option($uatcOptions, 'groupedText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'groupedText') : $name;

	    else if ($type == 'external')
        {
            return Options::bc_atc_get_option($uatcOptions, 'externalText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'externalText') : $name;
        }

	    else if ($type == 'booking')
		    return Options::bc_atc_get_option($uatcOptions, 'wooBookingText') !== '' ? Options::bc_atc_get_option($uatcOptions, 'wooBookingText') : $name;

        return $name;

    }

    public function register_theme_type()
    {
        $args = array(
            'labels' => array(
                'name' => 'Button styles',
                'singular_name' => 'Style',
                'add_new' => 'Add new table',
                'edit_item' => 'Edit Premium Content',
                'all_items' => 'All Premium Content',
                'publicly_queryable' => true
            ),
            'public' => false,
            'show_ui' => false,
            'has_archive' => true,
            'supports' => array( 'title', 'author')

        );

        register_post_type(Config::BC_ULTIMATE_ATC_CUSTOM_THEME, $args);
    }

}

$uatcOptions = Options::get_options();

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
    }
}

add_action('plugin_loaded', function(){
    if (is_woocommerce_activated())
        Initiator::get_instance();

});
