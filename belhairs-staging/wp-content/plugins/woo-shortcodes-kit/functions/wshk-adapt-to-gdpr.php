<?php



//Since v.1.6.8

/*ENABLE GPRD SETTINGS*/
//If you want adjust the function settings you need enable it.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_gprdsettings']) && $pluginOptionsVal['wshk_gprdsettings']==88)
{ 

$gprdurlslug = get_option('wshk_gprdurlslug');
$gprdiread = get_option('wshk_gprdiread');
$gprdpolit = get_option('wshk_gprdpolit');
$gprderror = get_option('wshk_gprderror');
$gprduserlegalinfo = get_option('wshk_gprduserlegalinfo');
$gprdcomveri = get_option('wshk_gprdcomveri');

}

//Since v.1.6.8

/*DISPLAY CHECKBOX IN WP COMMENTS*/
//If you want to show the GPRD checkbox in the comments form, just need activate this function.


global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_gprdcomments']) && $pluginOptionsVal['wshk_gprdcomments']==89)
{ 
//Since v.1.6.8
/*CHECKBOX*/

function wshk_custom_fields($fields) {


	// Multilingual strings
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
	$url = '/' . get_option('wshk_gprdurlslug'); /*get_permalink ( get_option( 'wpcpc_policy_page_id' ) );*/
	$read_and_accept =  get_option('wshk_gprdiread');//__( 'He leido y ACEPTO la ', 'wp-comment-policy-checkbox' );
	
	if (get_option('wshk_gprdireadcomments')!='') { 
     
     $readandcomments = get_option('wshk_gprdireadcomments');
     
 } else { 
     
     $readandcomments = get_option('wshk_gprdiread');
     
 }

    $fields[ 'policy' ] =
        '<p class="comment-form-policy">'.
            '<label for="policy">
                <input name="policy" value="policy-key" class="comment-form-policy__input" type="checkbox" style="width:auto"' . $aria_req . ' aria-req="true" />
                ' . $readandcomments . '
                <a href="' . esc_url( $url ) . '" target="_blank" class="comment-form-policy__see-more-link">' . __('Policy Privacy' , 'woo-shortcodes-kit') . '</a>
                <span class="comment-form-policy__required required">*</span>
            </label>
        </p>';

    return $fields;
}

add_filter('comment_form_default_fields', 'wshk_custom_fields');



//Since v.1.6.8
/*CHECKBOX VERIFICATOR*/

//javascript validation
add_action('wp_footer','wshk_validate_privacy_comment_javascript');
function wshk_validate_privacy_comment_javascript(){
    if (! is_user_logged_in() && is_single() && comments_open()){
        wp_enqueue_script('jquery');
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            $("#submit").click(function(e){
                if (!$('.comment-form-policy__input').prop('checked')){
                    e.preventDefault();
                    alert('You must agree to our privacy term by checking the box', 'woo-shortcodes-kit');
                    return false;
                }
            })
        });
        </script>
        <?php
    }
}

//Since v.1.6.8
/*LEGAL TEXT*/

add_action('comment_form_after','wshk_my_comment_form_before');
function wshk_my_comment_form_before() {
    
    
  if (! is_product() ) {
      
      $gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
    $gprdcomveri = get_option('wshk_gprdcomveri');
    
    $gprdcommentsbdsize = get_option('wshk_gprdcommentsbdsize');
    $gprdcommentsbdtype = get_option('wshk_gprdcommentsbdtype');
    $gprdcommentsbdcolor = get_option('wshk_gprdcommentsbdcolor');
    $gprdcommentsbdradius = get_option('wshk_gprdcommentsbdradius');
    $gprdcommentspadding = get_option('wshk_gprdcommentspadding');
    $gprdcommentsbgcolor = get_option('wshk_gprdcommentsbgcolor');
    
    
?>
  
  <div style="border: <?php echo $gprdcommentsbdsize ;?>px <?php echo $gprdcommentsbdtype ;?> <?php echo $gprdcommentsbdcolor ;?>;border-radius: <?php echo $gprdcommentsbdradius ;?>px;padding:<?php echo $gprdcommentspadding ;?>px;background-color:<?php echo $gprdcommentsbgcolor ;?>;margin-top: 20px;"><?php echo $gprdcomveri; ?>
  
<!--<h4 style="letter-spacing: 1px;"><span class="fa fa-info-circle"></span> Información relativa a los datos que proporcionas al dejar tu comentario</h4>

<p><strong>Responsable:</strong> Alberto Gómez Orta</p>

<p><strong>Finalidad:</strong> moderación de comentarios</p>

<p><strong>Legitimación:</strong> tu consentimiento, mediante marcación de botón.</p>

<p><strong>Destinatarios:</strong> servidores de Webempresa (actual hosting de esta web).</p>

<p><strong>Derechos:</strong> acceso, rectificación, limitación y/o supresión de tus datos.</p>--></div><br /><?php
}   
}



