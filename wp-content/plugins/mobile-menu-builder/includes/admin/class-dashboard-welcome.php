<?php
/**
 * Create welcome page after activation
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mobile_Menu_Builder_Dashboard_Welcome Class
 */
class Mobile_Menu_Builder_Dashboard_Welcome {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'screen_page' ) );
		add_action( 'activated_plugin', array( $this, 'redirect' ) );
		add_action( 'admin_head', array( $this, 'remove_menu' ) );
	}

	/**
	 * Setup the admin menu.
	 */
	public function screen_page() {
		add_dashboard_page(
			__( 'Mobile Menu Builder', 'mobile-menu-builder' ),
			__( 'Mobile Menu Builder', 'mobile-menu-builder' ),
			apply_filters( 'mobile_menu_builder_welcome_screen_capability', 'manage_options' ),
			'mobile-menu-builder--welcome',
			array( $this, 'content' )
		);
	}

	/**
	 * Remove the menu item from the admin.
	 */
	public function remove_menu() {
		remove_submenu_page( 'index.php', 'mobile-menu-builder--welcome' );
	}

	/**
	 * Page header.
	 */
	public function header() {

		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'mobile-menu-builder--welcome';
		?>
		<h1><?php echo esc_html__( 'Welcome to Mobile Menu Builder', 'mobile-menu-builder' ); ?></h1>
		<!-- <div class="about-text">
			<?php echo esc_html__( 'We highly recommend you watch this instructions below to get started, then you will be up and running in no time.', 'mobile-menu-builder' ); ?>
		</div> -->

		<?php
	}

	/**
	 * Page content.
	 */
	public function content() {
		$url = add_query_arg(
			array(
				'autofocus[section]' => 'mobile_menu_builder--container',
				'url' 				=> esc_url( home_url() ) ,
			),
			admin_url( 'customize.php' )
		);
	?>
		<div class="wrap about-wrap mobile-menu-builder--about-wrap">
			<?php $this->header(); ?>
			<div class="about-description">
				<p><?php echo esc_html__( 'We highly recommend you watch this instructions below to get started, then you will be up and running in no time.', 'mobile-menu-builder' ); ?></p>
				<div class="featured-video">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/hBczWJ1LHp0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
				<p>
					<a href="<?php echo $url; ?>" class="button button-primary"><?php echo esc_html__( 'Go to Mobile Menu Builder', 'mobile-menu-builder' ); ?></a>
					<a href="https://menubuilderwp.com/wordpress-mobile-menu-builder-tutorial/" class="button button-secondary"><?php echo esc_html__( 'View Full Tutorials', 'mobile-menu-builder' ); ?></a>
				</p>
			</div>

		</div>
		<style type="text/css" media="screen">
			.mobile-menu-builder--about-wrap h1{
		    	color: #000;
		    	text-align: center;
		    	font-size: 31px;
		    	margin: 50px 0px 30px;
		    }
		    .mobile-menu-builder--about-wrap .regular-text{
		    	max-width:  100%;
		    }
		    .mobile-menu-builder--about-wrap .about-description{
		    	font-size: 16px;
		    	color: #000;
		    	background: #fff;
			    border: 1px solid #e1e1e1;
			    padding: 40px;
			    box-shadow: 1px 5px 15px rgba(0,0,0,0.02);
			    border-radius: 2px;
			    text-align: center;
		    }
		    .mobile-menu-builder--about-wrap .about-description .featured-video{
		    	margin-top: 30px;
		    }
		    .mobile-menu-builder--about-wrap .about-description .button{
		    	height: auto;
			    width: auto;
			    padding: 10px 30px;
			    font-size: 16px;
			    margin: 0px 5px;
		    }
		    .mobile-menu-builder--about-wrap iframe{
		    	max-width: 100%;
		    }
		</style>
	<?php
	}

	/**
	 * Redirect to the welcome page upon plugin activation.
	 */
	public function redirect( $plugin ) {
		if ( ( $plugin == 'mobile-menu-builder/plugin.php' ) && ! isset( $_GET['activate-multi'] ) ) {
			wp_safe_redirect( admin_url( 'index.php?page=mobile-menu-builder--welcome' ) );
			die();
		}
	}
}

return new Mobile_Menu_Builder_Dashboard_Welcome();
