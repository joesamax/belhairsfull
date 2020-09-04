<?php

defined('ABSPATH') || die();

if(isset($_POST['weblizar_page_anim_submit']) && isset($_POST['security'])) {
	if ( ! wp_verify_nonce( $_POST['security'], 'weblizar_saves_settings' ) ) {
        die();}
	$weblizar_page_in_trans		=	sanitize_option('weblizar_page_in_trans', $_POST['weblizar_page_in_trans']);
	$weblizar_page_out_trans	=	sanitize_option('weblizar_page_out_trans',$_POST['weblizar_page_out_trans']);
	$weblizar_page_in_durations	=	sanitize_text_field( $_POST['weblizar_page_in_durations']);
	$weblizar_page_out_durations =	sanitize_text_field( $_POST['weblizar_page_out_durations']);
	$weblizar_bg_clr			=	sanitize_text_field( $_POST['weblizar_bg_clr']);
	$weblizar_preload_txt_clr	=	sanitize_text_field( $_POST['weblizar_preload_txt_clr']);
	$weblizar_pre_load_delay	=	sanitize_text_field( $_POST['weblizar_pre_load_delay']);
	$weblizar_icon_pre_load		=	sanitize_text_field( $_POST['weblizar_icon_pre_load']);
	$weblizar_pre_load_switch	=	sanitize_text_field( $_POST['weblizar_pre_load_switch']);
	$weblizar_pg_anim_txt_append =	sanitize_text_field( $_POST['weblizar_pg_anim_txt_append']);

	$wl_page_trans_options['weblizar_page_in_trans']= $weblizar_page_in_trans;
	$wl_page_trans_options['weblizar_page_out_trans']= $weblizar_page_out_trans;
	$wl_page_trans_options['weblizar_page_in_durations']= intval($weblizar_page_in_durations);
	$wl_page_trans_options['weblizar_page_out_durations']= intval($weblizar_page_out_durations);
	$wl_page_trans_options['weblizar_bg_clr']= $weblizar_bg_clr;
	$wl_page_trans_options['weblizar_preload_txt_clr']=$weblizar_preload_txt_clr;
	$wl_page_trans_options['weblizar_pre_load_delay']= $weblizar_pre_load_delay;
	$wl_page_trans_options['weblizar_icon_pre_load']= $weblizar_icon_pre_load;
	$wl_page_trans_options['weblizar_pre_load_switch']= $weblizar_pre_load_switch;
	$wl_page_trans_options['weblizar_pg_anim_txt_append']= $weblizar_pg_anim_txt_append;

	update_option('wl_page_trans_options', $wl_page_trans_options );
}
$wl_page_trans_options = get_option('wl_page_trans_options'); 
?>