//Since v.1.6.8
/* COMMENTS VERIFICATION */
add_filter('comment_notification_text', 'wshk_my_comment_notification_text');
add_filter('comment_moderation_text', 'wshk_my_comment_notification_text');


function wshk_my_comment_notification_text($notify_message)
{
     $gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
    
    
return $notify_message . $gprduserlegalinfoo;
}


}




//Since v.1.6.8
/*DISPLAY CHECKBOX IN CHECKOUT PAGE */



global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_gprdorders']) && $pluginOptionsVal['wshk_gprdorders']==90)
{ 




add_action( 'woocommerce_review_order_before_submit', 'wshk_add_checkout_tickbox', 9 );
  
function wshk_add_checkout_tickbox() {
 $readandaccept = get_option('wshk_gprdiread');
 $urlpol = '/' . get_option('wshk_gprdurlslug');
 $pollink = __('Policy Privacy', 'woo-shortcodes-kit');
 
 if (get_option('wshk_gprdireadcheckout')!='') { 
     
     $readandcheckout = get_option('wshk_gprdireadcheckout');
     
 } else { 
     
     $readandcheckout = get_option('wshk_gprdiread');
     
 }
  
  if(! is_user_logged_in() ) {

?> 
<p class="form-row terms" style="font-size: 16px;">
  
  <input name="deliverycheck" id="deliverycheck" class="comment-form-policy__input" type="checkbox" required style="width:auto">
                <?php echo $readandcheckout ; ?>
                <a href="<?php echo $urlpol;  ?>" target="_blank" class="comment-form-policy__see-more-link"><?php echo $pollink ;?></a>
  

</p>
<?php
  } else { 
	?>
  
	<p class="form-row terms" style="display:none;">
  
  <input name="deliverycheck" id="deliverycheck" class="comment-form-policy__input" type="checkbox" required style="width:auto"checked>
                <?php echo $readandcheckout ; ?>
                <a href="<?php echo $urlpol; ?>" target="_blank" class="comment-form-policy__see-more-link"><?php echo $pollink ;?></a>
  

</p>
  <?php
  }

 
}
 
// Show notice if customer does not tick
  
add_action( 'woocommerce_checkout_process', 'wshk_not_approved_delivery' );
 
function wshk_not_approved_delivery() {
    if ( ! (int) isset( $_POST['deliverycheck'] ) ) {
        wc_add_notice( __( 'You must agree to our privacy term by checking the box', 'woo-shortcodes-kit'), 'error' );
    }
}







//Since v.1.6.8

/*ADD LEGAL TEXT IN CHECKOUT PAGE*/



add_action( 'woocommerce_review_order_after_submit', 'wshk_gprd_law_info_text', 9 );

function wshk_gprd_law_info_text()  {
$gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
$gprdordveri = get_option('wshk_gprdordveri');

$gprdcheckoutbdsize = get_option('wshk_gprdcheckoutbdsize');
$gprdcheckoutbdtype = get_option('wshk_gprdcheckoutbdtype');
$gprdcheckoutbdcolor = get_option('wshk_gprdcheckoutbdcolor');
$gprdcheckoutbdradius = get_option('wshk_gprdcheckoutbdradius');
$gprdcheckoutpadding = get_option('wshk_gprdcheckoutpadding');
$gprdcheckoutbgcolor = get_option('wshk_gprdcheckoutbgcolor');
?>
  <br />
  <br />
  <div style="border: <?php echo $gprdcheckoutbdsize; ?>px <?php echo $gprdcheckoutbdtype; ?> <?php echo $gprdcheckoutbdcolor; ?>;border-radius: <?php echo $gprdcheckoutbdradius; ?>px; padding: <?php echo $gprdcheckoutpadding; ?>px; background-color: <?php echo $gprdcheckoutbgcolor; ?>;">
      <?php echo $gprdordveri; ?>
      
<!--<h4 style="letter-spacing: 1px;font-size: 14px !important"><span class="fa fa-info-circle"></span> Información relativa a los datos que proporcionas al realizar tu pedido</h4>

<p><strong>Responsable:</strong> Alberto Gómez Orta</p>

<p><strong>Finalidad:</strong> realizar compra en tienda online</p>

<p><strong>Legitimación:</strong> tu consentimiento, mediante marcación de botón.</p>

<p><strong>Destinatarios:</strong> servidores de Webempresa (actual hosting de esta web).</p>

<p><strong>Derechos:</strong> acceso, rectificación, limitación y/o supresión de tus datos.</p>--></div><br /><?php
}





//Since v.1.6.8

/*ADD VERIFICATION IN EMAIL ORDER*/




add_action( 'woocommerce_email_customer_details', 'wshk_add_content_', 50, 4 ); 
function wshk_add_content_( $order, $sent_to_admin, $plain_text, $email ) {
    
    $gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
    
    
    if ( $sent_to_admin ) {
        echo $gprduserlegalinfoo;
    }
}


}





