<?php

if ( class_exists( 'WP_Customize_Control' ) ) {

	class TM_Customize_Iconpicker_Control extends WP_Customize_Control {

		/**
		 * Render the control's content.
		 */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>
				<div class="input-group icp-container">
					<input data-placement="bottomRight" class="icp icp-auto" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" type="text" readonly="readonly" />
					<span class="input-group-addon"></span>
				</div>
			</label>
			<?php
		}

		/**
		 * Enqueue required scripts and styles.
		 */
		public function enqueue() {
			wp_enqueue_script( 'tm-fontawesome-iconpicker', MOBILE_MENU_BUILDER_PLUGIN_URL . 'includes/customizer/controls/icon-picker/assets/js/fontawesome-iconpicker.min.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'tm-iconpicker-control', MOBILE_MENU_BUILDER_PLUGIN_URL . 'includes/customizer/controls/icon-picker/assets/js/iconpicker-control.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_style( 'tm-fontawesome-iconpicker', MOBILE_MENU_BUILDER_PLUGIN_URL . 'includes/customizer/controls/icon-picker/assets/css/fontawesome-iconpicker.min.css' );
			wp_enqueue_style( 'tm-fontawesome', MOBILE_MENU_BUILDER_PLUGIN_URL . 'includes/customizer/controls/icon-picker/assets/css/ionicons.min.css' );
		}

	}

}