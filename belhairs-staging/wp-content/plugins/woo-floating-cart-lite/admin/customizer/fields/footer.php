<?php

$fields[] = array(
    'id'        => 'cart_checkout_button_bg_color',
    'section'   => 'footer',
    'label'     => esc_html__( 'Cart Checkout Button Bg Color', 'woo-floating-cart' ),
    'type'      => 'color',
    'choices'   => array(
    'alpha' => true,
),
    'default'   => '#2c97de',
    'transport' => 'auto',
    'output'    => array( array(
    'element'  => '.xt_woofc-inner a.xt_woofc-checkout',
    'property' => 'background',
) ),
);
$fields[] = array(
    'id'        => 'cart_checkout_button_bg_hover_color',
    'section'   => 'footer',
    'label'     => esc_html__( 'Cart Checkout Button Bg Hover Color', 'woo-floating-cart' ),
    'type'      => 'color',
    'choices'   => array(
    'alpha' => true,
),
    'default'   => '#2c97de',
    'transport' => 'auto',
    'output'    => array( array(
    'element'  => array( '.xt_woofc-no-touchevents .xt_woofc-inner a.xt_woofc-checkout:hover', '.xt_woofc-touchevents .xt_woofc-inner a.xt_woofc-checkout:focus' ),
    'property' => 'background',
) ),
);
$fields[] = array(
    'id'        => 'cart_checkout_button_text_color',
    'section'   => 'footer',
    'label'     => esc_html__( 'Cart Checkout Button Text Color', 'woo-floating-cart' ),
    'type'      => 'color',
    'default'   => '#ffffff',
    'transport' => 'auto',
    'output'    => array( array(
    'element'  => '.xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout, .xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout *',
    'property' => 'color',
) ),
);
$fields[] = array(
    'id'        => 'cart_checkout_button_text_hover_color',
    'section'   => 'footer',
    'label'     => esc_html__( 'Cart Checkout Button Text Hover Color', 'woo-floating-cart' ),
    'type'      => 'color',
    'default'   => '#ffffff',
    'transport' => 'auto',
    'output'    => array( array(
    'element'  => array(
    '.xt_woofc-no-touchevents .xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout:hover',
    '.xt_woofc-touchevents .xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout:focus',
    '.xt_woofc-touchevents .xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout:focus *',
    '.xt_woofc-touchevents .xt_woofc-cart-open .xt_woofc-inner a.xt_woofc-checkout:focus *'
),
    'property' => 'color',
) ),
);
$fields[] = array(
    'id'      => 'footer_features',
    'section' => 'footer',
    'type'    => 'xt-premium',
    'default' => array(
    'type'  => 'image',
    'value' => $this->core->plugin_url() . 'admin/customizer/assets/images/footer.png',
    'link'  => $this->core->plugin_upgrade_url(),
),
);