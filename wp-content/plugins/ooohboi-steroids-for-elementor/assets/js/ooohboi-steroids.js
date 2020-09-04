/* Elementor hooks - editor - frontend */

'use strict';

( function ( $, w ) {
    
    var $window = $( w );

    $window.on( 'elementor/frontend/init', function() {

        var PoopArt = elementorModules.frontend.handlers.Base.extend( {

            onInit: function() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initPoopArt();

            },

            initPoopArt: function() {

                if( this.isEdit ) {
                    this.$element.addClass( 'ob-has-background-overlay' );
                }

            }, 

        } );

        var Harakiri = elementorModules.frontend.handlers.Base.extend( {

            onInit: function onInit() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initHarakiri();

            },

            initHarakiri: function() {

                if( this.isEdit ) {
                    if( 'inherit' !== this.getElementSettings( '_ob_harakiri_writing_mode' ) ) this.$element.addClass( 'ob-harakiri' );
                }

            }, 

            onElementChange: function( changedProp ) {

                if( changedProp === '_ob_harakiri_writing_mode' ) {
                    if( 'inherit' !== this.getElementSettings( '_ob_harakiri_writing_mode' ) ) this.$element.addClass( 'ob-harakiri' );
                    else this.$element.removeClass( 'ob-harakiri' );
                }

            }

        } );
        
        var SectionExtends = elementorModules.frontend.handlers.Base.extend( {

            onInit: function onInit() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initSectionExtends();

            },
            isBreakingBad: function() {

                return this.$element.hasClass( 'ob-is-breaking-bad' );

            },
            isGlider: function() {

                return this.$element.hasClass( 'ob-is-glider' );

            },
            onElementChange: function( changedProp ) {

                // Breaking Bad
                if( changedProp === '_ob_bbad_use_it' ) {
                    if( 'yes' === this.getElementSettings( '_ob_bbad_use_it' ) ) this.$element.addClass( 'ob-is-breaking-bad' );
                    else this.$element.removeClass( 'ob-is-breaking-bad' );
                }
                // Glider
                if( changedProp === '_ob_glider_is_slider' ) {

                    if( 'yes' === this.getElementSettings( '_ob_glider_is_slider' ) ) {
                        this.$element.addClass( 'ob-is-glider' );
                        this.addClassesRouteGlider( '.elementor-element-' + this.$element.attr( 'data-id' ), 'addClass' ); 
                        this.initSwiperElements();
                    } else {
                        if( 'yes' != this.getElementSettings( '_ob_glider_is_slider' ) ) {
                            this.$element.removeClass( 'ob-is-glider' );
                            this.addClassesRouteGlider( '.elementor-element-' + this.$element.attr( 'data-id' ), 'removeClass' );
                        }
                    }

                }
                
            },
            addClassesRouteGlider: function( el, action ) {
                
                // elementor-container add swiper-container
                var container = $( el ).children( '.elementor-container' ).first();
                if( container.length ) container.addClass( 'swiper-container' );
                // wrapper
                var wrapper = $( container ).children( '.elementor-row' ).first();

                if( wrapper.length && 'addClass' == action ) {
                    wrapper.addClass( 'swiper-wrapper' ); 
                    $( wrapper ).children( 'div.elementor-column' ).addClass( 'swiper-slide' );
                } 
                if( wrapper.length && 'removeClass' == action ) {
                    wrapper.removeClass( 'swiper-wrapper' ); 
                    $( wrapper ).children( 'div.elementor-column' ).removeClass( 'swiper-slide' );
                }

            }, 
            initSectionExtends: function() {
            
                if( this.isEdit ) {
                    // Breaking Bad
                    if( 'yes' === this.getElementSettings( '_ob_bbad_use_it' ) && ! this.isBreakingBad() ) this.$element.addClass( 'ob-is-breaking-bad' );
                    // Glider: editor and font-end
                    if( 'yes' === this.getElementSettings( '_ob_glider_is_slider' ) ) {
                        this.$element.addClass( 'ob-is-glider' );
                        this.addClassesRouteGlider( '.elementor-element-' + this.$element.attr( 'data-id' ), 'addClass' );
                        this.initSwiperElements();
                    }
                } else {

                    if( 'yes' === this.getElementSettings( '_ob_glider_is_slider' ) ) {

                        this.$element.addClass( 'ob-is-glider' );
                        this.addClassesRouteGlider( '.elementor-element-' + this.$element.attr( 'data-id' ), 'addClass' ); 
                        this.initSwiperElements();

                    }

                }
            
            }, 
            initSwiperElements: function() {
                // navig
                if( ! this.$element.children( '.elementor-container .swiper-button-next' ).first().length ) {
                    this.$element.children( '.elementor-container' ).first().append( 
                        '<div class="swiper-button-next"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMin" viewBox="0 0 27 44"><path d="M27 22L5 44l-2.1-2.1L22.8 22 2.9 2.1 5 0l22 22z"></path></svg></div>' 
                    );
                }
                if( ! this.$element.children( '.elementor-container .swiper-button-prev' ).first().length ) {
                    this.$element.children( '.elementor-container' ).first().append( 
                        '<div class="swiper-button-prev"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMin" viewBox="0 0 27 44"><path d="M0 22L22 0l2.1 2.1L4.2 22l19.9 19.9L22 44 0 22z"></path></svg></div>' 
                    );
                }
                // pagination
                if( ! this.$element.children( '.elementor-container .swiper-pagination' ).first().length ) {
                    this.$element.children( '.elementor-container' ).first().append( '<div class="swiper-pagination"></div>' );
                }
                // settings 
                var settingz = {};
                settingz.pagination_type = this.getElementSettings( '_ob_glider_pagination_type' );
                settingz.allowTouchMove = this.getElementSettings( '_ob_glider_allow_touch_move' );
                settingz.autoheight = this.getElementSettings( '_ob_glider_auto_h' );
                settingz.effect = this.getElementSettings( '_ob_glider_effect' );
                settingz.loop = this.getElementSettings( '_ob_glider_loop' );
                settingz.direction = this.getElementSettings( '_ob_glider_direction' );
                settingz.parallax = this.getElementSettings( '_ob_glider_parallax' );
                settingz.speed = this.getElementSettings( '_ob_glider_speed' );
                var autoplayed = this.getElementSettings( '_ob_glider_autoplay' );
                if( autoplayed ) {
                    settingz.autoplay = {
                        'delay': this.getElementSettings( '_ob_glider_autoplay_delay' ), 
                    }
                } else settingz.autoplay = false;

                // run swiper
                makeSwiper( this.$element.attr( 'data-id' ), settingz );

            }, 

        } );

        var ColumnExtends = elementorModules.frontend.handlers.Base.extend( {

            onInit: function onInit() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initColumnExtends();

            },
            isTeleporter: function() {

                return this.$element.hasClass( 'ob-is-teleporter' );

            },
            initColumnExtends: function() {

                if( this.isEdit && 'use-teleporter' === this.getElementSettings( '_ob_teleporter_use' ) ) { 
                    this.$element.addClass( 'ob-is-teleporter' ); 
                    this.doTeleporterEditor(); 
                } 
                if( ! this.isEdit && this.isTeleporter() ) {
                    this.doTeleporter(); 
                }

            }, 
            onElementChange: function( changedProp ) {
                
                if( changedProp === '_ob_teleporter_overlay_color' ) {
                    this.$element.find( 'div[class*="ob-teleporter-"] > .ob-tele-overlay' ).css( 'background-color', this.getElementSettings( '_ob_teleporter_overlay_color' ) );
                } else if( changedProp === '_ob_teleporter_no_pass_tablet' ) {
                    if( 'no-tablet' === this.getElementSettings( '_ob_teleporter_no_pass_tablet' ) ) 
                        this.$element.addClass( 'ob-tele-no-tablet' );
                    else 
                        this.$element.removeClass( 'ob-tele-no-tablet' );
                } else if( changedProp === '_ob_teleporter_no_pass_mobile' ) {
                    if( 'no-mobile' === this.getElementSettings( '_ob_teleporter_no_pass_mobile' ) ) 
                        this.$element.addClass( 'ob-tele-no-mobile' ); 
                    else 
                        this.$element.removeClass( 'ob-tele-no-mobile' ); 
                }

            },
            doTeleporterEditor: function() {

                if( 'use-teleporter' !== this.getElementSettings( '_ob_teleporter_use' ) ) return; // bail
                if( 'do-pass' !== this.getElementSettings( '_ob_teleporter_pass' ) ) return; // bail too

                var this_ob = this;
                var myself  = this.$element;
                var my_id   = this.$element.attr( 'data-id' ); 

                // default classes
                if( 'no-tablet' === this.getElementSettings( '_ob_teleporter_no_pass_tablet' ) ) 
                    this.$element.addClass( 'ob-tele-no-tablet' );
                if( 'no-mobile' === this.getElementSettings( '_ob_teleporter_no_pass_mobile' ) ) 
                    this.$element.addClass( 'ob-tele-no-mobile' ); 

                // this column's parent section
                var parent_section = ( 'section' === this.getElementSettings( '_ob_teleporter_pass_element' ) ) ? this.$element.closest( '.elementor-section' ) : this.$element.closest( '.elementor-container' ); 
                if( ! parent_section.length ) return; // bail

                // parent overflow
                parent_section.css( 'overflow', 'hidden' );

                // new element & effect
                var hover_effect  = this.getElementSettings( '_ob_teleporter_pass_effect' );
                var hover_element = '<div class="ob-teleporter-' + my_id + ' ob-tele-eff-' + hover_effect + '" data-id-teleporter="' + my_id + '"><div class="ob-tele-overlay" style="background-color: ' + this.getElementSettings( '_ob_teleporter_overlay_color' ) + ';"></div></div>';

                if( ! $( '.ob-teleporter-' + my_id ).length ) this.$element.prepend( hover_element );

                this.$element.off( 'mouseenter mouseleave' );
                this.$element.on( 'mouseenter mouseleave', function( ev ) {

                    if( 'mouseenter' === ev.type ) {

                        if( 'no-tablet' === this_ob.getElementSettings( '_ob_teleporter_no_pass_tablet' ) && 
                        'tablet' === elementorFrontend.getCurrentDeviceMode() ) return; // bail
                        if( 'no-mobile' === this_ob.getElementSettings( '_ob_teleporter_no_pass_mobile' ) && 
                            'mobile' === elementorFrontend.getCurrentDeviceMode() ) return; // bail
                        if( 'do-pass' !== this_ob.getElementSettings( '_ob_teleporter_pass' ) ) return;

                        var tele_css = { 
                            'background-color': $( '.ob-teleporter-' + my_id ).css( 'background-color' ),
                            'background-image': $( '.ob-teleporter-' + my_id ).css( 'background-image' ),
                            'background-position': $( '.ob-teleporter-' + my_id ).css( 'background-position' ),
                            'background-size': $( '.ob-teleporter-' + my_id ).css( 'background-size' ),
                            'background-repeat': $( '.ob-teleporter-' + my_id ).css( 'background-repeat' )
                        };
                        
                        if( 'section' === this_ob.getElementSettings( '_ob_teleporter_pass_element' ) ) {
                            var all_children = parent_section.children().not( '.elementor-container' ).detach();
                            parent_section.addClass( 'ob-tele-mom-hover' ).prepend( $( '.ob-teleporter-' + my_id ) );
                            parent_section.prepend( all_children );
                        } else { 
                            parent_section.addClass( 'ob-tele-mom-hover' ).prepend( $( '.ob-teleporter-' + my_id ) );
                        }
                        
                        $( '.ob-teleporter-' + my_id ).css( tele_css ).hide();
                        $( '.ob-teleporter-' + my_id ).addClass(  'ob-teleporter-hover' ).show(); 

                    } else {

                        parent_section.removeClass( 'ob-tele-mom-hover' );
                        setTimeout( function() {
                            $( '.ob-teleporter-' + my_id ).removeAttr( 'style' ).removeClass( 'ob-teleporter-hover' );
                            myself.prepend( $( '.ob-teleporter-' + my_id ) ); 
                        }, 100 );

                    }

                } );
            
            }, 
            doTeleporter: function() {

                var teleporter_settings = $.parseJSON( this.$element.attr( 'data-settings' ) );
                if( 'use-teleporter' !== teleporter_settings._ob_teleporter_use ) return; // bail
                if( 'do-pass' !== teleporter_settings._ob_teleporter_pass ) return; // bail too

                var myself = this.$element;
                var my_id  = this.$element.attr( 'data-id' ); 

                // default classes
                if( 'no-tablet' === teleporter_settings._ob_teleporter_no_pass_tablet ) 
                    this.$element.addClass( 'ob-tele-no-tablet' );
                if( 'no-mobile' === teleporter_settings._ob_teleporter_no_pass_mobile ) 
                    this.$element.addClass( 'ob-tele-no-mobile' ); 
                 
                // this column's parent section
                var parent_section = ( 'section' === teleporter_settings._ob_teleporter_pass_element ) ? this.$element.closest( '.elementor-section' ) : this.$element.closest( '.elementor-container' ); 
                if( ! parent_section.length ) return; // bail

                // parent overflow
                parent_section.css( 'overflow', 'hidden' );

                // new element
                var hover_effect  = teleporter_settings._ob_teleporter_pass_effect;
                var hover_element = '<div class="ob-teleporter-' + my_id + ' ob-tele-eff-' + hover_effect + '" data-id-teleporter="' + my_id + '"><div class="ob-tele-overlay" style="background-color: ' + teleporter_settings._ob_teleporter_overlay_color + ';"></div>';

                if( ! $( '.ob-teleporter-' + my_id ).length ) this.$element.prepend( hover_element );

                this.$element.off( 'mouseenter mouseleave' );
                this.$element.on( 'mouseenter', function() { 

                    if( 'no-tablet' === teleporter_settings._ob_teleporter_no_pass_tablet && 
                        'tablet' === elementorFrontend.getCurrentDeviceMode() ) return; // bail
                    if( 'no-mobile' === teleporter_settings._ob_teleporter_no_pass_mobile && 
                        'mobile' === elementorFrontend.getCurrentDeviceMode() ) return; // bail

                    var tele_css = { 
                        'background-color': $( '.ob-teleporter-' + my_id ).css( 'background-color' ),
                        'background-image': $( '.ob-teleporter-' + my_id ).css( 'background-image' ),
                        'background-position': $( '.ob-teleporter-' + my_id ).css( 'background-position' ),
                        'background-size': $( '.ob-teleporter-' + my_id ).css( 'background-size' ),
                        'background-repeat': $( '.ob-teleporter-' + my_id ).css( 'background-repeat' )
                    };
                    
                    if( 'section' === teleporter_settings._ob_teleporter_pass_element ) {
                        var all_children = parent_section.children().not( '.elementor-container' ).detach();
                        parent_section.addClass( 'ob-tele-mom-hover' ).prepend( $( '.ob-teleporter-' + my_id ) );
                        parent_section.prepend( all_children );
                    } else parent_section.addClass( 'ob-tele-mom-hover' ).prepend( $( '.ob-teleporter-' + my_id ) );
                    
                    $( '.ob-teleporter-' + my_id ).css( tele_css ).hide();
                    $( '.ob-teleporter-' + my_id ).show().addClass( 'ob-teleporter-hover' );
                    
                } );
                
                this.$element.on( 'mouseleave', function() {
                    
                    parent_section.removeClass( 'ob-tele-mom-hover' );
                    setTimeout( function() {
                        $( '.ob-teleporter-' + my_id ).removeAttr( 'style' ).removeClass( 'ob-teleporter-hover' );
                        myself.prepend( $( '.ob-teleporter-' + my_id ) );
                    }, 100 );

                } );

                if( undefined !== teleporter_settings._ob_teleporter_link ) { 

                    var tele_link = teleporter_settings._ob_teleporter_link;
                    if( '' === tele_link.url ) return;

                    this.$element.off( 'click.obTeleporter' );
                    this.$element.on( 'click.obTeleporter', function() {
                        if( tele_link.is_external ) window.open( tele_link.url ); 
                        else location.href = tele_link.url;
                    } );

                }
 
            }, 

        } );

        var SearchCop = elementorModules.frontend.handlers.Base.extend( {

            onInit: function() {

                elementorModules.frontend.handlers.Base.prototype.onInit.apply( this, arguments );
                this.initSearchCop();

            },

            onElementChange: function( changedProp ) {

                if( changedProp === '_ob_searchcop_srch_options' ) this.routeSearchCop();
                
            },

            initSearchCop: function() {

                this.routeSearchCop();

            }, 

            routeSearchCop: function() {
                var search_cop_val = this.getElementSettings( '_ob_searchcop_srch_options' );
                if( 'post' === search_cop_val || 'page' === search_cop_val ) {
                    var this_input_wrapper = this.$element.find( '.elementor-search-form__container' );
                    if( ! this_input_wrapper.length ) return;
                    var param_input = '<input type="hidden" name="post_type" value="' + search_cop_val + '" />';
                    this_input_wrapper.prepend( param_input );
                }
            },

        } );

        var handlersList = {

            'widget': PoopArt, 
            'heading.default': Harakiri, 
            'text-editor.default': Harakiri, 
            'section': SectionExtends, 
            'column': ColumnExtends, 
            'search-form.default': SearchCop 

        };

        $.each( handlersList, function( widgetName, handlerClass ) {

            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widgetName, function( $scope ) {
                
                //if( 'section' === widgetName && $scope.context.classList.contains( 'elementor-inner-section' ) ) return;
                elementorFrontend.elementsHandler.addHandler( handlerClass, { $element: $scope } );

            } );

        } );

    } );

    var makeSwiper = function( elem_id, settings ) {
        
        var me_the_swiper = new Swiper( '.elementor-element-' + elem_id + ' .swiper-container', {
            allowTouchMove: ( 'yes' === settings.allowTouchMove ? true : false ), 
            autoHeight: ( 'yes' === settings.autoheight ? true : false ), 
            effect: settings.effect, 
            loop: settings.loop, 
            direction: ( 'fade' === settings.effect ? 'horizontal' : settings.direction ), 
            parallax: ( 'yes' === settings.parallax ? true : false ),
            speed: settings.speed, 
            navigation: {
                nextEl: '.elementor-element-' + elem_id + ' .swiper-button-next',
                prevEl: '.elementor-element-' + elem_id + ' .swiper-button-prev',
            },
            pagination: {
                el: '.elementor-element-' + elem_id + ' .swiper-pagination', 
                type: settings.pagination_type, 
                clickable: true, 
            },
            autoplay: settings.autoplay,
            watchOverflow : true, /* gotta force it down */
        } );
        
    }

} ( jQuery, window ) );