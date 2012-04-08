/* 
 * Tooltip JavaScript Library
 * 
 * Used for displaying tooltips.
 * 
 * Usage: 
 * ----------------------------
 * 
 * <script type="text/javascript">
 *   mwf.tooltip.init();  // all forms
 * </script>
 *
 * Options:
 * ---------------------------- 
 * 
 * <script type="text/javascript">
 *   mwf.tooltip.init({
 *     selector: "#form1"
 *   });  // only form with id 'formId'
 * </script>
 * 
 * <script type="text/javascript">
 *   mwf.tooltip.init({
 *     selector: ".myforms"
 *   });  // only form with class 'myforms'
 * </script>
 */
mwf.tooltip = function(options) {        
            
    (function($){
        
        // sets options and merge with default settings
        var settings = $.extend( {
            selector: ""
        }, options);
        
        /////////////////////////////////////////
        // Tooltip
        /////////////////////////////////////////
        $(settings.selector + " .tiptext").addClass("tooltip").before('<a href="#" class="tip">tip</a>');
        
        $(settings.selector + " .tip").tooltip(
            {
                effect: 'slide',
                position: 'top right',
                offset: [40, -40],
                events: {
                    def: "mouseover focus, mouseout blur"
                }
            }
        ).dynamic(
            {
                bottom: {direction: 'down', bounce: true}
            }
        );
        
    })(jQuery);
};