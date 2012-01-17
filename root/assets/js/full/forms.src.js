/* 
 * Forms JavaScript Library
 * 
 * Used for transforming HTML form elements into HTML5 form elements if 
 * device supports it.  This includes placeholder, required and various
 * input types.  Also used for client side validation.
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
 * Initialize the form for transformation, placeholder, validation.
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

        // if support color
        if (mwf.capability.inputtypes.color()) {
            simpleTransform("color");
        }
        
        // if support search
        if (mwf.capability.inputtypes.search()) {
            simpleTransform("search");
        }
        
        // if support number
        if (mwf.capability.inputtypes.number()) {
            rangeTransform("number");
        }

        // if support tel
        if (mwf.capability.inputtypes.tel()) {
            simpleTransform("tel");
        }

        // if support url
        if (mwf.capability.inputtypes.url()) {
            simpleTransform("url");
        }

        // if support email
        if (mwf.capability.inputtypes.email()) {
            simpleTransform("email");
        }

        // if support date
        if (mwf.capability.inputtypes.date()) {
            datetimeTransform("date");
        }
        
        // if support month
        if (mwf.capability.inputtypes.month()) {
            datetimeTransform("month");
        }
        
        // if support week
        if (mwf.capability.inputtypes.week()) {
            datetimeTransform("week");
        }
        
        // if support datetime
        if (mwf.capability.inputtypes.datetime()) {
            datetimeTransform("datetime");
        }
        
        // if support datetime
        if (mwf.capability.inputtypes.datetimelocal()) {
            datetimeTransform("datetime-local");
        }
        
        // if support time
        if (mwf.capability.inputtypes.time()) {
            datetimeTransform("time");
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
         * Transforms into a single input field such as email, url, tel, search.
         */
        function simpleTransform(inputtype) {
            $(settings.selector + " ." + inputtype + "-field").each(function() {
                var element = $(this);
                var clone = element.clone();
                clone.attr("name", element.attr("name") + "-transform");
                clone.attr("type", inputtype);
                clone.removeClass(inputtype + "-field");
                clone.addClass("simple-transform-field");
                clone.insertAfter(element);
                element.addClass("hide");
                element.removeAttr("required");
            });
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
        
        /*
         * Transforms into a date and time input type such as date, month, week,
         * datetime, time.
         */
        function datetimeTransform(inputtype) {
            $(settings.selector + " ." + inputtype + "-field").each(function() {
                var element = $(this);
            
                // determine what type of input type (date, month, week)
                var hasOffsetMinute = false;
                if (element.find(".offset-minute").size() > 0)
                    hasOffsetMinute = true;
                var hasOffsetHour = false;
                if (element.find(".offset-hour").size() > 0)
                    hasOffsetHour = true;
                var hasOffset = false;
                if (element.find(".offset").size() > 0)
                    hasOffset = true;
                var hasSecond = false;
                if (element.find(".second").size() > 0)
                    hasSecond = true;
                var hasMinute = false;
                if (element.find(".minute").size() > 0)
                    hasMinute = true;
                var hasHour = false;
                if (element.find(".hour").size() > 0)
                    hasHour = true;
                var hasDay = false;
                if (element.find(".day").size() > 0)
                    hasDay = true;
                var hasWeek = false;
                if (element.find(".week").size() > 0)
                    hasWeek = true;
                var hasMonth = false;
                if (element.find(".month").size() > 0)
                    hasMonth = true;
                var hasYear = false;
                if (element.find(".year").size() > 0)
                    hasYear = true;               
                
                // get each field's value
                var currentOffsetMinute = "00";
                if (hasOffsetMinute) {
                    currentOffsetMinute = getCurrentDateField(element, "offset-minute");
                }
                
                var currentOffsetHour = "00";
                if (hasOffsetHour) {
                    currentOffsetHour = getCurrentDateField(element, "offset-hour");
                }
                
                var currentOffset = "+";
                if (hasOffset) {
                    currentOffset = getCurrentDateField(element, "offset");
                }
                
                var currentSecond = "00";
                if (hasSecond) {
                    currentSecond = getCurrentDateField(element, "second");
                }
                
                var currentMinute = "00";
                if (hasMinute) {
                    currentMinute = getCurrentDateField(element, "minute");
                }
                
                var currentHour = "00";
                if (hasHour) {
                    currentHour = getCurrentDateField(element, "hour");
                }
                
                var currentDay = "01";
                if (hasDay) {
                    currentDay = getCurrentDateField(element, "day");
                }
                
                var currentWeek = "01";
                if (hasWeek) {
                    currentWeek = getCurrentDateField(element, "week");
                }
                
                var currentMonth = "01";
                if (hasMonth) {
                    currentMonth = getCurrentDateField(element, "month");
                }
                
                var currentYear = "1900";
                if (hasYear) {
                    currentYear = getCurrentDateField(element, "year");
                }
                
                // build transformed element
                var clone = $('<input type="' + inputtype + '" />');
                
                var current = "";
                
                if (hasYear) {
                    current += currentYear;
                }
                
                if (hasMonth) {
                    current += "-";
                    current += currentMonth;
                }
                
                if (hasWeek) {
                    current += "-W";
                    current += currentWeek;
                }
                
                if (hasDay) {
                    current += "-";
                    current += currentDay;
                }
                
                if (inputtype === "datetime-local" || inputtype === "datetime") {
                    current += "T";
                }
                
                if (hasHour || hasMinute || hasSecond) {
                    current += currentHour + ":" + currentMinute + ":" + currentSecond;
                }
                
                if (inputtype === "datetime") {
                    current += currentOffset + currentOffsetHour + ":" + currentOffsetMinute;
                }
                
                clone.attr("name", element.attr("name") + "-transform");
                clone.attr("value", current);
                clone.removeClass(inputtype + "-field");
                if (inputtype === "time")
                    clone.addClass("time-transform-field");
                else
                    clone.addClass("datetime-transform-field");
                clone.insertAfter(element);
                element.addClass("hide");
            });
                        
            /*
             * helper method for dateTransform to get minimum date
             */
            function getMinDateField(element, field) {
                return element.find("." + field +" option:first-child").attr("value");
            }
        
            /*
             * helper method for dateTransform to get maximum date
             */
            function getMaxDateField(element, field) {
                return element.find("." + field +" option:last-child").attr("value");
            }
        
            /*
             * helper method for dateTransform to get current selected date
             */
            function getCurrentDateField(element, field) {
                return element.find("." + field +" option:selected").attr("value");
            }
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
        
        /*
         * Listens for changes on date transform input field and updates the 
         * original input type.
         */
        $(settings.selector + " .datetime-transform-field").blur(function() {
            var element = $(this);
            var prevElement = element.prev();
            
            // clear all currently selected
            prevElement.find("option:selected").removeAttr("selected");
                
            // split by "T" or " " into date and time
            var tokens = element.val().split("T"); 
            if (tokens.length == 0) {
                tokens = element.val().split(" ");     
            }

            // process date.  split into year, month/week, day, time, timezone
            var t = tokens[0].split("-");
                        
            // set year
            prevElement.find(".year").val(t[0]);
                        
            // set month or week
            if (t.length > 1) {
                // starts with "W" if week
                if (t[1].lastIndexOf("W", 0) === 0) {
                    //var length = t[1].length;  // get rid of 'W'
                    prevElement.find(".week").val(t[1].substring(1, 3));
                } else {
                    prevElement.find(".month").val(t[1]);
                }
            }
                        
            if (t.length > 2) {
                prevElement.find(".day").val(t[2]);
            }
                
            // process time and timezone (hh:mm:ss+HH:MM or hh:mm:ssZ)
            var hasTime = false;
            var hasTimeZone = false;
            var isUtc = false;
            var isPositiveOffset = false;
            var tz;
            
            // has time component?
            if (tokens.length > 1) {
                hasTime = true;
                
                // is utc format?
                tz = tokens[1].split("Z");
                if (tz.length > 1) {
                    isUtc = true;
                } else {
                    // is offset + or -?
                    tz = tokens[1].split("+");
                    if (tz.length > 1) {
                        isPositiveOffset = true;
                    } else {
                        tz = tokens[1].split("-");
                    }
                }
            }
            
            if (tz.length > 1) {
                hasTimeZone = true;
            }
            
            if (hasTime) {                        
                t = tz[0].split(":");
                prevElement.find(".hour").val(t[0]);
                if (t.length > 1) {
                    prevElement.find(".minute").val(t[1]);
                    // default to 0 sec in case seconds is not avaiable in ui
                    prevElement.find(".second").val("00");
                }
                if (t.length > 2) {
                    prevElement.find(".second").val(t[2].substring(0, 2));
                }
                    
                if (hasTimeZone) {
                    prevElement.find(".offset").val("+");
                    prevElement.find(".offset-hour").val("00");
                    prevElement.find(".offset-minute").val("00");
                    if (!isUtc) {
                        if (!isPositiveOffset) {
                            prevElement.find(".offset").val("-");
                        }
                        t = tz[1].split(":");
                        prevElement.find(".offset-hour").val(t[0]);
                        prevElement.find(".offset-minute").val(t[1]);
                    }
                }
            }
            
        });
        
        /*
         * Listens for changes on time transform input field and updates the 
        * original input type.
        */
        $(settings.selector + " .time-transform-field").blur(function() {
            var element = $(this);
            var prevElement = element.prev();
            
            // clear all currently selected
            prevElement.find("option:selected").removeAttr("selected");
                
            // split by ":" into hour, minute
            var tokens = element.val().split(":");

            if (tokens.length > 0) {
                prevElement.find(".hour").val(tokens[0]);
            }
            
            if (tokens.length > 1) {
                prevElement.find(".minute").val(tokens[1]);
            }
            
            if (tokens.length > 2) {
                prevElement.find(".second").val(tokens[2]);
            }
        });
        
        /////////////////////////////////////////
        // Validate
        /////////////////////////////////////////
        $(settings.selector).each(function() {
            $(this).validate({
                errorClass: "invalid",
                errorElement: "p",
                autoCreateRanges: true
            });
            
            $.validator.autoCreateRanges = true;
        });
        
    })(jQuery);
};