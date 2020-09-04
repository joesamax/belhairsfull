<?php 

/* TOTAL SHOP SALES COUNTER */

// If you want to show the global orders/downloads counter on any page or post, use this Shortcode: [woo_global_sales]

// It will display the total of the orders with status: completed, on-hold and processing

// It will subtract the refunded orders from the total

if(isset($pluginOptionsVal['wshk_enablethetotsalessht']) && $pluginOptionsVal['wshk_enablethetotsalessht']==2008)
{

function wshk_my_global_sales() {

global $wpdb;

$order_totals = apply_filters( 'woocommerce_reports_sales_overview_order_totals', $wpdb->get_row( "

SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts

LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id

WHERE meta.meta_key = '_order_total'

AND posts.post_type = 'shop_order'

AND posts.post_status IN ( '" . implode( "','", array( 'wc-completed', 'wc-processing', 'wc-on-hold' ) ) . "' )

" ) );
ob_start();
return absint( $order_totals->total_orders).ob_get_clean();

}
add_shortcode('woo_global_sales', 'wshk_my_global_sales');
}




/*WOO TOTAL SALES AMOUNT COUNTER*/

// If you want to show the total shop sales amount counter on any page or post, use this Shortcode: [woo_total_amount]

// It will display the total of the orders with status: completed, on-hold and processing


//Since 1.8.4

if(isset($pluginOptionsVal['wshk_enablethetotsalesamount']) && $pluginOptionsVal['wshk_enablethetotsalesamount']==18401)
{

function wshk_get_total_sales() {

	    global $wpdb;

	    $order_totals = apply_filters( 'woocommerce_reports_sales_overview_order_totals', $wpdb->get_row( "
	        SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts
	        LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
	        LEFT JOIN {$wpdb->term_relationships} AS rel ON posts.ID=rel.object_ID
	        LEFT JOIN {$wpdb->term_taxonomy} AS tax USING( term_taxonomy_id )
	        LEFT JOIN {$wpdb->terms} AS term USING( term_id )
	        WHERE   meta.meta_key       = '_order_total'
	        AND     posts.post_type     = 'shop_order'
	        AND     posts.post_status   IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed','on-hold', 'processing' ) ) ) . "' )
	    " ) );

	    return $order_totals->total_sales;

	}
add_shortcode('woo_total_amount', 'wshk_get_total_sales');

}



/* WOO TOTAL PRODUCT COUNTER */

//Updated v.1.8.7

//If you want to show total products on any page or post, use this Shortcode: [woo_total_product_count] 

// If you want exclude any category from the total count just add [woo_total_product_count cat_id="Here write the category ID number"]

// Now you can exclude more than one category. Just follow using the cat_id2="" and cat_id3="" attributes on the shortcode.

if(isset($pluginOptionsVal['wshk_enablethetotprosht']) && $pluginOptionsVal['wshk_enablethetotprosht']==2009)
{

function wshk_product_count_shortcode( $atts ) {
    ob_start();
extract( shortcode_atts( array(
        'product_count' => 0
    ), $atts ) );

    $data = shortcode_atts( array(
        'cat_id' => '',
        'cat_id2' => '',
        'cat_id3' => '',
        'taxonomy'  => 'product_cat'
    ), $atts );
    
    // loop through all categories to collect the count.
   foreach (get_terms('product_cat') as $term)
      $product_count += $term->count;

   //Since v.1.3 - updated v.1.8.7

    $category = get_term($data['cat_id'], $data['taxonomy'] );
    $categorytwo = get_term( $data['cat_id2'], $data['taxonomy'] );
    $categorythree = get_term( $data['cat_id3'], $data['taxonomy'] );
    $count = !empty($category->count)?$category->count:0;
    $counttwo = !empty($categorytwo->count)?$categorytwo->count:0;
    $countthree = !empty($categorythree->count)?$categorythree->count:0;
    $count_posts = wp_count_posts( 'product' );

    return (int)$count_posts->publish - (int)$count - (int)$counttwo - (int)$countthree.ob_get_clean();
    
}
add_shortcode( 'woo_total_product_count', 'wshk_product_count_shortcode' );
}



//Since v.1.5    

/*HOW MUCH PRODUCTS BOUGHT A USER (NUMBER ONLY)*/
//With a shortcode you can show the number of products that a user bought. If you want show in any page or post, use this shortcode : [woo_total_bought_products]

//Can be added a custom preffix, suffix with singular and plural text, and text to display when the customer dont have any product bought.

//Can control the message alignment: left, center or right

//Can fix the shortcode displaying position: Im fine = not fix , Enable for view = apply fix



/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/


if(isset($pluginOptionsVal['wshk_enablectbp']) && $pluginOptionsVal['wshk_enablectbp']==6)
{

   add_shortcode( 'woo_total_bought_products', 'wshk_current_customer_month_count' );
function wshk_current_customer_month_count( $user_id=null ) {
    if ( empty($user_id) ){
        $user_id = get_current_user_id();
    }
    // Date calculations to limit the query
    $today_year = date( 'Y' );
    $today_month = date( 'm' );
    $day = date( 'd' );
    if ($today_month == '01') {
        $month = '12';
        $year = $today_year - 1;
    } else{
        $month = $today_month - 1;
        $month = sprintf("%02d", $month);
        $year = $today_year - 1;
    }

    // ORDERS FOR LAST 30 DAYS (Time calculations)
    $now = strtotime('now');
    // Set the gap time (here 30 days)
    $gap_days = 30;
    $gap_days_in_seconds = 60*60*24*$gap_days;
    $gap_time = $now - $gap_days_in_seconds;

    // The query arguments
    $args = array(
        // WC orders post type
        'post_type'   => 'shop_order',        
        // Only orders with status "completed" (others common status: 'wc-on-hold' or 'wc-processing')
        'post_status' => 'wc-completed', 
        // all posts
        'numberposts' => -1,
        // for current user id
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'date_query' => array(
            //orders published on last 30 days
            'relation' => 'OR',
            array(
                'year' => $today_year,
                'month' => $today_month,
            ),
            array(
                'year' => $year,
                'month' => $month,
            ),
        ),
    );

    // Get all customer products
    $customer_orders = get_posts( $args );
    $textprefix = get_option('wshk_textprefix');
    $textsuffix = get_option('wshk_textsuffix');
    $textpsuffix = get_option('wshk_textpsuffix');
    $textnobp = get_option('wshk_textnobp');
    $aligntheproducts = get_option('wshk_aligntheproducts');
    $caunt = 1;
    $count = 0;
    
     global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenabletwo']) && $pluginOptionsVal['wshk_yesenabletwo']=='wshk_yesenabletwo')
{
  ob_start();
  }
  else if(isset($pluginOptionsVal['wshk_nnoenabletwo']) && $pluginOptionsVal['wshk_nnoenabletwo']=='wshk_nnoenabletwo') {
      //ob_start();
      
  }
    
    if (!empty($customer_orders)) {
        $customer_orders_date = array();
        // Going through each current customer orders
        foreach ( $customer_orders as $customer_order ){
            // Conveting order dates in seconds
            $customer_order_date = strtotime($customer_order->post_date);
            // Only past 30 days orders
            if ( $customer_order_date > $gap_time ) {
                $customer_order_date;
                $order = new WC_Order( $customer_order->ID );
                $order_items = $order->get_items();
                // Going through each current customer items in the order
                foreach ( $order_items as $order_item ){
                    $count++;
                }                
            } 
        }
        if ($count > $caunt){
        return '<p style="text-align:' . $aligntheproducts .';">' . $textprefix . ' ' . $count . ' ' . $textpsuffix . '</p>';
        }
    }
    if ($count == $caunt){
        echo '<p style="text-align:' . $aligntheproducts .';">' . $textprefix . ' ' . $count . ' ' . $textsuffix . '</p>';
        
        } else{
            echo '<p style="text-align:' . $aligntheproducts .';">' . $textnobp . '</p>' ;
            }
           
                global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenabletwo']) && $pluginOptionsVal['wshk_yesenabletwo']=='wshk_yesenabletwo')
{
  return ob_get_clean(); 
  }
  else if(isset($pluginOptionsVal['wshk_nnoenabletwo']) && $pluginOptionsVal['wshk_nnoenabletwo']=='wshk_nnoenabletwo') {
      //return ob_get_clean(); 
      
  } 
            
           
}
}




//Since v.1.5

/*GET ALL ORDERS FOR A USER*/
//Show the total orders that a user have made, if you want display in any page or post, use this shortcode: [woo_customer_total_orders]

//Can be added a custom preffix, suffix with singular and plural text, and text to display when the customer dont have any order maded.

//Can control the message alignment: left, center or right

//Can fix the shortcode displaying position: Im fine = not fix , Enable for view = apply fix


/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/

if(isset($pluginOptionsVal['wshk_enablectbo']) && $pluginOptionsVal['wshk_enablectbo']==7)
{

add_shortcode( 'woo_customer_total_orders', 'wshk_get_customer_total_orders' );
function wshk_get_customer_total_orders( $user_id=null ) {
        

    if ( empty($user_id) ){
        $user_id = get_current_user_id();
    }
    // Date calculations to limit the query
    $today_year = date( 'Y' );
    $today_month = date( 'm' );
    $day = date( 'd' );
    if ($today_month == '01') {
        $month = '12';
        $year = $today_year - 1;
    } else{
        $month = $today_month - 1;
        $month = sprintf("%02d", $month);
        $year = $today_year - 1;
    }

    // ORDERS FOR LAST 30 DAYS (Time calculations)
    $now = strtotime('now');
    // Set the gap time (here 30 days)
    $gap_days = 30;
    $gap_days_in_seconds = 60*60*24*$gap_days;
    $gap_time = $now - $gap_days_in_seconds;

    // The query arguments
    $args = array(
        // WC orders post type
        'post_type'   => 'shop_order',        
        // Only orders with status "completed" (others common status: 'wc-on-hold' or 'wc-processing')
        'post_status' => 'wc-completed', 
        // all posts
        'numberposts' => -1,
        // for current user id
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'date_query' => array(
            //orders published on last 30 days
            'relation' => 'OR',
            array(
                'year' => $today_year,
                'month' => $today_month,
            ),
            array(
                'year' => $year,
                'month' => $month,
            ),
        ),
    );
    
    
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenable']) && $pluginOptionsVal['wshk_yesenable']=='wshk_yesenable')
{
  ob_start();
  }
  else if(isset($pluginOptionsVal['wshk_nnoenable']) && $pluginOptionsVal['wshk_nnoenable']=='wshk_nnoenable') {
      //ob_start();
      
  }
    // Get all customer orders
    $customer_orders = get_posts( $args );
    $tordersprefix = get_option('wshk_tordersprefix');
    $torderssuffix = get_option('wshk_torderssuffix');
    $torderspsuffix = get_option('wshk_torderspsuffix');
    $textnobo = get_option('wshk_textnobo');
    $aligntheorders = get_option('wshk_aligntheorders');
    $caunt = 1;
    $count = 0;
    
    

    if (!empty($customer_orders)) {
        $customer_orders_date = array();
        // Going through each current customer orders
        foreach ( $customer_orders as $customer_order ){
            // Conveting order dates in seconds
            $customer_order_date = strtotime($customer_order->post_date);
            // Only past 30 days orders
            if ( $customer_order_date > $gap_time ) {
                $customer_order_date;
                $order = new WC_Order( $customer_order->ID );
                
                    $count++;
                                
            } 
        }
        if ($count > $caunt){
        return '<p style="text-align:' . $aligntheorders .';">' .$tordersprefix . ' ' . $count . ' ' . $torderspsuffix . '</p>' ;
        }
    }
    if ($count == $caunt){
        echo '<p style="text-align:' . $aligntheorders .';">' . $tordersprefix . ' ' . $count . ' ' . $torderssuffix . '</p>' ;
        
        } else{
            echo '<p style="text-align:' . $aligntheorders .';">' . $textnobo . '</p>';
            }
           
           
            global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenable']) && $pluginOptionsVal['wshk_yesenable']=='wshk_yesenable')
{
  return ob_get_clean();
    
} else if(isset($pluginOptionsVal['wshk_nnoenable']) && $pluginOptionsVal['wshk_nnoenable']=='wshk_nnoenable') {
    //return ob_get_clean();
}

    

}
}




//Since v.1.5

/*SHOW TOTAL OF COMMENTS BY USER (Only products)*/
//Display a product reviews counter made by a user, If you want display in any page or post, use this shortcode [woo_total_count_reviews]

//Can be added a custom preffix, suffix with singular and plural text, and text to display when the customer dont have any review maded.

//Can control the message alignment: left, center or right

//Can fix the shortcode displaying position: Im fine = not fix , Enable for view = apply fix


  /*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enablerwcounter']) && $pluginOptionsVal['wshk_enablerwcounter']==10)
{
    function wshk_count_reviews_by_user(){
$user_id = get_current_user_id();
$args = array(
	'user_id' => $user_id, // get the user by ID
	'post_type' => 'product',	
        'count' => true //return only the count
);
    
        global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenablethree']) && $pluginOptionsVal['wshk_yesenablethree']=='wshk_yesenablethree')
{
  ob_start();
  }
  else if(isset($pluginOptionsVal['wshk_nnoenablethree']) && $pluginOptionsVal['wshk_nnoenablethree']=='wshk_nnoenablethree') {
      //ob_start();
      
  }

$treviewprefix = get_option('wshk_treviewprefix');
$treviewsuffix = get_option('wshk_treviewsuffix');
$treviewpsuffix = get_option('wshk_treviewpsuffix');
$textnoreview = get_option('wshk_textnoreview');
$alignthereviews = get_option('wshk_alignthereviews');

$comments = get_comments($args);


 // Display the message if the customer has 1 review.
    if ( $comments == 1 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $treviewprefix . ' '  . $comments . ' ' . $treviewsuffix. '</p>';
 // Display this notice if the customer hasn't reviews yet.       
    } elseif( $comments == 0 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $textnoreview. '</p>';
    }
     // Display this notice if the customer has more than 1 review.
    else if( $comments >= 2 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $treviewprefix . ' ' . $comments . ' ' . $treviewpsuffix. '</p>';
    } 
    
            global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_yesenablethree']) && $pluginOptionsVal['wshk_yesenablethree']=='wshk_yesenablethree')
{
  return ob_get_clean();
  }
  else if(isset($pluginOptionsVal['wshk_nnoenablethree']) && $pluginOptionsVal['wshk_nnoenablethree']=='wshk_nnoenablethree') {
      //return ob_get_clean();
      
  }
    
}
} 
add_shortcode( 'woo_total_count_reviews', 'wshk_count_reviews_by_user' );




/* INDIVIDUAL PRODUCT SALES/DOWNLOADS COUNT FUNCTION*/ 
// If you want to show the invididual product sales/downloads with a  automatic counter just need activate the function.

// Can detect automaticlly if a product is virtual or not, to display downloads or sales.

// Can add custom text for each case: Downloads and Sales

// Can control when display the counter: All (always) custom number (when the product get these number of downloads/sales)

// Can control the style using the wshk classes

// Can be filtere with a custom snippet

	

/** Check if is active */

if(isset($pluginOptionsVal['wshk_enable']) && $pluginOptionsVal['wshk_enable']==1)
{
    //since 1.8.9
    //Use it with the shortcode [wshk_product_sales id="ID NUMBER HERE"]
    $getactivationfour = get_option('wshk_sales_sht_four');

if ( isset($getactivationfour) && $getactivationfour =='saleshtfour')
    {
    add_shortcode( 'wshk_product_sales', 'wshk_sales_by_product_id' );
    }
function wshk_sales_by_product_id( $atts ) {
        
   $atts = shortcode_atts( array(
      'id' => ''
   ), $atts );
    
   $units_sold = get_post_meta( $atts['id'], 'total_sales', true );
     
   return $units_sold;
     
}
    
    
	/* Start Sales Count Code */

  if(!function_exists('wshk_product_sold_count')):
      
      $getactivationone = get_option('wshk_sales_sht_one');

if ( isset($getactivationone) && $getactivationone =='saleshtone')
    {
	add_action( 'woocommerce_single_product_summary', 'wshk_product_sold_count', 11 );
    }
    $getactivationthree = get_option('wshk_sales_sht_three');

if ( isset($getactivationthree) && $getactivationthree =='saleshtthree')
    {
	add_action( 'woocommerce_before_add_to_cart_form', 'wshk_product_sold_count', 11 );
    }
$getactivationtwo = get_option('wshk_sales_sht_two');

if ( isset($getactivationtwo) && $getactivationtwo =='saleshttwo')
    {	
	add_action( 'woocommerce_after_shop_loop_item', 'wshk_product_sold_count', 11 );
}
function wshk_product_sold_count() {
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;

if ($product->is_downloadable('yes')) {
    
    // It will happen if the product is downloable.

		global $product;
		$pluginOptionsVal=get_wshk_sidebar_options();
		if(isset($pluginOptionsVal['wshk_text']) && $pluginOptionsVal['wshk_text']!='')
		{
			$salesTxt=$pluginOptionsVal['wshk_text'];
			}else {
			   $salesTxt = __( "Downloads", "woo-shortcodes-kit" );
				
				}
		$units_sold = get_post_meta( $product->id, 'total_sales', true );

    //Since v.1.4
		
		if($units_sold >= $pluginOptionsVal['wshk_min']){
		    
		
		echo '<p class="wshk wshkdow" style="margin-top:20px;"><span class="dashicons dashicons-download wshkicondow" style="padding-right:30px;"></span>' . sprintf( __( '<span class="wshk-count wshkcoudow">%s</span> <span class="wshk-text wshktxtdow">%s</span>', 'woocommerce' ), $units_sold,$salesTxt ) . '</p>';
		
		}
		
	} else {
	    
	    // It will happen if the product is not downloable
	    
	global $product;
		$pluginOptionsVal=get_wshk_sidebar_options();
	if(isset($pluginOptionsVal['wshk_textsales']) && $pluginOptionsVal['wshk_textsales']!='')
		{
			$saleTxt=$pluginOptionsVal['wshk_textsales'];
			}else {
			    
			    $saleTxt = __( "Sales", "woo-shortcodes-kit" );
			
				}
				$units_sold = get_post_meta( $product->id, 'total_sales', true );

    //Since v.1.4
		
		if($units_sold >= $pluginOptionsVal['wshk_minsales']){
		  
		
		echo '<p class="wshk wshksa" style="margin-top:20px;"><span class="dashicons dashicons-cart wshkiconsa" style="padding-right:30px;"></span>' . sprintf( __( '<span class="wshk-count wshkcousa">%s</span> <span class="wshk-text wshktxtsa">%s</span>', 'woocommerce' ), $units_sold,$saleTxt ) . '</p>';
		   
		}
	} 
	} 
  endif;
  
  /*add_action('wp_head','add_wshk_inline_style');

	//Default Counter CSS
	if(!function_exists('add_wshk_inline_style')):
	function add_wshk_inline_style()
	{
		$pluginOptionsVal=get_wshk_sidebar_options();
		$wshk_style='<style>'.$pluginOptionsVal['wshk-inlinecss'].'</style>';
		print $wshk_style;
		}
	endif;*/
}
?>