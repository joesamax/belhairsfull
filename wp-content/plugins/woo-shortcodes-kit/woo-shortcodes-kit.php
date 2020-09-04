<?php

/**
* Plugin Name: Woo Shortcodes Kit
* Plugin URI: https://disespubli.com/
* Description: Easy shortcodes which can be displayed on any page or post to build your own my account page, customize the shop page, order emails, the add to cart button, add security, restrict content and much more!. Enjoy customizing easilly your WooCommerce's shop with more than 50 shortcodes & functions. This plugin not work alone, you need install WooCommerce before.
* Author: Alberto G.
* Version: 1.8.9
* Tested up to: 5.4
* WC requires at least: 4.0
* WC tested up to: 4.2.0
* Author URI: https://disespubli.com/
* Text Domain: woo-shortcodes-kit
* Domain Path: /languages
* License: GPLv3
* URI: http://www.gnu.org/licenses/gpl-3.0.html

    Woo Shortcodes Kit is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.
 
    Woo Shortcodes Kit is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with Woocommerce Shortcodes Kit. If not, see http://www.gnu.org/licenses/gpl-3.0.html.
  */

    //Let's go!
    
// Make sure WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;
    
    
/* register admin menu */
    
    add_action('admin_menu', 'register_woo_shortcodes_kit');
    
    	if(!function_exists('register_woo_shortcodes_kit')):

	function register_woo_shortcodes_kit() {
    	add_submenu_page( 'woocommerce', 'Woo Shortcodes Kit', 'WSHK', 'manage_options', 'woo-shortcodes-kit', 'init_woo_shortcodes_kit_admin_page_html' ); 
	}


	endif;
	

	if(!function_exists('wshk_add_settings_link')):

    // Load translations
        
    add_action('plugins_loaded', 'wshk_load_textdomain');
    function wshk_load_textdomain() {
        load_plugin_textdomain( 'woo-shortcodes-kit', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

	// Add settings link to plugin list page in admin
        
        function wshk_add_settings_link( $links ) {
            $mysettingslink = __('Settings','woo-shortcodes-kit');
            $myratelink = __('Please rate the plugin','woo-shortcodes-kit');
            $myvideolink = __('Learn how work all the functions','woo-shortcodes-kit');
            $settings_link = array('<a href="admin.php?page=woo-shortcodes-kit"'.' title="'.$mysettingslink.'">' . __( 'Settings', 'woo-shortcodes-kit' ) . '</a>'.' | '.'<a href="https://wordpress.org/support/plugin/woo-shortcodes-kit/reviews/#new-post" target="_blank" title="'.$myratelink.'">' . __( 'Please rate the plugin', 'woo-shortcodes-kit' ) . '</a>'.' | '.'<a href="https://www.youtube.com/watch?v=20L7LjV0BX8&list=PLAI7D4M9MLQA1gcsDKfvuO4N_RfkywlJl" target="_blank" title="'.$myvideolink.'">' . __( 'Learn how work all the functions', 'woo-shortcodes-kit' ) . '</a>');
            return array_merge( $links, $settings_link );;
        } 
	endif;
	
	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 'wshk_add_settings_link' );

/** register settings */

	if(!function_exists('wshk_register_settings')):

	function wshk_register_settings() {
    	register_setting( 'wshk_options', 'wshk_enable');
    	register_setting( 'wshk_options', 'wshk_test');
    	register_setting( 'wshk_options', 'wshk-inlinecss');
    	register_setting( 'wshk_options', 'wshk_text');
    	register_setting( 'wshk_options', 'wshk_min'); 
    	register_setting( 'wshk_options', 'wshk_perpage'); 
    	register_setting( 'wshk_options', 'wshk_nperpage');
    	register_setting( 'wshk_options', 'wshk_enablecat');
    	register_setting( 'wshk_options', 'wshk_firstcat');
    	register_setting( 'wshk_options', 'wshk_secondcat');
    	register_setting( 'wshk_options', 'wshk_thirdcat');
    	register_setting( 'wshk_options', 'wshk_enablebought');
    	register_setting( 'wshk_options', 'wshk_buttontext');
    	register_setting( 'wshk_options', 'wshk_enablectbp');
    	register_setting( 'wshk_options', 'wshk_textprefix'); 
    	register_setting( 'wshk_options', 'wshk_textsuffix');
    	register_setting( 'wshk_options', 'wshk_textpsuffix');
    	register_setting( 'wshk_options', 'wshk_textnobp');
    	register_setting( 'wshk_options', 'wshk_enablectbo');
    	register_setting( 'wshk_options', 'wshk_tordersprefix');
    	register_setting( 'wshk_options', 'wshk_torderssuffix');
    	register_setting( 'wshk_options', 'wshk_torderspsuffix');
    	register_setting( 'wshk_options', 'wshk_textnobo');
    	register_setting( 'wshk_options', 'wshk_enablewmessage');
    	register_setting( 'wshk_options', 'wshk_wmorders');
    	register_setting( 'wshk_options', 'wshk_textwmssg');
    	register_setting( 'wshk_options', 'wshk_textsales');
    	register_setting( 'wshk_options', 'wshk_minsales');
    	register_setting( 'wshk_options', 'wshk_nonotice');
    	register_setting( 'wshk_options', 'wshk_morenotice');
    	register_setting( 'wshk_options', 'wshk_enablereviews');
    	register_setting( 'wshk_options', 'wshk_textavsize');
    	register_setting( 'wshk_options', 'wshk_textavbdsize');
    	register_setting( 'wshk_options', 'wshk_textavbdradius');
    	register_setting( 'wshk_options', 'wshk_textavbdtype');
    	register_setting( 'wshk_options', 'wshk_textavbdcolor');
    	register_setting( 'wshk_options', 'wshk_texttbwsize');
    	register_setting( 'wshk_options', 'wshk_textbxfsize');
    	register_setting( 'wshk_options', 'wshk_textbxbdsize');
    	register_setting( 'wshk_options', 'wshk_textbxbdradius');
    	register_setting( 'wshk_options', 'wshk_textbxbdtype');
    	register_setting( 'wshk_options', 'wshk_textbxbdcolor');
    	register_setting( 'wshk_options', 'wshk_textbxbgcolor');
    	register_setting( 'wshk_options', 'wshk_textbtnbdsize');
    	register_setting( 'wshk_options', 'wshk_textbtnbdradius');
    	register_setting( 'wshk_options', 'wshk_textbtnbdtype');
    	register_setting( 'wshk_options', 'wshk_textbtnbdcolor');
    	register_setting( 'wshk_options', 'wshk_textbtntarget');
    	register_setting( 'wshk_options', 'wshk_textbtntxd');
    	
    	/*Nuevas opciones desde v.1.7.8*/
    	register_setting( 'wshk_options', 'wshk_enablemydownloadsht');
    	register_setting( 'wshk_options', 'wshk_enablemyaddressessht');
    	register_setting( 'wshk_options', 'wshk_enablemypaymentsht');
    	register_setting( 'wshk_options', 'wshk_enablemyeditaccsht');
    	register_setting( 'wshk_options', 'wshk_enabledashbsht');
    	register_setting( 'wshk_options', 'wshk_enabletheipsht');
    	register_setting( 'wshk_options', 'wshk_enablethenamesurnsht');
    	register_setting( 'wshk_options', 'wshk_enabletheuseremailsht');
    	register_setting( 'wshk_options', 'wshk_enablethetotsalessht');
    	register_setting( 'wshk_options', 'wshk_enablethetotprosht');
    	register_setting( 'wshk_options', 'wshk_enabletheboughtsht');
    	/*FIN nuevas opciones*/
    	
    	/*since 1.8.4*/
    	register_setting( 'wshk_options', 'wshk_enablethetotsalesamount');
    	register_setting( 'wshk_options', 'wshk_blockadmredirect');
    	register_setting( 'wshk_options', 'wshk_tablaymod');
    	
    	/*since 1.8.5*/
    	register_setting( 'wshk_options', 'wshk_nosendusers');
    	register_setting( 'wshk_options', 'wshk_disablenewdashboardwc');
    	
    	/*Since 1.8.7*/
    	register_setting( 'wshk_options', 'wshk_displaywoonotices');
    	register_setting( 'wshk_options', 'wshk_userinmenuoptions');
    	
    	/*Since 1.8.9*/
    	register_setting( 'wshk_options', 'wshk_sales_sht_one');
    	register_setting( 'wshk_options', 'wshk_sales_sht_two');
    	register_setting( 'wshk_options', 'wshk_sales_sht_three');
    	register_setting( 'wshk_options', 'wshk_sales_sht_four');
    	register_setting( 'wshk_options', 'wshk_myfilesizelimit');
    	register_setting( 'wshk_options', 'wshk_displaycustavatartoo');
    	
    	
    	register_setting( 'wshk_options', 'wshk_yesenable');
    	register_setting( 'wshk_options', 'wshk_yesenabletwo');
    	register_setting( 'wshk_options', 'wshk_yesenablethree');
    	register_setting( 'wshk_options', 'wshk_nnoenable');
    	register_setting( 'wshk_options', 'wshk_nnoenabletwo');
    	register_setting( 'wshk_options', 'wshk_nnoenablethree');
    	
    	register_setting( 'wshk_options', 'wshk_alignthereviews');
    	register_setting( 'wshk_options', 'wshk_aligntheorders');
    	register_setting( 'wshk_options', 'wshk_aligntheproducts');
    	
    	register_setting( 'wshk_options', 'wshk_enabledisplayreviews');
    	register_setting( 'wshk_options', 'wshk_disretextavsize');
    	register_setting( 'wshk_options', 'wshk_disretextavbdsize');
    	register_setting( 'wshk_options', 'wshk_disretextavbdradius');
    	register_setting( 'wshk_options', 'wshk_disretextavbdtype');
    	register_setting( 'wshk_options', 'wshk_disretextavbdcolor');
    	register_setting( 'wshk_options', 'wshk_disretexttbwsize');
    	register_setting( 'wshk_options', 'wshk_disretextbxfsize');
    	register_setting( 'wshk_options', 'wshk_disretextmargintop');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdsize');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdradius');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdtype');
    	register_setting( 'wshk_options', 'wshk_disretextbxbdcolor');
    	register_setting( 'wshk_options', 'wshk_disretextbxbgcolor');
    	register_setting( 'wshk_options', 'wshk_disretextbxpadding');
    	register_setting( 'wshk_options', 'wshk_disretextbxminheight');
    	register_setting( 'wshk_options', 'wshk_disretextcolor');
    	register_setting( 'wshk_options', 'wshk_numbrevdis');
    	register_setting( 'wshk_options', 'wshk_showpoints');
    	register_setting( 'wshk_options', 'wshk_limitcomm');
    	register_setting( 'wshk_options', 'wshk_readmoretextlim');
    	
    	register_setting( 'wshk_options', 'wshk_enableorderscontrol');
    	register_setting( 'wshk_options', 'wshk_numeropedidos');
    	
    	register_setting( 'wshk_options', 'wshk_bougcolumnum');
    	
    	
    	
    	register_setting( 'wshk_options', 'wshk_disretextlinktarget');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxd');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxtsize');
    	register_setting( 'wshk_options', 'wshk_disretextlinktxtcolor');
    	
    	register_setting( 'wshk_options', 'wshk_disredisplaynumber');
    	register_setting( 'wshk_options', 'wshk_disrecolumnsnumber');
    	
    	
    	register_setting( 'wshk_options', 'wshk_enablerwcounter');
    	register_setting( 'wshk_options', 'wshk_treviewprefix');
    	register_setting( 'wshk_options', 'wshk_treviewsuffix');
    	register_setting( 'wshk_options', 'wshk_treviewpsuffix');
    	register_setting( 'wshk_options', 'wshk_textnoreview');
    	register_setting( 'wshk_options', 'wshk_enableusername');
    	register_setting( 'wshk_options', 'wshk_usernmtc');
    	register_setting( 'wshk_options', 'wshk_usernmts');
    	register_setting( 'wshk_options', 'wshk_usernmta');
    	register_setting( 'wshk_options', 'wshk_enablelogoutbtn');
    	register_setting( 'wshk_options', 'wshk_logbtnbdsize');
    	register_setting( 'wshk_options', 'wshk_logbtnbdradius');
    	register_setting( 'wshk_options', 'wshk_logbtnbdtype');
    	register_setting( 'wshk_options', 'wshk_logbtnbdcolor');
    	register_setting( 'wshk_options', 'wshk_logbtntd');
    	register_setting( 'wshk_options', 'wshk_logbtnta');
    	register_setting( 'wshk_options', 'wshk_logbtnwd');
    	register_setting( 'wshk_options', 'wshk_logbtntext');
    	register_setting( 'wshk_options', 'wshk_enableloginform');
    	register_setting( 'wshk_options', 'wshk_loginredi');
    	register_setting( 'wshk_options', 'wshk_blockmya');
    	register_setting( 'wshk_options', 'wshk_enableaddtocarttxt');
    	register_setting( 'wshk_options', 'wshk_atctxtexternal');
    	register_setting( 'wshk_options', 'wshk_atctxtgrouped');
    	register_setting( 'wshk_options', 'wshk_atctxtsimple');
    	register_setting( 'wshk_options', 'wshk_atctxtvariable');
    	/*register_setting( 'wshk_options', 'wshk_atctxtntin');    */
    	register_setting( 'wshk_options', 'wshk_textbxpadding');
    	register_setting( 'wshk_options', 'wshk_textbtntxt');
    	register_setting( 'wshk_options', 'wshk_avshadow');
    	register_setting( 'wshk_options', 'wshk_textusernmpf');
    	register_setting( 'wshk_options', 'wshk_textusernmsf');
    	register_setting( 'wshk_options', 'wshk_enablegravatar');
    	register_setting( 'wshk_options', 'wshk_textgravasize');
    	register_setting( 'wshk_options', 'wshk_textgravashd');
    	register_setting( 'wshk_options', 'wshk_textgravabdsz');
    	register_setting( 'wshk_options', 'wshk_textgravabdtp');
    	register_setting( 'wshk_options', 'wshk_textgravabdcl');
    	register_setting( 'wshk_options', 'wshk_textgravabdrd');
    	register_setting( 'wshk_options', 'wshk_emailordersizes');
    	register_setting( 'wshk_options', 'wshk_excludecat');
    	register_setting( 'wshk_options', 'wshk_exfirstcat');
    	register_setting( 'wshk_options', 'wshk_exsecondcat');
    	register_setting( 'wshk_options', 'wshk_exthirdcat');
    	register_setting( 'wshk_options', 'wshk_enablecustomenu');
    	register_setting( 'wshk_options', 'wshk_menulocation');
    	register_setting( 'wshk_options', 'wshk_logmenu');
    	register_setting( 'wshk_options', 'wshk_nonlogmenu');
    	register_setting( 'wshk_options', 'wshk_enableshtmenu');
    	register_setting( 'wshk_options', 'wshk_enableuserinmenu');
    	register_setting( 'wshk_options', 'wshk_enablesloginsec');
    	register_setting( 'wshk_options', 'wshk_enablesadminbar');
    	register_setting( 'wshk_options', 'wshk_enablerestrictctnt');
    	register_setting( 'wshk_options', 'wshk_enableoffctnt');
    	register_setting( 'wshk_options', 'wshk_btnlogoutredi');
    	register_setting( 'wshk_options', 'wshk_showusername');
    	register_setting( 'wshk_options', 'wshk_showonlyname');
    	register_setting( 'wshk_options', 'wshk_showdisplay');
    	
    	register_setting( 'wshk_options', 'wshk_enableautocom');
    	register_setting( 'wshk_options', 'wshk_enableacustomshopage');
    	register_setting( 'wshk_options', 'wshk_shopageslug');
    	register_setting( 'wshk_options', 'wshk_enablehidelogerror');
    	register_setting( 'wshk_options', 'wshk_hidelogerrorcustomessage');
    	register_setting( 'wshk_options', 'wshk_enablesecheaders');

    	
    	register_setting( 'wshk_options', 'wshk_enableacustomthankyoupage');
    	register_setting( 'wshk_options', 'wshk_customthankyouoneid');
    	register_setting( 'wshk_options', 'wshk_customthankyouone');
    	register_setting( 'wshk_options', 'wshk_customthankyoutwoid');
    	register_setting( 'wshk_options', 'wshk_customthankyoutwo');
    	register_setting( 'wshk_options', 'wshk_customthankyouthreeid');
    	register_setting( 'wshk_options', 'wshk_customthankyouthree');
    	register_setting( 'wshk_options', 'wshk_customthankyougeneral');
    	
    	register_setting( 'wshk_options', 'wshk_gprdiread');
    	register_setting( 'wshk_options', 'wshk_gprdurlslug');
    	register_setting( 'wshk_options', 'wshk_gprdpolit');
    	register_setting( 'wshk_options', 'wshk_gprderror');
    	register_setting( 'wshk_options', 'wshk_gprduserlegalinfo');
    	register_setting( 'wshk_options', 'wshk_gprdsettings');
    	register_setting( 'wshk_options', 'wshk_gprdcomments');
    	register_setting( 'wshk_options', 'wshk_gprdorders');
    	register_setting( 'wshk_options', 'wshk_gprdreviews');
    	register_setting( 'wshk_options', 'wshk_gprdcomveri');
    	register_setting( 'wshk_options', 'wshk_gprdordveri');
    	register_setting( 'wshk_options', 'wshk_gprdrewveri');
    	register_setting( 'wshk_options', 'wshk_gprdregveri');
    	register_setting( 'wshk_options', 'wshk_gprdwcregisterform');
    	register_setting( 'wshk_options', 'wshk_wcregisterformfieldsextra');
    	/*Since v.1.8.6*/
    	register_setting( 'wshk_options', 'wshk_gprdireadcomments');
    	register_setting( 'wshk_options', 'wshk_gprdireadcheckout');
    	register_setting( 'wshk_options', 'wshk_gprdireadreviews');
    	register_setting( 'wshk_options', 'wshk_gprdireadregister');
    	/*end 1.8.6*/
    	
    	
    	register_setting( 'wshk_options', 'wshk_wcnewtermsbox ');
    	register_setting( 'wshk_options', 'wshk_termstexto');
    	register_setting( 'wshk_options', 'wshk_termslink');
    	register_setting( 'wshk_options', 'wshk_termstextlink');
        register_setting( 'wshk_options', 'wshk_enableskipcart');
    	
    	register_setting( 'wshk_options', 'wshk_gprdcommentsbdsize');
    	register_setting( 'wshk_options', 'wshk_gprdcommentsbdtype');
    	register_setting( 'wshk_options', 'wshk_gprdcommentsbdcolor');
    	register_setting( 'wshk_options', 'wshk_gprdcommentsbdradius');
    	register_setting( 'wshk_options', 'wshk_gprdcommentspadding');
    	register_setting( 'wshk_options', 'wshk_gprdcommentsbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutbdsize');
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutbdtype');
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutbdcolor');
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutbdradius');
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutpadding');
    	register_setting( 'wshk_options', 'wshk_gprdcheckoutbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_gprdreviewsbdsize');
    	register_setting( 'wshk_options', 'wshk_gprdreviewsbdtype');
    	register_setting( 'wshk_options', 'wshk_gprdreviewsbdcolor');
    	register_setting( 'wshk_options', 'wshk_gprdreviewsbdradius');
    	register_setting( 'wshk_options', 'wshk_gprdreviewspadding');
    	register_setting( 'wshk_options', 'wshk_gprdreviewsbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_gprdregisterbdsize');
    	register_setting( 'wshk_options', 'wshk_gprdregisterbdtype');
    	register_setting( 'wshk_options', 'wshk_gprdregisterbdcolor');
    	register_setting( 'wshk_options', 'wshk_gprdregisterbdradius');
    	register_setting( 'wshk_options', 'wshk_gprdregisterpadding');
    	register_setting( 'wshk_options', 'wshk_gprdregisterbgcolor');
    	
    	
    	
    	register_setting( 'wshk_options', 'wshk_enablesemab');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntdash');
    	register_setting( 'wshk_options', 'wshk_editdashb');
    	register_setting( 'wshk_options', 'wshk_editaftdashb');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntord');
    	register_setting( 'wshk_options', 'wshk_editorde');
    	register_setting( 'wshk_options', 'wshk_editaftorde');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntdow');
    	register_setting( 'wshk_options', 'wshk_editdown');
    	register_setting( 'wshk_options', 'wshk_editaftdown');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntadd');
    	register_setting( 'wshk_options', 'wshk_editaddre');
    	register_setting( 'wshk_options', 'wshk_editaftaddre');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntpay');
    	register_setting( 'wshk_options', 'wshk_editpaym');
    	register_setting( 'wshk_options', 'wshk_editaftpaym');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntrev');
    	register_setting( 'wshk_options', 'wshk_editrevi');
    	register_setting( 'wshk_options', 'wshk_editaftrevi');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntedi');
    	register_setting( 'wshk_options', 'wshk_editedit');
    	register_setting( 'wshk_options', 'wshk_editaftedit');
    	
    	register_setting( 'wshk_options', 'wshk_enablescontntlog');
    	register_setting( 'wshk_options', 'wshk_editlogo');
    	register_setting( 'wshk_options', 'wshk_editaftlogo');
    	
    	register_setting( 'wshk_options', 'wshk_tabsbdsize');
    	register_setting( 'wshk_options', 'wshk_tabsbdtype');
    	register_setting( 'wshk_options', 'wshk_tabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_tabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_tabspdtop');
    	register_setting( 'wshk_options', 'wshk_tabspdright');
    	register_setting( 'wshk_options', 'wshk_tabspdbottom');
    	register_setting( 'wshk_options', 'wshk_tabspdleft');
    	
    	register_setting( 'wshk_options', 'wshk_tabstxtsize');
    	register_setting( 'wshk_options', 'wshk_tabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_tabstxtalign');
    	register_setting( 'wshk_options', 'wshk_tabstxtdeco');
    	
    	register_setting( 'wshk_options', 'wshk_tabsbgcolor');
    	register_setting( 'wshk_options', 'wshk_tabswdsize');
    	register_setting( 'wshk_options', 'wshk_tabshgsize');
    	
    	
    	register_setting( 'wshk_options', 'wshk_actabsbdsize');
    	register_setting( 'wshk_options', 'wshk_actabsbdtype');
    	register_setting( 'wshk_options', 'wshk_actabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_actabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_actabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_actabstxtdeco');
    	register_setting( 'wshk_options', 'wshk_actabsbgcolor');
    	
    	
    	register_setting( 'wshk_options', 'wshk_hotabsbdsize');
    	register_setting( 'wshk_options', 'wshk_hotabsbdtype');
    	register_setting( 'wshk_options', 'wshk_hotabsbdcolor');
    	register_setting( 'wshk_options', 'wshk_hotabsbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_hotabstxtcolor');
    	register_setting( 'wshk_options', 'wshk_hotabstxtdeco');
    	register_setting( 'wshk_options', 'wshk_hotabsbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_contbbdsize');
    	register_setting( 'wshk_options', 'wshk_contbbdtype');
    	register_setting( 'wshk_options', 'wshk_contbbdcolor');
    	register_setting( 'wshk_options', 'wshk_contbbdradius');
    	
    	register_setting( 'wshk_options', 'wshk_contbpdtop');
    	register_setting( 'wshk_options', 'wshk_contbpdright');
    	register_setting( 'wshk_options', 'wshk_contbpdbottom');
    	register_setting( 'wshk_options', 'wshk_contbpdleft');
    	
    	register_setting( 'wshk_options', 'wshk_contbctheight');
    	register_setting( 'wshk_options', 'wshk_contbctbgcolor');
    	
    	register_setting( 'wshk_options', 'wshk_keeplastab');
    	register_setting( 'wshk_options', 'wshk_choosingstyles');
    	
    	
    	register_setting( 'wshk_options', 'wshk_icondashb');
    	register_setting( 'wshk_options', 'wshk_iconorder');
    	register_setting( 'wshk_options', 'wshk_icondownl');
    	register_setting( 'wshk_options', 'wshk_iconaddre');
    	register_setting( 'wshk_options', 'wshk_iconpayme');
    	register_setting( 'wshk_options', 'wshk_iconrevie');
    	register_setting( 'wshk_options', 'wshk_iconedita');
    	register_setting( 'wshk_options', 'wshk_iconlogou');
    	
    	register_setting( 'wshk_options', 'wshk_enablescusre');
    	register_setting( 'wshk_options', 'wshk_vieworderid');
    	register_setting( 'wshk_options', 'wshk_miaddressesid');
    	register_setting( 'wshk_options', 'wshk_mipaymentsid');
    	register_setting( 'wshk_options', 'wshk_viewsubscriptionid');
    	
    	
    	register_setting( 'wshk_options', 'wshk_enablecustomblockss');
    	
    	register_setting( 'wshk_options', 'wshk_enablescusrecharts');
    	
    	register_setting( 'wshk_options', 'wshk_tbcharttitleone');
    	register_setting( 'wshk_options', 'wshk_tbcharttitletwo');
    	register_setting( 'wshk_options', 'wshk_tbcharttitletres');
    	register_setting( 'wshk_options', 'wshk_tbcharttitlefour');
    	register_setting( 'wshk_options', 'wshk_tbcharttitlefive');
    	register_setting( 'wshk_options', 'wshk_tbcharttitlesix');
    	register_setting( 'wshk_options', 'wshk_tbcharttitleseven');
    	
    	register_setting( 'wshk_options', 'wshk_occharttitleone');
    	register_setting( 'wshk_options', 'wshk_occharttitletwo');
    	register_setting( 'wshk_options', 'wshk_occharttitletres');
    	register_setting( 'wshk_options', 'wshk_occharttitlefour');
    	register_setting( 'wshk_options', 'wshk_occharttitlefive');
    	register_setting( 'wshk_options', 'wshk_occharttitlesix');
    	register_setting( 'wshk_options', 'wshk_occharttitleoseven');
    	
    	register_setting( 'wshk_options', 'wshk_enablebillinguserdata');
    	register_setting( 'wshk_options', 'wshk_enableshippinguserdata');
    	register_setting( 'wshk_options', 'wshk_enabletotalspender');
    	register_setting( 'wshk_options', 'wshk_enableordercountser');
    	register_setting( 'wshk_options', 'wshk_enableproimage');
    	
    	register_setting( 'wshk_options', 'wshk_prodimagesize');
    	register_setting( 'wshk_options', 'wshk_prodimagebordsize');
    	register_setting( 'wshk_options', 'wshk_prodimagebordtype');
    	register_setting( 'wshk_options', 'wshk_prodimagebordcolor');
    	register_setting( 'wshk_options', 'wshk_prodimagebordradius');
    	
    	
    	
    	register_setting( 'wshk_options', 'wshk_onlyoneincartt');
    	register_setting( 'wshk_options', 'wshk_productsincart');
    	
    	register_setting( 'wshk_options', 'wshk_returntoshopbtn');
    	register_setting( 'wshk_options', 'wshk_retshopbtntext');
    	register_setting( 'wshk_options', 'wshk_retshopurlredi');
    	
    	register_setting( 'wshk_options', 'wshk_enableelemtbdetect');
    	
    	register_setting( 'wshk_options', 'wshk_enablesubscription');
    	register_setting( 'wshk_options', 'wshk_enablesubscriptionshortcode');
    	
    	/*cbar v.1.0.8*/
    	register_setting( 'wshk_options', 'wshk_enablecustomeravataruploader');
    	register_setting( 'wshk_options', 'wshk_enablecustomeravatarshortcode');
    	/*cbar v.1.0.9 -now WSHK PRO*/
    	register_setting( 'wshk_options', 'wshk_enablecustomblockselementor');
    	register_setting( 'wshk_options', 'wshk_enablewshkshortcodeselementor');
    	register_setting( 'wshk_options', 'wshk_enablewshkcustomelemlibrary');
    	register_setting( 'wshk_options', 'wshk_enablerestrictcategories');
    	/*WSHK PRO v.1.1.0*/
    	register_setting( 'wshk_options', 'wshk_enabledivitbdetect');
    	register_setting( 'wshk_options', 'wshk_customdivitabsmodule');
    	register_setting( 'wshk_options', 'wshk_customdivitextsmodule');
    	
    	
	}
	add_action( 'admin_init', 'wshk_register_settings' );
	endif;

