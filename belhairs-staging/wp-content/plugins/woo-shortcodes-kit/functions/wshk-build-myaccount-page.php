<?php



//Since v.1.6.6

/*SHOW THE ORDERS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_myorders]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enableorderscontrol']) && $pluginOptionsVal['wshk_enableorderscontrol']==140)
{


function wshk_newstyle_myorders() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    
   
    if (  is_user_logged_in() && ( is_account_page() ) ) {
ob_start();
if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
            
            require ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/mytemplates/my-orders.php';
        } else {
    require dirname( __DIR__ ) . '/mytemplates/my-orders.php'; }
    
    
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.
        if ( 'edit-address' === $key ) {
          continue;
        }
        
        if ( 'add-payment-method' === $key ) {
          continue;
        }
        
        //Since v.1.8.2
if(isset($pluginOptionsVal['wshk_enablesubscriptionshortcode']) && $pluginOptionsVal['wshk_enablesubscriptionshortcode']==3003)
{
        
        if ( 'view-subscription' === $key ) {
          continue;

        } //Activar solo si se usa el shortcode
}
        
        if ( 'payment-methods' === $key ) {
          continue;
        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          return ob_get_clean();
          
        }
      }
    }

    // No endpoint found? Default to dashboard.
    /*wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
    return ob_get_clean();
} 
}
add_shortcode ('woo_myorders', 'wshk_newstyle_myorders');

//Sustituir plantilla del tema por la del plugin
add_filter( 'wc_get_template', 'wshk_cma_get_templatee', 10, 5 );
function wshk_cma_get_templatee( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'myaccount/view-order.php' == $template_name ) {
        $located = plugin_dir_path( __DIR__ ) . '/mytemplates/view-order.php';
    }
    
    return $located;
}

}




//Since v.1.6.6

/*SHOW THE DOWNLOADS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_mydownloads]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enablemydownloadsht']) && $pluginOptionsVal['wshk_enablemydownloadsht']==2000)
{

function wshk_newstyle_mydownloads() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();

    require dirname( __DIR__ ) . '/mytemplates/downloads.php';
    return ob_get_clean();
}
}
add_shortcode ('woo_mydownloads', 'wshk_newstyle_mydownloads');

//Sustituir plantilla del tema por la del plugin

function wshk_order_downloads_get_template( $located, $template_name, $args, $template_path, $default_path ) {   
        
    if ( 'order/order-downloads.php' == $template_name ) {
        $located = plugin_dir_path( __DIR__ ) . '/mytemplates/order-downloads.php';
    }
    
    return $located;
    
}
add_filter( 'wc_get_template', 'wshk_order_downloads_get_template', 10, 5 );
}




//Since v.1.6.6

/*SHOW THE ADDRESSES*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_myaddress]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enablemyaddressessht']) && $pluginOptionsVal['wshk_enablemyaddressessht']==2001)
{

function wshk_newstyle_myaddress() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    
    if (  is_user_logged_in() && ( is_account_page() ) ) {
    ob_start();    
     if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
            
            require ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/mytemplates/my-address.php';
        } else {
    require dirname( __DIR__ ) . '/mytemplates/my-address.php'; }   
    
    
    
    
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.
        if ( 'view-order' === $key ) {
          continue;
        }
        
        if ( 'add-payment-method' === $key ) {
          continue;
        }
        
        if ( 'view-subscription' === $key ) {
          continue;

        }
        
        if ( 'payment-methods' === $key ) {
          continue;
        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
          
          //ob_start();
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          //return ob_get_clean();
          
        }
      }
    }

    // No endpoint found? Default to dashboard.
   /* wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
return ob_get_clean();    
}

}

add_shortcode ('woo_myaddress', 'wshk_newstyle_myaddress');

//Sustituir plantilla del tema por la del plugin

function wshk_cma_get_template( $located, $template_name, $args, $template_path, $default_path ) {   
        
    if ( 'myaccount/form-edit-address.php' == $template_name ) {
        $located = plugin_dir_path( __DIR__ ) . '/mytemplates/form-edit-address.php';
    }
    
    return $located;
    
}

/*Since 1.8.7*/
add_filter( 'wc_get_template', 'wshk_cma_get_template', 10, 5 );

