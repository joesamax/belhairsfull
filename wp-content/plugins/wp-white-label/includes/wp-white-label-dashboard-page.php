<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wp_White_Label_Custom_Dashboard {
    protected $capability = 'read'; // Allows everyone to see the page
    protected $title;
    final public function __construct() {

            add_action( 'init', array( $this, 'init' ) );

    }
    final public function init() {
        if( current_user_can( $this->capability ) ) {
            $this->set_title();
            add_filter( 'admin_title', array( $this, 'admin_title' ), 10, 2 );
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
            add_action( 'current_screen', array( $this, 'current_screen' ) );
        }
    }

    // Custom page title. TODO make this a setting.

    function set_title() {
        if( ! isset( $this->title ) ) {
            $this->title = get_option( 'wp_white_label_custom_dashboard_title' );
        }
    }

    // Generate the custom page

    function page_content() {

        $content = wpautop(get_option('wp_white_label_custom_dashboard'));

        echo 
			'<div class="wrap">
				<h2>'.$this->title.'</h2>
				<div class="wp-white-label-page" style="background:#ffffff;padding:1px 30px;">
					<div class="wp-white-label-col-1">
					  <p>'.$content.'</p>
					</div>
				</div>
			</div>';
    }


    final public function admin_title( $admin_title, $title ) {
        global $pagenow;
        if( 'admin.php' == $pagenow && isset( $_GET['page'] ) && 'my-dashboard' == $_GET['page'] ) {
            $admin_title = $this->title . $admin_title;
        }
        return $admin_title;
    }
    final public function admin_menu() {

        // Add our custom page

        add_menu_page( $this->title, '', 'read', 'my-dashboard', array( $this, 'page_content' ) );

        // Hide it from the menu

        remove_menu_page('my-dashboard');

        //  Make dashboard menu item the active item

        global $parent_file, $submenu_file;
        $parent_file = 'index.php';
        $submenu_file = 'index.php';

        // rename the dashboard

        global $menu;
        $menu[2][0] = $this->title;

         // Rename the dashboard submenu item

        global $submenu;
        $submenu['index.php'][0][0] = $this->title;
    }

    // Redirect users to our new dashboard from the old one

    final public function current_screen( $screen ) {
        if( 'dashboard' == $screen->id ) {
           wp_safe_redirect( admin_url('admin.php?page=my-dashboard') );
          exit;
        }
    }
}
new Wp_White_Label_Custom_Dashboard();
