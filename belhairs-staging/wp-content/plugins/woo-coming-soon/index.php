<?php 
/*
Plugin Name: Woo Coming Soon
Plugin URI: http://androidbubble.com/blog/wordpress/plugins/woo-coming-soon
Description: Woo Coming Soon is a great plugin to set your products to coming status. 
Version: 1.1.7
Author: Fahad Mahmood 
Author URI: http://www.androidbubbles.com
Text Domain: woo-coming-soon
Domain Path: /languages/
License: GPL2

Woo Coming Soon is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version. Woo Coming Soon is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with Woo Coming Soon. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/ 

include('io/functions-inner.php');

global $woo_cs_dir, $woo_cs_url;

$woo_cs_dir = plugin_dir_path( __FILE__ );
$woo_cs_url = plugin_dir_url( __FILE__ );

$rest_api_url = 'woo-cs-settings/v1';
$woo_cs_settings = new QR_Code_Settings_WCS($woo_cs_dir, $woo_cs_url, $rest_api_url);





add_filter('woocommerce_loop_add_to_cart_link', 'woo_csn_woocommerce_loop_add_to_cart_link', 10, 2);

function woo_csn_woocommerce_loop_add_to_cart_link($html, $product){
	
	$_coming_soon = get_post_meta($product->get_id(), '_coming_soon', true);
	$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
		
	$is_cs = ($product->get_status()=='coming_soon' || $_coming_soon=='true');
		
	if($is_cs)
	return '<div class="add-to-cart-button-outer"><div class="add-to-cart-button-inner"><div class="add-to-cart-button-inner2"><a rel="nofollow" class="qbutton add-to-cart-button button add_to_cart_button ajax_add_to_cart">'.__('Coming Soon', 'woo-coming-soon').'</a></div></div></div>';
	else
	return $html;
}

add_action( 'post_submitbox_misc_actions', 'woo_csn_custom_button' );

function woo_csn_custom_button(){
		global $post;
		global $woo_cs_url;		
		$_coming_soon = get_post_meta($post->ID, '_coming_soon', true);
		$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
        $html  = '<div class="coming-soon-section">';
        $html .= '<input type="button" value="Coming Soon" class="button button-secondary '.($_coming_soon=='true'?'active':'').'"><input type="hidden" class="" name="_coming_soon" value="'.$_coming_soon.'" />';
		$html .= '</div>';
		/* new code */
		$html .= QR_Code_Settings_WCS::ab_io_display($woo_cs_url);
        echo $html;
}

function woo_csn_disable_coming_soon_purchase( $purchasable, $product ) {

	$_coming_soon = get_post_meta($product->get_id(), '_coming_soon', true);
	$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
		
	$is_cs = ($product->get_status()=='coming_soon' || $_coming_soon=='true');
	 
    //$product_id = $product->is_type( 'variation' ) ? $product->get_variation_id() : $product->get_id();
   
    return (!$is_cs);
}
add_filter( 'woocommerce_variation_is_purchasable', 'woo_csn_disable_coming_soon_purchase', 10, 2 );
add_filter( 'woocommerce_is_purchasable', 'woo_csn_disable_coming_soon_purchase', 10, 2 );

function woo_csn_custom_post_status(){
	register_post_status( 'coming_soon', array(
		'label'                     => _x( 'Coming Soon', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => true,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Coming Soon <span class="count">(%s)</span>', 'Coming Soon <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'woo_csn_custom_post_status' );

add_action('admin_footer', 'woo_csn_append_post_status_list');
function woo_csn_append_post_status_list(){
     global $post;
     $complete = '';
     $label = '';
	 //pre($post);
     if(is_object($post) && !empty($post) && $post->post_type == 'product'){
          if($post->post_status == 'coming_soon'){
               $complete = ' selected="selected"';
               $label = '<span id="post-status-display"> '.__('Coming Soon').'</span>';
          }
?>
          <script>
          jQuery(document).ready(function($){
               $('select#post_status').append('<option value="coming_soon" <?php echo $complete; ?>><?php echo __('Coming Soon', 'woo-coming-soon'); ?></option>');
               $('.misc-pub-section label').append('<?php echo $label; ?>');
			   
			   $('.coming-soon-section input[type="button"]').click(function(){
				   $(this).toggleClass('active');
				   var obj = $('.coming-soon-section input[name="_coming_soon"]');
				   if(obj.val()=='true')
				   obj.val('false');
				   else
				   obj.val('true');
				   
			   });
          });
          </script>
          
          <style type="text/css">
		  .coming-soon-section{
			  background-color:#fff;
			  text-align:center;
		  }
		  .coming-soon-section input[type="button"]{
			background-color:#FFF;
			font-size:12px;  
			color:#000;
		  }
		  .coming-soon-section input[type="button"].active,
		  .coming-soon-section input[type="button"]:hover{
			background:none !important;
			font-size:12px;  
			background-color:#0085ba !important;
			color:#fff;
			border:0;
			box-shadow:none;
		  }

		  </style>
<?php  
     }
}
function woo_csn_display_archive_state( $states ) {
     global $post;
     $arg = get_query_var( 'post_status' );
     if($arg != 'coming_soon'){
          if(is_object($post) && !empty($post) && $post->post_status == 'coming_soon'){
               return array(__('Coming Soon', 'woo-coming-soon'));
          }
     }
    return $states;
}
add_filter( 'display_post_states', 'woo_csn_display_archive_state' );

add_action( 'woocommerce_before_single_product', 'woo_csn_wc_print_notices', 10 );


function sanitize_wcs_data( $input ) {

	if(is_array($input)){
	
		$new_input = array();

		foreach ( $input as $key => $val ) {
			$new_input[ $key ] = (is_array($val)?sanitize_wcs_data($val):sanitize_text_field( $val ));
		}
		
	}else{
		$new_input = sanitize_text_field($input);
	}
	
	return $new_input;
}


function woo_csn_wc_print_notices(){
	global $post;
	
	
	$_coming_soon = get_post_meta($post->ID, '_coming_soon', true);
	$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
		
	$is_cs = ($post->post_status=='coming_soon' || $_coming_soon=='true');
		
	if($is_cs){
?>
<style type="text/css">
.single-product .woo_csn_notices{
	text-align:right;
	font-size:18px;	
}
.single-product form.cart,
.single-product #tab-reviews{
	display:none !important;
}
</style>
<script type="text/javascript" language="javascript">
	jQuery(document).ready(function($){
		setTimeout(function(){
			$('.single-product form.cart').remove();
		}, 3000);
	});
</script>
<div class="woo_csn_notices"><strong><?php _e('This product is Coming Soon!', 'woo-coming-soon'); ?></strong></div>
<?php			
	}
	
}

function woo_csn_update_post( $post_id ) {
	if(is_admin() && isset($_POST['_coming_soon'])){
		update_post_meta($post_id, '_coming_soon', wp_kses($_POST['_coming_soon'], array()));
	}
}
add_action( 'save_post', 'woo_csn_update_post' );

if(!function_exists('pre')){
function pre($data){
		if(isset($_GET['debug'])){
			pree($data);
		}
	}	 
} 	
if(!function_exists('pree')){
function pree($data){
			echo '<pre>';
			print_r($data);
			echo '</pre>';	
	
	}	 
} 
