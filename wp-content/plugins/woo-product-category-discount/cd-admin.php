<?php
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

add_action('admin_menu', 'wpcd_register_submenu_page');
function wpcd_register_submenu_page() {
    add_submenu_page( 'woocommerce', __('Product Category Discount'), __('Product Category Discount'), 'manage_woocommerce', 'wpcd-category-discount', 'wpcd_product_category_discount' ); 
}

function wpcd_product_category_discount() {

    global $wpdb;
    
    echo '<h3>' . __('Product Category Discount') . '</h3>';
    
    $arrSelector = array(
            'product_cat'   =>  'category'
        );

    $controller = isset($_REQUEST['controller']) && !empty($_REQUEST['controller']) && in_array($_REQUEST['controller'], array('product_cat'))?$_REQUEST['controller']:'product_cat';

    $strCategory = 'SELECT tt.term_id t_id, tt.term_taxonomy_id tt_id, t.name name, tt.parent parent, tt.taxonomy taxonomy '
            . ' FROM ' . $wpdb->prefix . 'terms t, '
            . $wpdb->prefix . 'term_taxonomy tt '
            . ' WHERE tt.term_id = t.term_id'
            . ('product_attributes' == $controller?' AND tt.taxonomy LIKE "pa_%"':' AND tt.taxonomy = "' . $controller . '"');
    $arrCategories = $wpdb->get_results($strCategory);
    
    $arrProcessedCat = array();
    foreach($arrCategories AS $key => $arrVal) {
        
        if('product_attributes' == $controller) {

            $arrProcessedCat[$arrVal->t_id]['isChild'] = 0;
            $attribute = ucfirst(wc_attribute_label(str_replace('pa_', '', $arrVal->taxonomy)));
            $arrProcessedCat[$arrVal->t_id]['name'] = $attribute . ' >> ' . $arrVal->name;
        } else {
            $strCatName = wpcd_get_term_parents($arrVal->t_id, $controller);

            $arrProcessedCat[$arrVal->t_id]['name'] = substr($strCatName, 0, strlen($strCatName) - 3);
            $arrProcessedCat[$arrVal->t_id]['breadcrumb'] = (!empty($arrProcessedCat[$arrVal->parent]['name'])?$arrProcessedCat[$arrVal->parent]['name'] . ' >> ' : '') . $arrVal->name;
            if($arrVal->parent != 0) {
                $arrProcessedCat[$arrVal->parent]['child'][] = $arrVal->t_id;
                $arrProcessedCat[$arrVal->t_id]['isChild'] = 1;
            } else {
                $arrProcessedCat[$arrVal->t_id]['isChild'] = 0;
            }
        }
    }
    
    // Get category discount
    $strCategory = get_option('wpcd_' . $arrSelector[$controller] . '_discount');
    $arrCatDiscount = unserialize($strCategory);
    
    ?><form enctype="multipart/form-data" method="POST">
        <div class="postbox wc-metaboxes-wrapper" style="width:93%">
            <table style="padding:10px;width:80%;">
                <tbody>
                    <tr>
                        <th colspan="7">Quick Links</th>
                    </tr>
                    <tr> 
                        <td colspan="7">                       
                            <table style="width:100%;margin-top:20px;margin-bottom:10px;"><tr>
                                <td style="min-width:150px;"><a target="_blank" href="https://www.wooextend.com/product/woo-product-category-discount-pro/?utm_source=quick-link-wpcd" class="wsm-quick-link-pro">Buy Premium</a></td>
                                <td style="min-width:200px;"><a target="_blank" href="https://www.wooextend.com/submit-ticket/?utm_source=quick-link-wpcd" class="wsm-quick-link">Need help - Submit Ticket</a></td>
                                <td style="min-width:300px;"><a target="_blank" href="https://www.wooextend.com/woocommerce-expert/?utm_source=quick-link-wpcd" class="wsm-quick-link">Need custom feature developed - Get a free quote!</a></td>
                                
                            </tr></table>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="1" style="text-align:left;">Discount products based on</th>
                        <th colspan="6" style="text-align:left;">
                            <select name="controller" onchange="javascript:this.form.submit();" id="controller">
                                <option value="product_cat">Product Category</option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <th style="width:50%;padding:10px;"><?php echo $controller != 'product_cat'?ucfirst(str_replace("product_", "", $controller)):'Category';?></th>
                        <th style="width:8%;padding:10px;">Discount type</th>
                        <th style="width:8%;padding:10px;">Amount<?php echo '(' . get_woocommerce_currency_symbol() . ')';?></th>
                        <th style="width:2%;padding:10px;">Apply</th>
                    </tr>
                    <tr style="text-align:center;">
                        <td></td>
                        <td><a href="javascript:;" class="help tooltip">?<span class="tooltiptext">Specify type of discount. For e.g. $5.99 or 5.00%.</span></a></td>
                        <td><a href="javascript:;" class="help tooltip">?<span class="tooltiptext">Specify discount amount.</span></a></td>
                        <td><a href="javascript:;" class="help tooltip">?<span class="tooltiptext">This will apply discount immediately.</span></a></td>
                    </tr><?php
                    
                    foreach($arrProcessedCat AS $key => $arrVal) {
                        
                        if(!$arrVal['isChild']) {
                            ?><tr class="trwcpd<?php echo $key;?>"><td style="padding:5px;">
                                <label for="txtCatAmount_<?php echo $key;?>"><?php echo $arrProcessedCat[$key]['name']; ?></label>
                            </td>
                            <td style="padding:5px;">
                                <select name="selCat_<?php echo $key;?>" class="type" data-row_id="<?php echo $key;?>">
                                    <option value="Fixed Amount"><?php _e('Fixed Amount');?></option>
                                    <option value="% of Price" <?php echo isset($arrCatDiscount[$key]['type']) && $arrCatDiscount[$key]['type'] == '% of Price'?' selected="selected"':'';?>><?php _e('% of Price');?></option>
                                </select>
                            </td>
                            <td style="padding:5px;">
                                <input type='text' data-row_id="<?php echo $key;?>" class="amount" size='5' name="txtCatAmount_<?php echo $key;?>" id="txtCatAmount_<?php echo $key;?>" placeholder="Enter Amount" value="<?php echo isset($arrCatDiscount[$key]['value'])?$arrCatDiscount[$key]['value']:'';?>"/>
                            </td>
                            <td style="padding:5px;text-align:center;">
                                <input type='checkbox' data-row_id="<?php echo $key;?>" class="wpcd_active" name="chkActive_<?php echo $key;?>" id="chkActive_<?php echo $key;?>" value="Y" <?php echo isset($arrCatDiscount[$key]['isActive']) && $arrCatDiscount[$key]['isActive'] == 'true'?' checked="checked"':'';?>/>
                            </td>
                            <td class="loader" style="display:none;">
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/hourglass.gif';?>" style="height:30px;"/>
                            </td>
                            <td class="complete" style="display:none;">
                                <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/complete.png';?>" style="height:30px;"/>
                            </td></tr><?php
                        }
                        if(!empty($arrVal['child'])) {
                            foreach($arrVal['child'] AS $keyTemp => $childId) {
                                ?><tr class="trwcpd<?php echo $childId;?>"><td style="padding:5px;">
                                    <label for="txtCatAmount_<?php echo $childId;?>"><?php echo $arrProcessedCat[$childId]['name']; ?></label>
                                </td>
                                <td style="padding:5px;">
                                    <select name="selCat_<?php echo $childId;?>" class="type" data-row_id="<?php echo $childId;?>">
                                        <option value="Fixed Amount"><?php _e('Fixed Amount');?></option>
                                        <option value="% of Price" <?php echo $arrCatDiscount[$childId]['type'] == '% of Price'?' selected="selected"':'';?>><?php _e('% of Price');?></option>
                                    </select>
                                </td>
                                <td style="padding:5px;">
                                    <input type='text' data-row_id="<?php echo $childId;?>" class="amount" size='5' name="txtCatAmount_<?php echo $childId;?>" id="txtCatAmount_<?php echo $childId;?>" placeholder="Enter Amount" value="<?php echo isset($arrCatDiscount[$childId]['value'])?$arrCatDiscount[$childId]['value']:'';?>"/>
                                </td>
                                <td style="padding:5px;text-align:center;">
                                    <input type='checkbox' class="wpcd_active" name="chkActive_<?php echo $childId;?>" id="chkActive_<?php echo $childId;?>" value="Y" <?php echo isset($arrCatDiscount[$childId]['isActive']) && $arrCatDiscount[$childId]['isActive'] == 'true'?' checked="checked"':'';?> data-row_id="<?php echo $childId;?>"/>
                                </td>
                                <td class="loader" style="display:none;">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/hourglass.gif';?>" style="height:30px;"/>
                                </td>
                                <td class="complete" style="display:none;">
                                    <img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/images/complete.png';?>" style="height:30px;"/>
                                </td></tr><?php
                            }
                        } 
                    }
                ?></tbody>
            </table>
        </div>
    </form><?php
}


