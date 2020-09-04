(function($) {
	$.fn.mutated = function(cb, e) {
		e = e || { subtree:true, childList:true, characterData:true };
		$(this).each(function() {
			function callback(changes) { cb.call(node, changes, this); }
			var node = this;
			(new MutationObserver(callback)).observe(node, e);
		});
	};
})(jQuery);


(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 */

	$(function() {

		// wc_cart_fragments_params is required to continue, ensure the object exists
		if ( typeof wc_cart_fragments_params === 'undefined' ) {
			return false;
		}

		/* Storage Handling */
		var $supports_html5_storage;
		var cart_hash_key = wc_cart_fragments_params.ajax_url.toString() + '-wc_cart_hash';

		try {
			$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
			window.sessionStorage.setItem( 'wc', 'test' );
			window.sessionStorage.removeItem( 'wc' );
			window.localStorage.setItem( 'wc', 'test' );
			window.localStorage.removeItem( 'wc' );
		} catch( err ) {
			$supports_html5_storage = false;
		}

		var isTouch = touchSupport();

		var wooNotices = $('.woocommerce-notices-wrapper:first');
		var cartNotices = $('.xt_woofc-notices-wrapper');

		//store jQuery objects
		var customizer,
			cartAnimation,
			cartContainer = $('.xt_woofc'),
			addToCartBtn,
			singleAddToCartBtn,
			cartHeaderNotif,
			cartInner,
			cartWrapper,
			cartHeader,
			cartBody,
			cartBodyHeader,
			cartBodyFooter,
			cartListWrap,
			cartList,
			cartTotal,
			cartTrigger,
			cartCheckoutButton,
			cartCount,
			cartSpinner,
			cartError,
			cartMenu,
			cartMenuLink,
			undo,
			couponToggle,
			couponRemoveBtn,
			couponForm,
			cartErrorTimeoutId,
			undoTimeoutId,
			addTimeoutId,
			winWidth,
			cartWidth,
			cartActive = false,
			cartTransitioning = false,
			cartRefreshing = false,
			isReady = false,
			viewMode = 'desktop',
			couponsEnabled = false,
			totalsEnabled = false,
			suggestedProductsSlider,
			ajaxInit = cartContainer.attr('data-ajax-init') === '1',
			expressCheckout = cartContainer.attr('data-express-checkout') === '1',
			triggerevent = cartContainer.attr('data-triggerevent'),
			hoverdelay = cartContainer.attr('data-hoverdelay') ? cartContainer.attr('data-hoverdelay') : 0;


		if(isTouch && triggerevent === 'mouseenter') {
			triggerevent = 'vclick';
		}

		function initVars() {

			cartAnimation = cartContainer.attr('data-animation');
			customizer = (typeof(wp) !== 'undefined' && typeof(wp.customize) !== 'undefined');
			addToCartBtn = $('.add_to_cart_button');
			singleAddToCartBtn = $('form .single_add_to_cart_button, .variations .single_add_to_cart_button');
			wooNotices = $('.woocommerce-notices-wrapper');
			cartNotices = $('.xt_woofc-notices-wrapper');
			cartHeaderNotif = $('.xt_woofc-notif');
			cartContainer = $('.xt_woofc');
			cartInner = cartContainer.find('.xt_woofc-inner');
			cartWrapper = cartInner.find('.xt_woofc-wrapper');
			cartHeader = cartContainer.find('.xt_woofc-header');
			cartBody = cartContainer.find('.xt_woofc-body');
			cartBodyHeader = cartBody.find('.xt_woofc-body-header');
			cartBodyFooter = cartBody.find('.xt_woofc-body-footer');
			cartListWrap = cartBody.find('.xt_woofc-list-wrap');
			cartList = cartListWrap.find('ul.xt_woofc-list');
			cartTrigger = cartContainer.find('.xt_woofc-trigger');
			cartCount = cartTrigger.find('.xt_woofc-count');
			cartCheckoutButton = cartContainer.find('.xt_woofc-checkout');
			cartTotal = cartCheckoutButton.find('span.amount');
			cartSpinner = cartContainer.find('.xt_woofc-spinner-wrap');
			cartError = cartContainer.find('.xt_woofc-cart-error');
			undo = cartContainer.find('.xt_woofc-undo');
			totalsEnabled = cartContainer.hasClass('xt_woofc-enable-totals');
			couponsEnabled = cartContainer.hasClass('xt_woofc-enable-coupon');
			cartMenu = $('.xt_woofc-menu');
			cartMenuLink = $('.xt_woofc-menu-link');

			if(couponsEnabled) {
				couponToggle = cartContainer.find('.xt_woofc-coupon');
				couponRemoveBtn = cartContainer.find('.xt_woofc-remove-coupon');
				couponForm = cartContainer.find('.xt_woofc-coupon-form');
			}

		}

		function showLoading() {
			$('html').addClass('xt_woofc-loading');
		}

		function hideLoading() {
			$('html').removeClass('xt_woofc-loading');
		}

		function init() {

			if( !cartContainer.length ) {
				return false;
			}

			initVars();
			setListHeight();

			// Remove unwanted ajax request (cart form submit) coming from native cart script.
			if(totalsEnabled || expressCheckout) {

				$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
					if (originalOptions.url === '#woocommerce-cart-form') {
						jqXHR.abort();
					}
				});
			}

			// Make sure to burst the cache and refresh the cart after a browser back button event
			$(window).on('pageshow', function() {

				if(!isReady && !cartRefreshing) {
					refreshCart(function () {

						cartReady();
					});
				}
			});

			$(window).on('resize', function(){

				window.requestAnimationFrame(onResize);

			});
			onResize();

			// Fix for some custom themes
			$('form .add_to_cart_button').each(function() {
				$(this).removeClass('add_to_cart_button').addClass('single_add_to_cart_button');
			});

			$(document.body).on('added_to_cart', function(evt, fragments, cart_hash, btn){

				if(fragments && !cartHasErrors(fragments)) {

					addToCart(btn, fragments);
					setListHeight();
				}
			});

			// Remove alerts on click
			$(document.body).on('vclick', '.woocommerce-error, .woocommerce-message', function() {

				$(this).slideUp(function() {
					$(this).remove();
				});
			});

			// Update Cart List Obj
			$(document.body).on('wc_fragments_refreshed wc_fragments_loaded', function() {

				initVars();
				removeUnwantedElements();
				setListHeight();
				refreshCartVisibility();
				resetCheckoutButtonLabel();

				if(XT_WOOFC.can_use_premium_code && XT_WOOFC.suggested_products_enabled) {

					initSuggestedProductsSlider();
				}
			});

			//open/close cart
			cartTrigger.on('vclick', function(evt){
				evt.preventDefault();
				toggleCart();
			});

			if(triggerevent === 'mouseenter') {

				var mouseEnterTimer;
				cartTrigger.on('mouseenter', function(evt){

					mouseEnterTimer = setTimeout(function () {

						if(!cartActive) {
							evt.preventDefault();
							toggleCart();
						}

					}, hoverdelay);

				}).on('mouseleave', function() {

					clearTimeout(mouseEnterTimer);
				});

			}


			//close cart when clicking on the .xt_woofc::before (bg layer)
			cartContainer.on('vclick', function(evt){
				if( $(evt.target).is($(this)) ) {
					toggleCart(true);
				}
			});

			//close cart when clicking on the header close icon
			cartHeader.find('.xt_woofc-header-close').on('vclick', function(evt) {
				if( $(evt.target).is($(this)) ) {
					toggleCart(true);
				}
			});


			//delete an item from the cart
			cartBody.on('vclick', '.xt_woofc-delete-item', function(evt){
				evt.preventDefault();

				var key = $(evt.target).parents('.xt_woofc-product').data('key');
				removeProduct(key);
			});

			//update item quantity

			$( document ).on('change', '.xt_woofc-quantity input', function(evt) {

				evt.preventDefault();

				var $parent = $( this ).parent();
				var min = parseFloat( $( this ).attr( 'min' ) );
				var max	= parseFloat($( this ).attr( 'max' ) );

				if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {

					$( this ).val( min );
					showError(XT_WOOFC.lang.min_qty_required, $parent);
					return;

				}else if ( max && max > 0 && parseFloat( $( this ).val() ) > max ) {

					$( this ).val( max );
					showError(XT_WOOFC.lang.max_stock_reached, $parent);
					return;

				}

				var product = $(this).closest('.xt_woofc-product');
				var qty = $(this).val();
				var key = product.data('key');

				updateProduct(key, qty);

			});


			$( document ).on( 'vclick', '.xt_woofc-quantity-up, .xt_woofc-quantity-down', function(evt) {

				evt.preventDefault();

				// Get values

				var $parent 	= $( this ).closest( '.xt_woofc-quantity' ),
					$qty		= $parent.find( 'input' ),
					currentVal	= parseFloat( $qty.val() ),
					max			= parseFloat( $qty.attr( 'max' ) ),
					min			= parseFloat( $qty.attr( 'min' ) ),
					step		= $qty.attr( 'step' ),
					newQty		= currentVal;

				// Format values
				if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) {
					currentVal = 0;
				}
				if ( max === '' || max === 'NaN' ) {
					max = '';
				}
				if ( min === '' || min === 'NaN' ) {
					min = 0;
				}
				if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) {
					step = 1;
				}


				// Change the value
				if ( $( this ).is( '.xt_woofc-quantity-up' ) ) {

					if ( max && ( max === currentVal || currentVal > max ) ) {
						newQty = ( max );
						showError(XT_WOOFC.lang.max_stock_reached, $parent);
						return;
					} else {
						newQty = ( currentVal + parseFloat( step ) );
					}

				} else {

					if ( min && ( min === currentVal || currentVal < min ) ) {
						newQty = ( min );
						showError(XT_WOOFC.lang.min_qty_required, $parent);
						return;
					} else if ( currentVal > 0 ) {
						newQty = ( currentVal - parseFloat( step ) );
					}

				}

				// Trigger change event

				var product = $qty.closest('.xt_woofc-product');
				var key = product.data('key');

				if(currentVal !== newQty) {

					// Update product quantity
					updateProduct(key, newQty);
				}

			});


			//reinsert item deleted from the cart
			undo.on('vclick', 'a', function(evt){
				if(undoTimeoutId) {
					clearInterval(undoTimeoutId);
				}
				evt.preventDefault();

				var timeout = 0;

				var product = cartList.find('.xt_woofc-deleted');

				product.each(function(i) {

					var $this = $(this);

					timeout = timeout + 300;

					setTimeout(function() {

						$this.addClass('xt_woofc-undo-deleted');

					}, timeout);

				});

				animationEnd(product, true, function(el) {

					el.removeClass('xt_woofc-deleted xt_woofc-undo-deleted').removeAttr('style');

					var key = undo.data('key');

					undoProductRemove(key, function() {

						$( document.body ).trigger( 'xt_woofc_undo_product_remove', [ key ] );

					});
					refreshCartVisibility();

				});

				setTimeout(function() {
					undo.removeClass('xt_woofc-visible');
					showCouponToggle();
				});

			});

			$(document).on('wc_update_cart', function (e) {

				refreshCart();
			});

			if(XT_WOOFC.can_use_premium_code || (typeof(XT_WOOVS) !== 'undefined' && XT_WOOVS.can_use_premium_code)) {

				//single add product to cart
				$(document).on('click', singleAddToCartBtn.selector, function (evt) {

					var btn = $(this);

					if (btn.hasClass('disabled')) {
						return false;
					}

					if (skipAddToCart(btn)) {
						return true;
					}

					evt.preventDefault();
					evt.stopPropagation();

					if (validateAddToCart(btn)) {
						addToCart(btn);
					}
				});
			}

			if(XT_WOOFC.can_use_premium_code) {

				$( document.body ).on('updated_cart_totals', function(e) {

					if($('form.woocommerce-shipping-calculator').length) {
						$('form.woocommerce-shipping-calculator').slideUp();
					}
				});

				if(expressCheckout || totalsEnabled) {

					$(document).on('updated_wc_div', function (e) {

						setTimeout(function() {
							hideLoading();
						}, 800);
					});

					$( document ).ajaxComplete(function( event, xhr, settings ) {

						if ( settings.url.search('/?wc-ajax=checkout') !== -1 ) {

							resetCheckoutButtonLabel();
						}
					});

					$(document).on('select2:open', '.xt_woofc-body .woocommerce-shipping-calculator #calc_shipping_country', function (e) {

						var $form = $(e.target).closest('form');

						$form.find('input:text, textarea').val('');
						$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
					});

					$(document).on('select2:open', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', 'hidden');
					});

					$(document).on('select2:select', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', '');
						cartBody.off('scroll.select2-' + e.target.id);
					});

					$(document).on('select2:close', '.xt_woofc-body .select2-hidden-accessible', function (e) {

						cartBody.css('overflow', '');
						cartBody.off('scroll.select2-' + e.target.id);
					});
				}

				$(document).on('vclick', cartCheckoutButton.selector, function (e) {

					showProcessingCheckoutButtonLabel();
				});


				if(expressCheckout) {

					$(document.body).on('xt_woofc_added_to_cart', function(){
						$( document.body ).trigger( 'update_checkout' );
					});

					$(document.body).on('update_checkout', function(){

						removeAllAlerts();
						showLoading();
						setListHeight();
					});

					$(document.body).on('checkout_error updated_checkout', function(){

						hideLoading();
						removeUnwantedElements();
						scrollToAlert();
						setListHeight();
					});

					$(document.body).on('click', 'a.showlogin', function(e) {

						var $this = $(e.target);

						setTimeout(function() {

							var $div = cartBody.find('.woocommerce-form-login').first();

							if($div.length && $div.is(':visible')) {
								cartBody.animate({scrollTop: (cartBody.scrollTop() + $this.position().top) - 10}, 500);
							}
						}, 500);
					});

					if(XT_WOOFC.can_checkout) {

						$(document).on('vclick', cartCheckoutButton.selector, function (e) {

							var order_btn = cartBody.find('[name="woocommerce_checkout_place_order"]');

							if(order_btn.length) {
								order_btn.trigger('click');

								showLoading();
								e.preventDefault();
							}
						});

						$(document).off('click', '.shipping-calculator-button');
						$(document).on('click', '.xt_woofc-cart-totals .shipping-calculator-button', function (e) {

							e.preventDefault();

							var use_shipping_address = cartBody.find('#ship-to-different-address-checkbox').is(':checked');
							var $div = use_shipping_address ? cartBody.find('.woocommerce-shipping-fields').first() : cartBody.find('.woocommerce-billing-fields').first();

							if ($div.length) {
								cartBody.animate({scrollTop: (cartBody.scrollTop() + $div.position().top) - 10}, 500);
							}
						});

					}
				}

				if(!!XT_WOOFC.cart_menu_enabled && XT_WOOFC.cart_menu_click_action === 'toggle') {
					$(document).on('click', cartMenuLink.selector, function (event) {
						event.preventDefault();
						toggleCart();
					});
				}
			}

			initMutationObserver();
			setTriggerDefaultText();
			refreshCartCountSize();
			removeUnwantedElements();

			if(ajaxInit) {

				refreshCart(function () {

					cartReady();
				});

			}else{

				cartReady();
			}

		}

		function setListHeight() {

			var listHeight = 0;
			cartList.children().each(function() {
				listHeight += $(this).height();
			});

			cartList.css({'min-height': listHeight+'px'});

			if(!!XT_WOOFC.can_use_premium_code && !!XT_WOOFC.cart_autoheight) {

				var autoHeight = cartBodyHeader.outerHeight(true) + cartListWrap.outerHeight(true) + cartBodyFooter.outerHeight(true) + cartCheckoutButton.outerHeight(true) + cartHeader.outerHeight(true);

				cartInner.css('height', autoHeight + 'px');

			}else{

				cartInner.css('height', '');
			}
		}

		function onResize() {

			winWidth = $(window).width();
			cartWidth = cartWrapper.width();

			if(winWidth <= XT_WOOFC.layouts.S) {

				cartContainer.removeClass('xt_woofc-is-desktop xt_woofc-is-tablet');
				cartContainer.addClass('xt_woofc-is-mobile');
				viewMode = 'mobile';

			}else if(winWidth <= XT_WOOFC.layouts.M) {

				cartContainer.removeClass('xt_woofc-is-desktop xt_woofc-is-mobile');
				cartContainer.addClass('xt_woofc-is-tablet');
				viewMode = 'tablet';

			}else{

				cartContainer.removeClass('xt_woofc-is-mobile xt_woofc-is-tablet');
				cartContainer.addClass('xt_woofc-is-desktop');
				viewMode = 'desktop';
			}

			if(cartWidth <= 400) {

				cartContainer.addClass('xt_woofc-narrow-cart');
			}else{

				cartContainer.removeClass('xt_woofc-narrow-cart');
			}

			if(XT_WOOFC.can_use_premium_code && XT_WOOFC.suggested_products_enabled) {

				refreshSuggestedProductsSlider();
			}

			setListHeight();

		}

		function initMutationObserver() {

			if(isReady) {
				return false;
			}

			$('body').mutated(function(changes, observer) {

				if(isReady) {
					return false;
				}

				changes.some(function(change) {

					return Array.prototype.slice.call(change.addedNodes).some(function(item) {

						if($(item).hasClass('single_add_to_cart_button')) {

							initVars();
							setTriggerDefaultText();
							setListHeight();

							return true;
						}

					})

				})

			});
		}

		function setTriggerDefaultText() {

			if(singleAddToCartBtn.length > 0) {

				singleAddToCartBtn.each(function() {

					$(this).data('defaultText', $(this).html().trim());

					if($(this).data('defaultText') !== '') {
						$(this).html(XT_WOOFC.lang.wait);
					}

					$(this).data('loading', true).addClass('loading');

				});
			}
		}

		function resetTriggerDefaultText() {

			singleAddToCartBtn.each(function() {

				$(this).removeData('loading').removeClass('loading');

				if($(this).data('defaultText') !== '') {
					$(this).html($(this).data('defaultText'));
				}

			});
		}

		function transitionEnd(el, once, callback) {

			var events = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';

			if(once) {

				el.one(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});

			}else{

				el.on(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});
			}
		}

		function animationEnd(el, once, callback) {

			var events = 'webkitAnimationEnd oanimationend oAnimationEnd msAnimationEnd animationend';

			if(once) {

				el.one(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});

			}else{

				el.on(events, function() {

					$(this).off(events);

					//evt.preventDefault();
					callback($(this));
				});
			}
		}

		function skipAddToCart(btn) {

			if(btn.closest('.wc-product-table').length) {

				return true;
			}

			return false;
		}

		function cartHasErrors(fragments) {

			if(fragments && fragments.hasOwnProperty('.woocommerce-notices-wrapper') && $(fragments['.woocommerce-notices-wrapper']).length) {

				return $(fragments['.woocommerce-notices-wrapper']).find('.woocommerce-error').length > 0;
			}
			return false;
		}

		function validateAddToCart(btn) {

			// validate required options from multiple plugins

			var form = btn.closest('form');
			var errors = 0;

			// Check if has quantity
			var $qty = form.find('.quantity .qty:visible');

			if($qty.length) {

				$qty.closest('.quantity').removeClass('xt_woofc-error');

				if (parseInt($qty.val()) === 0) {

					$qty.closest('.quantity').addClass('xt_woofc-error');
					errors++;
				}
			}

			// https://woocommerce.com/products/product-add-ons/
			var $elements = form.find('.wc-pao-required-addon, .required-product-addon');

			// https://codecanyon.net/item/woocommerce-extra-product-options/7908619
			$elements = $.merge(
				$elements,
				form.find('.tm-has-required + div.tm-extra-product-options-container').not('.tc-hidden div.tm-extra-product-options-container')
			);

			// https://wordpress.org/plugins/woocommerce-product-addon/
			$elements = $.merge(
				$elements,
				form.find('.ppom-field-wrapper .show_required').closest('.form-group')
			);

			// https://woocommerce.com/products/gravity-forms-add-ons/
			$elements = $.merge(
				$elements,
				form.find('.gfield_contains_required')
			);

			$elements.each(function() {

				var $row = $(this);

				if($row.is(':visible')) {
					var $input = $row.find(':input');

					if ($input.attr('type') === 'checkbox' || $input.attr('type') === 'radio') {
						$row.removeClass('xt_woofc-error');
						if (!$input.is(':checked')) {
							errors++;
							$row.addClass('xt_woofc-error');
						}
					} else {
						$row.removeClass('xt_woofc-error');
						if ($input.val() === '') {
							errors++;
							$row.addClass('xt_woofc-error');
						}
					}
				}else{
					$row.removeClass('xt_woofc-error');
				}
			});

			if(errors > 0) {
				var $firstError = form.find('.xt_woofc-error').first();
				var inQuickView = $firstError.closest('.xt-woo-quick-view').length > 0;
				var scroll_selector = inQuickView ? '.xt_wooqv-item-info' : 'html,body';

				if($firstError.length) {
					$(scroll_selector).animate({scrollTop: $firstError.offset().top - 100}, 500);
				}
			}

			return (errors === 0);
		}

		function toggleCart(bool) {

			if(cartTransitioning) {
				return false;
			}

			cartTransitioning = true;
			var cartIsOpen = ( typeof bool === 'undefined' ) ? cartContainer.hasClass('xt_woofc-cart-open') : bool;

			if( cartIsOpen ) {
				cartContainer.removeClass('xt_woofc-cart-open');
				cartContainer.addClass('xt_woofc-cart-close');
				cartActive = false;

				if(XT_WOOFC.can_use_premium_code && XT_WOOFC.body_lock_scroll) {
					bodyScrollLock.enableBodyScroll(cartBody.get(0));
				}

				resetUndo();
				resetCouponForm();
				showCouponToggle();

				setTimeout(function(){
					cartBody.scrollTop(0);
					//check if cart empty to hide it
					refreshCartVisibility();

					if(XT_WOOFC.can_use_premium_code && XT_WOOFC.suggested_products_enabled) {
						destroySuggestedProductsSlider();
					}

				}, 500);

			} else {
				cartContainer.removeClass('xt_woofc-cart-close');
				cartContainer.addClass('xt_woofc-cart-open');
				cartActive = true;

				if(XT_WOOFC.can_use_premium_code) {

					if(XT_WOOFC.body_lock_scroll) {
						bodyScrollLock.disableBodyScroll(cartBody.get(0));
					}

					if(XT_WOOFC.suggested_products_enabled) {

						initSuggestedProductsSlider();
					}
				}
			}

			transitionEnd(cartContainer, true, function() {
				cartTransitioning = false;
				if( !cartIsOpen ) {
					cartContainer.addClass('xt_woofc-cart-opened');
					cartContainer.removeClass('xt_woofc-cart-closed');
				}else{
					cartContainer.removeClass('xt_woofc-cart-opened');
					cartContainer.addClass('xt_woofc-cart-closed');
				}
			});

			setTimeout(function(){
				cartTransitioning = false;
				refreshCartVisibility();
			}, 500)
		}

		function addToCart(trigger, fragments) {

			fragments = typeof(fragments) !== 'undefined' ? fragments : null;

			if(addTimeoutId){
				clearInterval(addTimeoutId);
			}

			if(trigger.data('loading')) {
				return false;
			}

			trigger.removeClass('added');
			trigger.data('loading', true);
			trigger.addClass('loading');

			var type;
			var single = trigger.hasClass('single_add_to_cart_button');
			var single_variation = false;

			if(single) {
				single_variation = trigger.closest('.variations').length;
			}

			var args = {};

			if(!single || fragments) {

				type = 'add';
				args = {
					fragments: fragments
				};

			}else{

				type = 'single-add';
				var form = trigger.closest('form');
				args = form.serializeJSON();

				if(typeof args === 'string') {
					args = $.parseJSON(args);
				}

				if(typeof args === 'object') {
					args['add-to-cart'] = form.find('[name="add-to-cart"]').val();
				}
			}


			//update cart product list
			request(type, args, function(data) {

				if(!cartHasErrors(data.fragments)) {

					if(XT_WOOFC.can_use_premium_code) {

						if (cartContainer.attr('data-flytocart') === '1' && !cartActive) {

							animateAddToCart(trigger, single, single_variation);

						} else if (!single_variation) {

							animateCartShake();
						}
					}

					trigger.removeClass('loading').addClass('added');
					trigger.removeData('loading');

					// Trigger single added to cart event manually. Used by tracking plugins such as FB Pixel and others
					if(type === 'single-add') {
						$(document.body).trigger('added_to_cart', [null, null, trigger]);
					}

					$( document.body ).trigger( 'xt_woofc_added_to_cart', [ data ] );

				}else{

					trigger.removeClass('loading');
					trigger.removeData('loading');
				}

			});

			//show cart
			refreshCartVisibility();
		}

		function getCartPosition(viewMode) {

			var position_key = viewMode !== 'desktop' ? 'data-'+viewMode+'-position' : 'data-position';

			return cartContainer.attr(position_key);
		}

		function animateAddToCart(trigger, single, single_variation) {

			var item;
			var productsContainer = $('body');
			var position = getCartPosition(viewMode);

			if(!single) {

				item = findLoopImage(trigger);

			}else{

				item = findSingleImage(trigger);
			}

			if(!item || item.length === 0) {

				return false;
			}

			var itemPosition = item.offset();
			var triggerPosition = cartTrigger.offset();

			if(itemPosition.top === 0 && itemPosition.left === 0) {

				var products = trigger.closest('.products');
				var product = trigger.closest('.product');
				var single_main_product = single && products.length === 0;

				if(single_main_product && product.length) {
					itemPosition = product.offset();
				}else{
					itemPosition = trigger.offset();
					itemPosition.top = itemPosition.top - item.height();

					if(single_main_product) {
						itemPosition.left = itemPosition.left - item.width();
					}
				}
			}

			var defaultState = {
				opacity: 1,
				top: itemPosition.top,
				left: itemPosition.left,
				width: item.width(),
				height: item.height(),
				transform: 'scale(1)'
			};

			var top_dir = 0;
			var left_dir = 0;

			if(position === 'bottom-right') {

				top_dir = -1;
				left_dir = -1;

			}else if(position === 'bottom-left') {

				top_dir = -1;
				left_dir = 1;

			}else if(position === 'top-right') {

				top_dir = 1;
				left_dir = -1;

			}else if(position === 'top-left') {

				top_dir = 1;
				left_dir = 1;
			}

			var animationState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2) + (trigger.height() * top_dir),
				left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2) + (trigger.width() * left_dir),
				opacity: 0.9,
				transform: 'scale(0.5)'
			};

			var inCartState = {
				top: triggerPosition.top + (cartTrigger.height() / 2) - (defaultState.height / 2),
				left: triggerPosition.left + (cartTrigger.width() / 2) - (defaultState.width / 2),
				opacity: 0,
				transform: 'scale(0)'
			};

			var duplicatedItem = item.clone();
			duplicatedItem.find('.add_to_cart_button').remove();
			duplicatedItem.css(defaultState);
			duplicatedItem.addClass('xt_woofc-fly-to-cart');

			duplicatedItem.appendTo(productsContainer);

			var flyAnimationDuration = cartContainer.attr('data-flyduration') ? cartContainer.attr('data-flyduration') : 650;
			flyAnimationDuration = (parseInt(flyAnimationDuration) / 1000);

			xt_gsap.to(duplicatedItem, flyAnimationDuration, { css: animationState, ease: Power3.easeOut, onComplete:function() {

				animateCartShake();

				xt_gsap.to(duplicatedItem, (flyAnimationDuration * 0.8), { css: inCartState, ease: Power3.easeOut, onComplete: function() {

					$(duplicatedItem).remove();

				}});

			}});
		}

		function animateCartShake() {

			var shakeClass = cartContainer.attr('data-shaketrigger');

			if(shakeClass !== '') {
				cartInner.addClass('xt_woofc-shake-'+shakeClass);

				animationEnd(cartInner, false, function(_trigger) {

					cartInner.removeClass('xt_woofc-shake-'+shakeClass);

					if(cartContainer.attr('data-opencart-onadd') === '1') {
						toggleCart(false);
					}

				});
			}
		}


		function findLoopImage(trigger) {

			var item = null;

			if(trigger.closest('.product').length) {

				var product = trigger.closest('.product');

				var selectors = [
					'.attachment-woocommerce_thumbnail',
					'.woocommerce-placeholder',
					'.wp-post-image',
					'img[srcset]',
					'img'
				].join(',');

				if (product.find(selectors).length) {

					item = product.find(selectors).first();
				}
			}

			if(!item || item.length === 0) {

				item = createFlyToCartImage(trigger);
			}

			return item;
		}

		function findSingleImage(trigger) {

			var item = null;
			var id = findSingleProductId(trigger);

			// If Woo Product Table, Find Row Image
			if(trigger.closest('.wc-product-table').length) {

				if(trigger.closest('.product-row').find('.product-table-image').length) {

					item = trigger.closest('.product-row').find('.product-table-image');

					// If Woo Product Table, Mobile View Find Row Image
				}else if(trigger.closest('tr').prev('.product-row').find('.product-table-image').length) {

					item = trigger.closest('tr').prev('.product-row').find('.product-table-image');
				}

				// If Woo Product Table, Find Row Image
			}else if(trigger.closest('.variations').find('.image_link img').length) {

				item = trigger.closest('.variations').find('.image_link img');

				// Find image in Woo Quick View Modal
			}else if(trigger.closest('.xt-woo-quick-view').length) {

				item = $('.xt_wooqv-slider-wrapper .xt_wooqv-slider li img').first();

				// Find image in Product Quick View Modal
			}else if(trigger.closest('.product-quick-view-container').length) {

				item = trigger.closest('.product-quick-view-container').find('.slide.first img');

				// Find image in single product page
			}else if(trigger.closest('.product').length) {

				var product = trigger.closest('.product');

				var selectors = [
					'img.size-woocommerce_thumbnail',
					'.magic-slide',
					'.woocommerce-product-gallery .woocommerce-product-gallery__image',
					'.images img',
					'img[srcset]',
					'img'
				].join(',');

				if (product.find(selectors).length) {

					item = product.find(selectors).first();
				}
			}

			if((!item || item.length === 0) && $('.xt_woofc-product-image[data-product_id="'+id+'"]').length) {

				item = createFlyToCartImage($('.xt_woofc-product-image[data-product_id="'+id+'"]'));
			}

			return item;
		}

		function findSingleProductId(trigger) {

			var id;

			if(trigger.attr('name') === 'add-to-cart' && trigger.val() !== '') {

				id = trigger.val();

			}else {

				var form = trigger.closest('form');
				if (form.length) {

					if (form.find('input[name=product_id]').length) {
						id = form.find('input[name=product_id]').val();
					} else if (form.find('input[name=add-to-cart]').length) {
						id = form.find('input[name=add-to-cart]').val();
					}
				}
			}

			return id;
		}

		function createFlyToCartImage(fromElem) {

			var item = null;

			if(fromElem.data('product_image_src')) {

				item = $('<img>');
				item.attr('src', fromElem.data('product_image_src'));
				item.attr('width', fromElem.data('product_image_width'));
				item.attr('height', fromElem.data('product_image_height'));

				item.css({
					width: fromElem.data('product_image_width') + 'px',
					height: fromElem.data('product_image_height') + 'px'
				});
			}

			return item;
		}

		function request(type, args, callback) {

			hideHeaderMessages();
			resetCouponForm();
			showCouponToggle();

			if(type !== 'refresh') {
				removeAllAlerts();
			}

			showLoading();

			if(type !== 'remove' && type !== 'undo') {
				undo.removeClass('xt_woofc-visible');
			}

			if(type === 'refresh' || type === 'totals') {

				refreshFragments(type, callback);
				return false;

			}else if(type === 'add') {

				onRequestDone(args, type, callback);
				return false;

			}

			var params = {
				type: type
			};

			params = $.extend(params, args);

			$.XT_Ajax_Queue({

				url: get_url('xt_woofc_update_cart'),
				data: params,
				type: 'post'

			}).done(function(data) {

				onRequestDone(data, type, callback);

			});

		}

		function refreshFragments(type, callback) {

			$.XT_Ajax_Queue({
				url: get_url('get_refreshed_fragments'),
				data: {
					type: type
				},
				type: 'post'

			}).done(function(data) {

				onRequestDone(data, type, callback);
			});
		}

		function onRequestDone(data, type, callback) {

			$.each( data.fragments, function( key, value ) {

				$(key).replaceWith(value);
			});

			if(XT_WOOFC.can_use_premium_code && expressCheckout){
				$(document.body).trigger('wc_address_i18n_ready');
			}

			// If cart has errors, scroll to error
			if(cartHasErrors(data.fragments) && wooNotices.length) {

				// Close Quick View
				if(typeof(xt_wooqv_close) !== 'undefined') {
					xt_wooqv_close();
				}
				$('html,body').animate({scrollTop: wooNotices.offset().top - 100}, 500);
			}

			if ( $supports_html5_storage ) {
				sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(data.fragments));
				set_cart_hash(data.cart_hash);

				if (data.cart_hash) {
					set_cart_creation_timestamp();
				}
			}

			$(document.body).trigger('wc_fragments_refreshed');
			setListHeight();

			var loadingTimout = cartContainer.attr('data-loadingtimeout') ? parseInt(cartContainer.attr('data-loadingtimeout')) : 0;

			setTimeout(function() {
				$('html').addClass('xt_woofc-stoploading');
				setTimeout(function() {
					hideLoading();
					$('html').removeClass('xt_woofc-stoploading');

					if(typeof(callback) !== 'undefined') {
						callback(data);
					}

				}, loadingTimout);
			}, 100);

		}

		function updateProduct(key, qty, callback) {

			if(qty > 0) {

				request('update', {

					cart_item_key: key,
					cart_item_qty: qty

				}, function(data) {

					$( document.body ).trigger( 'xt_woofc_product_update', [ key, qty ] );

					if(typeof(callback) !== 'undefined') {
						callback(data);
					}

				});

			}else{
				removeProduct(key, callback);
			}
		}

		function removeProduct(key, callback) {

			request('remove', {

				cart_item_key: key

			}, function() {

				resetUndo();
				resetCouponForm();
				showCouponToggle();
				removeAllAlerts();

				var product = cartList.find('li[data-key="'+key+'"]');

				if(product.length > 0) {

					var isBundle = product.hasClass('xt_woofc-bundle');
					var isComposite = product.hasClass('xt_woofc-composite');
					var topPosition = product.offset().top - cartBody.find('ul').offset().top;
					var selector = '';

					product.css('top', topPosition+'px');

				}

				if(isBundle || isComposite) {

					var group_id = product.data('key');

					if(isBundle) {
						selector = '.xt_woofc-bundled-item[data-group="'+group_id+'"]';
					}else{
						selector = '.xt_woofc-composite-item[data-group="'+group_id+'"]';
					}

					var groupedProducts = $(cartList.find(selector).get().reverse());

					groupedProducts.addClass('xt_woofc-deleted');
				}

				product.addClass('xt_woofc-deleted');
				refreshCartVisibility();

				hideCouponToggle();
				undo.data('key', key).addClass('xt_woofc-visible');

				$( document.body ).trigger( 'xt_woofc_product_removed', [ key ] );


				//wait 8sec before completely remove the item
				undoTimeoutId = setTimeout(function(){

					resetUndo();
					resetCouponForm();
					showCouponToggle();

					if(typeof(callback) !== 'undefined') {
						callback();
					}

				}, 8000);

			});
		}

		function showCouponToggle() {

			if(couponsEnabled) {
				couponToggle.addClass('xt_woofc-visible');
			}

			cartHeaderNotif.removeClass('xt_woofc-visible');
		}

		function hideCouponToggle() {

			if(couponsEnabled) {
				couponToggle.removeClass('xt_woofc-visible');
			}

			cartHeaderNotif.addClass('xt_woofc-visible');
		}

		function resetCouponForm() {

			if(couponsEnabled && couponForm.is(':visible')) {
				couponForm.slideUp();
			}
		}

		function resetUndo() {

			if(undoTimeoutId) {
				clearInterval(undoTimeoutId);
			}

			undo.removeData('key').removeClass('xt_woofc-visible');
			cartList.find('.xt_woofc-deleted').remove();

		}

		function undoProductRemove(key, callback) {

			request('undo', {

				cart_item_key: key,

			}, callback);
		}

		function refreshCart(callback) {

			if(!cartRefreshing) {

				cartRefreshing = true;
				request('refresh', {}, function() {

					cartRefreshing = false;

					if(typeof(callback) !== 'undefined') {
						callback();
					}
				});
			}
		}

		function refreshCartVisibility() {

			initVars();

			var is_empty;

			if( cartList.find('li:not(.xt_woofc-deleted):not(.xt_woofc-no-product)').length === 0) {
				cartContainer.addClass('xt_woofc-empty');
				is_empty = true;
			}else{
				cartContainer.removeClass('xt_woofc-empty');
				is_empty = false;
			}

			if(!!XT_WOOFC.cart_menu_enabled && cartMenu.length) {

				if(is_empty) {
					cartMenu.addClass('xt_woofc-menu-empty');
				}else{
					cartMenu.removeClass('xt_woofc-menu-empty');
				}
			}
		}

		function refreshCartCountSize() {

			var quantity = Number(cartCount.find('li').eq(0).text());

			if(quantity > 99) {
				cartCount.addClass('xt_woofc-count-big');
			}else{
				cartCount.removeClass('xt_woofc-count-big');
			}
		}

		/* Cart session creation time to base expiration on */
		function set_cart_creation_timestamp() {
			if ( $supports_html5_storage ) {
				sessionStorage.setItem( 'wc_cart_created', ( new Date() ).getTime() );
			}
		}

		/** Set the cart hash in both session and local storage */
		function set_cart_hash( cart_hash ) {
			if ( $supports_html5_storage ) {
				localStorage.setItem( cart_hash_key, cart_hash );
				sessionStorage.setItem( cart_hash_key, cart_hash );
			}
		}

		function hideHeaderMessages() {

			if(cartErrorTimeoutId) {
				clearInterval(cartErrorTimeoutId);
			}

			undo.removeClass('xt_woofc-visible');
			cartError.removeClass('xt_woofc-visible');

			hideCouponToggle();
		}


		function showError(error, elemToShake) {

			hideHeaderMessages();

			if(typeof(elemToShake) !== 'undefined') {
				elemToShake.removeClass('xt_woofc-shake');
			}

			cartError.removeClass('xt_woofc-shake xt_woofc-visible');
			setTimeout(function() {

				cartError.text(error).addClass('xt_woofc-visible');

				transitionEnd(cartError, true, function() {

					cartError.addClass('xt_woofc-shake');

					if(typeof(elemToShake) !== 'undefined') {
						elemToShake.addClass('xt_woofc-shake');
					}

					animationEnd(cartError, true, function() {

						cartError.removeClass('xt_woofc-shake');

						cartErrorTimeoutId = setTimeout(function() {

							cartError.removeClass('xt_woofc-visible');

							showCouponToggle();

						}, 5000);
					});
				});

			},100);

		}


		function removeUnwantedElements() {

			if(cartBody.find('.woocommerce-cart-form').length > 1) {
				cartBody.find('.woocommerce-cart-form').each(function(i) {
					if(i > 0) {
						$(this).remove();
					}
				});
				cartBody.find('.woocommerce-cart-form').empty();
			}

			if(cartBody.find('.woocommerce-notices-wrapper').length) {
				cartBody.find('.woocommerce-notices-wrapper').remove();
			}

			if(cartBody.find('.woocommerce-form-coupon,.woocommerce-form-coupon-toggle').length) {
				cartBody.find('.woocommerce-form-coupon,.woocommerce-form-coupon-toggle').remove();
			}

			if(totalsEnabled && !expressCheckout && cartBody.find('.angelleye-proceed-to-checkout-button-separator').length) {

				setTimeout(function() {
					cartBody.find('.angelleye-proceed-to-checkout-button-separator').insertAfter(cartBody.find('.angelleye_smart_button_bottom'));
				},100);
			}
		}

		function removeAllAlerts() {

			var $alerts = $(cartBodyHeader, cartBodyFooter).find('.woocommerce-error, .woocommerce-message');
			if($alerts.length) {
				$alerts.each(function() {
					$(this).slideUp(function() {
						$(this).remove();
					});
				});
			}
		}

		function initSuggestedProductsSlider(){

			destroySuggestedProductsSlider();

			suggestedProductsSlider = $('.xt_woofc-sp-products').lightSlider({
				item: 1,
				enableDrag: false,
				adaptiveHeight: true,
				controls: (!!XT_WOOFC.suggested_products_enabled),
				prevHtml: '<span class="xt_woofc-sp-arrow-icon '+XT_WOOFC.suggested_products_arrow+'"></span>',
				nextHtml: '<span class="xt_woofc-sp-arrow-icon '+XT_WOOFC.suggested_products_arrow+'"></span>',
				onSliderLoad: function() {

					setTimeout(function() {
						$(window).trigger('resize');
						setTimeout(function() {
							$('.xt_woofc-sp').css('opacity', 1);
						}, 300);
					}, 200);
				}
			});
		}

		function destroySuggestedProductsSlider() {

			if(suggestedProductsSlider && typeof(suggestedProductsSlider.destroy) !== 'undefined') {
				$('.xt_woofc-sp').css('opacity', 0);
				suggestedProductsSlider.destroy();
			}
		}

		function refreshSuggestedProductsSlider() {

			if(suggestedProductsSlider && typeof(suggestedProductsSlider.refresh) !== 'undefined') {
				suggestedProductsSlider.refresh();
			}

		}

		function scrollToAlert() {

			setTimeout(function() {

				var $alert = cartBodyFooter.find('.woocommerce-error, .woocommerce-message').first();

				if($alert.length) {
					cartBody.animate({scrollTop: (cartBody.scrollTop() + $alert.position().top) - 10}, 500);
				}
			},500)

		}

		function showProcessingCheckoutButtonLabel() {

			if(cartCheckoutButton.hasClass('xt_woofc-processing')) {
				return false;
			}

			cartCheckoutButton.addClass('xt_woofc-processing');

			var processing_text = cartCheckoutButton.data('processing-text');
			cartCheckoutButton.find('.xt_woofc-footer-label').text(processing_text);
		}

		function resetCheckoutButtonLabel() {

			var text = cartCheckoutButton.data('text');
			cartCheckoutButton.find('.xt_woofc-footer-label').text(text);

			cartCheckoutButton.removeClass('xt_woofc-processing');
		}

		function touchSupport() {

			if ('ontouchstart' in document.documentElement) {
				$('html').addClass('xt_woofc-touchevents');
				return true;
			}

			$('html').addClass('xt_woofc-no-touchevents');

			return false;
		}

		function cartReady() {

			resetTriggerDefaultText();

			$('body').addClass('xt_woofc-ready');

			$(document).trigger('xt_woofc_ready');

			isReady = true;
		}

		function get_url ( endpoint ) {
			return XT_WOOFC.wc_ajax_url.toString().replace(
				'%%endpoint%%',
				endpoint
			);
		}


		$(function() {

			init();

			if(XT_WOOFC.can_use_premium_code && couponsEnabled) {

				var wc_checkout_coupons = {
					init: function () {
						$(document.body).on('vclick', couponToggle.selector, this.show_coupon_form);
						$(document.body).on('vclick', couponRemoveBtn.selector, this.remove_coupon);
						couponForm.hide().submit(this.submit);
					},
					show_coupon_form: function (e) {
						e.preventDefault();

						cartBody.animate({
							scrollTop: 0
						}, 'fast');

						couponForm.slideToggle(400, function () {
							couponForm.find(':input:eq(0)').focus();
						});
					},
					submit: function (e) {

						e.preventDefault();

						var $form = $(this);

						if ($form.is('.processing')) {
							return false;
						}

						$form.addClass( 'processing' );

						showLoading();

						var data = {
							coupon_code: $form.find('input[name="coupon_code"]').val()
						};

						$.XT_Ajax_Queue({
							url: get_url('xt_woofc_apply_coupon'),
							data: data,
							type: 'post'

						}).done(function(response) {

							$form.removeClass( 'processing' );

							setTimeout(function() {

								$form.slideUp();

								onRequestDone(response, 'apply_coupon');
								$(document.body).trigger('coupon_applied');

								hideLoading();

							},5);
						});

						return false;
					},
					remove_coupon: function (e) {
						e.preventDefault();

						var coupon = $(this).data('coupon');
						var container = $(this).closest('.xt_woofc-cart-totals');

						if (container.is('.processing')) {
							return false;
						}

						container.addClass( 'processing' );

						showLoading();

						var data = {
							coupon: coupon
						};

						$.XT_Ajax_Queue({
							url: get_url('xt_woofc_remove_coupon'),
							data: data,
							type: 'post'

						}).done(function(response) {

							container.removeClass( 'processing' );

							onRequestDone(response, 'remove_coupon');
							$(document.body).trigger('coupon_removed');

							// Remove coupon code from coupon field
							$('form.xt_woofc-coupon-form').find('input[name="coupon_code"]').val('');

							hideLoading();

						});

					}
				};

				wc_checkout_coupons.init();

			}

			if(XT_WOOFC.can_use_premium_code && (totalsEnabled || expressCheckout)) {

				/**
				 * Update the .woocommerce div with a string of html.
				 *
				 * @param {String} html_str The HTML string with which to replace the div.
				 * @param {bool} preserve_notices Should notices be kept? False by default.
				 */
				var update_wc_div = function( html_str, preserve_notices ) {
					var $html       = $.parseHTML( html_str );
					var $new_form   = $( '.woocommerce-cart-form', $html );
					var $new_totals = $( '.cart_totals', $html );
					var $notices    = $( '.woocommerce-error, .woocommerce-message, .woocommerce-info', $html );

					// Remove errors
					if ( ! preserve_notices ) {
						$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();
					}

					if ( $new_form.length === 0 ) {

						// No items to display now! Replace all cart content.
						var $cart_html = $( '.cart-empty', $html ).closest( '.woocommerce' );
						$( '.woocommerce-cart-form__contents' ).closest( '.woocommerce' ).replaceWith( $cart_html );

						// Display errors
						if ( $notices.length > 0 && cartNotices.length ) {
							cartNotices.prepend( $notices );
						}

						// Notify plugins that the cart was emptied.
						$( document.body ).trigger( 'wc_cart_emptied' );
					} else {
						// If the checkout is also displayed on this page, trigger update event.
						if ( $( '.woocommerce-checkout' ).length ) {
							$( document.body ).trigger( 'update_checkout' );
						}

						$( '.woocommerce-cart-form' ).replaceWith( $new_form );
						$( '.woocommerce-cart-form' ).find( ':input[name="update_cart"]' ).prop( 'disabled', true );

						if ( $notices.length > 0 && cartNotices.length) {
							cartNotices.prepend($notices);
						}

						update_cart_totals_div( $new_totals );
					}

					$( document.body ).trigger( 'updated_wc_div' );
				};

				/**
				 * Update the .cart_totals div with a string of html.
				 *
				 * @param {String} html_str The HTML string with which to replace the div.
				 */
				var update_cart_totals_div = function( html_str ) {
					$( '.cart_totals' ).replaceWith( html_str );
					$( document.body ).trigger( 'updated_cart_totals' );
				};


				/**
				 * Object to handle AJAX calls for cart shipping changes.
				 */
				var cart_shipping = {

					/**
					 * Initialize event handlers and UI state.
					 */
					init: function (cart) {
						this.cart = cart;
						this.toggle_shipping = this.toggle_shipping.bind(this);
						this.shipping_method_selected = this.shipping_method_selected.bind(this);
						this.shipping_calculator_submit = this.shipping_calculator_submit.bind(this);

						$(document).off('click', '.shipping-calculator-button');
						$(document).on(
							'click',
							'.xt_woofc .shipping-calculator-button',
							this.toggle_shipping
						);

						$(document).off('click', 'select.shipping_method, :input[name^=shipping_method]');
						$(document).on(
							'change',
							'.xt_woofc select.shipping_method, .xt_woofc :input[name^=shipping_method]',
							this.shipping_method_selected
						);

						$(document).off('submit', 'form.woocommerce-shipping-calculator');
						$(document).on(
							'submit',
							'.xt_woofc form.woocommerce-shipping-calculator',
							this.shipping_calculator_submit
						);

						cartBody.find('.shipping-calculator-form').hide();
					},

					/**
					 * Toggle Shipping Calculator panel
					 */
					toggle_shipping: function () {
						cartBody.find('.shipping-calculator-form').slideToggle('slow');
						$(document.body).trigger('country_to_state_changed'); // Trigger select2 to load.
						return false;
					},

					/**
					 * Handles when a shipping method is selected.
					 */
					shipping_method_selected: function () {
						var shipping_methods = {};

						cartBody.find('select.shipping_method, :input[name^=shipping_method][type=radio]:checked, :input[name^=shipping_method][type=hidden]').each(function () {
							shipping_methods[$(this).data('index')] = $(this).val();
						});

						showLoading();

						var data = {
							shipping_method: shipping_methods
						};

						$.ajax({
							type: 'post',
							url: get_url('xt_woofc_update_shipping_method'),
							data: data,
							dataType: 'json',
							success: function (response) {
								update_cart_totals_div(response);
								onRequestDone(response, 'update_shipping_method');
							},
							complete: function () {
								hideLoading();
								$(document.body).trigger('updated_shipping_method');
							}
						});
					},

					/**
					 * Handles a shipping calculator form submit.
					 *
					 * @param {Object} evt The JQuery event.
					 */
					shipping_calculator_submit: function (evt) {
						evt.preventDefault();

						var $form = $(evt.currentTarget);

						showLoading();

						// Provide the submit button value because wc-form-handler expects it.
						$('<input />').attr('type', 'hidden')
							.attr('name', 'calc_shipping')
							.attr('value', 'x')
							.appendTo($form);

						// Make call to actual form post URL.
						$.ajax({
							type: $form.attr('method'),
							url: $form.attr('action'),
							data: $form.serialize(),
							dataType: 'html',
							success: function (response) {
								update_wc_div(response);
							},
							complete: function () {
								hideLoading();
							}
						});
					}
				};

				cart_shipping.init();

			}

			if(customizer) {

				if(XT_WOOFC.can_use_premium_code) {

					var requireVarUpdate = [
						{
							key: 'cart_autoheight_enabled',
							var: 'cart_autoheight'
						},
					];

					var requireCartRefresh = [
						'shake_trigger',
						'loading_spinner',
						'open_cart_on_product_add',
						'cart_product_link_to_single',
						'cart_product_show_sku',
						'cart_product_show_bundled_products',
						'cart_product_show_bundled_products',
						'cart_product_show_composite_products',
						'cart_product_show_attributes',
						'cart_product_attributes_hide_label',
						'cart_menu_click_action'
					];

					var requireWindowResize = [
						'animation_type',
						'hoffset',
						'hoffset_tablet',
						'hoffset_mobile',
						'voffset',
						'voffset_tablet',
						'voffset_mobile',
						'cart_width',
						'cart_height',
						'cart_width_tablet',
						'cart_height_tablet',
						'cart_width_mobile',
						'cart_height_mobile',
						'cart_width_percent',
						'cart_height_percent',
						'cart_width_percent_tablet',
						'cart_height_percent_tablet',
						'cart_width_percent_mobile',
						'cart_height_percent_mobile',
					];

					requireVarUpdate.forEach(function (setting) {

						top.wp.customize.value('xt_woofc[' + setting.key + ']').bind(function (value) {

							XT_WOOFC[setting.var] = value;

							initVars();
							setListHeight();
						});
					});

					requireCartRefresh.forEach(function (setting) {

						top.wp.customize.value('xt_woofc[' + setting + ']').bind(function () {

							top.wp.customize.previewer.save();
						});

					});

					requireWindowResize.forEach(function (setting) {

						top.wp.customize.value('xt_woofc[' + setting + ']').bind(function () {

							$(window).trigger('resize');

						});

					});
				}

				wp.customize.preview.bind('saved', function () {

					setListHeight();
					refreshCart();
				});


				var disableClickSelectors = [
					'.add_to_cart_button',
					'.single_add_to_cart_button'
				];

				if(!!XT_WOOFC.cart_menu_enabled && XT_WOOFC.cart_menu_click_action === 'toggle') {
					disableClickSelectors.push('.xt_woofc-menu-link');
				}

				disableClickSelectors = disableClickSelectors.join(',');

				$('body').on('mouseover', disableClickSelectors, function() {

					$(this).attr('data-href', $(this).attr('href')).attr('href', '#');

				}).on('mouseout', disableClickSelectors, function() {

					$(this).attr('href', $(this).attr('data-href'));
				});

				$(top.document.body).on('mouseenter', '#customize-controls', function() {
					cartContainer.addClass('xt_woofc-no-transitions');
				});

				$(top.document.body).on('mouseleave', '#customize-controls', function() {
					cartContainer.removeClass('xt_woofc-no-transitions');
				});

			}

		});

		window.xt_woofc_refresh_cart = refreshCart;
		window.xt_woofc_toggle_cart = toggleCart;
		window.xt_woofc_open_cart = function() {
			toggleCart(false);
		};
		window.xt_woofc_close_cart = function() {
			toggleCart(true);
		};
		window.xt_woofc_is_cart_open = function() {
			return cartActive;
		};
		
	});


})( jQuery, window );