/*add_action( 'woocommerce_save_account_details_errors', 'account_validation_unique_error', 9999 ); // Details
add_action( 'woocommerce_after_save_address_validation', 'account_validation_unique_error', 9999 ); // Adresses
function account_validation_unique_error(){
    $notices = WC()->session->get( 'wc_notices' ); // Get Woocommerce notices from session

    // if any validation errors
    if( $notices && isset( $notices['error'] ) ) {

        // remove all of them
        //WC()->session->__unset( 'wc_notices' );

        // Add one custom one instead
        //wc_add_notice( __( 'Please fill in all required fields.', 'woo-shortcodes-kit' ), 'error' );
    }
}*/
/*end*/

}







//Since v.1.6.6

/*SHOW THE PAYMENTS METHODS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_mypayments]


//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enablemypaymentsht']) && $pluginOptionsVal['wshk_enablemypaymentsht']==2002)
{


function wshk_newstyle_mypayment() {
    
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();
        if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
            
            require ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/mytemplates/payment-methods.php';
        } else {
    require dirname( __DIR__ ) . '/mytemplates/payment-methods.php'; }
    ?>
   <br /><br /><br /><br /><?php
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
        
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.

        if ( 'edit-address' === $key ) {
          continue;

        }
        
        if ( 'view-order' === $key ) {
          continue;

        }
        
        if ( 'view-subscription' === $key ) {
          continue;

        }
        
        if ( 'payment-methods' === $key ) {
          continue;

        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
            //ob_start();
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          return ob_get_clean();
          
          
        }
      }
      
    }

    // No endpoint found? Default to dashboard.
   /* wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
    return ob_get_clean();
    }
}
add_shortcode ('woo_mypayment', 'wshk_newstyle_mypayment');


}





//Since v.1.6.6

/*SHOW THE EDIT ACCOUNT*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enablemyeditaccsht']) && $pluginOptionsVal['wshk_enablemyeditaccsht']==2003)
{

function wshk_newstyle_myeditaccount() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
    ob_start();
    require dirname( __DIR__ ) . '/mytemplates/form-edit-account.php';
    return ob_get_clean();
}
}
add_shortcode ('woo_myedit_account', 'wshk_newstyle_myeditaccount');
}






//Since v.1.6.6

/*SHOW THE DASHBOARD*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_mydashboard]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enabledashbsht']) && $pluginOptionsVal['wshk_enabledashbsht']==2004)
{



function wshk_newstyle_mydashboard() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();
    require dirname( __DIR__ ) . '/mytemplates/dashboard.php';
    return ob_get_clean();
    }
}
add_shortcode ('woo_mydashboard', 'wshk_newstyle_mydashboard');
}



//Since v.1.5 -Updated v.1.8.0

/*SHOW GRAVATAR USER IMAGE*/
//Display the user's Gravatar image, if you want show the Gravata'r image in any page or post, use this shortcode [woo_gravatar_image]

//Can control the image style: size, shadow, border (size,type,color,radius)

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/


if(isset($pluginOptionsVal['wshk_enablegravatar']) && $pluginOptionsVal['wshk_enablegravatar']==15)
{

function wshk_gravatar_image(){
$textgravasize = get_option('wshk_textgravasize');
$textgravashd = get_option('wshk_textgravashd');
$textgravabdsz = get_option('wshk_textgravabdsz');
$textgravabdtp = get_option('wshk_textgravabdtp');
$textgravabdcl = get_option('wshk_textgravabdcl');
$textgravabdrd = get_option('wshk_textgravabdrd');

$user_id = get_current_user_id();

ob_start();
$id_or_email = wp_get_current_user();

//Since v.1.7.9
//Updated styles compatibility with builders

echo '<style> img.avatar.avatar-'.$textgravasize.'.photo { height: '.$textgravasize.'px;
  width: '.$textgravasize.'px;
  border: '.$textgravabdsz.'px '.$textgravabdtp.' '.$textgravabdcl.' !important;  
  border-radius: '.$textgravabdrd.'% !important;
  box-shadow: '.$textgravashd.';
  overflow: hidden;
  margin: auto;}</style>';
echo get_avatar( $id_or_email, $textgravasize, '', '', '' );
return ob_get_clean();
}
}
add_shortcode( 'woo_gravatar_image', 'wshk_gravatar_image' );





