<?php



//Since v.1.6.6

/*RESTRICT CONTENT TO NON LOGGED IN USERS*/
//Hide the content that you want for non logged in users everywhere! If you want restrict some content in any page or post, use this shortcode [wshk] my contente [/wshk]

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enablerestrictctnt']) && $pluginOptionsVal['wshk_enablerestrictctnt']==22)
{
function wshk_hide_content_shortcode($atts = [], $content = null)
{
    // do something to $content
    
    if ( is_user_logged_in() ) {
 ob_start();
    // run shortcode parser recursively
    $content = do_shortcode($content);
 
    // always return
    echo $content;
    return ob_get_clean();
}
}
add_shortcode('wshk', 'wshk_hide_content_shortcode');
}

//Since v.1.6.6

/*RESTRICT CONTENT TO LOGGED IN USERS*/
//Hide the content that you want for logged in users everywhere! If you want restrict some content in any page or post, use this shortcode [off] my contente [/off]

/*global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();*/
      if(isset($pluginOptionsVal['wshk_enableoffctnt']) && $pluginOptionsVal['wshk_enableoffctnt']==23)
{
function wshk_off_content_shortcode($atts = [], $content = null)
{
    // do something to $content
    
    if ( ! is_user_logged_in() ) {
 ob_start();
    // run shortcode parser recursively
    $content = do_shortcode($content);
 
    // always return
    echo $content;
    return ob_get_clean();
}
}
add_shortcode('off', 'wshk_off_content_shortcode');
}


?>