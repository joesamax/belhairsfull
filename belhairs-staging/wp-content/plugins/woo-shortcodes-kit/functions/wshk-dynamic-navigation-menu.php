<?php 


//Since 1.6.4
/*CUSTOM MENU FOR LOGGED IN AND NON LOGGED IN USERS*/
//If you want display a different menu for logged in & non logged in users, just need activate this function and write the menu name in each field.
/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enablecustomenu']) && $pluginOptionsVal['wshk_enablecustomenu']==17)
{
    
    
function wshk_custom_menus( $args ) {
    
    //can choose the menu location from dropdown
    
    //can choose the logged and non logged in menus from dropdown
    
    //To use with Elementor nav menu widget you need custom blocks and redirections addon
    
   $menloca = get_option('wshk_menulocation');
   
      if ( $args['theme_location'] ==  $menloca) {
         
    $loggedinmenu = get_option('wshk_logmenu');
    $nonloggedinmenu = get_option('wshk_nonlogmenu');
    
 if( is_user_logged_in() ) {

 $args['menu'] = $loggedinmenu;
 } else {
     
 $args['menu'] = $nonloggedinmenu;
 }
 }
 return $args;
}

 add_filter( 'wp_nav_menu_args', 'wshk_custom_menus' );
}




//Since 1.6.4
/*ENABLE ADD SHORTCODES IN MENU ITEM TITLES*/
//If you want insert shortcodes in your menu item titles, just need activate this function and nothing more!

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableshtmenu']) && $pluginOptionsVal['wshk_enableshtmenu']==18)
{

function wshk_shortcodes_in_menu( $menu ){ 
        return do_shortcode( $menu ); 
} 
add_filter('wp_nav_menu', 'wshk_shortcodes_in_menu'); 
}




//Since 1.6.4 - updated 1.8.7
/*ENABLE DISPLAY USERNAME IN MENU*/
//If you want show the username in the menu, just need activate this function.

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableuserinmenu'])  && $pluginOptionsVal['wshk_enableuserinmenu']==19)
{
   

function displayname_on_menu(){
    ob_start();
    $user = wp_get_current_user();
    
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
    if(isset($pluginOptionsVal['wshk_userinmenuoptions']) && $pluginOptionsVal['wshk_userinmenuoptions']=='showus')
    {
    
        echo $user->user_login;//first_name, display_name
        
    } else if (isset($pluginOptionsVal['wshk_userinmenuoptions']) && $pluginOptionsVal['wshk_userinmenuoptions']=='showonly') 

    {
        echo $user->first_name;   
        
    } else {
        
        echo $user->display_name;
    }    
    
    
    return ob_get_clean();
}
add_shortcode( 'wshk_user_in_menu' , 'displayname_on_menu' );
}



?>