//Since v.1.5

/*SHOW THE USERNAME*/
//If you are building your own myaccount page, maybe need this function to get the username. Just need activate and use this shortcode: [woo_user_name]


  /*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableusername']) && $pluginOptionsVal['wshk_enableusername']==11)
{
    
    add_shortcode('woo_user_name', 'wshk_get_user');
function wshk_get_user() {
ob_start();
	if ( is_user_logged_in()) {
$usernmtc = get_option('wshk_usernmtc');
$usernmts = get_option('wshk_usernmts');
$usernmta = get_option('wshk_usernmta');
$textusernmpf = get_option('wshk_textusernmpf');
$textusernmsf = get_option('wshk_textusernmsf');
		$user = wp_get_current_user();
		
		//CONDITION TO CHANGE THE SHORTCODE DISPLAY FUNCTION

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_showusername']) && $pluginOptionsVal['wshk_showusername']=='showus')
{
    echo '<p style="color:' . ' ' . $usernmtc . '; text-align:' . ' ' . $usernmta . '; font-size:' . ' ' . $usernmts . 'px;">' . $textusernmpf . ' ' . $user->user_login . ' ' . $textusernmsf . '</p>';
    
} else if (isset($pluginOptionsVal['wshk_showusername']) && $pluginOptionsVal['wshk_showusername']=='showonly') 

{
    
    echo '<p style="color:' . ' ' . $usernmtc . '; text-align:' . ' ' . $usernmta . '; font-size:' . ' ' . $usernmts . 'px;">' . $textusernmpf . ' ' . $user->user_firstname . ' ' . $textusernmsf . '</p>';
    
} else {

   echo '<p style="color:' . ' ' . $usernmtc . '; text-align:' . ' ' . $usernmta . '; font-size:' . ' ' . $usernmts . 'px;">' . $textusernmpf . ' ' . $user->display_name . ' ' . $textusernmsf . '</p>';
    
}
		
		
		/*echo '<p style="color:' . ' ' . $usernmtc . '; text-align:' . ' ' . $usernmta . '; font-size:' . ' ' . $usernmts . 'px;">' . $textusernmpf . ' ' . $user->display_name . ' ' . $textusernmsf . '</p>';*/
		
		return ob_get_clean();
	}
}
}






//Since v.1.5

/*SHOW LOGOUT BUTTON*/
//If you are building your own myaccount page, you will need this function to let the user make a logout. Just need activate and use this shortcode: [woo_logout_button]


 /*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enablelogoutbtn']) && $pluginOptionsVal['wshk_enablelogoutbtn']==12)
{

add_shortcode ('woo_logout_button', 'wshk_logout_button');
function wshk_logout_button() {    
    
if ( is_user_logged_in() && ( is_account_page() ) ) {
$logbtnbdsize = get_option('wshk_logbtnbdsize');
$logbtnbdradius = get_option('wshk_logbtnbdradius');
$logbtnbdtype = get_option('wshk_logbtnbdtype');
$logbtnbdcolor = get_option('wshk_logbtnbdcolor');
$logbtntext = get_option('wshk_logbtntext');
$logbtntd = get_option('wshk_logbtntd');
$logbtnta = get_option('wshk_logbtnta');
$logbtnwd = get_option('wshk_logbtnwd');



//the get page id myaccount can be changed for shop to redirect after logout to the shop page
ob_start();
print '<a class="woocommerce-Button button wshkclose" style="border:' . ' ' . $logbtnbdsize . 'px' . ' ' . $logbtnbdtype . ' ' . $logbtnbdcolor . '; border-radius:' . ' ' . $logbtnbdradius . 'px; text-decoration:' . ' ' . $logbtntd . '; margin: 0 auto;  text-align:' . ' ' . $logbtnta . '; display:block; width:' . ' ' . $logbtnwd . 'px;" href="' . wp_logout_url( get_permalink( wc_get_page_id( "myaccount" ) ) ) . '">' . ' ' . $logbtntext . ' ' . '</a>';

return ob_get_clean();
}

}


//Since 1.6.6
/*Redirect after logout to a custom page*/

