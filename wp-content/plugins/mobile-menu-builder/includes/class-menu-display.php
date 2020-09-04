<?php
/**
 * Load @@pkg.title block assets.
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @link      @@pkg.author_uri
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main @@pkg.title Class
 *
 * @since 1.0.0
 */
class Mobile_Menu_Builder_Display {


	/**
	 * This plugin's instance.
	 *
	 * @var Mobile_Menu_Builder_Display
	 */
	private static $instance;

	/**
     * $cache_time 
     * transient exiration time
     * @var int
     */
    public $cache_time 		= 86400; // 24 hours in seconds
    private $transient_name = 'mobile_menu_builder_cache';

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new Mobile_Menu_Builder_Display();
		}
	}

	/**
	 * The base directory path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_dir;

	/**
	 * The base URL path (without trailing slash).
	 *
	 * @var string $_url
	 */
	private $_url;

	/**
	 * The Plugin version.
	 *
	 * @var string $_version
	 */
	private $_version;

	/**
	 * The Plugin version.
	 *
	 * @var string $_slug
	 */
	private $_slug;

	/**
	 * Customizer saved values
	 *
	 * @var string $_options
	 */
	private $_options;

	/**
	 * The Constructor.
	 */
	private function __construct() {
		$this->_version = MOBILE_MENU_BUILDER_VERSION;
		$this->_slug    = 'mobile_menu_builder';
		$this->_dir     = MOBILE_MENU_BUILDER_PLUGIN_DIR;
		$this->_url     = MOBILE_MENU_BUILDER_PLUGIN_URL;
		$this->_options     = get_option( 'mobile_menu_builder_customizer' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'display_menu' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}

	/**
	 * Add custom body class
	 *
	 * @access public
	 */
	public function body_class( $classes ){
		if( isset( $this->_options['position'] ) && !empty( $this->_options['position'] ) ){
			$classes[] = 'mobile-menu-builder--'. $this->_options['position'];
		}

		if( isset( $this->_options['enableAnimation'] ) && !empty( $this->_options['enableAnimation'] ) && $this->_options['enableAnimation'] ){
			$classes[] = 'mobile-menu-builder--animate';
		}else{
			$classes[] = 'mobile-menu-builder--noanimate';
		}

		return $classes;
	}

	/**
	 * Scripts & Styles
	 *
	 * @access public
	 */
	
	public function enqueue_scripts(){

		$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

        if( isset( $this->_options['font'] ) && !empty( $this->_options['font'] ) ){
            $gfonts      = str_replace( ' ', '+', $this->_options['font'] ) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
            $query_args = array(
                'family' => $gfonts,
            );

            wp_register_style(
                'mobile-menu-builder-font',
                add_query_arg( $query_args, '//fonts.googleapis.com/css' ),
                array(),
                null
            );
            wp_enqueue_style( 'mobile-menu-builder-font' );
        }

        if( isset( $this->_options['popupFontFamily'] ) && !empty( $this->_options['popupFontFamily'] ) ){
            $gfonts      = str_replace( ' ', '+', $this->_options['popupFontFamily'] ) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
            $query_args = array(
                'family' => $gfonts,
            );

            wp_register_style(
                'mobile-menu-builder-popupFontFamily',
                add_query_arg( $query_args, '//fonts.googleapis.com/css' ),
                array(),
                null
            );
            wp_enqueue_style( 'mobile-menu-builder-popupFontFamily' );
        }

		wp_enqueue_style( 'mobile-menu-builder-css', $this->_url . 'assets/css/mobile-menu-builder.css', false );
		
		if( is_customize_preview() ){
			wp_enqueue_style( 'ionicons', $this->_url . 'includes/customizer/controls/icon-picker/assets/css/ionicons.min.css' );
		}
		

		wp_register_script(
            'jquery-mobile-menu-builder',
            $this->_url .'assets/js/mobile-menu-builder'. $suffix .'.js',
            array( 'jquery' ),
            '',
            true
        );
        wp_enqueue_script( 'jquery-mobile-menu-builder' );

	}

	/**
	 * Menu display
	 *
	 * @access public
	 */
	public function display_menu() {
		global $wp;

		$options 		= '';
		
		$innerClass 	= '';

		$container_css 	= '';
		$icon_css 		= '';
		$svg_css 		= '';
		$label_css 		= '';
		$links_css 		= '';
		$linksHover_css = '';
		$popup_css 		= '';
		$popupText_css 	= '';
		$popupTitle_css = '';

		$links 			= array();
		$icons 			= array();
		$label 			= array();
		$menu_count 	= apply_filters( 'mobile-menu-builder/menu_items', 4 );
		$current_url 	=  parse_url( home_url( $wp->request ) );
		$current_url['path'] = isset( $current_url['path'] ) ? trim( $current_url['path'], '/' ) : '';
		$current_class	= '';
		$menu_class		= '';

		if ( !is_customize_preview() && is_array( $this->_options ) && isset( $this->_options['cached'] ) && $this->_options['cached'] && false !== ( $cached_transient = get_transient( $this->transient_name ) ) ){
			echo $cached_transient;

			return;
		}
        
		ob_start();

		if( $this->_options ){
			$options = $this->_options;

			if ( ! class_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			WP_Filesystem();
			
			global $wp_filesystem;

			//return when disabled on front-end
			if( !is_customize_preview() && ( !isset( $options['enableMenu'] ) || ( isset( $options['enableMenu'] ) && ! $options['enableMenu'] ) ) ){
				return false;
			}
			
			if( isset( $options['containerbg'] ) ){
				$container_css .= 'background-color:'. esc_html( $options['containerbg'] ) .';';
			}
			if( isset( $options['containerbr'] ) ){
				$container_css .= 'border-color:'. esc_html( $options['containerbr'] ) .';';
			}

			if( !is_customize_preview() && isset( $options[ 'menuCount' ] ) && !empty( $options[ 'menuCount' ] ) ){
				$menu_count = intval( $options[ 'menuCount' ] );
			}

			//add classes
			if( isset( $options['popupTextAlign'] ) && !empty($options['popupTextAlign'] ) ){
				$innerClass .= ' mobile-menu-builder-popup--' . esc_html( $options['popupTextAlign'] );
			}

			for ( $x = 1; $x <= $menu_count; $x++ ) {
				if( isset( $options[ 'menu-'. $x .'-icon' ] ) && !empty( $options[ 'menu-'. $x .'-icon' ] ) ){
					$icons['menu-'. $x .'-icon'] = $options[ 'menu-'. $x .'-icon' ];
				}

				if( isset( $options[ 'menu-'. $x .'-label' ] ) && !empty( $options[ 'menu-'. $x .'-label' ] ) ){
					$label['menu-'. $x .'-label'] = $options[ 'menu-'. $x .'-label' ];
				}

				if( isset( $options[ 'menu-'. $x .'-link' ] ) && !empty( $options[ 'menu-'. $x .'-link' ] ) ){
					$links['menu-'. $x .'-link'] = $options[ 'menu-'. $x .'-link' ];
				}
			}

			//icons
			if( isset( $options['iconColor'] ) && !empty($options['iconColor'] ) ){ 
				if( is_customize_preview() ){
					$icon_css .= 'color:'. $options['iconColor'] . ';';
				}else{
					$svg_css .= 'fill:'. $options['iconColor'] . ';';
				}
			}
			if( isset( $options['iconSize'] ) && !empty($options['iconSize'] ) ){ 
				if( is_customize_preview() ){
					$icon_css .= 'font-size:'. $options['iconSize'] . ';';
				}else{
					$icon_css .= 'width:'. $options['iconSize'] . ';';
				}
			}
			if( isset( $options['hideIcon'] ) && $options['hideIcon'] ){
				$icon_css .= 'display: none';
			}
			
			//labels
			if( isset( $options['textColor'] ) && !empty($options['textColor'] ) ){ 
				$label_css .= 'color:'. $options['textColor'] . ';';
			}
			if( isset( $options['labelSize'] ) && !empty($options['labelSize'] ) ){ 
				$label_css .= 'font-size:'. $options['labelSize'] . ';';
			}
			if( isset( $options['hideLabel'] ) && $options['hideLabel'] ){
				$label_css .= 'display: none';
			}

			//links
			if( isset( $options['menuHoverBg'] ) && !empty($options['menuHoverBg'] ) ){
				$linksHover_css .= 'background-color:' . esc_html( $options['menuHoverBg'] ) .';';
			}
			if( isset( $options['textHoverColor'] ) && !empty($options['textHoverColor'] ) ){
				$linksHover_css .= 'color:' . esc_html( $options['textHoverColor'] ) .';';
			}

			//popup styling
			if( isset( $options['popupBg'] ) && !empty($options['popupBg'] ) ){
				$popup_css 	.= 'background-color:' . esc_html( $options['popupBg'] ) . ';';
			}
			if( isset( $options['popupTextColor'] ) && !empty($options['popupTextColor'] ) ){
				$popupText_css 	.= 'color:' . esc_html( $options['popupTextColor'] ) . ';';
			}

			if( isset( $options['popupHeadingColor'] ) && !empty($options['popupHeadingColor'] ) ){
				$popupTitle_css 	.= 'color:' . esc_html( $options['popupHeadingColor'] ) . ';';
			}

			//add filters for devs
			$container_css 		= sanitize_text_field( apply_filters( 'mobile-menu-builder/css/container', $container_css ) );
			$links_css 			= sanitize_text_field( apply_filters( 'mobile-menu-builder/css/links', $links_css ) );
			$linksHover_css 	= sanitize_text_field( apply_filters( 'mobile-menu-builder/css/links/hover', $linksHover_css ) );
			$popupText_css 		= sanitize_text_field( apply_filters( 'mobile-menu-builder/css/popup/text', $popupText_css ) );
			$popupTitle_css 	= sanitize_text_field( apply_filters( 'mobile-menu-builder/css/popup/title', $popupTitle_css ) );

			//Custom inline styling ?>
			<style type="text/css" media="screen">
				<?php if( !empty( $links_css ) ){ ?>
					.mobile-menu-builder--links a{
						<?php echo $links_css;?>
					}
				<?php }?>
				<?php if( !empty( $linksHover_css ) ){ ?>
					.mobile-menu-builder--links a:hover, .mobile-menu-builder--current-page a, .mobile-menu-builder-customizer--container .mobile-menu-builder-customizer--inner .mobile-menu-builder--links a.mobile-menu-builder--clicked{
						<?php echo $linksHover_css;?>
					}
				<?php }?>
				<?php if( isset( $options['iconHoverColor'] ) && !empty($options['iconHoverColor'] ) ){ ?>
					.mobile-menu-builder--links a:hover .mobile-menu-builder--icon , .mobile-menu-builder--current-page a .mobile-menu-builder--icon{
						color: <?php echo esc_html( $options['iconHoverColor'] );?> !important;
					}
				<?php }?>
				<?php if( isset( $options['textHoverColor'] ) && !empty($options['textHoverColor'] ) ){ ?>
					.mobile-menu-builder--links a:hover .mobile-menu-builder--label, .mobile-menu-builder--current-page a .mobile-menu-builder--label{
						color: <?php echo esc_html( $options['textHoverColor'] );?> !important;
					}
				<?php }?>
				<?php if( isset( $options['font'] ) && !empty($options['font'] ) ){ ?>
					.mobile-menu-builder--links .mobile-menu-builder--label{
						font-family: "<?php echo esc_html( $options['font'] );?>";
					}
				<?php }?>


				/** Popup  */
				<?php if( !empty( $popupText_css ) ){ ?>
					body .mobile-menu-builder-popup--container .mobile-menu-builder-popup--inner .widget, body .mobile-menu-builder-popup--container .mobile-menu-builder-popup--inner .widget p, body .mobile-menu-builder-popup--container .mobile-menu-builder-popup--inner .widget li, body .mobile-menu-builder-popup--container .mobile-menu-builder-popup--inner .widget a{
						<?php echo $popupText_css;?>
					}
				<?php }?>
				<?php if( !empty( $popupTitle_css ) ){ ?>
					body .mobile-menu-builder-popup--container .mobile-menu-builder-popup--inner .widget h3.widgettitle{
						<?php echo $popupTitle_css;?>
					}
				<?php }?>
			</style>

	<?php } ?>
		<?php if( ( isset( $options['enablePopup'] ) && $options['enablePopup'] ) || is_customize_preview() ) { ?>
			<div class="mobile-menu-builder-popup--container" style="<?php echo $popup_css;?>">
				<div class="mobile-menu-builder-popup--inner <?php echo $innerClass;?>">
					<?php if ( is_active_sidebar( 'mobile-menu-builder-1' ) ){
						dynamic_sidebar( 'mobile-menu-builder-1' );
					}else{ ?>
						<style type="text/css" media="screen">
							.mobile-menu-builder-popup--inner>.customize-partial-edit-shortcut{
								display: block;
							}	
						</style>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
		<div class="mobile-menu-builder-customizer--container" style="<?php echo $container_css; ?>">
			<?php if( is_customize_preview() ){ ?>
				<div class="mobile-menu-builder-customizer--templates">
				</div>
				<div class="mobile-menu-builder-customizer--expander mobile-menu-builder--opener">
					<a href="#" class="ion-ios-expand"></a>
				</div>
			<?php }?>
			<div class="mobile-menu-builder-customizer--inner">
				<?php for ( $i = 1; $i <= $menu_count; $i++ ) { 

					if( !is_customize_preview() && !isset( $icons['menu-'. $i .'-icon'] ) && !isset( $label['menu-'. $i .'-label'] ) ){
						continue;
					}
					//check url matching
					$current_class	= '';
					if( isset( $links['menu-'. $i .'-link'] ) ){
						$parse_url  = parse_url( $links['menu-'. $i .'-link'] );
						$path		= $parse_url['path'];

						if( isset( $current_url['host'] ) ){
							$parse_url['path'] = trim( $parse_url['path'], '/' );
							//check url matching
							if( !isset( $parse_url['host'] ) || $parse_url['host'] == $current_url['host'] ){
								if( ( is_home() || is_front_page() ) && ( $parse_url['path'] == '/' || !isset( $parse_url['path'] ) || empty( $parse_url['path'] ) ) ){
									$current_class = 'mobile-menu-builder--current-page';
								}
							}
							if( isset( $parse_url['path'] ) && isset( $current_url['path'] ) ){
								if( $parse_url['path'] == $current_url['path'] ){
									$current_class = 'mobile-menu-builder--current-page';
								}
							}
						}
					}

					//add classes
					$menu_class = '';
					if( !isset( $icons['menu-'. $i .'-icon'] ) || empty( $icons['menu-'. $i .'-icon'] ) ){
						$menu_class .= ' mobile-menu-builder--noicon';
					}

					if( !isset( $label['menu-'. $i .'-label'] ) || empty( $label['menu-'. $i .'-label'] ) ){
						$menu_class .= ' mobile-menu-builder--nolabel';
					}

					if( isset( $options[ 'menu-'. $i .'-popup' ] ) && !empty( $options[ 'menu-'. $i .'-popup' ] ) ){
						$menu_class .= ' mobile-menu-builder--opener';
					}

					?>
					<div class="mobile-menu-builder--links mobile-menu-builder--link-<?php echo $i;?> <?php echo $current_class;?> <?php echo $menu_class;?>" style="">
						<a href="<?php echo ( isset( $links['menu-'. $i .'-link'] ) ) ? $links['menu-'. $i .'-link'] : '#'; ?>">
							<?php if( is_customize_preview() ){ ?>
								<i class="mobile-menu-builder--icon <?php echo ( isset( $icons['menu-'. $i .'-icon'] ) ) ? $icons['menu-'. $i .'-icon'] : '';?>" style="<?php echo esc_html( $icon_css );?>"></i>
							<?php }else{
								$ion_icon = str_replace( 'ion-', '', $icons['menu-'. $i .'-icon'] );

								if ( isset( $icons['menu-'. $i .'-icon'] ) &&  $wp_filesystem->exists( MOBILE_MENU_BUILDER_PLUGIN_DIR . 'assets/svg/'. $ion_icon .'.svg' ) ) {
									$svg = $wp_filesystem->get_contents( MOBILE_MENU_BUILDER_PLUGIN_DIR . 'assets/svg/'. $ion_icon .'.svg' );
									echo '<span class="mobile-menu-builder--icon" style="'. esc_html( $icon_css ) .'">'.  str_replace( '<svg', '<svg style="'. $svg_css .'"', $svg ) . '</span>';
								}
							} ?>
							<span class="mobile-menu-builder--label" style="<?php echo esc_html( $label_css );?>"><?php echo ( isset( $label['menu-'. $i .'-label'] ) ) ? $label['menu-'. $i .'-label'] : '';?></span>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php 
		echo $html_contents = ob_get_clean();
		if( !is_customize_preview() && is_array( $options ) && isset( $options['cached'] ) && $options['cached'] ){
			set_transient( $this->transient_name , $html_contents, $this->cache_time );
		}
	}
}

Mobile_Menu_Builder_Display::register();
