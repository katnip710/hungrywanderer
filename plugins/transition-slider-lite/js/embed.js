"use strict";
(function($) {
    $(document).ready(function(){
        
        var sliders = $(".slider_instance");

        $.each(sliders, function(){
            var optionsString = this.innerHTML
            $(this).empty().show()
            if(!optionsString) return;
            var options = JSON.parse(optionsString)
            
            convertStrings(options)
            
            if(options.navigation && !options.navigation.enable) options.navigation = false;
            if(options.pagination && !options.pagination.enable) options.pagination = false;
            if(options.keyboard && !options.keyboard.enable) options.keyboard = false;
            if(options.autoplay && !options.autoplay.enable) options.autoplay = false;
            if(options.hashNavigation && !options.hashNavigation.enable) options.hashNavigation = false;
            if(options.shadow && options.shadow == "off") options.shadow = null;

            for(var key in options.slides){
                var slide = options.slides[key]
                if(slide.elements){
                    for (var key2 in slide.elements){
                        delete slide.elements[key2].node
                    }
                }
                for(var key3 in slide){
                    if(typeof slide[key3] == 'undefined')
                        delete slide[key3]
                }
            }

            var slider = $(this).transitionSlider(options);
        })

        function convertStrings(obj) {

            $.each(obj, function(key, value) {
                if (typeof(value) == 'object' || typeof(value) == 'array') {
                    convertStrings(value)
                } else if (!isNaN(value)) {
                    if (obj[key] === "")
                        delete obj[key]
                    else
                        obj[key] = Number(value)
                } else if (value === "true") {
                    obj[key] = true
                } else if (value === "false") {
                    obj[key] = false
                }
            });

        }
        
    });
}(jQuery));