/** Define plugin settings page html */

	if(!function_exists('init_woo_shortcodes_kit_admin_page_html')):

	function init_woo_shortcodes_kit_admin_page_html()
	{
    
    //esto es para la caja de .css
    
    if(get_option('wshk-inlinecss')!='')
	{
    $inlineCss=get_option('wshk-inlinecss');
    	}
    else {
    $inlineCss='.wshk {width: 50%;}
	.wshk .wshk-count{ 
    	color:#a46497;font-weight:bold;font-size:18px;
    	}
	.wshk .wshk-text {font-size: 12px;}';
        }
?>

<!-- HTML START -->
<style>


  .probando {
    background-color: #c6adc2;
    border: 1px solid #c6adc2;
    border-radius: 13px;
    color: white;
    padding: 16px 32px;
    width: 50%;
    height: 55px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-weight: 900;
    text-transform: uppercase;
    font-size: 14px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.3s; /* Safari */
    transition-duration: 0.3s;
    cursor: pointer;
    letter-spacing: 1px;
}


.probando:Hover {
    background-color: #a46497; 
    color: white; 
    border: 1px solid #a46497;
    border-radius: 13px;
}

input[type=checkbox].testininputclass{
	height: 0;
	width: 0;
	visibility: hidden;
}

label.testintheclass {
	cursor: pointer;
	text-indent: -9999px;
	width: 64px;
	height: 32px;
	background: #f2f7f6;
	display: block;
	border-radius: 100px;
	position: relative;
}

label.testintheclass:after {
	content: '';
	position: absolute;
	top: 5px;
	left: 5px;
	width: 22px;
	height: 22px;
	background: #c6adc2;
	border-radius: 90px;
	transition: 0.3s;
}

input:checked + label.testintheclass {
	background: #f2f7f6;
}

input:checked + label.testintheclass:after {
	left: calc(100% - 5px);
	transform: translateX(-100%);
	background: #aadb4a;
}

label.testingtheclass:active:after {
	width: 50px;
}

// centering
body {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
}
input[type="number"].testininputclass,
input[type="text"].testininputclass
{
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 100%;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 45px;
}
/*input[type="textarea"]*/
.textarea
{


/*box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 100%;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 245px;*/


box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    display: block;
    width: 500px;
    padding: 7px;
    border: none;
    border-bottom: 1px solid #ddd;
    background: transparent;
    margin-bottom: 10px;
    font: 16px Arial, Helvetica, sans-serif;
    height: 45px;
    resize:none;
    overflow: hidden;
}

.wp-admin select {
    padding: 2px;
    line-height: 28px;
    height: 48px !important;
    border: 1px solid transparent !important;
}


/* Style the element that is used to open and close the accordion class */
div.accordion {
 background-color: #a46497;
 color: #fff;
 cursor: pointer;
 padding: 18px;
 width: 96%;
 text-align: left;
 border: none;
 border-radius: 13px;
 outline: none;
 transition: 0.4s;
 margin-bottom:10px;
}
/* Add a background color to the accordion if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
div.accordion.active, p.accordion:hover {
 background-color: #c6adc2;
}
/* Unicode character for "plus" sign (+) */
div.accordion:after {
 content: "<?php esc_html_e( 'Show Advanced Options', 'woo-shortcodes-kit' ); ?> \1f441";
 font-size: 15px;
 color: #fff;
 float: right;
 margin-left: 5px;
 margin-top: -20px;
}
/* Unicode character for "minus" sign (-) */
div.accordion.active:after {
 content: "<?php esc_html_e( 'Hide Advanced Options', 'woo-shortcodes-kit' ); ?>  \1f5d9";
 font-size: 15px;
 color: #a46497;
 float: right;
 margin-left: 5px;
 margin-top: -20px;
}
/* Style the element that is used for the panel class */
div.panel {
 padding: 0 18px;
 background-color: transparent;
 max-height: 0;
 overflow: hidden;
 transition: 0.4s ease-in-out;
 opacity: 0;
 margin-bottom:10px;
}
div.panel.show {
 opacity: 1;
 max-height: 100%; /* Whatever you like, as long as its more than the height of the content (on all screen sizes) */
}


/*COPY BUTTON AND TOOLTIPS STYLE*/

.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 200px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}

</style>












