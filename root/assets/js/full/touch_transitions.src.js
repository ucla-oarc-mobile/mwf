mwf.webkit.touch_transitions = new function() {
    this.init = function () {
        $('.webkit-touch-transition-trigger').swipe({
            swipeLeft: function(e) { mwf.webkit.touch_transitions.trigger('next', e) },
            swipeRight: function(e) { mwf.webkit.touch_transitions.trigger('prev', e) }
        });
    };

    this.trigger = function(type, e) {
        var target = $('.webkit-touch-transition-target').children('.active').first();
        if(type == 'prev')
            mwf.webkit.transitions.swap_prev(target);
        if(type == 'next')
            mwf.webkit.transitions.swap_next(target);
    }
}

document.addEventListener('load', mwf.webkit.touch_transitions.init, false);
