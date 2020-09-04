<?php



	/* New Code */
	

if(!class_exists('qrstr')){
	include('phpqrcode/phpqrcode.php');
}
if(!class_exists('QR_Code_Settings_WCS')){
	class QR_Code_Settings_WCS 
	{
		private $rest_api_url;
		private $plugin_url;
		private $plugin_dir;
		
	
		function __construct($plugin_dir, $plugin_url, $rest_api_url)
		{
			$this->rest_api_url = $rest_api_url;
			$this->plugin_url = $plugin_url;
			$this->plugin_dir = $plugin_dir;		
			$this->execute_settings_api();
		}
	
		function api_read_settings($param){
	
			$login_key = $param['login_key'];	
			$login_key_status = $this->validate_login_key($login_key);
			
	
			// if($login_key == base64_decode('MTIz')){			
				if($login_key_status == true){
	
				$args = array(
					"numberposts" => -1,
					"post_status" => "publish",
					"post_type" => "product"
				);
				$products = get_posts($args);
				$settings_array = array_map(function($product){
					$settings = array();
					$wc_product = wc_get_product($product->ID);
					$product_price = $wc_product->get_price();
					$currency = get_woocommerce_currency();
					$currency_symbol = get_woocommerce_currency_symbol($currency);
					$product_price = number_format($product_price,2);
					$settings['product_id'] = $product->ID;
					$settings['product_name'] = $product->post_title." - ".html_entity_decode($currency_symbol).$product_price;
					$coming_soon_meta = get_post_meta($product->ID,'_coming_soon',true);
					if(!empty($coming_soon_meta)){
						$settings['_coming_soon'] = $coming_soon_meta;
					}else{
						$settings['_coming_soon'] = "false";
					}
					return $settings;
				},$products);
				
				$res = new WP_REST_Response($settings_array);
				return $res;
			}
			
	
				
	
	
	
		}
	
		function register_api_read_settings(){		
			
			register_rest_route( $this->rest_api_url, '/read_epn_settings', array(
	
			  'methods' => 'POST',
	
			  'callback' => array($this, 'api_read_settings'),
	
			));
		}
		
		function api_update_settings($param){			
	
			$login_key = $param['login_key'];
			$login_key_status = $this->validate_login_key($login_key);
			$update_epn_settings = array(
	
				'writeSettingsStatus' => 'Not OK'		
	
			);		
			// if($login_key == base64_decode('MTIz')){
			if($login_key_status == true){			
	
	
				$jsonSettings = $param['jsonSettings'];
	
				if(!empty($jsonSettings)){
	
					$woo_cs_Settings = json_decode($jsonSettings, true);
	
					$update_woo_cs_settings = array_map(function($setting){
						$update_status = update_post_meta($setting['product_id'],"_coming_soon",$setting['_coming_soon']);
						
						if($update_status == false){
							return false;
						}elseif($update_status == true){
							return true;
						}else{
							return true;
						}
					},$woo_cs_Settings);					
	
					$update_epn_settings['writeSettingsStatus'] = 'done';
					$update_epn_settings['login_key'] = 'valid';				
	
				}			
	
			}else{
				$update_epn_settings['login_key'] = 'invalid';
			}
	
			$res = new WP_REST_Response($update_epn_settings);
			return $res;
			
		}
	
		function register_api_update_settings() {		
	
			register_rest_route( $this->rest_api_url, '/update_epn_settings', array(
	
			  'methods' => 'POST',
	
			  'callback' => array($this,'api_update_settings'),
	
			));
		}
	
		private function get_login_key_option_name(){
			$login_key_option_name = str_replace(" ", "_", get_bloginfo());
			$login_key_option_name = $login_key_option_name."_login_key";
			return $login_key_option_name;
		}
	
		private function generate_random_login_key(){
	
			$login_key_option_name = $this->get_login_key_option_name();		
			$login_key_array = get_option($login_key_option_name);
			$rand_login_key = md5(rand());
			
	
			if(empty($login_key_array)){
				$rand_key_update_status =	update_option($login_key_option_name, array($rand_login_key));
			}else{
				$login_key_array[] = $rand_login_key;
				$rand_key_update_status =	update_option($login_key_option_name, $login_key_array);
			}
	
			if($rand_key_update_status == true){
				return	$rand_login_key;
			}else{
				return false;
			}
		}	
	
		private function validate_login_key($login_key){
	
			$login_key_option_name = $this->get_login_key_option_name();
			$login_key_array = get_option($login_key_option_name);
			// $login_key_array = array("a7749324bf84d8e7ae248562832d24d5");
			$login_key_match_result = array_search($login_key, $login_key_array);
			if($login_key_match_result >= 0){
				return true;
			}else{
				return false;
			}
		}
		
		function qrhash_authentication_settings($param){
	
			
	
			$result_array = array(
	
				"request_status" => "rejected",
	
				"login_key" => "null",
	
				"settings_name" => "null"
	
			);
	
	
	
			if(isset($param['qr_hash'])){				
	
				
	
				$qr_hash_call = $param['qr_hash'];
	
				$qr_hash_option = get_option('epn_qrcode_hash');				
	
				$epn_qrcode_hash = $qr_hash_option['epn_qrcode_hash'];
	
				// $epn_qrcode_hash = "a";
	
				$epn_qrcode_hash_time = $qr_hash_option['epn_qrcode_hash_time'];
	
				
	
				if($epn_qrcode_hash == $qr_hash_call){
	
					$rand_login_key = $this->generate_random_login_key();				
	
					if($rand_login_key != false){
						$result_array["request_status"] = "active";
						$result_array["login_key"] = $rand_login_key;
						$result_array["settings_name"] = get_bloginfo();
					}
	
				}			
	
			
	
			}
	
	
	
			$res = new WP_REST_Response($result_array);			
	
			return $res;
	
		}
	
		function register_qrhash_authentication_settings() {		
	
			
	
			register_rest_route( $this->rest_api_url, '/authentication', array(
	
			  'methods' => 'POST',
	
			  'callback' => array($this,'qrhash_authentication_settings'),
	
			));
		}	
	
		function generate_qrcode_ajax() { ?>
	
			<script type="text/javascript" language="javascript">
	
	
	
				jQuery(document).ready(function($) {
	
	
	
					var qrSample = $(".epn-qrcode-body .epn-qrcode-view .qr-sample");
	
					var modal = $(".epn-qrcode-body .qr-modal");
	
					var qrcode_img = $('.epn-qrcode-body .epn-qrcode-img');
	
					var modal_close = $('.epn-qrcode-body .qr-modal .qr-modal-close');
	
					var interval = null;
	
	
	
					var data = {
	
						'action': 'generate_qrcode'
	
						
	
					};
	
	
	
					var get_qrcode = function (){
	
	
	
						jQuery.post(ajaxurl, data, function(response, status) {							
	
							
	
							if(status == 'success'){
	
								qrcode_img.html(response);
	
							}
	
	
	
						});
	
					}
	
					
	
					var clear_interval = function (){
	
						clearInterval(interval);
	
						qrcode_img.html('<span class="qr-loading">Loading....</span>');
	
					}
	
					
	
					qrSample.on("click", function(){
	
						modal.css("display","block");
	
						$(get_qrcode);
	
						interval = setInterval(get_qrcode, 1000*60);
	
					})
	
	
	
					modal.on("click", function(e){
	
						
	
						if(e.target == modal[0]){
	
							modal.css("display","none");
	
							$(clear_interval);
	
						}
	
							
	
						
	
					})
	
	
	
					modal_close.on("click", function(){
	
						modal.click();
	
					});
	
	
	
					$(document).keyup(function(e) {
	
						
	
						if (e.keyCode === 27){
	
								modal.click();
	
								$(clear_interval);
	
						}
	
					});
	
					
	
					
	
					
	
					
	
				});
	
	
	
			</script> 
	
			<?php
	
		}
	
		function generate_qrcode() {
	
						
	
			$tempDir = $this->plugin_dir."io/barcode/";
			if(!file_exists($tempDir)){
				mkdir($tempDir);
			}
			$url = $this->plugin_url."io/barcode/";		
				
			
			$files = glob($tempDir.'*'); // get all file names		
	
			if(!empty($files)){
	
				foreach($files as $file){ // iterate files
	
				if(is_file($file))
	
					unlink($file); // delete file
	
				}
	
			}
	
			
	
			$epn_qrcode_hash_array = array();
	
			$codeContents = array();
	
			$rand_no = rand();
	
			$rand_no_qr = md5($rand_no);
	
			$codeContents['url'] = get_home_url()."/wp-json/".$this->rest_api_url."/";
			// $codeContents['url'] = "http://192.168.43.248:82/wp-json/".$this->rest_api_url."/";
	
			$codeContents['qr_hash'] = $rand_no_qr;
	
			$epn_qrcode_hash_array['epn_qrcode_hash_time'] = time()+30;
	
			$epn_qrcode_hash_array['epn_qrcode_hash'] = $codeContents['qr_hash'];
	
			update_option('epn_qrcode_hash',$epn_qrcode_hash_array);
	
	
	
			$qr_content = json_encode($codeContents);
	
			$fileName = 'barcode'.rand().'.png';
	
			$pngAbsoluteFilePath = $tempDir.$fileName;		
	
			QRcode::png($qr_content, $pngAbsoluteFilePath,QR_ECLEVEL_L,10);
			
			echo '<img src="'.$url.$fileName.'" />';
	
	
	
			wp_die();
	
	
	
		}
	
	
		private function execute_settings_api(){
	
			add_action( 'rest_api_init', array($this, 'register_api_read_settings'));
			add_action( 'rest_api_init', array($this, 'register_api_update_settings'));
			add_action( 'rest_api_init', array($this, 'register_qrhash_authentication_settings'));
			add_action( 'wp_ajax_generate_qrcode', array($this,'generate_qrcode') );
			add_action( 'admin_footer', array($this, 'generate_qrcode_ajax') );
		}
	
	
		
	
		public static function ab_io_display($plugin_url){
			
		
	
			?>
			<style>
				.epn-qrcode-body .epn-qrcode-view{
	
					float: left;
					width: 240px;
					height: 100px;	
					clear: both;
					cursor: pointer;
					position: relative;
					
				}
	
				.epn-qrcode-body .epn-qrcode-view .qr-sample {
	
					width: auto;
					height: 50px;
					position: absolute;
					right: 0;
					top: 12px;
	
				}
	
				.epn-qrcode-body .epn-qrcode-view .google-badge-img {
					width: auto;
					height: 75px;
					top: 0;
					position:absolute;
	
				}
	
				.epn-qrcode-body .qr-modal{
					display: none;
					position:fixed;
					z-index: 50000;
					top:0;
					left:0;
					width: 100%;
					height:100%;
					overflow: auto;
					background-color: rgb(0,0,0);
					background-color: rgba(0,0,0,0.6);
				}
	
	
				.epn-qrcode-body .qr-modal .modal-content {
	
					margin: auto;	
					width: 40%;
					text-align: center;
					padding-top: 100px;
	
				}
	
				.epn-qrcode-body .qr-modal .modal-content .qr-loading {
	
					font-size: 2rem;
					color: white;
				} 
	
	
				.epn-qrcode-body .epn-qrcode-img img {
					widows: 100%;
					height: auto;
				}
	
				.epn-qrcode-body .qr-modal .qr-modal-close {
					color: tomato;
					float: right;
					font-size: 50px;
					/* font-weight: bold; */
					margin-top: 50px;
					margin-right: 50px;
	
				}
	
				.epn-qrcode-body .qr-modal .qr-modal-close:hover,
				.epn-qrcode-body .qr-modal .qr-modal-close:focus {
					color: #000;
					text-decoration: none;
					cursor: pointer;
				}
	
			</style>
			<div class="epn-qrcode-body">
	
	
	
				<div class="epn-qrcode-view">
	
	
	
					<img class="qr-sample" title="Click here to Scan QR Code!" src="<?php echo $plugin_url.'io/sample.png' ?>">
	
					<div class="google-badge">
	
	
	
						<a target="_blank" href='https://play.google.com/store/apps/details?id=woo.coming.soon'>
	
							<img class="google-badge-img" alt='Get it on Google Play' src='https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png' />
	
						</a>
	
	
	
					</div>
	
				</div>
	
				
	
	
	
				<div class="qr-modal">
	
					<span class="qr-modal-close">&times;</span>
	
					<!-- Modal content -->
	
					<div class="modal-content">
	
						
	
						<div class="epn-qrcode-img">
	
							<span class="qr-loading">Loading....</span>
	
						</div>
	
					</div>
	
	
	
				</div>
	
	
	
			</div>
	
			<?php		
	
		}
	
	
	}	


}