<script>
document.addEventListener("DOMContentLoaded", function(event) {
var acc = document.getElementsByClassName("accordion");
var panel = document.getElementsByClassName('panel');
for (var i = 0; i < acc.length; i++) {
 acc[i].onclick = function() {
 var setClasses = !this.classList.contains('active');
 setClass(acc, 'active', 'remove');
 setClass(panel, 'show', 'remove');
 if (setClasses) {
 this.classList.toggle("active");
 this.nextElementSibling.classList.toggle("show");
 }
 }
}
function setClass(els, className, fnName) {
 for (var i = 0; i < els.length; i++) {
 els[i].classList[fnName](className);
 }
}
});
</script>
<div style="width: 90%; padding: 10px; margin: 10px;">
 <div style="width: 100%;background-color: #a46497; border: 1px solid #a46497; border-radius: 13px; padding: 20px;"><h1><span style="color: white;">Woo Shortcodes Kit v 1.8.<small>9</small></span><span style="font-size: 12px; color: #c6adc2; float: right;margin-top: 35px;"><?php  echo get_num_queries(); ?> <?php esc_html_e( 'Queries in', 'woo-shortcodes-kit' ); ?> <?php timer_stop(1); ?>  <?php esc_html_e( 'seconds', 'woo-shortcodes-kit' ); ?>
 </span></h1>
 
 </div>
 <!-- Start Options Form -->
 
 <form action="options.php" method="post" id="wshk-sidebar-admin-form">    
 &nbsp;
 <br />
 
 


 
 <div id="wshk-tab-menu" style="width:100%;">
     
     
     
     <a id="wshk-general" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 85px;text-transform: uppercase;letter-spacing: 1px;" class="wshk-tab-links active" ><img src="<?php echo  plugins_url( 'images/newsett.png
' , __FILE__ );?> " style="width: 48px; height: 48px; padding-bottom: 15px;"><span style="text-align: center;"><br /><?php esc_html_e( 'Settings', 'woo-shortcodes-kit' ); ?></span></a>
     
     
     <!--<a  id="wshk-support" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 100px;text-transform: uppercase;letter-spacing: 1px;"  class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/thshortcodes.png' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;" ;><br /><span style="margin-left: -5px;"><?php esc_html_e( 'Shortcodes', 'woo-shortcodes-kit' ); ?></span></a>-->
     
     <a  id="wshk-news" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 85px;text-transform: uppercase;letter-spacing: 1px;"  class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/notification4.png' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;" ;><br /><span style="margin-left: -5px;"><?php esc_html_e( 'News', 'woo-shortcodes-kit' ); ?></span></a>
     

     <a  id="wshk-languages" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: auto;text-transform: uppercase;letter-spacing: 1px;" class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/languageswshk.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;"><span style="text-align: center;"><br /><?php esc_html_e( 'Languages', 'woo-shortcodes-kit' ); ?></span></a>
     
     
     <a  id="wshk-recom" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 85px;text-transform: uppercase;letter-spacing: 1px;"  class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/recomend.png' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;" ;><br /><span style="margin-left: -22px;"><?php esc_html_e( 'Recommended', 'woo-shortcodes-kit' ); ?></span></a>
     
     <a  id="wshk-contact" style="border: 1px solid white; border-radius: 13px; height: 95px;padding-top: 20px;padding-bottom: 10px; text-align: center;width: 85px;text-transform: uppercase;letter-spacing: 1px;" class="wshk-tab-links"><img src="<?php echo  plugins_url( 'images/newcont.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 15px;"><span style="text-align: center;"><br /><?php esc_html_e( 'Contact', 'woo-shortcodes-kit' ); ?></span></a>

    <?php
    //Since 1.7.3
    //CHECK IF CUSTOM REDIRECTIONS EXISTS
    /*if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
       include( ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/license/main-wshk-license.php' );
        }*/
        ?>


 </div>
 
 
 
<div class="wshk-setting">

    <!-- General Setting -->   
    
      
    <br />
     
    <div class="first wshk-tab" id="div-wshk-general">
        
        
    <!-- Inicio caja blanca -->
    
    <div style="background-color: white; width: 100%; padding: 20px 20px 20px 20px;border: 1px solid white; border-radius: 13px;">
        
        <!-- caja info ajustes -->
        
         <div style="padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
    <table width="100%">
        <tr>
            <td style="width:90%">
                <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Functions and Shortcodes', 'woo-shortcodes-kit' ); ?></span>
    </h2>
            </td>
            <td>
                <!--<a href="#" target="_blank" style="background-color:#a46497;padding:15px;border-radius:13px;" ><span style="font-size:26px;color:#ffffff;" class="dashicons dashicons-book"> </span> </a>-->
            </td>
        </tr>
    </table>         
    
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Just need make a click in each section to view the functions and shortcodes.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Enable & configure the functions.', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(Some functions use a shortcode to be displayed in the Frontend)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    
    
    
  
  <!-- estilos para container accordion principal -->
    <style>

.pcontainer {
  width: 100%;
  /*margin: 0 auto;*/
  
}

.acc {
  margin-top: 50px;
  overflow: hidden;
  /*padding: 0;*/
}

.acc li {
  list-style-type: none;
  /*padding: 0;*/
}

.acc_ctrl {
  /*background: #FFFFFF;*/
  background: linear-gradient(45deg, #f7f7f7, #ffffff);
  border: 1px solid #f7f7f7;
  border-bottom: solid 1px #f7f7f7;
  cursor: pointer;
  display: block;
  outline: none;
  padding: 2em;
  position: relative;
  text-align: left;
  width: 98%;
}

.acc_ctrl:before {
  /*background: #44596B;*/
  content: '';
  height: 2px;
  margin-right: 37px;
  position: absolute;
  right: 0;
  top: 50%;
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
  -webkit-transition: all 0.2s ease-in-out;
  -moz-transition: all 0.2s ease-in-out;
  -ms-transition: all 0.2s ease-in-out;
  -o-transition: all 0.2s ease-in-out;
  transition: all 0.2s ease-in-out;
  width: 14px;
}

.acc_ctrl:after {
  /*background: #44596B;*/
  content: '';
  height: 2px;
  margin-right: 37px;
  position: absolute;
  right: 0;
  top: 50%;
  width: 14px;
}

.acc_ctrl.active:before {
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -ms-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
}

.acc_ctrl.active h2, .acc_ctrl:focus h2 {
  position: relative;
}

.acc_panel {
  /*background: #F2F2F2;*/
  display: none;
  overflow: hidden;
}

</style>
<!-- fin estilos accordion principal -->


<!-- inicio accordion principal -->
<div class="pcontainer">
  <ul class="acc">
      
      <!-- cada li una funcion -->
    <li>
      <!-- CONDITIONAL aND CUSTOMIZABLE MENU SECTION -->
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-menu"></span> <?php esc_html_e( 'DYNAMIC NAVIGATION MENU', 'woo-shortcodes-kit' ); ?></h3></div>
      
      <!-- contenido primer accordion -->
      <div class="acc_panel">
          <br /><br />
          

  <!-- CUSTOMIZE MENU - CONDITIONAL MENU -->
  
  
  
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablecustomenu" name="wshk_enablecustomenu" value='17' <?php if(get_option('wshk_enablecustomenu')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablecustomenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Conditional menu', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<?php
/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
$menus = get_registered_nav_menus(); ?>

<p><b>1.- <?php esc_html_e( 'Choose the location from the menu where you want to apply the changes', 'woo-shortcodes-kit' ); ?></b><br />

<small><?php esc_html_e( 'Menu locations detected: ', 'woo-shortcodes-kit' ); echo count($menus);?></small>
</p>
<br /> 
<select name="wshk_menulocation" id="wshk_menulocation" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;">
<option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
<?php
foreach($menus as $location => $description):
echo '<option value="'.$location.'">'.$description.'</option>';
endforeach;
$getopciones = get_option('wshk_menulocation');
?>
<option style="background-color:#a46497;color:white;" value="<?php echo $getopciones; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($menus as $location => $description): if($location == $getopciones): echo $description; endif; endforeach; ?></option>
</select>


<br /><br /><br />
<?php $menutt = wp_get_nav_menus(); ?>
<p><b>2.- <?php esc_html_e( 'Indicates which menu each user will see, according to the status of their session', 'woo-shortcodes-kit' ); ?></b><br />

<small><?php esc_html_e( 'Menus detected: ', 'woo-shortcodes-kit' ); echo count($menutt);?></small>
<br /><br />
<table>
    <tr>
    <td style="padding: 30px;">
           
    <p><?php esc_html_e( 'Choose the menu for logged in users:', 'woo-shortcodes-kit' ); ?><br /><br /> 
    
   <select name="wshk_logmenu" id="wshk_logmenu" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;">
<option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
<?php
$menutt = wp_get_nav_menus();
foreach( $menutt as $menuti):
    
echo '<option value="'.$menuti->name.'">'.$menuti->name.'</option>';

endforeach;
$getopcionett = get_option('wshk_logmenu');

?>
<option style="background-color:#a46497;color:white;" value="<?php echo $getopcionett; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($menutt as $menuti): if($menuti->name == $getopcionett): echo $menuti->name; endif; endforeach; ?></option>
</select><br>
    
    
    
    
    
    
    <small><?php esc_html_e( 'You can choose a menu from those available or', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="/wp-admin/nav-menus.php?action=edit&menu=0" target="_blank"><?php esc_html_e( 'create a new menu', 'woo-shortcodes-kit' ); ?></a></small></p>    
    
    
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid;">         
    <p><?php esc_html_e( 'Choose the menu for non logged in users:', 'woo-shortcodes-kit' ); ?><br /><br /> 
    
    
    
    <select name="wshk_nonlogmenu" id="wshk_nonlogmenu" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;">
<option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
<?php
$menutt = wp_get_nav_menus();
foreach( $menutt as $menuti):
    
echo '<option value="'.$menuti->name.'">'.$menuti->name.'</option>';

endforeach;
$getopcionettt = get_option('wshk_nonlogmenu');

?>
<option style="background-color:#a46497;color:white;" value="<?php echo $getopcionettt; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($menutt as $menuti): if($menuti->name == $getopcionettt): echo $menuti->name; endif; endforeach; ?></option>
</select>
<br>

     <small><?php esc_html_e( 'You can choose a different menu from those available or', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="/wp-admin/nav-menus.php?action=edit&menu=0" target="_blank"><?php esc_html_e( 'create a new menu', 'woo-shortcodes-kit' ); ?></a></small></p>
    
    
    <br /><br />
    </td>                    
    
    </tr>
    </table>
    <br />
    
    <p><b>3.- <?php esc_html_e( 'Remember Save the changes!', 'woo-shortcodes-kit' ); ?></b></p>
    <small><?php esc_html_e( 'The settings will only be applied from the moment you save the settings. You can continue to configure other functions, although it is recommended, before continuing ', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="#toggle" ><?php esc_html_e( 'save the settings', 'woo-shortcodes-kit' ); ?></a></small></p>
    
    <br /><br />
    </div>
  
  <!-- FIN CUSTOMIZE MENU - CONDITIOANL MENU -->
  
  
  
  <!-- CUSTOMIZE MENU - ENABLE SHORTCODES IN MENU TITLES -->
  
  <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableshtmenu" name="wshk_enableshtmenu" value='18' <?php if(get_option('wshk_enableshtmenu')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableshtmenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Shortcodes in menu titles', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<p><b><?php esc_html_e( 'Once the function is activated, you can add a shortcode in each menu item title.', 'woo-shortcodes-kit' ); ?></b></p>
    <p><?php esc_html_e( 'You can combine this function with the others of the same category.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>
  
  <!-- FIN CUSTOMIZE MENU - ENABLE SHORTCODES IN MENU TITLE -->
  
  
  
  
  <!-- CUSTOMIZE MENU - ENABLE USERNAME IN MENU SHORTCODE -->
  
  <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableuserinmenu" name="wshk_enableuserinmenu" value='19' <?php if(get_option('wshk_enableuserinmenu')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableuserinmenu></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Username in menu title', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'UPDATED', 'woo-shortcodes-kit' ); ?></span></big><br /><small> <?php esc_html_e( 'Just need activate and paste the shortcode in your menu item title!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"> 
<br><br>

<p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[wshk_user_in_menu]" id="wshkuserinmenu" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionwshkuserinmenu()" onmouseout="outFuncwshkuserinmenu()">
  <span class="tooltiptext" id="myTooltipwshkuserinmenu"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("wshkuserinmenu").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionwshkuserinmenu() {
  var copyText = document.getElementById("wshkuserinmenu");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipwshkuserinmenu = document.getElementById("myTooltipwshkuserinmenu");
  tooltipwshkuserinmenu.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncwshkuserinmenu() {
  var tooltipwshkuserinmenu = document.getElementById("myTooltipwshkuserinmenu");
  tooltipwshkuserinmenu.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste on any page or post', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>


<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Display options', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Choose what should display the shortcode', 'woo-shortcodes-kit' ); ?></small></p>
    <br /><br />






    <p> <?php esc_html_e( 'Choose the option that you want display with this shortcode', 'woo-shortcodes-kit' ); ?>
    
    <br /><br /> 
    
    <select name="wshk_userinmenuoptions" id="wshk_userinmenuoptions" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> 
    
    <option <?php if (get_option('wshk_userinmenuoptions') == 'showus') { ?>selected="true" <?php }; ?> value="showus"><?php esc_html_e( 'Login user', 'woo-shortcodes-kit' ); ?></option> 
    
    <option <?php if (get_option('wshk_userinmenuoptions') == 'showonly') { ?>selected="true" <?php }; ?> value="showonly"><?php esc_html_e( 'Only the name', 'woo-shortcodes-kit' ); ?></option> 
    
    <option <?php if (get_option('wshk_userinmenuoptions') == 'showdispl') { ?>selected="true" <?php }; ?> value="showdispl"><?php esc_html_e( 'Display name', 'woo-shortcodes-kit' ); ?></option> 
    
    </select> 
    
    <br />
    
    </p>
<br><br><br>

    </div>
  
  <!-- FIN CUSTOMIZE MENU - ENABLE USERNAME IN MENU SHORTCODE -->
  
      </div>
    </li>
  <!-- fin CONDITIONAL MENU SECTION -->  
  
  
  
  <!-- CUSTOMIZE THE SHOP PAGE SECTION START -->

<!-- titular -->    
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-store"></span> <?php esc_html_e( 'CUSTOMIZE THE SHOP PAGE OR BUILD A NEW', 'woo-shortcodes-kit' ); ?></h3></div>
      
      <!-- FIN de titular -->
      
      <div class="acc_panel">
          <br /><br />
          
          
          
<!-- CUSTOMIZE THE SHOP PAGE - Display only products of specifics categories -->
          
          <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablecat" name="wshk_enablecat" value='4' <?php if(get_option('wshk_enablecat')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablecat></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Show only products from specific categories on the shop page', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <p><b><?php esc_html_e( 'Choose the category you want to display on the shop page.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can add 3 different categories to display', 'woo-shortcodes-kit' ); ?>:</small></p>
    <table width="100%">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'First Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        <select id="wshk_firstcat" name="wshk_firstcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
  <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
  
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes 
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        //echo '<option value="'.$category->slug.'">'.$category->name.' ('.$category->category_count.')</option>';
        
    }
    $getopcatfirst = get_option('wshk_firstcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatfirst; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatfirst): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>

        </td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Second Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        <select id="wshk_secondcat" name="wshk_secondcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
    <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
    
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes  
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        
    }
    
    $getopcatsecond = get_option('wshk_secondcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatsecond; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatsecond): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>
        </td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Third Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        
        <select id="wshk_thirdcat" name="wshk_thirdcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
    <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
    
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes  
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        
    }
    $getopcatthird = get_option('wshk_thirdcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatthird; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatthird): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>
        </td></tr>
        
        <br />
        <br />
        </table><br><br><br>
        </div>
    <!-- FIN display only products of specifics categories -->
    
    
    
    <!-- Excluse products of specifics categories -->
    
    
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_excludecat" name="wshk_excludecat" value='16' <?php if(get_option('wshk_excludecat')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_excludecat></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Exclude products from specific categories on the shop page', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
<br><br>
        <p><b><?php esc_html_e( 'Choose the category you want to exclude on the shop page.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can add 3 different categories to exclude', 'woo-shortcodes-kit' ); ?>:</small></p>
    <table width="100%">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'First Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        
        
        <select id="wshk_exfirstcat" name="wshk_exfirstcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
  <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
  
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes 
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        //echo '<option value="'.$category->slug.'">'.$category->name.' ('.$category->category_count.')</option>';
        
    }
    $getopcatfirstex = get_option('wshk_exfirstcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatfirstex; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatfirstex): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>
        
        
        </td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Second Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        
        
        <select id="wshk_exsecondcat" name="wshk_exsecondcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
  <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
  
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes 
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        //echo '<option value="'.$category->slug.'">'.$category->name.' ('.$category->category_count.')</option>';
        
    }
    $getopcatsecondex = get_option('wshk_exsecondcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatsecondex; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatsecondex): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>
        
        
        </td>
        
        <td style="width: 33%; padding-left: 30px;"><p><big><strong><?php esc_html_e( 'Third Category:', 'woo-shortcodes-kit' ); ?></strong></big><br /></p>
        
        <select id="wshk_exthirdcat" name="wshk_exthirdcat" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
  <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option>
  
    <?php 
    
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for no, 0 for yes
  $pad_counts   = 0;      // 1 for no, 0 for yes
  $hierarchical = 1;      // 1 for no, 0 for yes 
  $title        = '';  
  $empty        = 0;

  $args = array(
         'taxonomy'     => $taxonomy,
         'orderby'      => $orderby,
         'show_count'   => $show_count,
         'pad_counts'   => $pad_counts,
         'hierarchical' => $hierarchical,
         'title_li'     => $title,
         'hide_empty'   => $empty
  );
    $categories = get_categories($args); 
    foreach ( $categories as $category ) {
        printf( '<option value="%1$s">%2$s (%3$s)</option>',
            esc_html( $category->slug ),
            esc_html( $category->cat_name ),
            esc_html( $category->category_count )
        );
        //echo '<option value="'.$category->slug.'">'.$category->name.' ('.$category->category_count.')</option>';
        
    }
    $getopcatthirdex = get_option('wshk_exthirdcat');
    ?>
    <option style="background-color:#a46497;color:white;" value="<?php echo $getopcatthirdex; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($categories as $category): if($category->slug == $getopcatthirdex): echo $category->name .' ('.$category->category_count.')'; endif; endforeach; ?></option>
</select>
        
        
        
        </td></tr>
        
        <br />
        <br />
        </table><br><br><br>
        </div>
      <!-- FIN exclude products of specifics categories -->
      
      <!-- products per page manager -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
        <th><p><input type="checkbox" class="testininputclass" id="wshk_perpage" name="wshk_perpage" value='3' <?php if(get_option('wshk_perpage')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_perpage></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Products per page Manager', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>      
        </table>
</div>
<div class="panel">
    <br><br>
        <p><b><?php esc_html_e( 'Write the number of products to display per page', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'This function is also compatible with the functions: Show only/Exclude products from specific categories on the shop page', 'woo-shortcodes-kit' ); ?></small></p>
    <br /><br />
    <table>
        <tr>
        <p><?php esc_html_e( 'Number of products:', 'woo-shortcodes-kit' ); ?><br /><br /> <input type="number" class="testininputclass" id="wshk_nperpage" name="wshk_nperpage" value="<?php if(get_option('wshk_nperpage')!=''){ echo get_option('wshk_nperpage'); }?>" placeholder="<?php esc_html_e( "-1 to show all products", "woo-shortcodes-kit" ); ?>"/ size="20"><small> <?php esc_html_e( 'Write -1 to display All products', 'woo-shortcodes-kit' ); ?></small><br /></p>
        </tr>
        </table>
        <br><br>
        <p style="border: 1px solid #ddd;padding:10px;color:#a46497"><b><?php esc_html_e( 'This function is prepared to be compatible if you are using a DIVI theme, but sometimes it is not effective.', 'woo-shortcodes-kit' ); ?></b><br><small style="color:grey;"><?php esc_html_e( 'This is because DIVI already offers this function, so preference is given to the native function.', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'If you are using DIVI and the function is not working, go to: Divi Theme Options > General > Number of Products displayed on WooCommerce archive pages to configure it.', 'woo-shortcodes-kit' ); ?></small></p>
        <br />
        <br />
        </div>
        
<!-- FIN products per page manager -->


          
          
          
 <!-- customize add to cart text button if user has bought the product -->
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
  <tr>
  
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablebought" name="wshk_enablebought" value='5' <?php if(get_option('wshk_enablebought')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablebought></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big>    <?php esc_html_e( 'Conditional "Add to cart" button for purchased products', 'woo-shortcodes-kit' ); ?></big><br />
        <small><?php esc_html_e( 'Activate the function and clic here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
</table>


        
</div>
<div class="panel">
<br />
<br />
<b><?php esc_html_e( 'Change the text of the "Add to cart" button if the user has already purchased the product', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'The button will be modified on the store page, product summary and product archives.', 'woo-shortcodes-kit' ); ?></small>
<br><br>
        <table>
    <tr>
    
    <td><p> <?php esc_html_e( 'Write here the text to display in the button:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_buttontext" name="wshk_buttontext" value="<?php if(get_option('wshk_buttontext')!=''){ echo get_option('wshk_buttontext'); }?>" placeholder="<?php esc_html_e( "Downloaded/Bought", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    <br /></td>
    </tr>
    </table> 
    
        <br />      
        <br />
        </div>

<!-- fin customize add to cart button if user has bought the product -->

<!-- customize add to cart button by product type -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
  <tr>
  
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableaddtocarttxt" name="wshk_enableaddtocarttxt" value='14' <?php if(get_option('wshk_enableaddtocarttxt')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableaddtocarttxt></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Change the "Add to cart" button text', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'UPDATED', 'woo-shortcodes-kit' ); ?></span></big><br /><small>  <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
</table>


        
</div>
<div class="panel">
<br />
<br />
<p><b><?php esc_html_e( 'Change the text of the Add to cart button and write a different text in each case', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'If you dont need to modify the text for some type of product, the default text will be displayed.', 'woo-shortcodes-kit' ); ?></small><br><small><?php esc_html_e( 'This function is compatible with the modification of the button text if the user has purchased the product.', 'woo-shortcodes-kit' ); ?></small></p>
<br />
<br />
        <table>
    <tr>
    
    <td style="padding: 30px;">
    <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'external', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" id="wshk_atctxtexternal" name="wshk_atctxtexternal" value="<?php if(get_option('wshk_atctxtexternal')!=''){ echo get_option('wshk_atctxtexternal'); }?>" placeholder="<?php esc_html_e( "Buy this product", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'grouped', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" id="wshk_atctxtgrouped" name="wshk_atctxtgrouped" value="<?php if(get_option('wshk_atctxtgrouped')!=''){ echo get_option('wshk_atctxtgrouped'); }?>" placeholder="<?php esc_html_e( "View products", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
   
    </td>    
    <td style="padding: 30px; border-left: 1px solid;">
        
         <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'simple', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" id="wshk_atctxtsimple" name="wshk_atctxtsimple" value="<?php if(get_option('wshk_atctxtsimple')!=''){ echo get_option('wshk_atctxtsimple'); }?>" placeholder="<?php esc_html_e( "Add to cart", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
        
        <p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'variable', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" id="wshk_atctxtvariable" name="wshk_atctxtvariable" value="<?php if(get_option('wshk_atctxtvariable')!=''){ echo get_option('wshk_atctxtvariable'); }?>" placeholder="<?php esc_html_e( "Select options", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    
    <!--<p> <?php esc_html_e( 'Write here the text to display in the', 'woo-shortcodes-kit' ); ?> <strong><?php esc_html_e( 'default', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'products:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" id="wshk_atctxtntin" name="wshk_atctxtntin" value="<?php if(get_option('wshk_atctxtntin')!=''){ echo get_option('wshk_atctxtntin'); }?>" placeholder="<?php esc_html_e( "Read more", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>-->
    </td>
    </tr>
    </table> 
    
        <br />      
        <br />
        </div>
        
        <!-- FIN downloads/sales counter -->
        
        
        
         <!-- custom shop page -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enableacustomshopage" name="wshk_enableacustomshopage" value='85' <?php if(get_option('wshk_enableacustomshopage')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableacustomshopage></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Build a new shop page from scratch', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'UPDATED', 'woo-shortcodes-kit' ); ?></span></big><br /><small><?php esc_html_e( 'Just need activate the function and add your custom shop page slug!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>




<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'Choose the page of your new shop page', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'This function is compatible with any theme and page builder. You can design your new page in the same way as the others.', 'woo-shortcodes-kit' ); ?></small></p>

    <table>
          <colgroup>
    <!--<col span="3">
   
  </colgroup>-->
         <tr>
        <td style="width: 100%;">
        
        <select id="wshk_shopageslug" name="wshk_shopageslug" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          //var_dump($pages);
      
    /*$option = '<option value="' . get_page_link( $page->ID ) . '">';
    $option .= $page->post_title;
    $option .= '</option>';
    echo $option;*/
  }
$getopcushop = get_option('wshk_shopageslug');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopcushop; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopcushop): echo $page->post_title; endif; endforeach; ?></option>
</select>
        <br><br><br>
        <p><b>2.- <?php esc_html_e( 'Remember go to ', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;font-weight:600;text-decoration:underline;" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wc-settings&tab=products" target="_blank"><?php esc_html_e( 'WooCommerce settings', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( ' to disable the shop page option', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( ' Just need click in the WooCommerce settings link and remove the page from the shop page field.', 'woo-shortcodes-kit' ); ?></small></p>
        <br /><br /><br /> </td>
        
       </tr>
        
        <br />
        <br />
        </table>
        
        <p style="border: 1px solid #ddd;padding:10px;color:#a46497"><b><?php esc_html_e( 'If you use this function, some of the previous functions will no longer be useful.', 'woo-shortcodes-kit' ); ?></b><br><small style="color:grey;"><?php esc_html_e( 'Check that the following functions are not activated:', 'woo-shortcodes-kit' ); ?><br><br><?php esc_html_e( 'Show only products from specific categories on the shop page', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'Exclude products from specific categories on the shop page', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'Products per page manager', 'woo-shortcodes-kit' ); ?></small></p>
        <br />
        <br />
        </div>
    
 <!-- FIN custom shop page -->
        
        
      </div>
    </li>
    <!--FIN CUSTOMIZE SHOP PAGE SECTION -->
    
    
    
    
    
    
     <!-- BUILD YOUR CUSTOM ACCOUNT PAGE -->
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-buddicons-buddypress-logo"></span> <?php esc_html_e( 'BUILD YOUR CUSTOM ACCOUNT PAGE', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          <!--<div style="background-color:#f4f1ff;font-size:16px;padding:40px 20px 40px 20px;border:0px solid #a46497;border-radius:3px;color: #a46497;">
              <table width="100%" style="line-height:24px;">
                  
                 <tr>
                     
                     <td>
                         <span class="dashicons dashicons-info"></span><span><strong><?php esc_html_e( 'Now 40% exclusive discount', 'woo-shortcodes-kit' ); ?></strong> <?php esc_html_e( 'on the Custom Blocks & Redirections add-on!', 'woo-shortcodes-kit' ); ?><br> <?php esc_html_e( 'Use the Coupon code:', 'woo-shortcodes-kit' ); ?> <span style="font-weight:bolder;font-size:18px;">1MWSHKUS3R-JULY</span><br><small><?php esc_html_e( 'Expires on July 31, 2019', 'woo-shortcodes-kit' ); ?></small></span> 
                     </td>
                     
                     <td style="padding:20px 0px 0px 20px;">
                          <a href="http://bit.ly/getaddons" target="_blank" style="text-align: center; width: 110px; border: 1px solid #a46497; border-radius: 13px; background-color: #a46497; font-size: 17px; font-weight: bolder; color: white; padding: 15px;display:block;float:right;margin-top:-16px;"><span  style="color:white;"><?php esc_html_e( 'GET ADDONS', 'woo-shortcodes-kit' ); ?></span></a>
                     </td>
                 </tr> 
              </table>
              
              
              
              
             
              
              
              
              </div>-->
          <br><br>
          
          
          
           <!-- Order list shortcode and orders per page manager -->
     <div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableorderscontrol" name="wshk_enableorderscontrol" value='140' <?php if(get_option('wshk_enableorderscontrol')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableorderscontrol></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Orders list shortcode', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>

<div class="panel"><br /><br />
<p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
<div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_myorders]" id="woomyorders" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;cursor:pointer;" type="button" onclick="myFunction()" onmouseout="outFunc()">
  <span class="tooltiptext" id="myTooltip"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyorders").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunction() {
  var copyText = document.getElementById("woomyorders");
  copyText.select();
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span> <big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>


<table width="50%">
    <tr>    
    <td style="width: 35%;">
        <p><b>2.- <?php esc_html_e( 'Set the orders to display', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'By default 15 orders per page will be displayed', 'woo-shortcodes-kit' ); ?></small></p>
        <br>
    <div style="padding-left:30px;"><p> <?php esc_html_e( 'Number of orders', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" id="wshk_numeropedidos" name="wshk_numeropedidos"  value="<?php if(get_option('wshk_numeropedidos')!=''){ echo get_option('wshk_numeropedidos'); }?>" placeholder="15"/ size="10" ></p>     
   <small><?php esc_html_e( 'When the user has placed more orders than the established number, the pagination will appear below the table to navigate among the previous orders.', 'woo-shortcodes-kit' ); ?></small>
   </div>
    </td> 
            
    </tr>
   <br /><br />
    </table>
    <br><br><br>
    <p><b>3.- <?php esc_html_e( 'Link the function with his account container', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'This shortcode have an advanced action (view order details) and needs to be linked to a container.', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'To get it, you need the addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/easy-my-account-builder-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Easy My Account Builder', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( 'or the premium addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/custom-blocks-and-redirections-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Custom Blocks & Redirections', 'woo-shortcodes-kit' ); ?></a></small></p>
    <br /><br />
    </div>
    
  <!-- FIN order list shortcode and orders per page manager -->  
          
<!-- Downloads list shortcode -->
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablemydownloadsht" name="wshk_enablemydownloadsht" value='2000' <?php if(get_option('wshk_enablemydownloadsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablemydownloadsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Downloads list shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_mydownloads]" id="woomydownloads" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;cursor:pointer;" type="button" onclick="myFunctiondownloads()" onmouseout="outFuncdownloads()">
  <span class="tooltiptext" id="myTooltipdownloads"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomydownloads").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiondownloads() {
  var copyText = document.getElementById("woomydownloads");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipdownloads = document.getElementById("myTooltipdownloads");
  tooltipdownloads.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncdownloads() {
  var tooltipdownloads = document.getElementById("myTooltipdownloads");
  tooltipdownloads.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        </div>
    <!-- FIN downloads list shortcode -->
    
    
    
    <!-- Billing and shipping addresses shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablemyaddressessht" name="wshk_enablemyaddressessht" value='2001' <?php if(get_option('wshk_enablemyaddressessht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablemyaddressessht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Billing and shipping addresses shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
   <br><br>
   <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_myaddress]" id="woomyaddresses" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;cursor:pointer;" type="button" onclick="myFunctionaddresses()" onmouseout="outFuncaddresses()">
  <span class="tooltiptext" id="myTooltipaddresses"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyaddresses").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionaddresses() {
  var copyText = document.getElementById("woomyaddresses");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipaddresses = document.getElementById("myTooltipaddresses");
  tooltipaddresses.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncaddresses() {
  var tooltipaddresses = document.getElementById("myTooltipaddresses");
  tooltipaddresses.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Link the function with his account container', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'This shortcode have an advanced action (edit form address) and needs to be linked to a container.', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'To get it, you need the addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/easy-my-account-builder-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Easy My Account Builder', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( 'or the premium addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/custom-blocks-and-redirections-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Custom Blocks & Redirections', 'woo-shortcodes-kit' ); ?></a></small></p>
    <br /><br />
        </div>
    
    <!-- FIN billing and shipping addresses shortcode -->
    
    <!-- payment methods shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablemypaymentsht" name="wshk_enablemypaymentsht" value='2002' <?php if(get_option('wshk_enablemypaymentsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablemypaymentsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Payment methods shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>

    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_mypayment]" id="woomypayments" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;" type="button" onclick="myFunctionpayments()" onmouseout="outFuncpayments()">
  <span class="tooltiptext" id="myTooltippayments"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomypayments").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionpayments() {
  var copyText = document.getElementById("woomypayments");
  copyText.select();
  document.execCommand("copy");
  
  var tooltippayments = document.getElementById("myTooltippayments");
  tooltippayments.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncpayments() {
  var tooltippayments = document.getElementById("myTooltippayments");
  tooltippayments.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Link the function with his account container', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'This shortcode have an advanced action (add payment method form) and needs to be linked to a container.', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( 'To get it, you need the addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/easy-my-account-builder-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Easy My Account Builder', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( 'or the premium addon', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;text-decoration:underline;" href="https://disespubli.com/producto/custom-blocks-and-redirections-addon-for-wshk/" target="_blank"><?php esc_html_e( 'Custom Blocks & Redirections', 'woo-shortcodes-kit' ); ?></a></small></p>
    <br /><br />
        </div>
    
    <!-- FIN payment methods shortcode -->
    
    
    
    <!-- edit account shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablemyeditaccsht" name="wshk_enablemyeditaccsht" value='2003' <?php if(get_option('wshk_enablemyeditaccsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablemyeditaccsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Edit account shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border-color:#a46497;" type="text" value="[woo_myedit_account]" id="woomyeditaccount" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctioneditaccount()" onmouseout="outFunceditaccount()">
  <span class="tooltiptext" id="myTooltipeditaccount"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyeditaccount").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctioneditaccount() {
  var copyText = document.getElementById("woomyeditaccount");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipeditaccount = document.getElementById("myTooltipeditaccount");
  tooltipeditaccount.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunceditaccount() {
  var tooltipeditaccount = document.getElementById("myTooltipeditaccount");
  tooltipeditaccount.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 54%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        </div>
    
    <!-- FIN edit account shortcode -->
    
    
     <!-- dashboard shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enabledashbsht" name="wshk_enabledashbsht" value='2004' <?php if(get_option('wshk_enabledashbsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabledashbsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'Dashboard shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border-color:#a46497;" type="text" value="[woo_mydashboard]" id="woomydashboard" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiondashboard()" onmouseout="outFuncdashboard()">
  <span class="tooltiptext" id="myTooltipdashboard"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomydashboard").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiondashboard() {
  var copyText = document.getElementById("woomydashboard");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipdashboard = document.getElementById("myTooltipdashboard");
  tooltipdashboard.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncdashboard() {
  var tooltipdashboard = document.getElementById("myTooltipdashboard");
  tooltipdashboard.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>


<p style="padding-left:30px;"><span class="dashicons dashicons-warning"></span> <?php esc_html_e( 'This shortcode shows the dashboard of the WooCommerce my account page, but without the default text. It is only recommended to use if you have other plugins that need to display information on the dashboard, because if not it dont will display nothing.
', 'woo-shortcodes-kit' ); ?></p><br><br>
        </div>
    
    <!-- FIN dashboard shortcode -->
    
    
    
    <!-- user gravatar image -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablegravatar" name="wshk_enablegravatar" value='15' <?php if(get_option('wshk_enablegravatar')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablegravatar></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'User gravatar image shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_gravatar_image]" id="woomygravatar" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiongravatar()" onmouseout="outFuncgravatar()">
  <span class="tooltiptext" id="myTooltipgravatar"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomygravatar").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiongravatar() {
  var copyText = document.getElementById("woomygravatar");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipgravatar = document.getElementById("myTooltipgravatar");
  tooltipgravatar.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncgravatar() {
  var tooltipgravatar = document.getElementById("myTooltipgravatar");
  tooltipgravatar.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    
    
    <p><b>2.- <?php esc_html_e( 'Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but you must complete the fields for the image to be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    
    
    <br /><br /><table>
    <tr>
    <td style="padding: 30px; width: 50%;">
    <p> <?php esc_html_e( 'Gravatar size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_textgravasize" name="wshk_textgravasize" value="<?php if(get_option('wshk_textgravasize')!=''){ echo get_option('wshk_textgravasize'); }?>" placeholder="128px"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Gravatar shadow:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textgravashd" name="wshk_textgravashd" value="<?php if(get_option('wshk_textgravashd')!=''){ echo get_option('wshk_textgravashd'); }?>" placeholder="5px 5px 5px #c6adc2"/ size="50"><br /></p>
    
     <p> <?php esc_html_e( 'Border size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_textgravabdsz" name="wshk_textgravabdsz" value="<?php if(get_option('wshk_textgravabdsz')!=''){ echo get_option('wshk_textgravabdsz'); }?>" placeholder="4px"/ size="20"><br /></p>
    <br /><br />
    </td>
    <td style="padding: 30px; border-left: 1px solid; width: 50%;">    
    
   
    
    <p> <?php esc_html_e( 'Border type:', 'woo-shortcodes-kit' ); ?><br><br />
    <select name="wshk_textgravabdtp" id="wshk_textgravabdtp" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_textgravabdtp') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textgravabdtp') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textgravabdtp') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_textgravabdtp') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select><br><br /></p>
    
    <p> <?php esc_html_e( 'Boder color:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textgravabdcl" name="wshk_textgravabdcl" value="<?php if(get_option('wshk_textgravabdcl')!=''){ echo get_option('wshk_textgravabdcl'); }?>" placeholder="#ffffff"/ size="20"><br /></p>    
    
    <p> <?php esc_html_e( 'Border radius:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_textgravabdrd" name="wshk_textgravabdrd" value="<?php if(get_option('wshk_textgravabdrd')!=''){ echo get_option('wshk_textgravabdrd'); }?>" placeholder="100%"/ size="20"><br /></p>
    <br /><br /></td>
    
    
    </tr>
    </table>
    <br />
    <br />
    </div>

<!-- FIN user gravatar image -->



  <!-- display username with shortcode -->  
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableusername" name="wshk_enableusername" value='11' <?php if(get_option('wshk_enableusername')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableusername></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Username shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_user_name]" id="woomyusername" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionusername()" onmouseout="outFuncusername()">
  <span class="tooltiptext" id="myTooltipusername"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyusername").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionusername() {
  var copyText = document.getElementById("woomyusername");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipusername = document.getElementById("myTooltipusername");
  tooltipusername.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncusername() {
  var tooltipusername = document.getElementById("myTooltipusername");
  tooltipusername.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>

    
    
    <br><br><br>
    <p><b>2.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but you must complete the fields for the username to be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    <br /><br />
    
    
    
    <table>
    <tr>
    <td style="padding: 30px; width: 50%;"><br>
    <p> <?php esc_html_e( 'Text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textusernmpf" name="wshk_textusernmpf" value="<?php if(get_option('wshk_textusernmpf')!=''){ echo get_option('wshk_textusernmpf'); }?>" placeholder="<?php esc_html_e( "Hello", "woo-shortcodes-kit" ); ?>"/ size="50"><br /></p>
    
    <p> <?php esc_html_e( 'Text suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textusernmsf" name="wshk_textusernmsf" value="<?php if(get_option('wshk_textusernmsf')!=''){ echo get_option('wshk_textusernmsf'); }?>" placeholder="!"/ size="50"><br /></p> 
    
     <p> <?php esc_html_e( 'Choose the option that you want display with this shortcode', 'woo-shortcodes-kit' ); ?><br /><br /> <select name="wshk_showusername" id="wshk_showusername" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_showusername') == 'showus') { ?>selected="true" <?php }; ?> value="showus"><?php esc_html_e( 'Login user', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_showusername') == 'showonly') { ?>selected="true" <?php }; ?> value="showonly"><?php esc_html_e( 'Only the name', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_showusername') == 'showdispl') { ?>selected="true" <?php }; ?> value="showdispl"><?php esc_html_e( 'Display name', 'woo-shortcodes-kit' ); ?></option> </select> <br /></p>
    <br /><br /><br />
    </td>
    <td style="padding: 30px; border-left: 1px solid; width: 50%;">    
    
    <p> <?php esc_html_e( 'Text color:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_usernmtc" name="wshk_usernmtc" value="<?php if(get_option('wshk_usernmtc')!=''){ echo get_option('wshk_usernmtc'); }?>" placeholder="#ffffff"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Text size:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_usernmts" name="wshk_usernmts" value="<?php if(get_option('wshk_usernmts')!=''){ echo get_option('wshk_usernmts'); }?>" placeholder="16"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Text align:', 'woo-shortcodes-kit' ); ?><br /><br /> 
    
    <select name="wshk_usernmta" id="wshk_usernmta" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_usernmta') == 'left') { ?>selected="true" <?php }; ?> value="left"><?php esc_html_e( 'Left', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_usernmta') == 'center') { ?>selected="true" <?php }; ?> value="center"><?php esc_html_e( 'Center', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_usernmta') == 'right') { ?>selected="true" <?php }; ?> value="right"><?php esc_html_e( 'Right', 'woo-shortcodes-kit' ); ?></option> </select>
    <br /></p>
    <br /><br /></td>
    
    
    </tr>
    </table>
    <br />
    <br />
    </div>
    <!-- FIN display username with shortcode --> 
    
    
    <!-- Logout button with a shortcode-->
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablelogoutbtn" name="wshk_enablelogoutbtn" value='12' <?php if(get_option('wshk_enablelogoutbtn')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablelogoutbtn></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Logout button shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_logout_button]" id="woomylogout" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionlogout()" onmouseout="outFunclogout()">
  <span class="tooltiptext" id="myTooltiplogout"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomylogout").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionlogout() {
  var copyText = document.getElementById("woomylogout");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiplogout = document.getElementById("myTooltiplogout");
  tooltiplogout.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunclogout() {
  var tooltiplogout = document.getElementById("myTooltiplogout");
  tooltiplogout.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but you must complete the fields for the Logout button to be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    
    
    
    
    
    
    <br /><br /><table>
    <tr>
    <td style="padding: 30px;">
           
    <p> <?php esc_html_e( 'Button border (size):', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" name="wshk_logbtnbdsize" id="wshk_logbtnbdsize" value="<?php if(get_option('wshk_logbtnbdsize')!=''){ echo get_option('wshk_logbtnbdsize'); }?>" placeholder="1px" size="50" /></p>    
    <p> <?php esc_html_e( 'Button border (radius):', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" name="wshk_logbtnbdradius" id="wshk_logbtnbdradius" value="<?php if(get_option('wshk_logbtnbdradius')!=''){ echo get_option('wshk_logbtnbdradius'); }?>" placeholder="13%" size="50" /></p>
    <p> <?php esc_html_e( 'Button border (color):', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" name="wshk_logbtnbdcolor" id="wshk_logbtnbdcolor" value="<?php if(get_option('wshk_logbtnbdcolor')!=''){ echo get_option('wshk_logbtnbdcolor'); }?>" placeholder="#a46497" size="50" /></p>
    <p> <?php esc_html_e( 'Button border (type):', 'woo-shortcodes-kit' ); ?><br /><br />
    <select name="wshk_logbtnbdtype" id="wshk_logbtnbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_logbtnbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_logbtnbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_logbtnbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_logbtnbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
    </p> 
    
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid;">         
    <p> <?php esc_html_e( 'Button text:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" name="wshk_logbtntext" id="wshk_logbtntext" value="<?php if(get_option('wshk_logbtntext')!=''){ echo get_option('wshk_logbtntext'); }?>" placeholder="<?php esc_html_e( "Logout", "woo-shortcodes-kit" ); ?>" size="50" /></p>
    <p> <?php esc_html_e( 'Button text-decoration:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" name="wshk_logbtntd" id="wshk_logbtntd" value="<?php if(get_option('wshk_logbtntd')!=''){ echo get_option('wshk_logbtntd'); }?>" placeholder="<?php esc_html_e( "none", "woo-shortcodes-kit" ); ?>" size="50" /></p>
    <p> <?php esc_html_e( 'Button width:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" name="wshk_logbtnwd" id="wshk_logbtnwd" value="<?php if(get_option('wshk_logbtnwd')!=''){ echo get_option('wshk_logbtnwd'); }?>" placeholder="100px" size="50" /></p>
    <p> <?php esc_html_e( 'Button text-align:', 'woo-shortcodes-kit' ); ?><br /><br />
    <select name="wshk_logbtnta" id="wshk_logbtnta" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_logbtnta') == 'left') { ?>selected="true" <?php }; ?> value="left"><?php esc_html_e( 'Left', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_logbtnta') == 'center') { ?>selected="true" <?php }; ?> value="center"><?php esc_html_e( 'Center', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_logbtnta') == 'right') { ?>selected="true" <?php }; ?> value="right"><?php esc_html_e( 'Right', 'woo-shortcodes-kit' ); ?></option> </select>
    </p>
    
    <br /><br />
    </td>                    
    
    </tr>
    </table>
    <br />
    <br />
    <p><b>3.- <?php esc_html_e( 'Choose the page to redirect the user after logging out', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'By default the logout button will redirect the users to the WooCommerce my account page, but you can change it for your custom page.', 'woo-shortcodes-kit' ); ?></small></p>
    <div style="padding: 30px;">
        
            <p>
            
            
            <select id="wshk_btnlogoutredi" name="wshk_btnlogoutredi" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:50%;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          //var_dump($pages);
      
    /*$option = '<option value="' . get_page_link( $page->ID ) . '">';
    $option .= $page->post_title;
    $option .= '</option>';
    echo $option;*/
  }
$getopculogout = get_option('wshk_btnlogoutredi');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopculogout; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopculogout): echo $page->post_title; endif; endforeach; ?></option>
</select><br>
            
            
            <small><?php esc_html_e( 'Use it if you are building your own myaccount page and want redirect the user to a specific page after the logout.', 'woo-shortcodes-kit' ); ?></small></p>    
    
    
    <br /><br />
        
    </div>
    
    </div>
    <!-- FIN logout button shortcode -->
    
    <!-- login form shortcode -->
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableloginform" name="wshk_enableloginform" value='13' <?php if(get_option('wshk_enableloginform')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableloginform></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Login form shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
    <br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_login_form]" id="woomyloginform" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionloginform()" onmouseout="outFuncloginform()">
  <span class="tooltiptext" id="myTooltiploginform"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyloginform").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionloginform() {
  var copyText = document.getElementById("woomyloginform");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiploginform = document.getElementById("myTooltiploginform");
  tooltiploginform.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncloginform() {
  var tooltiploginform = document.getElementById("myTooltiploginform");
  tooltiploginform.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    
    
   <p><b>2.- <?php esc_html_e( 'Choose the page to redirect the user after login', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it if you are building your own myaccount page or want redirect the user to a specific page after the login.', 'woo-shortcodes-kit' ); ?></small></p> 
    
    
    <table>
    <tr>
    <td style="padding: 30px;width:50%;">
           
    <p>
    
    <select id="wshk_loginredi" name="wshk_loginredi" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:100%;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          //var_dump($pages);
      
    /*$option = '<option value="' . get_page_link( $page->ID ) . '">';
    $option .= $page->post_title;
    $option .= '</option>';
    echo $option;*/
  }
$getoplogin = get_option('wshk_loginredi');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getoplogin; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getoplogin): echo $page->post_title; endif; endforeach; ?></option>
</select>
    </p>    
    
    
    <br /><br />
    </td> 
                   
    
    </tr>
    </table>
    <br />
    <br />
    </div>
    <!--FIN login form shortcode-->
    
    
    
    
    <!-- user reviews with product link -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablereviews" name="wshk_enablereviews" value='9' <?php if(get_option('wshk_enablereviews')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablereviews></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Customer reviews shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>

<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Use it only in your custom account page', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_review_products]" id="woomyreviewpro" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionreviewpro()" onmouseout="outFuncreviewpro()">
  <span class="tooltiptext" id="myTooltipreviewpro"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyreviewpro").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionreviewpro() {
  var copyText = document.getElementById("woomyreviewpro");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipreviewpro = document.getElementById("myTooltipreviewpro");
  tooltipreviewpro.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncreviewpro() {
  var tooltipreviewpro = document.getElementById("myTooltipreviewpro");
  tooltipreviewpro.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    
    <p><b>2.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but you must complete the fields for the review products to be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    <br><br>
    <table>
    <tr>    
    <td style="padding: 30px; width: 35%;"><h4><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e( 'Customize the avatar', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Avatar size:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" id="wshk_textavsize" name="wshk_textavsize"  value="<?php if(get_option('wshk_textavsize')!=''){ echo get_option('wshk_textavsize'); }?>" placeholder="78px"/ size="20" ></p>     
    <p> <?php esc_html_e( 'Avatar border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textavbdsize" id="wshk_textavbdsize" value="<?php if(get_option('wshk_textavbdsize')!=''){ echo get_option('wshk_textavbdsize'); }?>" placeholder="2px" size="10" /></p>    
    <p> <?php esc_html_e( 'Avatar border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textavbdradius" id="wshk_avbdradius" value="<?php if(get_option('wshk_textavbdradius')!=''){ echo get_option('wshk_textavbdradius'); }?>" placeholder="100%" size="10" /></p>    
   <p> <?php esc_html_e( 'Avatar border (type):', 'woo-shortcodes-kit' ); ?><br />
   <select name="wshk_textavbdtype" id="wshk_textavbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_textavbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textavbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textavbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_textavbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
   </p>   
    <p> <?php esc_html_e( 'Avatar border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textavbdcolor" id="wshk_textavbdcolor" value="<?php if(get_option('wshk_textavbdcolor')!=''){ echo get_option('wshk_textavbdcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar cell (width):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_texttbwsize" id="wshk_texttbwsize" value="<?php if(get_option('wshk_texttbwsize')!=''){ echo get_option('wshk_texttbwsize'); }?>" placeholder="100px" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar shadow:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_avshadow" id="wshk_avshadow" value="<?php if(get_option('wshk_avshadow')!=''){ echo get_option('wshk_avshadow'); }?>" placeholder="5px 5px 5px #c2c2c2" size="10" /></p>
     
    <br /><br />
    </td> 
    <td style="padding: 30px; border-left: 1px solid; width: 35%;"><h4><span class="dashicons dashicons-id"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Box Font (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbxfsize" id="wshk_textbxfsize" value="<?php if(get_option('wshk_textbxfsize')!=''){ echo get_option('wshk_textbxfsize'); }?>" placeholder="16px" size="10" /></p>        
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbxbdsize" id="wshk_textbxbdsize" value="<?php if(get_option('wshk_textbxbdsize')!=''){ echo get_option('wshk_textbxbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbxbdradius" id="wshk_textbxbdradius" value="<?php if(get_option('wshk_textbxbdradius')!=''){ echo get_option('wshk_textbxbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br />
   <select name="wshk_textbxbdtype" id="wshk_textbxbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_textbxbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textbxbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textbxbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_textbxbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
   </p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbxbdcolor" id="wshk_textbxbdcolor" value="<?php if(get_option('wshk_textbxbdcolor')!=''){ echo get_option('wshk_textbxbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbxbgcolor" id="wshk_textbxbgcolor" value="<?php if(get_option('wshk_textbxbgcolor')!=''){ echo get_option('wshk_textbxbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbxpadding" id="wshk_textbxpadding" value="<?php if(get_option('wshk_textbxpadding')!=''){ echo get_option('wshk_textbxpadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
    </td> 
     <td style="padding: 30px; border-left: 1px solid; witdh: 35%;"><h4><span class="dashicons dashicons-slides"></span> <?php esc_html_e( 'Customize the button', 'woo-shortcodes-kit' ); ?></h4>         
    <p> <?php esc_html_e( 'Button border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbtnbdsize" id="wshk_textbtnbdsize" value="<?php if(get_option('wshk_textbtnbdsize')!=''){ echo get_option('wshk_textbtnbdsize'); }?>" placeholder="1px" size="10" /></p>
    <p> <?php esc_html_e( 'Button border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_textbtnbdradius" id="wshk_textbtnbdradius" value="<?php if(get_option('wshk_textbtnbdradius')!=''){ echo get_option('wshk_textbtnbdradius'); }?>" placeholder="13%" size="10" /></p>
   
    <p> <?php esc_html_e( 'Button border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbtnbdcolor" id="wshk_textbtnbdcolor" value="<?php if(get_option('wshk_textbtnbdcolor')!=''){ echo get_option('wshk_textbtnbdcolor'); }?>" placeholder="#a46497" size="10" /></p>
    <p> <?php esc_html_e( 'Button border (type):', 'woo-shortcodes-kit' ); ?><br /> 
   <select name="wshk_textbtnbdtype" id="wshk_textbtnbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_textbtnbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textbtnbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_textbtnbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_textbtnbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
   </p>
    <p> <?php esc_html_e( 'Button target:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbtntarget" id="wshk_textbtntarget" value="<?php if(get_option('wshk_textbtntarget')!=''){ echo get_option('wshk_textbtntarget'); }?>" placeholder="_blank" size="10" /></p>
    <p> <?php esc_html_e( 'Button text-decoration:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbtntxd" id="wshk_textbtntxd" value="<?php if(get_option('wshk_textbtntxd')!=''){ echo get_option('wshk_textbtntxd'); }?>" placeholder="none" size="10" /></p>
    <p> <?php esc_html_e( 'Button text:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_textbtntxt" id="wshk_textbtntxt" value="<?php if(get_option('wshk_textbtntxt')!=''){ echo get_option('wshk_textbtntxt'); }?>" placeholder="<?php esc_html_e( "View product", "woo-shortcodes-kit" ); ?>" size="10" /></p>
    <br /><br />
    </td>                    
    </tr>
   
    </table>
    <br/><br>
    <p><b>3.- <?php esc_html_e( 'How many reviews want display?', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Write all to show all reviews or a specific number to show this number of reviews', 'woo-shortcodes-kit' ); ?></small></p><br>
    <p style="max-width:500px;"><input class="testininputclass" type="text" name="wshk_numbrevdis" id="wshk_numbrevdis" value="<?php if(get_option('wshk_numbrevdis')!=''){ echo get_option('wshk_numbrevdis'); }?>" placeholder="5" size="10" /></p>
    <br /><br />
    
    </div>
    
    <!-- FIN user reviews with product link -->
    
    
    
    
    
    
    
     <!-- IP shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enabletheipsht" name="wshk_enabletheipsht" value='2005' <?php if(get_option('wshk_enabletheipsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabletheipsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'User IP shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_display_ip]" id="woomyuserip" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionuserip()" onmouseout="outFuncuserip()">
  <span class="tooltiptext" id="myTooltipuserip"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyuserip").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionuserip() {
  var copyText = document.getElementById("woomyuserip");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipuserip = document.getElementById("myTooltipuserip");
  tooltipuserip.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncuserip() {
  var tooltipuserip = document.getElementById("myTooltipuserip");
  tooltipuserip.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 53%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        </div>
    
    <!-- FIN IP shortcode -->
    
     <!-- name and surname shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablethenamesurnsht" name="wshk_enablethenamesurnsht" value='2006' <?php if(get_option('wshk_enablethenamesurnsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablethenamesurnsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'User name and surname shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_display_nsurname]" id="woomynsurname" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionnsurname()" onmouseout="outFuncnsurname()">
  <span class="tooltiptext" id="myTooltipnsurname"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomynsurname").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionnsurname() {
  var copyText = document.getElementById("woomynsurname");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipnsurname = document.getElementById("myTooltipnsurname");
  tooltipnsurname.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncnsurname() {
  var tooltipnsurname = document.getElementById("myTooltipnsurname");
  tooltipnsurname.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        </div>
    
    <!-- FIN name and surname shortcode -->
    
    
     <!-- user email shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enabletheuseremailsht" name="wshk_enabletheuseremailsht" value='2007' <?php if(get_option('wshk_enabletheuseremailsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabletheuseremailsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big> <?php esc_html_e( 'User email shortcode', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need enable the function and copy the shortcode in your custom account page!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_display_email]" id="woomyuseremail" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionuseremail()" onmouseout="outFuncuseremail()">
  <span class="tooltiptext" id="myTooltipuseremail"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyuseremail").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionuseremail() {
  var copyText = document.getElementById("woomyuseremail");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipuseremail = document.getElementById("myTooltipuseremail");
  tooltipuseremail.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncuseremail() {
  var tooltipuseremail = document.getElementById("myTooltipuseremail");
  tooltipuseremail.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom account page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        </div>
    
    <!-- FIN user email shortcode -->
      </div>
    </li>
    <!-- FIN MY ACCOUNT SECTION -->
    
    
    <!-- COUNTERS SECTION -->
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-backup"></span> <?php esc_html_e( 'COUNTERS WITH DATA FROM THE SHOP AND USER', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          
          
          
           <!-- Total sales of the shop shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablethetotsalessht" name="wshk_enablethetotsalessht" value='2008' <?php if(get_option('wshk_enablethetotsalessht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablethetotsalessht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Total shop sales counter', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need activate the function and copy the shortcode on any page or post!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_global_sales]" id="woomyglobalsal" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionglobalsal()" onmouseout="outFuncglobalsal()">
  <span class="tooltiptext" id="myTooltipglobalsal"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
<?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyglobalsal").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionglobalsal() {
  var copyText = document.getElementById("woomyglobalsal");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipglobalsal = document.getElementById("myTooltipglobalsal");
  tooltipglobalsal.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncglobalsal() {
  var tooltipglobalsal = document.getElementById("myTooltipglobalsal");
  tooltipglobalsal.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
<p style="padding-left:30px;"><?php esc_html_e( 'This shortcode shows total store sales, adding orders with status processing, completed and on hold', 'woo-shortcodes-kit' ); ?></p>
<br><br><br>
        </div>
    
    <!-- FIN total sales of the shop shortcode -->
    
    
     <!-- Total sales amount of the shop shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablethetotsalesamount" name="wshk_enablethetotsalesamount" value='18401' <?php if(get_option('wshk_enablethetotsalesamount')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablethetotsalesamount></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Total shop sales amount counter', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Just need activate the function and copy the shortcode on any page or post!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_total_amount]" id="woomyglobalsalamount" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionglobalsalamount()" onmouseout="outFuncglobalsalamount()">
  <span class="tooltiptext" id="myTooltipglobalsalamount"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
<?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyglobalsalamount").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionglobalsalamount() {
  var copyText = document.getElementById("woomyglobalsalamount");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipglobalsalamount = document.getElementById("myTooltipglobalsalamount");
  tooltipglobalsalamount.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncglobalsalamount() {
  var tooltipglobalsalamount = document.getElementById("myTooltipglobalsalamount");
  tooltipglobalsalamount.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
<p style="padding-left:30px;"><?php esc_html_e( 'This shortcode shows total amount sales, adding orders with status processing, completed and on hold', 'woo-shortcodes-kit' ); ?></p>
<br><br><br>
        </div>
    
    <!-- FIN total amount sales of the shop shortcode -->
    
     <!-- Total products in the shop shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enablethetotprosht" name="wshk_enablethetotprosht" value='2009' <?php if(get_option('wshk_enablethetotprosht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablethetotprosht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Total shop products counter', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'UPDATED', 'woo-shortcodes-kit' ); ?></span></big><br /><small><?php esc_html_e( 'Just need activate the function and copy the shortcode on any page or post!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_total_product_count]" id="woomytotalproco" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiontotalproco()" onmouseout="outFunctotalproco()">
  <span class="tooltiptext" id="myTooltiptotalproco"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomytotalproco").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiontotalproco() {
  var copyText = document.getElementById("woomytotalproco");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiptotalproco = document.getElementById("myTooltiptotalproco");
  tooltiptotalproco.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunctotalproco() {
  var tooltiptotalproco = document.getElementById("myTooltiptotalproco");
  tooltiptotalproco.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
        <p style="padding-left:30px;"><?php esc_html_e( 'if you want exclude any category from the total count use', 'woo-shortcodes-kit' ); ?><strong> [woo_total_product_count cat_id="<?php esc_html_e( 'Here write the category ID number', 'woo-shortcodes-kit' ); ?>"]</strong></p>
        <br>
        <p style="padding-left:30px;"><?php esc_html_e( 'Now you can exclude up to 3 differents categories, for example', 'woo-shortcodes-kit' ); ?>:<br><strong> [woo_total_product_count cat_id="26" cat_id2="28" cat_id3="23"]</strong></p>
        <br><br>
        </div>
    
    <!-- FIN total products in the shop shortcode -->
          
          
          
          
          <!-- display customer total bought products with a shortcode -->
        <div class="accordion">
 <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablectbp" name="wshk_enablectbp" value='6' <?php if(get_option('wshk_enablectbp')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablectbp></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Customer purchased products counter', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 28%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_total_bought_products]" id="woomytotalboupro" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiontotalboupro()" onmouseout="outFunctotalboupro()">
  <span class="tooltiptext" id="myTooltiptotalboupro"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomytotalboupro").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiontotalboupro() {
  var copyText = document.getElementById("woomytotalboupro");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiptotalboupro = document.getElementById("myTooltiptotalboupro");
  tooltiptotalboupro.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunctotalboupro() {
  var tooltiptotalboupro = document.getElementById("myTooltiptotalboupro");
  tooltiptotalboupro.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but by default it only will show the quantity of purchased products, you must complete the fields that will be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    
    <br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textprefix" name="wshk_textprefix" value="<?php if(get_option('wshk_textprefix')!=''){ echo get_option('wshk_textprefix'); }?>" placeholder="<?php esc_html_e( "You have bought", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textsuffix" name="wshk_textsuffix" value="<?php if(get_option('wshk_textsuffix')!=''){ echo get_option('wshk_textsuffix'); }?>" placeholder="<?php esc_html_e( "product", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textpsuffix" name="wshk_textpsuffix" value="<?php if(get_option('wshk_textpsuffix')!=''){ echo get_option('wshk_textpsuffix'); }?>" placeholder="<?php esc_html_e( "products", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have bought any product:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textnobp" name="wshk_textnobp" value="<?php if(get_option('wshk_textnobp')!=''){ echo get_option('wshk_textnobp'); }?>" placeholder="<?php esc_html_e( "You dont have any products bought yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
    
    <p><b>3.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can choose the text alignment and fix the shortcode if it is not displayed correctly', 'woo-shortcodes-kit' ); ?></small></p>
    <br>
<p>
<select name="wshk_aligntheproducts" id="wshk_aligntheproducts" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_aligntheproducts') == 'left') { ?>selected="true" <?php }; ?> value="left"><?php esc_html_e( 'Left', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_aligntheproducts') == 'center') { ?>selected="true" <?php }; ?> value="center"><?php esc_html_e( 'Center', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_aligntheproducts') == 'right') { ?>selected="true" <?php }; ?> value="right"><?php esc_html_e( 'Right', 'woo-shortcodes-kit' ); ?></option> </select>
</p>
    <br />


<p> <span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Sometimes the result of the shortcode can appear out of his site. It if happen, choose the option that you need to view correctly the shortcode', 'woo-shortcodes-kit' ); ?><br /><small style="padding-left:25px;"><?php esc_html_e( 'By default is selected the option to show the shortcode without the solution, if you dont see the shortcode in his place, please choose the other option.', 'woo-shortcodes-kit' ); ?></small><br /><br /><br > <select name="wshk_yesenabletwo" id="wshk_yesenabletwo" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:50%;"><option <?php if (get_option('wshk_yesenabletwo') == 'wshk_nnoenabletwo') { ?>selected="true" <?php }; ?> value="wshk_nnoenabletwo"><?php esc_html_e( 'Im fine and view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_yesenabletwo') == 'wshk_yesenabletwo') { ?>selected="true" <?php }; ?> value="wshk_yesenabletwo"><?php esc_html_e( 'Enable for view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option>  </select> <br /></p>


    <br />
    </div>
    
    <!-- FIN display customer total bought products with a shortcode -->

<!-- display custom total orders with a shortcode -->
<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablectbo" name="wshk_enablectbo" value='7' <?php if(get_option('wshk_enablectbo')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablectbo></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Customer total orders counter', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 29%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_customer_total_orders]" id="woomycustotalord" readonly></big><br /><br /></p></td>
        
        <td style="width: 21%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctioncustotalord()" onmouseout="outFunccustotalord()">
  <span class="tooltiptext" id="myTooltipcustotalord"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomycustotalord").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctioncustotalord() {
  var copyText = document.getElementById("woomycustotalord");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipcustotalord = document.getElementById("myTooltipcustotalord");
  tooltipcustotalord.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunccustotalord() {
  var tooltipcustotalord = document.getElementById("myTooltipcustotalord");
  tooltipcustotalord.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 50%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but by default it only will show the quantity of orders, you must complete the fields that will be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    <br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_tordersprefix" name="wshk_tordersprefix" value="<?php if(get_option('wshk_tordersprefix')!=''){ echo get_option('wshk_tordersprefix'); }?>" placeholder="<?php esc_html_e( "You have made", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text singular suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_torderssuffix" name="wshk_torderssuffix" value="<?php if(get_option('wshk_torderssuffix')!=''){ echo get_option('wshk_torderssuffix'); }?>" placeholder="<?php esc_html_e( "order", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_torderspsuffix" name="wshk_torderspsuffix" value="<?php if(get_option('wshk_torderspsuffix')!=''){ echo get_option('wshk_torderspsuffix'); }?>" placeholder="<?php esc_html_e( "orders", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have made any order:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textnobo" name="wshk_textnobo" value="<?php if(get_option('wshk_textnobo')!=''){ echo get_option('wshk_textnobo'); }?>" placeholder="<?php esc_html_e( "You dont have any orders made yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
    <p><b>3.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can choose the text alignment and fix the shortcode if it is not displayed correctly', 'woo-shortcodes-kit' ); ?></small></p>
    <br>
<p>
<select name="wshk_aligntheorders" id="wshk_aligntheorders" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_aligntheorders') == 'left') { ?>selected="true" <?php }; ?> value="left"><?php esc_html_e( 'Left', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_aligntheorders') == 'center') { ?>selected="true" <?php }; ?> value="center"><?php esc_html_e( 'Center', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_aligntheorders') == 'right') { ?>selected="true" <?php }; ?> value="right"><?php esc_html_e( 'Right', 'woo-shortcodes-kit' ); ?></option> </select>
</p>
    <br />
    
    
<p> <span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Sometimes the result of the shortcode can appear out of his site. It if happen, choose the option that you need to view correctly the shortcode', 'woo-shortcodes-kit' ); ?><br /><small style="padding-left:25px;"><?php esc_html_e( 'By default is selected the option to show the shortcode without the solution, if you dont see the shortcode in his place, please choose the other option.', 'woo-shortcodes-kit' ); ?></small><br /><br /><br> 
<select name="wshk_yesenable" id="wshk_yesenable" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:50%;"><option <?php if (get_option('wshk_yesenable') == 'wshk_nnoenable') { ?>selected="true" <?php }; ?> value="wshk_nnoenable"><?php esc_html_e( 'Im fine and view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_yesenable') == 'wshk_yesenable') { ?>selected="true" <?php }; ?> value="wshk_yesenable"><?php esc_html_e( 'Enable for view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option>  </select> <br /></p>
    
    
    <br />
    </div>
    <!-- FIN display customer total orders with a shortcode -->
    
    <!-- display customer total reviews number with a shortcode -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablerwcounter" name="wshk_enablerwcounter" value='10' <?php if(get_option('wshk_enablerwcounter')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablerwcounter></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Customer total reviews counter', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 25%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_total_count_reviews]" id="woomytotalcorev" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiontotalcorev()" onmouseout="outFunctotalcorev()">
  <span class="tooltiptext" id="myTooltiptotalcorev"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomytotalcorev").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiontotalcorev() {
  var copyText = document.getElementById("woomytotalcorev");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiptotalcorev = document.getElementById("myTooltiptotalcorev");
  tooltiptotalcorev.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFunctotalcorev() {
  var tooltiptotalcorev = document.getElementById("myTooltiptotalcorev");
  tooltiptotalcorev.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
    <p><b>2.- <?php esc_html_e( 'Write the prefix and suffix texts to show.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but by default it only will show the quantity of reviews, you must complete the fields that will be displayed', 'woo-shortcodes-kit' ); ?></small></p>
    <br /><br /><table>
    <tr>
    <td><p> <?php esc_html_e( 'Write here the text prefix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_treviewprefix" name="wshk_treviewprefix" value="<?php if(get_option('wshk_treviewprefix')!=''){ echo get_option('wshk_treviewprefix'); }?>" placeholder="<?php esc_html_e( "You have made", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text singular suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_treviewsuffix" name="wshk_treviewsuffix" value="<?php if(get_option('wshk_treviewsuffix')!=''){ echo get_option('wshk_treviewsuffix'); }?>" placeholder="<?php esc_html_e( "review", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Write here the text plural suffix:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_treviewpsuffix" name="wshk_treviewpsuffix" value="<?php if(get_option('wshk_treviewpsuffix')!=''){ echo get_option('wshk_treviewpsuffix'); }?>" placeholder="<?php esc_html_e( "reviews", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br /></td>
    
    <td><p> <?php esc_html_e( 'Text when dont have made any review:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_textnoreview" name="wshk_textnoreview" value="<?php if(get_option('wshk_textnoreview')!=''){ echo get_option('wshk_textnoreview'); }?>" placeholder="<?php esc_html_e( "You dont have any review made yet", "woo-shortcodes-kit" ); ?>"/ size="36"><small><?php esc_html_e( 'You can leave empty to show nothing', 'woo-shortcodes-kit' ); ?></small><br /></p>
    <br /><br />
    </td>
    </tr>
    </table>
    <br />
    <p><b>3.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can choose the text alignment and fix the shortcode if it is not displayed correctly', 'woo-shortcodes-kit' ); ?></small></p>
    <br>
<p>
<select name="wshk_alignthereviews" id="wshk_alignthereviews" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_alignthereviews') == 'left') { ?>selected="true" <?php }; ?> value="left"><?php esc_html_e( 'Left', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_alignthereviews') == 'center') { ?>selected="true" <?php }; ?> value="center"><?php esc_html_e( 'Center', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_alignthereviews') == 'right') { ?>selected="true" <?php }; ?> value="right"><?php esc_html_e( 'Right', 'woo-shortcodes-kit' ); ?></option> </select>
</p>
    <br />
    
<p> <span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Sometimes the result of the shortcode can appear out of his site. It if happen, choose the option that you need to view correctly the shortcode', 'woo-shortcodes-kit' ); ?><br /><small style="padding-left:25px;"><?php esc_html_e( 'By default is selected the option to show the shortcode without the solution, if you dont see the shortcode in his place, please choose the other option.', 'woo-shortcodes-kit' ); ?></small><br /><br /><br> <select name="wshk_yesenablethree" id="wshk_yesenablethree" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:50%;"><option <?php if (get_option('wshk_yesenablethree') == 'wshk_nnoenablethree') { ?>selected="true" <?php }; ?> value="wshk_nnoenablethree"><?php esc_html_e( 'Im fine and view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_yesenablethree') == 'wshk_yesenablethree') { ?>selected="true" <?php }; ?> value="wshk_yesenablethree"><?php esc_html_e( 'Enable for view the shortcode result correctly', 'woo-shortcodes-kit' ); ?></option>  </select> <br /></p>
    <br />
    </div>
    <!--FIN display user total reviews number with a shortcode -->
    
    
    <!-- Downloads/sales counter -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enable" name="wshk_enable" value='1' <?php if(get_option('wshk_enable')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enable></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Product Download/Sales Counter', 'woo-shortcodes-kit' ); ?>  <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?> </small></p></th>
    </table>
</div>
<div class="panel">
    <br /><br />
    
    <p><b>1.- <?php esc_html_e( 'Enter the text you want to display under each product', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Add a different text for the downloadable products and another for the rest of the products.', 'woo-shortcodes-kit' ); ?><br><?php esc_html_e( '(You can also set a minimum number of downloads or sales that a product must have to display the message below)', 'woo-shortcodes-kit' ); ?></small></p>
    <br><br>
    <table>
    <tr>
    <td style="padding: 30px;"><p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Downloable products (text)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'Write here the text to display below the product:', 'woo-shortcodes-kit' ); ?></small></p><p><input type="text" class="testininputclass" id="wshk_text" name="wshk_text" value="<?php if(get_option('wshk_text')!=''){ echo get_option('wshk_text'); }?>" placeholder="<?php esc_html_e( "Downloads", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'If you have not completed the field, a default text will be displayed', 'woo-shortcodes-kit' ); ?></small><br /></p>
    
    <br /><br /><p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Downloable products (condition)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'The message will be displayed if the product have a number of downloads:', 'woo-shortcodes-kit' ); ?></small></p><p><input class="testininputclass" type="number" id="wshk_min" name="wshk_min" value="<?php if(get_option('wshk_min')!=''){ echo get_option('wshk_min'); }?>" placeholder="<?php esc_html_e( "All", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'By default, it will display the message without counting the number of downloads.', 'woo-shortcodes-kit' ); ?></small><br /></p>
    
    <br /><br />
    
    <p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Downloable products (style control)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'You can use these classes to customize the message style:', 'woo-shortcodes-kit' ); ?></small></p>
    <div>
        <table width="100%">
            <tr>
                <td style="width:25%;">
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'BOX:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'ICON:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'COUNTER:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'TEXT:', 'woo-shortcodes-kit' ); ?></p>
                </td>
                
                <td style="width:75%;">
                    <p style="color:grey;">.wshkdow</p>
                    <p style="color:grey;">.wshkicondow</p>
                    <p style="color:grey;">.wshkcoudow</p>
                    <p style="color:grey;">.wshktxtdow</p>
                </td>
            </tr>
        </table>
    </div>
    
    </td>
    
    <td style="padding: 30px; border-left: 1px solid;"><p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Sales products (text)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'Write here the text to display below the product:', 'woo-shortcodes-kit' ); ?></small></p><p><input class="testininputclass" type="text" id="wshk_textsales" name="wshk_textsales" value="<?php if(get_option('wshk_textsales')!=''){ echo get_option('wshk_textsales'); }?>" placeholder="<?php esc_html_e( "Sales", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'If you have not completed the field, a default text will be displayed', 'woo-shortcodes-kit' ); ?></small><br /></p>
    
    <br /><br /><p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Sales products (condition)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'The message will be displayed if the product have a number of sales:', 'woo-shortcodes-kit' ); ?></small></p><input type="number" class="testininputclass" id="wshk_minsales" name="wshk_minsales" value="<?php if(get_option('wshk_minsales')!=''){ echo get_option('wshk_minsales'); }?>" placeholder="<?php esc_html_e( "All", "woo-shortcodes-kit" ); ?>"/ size="20"><small><?php esc_html_e( 'By default, it will display the message without counting the number of sales.', 'woo-shortcodes-kit' ); ?></small><br /></p>
    
     <br /><br />
    
    <p style="color:#a46497;font-size:14px;"><?php esc_html_e( 'Sales products (style control)', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'You can use these classes to customize the message style:', 'woo-shortcodes-kit' ); ?></small></p>
    <div>
        <table width="100%">
            <tr>
                <td style="width:35%;">
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'BOX:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'ICON:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'COUNTER:', 'woo-shortcodes-kit' ); ?></p>
                    <p style="color:#a46497;letter-spacing:1px;"><?php esc_html_e( 'TEXT:', 'woo-shortcodes-kit' ); ?></p>
                </td>
                
                <td style="width:65%;">
                    <p style="color:grey;">.wshksa</p>
                    <p style="color:grey;">.wshkiconsa</p>
                    <p style="color:grey;">.wshkcousa</p>
                    <p style="color:grey;">.wshktxtsa</p>
                </td>
            </tr>
        </table>
    </div>
    
    
    </td>
    </tr>
    </table>
    <br />
    <br />
    <p><strong>2.- <?php esc_html_e( 'Shortcode', 'woo-shortcodes-kit' ); ?></strong><br><small><?php esc_html_e( 'You can display a specific product sales by ID on any page or post.', 'woo-shortcodes-kit' ); ?></small></p><br>
    <p><?php esc_html_e( 'Just need to use the following shortcode and replace the PRODUCT ID HERE with the product ID number.', 'woo-shortcodes-kit' ); ?></p>
    <p style="color:#a46497;"><strong>[wshk_product_sales id="PRODUCT ID HERE"]</strong></p>
    <br />
    <br />
    <p><strong>3.- <?php esc_html_e( 'Display options', 'woo-shortcodes-kit' ); ?></strong><br><small><?php esc_html_e( 'You can choose how to display it. If you were using this function before v.1.8.9 you should choose the display options, the first and second option were the ones used in older versions.', 'woo-shortcodes-kit' ); ?></small></p><br>
    
    <input type="checkbox" id="wshk_sales_sht_one" name="wshk_sales_sht_one" value='saleshtone' <?php if(get_option('wshk_sales_sht_one')!=''){ echo ' checked="checked"'; }?> /><label for="wshk_sales_sht_one"><?php esc_html_e( 'Single product summary', 'woo-shortcodes-kit' ); ?></label><br>
    
    <input type="checkbox" id="wshk_sales_sht_two" name="wshk_sales_sht_two" value='saleshttwo' <?php if(get_option('wshk_sales_sht_two')!=''){ echo ' checked="checked"'; }?> /><label for="wshk_sales_sht_two"><?php esc_html_e( 'After shop loop item', 'woo-shortcodes-kit' ); ?></label><br>
    
    <input type="checkbox" id="wshk_sales_sht_three" name="wshk_sales_sht_three" value='saleshtthree' <?php if(get_option('wshk_sales_sht_three')!=''){ echo ' checked="checked"'; }?> /><label for="wshk_sales_sht_three"><?php esc_html_e( 'Before add to cart form', 'woo-shortcodes-kit' ); ?> <small style="color:#aadb4a;">(<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>)</small></label><br>
    
    <input type="checkbox" id="wshk_sales_sht_four" name="wshk_sales_sht_four" value='saleshtfour' <?php if(get_option('wshk_sales_sht_four')!=''){ echo ' checked="checked"'; }?> /><label for="wshk_sales_sht_four"><?php esc_html_e( 'Use shortcode', 'woo-shortcodes-kit' ); ?> <small style="color:#aadb4a;">(<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>)</small></label><br>
    
    <br />
    <br />
    </div>
    <!-- FIN downloads/sales counter -->



    
      </div>
    </li>
    <!-- FIN COUNTERS SECTION -->
    
    
    
    <!--ADDITIONALS SHORTCODES -->
    <li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;margin-top: 25px;"><span class="dashicons dashicons-plus-alt"></span> <?php esc_html_e( 'ADDITIONALS SHORTCODES', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          
          
          
           <!-- bought produts loop shortcode -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enabletheboughtsht" name="wshk_enabletheboughtsht" value='2010' <?php if(get_option('wshk_enabletheboughtsht')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabletheboughtsht></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Customer purchased products loop', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 25%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_bought_products]" id="woomyuserbouprod" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionuserbouprod()" onmouseout="outFuncuserbouprod()">
  <span class="tooltiptext" id="myTooltipuserbouprod"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyuserbouprod").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionuserbouprod() {
  var copyText = document.getElementById("woomyuserbouprod");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipuserbouprod = document.getElementById("myTooltipuserbouprod");
  tooltipuserbouprod.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncuserbouprod() {
  var tooltipuserbouprod = document.getElementById("myTooltipuserbouprod");
  tooltipuserbouprod.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br/><br>
    <p><b>2.- <?php esc_html_e( 'Function settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Choose the number of columns to display the products loop', 'woo-shortcodes-kit' ); ?></small></p><br>
    <p style="max-width:500px;padding-left:30px;">
        <select name="wshk_bougcolumnum" id="wshk_bougcolumnum" style="border:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_bougcolumnum') == '1') { ?>selected="true" <?php }; ?> value="1"><?php esc_html_e( '1', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_bougcolumnum') == '2') { ?>selected="true" <?php }; ?> value="2"><?php esc_html_e( '2', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_bougcolumnum') == '3') { ?>selected="true" <?php }; ?> value="3"><?php esc_html_e( '3', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_bougcolumnum') == '4') { ?>selected="true" <?php }; ?> value="4"><?php esc_html_e( '4', 'woo-shortcodes-kit' ); ?></option> </select>
        
        </p>
    <br /><br />
        </div>
    
    <!-- FIN bought product loop shortcode -->
          
          
          
        <!-- display custom message to the user if have a number of orders made -->
<div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablewmessage" name="wshk_enablewmessage" value='8' <?php if(get_option('wshk_enablewmessage')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablewmessage></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Conditional message to the customer according to their number of orders', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_message]" id="woomyusermessage" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionusermessage()" onmouseout="outFuncusermessage()">
  <span class="tooltiptext" id="myTooltipusermessage"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyusermessage").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionusermessage() {
  var copyText = document.getElementById("woomyusermessage");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipusermessage = document.getElementById("myTooltipusermessage");
  tooltipusermessage.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncusermessage() {
  var tooltipusermessage = document.getElementById("myTooltipusermessage");
  tooltipusermessage.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
<p><b>2.- <?php esc_html_e( 'Function settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Choose the number of columns to display the products loop', 'woo-shortcodes-kit' ); ?></small></p><br>
    <br /><table width="100%">
    <tr>
    <td style="padding: 30px;width:50%;"><p><?php esc_html_e( 'Message template', 'woo-shortcodes-kit' ); ?><br><small><?php esc_html_e( 'You can copy it and paste directly in the text message field', 'woo-shortcodes-kit' ); ?></small><br><br><code><?php esc_html_e( 'Hi %1$s!<br />To reward your activity in our shop with %2$s orders, we want give to you a 50%% discount for your next order!! 
<br />Enter this coupon code in your next order: WSHK50TST', 'woo-shortcodes-kit' ); ?></code><br><br><br> <?php esc_html_e( 'Message text:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_textwmssg" id="wshk_textwmssg" class="textarea" cols="40" rows="6" id="wshk_textwmssg" placeholder="<?php esc_html_e( 'Hi %1$s!<br />To reward your activity in our shop with %2$s orders, we want give to you a 50%% discount for your next order!! 
<br />Enter this coupon code in your next order: WSHK50TST', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:90px;"><?php if(get_option('wshk_textwmssg')!=''){ echo get_option('wshk_textwmssg'); }?></textarea><br /></p>
    <br /><br /></td>
    
    <td style="padding: 30px; border-left: 1px solid;"><p> <?php esc_html_e( 'Set the number of orders to display the message:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_wmorders" name="wshk_wmorders" value="<?php if(get_option('wshk_wmorders')!=''){ echo get_option('wshk_wmorders'); }?>" placeholder="5"/ size="20"><br /></p>
    
    <p><?php esc_html_e( 'Set the custom text to display if the customer not have orders made yet:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_nonotice" name="wshk_nonotice" value="<?php if(get_option('wshk_nonotice')!=''){ echo get_option('wshk_nonotice'); }?>" placeholder="<?php esc_html_e( "Dont have made orders yet", "woo-shortcodes-kit" ); ?>"/ size="20"><br /></p>
    
    <p> <?php esc_html_e( 'Set the custom text to display if the customer have more orders:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_morenotice" name="wshk_morenotice" value="<?php if(get_option('wshk_morenotice')!=''){ echo get_option('wshk_morenotice'); }?>" placeholder="<?php esc_html_e( "Coming soon more gifts", "woo-shortcodes-kit" ); ?>"/ size="36"><br /></p>
    <br /><br />
    </td>        
    </tr>
   
    </table> <br /><br />
    </div>
    <!-- FIN display custom message if user have a number or orders made -->
    
    
    
    <!-- display all shop reviews with a shortcode -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="1">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enabledisplayreviews" name="wshk_enabledisplayreviews" value='40' <?php if(get_option('wshk_enabledisplayreviews')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabledisplayreviews></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Display all the products reviews where you want', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>

<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 25%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[woo_display_reviews]" id="woomyallreviews" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionallreviews()" onmouseout="outFuncallreviews()">
  <span class="tooltiptext" id="myTooltipallreviews"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyallreviews").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionallreviews() {
  var copyText = document.getElementById("woomyallreviews");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipallreviews = document.getElementById("myTooltipallreviews");
  tooltipallreviews.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncallreviews() {
  var tooltipallreviews = document.getElementById("myTooltipallreviews");
  tooltipallreviews.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br><br>
<p><b>2.- <?php esc_html_e( 'Function and Style settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Each field shows an example of what to write, but by default it only will show the quantity of reviews, you must complete the fields that will be displayed', 'woo-shortcodes-kit' ); ?></small></p><br>
    <br /><table width="100%">
    <tr>    
    <td style="padding: 30px; width: 50%;"><h4 style=""><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e( 'Customize the avatar', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Avatar size:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" id="wshk_disretextavsize" name="wshk_disretextavsize"  value="<?php if(get_option('wshk_disretextavsize')!=''){ echo get_option('wshk_disretextavsize'); }?>" placeholder="48px"/ size="20" ></p>     
    <p> <?php esc_html_e( 'Avatar border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextavbdsize" id="wshk_disretextavbdsize" value="<?php if(get_option('wshk_disretextavbdsize')!=''){ echo get_option('wshk_disretextavbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Avatar border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextavbdradius" id="wshk_disretextavbdradius" value="<?php if(get_option('wshk_disretextavbdradius')!=''){ echo get_option('wshk_disretextavbdradius'); }?>" placeholder="100%" size="10" /></p>    
   <p> <?php esc_html_e( 'Avatar border (type):', 'woo-shortcodes-kit' ); ?><br />
   <select name="wshk_disretextavbdtype" id="wshk_disretextavbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_disretextavbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disretextavbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disretextavbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_disretextavbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
   </p>   
    <p> <?php esc_html_e( 'Avatar border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextavbdcolor" id="wshk_disretextavbdcolor" value="<?php if(get_option('wshk_disretextavbdcolor')!=''){ echo get_option('wshk_disretextavbdcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar cell (width):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretexttbwsize" id="wshk_disretexttbwsize" value="<?php if(get_option('wshk_disretexttbwsize')!=''){ echo get_option('wshk_disretexttbwsize'); }?>" placeholder="100px" size="10" /></p>
    <p> <?php esc_html_e( 'Avatar margin top:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextmargintop" id="wshk_disretextmargintop" value="<?php if(get_option('wshk_disretextmargintop')!=''){ echo get_option('wshk_disretextmargintop'); }?>" placeholder="15px" size="10" /></p>
    <!--<p> <?php esc_html_e( 'Avatar shadow:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_avshadow" id="wshk_avshadow" value="<?php if(get_option('wshk_avshadow')!=''){ echo get_option('wshk_avshadow'); }?>" placeholder="5px 5px 5px #c2c2c2" size="10" /></p>-->
    <br><br>
    
    <h4 style=""><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Customize the title', 'woo-shortcodes-kit' ); ?></h4>
    
    <p> <?php esc_html_e( 'Title text size:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextlinktxtsize" id="wshk_disretextlinktxtsize" value="<?php if(get_option('wshk_disretextlinktxtsize')!=''){ echo get_option('wshk_disretextlinktxtsize'); }?>" placeholder="24px" size="10" /></p>
    <p> <?php esc_html_e( 'Title text color:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextlinktxtcolor" id="wshk_disretextlinktxtcolor" value="<?php if(get_option('wshk_disretextlinktxtcolor')!=''){ echo get_option('wshk_disretextlinktxtcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Title text-decoration:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextlinktxd" id="wshk_disretextlinktxd" value="<?php if(get_option('wshk_disretextlinktxd')!=''){ echo get_option('wshk_disretextlinktxd'); }?>" placeholder="none" size="10" /></p>
    <p> <?php esc_html_e( 'Title link target:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextlinktarget" id="wshk_disretextlinktarget" value="<?php if(get_option('wshk_disretextlinktarget')!=''){ echo get_option('wshk_disretextlinktarget'); }?>" placeholder="_blank" size="10" /></p>
    <!--<br />-->
     
    <!--<br /><br /><br /><br />-->
    </td> 
    <td style="padding: 30px; border-left: 1px solid;"><h4><span class="dashicons dashicons-id"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
    <p> <?php esc_html_e( 'Box Font (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextbxfsize" id="wshk_disretextbxfsize" value="<?php if(get_option('wshk_disretextbxfsize')!=''){ echo get_option('wshk_disretextbxfsize'); }?>" placeholder="16px" size="10" /></p>        
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextbxbdsize" id="wshk_disretextbxbdsize" value="<?php if(get_option('wshk_disretextbxbdsize')!=''){ echo get_option('wshk_disretextbxbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextbxbdradius" id="wshk_disretextbxbdradius" value="<?php if(get_option('wshk_disretextbxbdradius')!=''){ echo get_option('wshk_disretextbxbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br />
   <select name="wshk_disretextbxbdtype" id="wshk_disretextbxbdtype" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_disretextbxbdtype') == 'none') { ?>selected="true" <?php }; ?> value="none"><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disretextbxbdtype') == 'solid') { ?>selected="true" <?php }; ?> value="solid"><?php esc_html_e( 'Solid', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disretextbxbdtype') == 'dashed') { ?>selected="true" <?php }; ?> value="dashed"><?php esc_html_e( 'Dashed', 'woo-shortcodes-kit' ); ?></option><option <?php if (get_option('wshk_disretextbxbdtype') == 'dotted') { ?>selected="true" <?php }; ?> value="dotted"><?php esc_html_e( 'Dotted', 'woo-shortcodes-kit' ); ?></option></select>
   </p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextbxbdcolor" id="wshk_disretextbxbdcolor" value="<?php if(get_option('wshk_disretextbxbdcolor')!=''){ echo get_option('wshk_disretextbxbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextbxbgcolor" id="wshk_disretextbxbgcolor" value="<?php if(get_option('wshk_disretextbxbgcolor')!=''){ echo get_option('wshk_disretextbxbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextbxpadding" id="wshk_disretextbxpadding" value="<?php if(get_option('wshk_disretextbxpadding')!=''){ echo get_option('wshk_disretextbxpadding'); }?>" placeholder="20px" size="10" /></p>
    <p> <?php esc_html_e( 'Box height:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_disretextbxminheight" id="wshk_disretextbxminheight" value="<?php if(get_option('wshk_disretextbxminheight')!=''){ echo get_option('wshk_disretextbxminheight'); }?>" placeholder="200px" size="10" /></p>
    
    <p> <?php esc_html_e( 'Box text color:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_disretextcolor" id="wshk_disretextcolor" value="<?php if(get_option('wshk_disretextcolor')!=''){ echo get_option('wshk_disretextcolor'); }?>" placeholder="black" size="10" /></p>
    
    <p> <?php esc_html_e( 'Comment character limit:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_limitcomm" id="wshk_limitcomm" value="<?php if(get_option('wshk_limitcomm')!=''){ echo get_option('wshk_limitcomm'); }?>" placeholder="300" size="10" /></p>
    
    <p> <?php esc_html_e( 'Type of limiter:', 'woo-shortcodes-kit' ); ?><br /> <select name="wshk_showpoints" id="wshk_showpoints" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_showpoints') == 'showpo') { ?>selected="true" <?php }; ?> value="showpo"><?php esc_html_e( 'Points only (...)', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_showpoints') == 'showlin') { ?>selected="true" <?php }; ?> value="showlin"><?php esc_html_e( 'Points and link (...Read More)', 'woo-shortcodes-kit' ); ?></option> </select> <br /></p>
    
    
    
    <?php
    
    $limitationtype = get_option('wshk_showpoints');
  if ($limitationtype == 'showpo') {
    
    $addtextstyle = 'none'; 
} else {
     $addtextstyle = 'block';  
}
    
    ?>
    <p> <?php esc_html_e( 'Add your custom link text', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_readmoretextlim" id="wshk_readmoretextlim" value="<?php if(get_option('wshk_readmoretextlim')!=''){ echo get_option('wshk_readmoretextlim'); }?>" placeholder="Read more" size="10" /></p>
    
    
    </td> 
     <!--<td style="padding: 30px; border-left: 1px solid; witdh: 35%;"><h4 style="margin-top: -355px;"><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Customize the title', 'woo-shortcodes-kit' ); ?></h4>
    
    <p> <?php esc_html_e( 'Title text size:', 'woo-shortcodes-kit' ); ?><br /> <input type="number" name="wshk_disretextlinktxtsize" id="wshk_disretextlinktxtsize" value="<?php if(get_option('wshk_disretextlinktxtsize')!=''){ echo get_option('wshk_disretextlinktxtsize'); }?>" placeholder="24px" size="10" /></p>
    <p> <?php esc_html_e( 'Title text color:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktxtcolor" id="wshk_disretextlinktxtcolor" value="<?php if(get_option('wshk_disretextlinktxtcolor')!=''){ echo get_option('wshk_disretextlinktxtcolor'); }?>" placeholder="#ffffff" size="10" /></p>
    <p> <?php esc_html_e( 'Title text-decoration:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktxd" id="wshk_disretextlinktxd" value="<?php if(get_option('wshk_disretextlinktxd')!=''){ echo get_option('wshk_disretextlinktxd'); }?>" placeholder="none" size="10" /></p>
    <p> <?php esc_html_e( 'Title link target:', 'woo-shortcodes-kit' ); ?><br /> <input type="text" name="wshk_disretextlinktarget" id="wshk_disretextlinktarget" value="<?php if(get_option('wshk_disretextlinktarget')!=''){ echo get_option('wshk_disretextlinktarget'); }?>" placeholder="_blank" size="10" /></p>
    <br />
    </td>-->                    
    </tr>
   <br />
    </table>
    <!--<br /><br /><br />-->
    <table width="100%">
        <tr>
            <td style="padding: 30px;" width="50%"><p><br><?php esc_html_e( 'How many reviews want display?', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" style="padding:10px;width:100%;" type="text" name="wshk_disredisplaynumber" id="wshk_disredisplaynumber" value="<?php if(get_option('wshk_disredisplaynumber')!=''){ echo get_option('wshk_disredisplaynumber'); }?>" placeholder="all" size="10" /></p><br /><small><?php esc_html_e( 'Write all to show all reviews or a specific number
            to show this number of reviews.', 'woo-shortcodes-kit' ); ?></small></td>
            
            <td style="padding: 30px; border-left: 1px solid;" width="50%"><p> <?php esc_html_e( 'How many columns want display?:', 'woo-shortcodes-kit' ); ?><br /> 
            <select name="wshk_disrecolumnsnumber" id="wshk_disrecolumnsnumber" style="border-bottom:1px solid #ddd !important;border-radius:4px;padding:10px;width:100%;"> <option <?php if (get_option('wshk_disrecolumnsnumber') == '1') { ?>selected="true" <?php }; ?> value="1"><?php esc_html_e( '1', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disrecolumnsnumber') == '2') { ?>selected="true" <?php }; ?> value="2"><?php esc_html_e( '2', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disrecolumnsnumber') == '3') { ?>selected="true" <?php }; ?> value="3"><?php esc_html_e( '3', 'woo-shortcodes-kit' ); ?></option> <option <?php if (get_option('wshk_disrecolumnsnumber') == '4') { ?>selected="true" <?php }; ?> value="4"><?php esc_html_e( '4', 'woo-shortcodes-kit' ); ?></option> </select>
            </p><br /><small style="margin-right:15px;"><?php esc_html_e( 'Choose the number of columns that you want display the reviews', 'woo-shortcodes-kit' ); ?></small></td>
        </tr>
    </table>
    <br><br>
    <p><b>3.- <?php esc_html_e( 'Additional shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'Now you can use the shortcode in differents pages and display a different number of reviews in each one', 'woo-shortcodes-kit' ); ?></small></p>
    <br>
    <code>[woo_display_reviews number="all"]</code><br>
    <small><?php esc_html_e( 'Just need copy this shortcode, and paste whatever you want. Can control the number of reviews to display from the shortcode replacing the number value', 'woo-shortcodes-kit' ); ?></small>
    <br /><br />
    </div>
    <!-- FIN display all shop reviews with a shortcode -->
    
    
    <!--SHORTCODES TO DISPLAY THE USER TOTAL SPENT ACCORDING TO THE ORDER STATUS -->
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enabletotalspender" name="wshk_enabletotalspender" value='8821' <?php if(get_option('wshk_enabletotalspender')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enabletotalspender></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Display the user total spent according to the order status', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'MOVED', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Expand for see the functions and shortcodes', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><br /><br>
    <?php esc_html_e( 'To understand how they work, these shortcodes show the total spent by the user in your store. This will allow your users to know how much money they have spent. To use them, you only need to copy the shortcode and paste it into the page my account or any other private page, since the user must be logged to see the result of the shortcode. You can add your own currency too after or before the shortcode.', 'woo-shortcodes-kit' ); ?></p><br /><br /> 


<table width="100%">
    <tr><th  style="padding-left:20px;"><?php esc_html_e( 'FUNCTIONS', 'woo-shortcodes-kit' ); ?></th>
    <th style="padding-left:20px;"><?php esc_html_e( 'SHORTCODES', 'woo-shortcodes-kit' ); ?></th></tr>
    <tr>
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total Balance', 'woo-shortcodes-kit' ); ?></p>
            <!--<p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total Spended', 'woo-shortcodes-kit' ); ?> <small><?php esc_html_e( '(looking for completed and in process orders)', 'woo-shortcodes-kit' ); ?></small></p>-->
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total pending', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total on hold', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total in process', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total completed', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total cancelled', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total refunded', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total failed', 'woo-shortcodes-kit' ); ?></p>
        </td>
        
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-balance]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-pending]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-on-hold]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-processing]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-completed]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-cancelled]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-refunded]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-total-orders-failed]</p>
        </td>
    </tr>
</table>

    <br />
    <br />
    </div>
    <!-- END SHORTCODES TO DISPLAY THE USER TOTAL SPENT ACCORDING TO THE ORDER STATUS -->
    
    
    
    <!--SHORTCODES TO DISPLAY THE USER ORDERS ACCORDING TO THE ORDER STATUS -->
        <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableordercountser" name="wshk_enableordercountser" value='8822' <?php if(get_option('wshk_enableordercountser')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableordercountser></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Display the user orders according to the status of the order', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'MOVED', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Expand for see the functions and shortcodes', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><br /><br>
    <?php esc_html_e( 'To understand how they work, these shortcodes show the total number of orders placed by the user in your store. This will allow the user to know how many orders they have made according to their status. To use them, you only need to copy the shortcode and paste it into the page my account or some other private page, since the user must have logged in to see the results of the shortcode. You can add text before or after the shortcode.', 'woo-shortcodes-kit' ); ?></p><br /><br /> 


<table width="100%">
    <tr><th  style="padding-left:20px;"><?php esc_html_e( 'FUNCTIONS', 'woo-shortcodes-kit' ); ?></th>
    <th style="padding-left:20px;"><?php esc_html_e( 'SHORTCODES', 'woo-shortcodes-kit' ); ?></th></tr>
    <tr>
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total orders', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total pending', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total on hold', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total in process', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total completed', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total cancelled', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total refunded', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Total failed', 'woo-shortcodes-kit' ); ?></p>
        </td>
        
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-pending]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-onhold]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-process]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-completed]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-cancelled]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-refunded]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-order-count-failed]</p>
        </td>
    </tr>
</table>

    <br />
    <br />
    </div>
    <!--END SHORTCODES TO DISPLAY THE USER ORDERS ACCORDING TO THE ORDER STATUS -->
     
    
    
    <!-- SHORTCODES TO DISPLAY THE USER BILLING DATA SEPARATELY -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablebillinguserdata" name="wshk_enablebillinguserdata" value='819' <?php if(get_option('wshk_enablebillinguserdata')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablebillinguserdata></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Display the user billing data separately', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'MOVED', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Expand for see the functions and shortcodes', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><br /><br>
    <?php esc_html_e( 'To understand how they work, these shortcodes show the billing user data. To use them, you only need to copy the shortcode and paste it into the page my account or some other private page, since the user must have logged in to see the results of the shortcode. You can add text before or after the shortcode.', 'woo-shortcodes-kit' ); ?></p><br /><br /> 


<table width="100%">
    <tr><th  style="padding-left:20px;"><?php esc_html_e( 'FUNCTIONS', 'woo-shortcodes-kit' ); ?></th>
    <th style="padding-left:20px;"><?php esc_html_e( 'SHORTCODES', 'woo-shortcodes-kit' ); ?></th></tr>
    <tr>
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user ID', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user name', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user lastname', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user address', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user post code', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user city', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user phone', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user email', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Billing user company', 'woo-shortcodes-kit' ); ?> <small style="color:green;">(<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>)</small></p>
        </td>
        
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-id]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-name]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-lastname]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-address]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-postcode]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-city]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-phone]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-email]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-billing-company]</p>
        </td>
    </tr>
</table>

    <br />
    <br />
    </div>
    <!-- END SHORTCODES TO DISPLAY THE USER BILLING DATA SEPARATELY -->
    
    <!--SHORTCODES TO DISPLAY THE USER SHIPPING DATA SEPARATELY -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableshippinguserdata" name="wshk_enableshippinguserdata" value='820' <?php if(get_option('wshk_enableshippinguserdata')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableshippinguserdata></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Display the user shipping data separately', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'MOVED', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Expand for see the functions and shortcodes', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><br /><br>
    <?php esc_html_e( 'To understand how they work, these shortcodes show the shipping user data. To use them, you only need to copy the shortcode and paste it into the page my account or some other private page, since the user must have logged in to see the results of the shortcode. You can add text before or after the shortcode.', 'woo-shortcodes-kit' ); ?></p><br /><br /> 


<table width="100%">
    <tr><th  style="padding-left:20px;"><?php esc_html_e( 'FUNCTIONS', 'woo-shortcodes-kit' ); ?></th>
    <th style="padding-left:20px;"><?php esc_html_e( 'SHORTCODES', 'woo-shortcodes-kit' ); ?></th></tr>
    <tr>
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user ID', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user name', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user lastname', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user address', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user post code', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user city', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user phone', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user email', 'woo-shortcodes-kit' ); ?></p>
            <p style="border-bottom:1px solid grey;padding-left:20px;"><?php esc_html_e( 'Shipping user company', 'woo-shortcodes-kit' ); ?> <small style="color:green;">(<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>)</small></p>
        </td>
        
        <td style="width:40%;">
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-id]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-name]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-lastname]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-address]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-postcode]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-city]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-phone]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-email]</p>
            <p style="border-bottom:1px solid grey;padding-left:20px;">[woo-shipping-company]</p>
        </td>
    </tr>
</table>

    <br />
    <br />
    </div>
    <!--END SHORTCODES TO DISPLAY THE USERS SHIPPING DATA SEPARATELY -->
    
    
    
    
    <!-- Display WooCommerce notices -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_displaywoonotices" name="wshk_displaywoonotices" value='18701' <?php if(get_option('wshk_displaywoonotices')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_displaywoonotices></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Display WooCommerce notices', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <br><br>
    <p><b>1.- <?php esc_html_e( 'The shortcode', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can use it on any page or post', 'woo-shortcodes-kit' ); ?></small></p>
<br><br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 25%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="[wshk_display_notices]" id="woomydispnotices" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctiondispnotices()" onmouseout="outFuncdispnotices()">
  <span class="tooltiptext" id="myTooltipdispnotice"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomydispnotices").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctiondispnotices() {
  var copyText = document.getElementById("woomydispnotices");
  copyText.select();
  document.execCommand("copy");
  
  var tooltipdispnotices = document.getElementById("myTooltipdispnotice");
  tooltipdispnotices.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncdispnotices() {
  var tooltipdispnotices = document.getElementById("myTooltipdispnotice");
  tooltipdispnotices.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
    <p><b>2.- <?php esc_html_e( 'Important recommendation', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'If you are using Woo Subscriptions, you can do its notices compatibles with ', 'woo-shortcodes-kit' ); ?><a href="https://disespubli.com/producto/custom-blocks-and-redirections-addon-for-wshk/" target="_blank" style="color:#a46497;">Custom Blocks and Redirections</a></small></p>
    <br /><br />
        </div>
    
    <!-- FIN Display WooCommerce notices -->
    
    
    
    
      </div>
    </li>
  <!--FIN ADDITIONALS SHORTCODES SECTION -->
  
  
  
  
    
  

 <!--RESTRICT SECTION -->
    <li>
     
       <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-hidden"></span> <?php esc_html_e( 'RESTRICT CONTENT TO LOGGED AND NON LOGGED IN USERS', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
         
    
    <!-- RESTRICT CONTENT FOR NON LOGGED IN USERS -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablerestrictctnt" name="wshk_enablerestrictctnt" value='22' <?php if(get_option('wshk_enablerestrictctnt')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablerestrictctnt></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Restrict content to users if they are not logged in', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and use the restrict content shortcode!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 26%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="<?php esc_html_e( '[wshk]Content here[/wshk]', 'woo-shortcodes-kit' ); ?>" id="woomyrestnonlog" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionrestnonlog()" onmouseout="outFuncrestnonlog()">
  <span class="tooltiptext" id="myTooltiprestnonlog"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyrestnonlog").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionrestnonlog() {
  var copyText = document.getElementById("woomyrestnonlog");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiprestnonlog = document.getElementById("myTooltiprestnonlog");
  tooltiprestnonlog.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncrestnonlog() {
  var tooltiprestnonlog = document.getElementById("myTooltiprestnonlog");
  tooltiprestnonlog.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
    
    
    
    </div>
    <!-- FIN RESTRICT CONTENT FOR NON LOGGED IN USERS-->
    
    <!-- RESTRICT CONTENT FOR LOGGED IN USERS -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableoffctnt" name="wshk_enableoffctnt" value='23' <?php if(get_option('wshk_enableoffctnt')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableoffctnt></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Restrict content to users if they are logged in', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and use the off content shortcode!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel">
    <br><br>
    <div onmousedown="return false;" onselectstart="return false;" style="max-height:130px;background-color:#a46497;color:white;border:1px solid #a46497;border-radius:13px;">
<table style="margin-top:-20px;">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 23%; padding-left: 30px;"><p><big><strong><span class="dashicons dashicons-code-standards"></span> <?php esc_html_e( 'Shortcode:', 'woo-shortcodes-kit' ); ?></strong><br><input class="testininputclass" onmousedown="return false;" onselectstart="return false;" style="color:white;margin-top:10px;outline:0;-moz-outline: 0;border:none;" type="text" value="<?php esc_html_e( '[off]Content here[/off]', 'woo-shortcodes-kit' ); ?>" id="woomyrestlogin" readonly></big><br /><br /></p></td>
        
        <td style="width: 23%; padding-left: 30px;"><p><big>

<div class="tooltip" style="width:120px;">
<button style="padding:10px;background-color:#a46497;color:white;border:1px solid white;border-radius:13px;width:150px;" type="button" onclick="myFunctionrestlogin()" onmouseout="outFuncrestlogin()">
  <span class="tooltiptext" id="myTooltiprestlogin"><?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?></span>
  <?php esc_html_e( 'Copy shortcode', 'woo-shortcodes-kit' ); ?>
  </button>
</div>



<script>

document.getElementById("woomyrestlogin").addEventListener("mousedown", function(event){
  event.preventDefault();
});

function myFunctionrestlogin() {
  var copyText = document.getElementById("woomyrestlogin");
  copyText.select();
  document.execCommand("copy");
  
  var tooltiprestlogin = document.getElementById("myTooltiprestlogin");
  tooltiprestlogin.innerHTML = "<?php esc_html_e( 'Copied:', 'woo-shortcodes-kit' ); ?> " + copyText.value;
}

function outFuncrestlogin() {
  var tooltiprestlogin = document.getElementById("myTooltiprestlogin");
  tooltiprestlogin.innerHTML = "<?php esc_html_e( 'Copy to Clipboard', 'woo-shortcodes-kit' ); ?>";
}
</script></big><br /><br /> </p></td>
        
        <td style="width: 46%; padding-left: 30px;"><p><span class="dashicons dashicons-warning"></span><big style="font-size:14px !important;"><strong><?php esc_html_e( 'Copy the shortcode and paste in your custom post or page', 'woo-shortcodes-kit' ); ?></strong></big><br /><br /></p></td></tr>
        
        <br />
        <br />
        </table>
</div>
<br><br>
    
    
    </div>
    <!-- FIN RESTRICT CONTENT FOR LOGGED IN USERS -->
    
     </div>
    </li>
   <!-- FIN RESTRICT SECTION --> 
    
    


    
    
    
    
    <!-- WOOCOMMERCE ADDITIONAL SETTINGS -->
    
    
    <li>
     
       <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-admin-generic"></span> <?php esc_html_e( 'WOOCOMMERCE ADDITIONAL SETTINGS', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          
    <!-- autocomplete orders -->
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enableautocom" name="wshk_enableautocom" value='84' <?php if(get_option('wshk_enableautocom')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableautocom></label><br /></th><th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Autocomplete the virtual products orders', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
    <table>
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 100%; padding-left: 30px;"><p><b><?php esc_html_e( 'With this function your orders will be completed automaticlly, just active it and forget the processing status.', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'All the orders with virtual products will be changed to the completed status.', 'woo-shortcodes-kit' ); ?></small></p><br><!--<div style="background-color:#a46497;padding:20px;color:white;"><strong><?php esc_html_e( 'This function is not valid for stores that need their orders to go through different states before being completed. For example, if you sell physical products and orders must go through states such as processing, shipping, until you reach the completed order status, this function is not recommended for your store, since it will cause the order to pass from the processing to the complete directly.', 'woo-shortcodes-kit' ); ?></strong></div>--><br /><br /> </td>
        
       </tr>
        
        <br />
        <br />
        </table>
        </div>
   
    <!-- FIN autocomplete orders -->
    
    <!-- custom thank you page -->
   
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enableacustomthankyoupage" name="wshk_enableacustomthankyoupage" value='87' <?php if(get_option('wshk_enableacustomthankyoupage')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableacustomthankyoupage></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Custom thank you pages', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>
<div class="panel">
     <br><br>
    <p><b><?php esc_html_e( 'Function settings', 'woo-shortcodes-kit' ); ?></b><br><small><?php esc_html_e( 'You can set up a different thank you page in up to 3 products. You can also add a different thank you page for the rest of the shop products.', 'woo-shortcodes-kit' ); ?></small></p>
    <br>
    <table width="90%">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 33%; padding-left: 30px;"><p><?php esc_html_e( 'Product one:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyouoneid" name="wshk_customthankyouoneid" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
 $all_ids = get_posts( array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
) );
  foreach ( $all_ids as $id ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $id ),
            esc_html( get_the_title($id) )
            
        );
        ;
  }
  
$getopthkoneid = get_option('wshk_customthankyouoneid');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkoneid; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($all_ids as $id): if($id == $getopthkoneid): echo get_the_title($id); endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> <p><?php esc_html_e( 'Custom thank you page for product one:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyouone" name="wshk_customthankyouone" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$getopthkpage = get_option('wshk_customthankyouone');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkpage; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopthkpage): echo $page->post_title; endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> </td>
        
        <td style="width: 33%; padding-left: 30px;"><p><?php esc_html_e( 'Product two:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyoutwoid" name="wshk_customthankyoutwoid" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
 $all_ids = get_posts( array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
) );
  foreach ( $all_ids as $id ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $id ),
            esc_html( get_the_title($id) )
            
        );
        ;
  }
  
$getopthktwoid = get_option('wshk_customthankyoutwoid');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthktwoid; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($all_ids as $id): if($id == $getopthktwoid): echo get_the_title($id); endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> <p><?php esc_html_e( 'Custom thank you page for product two:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyoutwo" name="wshk_customthankyoutwo" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$getopthkpagetwo = get_option('wshk_customthankyoutwo');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkpagetwo; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopthkpagetwo): echo $page->post_title; endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> </td>
        
        <td style="width: 34%; padding-left: 30px;"><p><?php esc_html_e( 'Product three:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyouthreeid" name="wshk_customthankyouthreeid" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
 $all_ids = get_posts( array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'publish',
        'fields' => 'ids',
) );
  foreach ( $all_ids as $id ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $id ),
            esc_html( get_the_title($id) )
            
        );
        ;
  }
  
$getopthkthreeid = get_option('wshk_customthankyouthreeid');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkthreeid; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($all_ids as $id): if($id == $getopthkthreeid): echo get_the_title($id); endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> <p><?php esc_html_e( 'Custom thank you page for product three:', 'woo-shortcodes-kit' ); ?><br /><br />
        <select id="wshk_customthankyouthree" name="wshk_customthankyouthree" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$getopthkpagethree = get_option('wshk_customthankyouthree');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkpagethree; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopthkpagethree): echo $page->post_title; endif; endforeach; ?></option>
</select>
        <br /></p><br /><br /> </td>
        
       </tr>
        
        <br />
        <br />
        </table>
        
      <p style="width:50%;padding-left:30px;"><?php esc_html_e( 'Global custom thank you page or for the rest of products:', 'woo-shortcodes-kit' ); ?><br /><br />
      <select id="wshk_customthankyougeneral" name="wshk_customthankyougeneral" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$getopthkpagegene = get_option('wshk_customthankyougeneral');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopthkpagegene; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopthkpagegene): echo $page->post_title; endif; endforeach; ?></option>
</select>
      <br /></p><br /><br />
        
        </div>
    
    <!-- FIN custom thank you page -->
    
    
    
    
    
    
    <!-- DISABLE THE NEW WOOCOMMERCE DASHBOARD -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_disablenewdashboardwc" name="wshk_disablenewdashboardwc" value='1851' <?php if(get_option('wshk_disablenewdashboardwc')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_disablenewdashboardwc></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Disable the new WooCommerce dashboard', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Just need activate and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><?php esc_html_e( 'Since WooCommerce 4.0 it add to your site a new features like a notification bar, new reports view (Analytics) and a new dashboard.', 'woo-shortcodes-kit' ); ?></p>
    <p>
    <?php esc_html_e( 'If you dont need the features introduced in WooCommerce 4.0 just activate this function and forget about them or activate again when you need it.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>
    <!-- END DISABLE THE NEW WOOCOMMERCE DASHBOARD -->
    
    
    
    
    
    
    
    
    <!-- add name and surname fields in register form -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_wcregisterformfieldsextra" name="wshk_wcregisterformfieldsextra" value='93' <?php if(get_option('wshk_wcregisterformfieldsextra')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_wcregisterformfieldsextra></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Add the Name and Surname fields in WooCommerce Register form', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>




<div class="panel">
    <table>
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 100%; padding-left: 30px;"> <p><?php esc_html_e( 'After enable the function and save the settings...', 'woo-shortcodes-kit' ); ?><br> <?php esc_html_e( 'Remember go to ', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;font-weight:600;text-decoration:underline;" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wc-settings&tab=account" target="_blank"><?php esc_html_e( 'WooCommerce settings', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( ' to enable the option: Allow customers to create an account on the "My account" page', 'woo-shortcodes-kit' ); ?><br /></p><br /><br /> </td>
        
       </tr>
        
        <br />
        <br />
        </table>
        </div>
    
<!-- FIN add name and surname fields in register form -->    
    
    
    
    

    
    
    

<!-- SKIP CART AND GO TO CHECKOUT -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_enableskipcart" name="wshk_enableskipcart" value='96' <?php if(get_option('wshk_enableskipcart')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableskipcart></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Skip Cart and go straight to Checkout page', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>




<div class="panel">
    <br />
    <br />
            
             <p style="width: 100%; padding-left: 30px;"><?php esc_html_e( 'After enable the function and save the settings...', 'woo-shortcodes-kit' ); ?><br>  <?php esc_html_e( 'Remember go to ', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;font-weight:600;text-decoration:underline;" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wc-settings&tab=products" target="_blank"><?php esc_html_e( 'WooCommerce settings', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( ' to disable option: Redirect to the cart page after successful addition', 'woo-shortcodes-kit' ); ?><br /></p><br /><br /> </td>
        
      
        <br />
        <br />
        </div>

    <!-- FIN skip cart and go to checkout-->
    
    
    <!-- display product image in order email -->
        <div class="accordion">
    <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
    <th><p><input type="checkbox" class="testininputclass" id="wshk_test" name="wshk_test" value='2' <?php if(get_option('wshk_test')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_test></label><br /></th>
    <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Product thumbnail in email orders', 'woo-shortcodes-kit' ); ?>    </big><br /><small>  <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
    
 
</table>
</div>


<!-- contenido funcion container -->
<div class="panel">
<br />
<br />
<table>
<tr>
<td>
<p style="width: 100%; padding-left: 30px;"> <?php esc_html_e( 'Set the size for the product thumbnail:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_emailordersizes" name="wshk_emailordersizes" value="<?php if(get_option('wshk_emailordersizes')!=''){ echo get_option('wshk_emailordersizes'); }?>" placeholder="100px"/ size="20"><br /></p></td>
</tr>
</table>
<br /><br />
</div>

<!-- FIN display product image in order email -->



<!-- DISPLAY THE PRODUCT IMAGE IN THE ORDER DETAILS 
         from Beta tester section -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enableproimage" name="wshk_enableproimage" value='8833' <?php if(get_option('wshk_enableproimage')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enableproimage></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Product image in the order details', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'MOVED', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Just need activate and customize the style!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<p><br /><br>
    <?php esc_html_e( 'To understand how it work, this function display the product image in the order details after make click in the view order button. To use them, you only need enable the function. The user must have logged in to see the order details. You can add your custom styles for the product image too.', 'woo-shortcodes-kit' ); ?></p><br /><br /> 

<h3><?php esc_html_e( 'Customize the product image style', 'woo-shortcodes-kit' ); ?></h3>
<p> <?php esc_html_e( 'Image size:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_prodimagesize" id="wshk_prodimagesize" value="<?php if(get_option('wshk_prodimagesize')!=''){ echo get_option('wshk_prodimagesize'); }?>" placeholder="100px" size="10" /></p>

<p> <?php esc_html_e( 'Image border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_prodimagebordsize" id="wshk_prodimagebordsize" value="<?php if(get_option('wshk_prodimagebordsize')!=''){ echo get_option('wshk_prodimagebordsize'); }?>" placeholder="1px" size="10" /></p> 

<p> <?php esc_html_e( 'Image border (type):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_prodimagebordtype" id="wshk_prodimagebordtype" value="<?php if(get_option('wshk_prodimagebordtype')!=''){ echo get_option('wshk_prodimagebordtype'); }?>" placeholder="solid" size="10" /></p>

<p> <?php esc_html_e( 'Image border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_prodimagebordcolor" id="wshk_prodimagebordcolor" value="<?php if(get_option('wshk_prodimagebordcolor')!=''){ echo get_option('wshk_prodimagebordcolor'); }?>" placeholder="#a46497" size="10" /></p>

<p> <?php esc_html_e( 'Image border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_prodimagebordradius" id="wshk_prodimagebordradius" value="<?php if(get_option('wshk_prodimagebordradius')!=''){ echo get_option('wshk_prodimagebordradius'); }?>" placeholder="100%" size="10" /></p>
    <br />
    <br />
    </div>
    <!-- END DISPLAY PRODUCT IMAGE IN THE ORDER DETAILS -->



<!-- LIMIT THE NUMBER OF PRODUCTS IN CART -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_onlyoneincartt" name="wshk_onlyoneincartt" value='2009' <?php if(get_option('wshk_onlyoneincartt')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_onlyoneincartt></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Limit the number of products in the cart', 'woo-shortcodes-kit' ); ?></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>




<div class="panel">
    <br />
    <br />
            
             <p style="width: 100%; padding-left: 30px;"><?php esc_html_e( 'When you activate this function, you must add a number of products to determine how many products can be added to the cart.', 'woo-shortcodes-kit' ); ?><br><br> <?php esc_html_e( 'This value will allow only the number of established products to be added to the cart, which means that if the user adds more products than the established number, the cart will restart with the last product added.', 'woo-shortcodes-kit' ); ?><br /></p><br />
             
             <p style="width:350px;padding-left: 30px;"> <?php esc_html_e( 'Set the numbers of products allowed to add in the cart:', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="number" id="wshk_productsincart" name="wshk_productsincart" value="<?php if(get_option('wshk_productsincart')!=''){ echo get_option('wshk_productsincart'); }?>" placeholder="1"/ size="20"><br /></p>
             
             <p style="border: 1px solid #ddd;padding: 10px;color: #a46497;"><?php esc_html_e( 'Example', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'If you set that only 2 products can be added to the cart and a customer adds 3 products, only the third product added will be shown in the cart. Since it had 2 products added, which is the maximum established and has added one more, it causes the cart to restart and pass to have only the product that was added as a third product.', 'woo-shortcodes-kit' ); ?></small></p>
             </td>
        
      
        <br />
        <br />
        </div>

    <!-- FIN LIMIT THE NUMBER OF PRODUCTS IN CART -->
    
    
    
    
    <!-- CHANGE RETURN TO SHOP BUTTON TEXT AND REDIRECTION -->

<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_returntoshopbtn" name="wshk_returntoshopbtn" value='2011' <?php if(get_option('wshk_returntoshopbtn')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_returntoshopbtn></label><br /></th> <th style="padding: 20px 20px 0px 20px;"><big><?php esc_html_e( 'Change the return to shop button text and add custom redirection', 'woo-shortcodes-kit' ); ?> </big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th>
         </table>
</div>




<div class="panel">
    <br />
    <br />
    
             <p style="padding-left: 30px;"><?php esc_html_e( 'When you activate this function, you must add a custom text for the button and it will change.', 'woo-shortcodes-kit' ); ?><br><br> <?php esc_html_e( 'The URL can be empty if you want to redirect users to the default store page. If you want to redirect to another page, simply choose the page.', 'woo-shortcodes-kit' ); ?><br /></p><br />
            
             <p style="width:350px;padding-left: 30px;"> <?php esc_html_e( 'Write the button text', 'woo-shortcodes-kit' ); ?><br /><br /> <input class="testininputclass" type="text" id="wshk_retshopbtntext" name="wshk_retshopbtntext" value="<?php if(get_option('wshk_retshopbtntext')!=''){ echo get_option('wshk_retshopbtntext'); }?>" placeholder="Return"/ size="20"><br /></p>
             
             
             <p style="padding-left: 30px;"> <?php esc_html_e( 'Choose the page to redirect', 'woo-shortcodes-kit' ); ?><br /><br /> 
             
             <select id="wshk_retshopurlredi" name="wshk_retshopurlredi" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
        
  
  }
$getopbtnredishop = get_option('wshk_retshopurlredi');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopbtnredishop; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopbtnredishop): echo $page->post_title; endif; endforeach; ?></option>
</select>
             <br /></p>
             <br><br>
             
             <p style="border: 1px solid #ddd;padding: 10px;color: #a46497;"><?php esc_html_e( 'Example', 'woo-shortcodes-kit' ); ?><br><small style="color:grey;"><?php esc_html_e( 'By default, the button shows the text "Return to shop" and redirects to the default store page, but for example, you can type the text "Go to the store" and choose a different page to redirect.', 'woo-shortcodes-kit' ); ?></small></p>
             </td>
        
      
        <br />
        <br />
        </div>

    <!-- FIN CHANGE RETURN TO SHOP BUTTON TEXT AND REDIRECTION -->
    
     
    
    




    
      </div>
    </li>
<!-- FIN WOOCOMMERCE ADDITIONAL SETTINGS -->
    
     
  
  
  
  
  
    
  
    
    <!-- ADAPT TO GPRD LAW SECTION-->
    <li>
     
       <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-thumbs-up"></span> <?php esc_html_e( 'ADAPT YOUR SHOP TO THE GDPR LAW', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          
         <!-- GPRD law global settings --> 
          <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_gprdsettings" name="wshk_gprdsettings" value='88' <?php if(get_option('wshk_gprdsettings')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_gprdsettings></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Global settings', 'woo-shortcodes-kit' ); ?></big> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<p style="padding-left: 30px;"><?php esc_html_e( 'This settings will be used for 4 different cases (WordPress comments, WooCommerce reviews, register form and checkout page).', 'woo-shortcodes-kit' ); ?></p>

<table style="width: 100%;"><tr><td style="width: 50%;padding-left:30px;">
    <p style="color:grey;border:1px solid grey; border-radius:13px;padding:15px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'The checkbox message can be configured from here globally or from each function to add a different message in each case.', 'woo-shortcodes-kit' ); ?></p><br>
    <p><b>1. <?php esc_html_e( 'Write your message for the checkbox:', 'woo-shortcodes-kit' ); ?> </b><br /><small style="color:grey;"><?php esc_html_e( 'Example: I have read and accept the privacy policy', 'woo-shortcodes-kit' ); ?></small><br /> <table><tr><td style="width: 50%;"><input class="testininputclass" type="text" name="wshk_gprdiread" id="wshk_gprdiread" value="<?php if(get_option('wshk_gprdiread')!=''){ echo get_option('wshk_gprdiread'); }?>" placeholder="<?php esc_html_e( "Write your custom checkbox message", "woo-shortcodes-kit" ); ?>" size="60" /></td></tr></table></p>
    
    
     <p><b>2. <?php esc_html_e( 'Set your custom privacy policy page:
', 'woo-shortcodes-kit' ); ?> </b><br /><small style="color:grey;"><?php esc_html_e( 'The choosed page will be linked with the checkbox message', 'woo-shortcodes-kit' ); ?></small><br /> <table><tr><td style="width: 50%;">
    
    <select id="wshk_gprdurlslug" name="wshk_gprdurlslug" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$getopprivpoli = get_option('wshk_gprdurlslug');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $getopprivpoli; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $getopprivpoli): echo $page->post_title; endif; endforeach; ?></option>
</select>

    </td></tr></table></p><br>



<!--<p style="font-weight: bolder; font-size: 16px;">3. <?php esc_html_e( 'Set your custom link text:', 'woo-shortcodes-kit' ); ?> <br /><br /> <table><tr><td style="width: 50%;"><input type="text" name="wshk_gprdpolit" id="wshk_gprdpolit" value="<?php if(get_option('wshk_gprdpolit')!=''){ echo get_option('wshk_gprdpolit'); }?>" placeholder="<?php esc_html_e( "Write your custom link text", "woo-shortcodes-kit" ); ?>" size="60" /></td></tr></table></p>-->

<!--<p style="font-weight: bolder; font-size: 16px;">4. <?php esc_html_e( 'Set your custom error text:', 'woo-shortcodes-kit' ); ?> <br /><br /> <table><tr><td style="width: 50%;"><input type="text" name="wshk_gprderror" id="wshk_gprderror" value="<?php if(get_option('wshk_gprderror')!=''){ echo get_option('wshk_gprderror'); }?>" placeholder="<?php esc_html_e( "Write your custom error text", "woo-shortcodes-kit" ); ?>" size="60" /></td></tr></table></p>-->

</td>

<td style="padding-left: 30px;width:50%;padding-top:25px;">
    <br />
<p><b>3. <?php esc_html_e( 'Set your verification message:', 'woo-shortcodes-kit' ); ?></b><br /><small style="color:grey;"><?php esc_html_e( 'This message will be shown in the emails of the administrator in each case, allowing that in any case of problems with the user, you can demonstrate that the user has accepted the privacy policy before performing the action.', 'woo-shortcodes-kit' ); ?></small><br /><br> <textarea name="wshk_gprduserlegalinfo" id="wshk_gprduserlegalinfo" class="textarea"  cols="100" rows="100" id="wshk_gprduserlegalinfo" placeholder="<?php esc_html_e( 'For example: This user has read and accepted the privacy policy before performing this action on the web. The data provided by the user, are treated in accordance with the provisions of the privacy policy of this website. In case of disagreement, this email can be used as proof, to prove it.', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:400px;overflow: auto; -webkit-overflow-scrolling: touch;border:1px solid #ddd !Important;"><?php if(get_option('wshk_gprduserlegalinfo')!=''){ echo get_option('wshk_gprduserlegalinfo'); }?></textarea><br /></p>




</td>
</tr></table>
    <br />
    <br />
    </div>
    <!-- GPRD law global settings -->
    
    <!-- GPRD law on blog comments -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_gprdcomments" name="wshk_gprdcomments" value='89' <?php if(get_option('wshk_gprdcomments')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_gprdcomments></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'GDPR on WordPress comments', 'woo-shortcodes-kit' ); ?></big> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<table>
    <tr>
        <td>
            <br>
            
            
            <p style="font-weight: 600; font-size: 14px;padding-left:30px;">1. <?php esc_html_e( 'Write your message for the checkbox:', 'woo-shortcodes-kit' ); ?> <br /><small style="color:grey;"><?php esc_html_e( 'Example: I have read and accept the privacy policy', 'woo-shortcodes-kit' ); ?></small><br /><br> <input class="testininputclass" type="text" name="wshk_gprdireadcomments" id="wshk_gprdireadcomments" value="<?php if(get_option('wshk_gprdireadcomments')!=''){ echo get_option('wshk_gprdireadcomments'); }?>" placeholder="<?php esc_html_e( "Write your custom checkbox message", "woo-shortcodes-kit" ); ?>" size="60" /></p>
            
            
            
            <br>
    <p style="font-weight: 600; font-size: 14px;padding-left:30px;">2. <?php esc_html_e( 'Set your legal summary text on user information:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_gprdcomveri" id="wshk_gprdcomveri" class="textarea" cols="100" rows="100" id="wshk_gprdcomveri" placeholder="<?php esc_html_e( 'Information regarding the data that you provide when leaving your comments, orders and reviews.
-responsable
-purpose
-legitimation
-recipients
-rights 

You can write all of you want', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:245px;overflow: auto; -webkit-overflow-scrolling: touch;"><?php if(get_option('wshk_gprdcomveri')!=''){ echo get_option('wshk_gprdcomveri'); }?></textarea></p><small style="padding-left:30px;font-weight:bolder;color:#a46497;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'You can add HTML code too!', 'woo-shortcodes-kit' ); ?></small></td>
        
        <td style="font-weight: 600; font-size: 14px;padding: 50px; border-left: 0px solid; width: 35%;"><h4><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
           
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcommentsbdsize" id="wshk_gprdcommentsbdsize" value="<?php if(get_option('wshk_gprdcommentsbdsize')!=''){ echo get_option('wshk_gprdcommentsbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcommentsbdradius" id="wshk_gprdcommentsbdradius" value="<?php if(get_option('wshk_gprdcommentsbdradius')!=''){ echo get_option('wshk_gprdcommentsbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcommentsbdtype" id="wshk_gprdcommentsbdtype" value="<?php if(get_option('wshk_gprdcommentsbdtype')!=''){ echo get_option('wshk_gprdcommentsbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcommentsbdcolor" id="wshk_gprdcommentsbdcolor" value="<?php if(get_option('wshk_gprdcommentsbdcolor')!=''){ echo get_option('wshk_gprdcommentsbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcommentsbgcolor" id="wshk_gprdcommentsbgcolor" value="<?php if(get_option('wshk_gprdcommentsbgcolor')!=''){ echo get_option('wshk_gprdcommentsbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcommentspadding" id="wshk_gprdcommentspadding" value="<?php if(get_option('wshk_gprdcommentspadding')!=''){ echo get_option('wshk_gprdcommentspadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
    </td>
    </tr>
</table>
    <br />
    <br />
    </div>
    <!-- GPRD law on blog comments -->
    
    <!-- GPRD law on checkout page -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_gprdorders" name="wshk_gprdorders" value='90' <?php if(get_option('wshk_gprdorders')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_gprdorders></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'GDPR on WooCommerce checkout page', 'woo-shortcodes-kit' ); ?></big> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<table>
    <tr>
        <td>
            
            <br>
            
            
            <p style="font-weight: 600; font-size: 14px;padding-left:30px;">1. <?php esc_html_e( 'Write your message for the checkbox:', 'woo-shortcodes-kit' ); ?> <br /><small style="color:grey;"><?php esc_html_e( 'Example: I have read and accept the privacy policy', 'woo-shortcodes-kit' ); ?></small><br /><br> <input class="testininputclass" type="text" name="wshk_gprdireadcheckout" id="wshk_gprdireadcheckout" value="<?php if(get_option('wshk_gprdireadcheckout')!=''){ echo get_option('wshk_gprdireadcheckout'); }?>" placeholder="<?php esc_html_e( "Write your custom checkbox message", "woo-shortcodes-kit" ); ?>" size="60" /></p>
            
            
            
            <br>
            
    <p style="font-weight: 600; font-size: 14px;padding-left:30px;">2. <?php esc_html_e( 'Set your legal summary text on user information:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_gprdordveri" id="wshk_gprdordveri" class="textarea" cols="100" rows="100" id="wshk_gprdordveri" placeholder="<?php esc_html_e( 'Information regarding the data that you provide when leaving your comments, orders and reviews.
-responsable
-purpose
-legitimation
-recipients
-rights 

You can write all of you want.', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:245px;overflow: auto; -webkit-overflow-scrolling: touch;"><?php if(get_option('wshk_gprdordveri')!=''){ echo get_option('wshk_gprdordveri'); }?></textarea></p><small style="padding-left:30px;font-weight:bolder;color:#a46497;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'You can add HTML code too!', 'woo-shortcodes-kit' ); ?></small></td>
        
    <td style="font-weight: 600; font-size: 14px;padding: 50px; border-left: 0px solid; width: 35%;"><h4><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
           
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcheckoutbdsize" id="wshk_gprdcheckoutbdsize" value="<?php if(get_option('wshk_gprdcheckoutbdsize')!=''){ echo get_option('wshk_gprdcheckoutbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcheckoutbdradius" id="wshk_gprdcheckoutbdradius" value="<?php if(get_option('wshk_gprdcheckoutbdradius')!=''){ echo get_option('wshk_gprdcheckoutbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcheckoutbdtype" id="wshk_gprdcheckoutbdtype" value="<?php if(get_option('wshk_gprdcheckoutbdtype')!=''){ echo get_option('wshk_gprdcheckoutbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcheckoutbdcolor" id="wshk_gprdcheckoutbdcolor" value="<?php if(get_option('wshk_gprdcheckoutbdcolor')!=''){ echo get_option('wshk_gprdcheckoutbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdcheckoutbgcolor" id="wshk_gprdcheckoutbgcolor" value="<?php if(get_option('wshk_gprdcheckoutbgcolor')!=''){ echo get_option('wshk_gprdcheckoutbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdcheckoutpadding" id="wshk_gprdcheckoutpadding" value="<?php if(get_option('wshk_gprdcheckoutpadding')!=''){ echo get_option('wshk_gprdcheckoutpadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
    </td>
    </tr>
</table>
    <br />
    <br />
    </div>
    
    <!-- FIN GPRD law on checkout page -->
    
    <!-- GPRD law on WooCommerce reviews -->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th>
        <p><input type="checkbox" class="testininputclass" id="wshk_gprdreviews" name="wshk_gprdreviews" value='91' <?php if(get_option('wshk_gprdreviews')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_gprdreviews></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'GDPR on WooCommerce reviews', 'woo-shortcodes-kit' ); ?></big> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />

<table>
    <tr>
        <td>
            
            <br>
            
            
            <p style="font-weight: 600; font-size: 14px;padding-left:30px;">1. <?php esc_html_e( 'Write your message for the checkbox:', 'woo-shortcodes-kit' ); ?> <br /><small style="color:grey;"><?php esc_html_e( 'Example: I have read and accept the privacy policy', 'woo-shortcodes-kit' ); ?></small><br /><br> <input class="testininputclass" type="text" name="wshk_gprdireadreviews" id="wshk_gprdireadreviews" value="<?php if(get_option('wshk_gprdireadreviews')!=''){ echo get_option('wshk_gprdireadreviews'); }?>" placeholder="<?php esc_html_e( "Write your custom checkbox message", "woo-shortcodes-kit" ); ?>" size="60" /></p>
            
            
            
            <br>
            
            
    <p style="font-weight: 600; font-size: 14px;padding-left:30px;">2. <?php esc_html_e( 'Set your legal summary text on user information:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_gprdrewveri" id="wshk_gprdrewveri" class="textarea" cols="100" rows="100" id="wshk_gprdrewveri" placeholder="<?php esc_html_e( 'Information regarding the data that you provide when leaving your comments, orders and reviews.
-responsable
-purpose
-legitimation
-recipients
-rights 

You can write all of you want.', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:245px;overflow: auto; -webkit-overflow-scrolling: touch;"><?php if(get_option('wshk_gprdrewveri')!=''){ echo get_option('wshk_gprdrewveri'); }?></textarea></p><small style="padding-left:30px;font-weight:bolder;color:#a46497;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'You can add HTML code too!', 'woo-shortcodes-kit' ); ?></small></td>

        <td style="font-weight: 600; font-size: 14px;padding: 50px; border-left: 0px solid; width: 35%;"><h4><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
           
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdreviewsbdsize" id="wshk_gprdreviewsbdsize" value="<?php if(get_option('wshk_gprdreviewsbdsize')!=''){ echo get_option('wshk_gprdreviewsbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdreviewsbdradius" id="wshk_gprdreviewsbdradius" value="<?php if(get_option('wshk_gprdreviewsbdradius')!=''){ echo get_option('wshk_gprdreviewsbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdreviewsbdtype" id="wshk_gprdreviewsbdtype" value="<?php if(get_option('wshk_gprdreviewsbdtype')!=''){ echo get_option('wshk_gprdreviewsbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdreviewsbdcolor" id="wshk_gprdreviewsbdcolor" value="<?php if(get_option('wshk_gprdreviewsbdcolor')!=''){ echo get_option('wshk_gprdreviewsbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdreviewsbgcolor" id="wshk_gprdreviewsbgcolor" value="<?php if(get_option('wshk_gprdreviewsbgcolor')!=''){ echo get_option('wshk_gprdreviewsbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdreviewspadding" id="wshk_gprdreviewspadding" value="<?php if(get_option('wshk_gprdreviewspadding')!=''){ echo get_option('wshk_gprdreviewspadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
    </td>
    </tr>
</table>
    <br />
    <br />
    </div>
 <!-- FIN GPRD law on WooCommerce reviews-->   
    
    
    
    
    
    <!-- GPRD law in register form-->
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_gprdwcregisterform" name="wshk_gprdwcregisterform" value='9292' <?php if(get_option('wshk_gprdwcregisterform')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_gprdwcregisterform></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'GDPR on WooCommerce Register Form', 'woo-shortcodes-kit' ); ?></big> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
<table>
    <tr>
        <td>
            
            <br>
            
            
            <p style="font-weight: 600; font-size: 14px;padding-left:30px;">1. <?php esc_html_e( 'Write your message for the checkbox:', 'woo-shortcodes-kit' ); ?> <br /><small style="color:grey;"><?php esc_html_e( 'Example: I have read and accept the privacy policy', 'woo-shortcodes-kit' ); ?></small><br /><br> <input class="testininputclass" type="text" name="wshk_gprdireadregister" id="wshk_gprdireadregister" value="<?php if(get_option('wshk_gprdireadregister')!=''){ echo get_option('wshk_gprdireadregister'); }?>" placeholder="<?php esc_html_e( "Write your custom checkbox message", "woo-shortcodes-kit" ); ?>" size="60" /></p>
            
            
            
            <br>
            
            
    <p style="font-weight: 600; font-size: 14px;padding-left:30px;">2. <?php esc_html_e( 'Set your legal summary text on user information:', 'woo-shortcodes-kit' ); ?><br /><br /> <textarea name="wshk_gprdregveri" id="wshk_gprdregveri" class="textarea" cols="100" rows="100" id="wshk_gprdregveri" placeholder="<?php esc_html_e( 'Information regarding the data that you provide when leaving your comments, orders and reviews.
-responsable
-purpose
-legitimation
-recipients
-rights 

You can write all of you want.', 'woo-shortcodes-kit' ); ?>" size="30%" style="height:245px;overflow: auto; -webkit-overflow-scrolling: touch;"><?php if(get_option('wshk_gprdregveri')!=''){ echo get_option('wshk_gprdregveri'); }?></textarea></p><small style="padding-left:30px;font-weight:bolder;color:#a46497;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'You can add HTML code too!', 'woo-shortcodes-kit' ); ?></small></td>


       
        
        <td style="font-weight: 600; font-size: 14px;padding: 50px; border-left: 0px solid; width: 35%;"><h4><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e( 'Customize the box', 'woo-shortcodes-kit' ); ?></h4>
           
    <p> <?php esc_html_e( 'Box border (size):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdregisterbdsize" id="wshk_gprdregisterbdsize" value="<?php if(get_option('wshk_gprdregisterbdsize')!=''){ echo get_option('wshk_gprdregisterbdsize'); }?>" placeholder="1px" size="10" /></p>    
    <p> <?php esc_html_e( 'Box border (radius):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdregisterbdradius" id="wshk_gprdregisterbdradius" value="<?php if(get_option('wshk_gprdregisterbdradius')!=''){ echo get_option('wshk_gprdregisterbdradius'); }?>" placeholder="13%" size="10" /></p>    
   <p> <?php esc_html_e( 'Box border (type):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdregisterbdtype" id="wshk_gprdregisterbdtype" value="<?php if(get_option('wshk_gprdregisterbdtype')!=''){ echo get_option('wshk_gprdregisterbdtype'); }?>" placeholder="<?php esc_html_e( "solid", "woo-shortcodes-kit" ); ?>" size="10" /></p>   
    <p> <?php esc_html_e( 'Box border (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdregisterbdcolor" id="wshk_gprdregisterbdcolor" value="<?php if(get_option('wshk_gprdregisterbdcolor')!=''){ echo get_option('wshk_gprdregisterbdcolor'); }?>" placeholder="#a46497" size="10%" /></p>
    <p> <?php esc_html_e( 'Box background (color):', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="text" name="wshk_gprdregisterbgcolor" id="wshk_gprdregisterbgcolor" value="<?php if(get_option('wshk_gprdregisterbgcolor')!=''){ echo get_option('wshk_gprdregisterbgcolor'); }?>" placeholder="#ffffff" size="10%" /></p>
    <p> <?php esc_html_e( 'Box padding:', 'woo-shortcodes-kit' ); ?><br /> <input class="testininputclass" type="number" name="wshk_gprdregisterpadding" id="wshk_gprdregisterpadding" value="<?php if(get_option('wshk_gprdregisterpadding')!=''){ echo get_option('wshk_gprdregisterpadding'); }?>" placeholder="20px" size="10" /></p>  
    <br /><br />
        
        
        </td>
    </tr>
</table>
    <br />
    <br />
    </div>
    <!-- FIN GPRD on register form -->
    
    
     <!-- add custom terms and conditions -->   
    
     <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  
         <th><p><input type="checkbox" class="testininputclass" id="wshk_wcnewtermsbox" name="wshk_wcnewtermsbox" value='94' <?php if(get_option('wshk_wcnewtermsbox')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_wcnewtermsbox></label></th> <th style="padding: 30px 20px 0px 20px;"><big><br /><?php esc_html_e( 'Custom terms and conditions checkbox in WooCommece checkout page', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small><?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p><br /></th>
         </table>
</div>




<div class="panel">
    <table width="100%">
          <colgroup>
    <col span="3">
   
  </colgroup>
         <tr>
        <td style="width: 100%; padding-left: 30px;">
            
            <table width="100%">
                <tr>
                    <td style="width: 33%; padding-left: 30px;"><p style="font-weight:600;font-size:14px;">1.- <?php esc_html_e( "Write the checkbox initial text", "woo-shortcodes-kit" ); ?></p> <input class="testininputclass" type="text" id="wshk_termstexto" name="wshk_termstexto" value="<?php if(get_option('wshk_termstexto')!=''){ echo get_option('wshk_termstexto'); }?>" placeholder="<?php esc_html_e( "add your custom text here", "woo-shortcodes-kit" ); ?>"/ size="20"></td>
                    
                    
                    <td style="width: 33%; padding-left: 30px;"><p style="font-weight:600;font-size:14px;">2.- <?php esc_html_e( "Choose the terms and conditions page", "woo-shortcodes-kit" ); ?></p> 
                    
                    
                    
                    <select id="wshk_termslink" name="wshk_termslink" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
          
  }
$gettermpagslug = get_option('wshk_termslink');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $gettermpagslug; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $gettermpagslug): echo $page->post_title; endif; endforeach; ?></option>
</select>
                    
                    
                    </td>
                    
                    
                    <td style="width: 34%; padding-left: 30px;"><p style="font-weight:600;font-size:14px;">3.- <?php esc_html_e( "Write your custom text link", "woo-shortcodes-kit" ); ?></p> <input class="testininputclass" type="text" id="wshk_termstextlink" name="wshk_termstextlink" value="<?php if(get_option('wshk_termstextlink')!=''){ echo get_option('wshk_termstextlink'); }?>" placeholder="<?php esc_html_e( "add your custom link text here", "woo-shortcodes-kit" ); ?>"/ size="20"></td>
                </tr>
            </table>
            
             <p> <?php esc_html_e( 'Remember go to ', 'woo-shortcodes-kit' ); ?> <a style="color:#a46497;font-weight:600;text-decoration:underline;" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wc-settings&tab=advanced" target="_blank"><?php esc_html_e( 'WooCommerce settings', 'woo-shortcodes-kit' ); ?></a> <?php esc_html_e( ' to disable the WooCommerce terms and conditions default page option', 'woo-shortcodes-kit' ); ?><br /></p><br /><br /> </td>
        
       </tr>
        
        <br />
        <br />
        </table>
        </div>
    
<!-- FIN add custom terms and conditions -->    
    
      </div>
    </li>
    <!--FIN GPRD LAW SECTION -->
    
    
    
      <!--SECURITY AND RESTRICT SECTION -->
    <li>
     
       <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="margin-top: 25px;padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;"><span class="dashicons dashicons-shield"></span> <?php esc_html_e( 'ADD SECURITY TO YOUR SHOP', 'woo-shortcodes-kit' ); ?></h3></div>
      <div class="acc_panel">
          <br /><br />
          
          <!-- BLOCK WP-ADMIN and WP-LOGIN ACCESS -->
          <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablesloginsec" name="wshk_enablesloginsec" value='20' <?php if(get_option('wshk_enablesloginsec')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablesloginsec></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Block users access to wp-admin and wp-login.php', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'After activating this function, nobody will be able to access wp-admin or wp-login.php , you can choose the page to redirect the users or will be redirected to the "My Account" page of WooCommerce by default.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <p style="padding-left: 30px;"> <?php esc_html_e( 'Choose the page to redirect', 'woo-shortcodes-kit' ); ?><br /><br /> 
             
             <select id="wshk_blockadmredirect" name="wshk_blockadmredirect" style="border:1px solid #ddd !important;border-radius:13px;padding:10px;width:250px;"> 
 <option value=""><?php esc_html_e( 'None', 'woo-shortcodes-kit' ); ?></option> 
 <?php 
  $pages = get_pages(); 
  foreach ( $pages as $page ) {
      
      printf( '<option value="%1$s">%2$s</option>',
            //esc_html( get_page_link( $page->ID ) ),
            esc_html( $page->post_name ),
            esc_html( $page->post_title )
            
        );
        
  
  }
$blockadmredirect = get_option('wshk_blockadmredirect');
 ?>
 <option style="background-color:#a46497;color:white;" value="<?php echo $blockadmredirect; ?>" selected ><?php esc_html_e( 'Selected: ', 'woo-shortcodes-kit' );  foreach($pages as $page): if($page->post_name == $blockadmredirect): echo $page->post_title; endif; endforeach; ?></option>
</select>
             <br />
             <br />
             <br />
    </div>
    <!-- FIN BLOCK WP-ADMIN and WP-LOGIN ACCESS -->
    
    <!-- BLOCK ADMIN TOP BAR -->
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablesadminbar" name="wshk_enablesadminbar" value='21' <?php if(get_option('wshk_enablesadminbar')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablesadminbar></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Block users access to the backend from the top administrator bar', 'woo-shortcodes-kit' ); ?></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'After activating this function, no user can access the backend from the top bar of the administrator, because it will be hidden.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    <br />
    </div>

<!-- FIN BLOCK ADMIN TOP BAR -->


    
    <!-- HIDE LOGIN ERROR MESSAGE -->
    
   
    
    
    
    <div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablehidelogerror" name="wshk_enablehidelogerror" value='86' <?php if(get_option('wshk_enablehidelogerror')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablehidelogerror></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Hide login errors in the login form', 'woo-shortcodes-kit' ); ?> <!--<span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span>--></big><br /><small> <?php esc_html_e( 'Activate the function and click here to configure it', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
  <p><?php esc_html_e( '
By default, WooCommerce shows form failures when entering an incorrect field.

For example, if you add the password incorrectly, it will indicate that the password is incorrect. The same happens if you make a mistake in the user.

This function prevents this type of information from being displayed and also allows you to add a personalized message.', 'woo-shortcodes-kit' ); ?></p><br>
    <p><?php esc_html_e( 'Write a custom message to display if something go bad while the login:
', 'woo-shortcodes-kit' ); ?> <br /><br /> <table><tr><td style="width: 50%;"><input class="testininputclass" type="text" name="wshk_hidelogerrorcustomessage" id="wshk_hidelogerrorcustomessage" value="<?php if(get_option('wshk_hidelogerrorcustomessage')!=''){ echo get_option('wshk_hidelogerrorcustomessage'); }?>" placeholder="<?php esc_html_e( "Write your custom message", "woo-shortcodes-kit" ); ?>" size="60" /></td></tr></table></p>
    <br />
    <br />
    </div>
   <!-- FIN HIDE LOGIN ERROR MESSAGE --> 
   
   
     <!--NO SEND USERS -->
<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_nosendusers" name="wshk_nosendusers" value='1850' <?php if(get_option('wshk_nosendusers')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_nosendusers></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Prevent send users on WP updates check', 'woo-shortcodes-kit' ); ?> <span style="background-color: #aadb4a; color: white;border:1px solid #aadb4a;border-radius:13px;padding:5px;text-transform: uppercase;font-size:10px;"><?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?></span></big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'This function adds security rules to avoid knowing the number of users on your website.', 'woo-shortcodes-kit' ); ?> <br /><?php esc_html_e( 'Since 2010, every time WordPress checks for updates, it sends the number of users of your website.', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'This can be used by attackers to find out the number of users a website has and see if it is of interest to establish them as the target to attack.', 'woo-shortcodes-kit' ); ?></p>
    
    <br />
    <p><?php esc_html_e( 'Activating this function we make sure to zero the blog and the number of users.', 'woo-shortcodes-kit' ); ?></p>
    <br />
    </div>
    
<!-- FIN NO SEND USERS -->


<!--SECURITY HEADERS -->
<div class="accordion">
  <table>
  <colgroup>
    <col span="2">
   
  </colgroup>
  <tr>
    <th><p><input type="checkbox" class="testininputclass" id="wshk_enablesecheaders" name="wshk_enablesecheaders" value='95' <?php if(get_option('wshk_enablesecheaders')!=''){ echo ' checked="checked"'; }?>/><label class="testintheclass" for=wshk_enablesecheaders></label><br /></th><th style="padding: 20px 20px 0px 20px;"> <big><?php esc_html_e( 'Add security headers in your website', 'woo-shortcodes-kit' ); ?> </big><br /><small> <?php esc_html_e( 'Just need activate the function and nothing more!', 'woo-shortcodes-kit' ); ?></small></p></th></tr>
    </table>
</div>
<div class="panel"><br /><br />
    <p><?php esc_html_e( 'This function adds security rules to your website and helps you prevent different types of attacks.', 'woo-shortcodes-kit' ); ?> <br /><br /></p>
    <?php
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablesecheaders']) && $pluginOptionsVal['wshk_enablesecheaders']==95)
{
    ?>
    <div>
        <table width="600px">
            
            <tr><td width="70%" style="font-weight:bold;"><?php esc_html_e( 'HEADERS', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="font-weight:bold;"><?php esc_html_e( 'STATUS', 'woo-shortcodes-kit' ); ?></td></tr><br><br>
            
            <tr><td width="70%"><?php esc_html_e( 'Enforce the use of HTTPS', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent Clickjacking', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent XSS Attack', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Block Access If XSS Attack Is Suspected', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent MIME-Type Sniffing', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Referrer Policy', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Feature Policy', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:green;"><?php esc_html_e( 'ENABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-yes"></span></td></tr>
        
        </table>
        <br><br>
        <?php 
        $siteurlwshk = get_site_url();
        $testurlwshk = 'https://securityheaders.com/?q='.$siteurlwshk.'&hide=on&followRedirects=on';
        ?>
        <div><h3 style="font-weight:bold;letter-spacing:1px;"><span style="border-radius: 12px;font-family: Arial,Helvetica,sans-serif;text-align: center;margin: auto;width: 65px;height: 65px;font-size: 90px;line-height: 65px;color: #fff;font-weight: 700;background-color: #34af00;border: 2px solid #309d00;font-size:16px;padding:5px;">A+</span> <?php esc_html_e( 'SECURITY HEADERS SCAN', 'woo-shortcodes-kit' ); ?> <a style="border:1px solid transparent; border-radius:13px;padding:10px;background-color:#a46497;color:white;font-size:14px;" href="<?php echo $testurlwshk; ?>" target="_blank"><?php esc_html_e( 'CHECK YOUR SITE NOW', 'woo-shortcodes-kit' ); ?></a></h3><p><?php esc_html_e( 'If your test result follow in red, please close the test and wait 30-60 seconds before to check your site again', 'woo-shortcodes-kit' ); ?>.</p></div>
        
    </div>
    <?php } else {?>
    <div>
        <table width="600px">
            
            <tr><td width="70%" style="font-weight:bold;">HEADERS</td><td width="30%" style="font-weight:bold;">STATUS</td></tr><br><br>
            
            <tr><td width="70%"><?php esc_html_e( 'Enforce the use of HTTPS', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent Clickjacking', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent XSS Attack', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Block Access If XSS Attack Is Suspected', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Prevent MIME-Type Sniffing', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Referrer Policy', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
            
            <tr><td width="70%"><?php esc_html_e( 'Feature Policy', 'woo-shortcodes-kit' ); ?></td><td width="30%" style="color:red;"><?php esc_html_e( 'DISABLED', 'woo-shortcodes-kit' ); ?> <span class="dashicons dashicons-no-alt"></span></td></tr>
        
        </table>
        <br><br>
    <?php 
        $siteurlwshk = get_site_url();
        $testurlwshk = 'https://securityheaders.com/?q='.$siteurlwshk.'&hide=on&followRedirects=on';
        ?>
    <div><h3 style="font-weight:bold;letter-spacing:1px;"><span style="border-radius: 12px;font-family: Arial,Helvetica,sans-serif;text-align: center;margin: auto;width: 85px;height: 65px;font-size: 90px;line-height: 65px;color: #fff;font-weight: 700;background-color: red;border: 2px solid darkred;font-size:16px;padding:5px;">F</span> <?php esc_html_e( 'SECURITY HEADERS SCAN', 'woo-shortcodes-kit' ); ?> <a style="border:1px solid transparent; border-radius:13px;padding:10px;background-color:#a46497;color:white;font-size:14px;" href="<?php echo $testurlwshk; ?>" target="_blank"><?php esc_html_e( 'CHECK YOUR SITE NOW', 'woo-shortcodes-kit' ); ?></a></h3></div>
    <?php } ?>
    <br />
    <br />
    </div>
<!-- FIN SECURITY HEADERS -->
    
    </div>
    
    
    
    
      
      
    
    </li>
   <!-- FIN SECURITY SECTION --> 
    
    
    
    
    <!-- BETA TESTERS -->
    <!--<li>
      
      <div class="acc_ctrl" style="background-color: #fbfbfb; padding: 10px;"><h3 style="padding-left:20px;color:#a46497;letter-spacing: 1px; font-size: 20px;margin-top: 25px;"><span class="dashicons dashicons-heart"></span> <?php esc_html_e( 'BETA TESTERS', 'woo-shortcodes-kit' ); ?> </h3></div>
      <div class="acc_panel">
          <br /><br />
          <div style="background-color:#f4f1ff;font-size:18px;padding:40px 20px 40px 20px;border:0px solid #a46497;border-radius:3px;color: #a46497;"><span class="dashicons dashicons-info"></span> <span><?php esc_html_e( 'Meet the new functions and if you like them, vote for free to keep them in the plugin!', 'woo-shortcodes-kit' ); ?></span> <a href="http://bit.ly/Betatesters" target="_blank" style="text-align: center; width: 100px; border: 1px solid #a46497; border-radius: 13px; background-color: #a46497; font-size: 18px; font-weight: bolder; color: white; padding: 15px;display:block;float:right;margin-top:-16px;"><span  style="color:white;"><?php esc_html_e( 'VOTE NOW', 'woo-shortcodes-kit' ); ?></span></a></div>
          <br><br>
          
         
    
      </div>
    </li>-->
    <!--END BETA TESTERS SECTION -->
    
    <li>
    
    
    
    
    
    
    
    
    
    <?php
    // Since 1.6.6
    //CHECK IF EASY MY ACCOUNT BUILDER EXISTS
    
    if ( in_array( 'easy-myaccount-builder/easy-myaccount-builder-for-wshk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
       include( ABSPATH . '/wp-content/plugins/easy-myaccount-builder/emab-settings.php' );


        }
        
    //Since 1.6.7
    //CHECK IF CUSTOM REDIRECTIONS EXISTS
    
    if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
       include( ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/cusre-settings.php' );


        }
    
    
    ?>
    
    
    
    
    <!--<li>
      <button class="acc_ctrl"><h2>Toyota</h2></button>
      <div class="acc_panel">
        <p>Toyota Motor Corporation is a Japanese automotive manufacturer which was founded by Kiichiro Toyoda in 1937 as a spinoff from his father's company Toyota Industries, which is currently headquartered in Toyota, Aichi Prefecture, Japan.</p>
      </div>
    </li>-->
    
    
  </ul>
</div>

<!--TOGGLE PRINCIPAL-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>$(function() {
  $('.acc_ctrl').on('click', function(e) {
    e.preventDefault();
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).next()
      .stop()
      .slideUp(300);
    } else {
      $(this).addClass('active');
      $(this).next()
      .stop()
      .slideDown(300);
    }
  });
});</script>
    
<!--FIN DE LA CAJA BLANCA-->
    </div>
    
    
    
   
    <br />
    <br />
    <br />
    <br />
        
        <center><button class="probando" type="submit" id="toggle" onclick="click()"><?php esc_html_e( 'SAVE SETTINGS', 'woo-shortcodes-kit' ); ?></button></center>
    <?php settings_fields('wshk_options');?>
    
    
    </form>

<!-- End Options Form -->

   
   </div>
   
   <!-- recomends - from v.1.8.7 -->
  
   
   <div class="last author wshk-tab" id="div-wshk-recom">
       <div style="width: 100%;">
     <div style="background-color: white; width: 100%;border-radius:13px;padding:20px;">
       
        <!-- contenido caja info ajustes -->
       <div style="display:block;background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
            
            <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Get to know the plugins recommended by WSHK', 'woo-shortcodes-kit' ); ?></span></h2>
            
            <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'From here you can directly access each recommendation with just one click.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Here you will find WSHK plugins and third party plugins!', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(All plugins have been tried before.)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
            </div> 
            
            <style>
            .row {display: flex;}
            .column {flex: 50%;padding:30px;border:1px solid #eee;border-radius:13px;margin:15px;}
            </style>
            <br><br>
            <!-- NEW ROW -->
            <div class="row">
                <div class="column">
                    
                    <table>
                                <tr>
                                    <td style="padding-right:30px;">
                                        <img src="<?php echo  plugins_url( 'images/cbar-logo-custom-blocks-and-redirections-150x150.png' , __FILE__ );?>" style="width: 64px; height: 64px;" ;>
                                    </td>
                                    <td>
                                       <a href="https://disespubli.com/producto/custom-blocks-and-redirections-addon-for-wshk/" target="_blank"><span style="font-size:18px; color:#a46497;letter-spacing:1px;">Woo Shortcodes Kit PRO</span></a><br><small>Author: <a href="https://profiles.wordpress.org/disespubli/" target="_blank">Alberto G - Disespubli</a></small> 
                                    </td>
                                </tr>
                            </table>
                            
                            <p><?php esc_html_e( 'Start from scratch your custom account page with your favorite builder without limits and get extra functions to your shop. High compatibility with third party plugin as Elementor, Visual composer, DIVI and Woo Subscriptions.', 'woo-shortcodes-kit' ); ?></p>
                            <br>
                            <a href="https://bit.ly/wshkpro" target="_blank" style="float:right;background-color:#a46497;padding:10px;border-radius:3px;color:white;font-size:14px;"><?php esc_html_e( 'EXPLORE NOW', 'woo-shortcodes-kit' ); ?></a>
                </div>
                            
                <div class="column">
                
                    <table>
                                <tr>
                                    <td style="padding-right:30px;">
                                        <img src="<?php echo  plugins_url( 'images/emab-logo-easy-my-account-builder-150x150.png' , __FILE__ );?>" style="width: 64px; height: 64px;" ;>
                                    </td>
                                    <td>
                                       <a href="https://disespubli.com/producto/easy-my-account-builder-addon-for-wshk/" target="_blank"><span style="font-size:18px; color:#a46497;letter-spacing:1px;">Easy My Account Builder</span></a><br><small>Author: <a href="https://profiles.wordpress.org/disespubli/" target="_blank">Alberto G - Disespubli</a></small> 
                                    </td>
                                </tr>
                            </table>
                            
                            <p><?php esc_html_e( 'With Easy My Account builder, just need write a shortcode in your new and custom account page.It will build a full login and private user zone like WooCommerce by default,with the difference that you can manage the tabs, the containers and the content.', 'woo-shortcodes-kit' ); ?></p>
                            <br>
                            <a href="https://bit.ly/emabrecom" target="_blank" style="float:right;background-color:#a46497;padding:10px;border-radius:3px;color:white;font-size:14px;"><?php esc_html_e( 'EXPLORE NOW', 'woo-shortcodes-kit' ); ?></a>
                </div>
            </div>
            <!-- END ROW -->
            
            <!-- NEW ROW -->    
            <div class="row">
                <div class="column">
                    
                    <table>
                                <tr>
                                    <td style="padding-right:30px;">
                                        <img src="<?php echo  plugins_url( 'images/elite-licenser-icon.png' , __FILE__ );?>" style="width: 64px; height: 64px;" ;>
                                    </td>
                                    <td>
                                       <a href="https://wordpress.org/plugins/elite-licenser-lite/" target="_blank"><span style="font-size:18px; color:#a46497;letter-spacing:1px;">Elite Licenser</span></a><br><small>Author: <a href="https://appsbd.com/" target="_blank">S M Sarwar Hasan - APPSBD</a></small> 
                                    </td>
                                </tr>
                            </table>
                            
                            <p><?php esc_html_e( 'Elite Licenser is a WordPress license manager plugin for any type of product licensing. It helps to manage product updates, license code auto generation, built in Envato licensing verification system, full license control and a licensing system can be added into your WordPress plugins or themes without any prior programming knowledge.', 'woo-shortcodes-kit' ); ?></p>
                            <br>
                            <a href="https://bit.ly/elitelicenser" target="_blank" style="float:right;background-color:#a46497;padding:10px;border-radius:3px;color:white;font-size:14px;"><?php esc_html_e( 'EXPLORE NOW', 'woo-shortcodes-kit' ); ?></a>
                </div>
                            
                <div class="column">
                
                    <table>
                                <tr>
                                    <td style="padding-right:30px;">
                                        <img src="<?php echo  plugins_url( 'images/mini-cart-drawer.png' , __FILE__ );?>" style="width: 64px; height: 64px;" ;>
                                    </td>
                                    <td>
                                       <a href="https://wordpress.org/plugins/woo-mini-cart-drawer/" target="_blank"><span style="font-size:18px; color:#a46497;letter-spacing:1px;">Mini Cart Drawer For WooCommerce</span></a><br><small>Author: <a href="https://appsbd.com/" target="_blank">S M Sarwar Hasan - APPSBD</a></small> 
                                    </td>
                                </tr>
                            </table>
                            
                            <p><?php esc_html_e( 'Woo Mini Cart Drawer is an interaction mini cart with many styles, color and effects for WooCommerce. You can change quantity of a product and also can remove from cart. It has nice control panel aslo has customizer panel. By this you can change the its configuration with live preview. It is fully ajax based mini cart.', 'woo-shortcodes-kit' ); ?></p>
                            <br>
                            <a href="https://bit.ly/minicartdrawer" target="_blank" style="float:right;background-color:#a46497;padding:10px;border-radius:3px;color:white;font-size:14px;"><?php esc_html_e( 'EXPLORE NOW', 'woo-shortcodes-kit' ); ?></a>
                </div>
            </div>
            <!-- END ROW -->

            
        </div>
        </div>
   </div>
   
   
   <!-- News - from v.1.8.0 -->
   
   <div class="author wshk-tab" id="div-wshk-news">
        <!-- fondo contenedor -->
        <div style="width: 100%;">
     <div style="background-color: white; width: 100%;border-radius:13px;padding:20px;">
       
        <!-- contenido caja info ajustes -->
       <div style="display:block;background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
            
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'You have a new message!', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'This is your inbox where you will find notifications about important changes in WSHK.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Here you will find info about news, updates, changes and more!.', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(The content will be updated each version)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    
       
       
       <!--<iframe style="display:block;margin:auto;border:1px solid transparent;border-radius:3px;" width="100%" height="415" src="https://www.youtube.com/embed/Ta1COGg4qg8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
       
       <br><br>
       
       
       <br><br>
       <style>
           div.boxwshknotify {
               margin: 0px 80px;
               padding: 30px 30px !important;
               background: linear-gradient(45deg, #74689b, #74689bba) !important;
           }
       </style>
       
       <div class="boxwshknotify" style="background-color: #a46497; padding: 10px 20px 10px 20px;border: 1px solid white; border-radius: 6px;color:white;height:auto;opacity: 1;">
        <h2 style="margin-bottom:20px;"><span style="color:white; font-size: 22px;"><span class="dashicons dashicons-admin-post"></span> <?php esc_html_e( 'WSHK CUSTOM TEMPLATES FOR ELEMENTOR IS FINALLY AVAILABLE! ARE YOU READY?', 'woo-shortcodes-kit' ); ?></span></h2>
        
        <h4><small><span style="color: white; font-size: 15px;"><?php esc_html_e( 'The version 1.1.0 comes with a very featured function to build all your WooCommerce custom pages with just a click, if you are Elementor user, you will love it!', 'woo-shortcodes-kit' ); ?></span></small></h4>
        <br>
        <a href="https://wshktemplates.ceonixt.com/" style="margin-bottom:20px;padding:10px;border:1px solid white;border-radius:13px;text-decoration:none;text-transform:uppercase;color:white;" target="_blank"><?php esc_html_e( 'Read More', 'woo-shortcodes-kit' ); ?></a>
        <br><br>
        </div>
        
        <br><br>
       
       <div class="boxwshknotify" style="background-color: #a46497; padding: 10px 20px 10px 20px;border: 1px solid white; border-radius: 6px;color:white;height:auto;opacity: 1;">
        <h2 style="margin-bottom:20px;"><span style="color:white; font-size: 22px;"><span class="dashicons dashicons-admin-post"></span> <?php esc_html_e( 'ENHANCED THE CUSTOMERS AVATAR UPLOADER!', 'woo-shortcodes-kit' ); ?></span></h2>
        
        <h4><small><span style="color: white; font-size: 15px;"><?php esc_html_e( 'This function has been updated to work better with all the themes, display correctly the custom avatar on all sites, limit file size and much more!', 'woo-shortcodes-kit' ); ?></span></small></h4>
        <br>
        <a href="https://disespubli.com/docs/customer-avatar-uploader-on-edit-account/" style="margin-bottom:20px;padding:10px;border:1px solid white;border-radius:13px;text-decoration:none;text-transform:uppercase;color:white;" target="_blank"><?php esc_html_e( 'Read More', 'woo-shortcodes-kit' ); ?></a>
        <br><br>
        </div>
        
        <br><br>
       
       <div class="boxwshknotify" style="background-color: #a46497; padding: 10px 20px 10px 20px;border: 1px solid white; border-radius: 6px;color:white;height:auto;opacity: 1;">
        <h2 style="margin-bottom:20px;"><span style="color:white; font-size: 22px;"><span class="dashicons dashicons-admin-post"></span> <?php esc_html_e( 'NOW WSHK PRO WORKS BETTER WITH DIVI TABS', 'woo-shortcodes-kit' ); ?></span></h2>
        
        <h4><small><span style="color: white; font-size: 15px;"><?php esc_html_e( 'The version 1.1.0 comes with a new function for DIVI, now you can use this function to build your custom buttons for the DIVI tabs module easily!', 'woo-shortcodes-kit' ); ?></span></small></h4>
        <br>
        <a href="https://disespubli.com/docs/wshk-pro-v-1-1-0/" style="margin-bottom:20px;padding:10px;border:1px solid white;border-radius:13px;text-decoration:none;text-transform:uppercase;color:white;" target="_blank"><?php esc_html_e( 'Read More', 'woo-shortcodes-kit' ); ?></a>
        <br><br>
        </div>
        
        <br><br>
       
       <div class="boxwshknotify" style="background-color: #a46497; padding: 10px 20px 10px 20px;border: 1px solid white; border-radius: 6px;color:white;height:auto;opacity: 1;">
        <h2 style="margin-bottom:20px;"><span style="color:white; font-size: 22px;"><span class="dashicons dashicons-admin-post"></span> <?php esc_html_e( 'WHAT INCLUDE WOO SHORTCODES KIT VERSION 1.8.9?', 'woo-shortcodes-kit' ); ?></span></h2>
        
        <h4><small><span style="color: white; font-size: 15px;"><?php esc_html_e( 'Version 1.8.9 comes with new features for the function Product Downloads/Sales counter, new updates to work with the new version of the addon WSHK PRO.', 'woo-shortcodes-kit' ); ?></span></small></h4>
        <br>
        <a href="https://disespubli.com/docs/wshk-v-1-8-9/" style="margin-bottom:20px;padding:10px;border:1px solid white;border-radius:13px;text-decoration:none;text-transform:uppercase;color:white;" target="_blank"><?php esc_html_e( 'Read More', 'woo-shortcodes-kit' ); ?></a>
        <br><br>
        </div>
        
        <br><br>
       
       <div class="boxwshknotify" style="background-color: #a46497; padding: 10px 20px 10px 20px;border: 1px solid white; border-radius: 6px;color:white;height:auto;opacity: 0.5;">
        <h2 style="margin-bottom:20px;"><span style="color:white; font-size: 22px;"><span class="dashicons dashicons-admin-post"></span> <?php esc_html_e( 'ENHACED COMPATIBILITY WITH ELEMENTOR AND NEW ELEMENTOR TEMPLATES!', 'woo-shortcodes-kit' ); ?></span></h2>
        
        <h4><small><span style="color: white; font-size: 15px;"><?php esc_html_e( 'Version 1.0.9 comes with a new name for the plugin, a lot of new features, new integrations with Elementor, templates, widget. If you are an Elementor user you will love this version! ', 'woo-shortcodes-kit' ); ?></span></small></h4>
        <br>
        <a href="https://disespubli.com/docs/wshk-pro-v-1-0-9/" style="margin-bottom:20px;padding:10px;border:1px solid white;border-radius:13px;text-decoration:none;text-transform:uppercase;color:white;" target="_blank"><?php esc_html_e( 'Read More', 'woo-shortcodes-kit' ); ?></a>
        <br><br>
        </div>
        
        
        <div style="border-bottom:10px double #f7f7f7;margin:5px 60px;"></div>
        
     
       
       
       
       
       
       <br><br>
       
       
       
       
       
       </div>
   </div>
   
    
  
   
   
   
   
   
   
    <!-- Support -->
    <div class="author wshk-tab" id="div-wshk-support">
    &nbsp;
   
    
     <!-- caja info ajustes -->
        
         <div style="background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Shortcodes Panel', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Hover the elements to see the shortcodes.', 'woo-shortcodes-kit' ); ?></span></small><br /><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Copy the shortcode and paste where you want.', 'woo-shortcodes-kit' ); ?></span></small><small><span style="color: #ccc; font-size: 13px;font-style: italic;"> <?php esc_html_e( '(Some shortcodes need enable his function to work)', 'woo-shortcodes-kit' ); ?></span></small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    
     <!--NUEVO PANEL -->
 
    &nbsp;
    <style>
    .featured .featured-columns .item {
  height: 230px;
  background-size: cover;
  position: relative;
  cursor: pointer;
  margin: 10px;
  width: 30%;
  float:left;
  border: 1px solid #a46497;
  border-radius: 13px;
}
.featured .featured-columns .item .widget-title {
  text-align: center;
  color: white;
  position: relative;
  top: 50px;
  font-weight: 700;
}
.featured .featured-columns .item .textwidget {
  background-color: white;
  position: absolute;
  top: 0;
  width: 100%;
  height: 170px;
  padding: 30px 0px;
  opacity: 0;
  -webkit-transition: opacity 0.3s ease-in-out;
  -moz-transition: opacity 0.3s ease-in-out;
  -ms-transition: opacity 0.3s ease-in-out;
  -o-transition: opacity 0.3s ease-in-out;
  transition: opacity 0.3s ease-in-out;
  box-shadow: 1px 1px 12px #ccc;
  border: 1px solid white;
  border-radius: 13px;
}
.featured .featured-columns .item:hover .textwidget,
.featured .featured-columns .item:focus .textwidget {
  opacity: 1;
}


	.featured .featured-columns .item[data-badge]:after {
		content:attr(data-badge);
		position:absolute;
		top:-10px;
		right:-10px;
		font-size:.7em;
		background:#aadb4a;
		color:white;
		width:40px;height:18px;
		text-align:center;
		line-height:18px;
		border-radius:13px;
		box-shadow:0 0 1px #333;
		letter-spacing: 1px;
		padding: 5px;
	}
	



    </style>
    
    
    <div class='featured'>
        
       <style>
           
           .wshkrow {
    /*margin: 10px -16px;*/
}

/* Add padding BETWEEN each column */
.wshkrow,
.wshkrow > .wshkcolumn {
    /*padding: 8px;*/
}

/* Create three equal columns that floats next to each other */
.wshkcolumn {
    /*float: left;
    width: 33.33%;*/
    display: none; /* Hide all elements by default */
}

/* Clear floats after rows */ 
.wshkrow:after {
    content: "";
    display: table;
    clear: both;
}

/* Content */
.wshkcontent {
    /*background-color: white;
    padding: 10px;*/
}

/* The "show" class is added to the filtered elements */
.wshkshow {
  display: block;
}

/* Style the buttons */
.wshkbtn {
  border: 1px solid #c6adc2;
  border-radius: 13px;
  outline: none;
  padding: 12px 16px;
  background-color: #c6adc2;
  color: white;
  cursor: pointer;
  margin-right: 10px;
  text-transform: uppercase;
}

.wshkbtn:hover {
  background-color: #a46497;
  color: white;
}

.wshkbtn.wshkactive {
  background-color: #a46497;
  color: white;
  border:1px solid #a46497;
  border-radius: 13px;
}
           
       </style>
<div id="myBtnContainer">
  <!--<button class="wshkbtn wshkactive" onclick="filterSelection('all')"> Show all</button>
  <button class="wshkbtn" onclick="filterSelection('myaccount')"> Build myaccount</button>
  <button class="wshkbtn" onclick="filterSelection('counters')"> counters</button>
  <button class="wshkbtn" onclick="filterSelection('addons')"> addons</button>-->
  <br />
  
  <a href="#" class="wshkbtn wshkactive" onclick="filterSelection('all')"><?php esc_html_e( 'Show all', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" onclick="filterSelection('myaccount')"><?php esc_html_e( 'Build my account', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" onclick="filterSelection('counters')"><?php esc_html_e( 'Counters', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" style="margin-left: 4px;" onclick="filterSelection('addons')"><?php esc_html_e( 'Addons', 'woo-shortcodes-kit' ); ?></a>
  <a href="#" class="wshkbtn" style="margin-left: 4px;" onclick="filterSelection('mustbe')"><?php esc_html_e( 'Required function Activation', 'woo-shortcodes-kit' ); ?></a>
  <br />
  
</div>
            
<div class="featured-columns panel-widget-style">
    <div id="pl-w57502fd8c7513">
        <div class="panel-grid" id="pg-w57502fd8c7513-0">
            
            <div class="wshkrow">
            <br />
            <br />
             <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/orderslist.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Orders list', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show user the purchase my-orders table, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myorders]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/globalsales.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Global sales', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the global sales/downloads counter use this shortcode:', 'woo-shortcodes-kit' ); ?> <br /><br /><small>[woo_global_sales]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
           
            <div class="wshkcolumn counters">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/totalproducts.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total Products counter', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total products on any page or post, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_product_count]</small><br /><p><small><span style="color: #666666"><?php esc_html_e( 'if you want exclude any category use:', 'woo-shortcodes-kit' ); ?></span><span style="color: #808080">[woo_total_product_count cat_id="<?php esc_html_e( 'here the category ID number', 'woo-shortcodes-kit' ); ?>"]</span></small></p></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
                    
              <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/olddownloadslist.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Downloads list', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show user the downloads table, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mydownloads]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/bought.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Bought products', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                 <h3><center><?php esc_html_e( 'If you want show user the products that have bought, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_bought_products]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/gravatarthumb.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Gravatar image', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the user Gravatar image, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_gravatar_image]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            <div class="wshkcolumn counters mustbe">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woototalproductsbyuser.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total products by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total bought products by user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_bought_products]</small></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters mustbe">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woototalordersbyuser.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total orders by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total orders made by user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_customer_total_orders]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn counters mustbe">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/rwcounter.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total reviews by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the total reviews made by a user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_count_reviews]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/cstmreviews.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Reviews by user', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the products reviews made by a user, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_review_products]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                    
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/display-the-reviews.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Display Reviews', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the products reviews made by all the users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_display_reviews]</small></center></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newusernm.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Username', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the username in any page or post, use this shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_user_name]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/woomessage.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Message by Orders', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show a message if the user made a number of orders, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_message]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                    
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/user-ip.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Display user IP', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the user ip where you want, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_display_ip]</small></center></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            
            
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                    
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/identity-card.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Display user name and surname', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the user name and surname, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_display_nsurname]</small></center></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            
            
            
            
            <div class="wshkcolumn addons">
                <div class="wshkcontent">
                                    
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                    
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/email.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Display user email', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want show the user email where you want, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_display_email]</small></center></h3>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newmyadd.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Addresses', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer billing & shipping address in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myaddress]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/mypaym.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Payments methods', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer payment methods saved in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mypayment]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/edit-account-form.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Edit account form', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the customer edit account form in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_myedit_account]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/newmydash.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Dashboard', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the my-account dashboard in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_mydashboard]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount mustbe">
                <div class="wshkcontent">
            
            <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/logout-nutton.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Logout button', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want display the Logout button in any post or page, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_logout_button]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn myaccount mustbe">
                <div class="wshkcontent">
            
                        <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/login-form.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Login form', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you are building your custom my account page and want display the Login form for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_login_form]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/hidecontent.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Restrict content', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you are building your custom my account page or want hide any content for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[wshk] [/wshk]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            
            
            <div class="wshkcolumn addons mustbe">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/hideye.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Hide content', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you want hide any content for logged in users and display only for non logged in users, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[off] [/off]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>
            <!--data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>"-->
            <!--START-->
            <!--<div class="wshkcolumn counters">
                <div class="wshkcontent">
            
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" data-badge="<?php esc_html_e( 'NEW', 'woo-shortcodes-kit' ); ?>" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/hideye.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Total Balance', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'If you display how much was spended by a client, use this Shortcode:', 'woo-shortcodes-kit' ); ?><br /><br /><small>[woo_total_balance]</small></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            </div>-->
            <!--END-->
             <div class="panel-grid-cell" id="pgc-w57502fd8c7513-0-1">
                <div class="so-panel widget widget_sow-editor panel-first-child panel-last-child" id="panel-w57502fd8c7513-0-1-0" data-index="1">
                    <div class="item panel-widget-style" style="background: #a46497">
                        <div class="so-widget-sow-editor so-widget-sow-editor-base">
                        <br />
                        <br />                        
                        <p><center><img src="<?php echo  plugins_url( 'images/comingsoon.png' , __FILE__ );?>"></center></p>
                            <h3 class="widget-title"><?php esc_html_e( 'Coming soon...', 'woo-shortcodes-kit' ); ?></h3>
                            <div class="siteorigin-widget-tinymce textwidget">
                                <h3><center><?php esc_html_e( 'New functions will be added in the nexts updates', 'woo-shortcodes-kit' ); ?></center></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- div del row -->
            </div>
            
            </div>


        </div>
    </div>
</div>

<script>
filterSelection("all")
function filterSelection(c) {
  var x, i;
  x = document.getElementsByClassName("wshkcolumn");
  if (c == "all") c = "";
  for (i = 0; i < x.length; i++) {
    w3RemoveClass(x[i], "wshkshow");
    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "wshkshow");
  }
}

function w3AddClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
  }
}

function w3RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);     
    }
  }
  element.className = arr1.join(" ");
}


// Add active class to the current button (highlight it)
var wbtnContainer = document.getElementById("myBtnContainer");
var wbtns = wbtnContainer.getElementsByClassName("wshkbtn");
for (var i = 0; i < wbtns.length; i++) {
  wbtns[i].addEventListener("click", function(){
    var wcurrent = document.getElementsByClassName("wshkactive");
    wcurrent[0].className = wcurrent[0].className.replace(" wshkactive", "");
    this.className += " wshkactive";
  });
}
</script>


 
 <!-- FIN NUEVO PANEL -->
   


   
    </div>
    
    
    </div>

    <!-- Contact -->
    
    

</div>
<div class="last wshk-tab" id="div-wshk-contact">
    
    <div style="width: 100%;">
   <div style="background-color: white; width: 100%; padding: 20px 20px 20px 20px;border: 1px solid white; border-radius: 13px;">
    
    
         <!-- caja info ajustes -->
        
         <div style="background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'Help & Support!', 'woo-shortcodes-kit' ); ?></span></h2>
    <h4><small><span style="color: #808080; font-size: 15px;padding-left: 30px;"><?php esc_html_e( 'Know more about Woo Shortcodes kit and how modding your WooCommerce shop!', 'woo-shortcodes-kit' ); ?></span></small><br /><small></h4>
   
    </div> 
    <!-- fin caja info ajustes-->
    <style>
    @import url(https://fonts.googleapis.com/css?family=Graduate|Oleo+Script);

mbody {
  margin-top: 5em;
  text-align: center;
  color: #414142;
  background: rgb(246,241,232);
  background: -moz-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%, rgba(212,204,186,1) 100%);
  background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(39%,rgba(246,241,232,1)), color-stop(100%,rgba(212,204,186,1)));
  background: -webkit-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: -o-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: -ms-radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  background: radial-gradient(center, ellipse cover,  rgba(246,241,232,1) 39%,rgba(212,204,186,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f6f1e8', endColorstr='#d4ccba',GradientType=1 );
}

a {
  color: #414142;
  font-style: normal;
  text-decoration: none;
  
}

a:hover {
  text-decoration: none;
}

.container {
  display: block;
  margin: 0 auto;
  width: 100%;
}
  
  #information {
    color: red;
    font-size: 14px;
  }
  
  .wrapper {
    display: inline-block;
    width: 310px;
    height: 100px;
    vertical-align: top;
    margin: 1em 1.5em 2em 0;
    cursor: pointer;
    position: relative;
    font-family: Tahoma, Arial;
    -webkit-perspective: 4000px;
       -moz-perspective: 4000px;
        -ms-perspective: 4000px;
         -o-perspective: 4000px;
            perspective: 4000px;
  }
  
  .mitem {
    height: 40px;
      -webkit-transform-style: preserve-3d;
         -moz-transform-style: preserve-3d;
          -ms-transform-style: preserve-3d;
           -o-transform-style: preserve-3d;
              transform-style: preserve-3d;
      -webkit-transition: -webkit-transform .6s;
         -moz-transition: -moz-transform .6s;
          -ms-transition: -ms-transform .6s;
           -o-transition: -o-transform .6s;
              transition: transform .6s;
  }
  
    .mitem:hover {
      -webkit-transform: translateZ(-50px) rotateX(95deg);
         -moz-transform: translateZ(-50px) rotateX(95deg);
          -ms-transform: translateZ(-50px) rotateX(95deg);
           -o-transform: translateZ(-50px) rotateX(95deg);
              transform: translateZ(-50px) rotateX(95deg);
    }
    
      .mitem:hover img {
        box-shadow: none;
        border-radius: 15px;
      }
      
      .mitem:hover .information {
        #box-shadow: 0px 3px 8px rgba(0,0,0,0.3);
        border-radius: 3px;
      }

    .mitem img {
      display: block;
      #position: absolute;
      top: 0;
      border-radius: 3px;
      
      -webkit-transform: translateZ(50px);
         -moz-transform: translateZ(50px);
          -ms-transform: translateZ(50px);
           -o-transform: translateZ(50px);
              transform: translateZ(50px);
      -webkit-transition: all .6s;
         -moz-transition: all .6s;
          -ms-transition: all .6s;
           -o-transition: all .6s;
              transition: all .6s;
      
    }
    
    
    
    .mitem .information {
      display: block;
      position: absolute;
      top: 0;
      height: 70px;
      width: 290px;
      text-align: left;
      border-radius: 15px;
      padding: 0px;          
      font-size: 12px;
      #text-shadow: 1px 1px 1px rgba(255,255,255,0.5);
      box-shadow: none;
      background: #a46497;
      
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ecf1f4', endColorstr='#becad9',GradientType=0 );
      -webkit-transform: rotateX(-90deg) translateZ(50px);
         -moz-transform: rotateX(-90deg) translateZ(50px);
          -ms-transform: rotateX(-90deg) translateZ(50px);
           -o-transform: rotateX(-90deg) translateZ(50px);
              transform: rotateX(-90deg) translateZ(50px);
      -webkit-transition: all .6s;
         -moz-transition: all .6s;
          -ms-transition: all .6s;
           -o-transition: all .6s;
              transition: all .6s;
      
    }
    
      .information strong {
        display: block;
        margin: .4em 0 .5em 0;
        font-size: 20px;
        color: #ffffff;
        background: #a46497;
        
        
      }
      

    </style>
     <div id="container" class="container" style="width: 100%;">
   <table>
   <tr>
   <td>
    <!--<h1 style="display: none;">CAN ADD A TITLE HERE</h1>-->
    
    
    
    <div class="wrapper">
        <a href="https://disespubli.com/wshk-features/#!/contact" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-email-alt" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'CONTACT', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Need help or have ideas to add?', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'SEND A MESSAGE!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
   
   <div class="wrapper">
        <a href="https://disespubli.com/docs-category/changelog/" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-admin-tools" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'CHANGELOG', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Want check the new changes?', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'CHECK NOW!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
    <div class="wrapper">
        <a href="http://bit.ly/wshkdocs" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-index-card" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'DOCUMENTATION', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Know all about how work WSHK!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'VIEW DOC!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
    
    <div class="wrapper">
        <a href="http://bit.ly/wshkhome" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-admin-home" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'THE WEB', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Want know more about WSHK?', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'VISIT NOW!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
    <div class="wrapper">
        <a href="https://www.facebook.com/disespubli/" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-facebook" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'THE FANPAGE', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Follow all the next news!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'FOLLOW THE NEWS!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
    <div class="wrapper">
        <a href="https://wordpress.org/support/plugin/woo-shortcodes-kit/reviews/#new-post" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-star-half" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'RATE IT!', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Help to follow growing!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'ADD YOUR REVIEW!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    
    <div class="wrapper">
        <a href="https://www.instagram.com/disespubli/" target="_blank">
      <div class="mitem">
        <p style="font-size: 26px; color: #a46497;"><span  class="dashicons dashicons-instagram" style="font-size: 48px; color: #a46497; padding-right: 50px;" ></span><?php esc_html_e( 'INSTANEWS', 'woo-shortcodes-kit' ); ?> <br /><span style="font-size: 14px;"><strong><?php esc_html_e( 'Follow WSHK on Instagram!', 'woo-shortcodes-kit' ); ?></strong></span></p>
        <span class="information">
          <center><p style="margin-top:20px;"><strong><?php esc_html_e( 'FOLLOW NOW!', 'woo-shortcodes-kit' ); ?></strong></p></center>
        </span>
      </div>
      </a>
    </div>
    </td>
    <td style="width: 25%">
    <br />
    <br />
    <br />
    <div style="border:1px solid #a46497;border-radius:3px;padding:20px;">
    <center><h3 style="color: grey;"><big><?php esc_html_e( 'STAY UPDATED!', 'woo-shortcodes-kit' ); ?></big><br><small><?php esc_html_e( 'NEW TUTORIALS COMMING SOON!', 'woo-shortcodes-kit' ); ?></small></h3></center>
    <br><center>
    <a href="http://bit.ly/wshknews" style="margin-bottom:30px;text-align:center;border-radius:13px;padding:10px;background-color:#a46497;color:white;font-size:14px;text-transfrom:uppercase;text-decoration:none;" target="_blank"><?php esc_html_e( 'SUBSCRIBE NOW', 'woo-shortcodes-kit' ); ?></a></center>
    <br>
    </div>
    <a  href="http://bit.ly/WCModding" target="_blank" style="text-align: center;">
    <div style="margin-top:20px;background: #a46497; border: 1px solid #a46497; border-radius: 3px; height: auto; padding: 15px;">
<center><img src="<?php echo  plugins_url( 'images/play-button.png', __FILE__ );?>" width="64" height="64" /></center>
<center><span style="color: white; font-size: 16px; "><strong><?php esc_html_e( 'Modding WooCommerce', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'with WSHK', 'woo-shortcodes-kit' ); ?></strong></span></center>
</div></a>
    <br />
    <a  href="https://www.youtube.com/playlist?list=PLAI7D4M9MLQCjV0ep5CxLFtwKvd6EgWNu" target="_blank" style="text-align: center;">
    <div style="background: #74689b; border: 1px solid #a46497; border-radius: 3px; height: auto; padding: 15px;">
<center><img src="<?php echo  plugins_url( 'images/play-button.png', __FILE__ );?>" width="64" height="64" /></center>
<center><span style="color: white; font-size: 16px; "><strong><?php esc_html_e( 'Learn how work', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'the WSHK templates!', 'woo-shortcodes-kit' ); ?></strong></span></center>
</div></a>

<br />
<a  href="https://www.youtube.com/playlist?list=PLAI7D4M9MLQCNYSJGX65bvm2Rgzkx--6S" target="_blank" style="text-align: center;">
    <div style="background: #74689b; border: 1px solid #a46497; border-radius: 3px; height: auto; padding: 15px;">
<center><img src="<?php echo  plugins_url( 'images/play-button.png', __FILE__ );?>" width="64" height="64" /></center>
<center><span style="color: white; font-size: 16px; "><strong><?php esc_html_e( 'Enhance your shop', 'woo-shortcodes-kit' ); ?><br /><?php esc_html_e( 'with WSHK PRO!', 'woo-shortcodes-kit' ); ?></strong></span></center>
</div></a>
    
    <br />          
    

    </td>
    </tr>
    </table>
    <br />
   
    
   </div> 
   
  </div>      
    
</div>
</div>




<div class="wshk-tab" id="div-wshk-languages">
    <div style="width: 100%;">
     <div style="background-color: white; width: 100%; padding: 20px 20px 20px 20px;border: 1px solid white; border-radius: 13px;">
     <!-- caja info ajustes -->
        
         <div style="background-color: white; padding-left: 10px;padding: 20px; color: #a46497;border: 1px solid #a46497; border-radius: 13px;">
             
             <!-- contenido caja info ajustes -->
             
    <h2><span style="color:#a46497; font-size: 26px;"><span class="dashicons dashicons-info"></span> <?php esc_html_e( 'TRANSLATE THE PLUGIN! ', 'woo-shortcodes-kit' ); ?></span></h2>
    <div style="color: #808080; font-size: 15px;padding-left: 30px;"><h4><small><span style="color: #808080; font-size: 15px;"><?php esc_html_e( 'Now you can easily copy or update the ready language files, with just one click.', 'woo-shortcodes-kit' ); ?></span><br><span style="color: #cccccc; font-size: 15px;"><?php esc_html_e( 'If in a new version the plugin does not translate all the strings correctly, you only need to click on the update button and the files will be copied automatically.', 'woo-shortcodes-kit' ); ?></span></small></h4></div>
   
    </div> 
    <br /><br />
    <!-- fin caja info ajustes-->
    
    <?php 
    
    //WSHK FILES FINDER
    
    $poplugin_dir = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/woo-shortcodes-kit-es_ES.po';
    
    $moplugin_dir = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/woo-shortcodes-kit-es_ES.mo';
    
  	
  	$pathmo = WP_CONTENT_DIR . '/languages/plugins/woo-shortcodes-kit-es_ES.mo';
  	$pathpo = WP_CONTENT_DIR . '/languages/plugins/woo-shortcodes-kit-es_ES.po';
    
    
    $pathmosin = WP_CONTENT_DIR . '/languages/plugins/';
    $pathposin = WP_CONTENT_DIR . '/languages/plugins/';
    
    /*Brazil*/
    
    $brazpoplugin_dir = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/woo-shortcodes-kit-pt_BR.po';
    
    $brazmoplugin_dir = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/woo-shortcodes-kit-pt_BR.mo';
    
    $brapathmo = WP_CONTENT_DIR . '/languages/plugins/woo-shortcodes-kit-pt_BR.mo';
  	$brapathpo = WP_CONTENT_DIR . '/languages/plugins/woo-shortcodes-kit-pt_BR.po';
    
    
    
     //CHECK IF CUSTOM REDIRECTIONS EXISTS
    
    if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        
        $adddestino = WP_CONTENT_DIR . '/plugins/custom-redirections-for-wshk/languages/wshk-custom-redirections-es_ES.po';
        
        $addmodestino = WP_CONTENT_DIR . '/plugins/custom-redirections-for-wshk/languages/wshk-custom-redirections-es_ES.mo';
        
    
    $sysadddestino = WP_CONTENT_DIR . '/languages/plugins/wshk-custom-redirections-es_ES.po';
    
    $sysaddmodestino = WP_CONTENT_DIR . '/languages/plugins/wshk-custom-redirections-es_ES.mo';
    }
    
    
    
     
     
    
    
    add_action('copy_wshk_files_es','wshk_custom_shortcode');
function wshk_custom_shortcode( $atts, $content= NULL) {   
    
/*$ruta= plugin_dir_path( __FILE__ ) . '/languages/';*/
$ruta = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/';
$destino= WP_CONTENT_DIR . '/languages/plugins/';
$archivos= glob($ruta.'woo-shortcodes-kit-es_ES.*o');


foreach ($archivos as $archivo){
$archivo_copiar= str_replace($ruta, $destino, $archivo);
copy($archivo, $archivo_copiar);
}

}


add_action('copy_wshk_files_br','wshk_custom_shortcodebr');
function wshk_custom_shortcodebr( $atts, $content= NULL) {   
    
/*$ruta= plugin_dir_path( __FILE__ ) . '/languages/';*/
$rutabra = WP_CONTENT_DIR . '/plugins/woo-shortcodes-kit/languages/';
$destinobra = WP_CONTENT_DIR . '/languages/plugins/';
$archivosbra = glob($rutabra.'woo-shortcodes-kit-pt_BR.*o');


foreach ($archivosbra as $archivobra){
$archivo_copiarbra= str_replace($rutabra, $destinobra, $archivobra);
copy($archivobra, $archivo_copiarbra);
}

}


 if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
    add_action('copy_cbar_files_es','wshk_custom_shortcodeadd');
function wshk_custom_shortcodeadd( $atts, $content= NULL) {   
    
$rutacbar= WP_CONTENT_DIR . '/plugins/custom-redirections-for-wshk/languages/';
$destinoadd= WP_CONTENT_DIR . '/languages/plugins/';
$archivosadd= glob($rutacbar.'wshk-custom-redirections-es_ES.*o');

 
  
foreach ($archivosadd as $archivoadd){
$archivo_copiarr= str_replace($rutacbar, $destinoadd, $archivoadd);
copy($archivoadd, $archivo_copiarr);
}

        
 }

}


//Copy files if button is clicked
  
  if(isset($_POST['wshkesfiles'])) { do_action('copy_wshk_files_es'); }
  if(isset($_POST['wshkbrafiles'])) { do_action('copy_wshk_files_br'); }
  if(isset($_POST['cbaresfiles'])) { do_action('copy_cbar_files_es'); }
  
  
//Change the action button text

  if(file_exists($pathpo)) {
    
    $wstitle = __( 'UPDATE', 'woo-shortcodes-kit' );
    
    } else {
    $wstitle = __( 'COPY', 'woo-shortcodes-kit' );
    }
    
     if(file_exists($brapathpo)) {
    
    $wstitlebr = __( 'UPDATE', 'woo-shortcodes-kit' );
    
    } else {
    $wstitlebr = __( 'COPY', 'woo-shortcodes-kit' );
    }
    
     if(file_exists($sysadddestino)) {
    
    $wstitlee = __( 'UPDATE', 'woo-shortcodes-kit' );
    
    } else {
    $wstitlee = __( 'COPY', 'woo-shortcodes-kit' );
    }
    ?>
    
    
    <h3 style="background-color:#a46497;color:white;padding:15px;border:1px solid #a46497;border-radius:13px;margin-bottom:-15px;"><?php esc_html_e( 'Plugin files', 'woo-shortcodes-kit' ); ?></h3>
    <table width="100%" bgcolor="#fbfbfb" style="color:#000000;border: 1px solid #fbfbfb;border-radius:13px;" cellpading="10" align="center">
         <thead>
    <tr>
      <th width="10%" style="padding:10px;"><?php esc_html_e( 'LANGUAGE', 'woo-shortcodes-kit' ); ?></th>
      
      <th width="80%" style="padding:10px;"><?php esc_html_e( 'ROOT', 'woo-shortcodes-kit' ); ?></th>
      <th width="10%" style="padding:10px;"><?php esc_html_e( 'AVAILABLE', 'woo-shortcodes-kit' ); ?></th>
      <th width="10%" style="padding:10px;"><?php esc_html_e( 'ACTION', 'woo-shortcodes-kit' ); ?></th>
    </tr>
  </thead>
  <br>
  <tbody>
        <tr style="text-align:center;padding-bottom:20px;">
        <td rowspan="2"><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

        
        <td style="font-size:12px;"><?php if(file_exists($poplugin_dir)) {echo $poplugin_dir; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($poplugin_dir)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        <td rowspan="2"><?php if(file_exists($poplugin_dir)) {echo '<form method="post"><button style="cursor:pointer;padding:10px 15px 10px 15px;background-color:#a46497;border:1px solid #a46497;border-radius:13px;color:white;" name="wshkesfiles">'.$wstitle.'</button></form>'; } else { echo esc_html_e( 'No available options', 'woo-shortcodes-kit' );} ?></td>
        </tr>
        <tr style="text-align:center;">
        <!--<td><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td>-->

        <!--<td></td>-->
        <td style="font-size:12px;"><?php if(file_exists($moplugin_dir)) {echo $moplugin_dir; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($moplugin_dir)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <!-- BRAZIL-->
        <tr style="text-align:center;padding-top:20px;">
        <td style="padding-top:20px;" rowspan="2"><img src="<?php echo  plugins_url( 'images/brazil.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

        
        <td style="padding-top:20px;font-size:12px;"><?php if(file_exists($brazpoplugin_dir)) {echo $brazpoplugin_dir; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td style="padding-top:20px;"><?php if(file_exists($brazpoplugin_dir)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        <td style="padding-top:20px;" rowspan="2"><?php if(file_exists($brazpoplugin_dir)) {echo '<form method="post"><button style="cursor:pointer;padding:10px 15px 10px 15px;background-color:#a46497;border:1px solid #a46497;border-radius:13px;color:white;" name="wshkbrafiles">'.$wstitlebr.'</button></form>'; } else { echo esc_html_e( 'No available options', 'woo-shortcodes-kit' );} ?></td>
        </tr>
        <tr style="text-align:center;">
        <!--<td><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td>-->

        <!--<td></td>-->
        <td style="font-size:12px;"><?php if(file_exists($brazmoplugin_dir)) {echo $brazmoplugin_dir; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($brazmoplugin_dir)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <!-- ADDON CBAR-->
        
        <?php
        
        //CHECK IF CUSTOM REDIRECTIONS EXISTS
    
    if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        
        ?>
        
        <tr style="text-align:center;">
        <td style="padding-top:20px;"  rowspan="2"><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

       
        
        <td style="padding-top:20px;font-size:12px;" ><?php if(file_exists($adddestino)) {echo $adddestino; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        
        <td style="padding-top:20px;" ><?php if(file_exists($adddestino)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        <td style="padding-top:20px;"  rowspan="2"><?php if(file_exists($adddestino)) {echo '<form method="post"><button style="cursor:pointer; padding:10px 15px 10px 15px;background-color:#a46497;border:1px solid #a46497;border-radius:13px;color:white;" name="cbaresfiles">'.$wstitlee.'</button></form>'; } else { echo esc_html_e( 'No available options', 'woo-shortcodes-kit' );} ?></td>
        </tr>
        
        <tr style="text-align:center;">
        <!--<td><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td>-->

        <!--<td></td>-->
        <td style="font-size:12px;"><?php if(file_exists($addmodestino)) {echo $addmodestino; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($addmodestino)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    
    <br><br>
    
    <h3 style="background-color:#a46497;color:white;padding:15px;border:1px solid #a46497;border-radius:13px;margin-bottom:-15px;"><?php esc_html_e( 'System files', 'woo-shortcodes-kit' ); ?></h3>
    <table width="100%" bgcolor="#fbfbfb" style="color:#000000;border: 1px solid #fbfbfb;border-radius:13px;" cellpading="10" align="center">
         <thead>
    <tr>
      <th width="10%" style="padding:10px;"><?php esc_html_e( 'LANGUAGE', 'woo-shortcodes-kit' ); ?></th>
      <th width="80%" style="padding:10px;"><?php esc_html_e( 'ROOT', 'woo-shortcodes-kit' ); ?></th>
      <th width="10%" style="padding:10px;"><?php esc_html_e( 'AVAILABLE', 'woo-shortcodes-kit' ); ?></th>
    </tr>
  </thead>
  <br>
  <tbody>
        <tr style="text-align:center;">
        <td rowspan="2"><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

        
        <td><?php if(file_exists($pathpo)) {echo $pathpo; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($pathpo)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <tr style="text-align:center;">
        <!--<td><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td>-->

        
        <td><?php if(file_exists($pathmo)) {echo $pathmo; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($pathmo)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <!-- BRAZIL -->
        
        <tr style="text-align:center;">
        <td rowspan="2" style="padding-top:20px;"><img src="<?php echo  plugins_url( 'images/brazil.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

        
        <td style="padding-top:20px;"><?php if(file_exists($brapathpo)) {echo $brapathpo; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td style="padding-top:20px;"><?php if(file_exists($brapathpo)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <tr style="text-align:center;">
        <!-- <td><img src="<?php echo  plugins_url( 'images/brazil.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td> -->
        <td><?php if(file_exists($brapathmo)) {echo $brapathmo; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($brapathmo)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <!--ADDON CBAR-->
        
        <?php
        
        //CHECK IF CUSTOM REDIRECTIONS EXISTS
    
    if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        
        ?>
        
        <tr style="text-align:center;">
        <td rowspan="2" style="padding-top:20px;"><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 48px; height: 48px;padding-bottom: 5px;"></td>

        
        <td style="padding-top:20px;"><?php if(file_exists($sysadddestino)) {echo $sysadddestino; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td style="padding-top:20px;"><?php if(file_exists($sysadddestino)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <tr style="text-align:center;">
        <!-- <td><img src="<?php echo  plugins_url( 'images/spain.png
' , __FILE__ );?>" style="width: 24px; height: 24px;padding-bottom: 5px;"></td> -->
        
        <td><?php if(file_exists($sysaddmodestino)) {echo $sysaddmodestino; } else { echo esc_html_e( 'The file not exist', 'woo-shortcodes-kit' );} ?></td>
        <td><?php if(file_exists($sysaddmodestino)) {echo '<span style="color:#aadb4a;"class="dashicons dashicons-yes"></span>'; } else { echo '<span style="color:red;" class="dashicons dashicons-no-alt"></span>';} ?></td>
        </tr>
        
        <?php } ?>
        
        </tbody>
    </table>
    
  
  <br><br>
   
    
    
    
    
    
   
    
    
    
    
    
    
    </div></div></div>
    
    



<?php
//Since 1.7.3
    //CHECK IF CUSTOM REDIRECTIONS EXISTS
    
    /*if ( in_array( 'custom-redirections-for-wshk/custom-redirections-for-whsk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
       include( ABSPATH . '/wp-content/plugins/custom-redirections-for-wshk/license/license-in-wshk.php' );


        }*/
	    
	}
endif;



/*Hide admin notices*/
if (isset($_GET['page']) && $_GET['page'] == 'woo-shortcodes-kit') {
function hide_notices_dashboard() {
    global $wp_filter;
 
    if (is_network_admin() and isset($wp_filter["network_admin_notices"])) {
        unset($wp_filter['network_admin_notices']);
    } elseif(is_user_admin() and isset($wp_filter["user_admin_notices"])) {
        unset($wp_filter['user_admin_notices']);
    } else {
        if(isset($wp_filter["admin_notices"])) {
            unset($wp_filter['admin_notices']);
        }
    }
 
    if (isset($wp_filter["all_admin_notices"])) {
        unset($wp_filter['all_admin_notices']);
    }
}
add_action( 'admin_init', 'hide_notices_dashboard' );}

/** add js into admin footer */
// better use get_current_screen(); or the global $current_screen

if (isset($_GET['page']) && $_GET['page'] == 'woo-shortcodes-kit') {
   add_action('admin_footer','init_wshk_admin_scripts');
}

if(!function_exists('init_wshk_admin_scripts')):
function init_wshk_admin_scripts()
{
wp_register_style( 'wshk_admin_style', plugins_url( 'css/wshk-admin-min.css',__FILE__ ) );
wp_enqueue_style( 'wshk_admin_style' );

echo $script='<script type="text/javascript">
    /* Protect WP-Admin js for admin */
    jQuery(document).ready(function(){
        jQuery(".wshk-tab").hide();
        jQuery("#div-wshk-general").show();
        jQuery(".wshk-tab-links").click(function(){
        var divid=jQuery(this).attr("id");
        jQuery(".wshk-tab-links").removeClass("active");
        jQuery(".wshk-tab").hide();
        jQuery("#"+divid).addClass("active");
        jQuery("#div-"+divid).fadeIn();
        });
        })
    </script>';
}
endif;



/** Include class file **/

//Updated v.1.7.8
require plugin_dir_path( __FILE__ ).'/wshk-class.php';
//require dirname(__FILE__).'/wshk-class.php';



?>