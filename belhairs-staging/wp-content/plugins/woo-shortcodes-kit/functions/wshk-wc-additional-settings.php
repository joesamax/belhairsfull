<?php 



//Since v.1.6.8 - Updated v.1.8.0

/*AUTOCOMPLETE THE ORDERS*/
//With this function your orders will be completed automaticlly, just active it and forget the processing status.

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableautocom']) && $pluginOptionsVal['wshk_enableautocom']==84)
{


add_action('woocommerce_order_status_changed', 'ts_auto_complete_virtual');

function ts_auto_complete_virtual($order_id)
{

if ( ! $order_id ) {
return;
}

global $product;
$order = wc_get_order( $order_id );

if ($order->data['status'] == 'processing') {

$virtual_order = null;

if ( count( $order->get_items() ) > 0 ) {

foreach( $order->get_items() as $item ) {

if ( 'line_item' == $item['type'] ) {

$_product = $order->get_product_from_item( $item );

if ( ! $_product->is_virtual() ) {
// once we find one non-virtual product, break out of the loop
$virtual_order = false;
break;
} 
else {
$virtual_order = true;
}
}
}
}

// if all are virtual products, mark as completed
if ( $virtual_order ) {
$order->update_status( 'completed' );
}
}
}

}





//Since v.1.6.8
    
/*CUSTOM THANK YOU PAGE REDIRECTIONS*/
//If you want redirect the users to a custom thank you page if buy some product (max 3 differents products) or redirect to a general custom thank you page, just need use this function.
    
    
/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableacustomthankyoupage']) && $pluginOptionsVal['wshk_enableacustomthankyoupage']==87)
{ 


    
    function wcs_redirect_product_based_men ( $order_id ){
	$order = wc_get_order( $order_id );
	
	
	
	$myproductone = get_option('wshk_customthankyouone');
	$myproductoneid = get_option('wshk_customthankyouoneid');
	
	$myproducttwo = get_option('wshk_customthankyoutwo');
	$myproducttwoid = get_option('wshk_customthankyoutwoid');
	
	$myproductthree = get_option('wshk_customthankyouthree');
	$myproductthreeid = get_option('wshk_customthankyouthreeid');
	
	$myproducsgeneral = get_option('wshk_customthankyougeneral');
	
	$miurlm = get_option( 'siteurl' );
	
	
 
	foreach( $order->get_items() as $item ) {
		$_product = wc_get_product( $item['product_id'] );
		
	  
	  // PRODUCT ONE
		if ( $item['product_id'] == $myproductoneid ) {
			// change to the URL that you want to send your customer to  
                	wp_redirect($miurlm . '/' . $myproductone);
		}
	  
	  // PRODUCT TWO
	  else if ( $item['product_id'] == $myproducttwoid ) {
			// change to the URL that you want to send your customer to  
                	wp_redirect($miurlm . '/' . $myproducttwo);
		}
	  
	  //PRODUCT THREE
	  else if ( $item['product_id'] == $myproductthreeid ) {
			// change to the URL that you want to send your customer to  
                	wp_redirect($miurlm . '/' . $myproductthree);
		}
		
		
	  
	  //GENERAL OR OTHER PRODUCTS
	  else {
			// change to the URL that you want to send your customer to  
                	wp_redirect($miurlm . '/' . $myproducsgeneral);
		}
	  
	}
}
add_action( 'woocommerce_thankyou', 'wcs_redirect_product_based_men' );	

}



/*DISABLE THE NEW WOOCOMMERCE DASHBOARD*/
//Since 1.8.5


/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/

if(isset($pluginOptionsVal['wshk_disablenewdashboardwc']) && $pluginOptionsVal['wshk_disablenewdashboardwc']==1851) { 
    
    
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_filter( 'woocommerce_admin_disabled', '__return_true' );
}

}




//Since v.1.6.8

/*ADD NAME AND SURNAME FIELDS TO WC REGISTER FORM*/




/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_wcregisterformfieldsextra']) && $pluginOptionsVal['wshk_wcregisterformfieldsextra']==93)
{ 




// 1. ADDING
 
add_action( 'woocommerce_register_form_start', 'wshk_add_name_woo_account_registration' );
 
function wshk_add_name_woo_account_registration() {
    ?>
 
    <p class="form-row form-row-first">
    <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
    </p>
 
    <p class="form-row form-row-last">
    <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
 
    <div class="clear"></div>
 
    <?php
}
 

// VALIDATING
 
add_filter( 'woocommerce_registration_errors', 'wshk_validate_name_fields', 10, 3 );
 
function wshk_validate_name_fields( $errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
    }
    return $errors;
}
 

// SAVING
 
add_action( 'woocommerce_created_customer', 'wshk_save_name_fields' );
 
function wshk_save_name_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
    }
 
}

}







//Since v.1.7.1

