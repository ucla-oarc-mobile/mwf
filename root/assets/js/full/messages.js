/* 
 * Messages JavaScript Library
 * 
 * Used for displaying modal message dialog boxes.  The html element that is 
 * the message content will be removed from the DOM after the message dialog box
 * is closed.
 * 
 * 
 * Usage:
 * ----------------------------
 * 
 * First way:
 * 
 * <div id="alert" class="message-full message-padded message-alert">[text]</div>
 * 
 * <script type="text/javascript">
 *  $(document).ready(function() {
 *       $("#alert").dialog();
 *   });
 * </script>
 * 
 * Second way:
 * 
 * <script type="text/javascript">
 *  $(document).ready(function() {
 *       $('<div class="message-full message-padded message-alert">[text]</div>').dialog();
 *   });
 * </script>
 * 
 * 
 * Options:
 * ----------------------------
 * 
 * Pass in a callback function to handle event when user closes the dialog box.
 * 
 * <script type="text/javascript">
 *  $(document).ready(function() {
 *       $("#alert").dialog({
 *           callback: callme
 *       });
 *   });
 * </script>
 * 
 */
(function($){
    
    $.fn.dialog = function(options) {
            
        // default settings
        var settings = {
            'callback' : null
        }

        // return this for chaining
        return this.each(function() {
            
            // if options exist, merge with default settings
            if (options) {
                $.extend(settings, options);
            }
            
            // build the modal dialog with mask, wrapper and button
            var message = $(this);
            var mask = $('<div class="message-mask" />');
            var button = $('<a href="#" class="message-button button-full">OK</a>');
            
            // remove from DOM and added it back to the beginning of page
            message.detach();
            message.addClass("message-modal");
            message.prependTo("body");
            
            // add mask, wrapper and button to dialog
            message.before(mask);
            message.wrap('<div class="message-wrapper" />');
            message.after(button);
                
            // handle closing of the dialog
            button.click(function(e) {
        
                e.preventDefault();
        
                // clean up
                message.parent(".message-wrapper").remove();
                mask.remove();

                // now do call back
                if (settings.callback != null) {
                    settings.callback();
                }
            
            });
                
        });
  
    };

})(jQuery);