//Since v.1.6.8 - Updated v.1.7.9

/*DISPLAY THE CHECKBOX IN WOOCOMMERCE REVIEWS*/



global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_gprdreviews']) && $pluginOptionsVal['wshk_gprdreviews']=='91')
{ 
    $urlpoli = '/' . get_option('wshk_gprdurlslug');
    
//Since v.1.6.8

/*WC CHECKBOX*/

add_action('comment_form_after_fields','my_revie_form_after_fields');
function my_revie_form_after_fields() {
  $readandaccepto = get_option('wshk_gprdiread');
 $urlpoli = '/' . get_option('wshk_gprdurlslug');
 $polilink = __('Policy Privacy', 'woo-shortcodes-kit');
 
 if (get_option('wshk_gprdireadreviews')!='') { 
     
     $readandreviews = get_option('wshk_gprdireadreviews');
     
 } else { 
     
     $readandreviews = get_option('wshk_gprdiread');
     
 }
 
  if ( is_product() ) {
?>
  <p class="form-row terms" style="font-size: 12px;">
  
  <input name="deliverycheck" id="deliverycheck" class="comment-form-policy__input" type="checkbox" required style="width:auto">
                <?php echo $readandreviews ; ?>
                <a href="<?php echo $urlpoli;  ?>" target="_blank" class="comment-form-policy__see-more-link"><?php echo $polilink ;?></a>
  

</p>
  <?php
}   
}

//Since v.1.6.8

/*WC REVIEWS LEGAL TEXT*/

// define the woocommerce_review_after_comment_text callback 
function action_woocommerce_review_after_comment_text( $comment ) { 
    // make action magic happen here... 
  $gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
  $gprdrewveri = get_option('wshk_gprdrewveri');
  
  
$gprdreviewsbdsize = get_option('wshk_gprdreviewsbdsize');
$gprdreviewsbdtype = get_option('wshk_gprdreviewsbdtype');
$gprdreviewsbdcolor = get_option('wshk_gprdreviewsbdcolor');
$gprdreviewsbdradius = get_option('wshk_gprdreviewsbdradius');
$gprdreviewspadding = get_option('wshk_gprdreviewspadding');
$gprdreviewsbgcolor = get_option('wshk_gprdreviewsbgcolor');
  
  
  if ( is_product() ) {
  ?>
	
	<br />
  <div style="border: <?php echo $gprdreviewsbdsize;?>px <?php echo $gprdreviewsbdtype;?> <?php echo $gprdreviewsbdcolor;?>;border-radius: <?php echo $gprdreviewsbdradius;?>px;padding:<?php echo $gprdreviewspadding;?>px;background-color:<?php echo $gprdreviewsbgcolor;?>;">
      <?php echo $gprdrewveri;?>
<!--<h4 style="letter-spacing: 1px;"><span class="fa fa-info-circle"></span> Información relativa a los datos que proporcionas al dejar tu valoración</h4>

<p><strong>Responsable:</strong> Alberto Gómez Orta</p>

<p><strong>Finalidad:</strong> moderación de valoraciones</p>

<p><strong>Legitimación:</strong> tu consentimiento, mediante marcación de botón.</p>

<p><strong>Destinatarios:</strong> servidores de Webempresa (actual hosting de esta web).</p>

<p><strong>Derechos:</strong> acceso, rectificación, limitación y/o supresión de tus datos.</p>--></div><br />
	
	<?php
	
  }
}; 
         
// add the action 
add_action( 'comment_form_after', 'action_woocommerce_review_after_comment_text', 50, 4 ); 


}




//Since v.1.6.8


/*WC REGISTER CHECKBOX*/