add_action( 'admin_enqueue_scripts', 'wpcd_load_custom_wp_admin_style' );
function wpcd_load_custom_wp_admin_style() {
    wp_register_script( 'discount_admin_js', plugin_dir_url( __FILE__ ) . 'assets/js/category-discount.js', array(), false, '1.0.0' );
    wp_enqueue_script( 'discount_admin_js' );
    wp_register_style( 'date-picker-css', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.datetimepicker.css', array(), '1.0.3' );
    wp_enqueue_style( 'date-picker-css' );
    // Localize the script
    $translation_array = array(
        'admin_url' => admin_url('admin-ajax.php')
    );
    wp_localize_script( 'discount_admin_js', 'wpcd_obj', $translation_array );
}

add_action( 'wp_ajax_wpcd_calculate_discount', 'wpcd_save_discount' );
add_action( 'wp_ajax_nopriv_wpcd_calculate_discount', 'wpcd_save_discount' );

function wpcd_save_discount() {

    global $wpdb;

    $arrController = array(
            'product_cat'   =>  'wpcd_category_discount'
        );

    $controller = isset($_REQUEST['controller']) && !empty($_REQUEST['controller']) && in_array($_REQUEST['controller'], array('product_cat'))?$_REQUEST['controller']:'product_cat';

    // Get existing saved discounts
    $strCategoryPrice = get_option($arrController[$controller]);
    $arrCategoryPrice = unserialize($strCategoryPrice);
    
    $arrExc = get_option('_wpcd_exclude_products');

    $reqCatId = $_POST['cat_id'];
    if(isset($arrCategoryPrice[$reqCatId]) && !empty($arrCategoryPrice[$reqCatId])) {
        $arrSelectedCat = $arrCategoryPrice[$reqCatId];
    } else {
        $arrSelectedCat = array(
                'type' => 'Fixed Amount', 
                'value' => 0, 
                'isActive' => 'false'
            );
    }

    $arrCategoryPrice[$reqCatId] = array(
        'type' => $_POST['type'], 
        'value' => $_POST['amount'], 
        'isActive' => $_POST['active']
    );
    
    // check if existing and requested both status are inactive, then no need to update product prices
    if($_POST['active'] == 'false' && ($arrSelectedCat['isActive'] == 'false' || empty($arrSelectedCat['isActive']))) {
        update_option($arrController[$controller], serialize($arrCategoryPrice));
        die();
    }

    $arrTransients = array();
    // check if we need to remove applied discount
    if($_POST['active'] == 'false' && $arrSelectedCat['isActive'] == 'true') {

        // Get all products in category
        $strCategory = 'SELECT tr.object_id product_id, pmWpcdCats.meta_value selected_cats, pmPrice.meta_value regular_price'
                    . ' FROM ' . $wpdb->prefix . 'terms t '
                    . ' LEFT JOIN ' . $wpdb->prefix . 'term_taxonomy tt ON (tt.term_id = t.term_id)'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'term_relationships tr ON (tr.term_taxonomy_id = tt.term_taxonomy_id)'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta pmPrice ON (tr.object_id = pmPrice.post_id AND pmPrice.meta_key = "_regular_price")'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta pmWpcdCats ON (tr.object_id = pmWpcdCats.post_id AND pmWpcdCats.meta_key = "_wpcd_cats")'
                    . ($controller == 'product_attributes'?' WHERE tt.term_id = "' . $reqCatId . '"':' WHERE tt.taxonomy = "' . $controller . '"')
                    . ' AND t.term_id = "' . $reqCatId . '"';
        $arrCategories = $wpdb->get_results($strCategory);

        // Loop for each product
        foreach($arrCategories AS $keyPro => $arrPro) {

            if(is_null($arrPro->product_id) || is_null(get_post($arrPro->product_id))) {
                continue;
            }
            $objProduct = wc_get_product( $arrPro->product_id );
            if($objProduct === false || in_array($arrPro->product_id, $arrExc)){
                continue;
            }

            // keep transients for sale synced
            $arrTransients[] = $arrPro->product_id;

            if(wpcd_woocommerce_version_check()) {
                $productType = $objProduct->get_type();
                $productId = $arrPro->product_id;
            } else {
                $productType = $objProduct->product_type;
                $productId = $arrPro->product_id;
            }
            if($productType == 'simple') {
                
                // Get all categories that product belongs to
                $arrCats = array();
                $strCats = $arrPro->selected_cats;
                if(isset($strCats) && !empty($strCats)) {
                    $arrCats = explode(',', $strCats);
                }    
                $key = array_search($reqCatId, $arrCats); 
                unset($arrCats[$key]);           
                update_post_meta($productId, '_wpcd_cats', implode(',', array_unique($arrCats)));

                if(!empty($arrCats)) {

                    // Update prices
                    $fltRegularPrice = (float)$arrPro->regular_price;
                    $discountAmount = wpcd_get_discount_amount($arrCategoryPrice, $arrCats, $fltRegularPrice, $controller);
                    $newPrice = $fltRegularPrice - $discountAmount;

                    update_post_meta($productId, '_price', $newPrice); 
                    update_post_meta($productId, '_sale_price', $newPrice);

                    // Compatibility for lookup table
                    if(wpcd_woocommerce_version_check('3.2')) {
                        wpcd_lookup_update( $productId, $newPrice);
                    }
                } else {
                    // Delete wpcd discount
                    delete_post_meta($productId, '_sale_price');
                    delete_post_meta($productId, '_wpcd_cats');
                    // Restore old discounted price
                    $strUpdateKey = "UPDATE {$wpdb->prefix}postmeta SET meta_key = '_sale_price' WHERE meta_key = '_wpcd_sale_price'
                        AND post_id = {$productId}";
                    $wpdb->query($strUpdateKey);

                    $fltRegularPrice = $arrPro->regular_price;
                    $fltSalePrice = get_post_meta($productId, '_sale_price', true);

                    $effectivePrice = (float)(isset($fltSalePrice) && !empty($fltSalePrice)?$fltSalePrice:$fltRegularPrice);
                    update_post_meta($productId, '_price', $effectivePrice); 
                    // Compatibility for lookup table
                    if(wpcd_woocommerce_version_check('3.2')) {
                        wpcd_lookup_update( $productId, $effectivePrice, '0');
                    }
                }              
            } else {

                // check if attributes
                if($controller == 'product_attributes') {

                    $strTerm = "SELECT tr.object_id 
                                FROM {$wpdb->prefix}term_relationships tr, {$wpdb->prefix}terms t, {$wpdb->prefix}term_taxonomy tt
                                WHERE tr.term_taxonomy_id = tt.term_taxonomy_id
                                AND tt.term_id = t.term_id
                                AND t.term_id = '" . $reqCatId . "'";
                    $arrTId = $wpdb->get_results($strTerm);
                    $arr_term_id = array();
                    foreach ($arrTId as $keyTerm => $valueTerm) {
                        $arr_term_id[] = $valueTerm->object_id;
                    }
                }                

                $strVariations = "SELECT p.ID variation_id
                 FROM {$wpdb->prefix}posts p
                 WHERE p.post_type='product_variation' AND p.post_parent = '{$arrPro->product_id}'";

                 if($controller == 'product_attributes') {
                    $strVariations .= " AND p.ID IN ('" . implode("','", $arr_term_id) . "')";
                 }
                $arrVariations = $wpdb->get_results($strVariations, ARRAY_A);

                // Loop for each variation 
                foreach($arrVariations AS $keVar => $arrVar) {

                    // Get all categories that product belongs to
                    $arrCats = array();
                    $strCats = $arrPro->selected_cats;
                    if(isset($strCats) && !empty($strCats)) {
                        $arrCats = explode(',', $strCats);
                    }    
                    $key = array_search($reqCatId, $arrCats); 
                    unset($arrCats[$key]);           
                    update_post_meta($arrVar['variation_id'], '_wpcd_cats', implode(',', array_unique($arrCats)));

                    if(!empty($arrCats)) {

                        // Update prices
                        $fltRegularPrice = (float)get_post_meta($arrVar['variation_id'], '_regular_price', true);
                        $discountAmount = wpcd_get_discount_amount($arrCategoryPrice, $arrCats, $fltRegularPrice, $controller);
                        $newPrice = $fltRegularPrice - $discountAmount;

                        update_post_meta($arrVar['variation_id'], '_price', $newPrice); 
                        update_post_meta($arrVar['variation_id'], '_sale_price', $newPrice);
                    } else {

                        // Delete wpcd discount
                        delete_post_meta($arrVar['variation_id'], '_sale_price');
                        delete_post_meta($arrVar['variation_id'], '_wpcd_cats');
                        // Restore old discounted price
                        $strUpdateKey = "UPDATE {$wpdb->prefix}postmeta SET meta_key = '_sale_price' WHERE meta_key = '_wpcd_sale_price'
                            AND post_id = {$arrVar['variation_id']}";
                        $wpdb->query($strUpdateKey);

                        $fltRegularPrice = get_post_meta($arrVar['variation_id'], '_regular_price', true);
                        $fltSalePrice = get_post_meta($arrVar['variation_id'], '_sale_price', true);

                        $effectivePrice = (float)(isset($fltSalePrice) && !empty($fltSalePrice)?$fltSalePrice:$fltRegularPrice);
                        update_post_meta($arrVar['variation_id'], '_price', $effectivePrice);
                    }
                }
            }

            // update product transients
            wpcd_delete_product_transients($arrPro->product_id);
        }
        $arrCategoryPrice[$reqCatId] = array(
                'type' => $_POST['type'], 
                'value' => $_POST['amount'], 
                'isActive' => $_POST['active']
            );
        update_option($arrController[$controller], serialize($arrCategoryPrice));

        delete_option('_transient_timeout_wc_products_onsale');
        delete_option('_transient_wc_products_onsale');
        die();
    }

    // check if we need to apply discount
    if($_POST['active'] == 'true') {

        // Get all products in category
        $strCategory = 'SELECT tr.object_id product_id, pmWpcdCats.meta_value selected_cats, pmPrice.meta_value regular_price'
                    . ' FROM ' . $wpdb->prefix . 'terms t '
                    . ' LEFT JOIN ' . $wpdb->prefix . 'term_taxonomy tt ON (tt.term_id = t.term_id)'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'term_relationships tr ON (tr.term_taxonomy_id = tt.term_taxonomy_id)'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta pmPrice ON (tr.object_id = pmPrice.post_id AND pmPrice.meta_key = "_regular_price")'
                    . ' LEFT JOIN ' . $wpdb->prefix . 'postmeta pmWpcdCats ON (tr.object_id = pmWpcdCats.post_id AND pmWpcdCats.meta_key = "_wpcd_cats")'
                    . ($controller == 'product_attributes'?' WHERE tt.term_id = "' . $reqCatId . '"':' WHERE tt.taxonomy = "' . $controller . '"')
                    . ' AND t.term_id = "' . $reqCatId . '"';
        $arrCategories = $wpdb->get_results($strCategory);

        // Loop for each product
        foreach($arrCategories AS $keyPro => $arrPro) {


            $objProduct = wc_get_product( $arrPro->product_id );
            
            if($objProduct === false || is_null($arrPro->product_id) || is_null(get_post($arrPro->product_id)) || in_array($arrPro->product_id, $arrExc)) {
                continue;
            }
            if(wpcd_woocommerce_version_check()) {
                $productType = $objProduct->get_type();
                $productId = $arrPro->product_id;
            } else {
                $productType = $objProduct->product_type;
                $productId = $arrPro->product_id;
            }

            // keep transients for sale synced
            $arrTransients[] = $arrPro->product_id;

            if($productType == 'simple') {
                
                // Backup existing discount price if not saved
                $strGetKey = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_wpcd_sale_price'
                    AND post_id = {$productId}";
                $arrKey = $wpdb->get_results($strGetKey);

                if(!isset($arrKey[0]) || empty($arrKey[0])) {
                    $strUpdateKey = "UPDATE {$wpdb->prefix}postmeta SET meta_key = '_wpcd_sale_price' WHERE meta_key = '_sale_price'
                        AND post_id = {$productId}";
                    $wpdb->query($strUpdateKey);
                }
                // Get all categories that product belongs to
                $arrCats = array();
                $strCats = $arrPro->selected_cats;
                if(isset($strCats) && !empty($strCats)) {
                    $arrCats = explode(',', $strCats);
                }
                $arrCats[] = $reqCatId;                
                update_post_meta($productId, '_wpcd_cats', implode(',', array_unique($arrCats)));

                // Update prices
                $fltRegularPrice = (float)$arrPro->regular_price;
                $discountAmount = wpcd_get_discount_amount($arrCategoryPrice, $arrCats, $fltRegularPrice, $controller);
                $newPrice = $fltRegularPrice - $discountAmount;

                update_post_meta($productId, '_price', $newPrice); 
                update_post_meta($productId, '_sale_price', $newPrice);
                if(wpcd_woocommerce_version_check('3.2')) {
                    wpcd_lookup_update( $productId, $newPrice);
                }
            } else {

                // check if attributes
                if($controller == 'product_attributes') {

                    $strTerm = "SELECT tr.object_id 
                                FROM {$wpdb->prefix}term_relationships tr, {$wpdb->prefix}terms t, {$wpdb->prefix}term_taxonomy tt
                                WHERE tr.term_taxonomy_id = tt.term_taxonomy_id
                                AND tt.term_id = t.term_id
                                AND t.term_id = '" . $reqCatId . "'";
                    $arrTId = $wpdb->get_results($strTerm);
                    $arr_term_id = array();
                    foreach ($arrTId as $keyTerm => $valueTerm) {
                        $arr_term_id[] = $valueTerm->object_id;
                    }
                }                

                $strVariations = "SELECT p.ID variation_id, pmPrice.meta_value regular_price, wpcdSalePrice.meta_value wpcd_sale_price
                 FROM {$wpdb->prefix}posts p
                 LEFT JOIN {$wpdb->prefix}postmeta pmPrice ON (p.ID = pmPrice.post_id AND pmPrice.meta_key = '_regular_price')
                 LEFT JOIN {$wpdb->prefix}postmeta wpcdSalePrice ON (p.ID = wpcdSalePrice.post_id AND wpcdSalePrice.meta_key = '_wpcd_sale_price')
                 WHERE p.post_type='product_variation' AND p.post_parent = '{$arrPro->product_id}'";
                if($controller == 'product_attributes') {
                   $strVariations .= " AND p.ID IN ('" . implode("','", $arr_term_id) . "')";
                }
                $arrVariations = $wpdb->get_results($strVariations, ARRAY_A);

                // Loop for each variation 
                foreach($arrVariations AS $keVar => $arrVar) {

                    // Backup existing discount price if not saved
                    if(!isset($arrVar['wpcd_sale_price']) || empty($arrVar['wpcd_sale_price'])) {
                        $strUpdateKey = "UPDATE {$wpdb->prefix}postmeta SET meta_key = '_wpcd_sale_price' WHERE meta_key = '_sale_price'
                            AND post_id = {$arrVar['variation_id']}";
                        $wpdb->query($strUpdateKey);
                    }
                    // Get all categories that product belongs to
                    $arrCats = array();
                    $strCats = $arrPro->selected_cats;
                    if(isset($strCats) && !empty($strCats)) {
                        $arrCats = explode(',', $strCats);
                    }
                    $arrCats[] = $reqCatId;                
                    update_post_meta($arrVar['variation_id'], '_wpcd_cats', implode(',', array_unique($arrCats)));

                    // Update prices
                    $fltRegularPrice = $arrVar['regular_price'];
                    $discountAmount = wpcd_get_discount_amount($arrCategoryPrice, $arrCats, $fltRegularPrice, $controller);
                    $newPrice = $fltRegularPrice - $discountAmount;

                    update_post_meta($arrVar['variation_id'], '_price', $newPrice); 
                    update_post_meta($arrVar['variation_id'], '_sale_price', $newPrice);
                    if(wpcd_woocommerce_version_check('3.2')) {
                        wpcd_lookup_update( $arrVar['variation_id'], $newPrice);
                    }
                }
            }

            // Delete transients for each product
            wpcd_delete_product_transients($arrPro->product_id);
        }
        $arrCategoryPrice[$reqCatId] = array(
                'type' => $_POST['type'], 
                'value' => $_POST['amount'], 
                'isActive' => $_POST['active']
            );
        update_option($arrController[$controller], serialize($arrCategoryPrice));
        
        delete_option('_transient_timeout_wc_products_onsale');
        delete_option('_transient_wc_products_onsale');
        die();
    }
}

/**
 * Clear sale transients.
 *
 * @param int $post_id (default: 0).
 */
function wpcd_delete_product_transients( $post_id = 0 ) {
    
    // Transient names that include an ID.
    $post_transient_names = array(
        'wc_product_children_',
        'wc_var_prices_',
        'wc_related_',
        'wc_child_has_weight_',
        'wc_child_has_dimensions_',
    );

    if ( $post_id > 0 ) {
        foreach ( $post_transient_names as $transient ) {
            $transients_to_clear[] = $transient . $post_id;
        }

        // Does this product have a parent?
        $product = wc_get_product( $post_id );

        if ( $product ) {
            if ( $product->get_parent_id() > 0 ) {
                wc_delete_product_transients( $product->get_parent_id() );
            }

            if ( 'variable' === $product->get_type() ) {
                wp_cache_delete(
                    WC_Cache_Helper::get_cache_prefix( 'products' ) . 'product_variation_attributes_' . $product->get_id(),
                    'products'
                );
            }
        }
    }

    // Delete transients.
    foreach ( $transients_to_clear as $transient ) {
        delete_transient( $transient );
    }

    // Increments the transient version to invalidate cache.
    WC_Cache_Helper::get_transient_version( 'product', true );

    do_action( 'woocommerce_delete_product_transients', $post_id );
}

function wpcd_lookup_update( $id, $price, $on_sale = '1') {

    global $wpdb;

    $strCheck = "SELECT product_id FROM {$wpdb->prefix}wc_product_meta_lookup WHERE product_id = '" . $id . "'";
    $arrCheck = $wpdb->get_results($strCheck);

    if(isset($arrCheck[0]) && !empty($arrCheck[0])) {
        $strUpdate = "UPDATE {$wpdb->prefix}wc_product_meta_lookup 
                    SET min_price = '" . $price . "', max_price = '" . $price . "', onsale='" . $on_sale . "'" .
                    " WHERE product_id = '" . $id . "'";
        $wpdb->query($strUpdate);
    } else {
        $strInsert = "INSERT INTO {$wpdb->prefix}wc_product_meta_lookup (`product_id`, `min_price`, `max_price`, `onsale`)
                    VALUES ('" . $id . "', '" . $price . "', '" . $price . "', '" . $on_sale . "')";
        $wpdb->query($strInsert);
    }
}

function wpcd_woocommerce_version_check( $version = '3.0' ) {
  if ( function_exists( 'is_woocommerce_active' ) && is_woocommerce_active() ) {
    global $woocommerce;
    if( version_compare( $woocommerce->version, $version, ">=" ) ) {
      return true;
    }
  }
  return false;
}

function wpcd_get_discount_amount($arrCatDetails, $arrSelectedCats, $price, $controller) {

    $arrController = array(
            'product_cat'   =>  'wpcd_category_discount'
        );

    $arrSelectedAmount = array();
    foreach($arrCatDetails AS $key => $arrVal) {

        if(isset($arrVal['isActive']) && !empty($arrVal['isActive']) && $arrVal['isActive'] == 'true' && in_array($key, $arrSelectedCats)) {
            
            if($arrVal['type'] == 'Fixed Amount') {
                $arrSelectedAmount[] = $arrVal['value'];
            } else {
                $arrSelectedAmount[] = (float)$arrVal['value'] * (float)$price / 100;
            }
        }
    }

    foreach ($arrController as $key => $strValue) {
        if($controller == $key) {
            continue;
        }

        $strCategoryPrice = get_option($strValue);
        $arrCategoryPrice = unserialize($strCategoryPrice);
        
        if(!isset($arrCategoryPrice) || empty($arrCategoryPrice) || !is_array($arrCategoryPrice)) {
            continue;
        }
        foreach($arrCategoryPrice AS $key => $arrVal) {

            if(isset($arrVal['isActive']) && !empty($arrVal['isActive']) && $arrVal['isActive'] == 'true' && in_array($key, $arrSelectedCats)) {
                
                if($arrVal['type'] == 'Fixed Amount') {
                    $arrSelectedAmount[] = $arrVal['value'];
                } else {
                    $arrSelectedAmount[] = (float)$arrVal['value'] * (float)$price / 100;
                }
            }
        }
    }

    /*Added By Upasana*/
    $isMaxOverlap = get_option('_wpcd_overlap_cat');

    if(is_array($arrSelectedAmount) && !empty($arrSelectedAmount)) {
        if(isset($isMaxOverlap) && !empty($isMaxOverlap) && $isMaxOverlap == "yes") {
            $amount = min($arrSelectedAmount);
        } else {
            $amount = max($arrSelectedAmount);
        }
    } else {
        $amount = 0;
    }
    return round($amount, get_option('woocommerce_price_num_decimals'));
    /*End By Upasana*/

}

function wpcd_get_term_parents( $id, $taxonomy, $link = false, $separator = ' >> ', $nicename = false, $visited = array() ) {
    $chain = '';
    $parent = get_term( $id, $taxonomy );
    if ( is_wp_error( $parent ) )
            return $parent;

    if ( $nicename ) {
            $name = $parent->slug;
    } else {
            $name = $parent->name;
    }

    if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
            $visited[] = $parent->parent;
            $chain .= wpcd_get_term_parents( $parent->parent, $taxonomy, $link, $separator, $nicename, $visited );
    }

    if ( $link ) {
            $chain .= '<a href="' . get_term_link( $parent, $taxonomy ) . '" title="' . esc_attr( sprintf( _e( "View all posts in %s" ), $parent->name ) ) . '">'.$parent->name.'</a>' . $separator;
    } else {
            $chain .= $name.$separator;
    }
    return $chain;
}

