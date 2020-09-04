<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Change the default wordpress@ email address
add_filter('wp_mail_from', 'wp_white_label_new_mail_from');
add_filter('wp_mail_from_name', 'wp_white_label_new_mail_from_name');
 
function wp_white_label_new_mail_from($old) {
	if ( $wp_white_label_section_email_enable && in_array( 'on', $wp_white_label_section_email_enable ) ) {
		return get_option('wp_white_label_forms_email');
	}
}
function wp_white_label_new_mail_from_name($old) {
	if ( $wp_white_label_section_email_enable && in_array( 'on', wp_white_label_section_email_enable ) ) {
		return get_option('wp_white_label_forms_name');
	}
}

$wp_white_label_remove_adminbar = get_option( 'wp_white_label_remove_adminbar' );
// Remove Admin Bar
if ( $wp_white_label_remove_adminbar && in_array( 'on', $wp_white_label_remove_adminbar ) ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		add_filter ('show_admin_bar', '__return_false');
	}
}

$wp_white_label_admin_area = get_option( 'wp_white_label_admin_area' );
// Remove WordPress Logo in Admin Bar
if ( $wp_white_label_admin_area && in_array( 'on', $wp_white_label_admin_area ) ) {

	function wp_white_label_remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_menu( 'about' );
		$wp_admin_bar->remove_menu( 'wporg' );
		$wp_admin_bar->remove_menu( 'documentation' );
		$wp_admin_bar->remove_menu( 'support-forums' );
		$wp_admin_bar->remove_menu( 'feedback' );
		$wp_admin_bar->remove_node( 'wp-logo' );
	}
	add_action( 'admin_bar_menu', 'wp_white_label_remove_wp_logo', 999 );
}

// Replace Howdy text with welcome
function wp_white_label_change_howdy( $wp_admin_bar ) {

	$wp_white_label_admin_howdy = get_option( 'wp_white_label_admin_howdy' );

	if ( $wp_white_label_admin_howdy ) {

		$wl_get_howdy = $wp_admin_bar->get_node( 'my-account' );

		$wl_replacement = preg_replace( '/^[^,]*,\s*/', $wp_white_label_admin_howdy . ' ', $wl_get_howdy->title );
		$wp_admin_bar->add_node(
			array(
				'id'    => 'my-account',
				'title' => $wl_replacement,
			)
		);
	}
}
add_filter( 'admin_bar_menu', 'wp_white_label_change_howdy', 25 );


// Add Custom Dashboard widget
$dashboard_widget_switch = get_option( 'wp_white_label_dashboard_widget_switch' );

if ( $dashboard_widget_switch ) {

	add_action( 'wp_dashboard_setup', 'wp_white_label_dashboard_widget_one' );

}

function wp_white_label_dashboard_widget_one() {

	$dashboard_widget_title = get_option( 'wp_white_label_dashboard_widget_title' );

	wp_add_dashboard_widget(
		'wp_white_label_dashboard_widget_one',
		$dashboard_widget_title,
		'wp_white_label_dashboard_widget_one_content'
	);
	global $wp_meta_boxes;
 	
 	// Get the regular dashboard widgets array 
 	// (which has our new widget already but at the end)
 
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	
 	// Backup and delete our new dashboard widget from the end of the array
 
 	$example_widget_backup = array( 'wp_white_label_dashboard_widget_one' => $normal_dashboard['wp_white_label_dashboard_widget_one'] );
 	unset( $normal_dashboard['wp_white_label_dashboard_widget_one'] );
 
 	// Merge the two arrays together so our widget is at the beginning
 
 	$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
 
 	// Save the sorted array back into the original metaboxes 
 
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;

}

function wp_white_label_dashboard_widget_one_content() {
	$dashboard_widget_content = get_option( 'wp_white_label_dashboard_widget_content' );
	echo wpautop( $dashboard_widget_content );
}

// Custom Admin Footer text
$admin_footer = get_option( 'wp_white_label_admin_footer' );

