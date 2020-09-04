<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
		
if ( ! function_exists( 'wp_white_label_create_settings' ) ):
function wp_white_label_create_settings() {
	$page_title = 'WP White Label';
	$menu_title = 'WP White Label';
	$capability = 'manage_options';
	$slug       = 'wp-white-label';
	$callback   = 'wp_white_label_page_callback';
	add_menu_page( $page_title, $menu_title, $capability, $slug, $callback );
	add_submenu_page( 'wp-white-label', 'WP White Label', 'WP White Label', 'manage_options', 'wp-white-label' );
	add_submenu_page('wp-white-label', 'WP Hidden Plugin', 'WP Hidden Plugin', 'manage_options','wpwl-hidden-plugin', 'wp_white_label_page_hidden_plugin_callback');
	do_action( 'wp_white_label_menus' );
}
endif;

/* <img src="<?php echo plugins_url(). '/wp-white-label/assets/images/ladyshop-3.png'; ?>" width="auto" height="auto"/> */
if ( ! function_exists( 'wp_white_label_page_callback' ) ):
function wp_white_label_page_callback() {
	?>
	<div class="wrap">
		<h1><?php _e( 'WP White Label', 'wp-white-label' ); ?></h1>
	    <?php settings_errors(); ?>
		<?php do_action( 'wp_white_label_before_page' ); ?>
	    <div class="wp-white-label-main-section">
			<form method="POST" action="options.php">
				<div class="wp-white-label-header-form">
					<ul class="wp-white-label-admin-tabs-links">
						<li class="tab-link active" data-tab="tab-1"><i class="dashicons dashicons-tag"></i><span class="section_title"><?php _e( 'Branding', 'wp-white-label' ); ?></span></li>
						<li class="tab-link" data-tab="tab-2"><i class="dashicons dashicons-archive"></i><span class="section_title"><?php _e( 'Add Dashboard Widgets', 'wp-white-label' ); ?></span></li>
						<li class="tab-link" data-tab="tab-3"><i class="dashicons dashicons-dashboard"></i><span class="section_title"><?php _e( 'Custom Dashboard Page', 'wp-white-label' ); ?></span></li>
						<li class="tab-link" data-tab="tab-4"><i class="dashicons dashicons-move"></i><span class="section_title"><?php _e( 'Removes Dashboard Widgets', 'wp-white-label' ); ?></span></li>
						<li class="tab-link" data-tab="tab-5"><i class="dashicons dashicons-editor-code"></i><span class="section_title"><?php _e( 'Add Scripts / Styles', 'wp-white-label' ); ?></span></li>
						<li class="tab-link" data-tab="tab-6"><i class="dashicons dashicons-hidden"></i><span class="section_title"><?php _e( 'WP White Label Hidden', 'wp-white-label' ); ?></span></li>
					</ul>
				</div>
				
				<div id="tab-1" class="wp-white-label-admin-tab-content active">
				   <?php
					do_action( 'wp_white_label_before_settings_white_label' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback' );
					do_action( 'wp_white_label_after_settings_white_label' );
					?>
				</div>
				<div id="tab-2" class="wp-white-label-admin-tab-content">
				   <?php
					do_action( 'wp_white_label_before_settings_dashboard_widget' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback_dashboard_widget' );
					do_settings_sections( 'wp_white_label_callback_script_styles' );
					do_action( 'wp_white_label_after_settings_dashboard_widget' );
					?>
				</div>
				<div id="tab-3" class="wp-white-label-admin-tab-content">
				   <?php
					do_action( 'wp_white_label_before_settings_custom_dashboard' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback_custom_dashboard' );
					do_settings_sections( 'wp_white_label_callback_script_styles' );
					do_action( 'wp_white_label_after_settings_custom_dashboard' );
					?>
				</div>
				<div id="tab-4" class="wp-white-label-admin-tab-content">
				   <?php
					do_action( 'wp_white_label_before_settings_remove_dashboard_widgets' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback_remove_dashboard_widgets' );
					do_action( 'wp_white_label_after_settings_remove_dashboard_widgets' );
					?>
				</div>
				<div id="tab-5" class="wp-white-label-admin-tab-content">
				   <?php
					do_action( 'wp_white_label_before_settings_script_styles' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback_script_styles' );
					do_action( 'wp_white_label_after_settings_script_styles' );
					?>
				</div>
				<div id="tab-6" class="wp-white-label-admin-tab-content">
				   <?php
					do_action( 'wp_white_label_before_settings_hidden' );
					settings_fields( 'wp_white_label_callback' );
					do_settings_sections( 'wp_white_label_callback_hidden' );
					do_action( 'wp_white_label_after_settings_hidden' );
					?>
				</div>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes','wp-white-label') ?>" />
					<a class="button button-primary" href="http://longvietweb.com/contact/" target="_blank"><?php _e('Support','wp-white-label') ?></a>
				</p>
			</form>
		</div>
		<?php do_action( 'wp_white_label_after_page' ); ?>
	 </div>
	<?php
}
endif;