<div class="block ui-tabs-panel active" id="option-general">

			<div id="heading">
				<table><tr><td cols=2 ><h2>	<?php include('responsive-portfolio-banner.php'); ?><?php esc_html_e('Page Animations Settings',WL_PAT_DOMAIN);?></h2></td></tr></table>
			</div>	
			<form class="form-horizontal" role="form" action="#" method="POST" name="google_plus_form" >
				<?php $nonce = wp_create_nonce( 'weblizar_saves_settings' ); ?>
                        <input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">
		<div class="form-group">
			<div class="container">
				<div class="row">
					<div class="col-md-4">
					<label  ><?php esc_html_e('Page In Animations',WL_PAT_DOMAIN); ?></label>
					</div>
					<div class="col-md-8 pt-2">
					<?php  $weblizar_page_in_trans= $wl_page_trans_options['weblizar_page_in_trans']; ?>
					<select id="weblizar_page_in_trans" name="weblizar_page_in_trans" style="width:80%;" >
						<option value="none" <?php if ('none' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('None',WL_PAT_DOMAIN); ?></option>
						<option value="fade-in" <?php if ('fade-in' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade In',WL_PAT_DOMAIN); ?></option>
						<option value="fade-in-up" <?php if ('fade-in-up' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade In Up',WL_PAT_DOMAIN); ?></option>
						<option value="fade-in-down" <?php if ('fade-in-down' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade In Down',WL_PAT_DOMAIN); ?></option>
						<option value="fade-in-left" <?php if ('fade-in-left' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade In Left',WL_PAT_DOMAIN); ?></option>
						<option value="fade-in-right" <?php if ('fade-in-right' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade In Right',WL_PAT_DOMAIN); ?></option>
						<option value="rotate-in" <?php if ('rotate-in' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Rotate In',WL_PAT_DOMAIN); ?></option>
						<option value="flip-in-x" <?php if ('flip-in-x' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Flip In X',WL_PAT_DOMAIN); ?></option>
						<option value="flip-in-y" <?php if ('flip-in-y' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Flip In Y',WL_PAT_DOMAIN); ?></option>
						<option value="overlay-slide-in-bottom" <?php if ('overlay-slide-in-bottom' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Overlay Slide In Top',WL_PAT_DOMAIN); ?></option>
						<option value="overlay-slide-in-top" <?php if ('overlay-slide-in-top' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Overlay Slide In Bottom',WL_PAT_DOMAIN); ?></option>
						<option value="overlay-slide-in-right" <?php if ('overlay-slide-in-right' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Overlay Slide In Left',WL_PAT_DOMAIN); ?></option>
						<option value="overlay-slide-in-left" <?php if ('overlay-slide-in-left' == $weblizar_page_in_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Overlay Slide In Right',WL_PAT_DOMAIN); ?></option>							
					</select>
					<p class="help-block"><?php esc_html_e('Select Your Website Page In Animation',WL_PAT_DOMAIN); ?></p>
					</div>
					
				</div>
			
				
				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label><?php esc_html_e('Page Out Animations',WL_PAT_DOMAIN); ?></label>
				</div>
				<div class="col-sm-8">
						<?php $weblizar_page_out_trans= $wl_page_trans_options['weblizar_page_out_trans']; ?>
						<select name="weblizar_page_out_trans" id="weblizar_page_out_trans" style="width:80%;">
							<option value="none" <?php if ('none' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('None',WL_PAT_DOMAIN); ?></option>
							<option value="fade-out" <?php if ('fade-out' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade Out',WL_PAT_DOMAIN); ?></option>
							<option value="fade-out-up" <?php if ('fade-out-up' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade Out Up',WL_PAT_DOMAIN); ?></option>
							<option value="fade-out-down" <?php if ('fade-out-down' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade Out Down',WL_PAT_DOMAIN); ?></option>
							<option value="fade-out-left"  <?php if ('fade-out-left' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade Out Left',WL_PAT_DOMAIN); ?></option>
							<option value="fade-out-right" <?php if ('fade-out-right' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Fade Out Right',WL_PAT_DOMAIN); ?></option>
							<option value="rotate-out" <?php if ('rotate-out' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Rotate Out',WL_PAT_DOMAIN); ?></option>
							<option value="flip-out-x" <?php if ('flip-out-x' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Flip Out X',WL_PAT_DOMAIN); ?></option>
							<option value="flip-out-y" <?php if ('flip-out-y' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Flip Out Y',WL_PAT_DOMAIN); ?></option>
							<option value="zoom-out" <?php if ('zoom-out' == $weblizar_page_out_trans) echo 'selected="selected"'; ?>><?php esc_html_e('Zoom Out',WL_PAT_DOMAIN); ?></option>
							<option value="overlay-slide-out-bottom" <?php if ('overlay-slide-out-bottom' == $weblizar_page_out_trans) echo esc_html('selected="selected"'); ?>><?php esc_html_e('Overlay Slide Out Top',WL_PAT_DOMAIN); ?></option>
							<option value="overlay-slide-out-top" <?php if ('overlay-slide-out-top' == $weblizar_page_out_trans) echo esc_html('selected="selected"'); ?>><?php esc_html_e('Overlay Slide Out Bottom',WL_PAT_DOMAIN); ?></option>
							<option value="overlay-slide-out-right" <?php if ('overlay-slide-out-right' == $weblizar_page_out_trans) echo esc_html('selected="selected"'); ?>><?php esc_html_e('Overlay Slide Out Left',WL_PAT_DOMAIN); ?></option>
							<option value="overlay-slide-out-left" <?php if ('overlay-slide-out-left' == $weblizar_page_out_trans) echo esc_html('selected="selected"'); ?>><?php esc_html_e('Overlay Slide Out Right',WL_PAT_DOMAIN); ?></option>		
						</select>
						<p class="help-block"><?php esc_html_e('Select Your Website Page Out Animation',WL_PAT_DOMAIN); ?></p>
						<p class="help-block"><?php esc_html_e('Please set Page In and Page Out for Overlay Animation',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>

				
				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label><?php esc_html_e('Page In Durations',WL_PAT_DOMAIN); ?></label>
				</div>
					<div class="col-sm-8">
						<?php  $weblizar_page_in_durations= $wl_page_trans_options['weblizar_page_in_durations']; ?>
						<select name="weblizar_page_in_durations" id="weblizar_page_in_durations" style="width:80%;">
							<option value="200" <?php if ('200' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('200',WL_PAT_DOMAIN); ?></option>
							<option value="400" <?php if ('400' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('400',WL_PAT_DOMAIN); ?></option>
							<option value="600" <?php if ('600' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('600',WL_PAT_DOMAIN); ?></option>
							<option value="800" <?php if ('800' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('800',WL_PAT_DOMAIN); ?></option>
							<option value="1000" <?php if ('1000' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1000',WL_PAT_DOMAIN); ?></option>
							<option value="1200" <?php if ('1200' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1200',WL_PAT_DOMAIN); ?></option>
							<option value="1400" <?php if ('1400' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1400',WL_PAT_DOMAIN); ?></option>
							<option value="1600" <?php if ('1600' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1600',WL_PAT_DOMAIN); ?></option>
							<option value="1800" <?php if ('1800' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1800',WL_PAT_DOMAIN); ?></option>
							<option value="2000" <?php if ('2000' == $weblizar_page_in_durations) echo 'selected="selected"'; ?>><?php esc_html_e('2000',WL_PAT_DOMAIN); ?></option>
						</select>
						<p class="help-block"><?php esc_html_e('Select Your Website Page In Animation Durations(Speed)',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>
				
				
				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label ><?php esc_html_e('Page Out Durations',WL_PAT_DOMAIN); ?></label>
				</div>
					<div class="col-sm-8">
						<?php $weblizar_page_out_durations= $wl_page_trans_options['weblizar_page_out_durations']; ?>
						<select name="weblizar_page_out_durations" id="weblizar_page_out_durations" style="width:80%;">
							<option value="100" <?php if ('100' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('100',WL_PAT_DOMAIN); ?></option>
							<option value="200" <?php if ('200' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('200',WL_PAT_DOMAIN); ?></option>
							<option value="300" <?php if ('300' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('300',WL_PAT_DOMAIN); ?></option>
							<option value="400" <?php if ('400' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('400',WL_PAT_DOMAIN); ?></option>
							<option value="500" <?php if ('500' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('500',WL_PAT_DOMAIN); ?></option>
							<option value="600" <?php if ('600' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('600',WL_PAT_DOMAIN); ?></option>
							<option value="700" <?php if ('700' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('700',WL_PAT_DOMAIN); ?></option>
							<option value="800" <?php if ('800' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('800',WL_PAT_DOMAIN); ?></option>
							<option value="900" <?php if ('900' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('900',WL_PAT_DOMAIN); ?></option>
							<option value="1000" <?php if ('1000' == $weblizar_page_out_durations) echo 'selected="selected"'; ?>><?php esc_html_e('1000',WL_PAT_DOMAIN); ?></option>
						</select>
						<p class="help-block"><?php esc_html_e('Select Your Website Page Out Animation Durations(Speed)',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>

				<tr><td cols=2 ><h3 id='heading'><?php esc_html_e('Preloader Settings',WL_PAT_DOMAIN);?></h3></td></tr>
				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label><?php esc_html_e('Preloader On/Off',WL_PAT_DOMAIN); ?></label>
				</div>
					<div class="col-sm-8">
						<?php  
						if(isset($wl_page_trans_options['weblizar_pre_load_switch'])) {
							$weblizar_pre_load_switch= $wl_page_trans_options['weblizar_pre_load_switch']; 
						} else {
							$weblizar_pre_load_switch = "1";
						}
						?>
						<select name="weblizar_pre_load_switch" id="weblizar_pre_load_switch" style="width:40%;">
							<option value="1" <?php if ('1' == $weblizar_pre_load_switch) echo 'selected="selected"'; ?>><?php esc_html_e('Off',WL_PAT_DOMAIN); ?></option>
							<option value="2" <?php if ('2' == $weblizar_pre_load_switch) echo 'selected="selected"'; ?>><?php esc_html_e('On',WL_PAT_DOMAIN); ?></option>
						</select>
						<p class="help-block"><?php esc_html_e('If Preloader Off then Page Transition is not applied',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>

				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label ><?php esc_html_e('Preloader Text',WL_PAT_DOMAIN); ?></label>
				</div>
				
					<div class="col-sm-8">
						<?php  
						if(isset($wl_page_trans_options['weblizar_pg_anim_txt_append'])) {
							$weblizar_pg_anim_txt_append= $wl_page_trans_options['weblizar_pg_anim_txt_append']; 
						} else {
							$weblizar_pg_anim_txt_append = "Welcome in Weblizar Preloader";
						}
						?>
						<input type="text" name="weblizar_pg_anim_txt_append" id="weblizar_pg_anim_txt_append" style="width:80%;" value="<?php echo esc_attr($weblizar_pg_anim_txt_append); ?>">
					</div>
				</div>
				</div>

				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label  class="col-sm-4"><?php esc_html_e('Preloader Text Color',WL_PAT_DOMAIN); ?></label>
				</div>
					<div class="col-sm-8">
						<?php
							if(isset($wl_page_trans_options['weblizar_preload_txt_clr'])){
								$weblizar_preload_txt_clr= $wl_page_trans_options['weblizar_preload_txt_clr']; 
							} else {
								$weblizar_preload_txt_clr = "#fff";
							}
						?>
						<input id="weblizar_preload_txt_clr" name="weblizar_preload_txt_clr" type="text" value="<?php echo esc_attr($weblizar_preload_txt_clr); ?>" class="my-color-field" data-default-color="#000000" />
						<p class="help-block"><?php esc_html_e('Font Color of Preloader Text',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>

				<div class="form-group">
				<div class="row">
				<div class="col-md-4">
					<label  ><?php esc_html_e('Preloader Background Color',WL_PAT_DOMAIN); ?></label>
				</div>
					<div class="col-sm-8">
						<?php  
							if(isset($wl_page_trans_options['weblizar_bg_clr'])){
								$weblizar_bg_clr= $wl_page_trans_options['weblizar_bg_clr']; 
							} else {
								$weblizar_bg_clr = "#000000";
							}
						?>
						<input id="weblizar_bg_clr" name="weblizar_bg_clr" type="text" value="<?php echo esc_attr($weblizar_bg_clr); ?>" class="my-color-field" data-default-color="#000000" />
						<p class="help-block"><?php esc_html_e('Background Color of Preloader',WL_PAT_DOMAIN); ?></p>
					</div>
				</div>
				</div>
				


				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
								<label  ><?php esc_html_e('Delay Time of Preloader',WL_PAT_DOMAIN); ?></label>
							</div>
								<div class="col-sm-8">
									<?php  
										if(isset($wl_page_trans_options['weblizar_pre_load_delay'])){
											$weblizar_pre_load_delay = $wl_page_trans_options['weblizar_pre_load_delay'];
										} else {
											$weblizar_pre_load_delay = 5000;
										}
									?>
									<input  class="pganim-slider" type="range" min="1000" max="60000" step="1000" name="weblizar_pre_load_delay" id="weblizar_pre_load_delay" value="<?php echo esc_attr($weblizar_pre_load_delay); ?>" data-rangeSlider>
									<p class="pg-range-span">Second: <span id="pg-range-val"></span></p>
								</div>
							</div>
						</div>
					
			

				<script>
					var slider = document.getElementById("weblizar_pre_load_delay");
					var output = document.getElementById("pg-range-val");
					
					var x = slider.value;
					var y = x/1000;
				    output.innerHTML = y;
					
					slider.oninput = function() {
						var x = slider.value;
						var y = x/1000;
						output.innerHTML = y;
					}
				</script>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<label  ><?php esc_html_e('Preloader Icon', WL_PAT_DOMAIN); ?></label>
						</div>
					<div class="col-sm-8">
						<?php 
							if(isset($wl_page_trans_options['weblizar_icon_pre_load'])){
								$weblizar_icon_pre_load = $wl_page_trans_options['weblizar_icon_pre_load'];
							} else {
								$weblizar_icon_pre_load = 1;
							}
						 ?>
						<select name="weblizar_icon_pre_load" id="weblizar_icon_pre_load" style="width:40%;">
							<option value="1" <?php if ('1' == $weblizar_icon_pre_load) echo 'selected="selected"'; ?>><?php esc_html_e('Icon 1',WL_PAT_DOMAIN); ?></option>
							<option value="2" <?php if ('2' == $weblizar_icon_pre_load) echo 'selected="selected"'; ?>><?php esc_html_e('Icon 2',WL_PAT_DOMAIN); ?></option>
							<option value="3" <?php if ('3' == $weblizar_icon_pre_load) echo 'selected="selected"'; ?>><?php esc_html_e('Icon 3',WL_PAT_DOMAIN); ?></option>
							<option value="4" <?php if ('4' == $weblizar_icon_pre_load) echo 'selected="selected"'; ?>><?php esc_html_e('Icon 4',WL_PAT_DOMAIN); ?></option>
							<option value="5" <?php if ('5' == $weblizar_icon_pre_load) echo 'selected="selected"'; ?>><?php esc_html_e('Icon 5',WL_PAT_DOMAIN); ?></option>
						</select>
					</div>
				</div>
			</div>

				<div class="form-group">
					<label  class="col-sm-4"><?php esc_html_e('Preloader Element',WL_PAT_DOMAIN); ?></label>
					<div class="col-sm-8">					
						<p class="wlpat_options"><?php
							if( is_ssl() ){
								$header_file_url = admin_url("theme-editor.php?file=header.php", "https");
							} else {
								$header_file_url = admin_url("theme-editor.php?file=header.php", "http");
							}
							$preloader_element = esc_html('now after <body> insert Preloader HTML element: <div id="page-anim-preloader"></div>');
						?> <?php esc_html_e('Open',WL_PAT_DOMAIN); ?><a target="_blank" href="<?php echo esc_attr($header_file_url); ?>"><?php esc_html_e('header.php',WL_PAT_DOMAIN); ?></a> <?php esc_html_e('file for your theme',WL_PAT_DOMAIN); ?>, <?php echo esc_html($preloader_element); ?>
						</p>
					</div>
				</div>				
				<div class="form-group col-md-offset-4">
					<div class="">
					  <button type="submit" class="btn btn-primary" name="weblizar_page_anim_submit" id="weblizar_page_anim_submit" value="submit"><?php esc_html_e('Save Changes',WL_PAT_DOMAIN); ?></button>
					</div>
				</div>
			</form>
			</div>
	</div>	
</div>
<!---------------- footer customization Settings form ------------------------>
<div class="block ui-tabs-panel deactive" id="option-offers" >
	<?php include('offers.php');?>
</div>