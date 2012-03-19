/* 
 * Forms JavaScript Library
 * 
 * Used for transforming HTML form elements into HTML5 form elements if 
 * device supports it.  This includes placeholder, required and various
 * input types.
 * 
 * Usage: 
 * ----------------------------
 * 
 * <script type="text/javascript">
 *   mwf.forms.init();  // all forms
 * </script>
 *
 * Options:
 * ---------------------------- 
 * 
 * <script type="text/javascript">
 *   mwf.forms.init({
 *     selector: "#form1"
 *   });  // only form with id 'formId'
 * </script>
 * 
 * <script type="text/javascript">
 *   mwf.forms.init({
 *     selector: ".myforms"
 *   });  // only form with class 'myforms'
 * </script>
 */
mwf.forms = new function() {};

/**
 * Initialize the form for transformation and placeholder.
 */
mwf.forms.init = function(options) {        
            
    (function($){
        
        // sets options and merge with default settings
        var settings = $.extend( {
            selector: "form"
        }, options);
        
        /////////////////////////////////////////
        // Transform
        /////////////////////////////////////////

        // if support placeholder
        if (mwf.capability.input.placeholder()) {
            placeholderTransform();
        }

        // if support required
        if (mwf.capability.input.required()) {
            requiredTransform();
        }
        
        // if support number
        if (mwf.capability.inputtypes.number()) {
            rangeTransform("number");
        }
        
        /*
         * Transforms required class into required attributes for the immediate 
         * input type.  ignore div.option (select or checkboxe group for now).
         */
        function requiredTransform() {
            var fields = $(settings.selector).find("label,:input,div");
            $(settings.selector + " .required").each(function() {
                var next = $(fields.eq(fields.index(this) + 1));
                if (!next.is("div")) {
                    next.attr("required", "required");
                }
            })
        }
        
        /*
         * Transforms required class into required attributes
         */
        function placeholderTransform() {
            $(settings.selector + " .placeholder").each(function() {
                $(this).prev(":input").attr("placeholder", $(this).html());
            })
        }
        
        /*
         * Transforms into a range input type such as number or range.
         */
        function rangeTransform(inputtype) {
            $(settings.selector + " ." + inputtype + "-field").each(function() {
                var element = $(this);
                
                // find the min
                var min = element.find("option:first-child").attr("value");               
                
                // find the max
                var max = element.find("option:last-child").attr("value");
                
                // find the step (difference between first and second item)
                var step = element.find("option:nth-child(2)").attr("value");
                step -= min;
                
                // find the selected value
                var current = element.find("option:selected").attr("value");
                
                var clone = $('<input type="' + inputtype + '" />');
                clone.attr("name", element.attr("name") + "-transform");
                clone.attr("min", min);
                clone.attr("max", max);
                clone.attr("value", current);
                clone.attr("step", step);
                clone.addClass("range-transform-field");
                clone.insertAfter(element);
                element.addClass("hide");
            });
        }
        
        /////////////////////////////////////////
        // change listener
        /////////////////////////////////////////
        
        /*
         * Listens for changes on simple transform input field and updates the 
         * original input type.
         */
        $(settings.selector + " .simple-transform-field").blur(function() {
            var element = $(this);
            element.prev().val(element.val());
        });
        
        /*
         * Listens for changes on range transform input field and updates the 
         * original input type.
         */
        $(settings.selector + " .range-transform-field").blur(function() {
            var element = $(this);
            element.prev().val(element.val());
        });
    })(jQuery);
};