/*Added By Upasana*/

add_filter( 'woocommerce_get_sections_products' , 'wpcd_category_discount_settings_tab' );
function wpcd_category_discount_settings_tab( $settings_tab ){
     $settings_tab['wpcd_category_discount'] = __( 'Category Discount' );
     return $settings_tab;
}

add_filter( 'woocommerce_get_settings_products' , 'wpcd_category_discount_settings' , 10, 2 );

function wpcd_category_discount_settings( $settings, $current_section ) {
        $custom_settings = array();

        global $wpdb;

        $arrSelOption = array();
        $strProduct = "SELECT post_title, ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_status = 'publish'";      
        $arrProduct = $wpdb->get_results($strProduct);
        foreach ($arrProduct as $key => $value) {
            $arrSelOption[$value->ID] = $value->post_title;
        }
        ?><script>jQuery(document).ready(function() {
            jQuery('#_wpcd_exclude_products').select2();
        });</script><?php
        if( 'wpcd_category_discount' == $current_section ) {
            $custom_settings =  array(
            array(
                'name' => __( 'Category Discount Configuration (BEFORE SWITCHING THIS, PLEASE DEACTIVATE ALL DISCOUNTS FROM STORE)' ),
                'type' => 'title',
                'id'   => 'category-discount' 
            ),
            array(
                'name' => __( 'Use minimum discount for overlapping categories' ),
                'type' => 'checkbox',
                'desc' => __( 'If this is checked then minimum discount will be used for overlapping categories else maximum.'),
                'id'    => '_wpcd_overlap_cat'
            ),
            array(
                'id'          => '_wpcd_exclude_products',
                'type'        => 'multiselect',
                'name'       => __( 'Exclude products from discount', 'woocommerce' ),
                'desc' => __( 'These products will not be included while applying discount.', 'woocommerce' ),
                'options' => $arrSelOption,
                'custom_attributes' => array("multiple" => "multiple")
            ),
             array( 'type' => 'sectionend', 'id' => 'category-discount' ),
    );
        return $custom_settings;
     } else {
            return $settings;
    }
}

/*End By Upasana*/

?>