/*SKIP CART AND JUMP TO CHECKOUT*/
//If you want send the users directly to the checkout page after press the add to cart button, just need enable this function.


/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableskipcart']) && $pluginOptionsVal['wshk_enableskipcart']==96)
{

add_filter('woocommerce_add_to_cart_redirect', 'wshk_add_to_cart_redirect');
function wshk_add_to_cart_redirect() {
 global $woocommerce;
 $checkout_url = wc_get_checkout_url();
 return $checkout_url;
}


}




//Since v.1.3

/*ADD PRODUCT IMAGE IN ORDER EMAIL*/
//If you want show the product image in the Order email, just enable this function.

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/

if(isset($pluginOptionsVal['wshk_test']) && $pluginOptionsVal['wshk_test']==2)
{
add_filter( 'woocommerce_email_order_items_args', 'wshk_woocommerce_email_order_items_args', 10, 1 );
 
function wshk_woocommerce_email_order_items_args( $args ) {
$emailordersizes = get_option('wshk_emailordersizes');
 
    $args['show_image'] = true;
    $args['image_size'] = array( $emailordersizes, $emailordersizes );
 
    return $args;
 
}
}




//Since v.1.7.3
//Display product image in order details
/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableproimage']) && $pluginOptionsVal['wshk_enableproimage']==8833)
{ 



add_filter( 'woocommerce_order_item_name', 'wshk_display_product_image_on_order_view_myaccount', 20, 3 );
function wshk_display_product_image_on_order_view_myaccount( $item_name, $item, $is_visible ) {

    if( is_wc_endpoint_url( 'view-order' ) ) {
        
        
    $prodimagesize = get_option('wshk_prodimagesize');
    $prodbordsize = get_option('wshk_prodimagebordsize');
    $prodbordtype = get_option('wshk_prodimagebordtype');
    $prodbordcolor = get_option('wshk_prodimagebordcolor');
    $prodbordradius = get_option('wshk_prodimagebordradius');
    
    $product   = $item->get_product();
    $thumbnail = $product->get_image(array( $prodimagesize, $prodimagesize)); // change width and height into whatever you like
    if( $product->get_image_id() > 0 )
    $item_name = '<style>div.item-thumbnail > span > img[class*=attachment-] {border:'.$prodbordsize.'px '.$prodbordtype.' '.$prodbordcolor.'; border-radius:'.$prodbordradius.'%;}</style><div class="item-thumbnail"><span style="margin-right:16px;">' . $thumbnail . '</span></div>' . $item_name;
    }
    return $item_name;
}
}




/*START LIMIT CART QUANTITY*/

//Since v.1.8.0

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/

if(isset($pluginOptionsVal['wshk_onlyoneincartt']) && $pluginOptionsVal['wshk_onlyoneincartt']==2009) {  
  
    
 

add_filter( 'woocommerce_add_to_cart_validation', 'wshk_only_one_in_cart', 99, 2 );

function wshk_only_one_in_cart( $passed, $added_product_id ) {

global $woocommerce;

// empty cart: new item will replace previous
$_cartQty = count( $woocommerce->cart->get_cart() );
$proincartlimit = get_option('wshk_productsincart');
if($_cartQty >= $proincartlimit){
    $woocommerce->cart->empty_cart();   
}

// display a message if you like
//wc_add_notice( 'Product added to cart!', 'notice' );

return $passed;
}


}

/*END LIMIT CART QUANTITY*/




/*START CHANGE RETURN TO SHOP BUTTON TEXT AND REDIRECTION*/

//Since v.1.8.0

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/

if(isset($pluginOptionsVal['wshk_returntoshopbtn']) && $pluginOptionsVal['wshk_returntoshopbtn']==2011) { 
    
 /*custom button text*/    


 //Sustituir plantilla del tema por la del plugin
add_filter( 'wc_get_template', 'wshk_cma_get_templatebtntext', 10, 5 );
function wshk_cma_get_templatebtntext( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'cart/cart-empty.php' == $template_name ) {
       
        $located = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/mytemplates/cart-empty.php';
    }
    
    return $located;
}
 
 /*custom redirection*/ 
 
 $retushopurlredi = get_option('wshk_retshopurlredi'); 
 if(!isset($retushopurlredi) || trim($retushopurlredi) == ''){


add_filter( 'woocommerce_return_to_shop_redirect', 'wshk_change_return_shop_url' );
 
function wshk_change_return_shop_url() {
return get_permalink( wc_get_page_id( 'shop' ) );
}

}else {
    
add_filter( 'woocommerce_return_to_shop_redirect', 'wshk_change_return_shop_url' );
 
function wshk_change_return_shop_url() {
 $retushopurlredi = get_option('wshk_retshopurlredi'); 
return home_url($retushopurlredi);    
}
}
    
}


/*END CHANGE RETURN TO SHOP BUTTON TEXT AND REDIRECTION*/





?>