function wshk_custom_logout_redirect() {
    
    /*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablelogoutbtn']) && $pluginOptionsVal['wshk_enablelogoutbtn']==12)
{*/
    
    $clogpage = get_option( 'wshk_btnlogoutredi' );
    $baselink = home_url( '/' . $clogpage );
    if (!empty ($clogpage)) {
        wp_redirect($baselink);
        exit();
    }
    
}
//}
add_action('wp_logout', 'wshk_custom_logout_redirect', PHP_INT_MAX);
}





//Since v.1.5 - Updated v.1.8.0

/*SHOW THE LOGIN & REGISTER FORM*/
//If you are building your own myaccount page, you need use this function to display the login/register form. Just need use this shortcode [woo_login_form]
/* global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableloginform']) && $pluginOptionsVal['wshk_enableloginform']==13)
{
add_shortcode ('woo_login_form', 'wshk_login_form');
function wshk_login_form() {


if ( ! is_user_logged_in() ) {
        //ob_start();
         return do_shortcode( '[woocommerce_my_account]' );
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
   //return get_ob_clean();
     
        
     /*OLD method*/
//wc_get_template( 'myaccount/form-lost-password.php' ); /*OLD method*/
//wc_get_template( 'myaccount/form-reset-password.php' ); /*OLD method*/
//require dirname( __FILE__ ) . '/mytemplates/login.php';
//echo wp_login_form();


} 
}

//Sustituir plantilla del tema por la del plugin
add_filter( 'wc_get_template', 'wshk_logma_get_templatee', 10, 5 );
function wshk_logma_get_templatee( $located, $template_name, $args, $template_path, $default_path ) {    
    $theme = get_current_theme(); // gets the current theme

    if ( 'myaccount/form-login.php' == $template_name ) {
        $located = plugin_dir_path( __DIR__ ) . '/mytemplates/form-login.php';
        
    } elseif($theme = get_option( 'Storefront' ) ) {
        
        $located = do_shortcode('[woocommerce_my_account]');
    }
    
    return $located;

}

//Since v.1.5 - Updated v.1.8.9
//Redirect users to custom URL based on their role after login
function wshk_custom_user_redirect( $redirect, $user ) {


	// Get the first of all the roles assigned to the user
	$loginredi = get_option('wshk_loginredi');
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = home_url( '/' . $loginredi );
	$wshk_checkouturl = get_permalink( get_option( 'woocommerce_checkout_page_id' ) );
	
	
	if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		//$redirect = $dashboard;
		$redirect = $myaccount;
	} elseif ( $role == 'shop-manager' ) {
		//Redirect shop managers to the dashboard
		//$redirect = $dashboard;
		$redirect = $myaccount;
	} elseif ( $role == 'editor' ) {
		//Redirect editors to the dashboard
		//$redirect = $dashboard;
		$redirect = $myaccount;
	} elseif ( $role == 'author' ) {
		//Redirect authors to the dashboard
		//$redirect = $dashboard;
		$redirect = $myaccount;
	} elseif ( WC()->cart->is_empty() or is_account_page() && $role == 'customer' || $role == 'subscriber' ) {
	    //$redirect = $mytestreditest;
	    $redirect = $myaccount;
	    //$redirect = $wshkurl;
	} else {
	    
		//Redirect any other role to the previous visited page or, if not available, to the home
		//$redirect = wp_get_referer() ? wp_get_referer() : home_url();
		//$redirect = $myaccount;
		$redirect = $wshk_checkouturl;
	}
	return $redirect;

}

add_filter( 'woocommerce_login_redirect', 'wshk_custom_user_redirect', 10, 2 );

}





//Since v.1.5 - Updated in v.1.8.0

