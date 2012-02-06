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
 * <div id="alert" class="message  padded alert">[text]</div>
 * 
 * <script type="text/javascript">
 *   mwf.messages.modal({
 *     id: "alert"
 *   });
 * </script>
 * 
 * Second way:
 * 
 * <script type="text/javascript">
 *   mwf.messages.modal({
 *     text: "This is an error message",
 *     type: "error",
 *     padded: false
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
 *   callback_function = function() {
 *     ...
 *   }    
 *
 *   mwf.messages.modal({
 *     id: "alert",
 *     callback: callback_function
 *   });
 * </script>
 * 
 */
mwf.messages = function() {};

mwf.messages.modal = function(options) {
    
    (function($){
        
        // sets options and merge with default settings
        var settings = $.extend( {
            id: null,
            text: null,
            type: null,
            padded: true,
            callback: null
        }, options);
            
        
        
        // validation.  if id is not specified, text and type is required.
        if (settings.id == null) {
            if (settings.text == null) {
                console.error("The text parameter must be specified");
                return;
            }
            
            if (settings.type == null) {
                console.error("The type parameter must be specified");
                return;
            }
            
            if (settings.type != null) {
                settings.type = settings.type.toLowerCase();
                if (settings.type != "alert" &&
                    settings.type != "confirm" &&
                    settings.type != "error" &&
                    settings.type != "info") {
                    console.error('Invalid type parameter.  Must be "alert", "confirm", "error" or "info"');
                    return;
                }
            }
            
            if (settings.callback != null) {
                if (typeof(settings.callback) != "function") {
                    console.error("Callback " + settings.callback + " is not a function");
                    return;
                }
            }
        }
        
        // construct the message element.  value of element is either HTML 
        // markup or element id.
        var element;
        if (settings.id == null) {
            if (settings.text == null) {
                throw "Text parameter must be specified";
            }
        
            element += '<div class="message ';
            
            element += settings.type;
            
            if (settings.padded) {
                element += ' padded'
            }
            
            element += '">';
            element += settings.text;
            element += '</div>';
        } else {
            element = "#" + settings.id;
        }
        
        // build the modal dialog with mask, wrapper and button
        var message = $(element);
            
        if (message == null) {
            console.error("Cannot find element");
            return;
        }
        
        if (message.hasClass("padded")) {
            settings.padded = true;
        }
            
        var mask = $('<div class="message-mask" />');
        var buttonClass = "message-button button";
            
        if (settings.padded) {
            buttonClass += " padded";
        }
            
        var button = $('<div class="' + buttonClass + '"><a href="#">OK</a></div>');
            
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
        
    
    })(jQuery);
}