<?php
/**
 *  Register Widgets
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Mobile_Menu_Builder_Widgets Class
 */
class Mobile_Menu_Builder_Widgets {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'widgets_init', array( $this, 'register_widgets' ), 99 );
		add_action( 'admin_footer', array( $this, 'hide_widgets' ));
	}

	function register_widgets(){
		register_sidebar( array(
	        'name' 			=> __( 'Mobile Menu Builder Popup', 'mobile-menu-builder' ),
	        'id' 			=> 'mobile-menu-builder-1',
	        'description' 	=> __( 'Mobile Menu Builder Popup Contents', 'mobile-menu-builder' ),
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
	    ) );
	}

	function hide_widgets(){ 
		global $pagenow;
		
		if( $pagenow != 'widgets.php' ){
			return;
		}
	?>
	<style>
		#widgets-right #mobile-menu-builder-1{
			display: none;
		}
	</style>
	<?php }

}

return new Mobile_Menu_Builder_Widgets();