/*SHOW COMMENTS BY A USER (Only products)*/
//Display all the products reviews made by a user with just a shortcode, If you want display in any page or post, use this shortcode [woo_review_products]

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enablereviews']) && $pluginOptionsVal['wshk_enablereviews']==9)
{

function wshk_show_reviews_by_user(){
    
     
    ob_start();
    
    
$user_id = get_current_user_id();




$acreviews =  get_option('wshk_enablereviews');
$textavsize =  get_option('wshk_textavsize');
$textavbdsize = get_option('wshk_textavbdsize');
$textavbdradius = get_option('wshk_textavbdradius');
$textavbdtype = get_option('wshk_textavbdtype');
$textavbdcolor = get_option('wshk_textavbdcolor');
$texttbwsize = get_option('wshk_texttbwsize');
$textbxfsize =  get_option('wshk_textbxfsize');
$textbxbdsize = get_option('wshk_textbxbdsize');
$textbxbdradius = get_option('wshk_textbxbdradius');
$textbxbdtype = get_option('wshk_textbxbdtype');
$textbxbdcolor = get_option('wshk_textbxbdcolor');
$textbxbgcolor = get_option('wshk_textbxbgcolor');
$textbtnbdsize = get_option('wshk_textbtnbdsize');
$textbtnbdradius = get_option('wshk_textbtnbdradius');
$textbtnbdtype = get_option('wshk_textbtnbdtype');
$textbtnbdcolor = get_option('wshk_textbtnbdcolor');
$textbtntarget = get_option('wshk_textbtntarget');
$textbtntxd = get_option('wshk_textbtntxd');
$textbxpadding = get_option('wshk_textbxpadding');
$textbtntxt = get_option('wshk_textbtntxt');
$avshadow = get_option('wshk_avshadow');
    
    
    $id_or_email = get_current_user_id();
$numbrevdis = get_option('wshk_numbrevdis');
$count = 0;
$html_r = "";
$title="";
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$number = $numbrevdis ; 
$tesunoo = '1'; //updated v.1.7.3
// all for show all the comments, for other quantity just write the number 1,2,3,4...
$offset = ( $paged - $tesunoo ) * $number; //updated v.1.7.3

global $product;
global $comment;
$args = array(
	'user_id' => $user_id, // get the user by ID
	'post_type' => 'product',
	'number' => $number,
    'offset' => $offset,
    'paged' => $paged,
	'post_ID' =>$product,  // Product Id  
	'meta_key' => '',
	'meta_value' => '',
	'status' => "approve", // Status you can also use 'hold', 'spam', 'trash'
);

$acreviews =  get_option('wshk_enablereviews');
$textavsize =  get_option('wshk_textavsize');
$textavbdsize = get_option('wshk_textavbdsize');
$textavbdradius = get_option('wshk_textavbdradius');
$textavbdtype = get_option('wshk_textavbdtype');
$textavbdcolor = get_option('wshk_textavbdcolor');
$texttbwsize = get_option('wshk_texttbwsize');
$textbxfsize =  get_option('wshk_textbxfsize');
$textbxbdsize = get_option('wshk_textbxbdsize');
$textbxbdradius = get_option('wshk_textbxbdradius');
$textbxbdtype = get_option('wshk_textbxbdtype');
$textbxbdcolor = get_option('wshk_textbxbdcolor');
$textbxbgcolor = get_option('wshk_textbxbgcolor');
$textbtnbdsize = get_option('wshk_textbtnbdsize');
$textbtnbdradius = get_option('wshk_textbtnbdradius');
$textbtnbdtype = get_option('wshk_textbtnbdtype');
$textbtnbdcolor = get_option('wshk_textbtnbdcolor');
$textbtntarget = get_option('wshk_textbtntarget');
$textbtntxd = get_option('wshk_textbtntxd');
$textbxpadding = get_option('wshk_textbxpadding');
$textbtntxt = get_option('wshk_textbtntxt');
$avshadow = get_option('wshk_avshadow');
    
$gravatar = get_avatar( $id_or_email, $textavsize) . ' ';
$url = get_option( 'siteurl' );
$comments = get_comments($args);
if (!empty ($comments)){
foreach($comments as $comment) :
?>
<style>
.mcon-image-container {
  height: <?php echo $textavsize ?>px !important;
  width: <?php echo $textavsize ?>px !important;
  border: <?php echo $textavbdsize ?>px <?php echo $textavbdtype ?> <?php echo $textavbdcolor ?> !important;  
  border-radius: <?php echo $textavbdradius ?>% !important;
  box-shadow: <?php echo $avshadow ?>;
    overflow: hidden;  
}


/*star rating for products*/
.wshkdiv.product .woocommerce-product-rating {
    margin-bottom: 1.618em;
}

.wshk.woocommerce-product-rating .star-rating {
    margin: .5em 4px 0 0;
    float: left;
}

.wshk.woocommerce-product-rating::after, .wshk.woocommerce-product-rating::before {

    content: ' ';
    display: table;

}

.wshk.woocommerce-product-rating {
    line-height: 2;
}

.wshk.star-rating {
    float: right;
    overflow: hidden;
    position: relative;
    height: 1em;
    line-height: 1;
    font-size: 1em;
    width: 5.4em;
    font-family: star;
    /*color:yellow;*/
}

.wshk.star-rating::before {
    content: '\73\73\73\73\73';
    /*color: #d3ced2;*/
    float: left;
    top: 0;
    left: 0;
    position: absolute;
}

.wshk.star-rating {
    line-height: 1;
    font-size: 1em;
    font-family: star;
}

.wshk.star-rating span {
    overflow: hidden;
    float: left;
    top: 0;
    left: 0;
    position: absolute;
    padding-top: 1.5em;
}

.wshk.star-rating span::before {
    content: '\53\53\53\53\53';
    top: 0;
    position: absolute;
    left: 0;
}

.wshk.star-rating span {

    overflow: hidden;
    float: left;
    top: 0;
    left: 0;
    position: absolute;
    padding-top: 1.5em;

}

.wshk.star-rating {
    
    /*float:right;*/
}

ul.userreviewswshk {
    
    margin: 0px !important;
}

div.wshkreviewbox {
    
    padding-left:25px;
}

th.wshktableth {
    
    background-color:transparent;
}
</style>
<?php

//Detect Storefront, GeneratePress themes

$wshk_storefront_my_theme = wp_get_theme( 'storefront' );
$wshk_generatepress_my_theme = wp_get_theme( 'generatepress' );
$wshk_hello_my_theme = wp_get_theme( 'hello-elementor' );
$wshk_theseven_my_theme = wp_get_theme( 'dt-the7' );
if ( $wshk_storefront_my_theme->exists() ) {
    
    $commentstablink = 'tab-reviews';
    
} else if ( $wshk_generatepress_my_theme->exists() ) {
    
    $commentstablink = 'tab-reviews';
    
} else if ( $wshk_hello_my_theme->exists() ) {
    
    $commentstablink = 'tab-reviews';
    
} else if ( $wshk_hello_my_theme->exists() ) {
    
    $commentstablink = 'comments';
    
} else {
    
    $commentstablink = 'tab-reviews';
}

$product = wc_get_product( $comment->comment_post_ID );
$teprodu = $product->get_name();
$tspermalink = get_permalink($comment->comment_post_ID);
//Updated - v.1.7.9
echo('<div class="wshkreviewcontainer" style="background:' .$textbxbgcolor . '; font-size:' . $textbxfsize . 'px; border:' . $textbxbdsize . 'px' . ' ' . $textbxbdtype . ' ' . $textbxbdcolor . '; border-radius:' . $textbxbdradius . 'px; padding:' . $textbxpadding . 'px;">' . '<ul class="userreviewswshk"><table><tr><th class="wshktableth" style="width:' . $texttbwsize . 'px;"><div class="mcon-image-container">' . $gravatar . '</div></th><th class="wshktableth">' . '<div class="wshk star-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span style="width:' . ( get_comment_meta( $comment->comment_ID, 'rating', true ) / 5 ) * 100 . '%"><strong itemprop="ratingValue">' . get_comment_meta( $comment->comment_ID, 'rating', true ) . '</strong></span></div><a href="' . $tspermalink . '#comment-' . (strval($comment->comment_ID)) . '" target="' .$textbtntarget . '">' . $teprodu . '</a><br /><strong>' . $comment->comment_author . '</strong><br /><small>' . get_comment_date( '', $comment) . '</small></th></tr></table><div class="wshkreviewbox">' . $comment->comment_content . '</div><br /><br />' . '<div class="wshkproductbuttonlink"><a class="woocommerce-Button button wshkcomment" target="' .$textbtntarget . '" style="border:' . $textbtnbdsize . 'px' . ' ' . $textbtnbdtype . ' ' . $textbtnbdcolor . '; border-radius:' . $textbtnbdradius . 'px; text-decoration:' . $textbtntxd . ';" href="' . $tspermalink . '#comment-' . (strval($comment->comment_ID)) . '">' . $textbtntxt . '</a></div>' . '</ul>' . '</div>' . '<br />');


endforeach;
} else {
   
    
    
    
    
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
    if( isset($pluginOptionsVal['wshk_enableacustomshopage']) && $pluginOptionsVal['wshk_enableacustomshopage']==85)
{
    $tesprue = sprintf( __( 'No reviews has been made yet.', 'woo-shortcodes-kit' ) );
    
    $tesbuton = sprintf( __( 'Make your first review', 'woo-shortcodes-kit' ) );
    $mycustomshopurl = get_option('wshk_shopageslug');
    $miurl = get_option( 'siteurl' );
	//return $miurl. '/' .$mycustomshopurl;
        echo '
    <div class="woocommerce-Message woocommerce-Message--info woocommerce-info test">
    '. $tesprue . '
		<a class="woocommerce-Button button" href="' . $miurl. '/' .$mycustomshopurl . '">' . $tesbuton . '</a><br />
		
	</div>
    
    ';
    
    
   } else {
       
        $mbaselink = wc_get_page_permalink( 'shop' );
    //$linksh = wc_get_page_permalink( 'shop' );
    $tesprue = sprintf( __( 'No reviews has been made yet.', 'woo-shortcodes-kit' ) );
    
    $tesbuton = sprintf( __( 'Make your first review', 'woo-shortcodes-kit' ) );
       
         echo '
    <div class="woocommerce-Message woocommerce-Message--info woocommerce-info test">
    '. $tesprue . '
		<a class="woocommerce-Button button" href="' . $mbaselink . '">' . $tesbuton . '</a><br />
		
	</div>
    
    ';
        
    }
    
    
    
    
    
    
}
return ob_get_clean();
}
}
add_shortcode( 'woo_review_products', 'wshk_show_reviews_by_user' );