global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_gprdwcregisterform']) && $pluginOptionsVal['wshk_gprdwcregisterform']=='9292')
{ 



add_action( 'woocommerce_register_form', 'wshk_add_registration_privacy_policy', 11 );
   
function wshk_add_registration_privacy_policy() {
    
    $readandaccepto = get_option('wshk_gprdiread');
 $urlpoli = '/' . get_option('wshk_gprdurlslug');
 $polilink = __('Policy Privacy', 'woo-shortcodes-kit');
 
 
 if (get_option('wshk_gprdireadregister')!='') { 
     
     $readandregister = get_option('wshk_gprdireadregister');
     
 } else { 
     
     $readandregister = get_option('wshk_gprdiread');
     
 }
 
woocommerce_form_field( 'privacy_policy_reg', array(
    'type'          => 'checkbox',
    'class'         => array('form-row privacy'),
    'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
    'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
    'required'      => true,
    'label'         => $readandregister . ' <a href="' . $urlpoli . '" target="_blank">' . $polilink . '</a>',
));
  
}


  
// Show error if user does not tick
   
add_filter( 'woocommerce_registration_errors', 'wshk_validate_privacy_registration', 10, 3 );
  
function wshk_validate_privacy_registration( $errors, $username, $email ) {
if ( ! is_checkout() ) {
    if ( ! (int) isset( $_POST['privacy_policy_reg'] ) ) {
        $errors->add( 'privacy_policy_reg_error', __( 'You must agree to our privacy term by checking the box', 'woo-shortcodes-kit') );
    }
}
return $errors;
}

//}


//Since v.1.6.8

/*WC REGISTER FORM LEGAL TEXT*/

// define the woocommerce_review_after_comment_text callback 
function action_woocommerce_register_form() { 
    // make action magic happen here... 
  
  $gprdregveri = get_option('wshk_gprdregveri');
  
  
  
$gprdregisterbdsize = get_option('wshk_gprdregisterbdsize');
$gprdregisterbdtype = get_option('wshk_gprdregisterbdtype');
$gprdregisterbdcolor = get_option('wshk_gprdregisterbdcolor');
$gprdregisterbdradius = get_option('wshk_gprdregisterbdradius');
$gprdregisterpadding = get_option('wshk_gprdregisterpadding');
$gprdregisterbgcolor = get_option('wshk_gprdregisterbgcolor');
  
  ?>
	
	<br />
  <div style="border: <?php echo $gprdregisterbdsize;?>px <?php echo $gprdregisterbdtype;?> <?php echo $gprdregisterbdcolor;?>;border-radius: <?php echo $gprdregisterbdradius;?>px;padding: <?php echo $gprdregisterpadding;?>px;background-color:<?php echo $gprdregisterbgcolor;?>;">
      <?php echo $gprdregveri;?></div><br />
	
	<?php
	
  
}; 
         
// add the action 


add_action( 'woocommerce_register_form_end', 'action_woocommerce_register_form', 12 );





//Since v.1.6.8

/*SEND CUSTOM ADMIN EMAIL IF SOME USER MAKE A ACCOUNT @ REGISTER FORM VALIDATION*/

function wshk_customer_registration_email_alert( $user_id ) {
    
    $gprduserlegalinfoo = get_option('wshk_gprduserlegalinfo');
    $user    = get_userdata( $user_id );
    $first_name = null;
    $last_name = null;
    $role = $user->roles;
    $email   = $user->user_email;
    $miasunto = __('New Customer Registration', 'woo-shortcodes-kit');
    $admiemail = get_option( 'admin_email' );
   
    if ( isset( $_POST['billing_first_name'] ) ) {
        $first_name = $_POST['billing_first_name'];
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        $last_name = $_POST['billing_last_name'];
    }
    $message = sprintf( __('Rejoice someone loves us! 
    A new customer %1$s %2$s with the email %3$s has registered.
    
    ', 'woo-shortcodes-kit' ), $first_name, $last_name, $email ) . $gprduserlegalinfoo ;
    
    
   
    // If new account doesn't have the 'customer' role don't do anything.
    if( !in_array( 'customer', $role ) ) {
        return;
    }
    wp_mail( $admiemail , $miasunto , $message );
    
    
}
add_action( 'user_register', 'wshk_customer_registration_email_alert' );



}




//Since v.1.6.8
/*ALTERNATIVE FOR WOOCOMMERCE TERMS AND CONDITIONS IN CHECKOUT PAGE*/




global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_wcnewtermsbox']) && $pluginOptionsVal['wshk_wcnewtermsbox']==94)
{ 




add_action( 'woocommerce_review_order_before_submit', 'wshk_add_checkout_privacy_policy', 9 );
   
function wshk_add_checkout_privacy_policy() {
  $termstexto = get_option('wshk_termstexto');
  $termslink = '/' . get_option('wshk_termslink');
  $termstextlink = get_option('wshk_termstextlink');
woocommerce_form_field( 'privacy_policy', array(
    'type'          => 'checkbox',
    'class'         => array('form-row privacy'),
    'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
    'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
    'required'      => true,
    'label'         => $termstexto . ' <a href="' . $termslink .'" target="_blank">' . $termstextlink . '</a>',
)); 
  
}
  
// Show notice if customer does not tick
   
add_action( 'woocommerce_checkout_process', 'wshk_not_approved_privacy' );
  
function wshk_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'You must accept the web conditions to continue', 'woo-shortcodes-kit' ), 'error' );
    }
}
 
}



?>