if ( $admin_footer ) {

	function wp_white_label_admin_footer_credit( $text ) {

		$admin_footer = get_option( 'wp_white_label_admin_footer' );

		return $admin_footer;
	}

	add_filter( 'admin_footer_text', 'wp_white_label_admin_footer_credit' );

}

// Custom login styles
function wp_white_label_login_styles() {

	$logo_url         = get_option( 'wp_white_label_custom_logo' );
	$logo_height      = get_option( 'wp_white_label_custom_logo_height' );
	$logo_width       = get_option( 'wp_white_label_custom_logo_width' );
	$login_background = get_option( 'wp_white_label_login_background' );
	$login_bg_image   = get_option( 'wp_white_label_login_background_image' );

	?>
	<style type="text/css">
	##login {
		padding: 1% 0 1% !important;
		margin: 1% auto !important;
		background: #fff;
	}
	body.login {
	  background-image: url(<?php echo $login_bg_image; ?>);
	  background: <?php echo $login_background; ?>;
	  background-repeat: no-repeat;
	  background-size: cover;
	  background-position: center;
	}
	#login h1 a, .login h1 a {
		background-image: url(<?php echo $logo_url; ?>);
		max-height: 200px ;
		height: 84px;
		width: 300px;
		background-size: contain;
		background-repeat: no-repeat;
		background-position: bottom;
	}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'wp_white_label_login_styles' );

// URL & Title for login link
add_filter( 'login_headerurl', 'wp_white_label_login_styles_url' );
function wp_white_label_login_styles_url() {
	$company_url = get_option( 'wp_white_label_company_url' );
	return $company_url;
}

add_filter( 'login_headertext', 'wp_white_label_login_styles_url_title' );
function wp_white_label_login_styles_url_title() {
	$company_name = get_option( 'wp_white_label_company_name' );
	return $company_name;
}

// Styles / Scripts
add_action( 'admin_print_footer_scripts', 'wp_white_label_script_styles' );
function wp_white_label_script_styles() {
	$wp_white_label_script_styles = get_option( 'wp_white_label_script_styles' );
	$wp_white_label_script_style = get_option( 'wp_white_label_script_style' );
	if ( $wp_white_label_script_styles ) {
		echo $wp_white_label_script_styles;
	}
	if ( $wp_white_label_script_style ) {
		echo $wp_white_label_script_style;
	}
}

// Hidden Plugin
add_filter( 'all_plugins', 'wp_white_label_hidden_plugins_items' );
function wp_white_label_hidden_plugins_items( $plugins ) {
    $user = get_current_user_id();
    $user_id = get_option( 'wp_white_label_hidden_user_options' ); 
    $pluginshidden = get_option('wp_white_label_hidden_plugin_options'); 
    if (isset($user_id)) {
		if ($user_id && in_array( $user, $user_id ) ) {   
			foreach($pluginshidden as $pluginname) {
				if( in_array( $pluginname, array_keys( $plugins ) ) ) {
					unset( $plugins[$pluginname] );
				}
			}     
		}
    }
    return $plugins;
}

// Admin Bar Custom Logo.
add_action( 'wp_before_admin_bar_render', 'wp_white_label_admin_bar_logo' );
function wp_white_label_admin_bar_logo() {
	$wl_admin_logo      = get_option( 'wp_white_label_admin_bar_logo' );
	if ( $wl_admin_logo ) {
		echo '
		<style type="text/css">
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			background-image: url(' . get_option( 'wp_white_label_admin_bar_logo' ) . ') !important;
			background-position: center;
			color:rgba(0, 0, 0, 0);
			background-size:cover;
		}
		#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
			background-position: center;
			background-size:cover;
		}
		</style>
		';
	}
}
// Disable File Edit.
$wp_white_label_section_disable_editor = get_option( 'wp_white_label_section_disable_editor' );
if ( $wp_white_label_section_disable_editor && in_array( 'on', $wp_white_label_section_disable_editor ) ) {
	if(!defined('DISALLOW_FILE_EDIT')) define( 'DISALLOW_FILE_EDIT', true );
}