//Since v.1.6.8

/*DISPLAY IP ADDRESS*/
// If you want to show the user IP address in any page, just use this shortcode [woo_display_ip]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enabletheipsht']) && $pluginOptionsVal['wshk_enabletheipsht']==2005)
{

function wshk_display_user_ip() {
        $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
}
add_shortcode('woo_display_ip', 'wshk_display_user_ip');
}



//Since v.1.6.8

/*DISPLAY USER NAME AND SURNAME*/
// If you want to show the user name and surname, just use this shortcode [woo_display_nsurname]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enablethenamesurnsht']) && $pluginOptionsVal['wshk_enablethenamesurnsht']==2006)
{


function wshk_displayuserapell_short(){
    
    $theuserapell = wp_get_current_user();
  
  
    return $theuserapell->first_name . " " . $theuserapell->last_name . "\n";
    
}

add_shortcode( 'woo_display_nsurname' , 'wshk_displayuserapell_short' );

}


//Since v.1.6.8

/*DISPLAY USER EMAIL*/
// If you want to show the user email, just use this shortcode [woo_display_email]

//Since v.1.7.8
if(isset($pluginOptionsVal['wshk_enabletheuseremailsht']) && $pluginOptionsVal['wshk_enabletheuseremailsht']==2007)
{

function wshk_displayemail_on_menu(){
    
    $theeuser = wp_get_current_user();
    return $theeuser->user_email;
    
}

add_shortcode( 'woo_display_email' , 'wshk_displayemail_on_menu' );
}




?>