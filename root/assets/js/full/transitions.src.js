mwf.webkit.transitions = new function() {
    this.init = function () {
        var activeElement = $('.webkit-transition-element + .active').first();
        if(activeElement.length == 0)
            activeElement = $('.webkit-transition-element').first().addClass('active');
        activeElement.nextAll('.webkit-transition-element').addClass('inactive-next');
        activeElement.prevAll('.webkit-transition-element').addClass('inactive-prev');
        $('.webkit-transition-trigger-prev').click(mwf.webkit.transitions.swap_prev_event);
        $('.webkit-transition-trigger-next').click(mwf.webkit.transitions.swap_next_event);
    };

    this.swap_prev = function(initialElement) {
        if(!$(initialElement).hasClass('webkit-transition-element'))
            initialElement = $(initialElement).parents('.webkit-transition-element').first();
        var finalElement = initialElement.prev('.webkit-transition-element');
        if(finalElement.length == 0)
            return;
        initialElement.addClass('inactive-next').removeClass('active');
        finalElement.addClass('active').removeClass('inactive-prev');
    }

    this.swap_next = function(initialElement) {
        if(!$(initialElement).hasClass('webkit-transition-element'))
            initialElement = $(initialElement).parents('.webkit-transition-element').first();
        var finalElement = initialElement.next('.webkit-transition-element');
        if(finalElement.length == 0)
            return;
        initialElement.addClass('inactive-prev').removeClass('active');
        finalElement.addClass('active').removeClass('inactive-next');
    }

    this.swap_prev_event = function(e) {
        if (!e) var e = window.event;
        var trigger = (window.event) ? e.srcElement : e.target;
        mwf.webkit.transitions.swap_prev(trigger);
    }

    this.swap_next_event = function(e) {
        if (!e) var e = window.event;
        var trigger = (window.event) ? e.srcElement : e.target;
        mwf.webkit.transitions.swap_next(trigger);
    }
}

document.addEventListener('load', mwf.webkit.transitions.init, false);
