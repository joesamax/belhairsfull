<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the suggested products.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/suggested-products.php.
 *
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.4.8
 *
 * @package    XT_Woo_Floating_Cart
 * @subpackage XT_Woo_Floating_Cart/public/templates/parts
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$args = array(
    'post_type'            	=> 'product',
    'post_status'    		=> 'publish',
    'ignore_sticky_posts'  	=> 1,
    'no_found_rows'       	=> 1,
    'posts_per_page'       	=> $items_count,
    'post__not_in'        	=> $exclude_ids,
    'post__in'        	    => $suggested_products,
    'orderby'             	=> 'rand',
    'meta_query'			=> array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '=',
        )
    )
);

$products = new WP_Query( $args );

$classes = array('xt_woofc-sp');

if(!$products->have_posts()) {
	$classes[] = 'xt_woofc-sp-empty';
}

$classes = implode(" ", $classes);
?>

<div class="<?php echo esc_attr($classes); ?>">

    <?php if ( $products->have_posts() ) : ?>
    <span class="xt_woofc-sp-title"><?php echo $title; ?></span>
    <ul class="xt_woofc-sp-products">
        <?php
        while ( $products->have_posts() ) : $products->the_post();
            global $product;
            $product_link = $product->get_permalink();
            ?>
            <li class="xt_woofc-sp-item lslide">

                <div class="xt_woofc-sp-item-wrap">
                    <div class="xt_woofc-sp-left-area">
                        <div class="xt_woofc-product-image">
                        <?php
                        woocommerce_template_loop_product_link_open();
                        woocommerce_template_loop_product_thumbnail();
                        woocommerce_template_loop_product_link_close();
                        ?>
                        </div>
                    </div>

                    <div class="xt_woofc-sp-right-area">
                        <div class="xt_woofc-sp-product-title">
                            <?php
                            woocommerce_template_loop_product_link_open();
                            echo get_the_title();
                            woocommerce_template_loop_product_link_close();
                            ?>
                        </div>
                        <?php woocommerce_template_loop_price(); ?>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                </div>

            </li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>

</div>

