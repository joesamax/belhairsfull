/**
 * Customizer Communicator
 */
( function ( api, $ ) {
    "use strict";

    api.bind("ready", function() {

        function getSectionResponsiveFields(section) {

            return XTFW_CUSTOMIZER_CTRL.responsive_fields.filter(function (item) {
                return item.section === section;
            });
        }

        function injectDeviceSwitcher(fields) {

            fields.forEach(function (item) {

                var container = api.control(item.config_id+'['+item.id+']').container;
                if(container.find('.xirki-devices-wrapper').length === 0) {
                    container.prepend(XTFW_CUSTOMIZER_CTRL.device_switcher);

                    item.hidden_screens.forEach(function(hidden) {

                        container.find('.xirki-devices-wrapper').find('.preview-'+hidden).hide();
                    });
                }
            });
        }

        api.section.each( function ( section ) {

            section.expanded.bind( function( isExpanding ) {

                if(isExpanding){

                    var fields = getSectionResponsiveFields(section.id);
                    injectDeviceSwitcher(fields);
                }
            });
        });

        $(document).on('click', '.xirki-devices button', function() {

            var device = $(this).data('device');

            api.previewedDevice.set(device);
        });

        $(document).on('click', '.xt-jsapi', function(event) {

            event.preventDefault();

            var $this = $(this);
            var $parent = $this.parent();
            var func = $this.data('function');
            var iframe = wp.customize.previewer.container.find('iframe');

            if(iframe.length) {

                var windowObj = iframe.get(0).contentWindow;

                if(windowObj && windowObj.hasOwnProperty(func)) {

                    var result = windowObj[func]();
                    result = JSON.stringify(result);

                    if(result !== '' && result !== undefined) {

                        result = result === '"true"' ? 'true' : result;
                        result = result === '"false"' ? 'false' : result;

                        if($parent.find('.xt-jsapi-result').length) {
                            $parent.find('.xt-jsapi-result').remove();
                        }

                        $this.after('<pre class="xt-jsapi-result">Result: '+result+'</pre>');
                    }
                }
            }
        });
    });

} )( wp.customize, jQuery );