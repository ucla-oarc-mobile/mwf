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

        // if support range
        if (mwf.capability.inputtypes.range()) {
            rangeTransform("range");
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
        //if (mwf.capability.inputtypes.date()) {
        datetimeTransform("date");
        //}
        
        // if support month
        //if (mwf.capability.inputtypes.month()) {
        datetimeTransform("month");
        //}
        
        // if support week
        //if (mwf.capability.inputtypes.week()) {
        datetimeTransform("week");
        //}
        
        // if support datetime
        //if (mwf.capability.inputtypes.datetime()) {
        datetimeTransform("datetime-local");
        //}
        
        // if support time
        //if (mwf.capability.inputtypes.time()) {
        datetimeTransform("time");
        //}
        
        /*
         * Transforms required class into required attributes and add required 
         * class to its label
         */
        function requiredTransform() {
            $(settings.selector + " .required").each(function() {
                $(this).next(":input").attr("required", "required");
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
                clone.attr("type", inputtype);
                clone.removeClass(inputtype + "-field");
                clone.addClass("simple-transform-field");
                clone.insertAfter(element);
                element.addClass("hide");
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
                var minSecond = "00";
                var maxSecond = "00";
                var currentSecond = "00";
                if (hasSecond) {
                    minSecond = getMinDateField(element, "second");
                    maxSecond = getMaxDateField(element, "second");
                    currentSecond = getCurrentDateField(element, "second");
                }
                
                var minMinute = "00";
                var maxMinute = "00";
                var currentMinute = "00";
                if (hasMinute) {
                    minMinute = getMinDateField(element, "minute");
                    maxMinute = getMaxDateField(element, "minute");
                    currentMinute = getCurrentDateField(element, "minute");
                }
                
                var minHour = "00";
                var maxHour = "00";
                var currentHour = "00";
                if (hasHour) {
                    minHour = getMinDateField(element, "hour");
                    maxHour = getMaxDateField(element, "hour");
                    currentHour = getCurrentDateField(element, "hour");
                }
                
                var minDay = "01";
                var maxDay = "01";
                var currentDay = "01";
                if (hasDay) {
                    minDay = getMinDateField(element, "day");
                    maxDay = getMaxDateField(element, "day");
                    currentDay = getCurrentDateField(element, "day");
                }
                
                var minWeek = "01";
                var maxWeek = "01";
                var currentWeek = "01";
                if (hasWeek) {
                    minWeek = getMinDateField(element, "week");
                    maxWeek = getMaxDateField(element, "week");
                    currentWeek = getCurrentDateField(element, "week");
                }
                
                var minMonth = "01";
                var maxMonth = "01";
                var currentMonth = "01";
                if (hasMonth) {
                    minMonth = getMinDateField(element, "month");
                    maxMonth = getMaxDateField(element, "month");
                    currentMonth = getCurrentDateField(element, "month");
                }
                
                var minYear = "1900";
                var maxYear = "1900";
                var currentYear = "1900";
                if (hasYear) {
                    minYear = getMinDateField(element, "year");
                    maxYear = getMaxDateField(element, "year");
                    currentYear = getCurrentDateField(element, "year");
                }
                
                // build transformed element
                var clone = $('<input type="' + inputtype + '" />');
                
                var min = "";
                var max = "";
                var current = "";
                
                if (hasYear) {
                    min += minYear;
                    max += maxYear;
                    current += currentYear;
                }
                
                if (hasMonth) {
                    min += "-";
                    min += minMonth;
                    max += "-";
                    max += maxMonth;
                    current += "-";
                    current += currentMonth;
                }
                
                if (hasWeek) {
                    min += "-W";
                    min += minWeek;
                    max += "-W";
                    max += maxWeek;
                    current += "-W";
                    current += currentWeek;
                }
                
                if (hasDay) {
                    min += "-";
                    min += minDay;
                    max += "-";
                    max += maxDay;
                    current += "-";
                    current += currentDay;
                }
                
                if (inputtype === "datetime-local" && (hasHour || hasMinute)) {
                    min += "T";
                    max += "T";
                    current += "T";
                }
                
                if (hasHour || hasMinute || hasSecond) {
                    min += minHour + ":" + minMinute + ":" + minSecond;
                    max += maxHour + ":" + maxMinute + ":" + maxSecond;
                    current += currentHour + ":" + currentMinute + ":" + currentSecond;
                }
                
                //clone.attr("min", min);
                //clone.attr("max", max);
                clone.attr("value", current);
                clone.removeClass(inputtype + "-field");
                if (inputtype === "time")
                    clone.addClass("time-transform-field");
                else
                    clone.addClass("datetime-local-transform-field");
                clone.addClass("ignore");
                clone.insertAfter(element);
            //element.addClass("hide");
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
        $(settings.selector + " .datetime-local-transform-field").blur(function() {
            var element = $(this);
            var prevElement = element.prev();
            
            // clear all currently selected
            prevElement.find("option:selected").removeAttr("selected");
                
            // split by "T" into date and time
            var tokens = element.val().split("T");

            // process date.  split into year, month/week, day
            var t = tokens[0].split("-");
                        
            // set year
            prevElement.find(".year").val(t[0]);
                        
            // set month or week
            if (t.length > 1) {
                // starts with "W" if week
                if (t[1].lastIndexOf("W", 0) === 0) {
                    var length = t[1].length;  // get rid of 'W'
                    prevElement.find(".week").val(t[1].substring(1, length));
                } else {
                    prevElement.find(".month").val(t[1]);
                }
            }
                        
            if (t.length > 2) {
                prevElement.find(".day").val(t[2]);
            }
                
            // process time
            if (tokens.length > 1) {
                t = tokens[1].split(":");
                prevElement.find(".hour").val(t[0]);
                prevElement.find(".minute").val(t[1]);
                prevElement.find(".second").val(t[2]);
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

            for (var i = 0; i < tokens.length; i++) {
                prevElement.find(".hour").val(tokens[0]);
                prevElement.find(".minute").val(tokens[1]);
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
                ignore: ".ignore"
            });
        });
        
    })(jQuery);
};   