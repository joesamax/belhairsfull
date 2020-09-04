<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
// register
if ( ! function_exists( 'wp_white_label_register_hide_settings' ) ):
add_action( 'admin_init', 'wp_white_label_register_hide_settings' );
function wp_white_label_register_hide_settings() {
   register_setting( 'wp_white_label_register_hide_setting', 'wp_white_label_hidden_user_options' );
   register_setting( 'wp_white_label_register_hide_setting', 'wp_white_label_hidden_plugin_options' );
}
endif;

// Setting form page
if ( ! function_exists( 'wp_white_label_page_hidden_plugin_callback' ) ):
function wp_white_label_page_hidden_plugin_callback() {
    $users = get_users( );
    $slected_user= get_option('wp_white_label_hidden_user_options'); 
    $slected_plugin= get_option('wp_white_label_hidden_plugin_options'); 
    ?>
    <div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<div class="notice notice-warning">
			<p><?php _e( 'Hidden the Plugins on the Plugin page "wp-admin/plugins.php". Prevent users from activating or deactivating.', 'wp-white-label' ); ?></p>
		</div>
		<?php settings_errors(); ?>
		<div class="wp-white-label-main-section"><?php 
			if ( ! function_exists( 'get_plugins' ) ) {
			  require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			$all_plugins = get_plugins(); ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'wp_white_label_register_hide_setting' ); ?>
				<h2><?php _e('Hide Plugins On The Plugin Page','wp-white-label') ?></h2>
				 <table class="form-table">
					<tr>
						<td>
							<label multiple for="wp_white_label_hidden_user_options" name="wp_white_label_hidden_user_options[]" class="hidden-plugin-columns"><div><strong><?php _e('Select Users','wp-white-label') ?></strong></div><?php 
								foreach ($users as $user) {
									?><div class="hidden-plugin-column">
										<input type="checkbox" name="wp_white_label_hidden_user_options[]" id="<?php echo $user->ID ?>" value="<?php echo $user->ID ?>" <?php echo ( !empty( $slected_user ) && in_array( $user->ID, $slected_user )) ? ' checked="checked"' : '' ?>><?php echo ucwords($user->display_name); ?></>
									</div><?php
								}?>
							</label>
							<label multiple for="wp_white_label_hidden_plugin_options" name="wp_white_label_hidden_plugin_options[]" class="hidden-plugin-columns" style="padding-left: 1%;border-left: 1px solid #ddd;"><div><strong><?php _e('Select Plugins','wp-white-label') ?></strong></div><?php
								foreach ($all_plugins as $key => $plugin) {
									?><div class="hidden-plugin-column">
										<input type="checkbox" name="wp_white_label_hidden_plugin_options[]" id="<?php echo $key ?>" value="<?php echo $key ?>"  <?php echo ( !empty( $slected_plugin ) && in_array( $key, $slected_plugin )) ? ' checked="checked"' : '' ?>><?php echo ucwords($plugin['Name']); ?></>
									</div><?php
								} ?>
							</label>
						</td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e('Save Changes','wp-white-label') ?>" />
					<a class="button button-primary" href="http://longvietweb.com/contact/" target="_blank"><?php _e('Support','wp-white-label') ?></a>
				</p>
			</form>
		</div>
	</div><?php
}endif;