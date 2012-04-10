mwf.standard.interactivity.expandable = {
    
    'handler': {
    
        'init':function(){

            if(!$(this).hasClass('expanded'));
                $(this).addClass('collapsed');

        },

        'initContainerAfter':function(){

            if($(this).find('.expanded').length == 0 && $(this).find('.expanded').siblings(':not(.target)').length == 0)
                $(this).addClass('collapsed');

        },

        'exec':function(){

            if($(this).hasClass('collapsed')){
                
                $(this).removeClass('collapsed').addClass('expanded');
                
                /**
                 * @todo add CSS 3 functioality to transitions - which requires
                 * some additional Javascript
                 */
                
                /*
                
                // Workaround for CSS 3 that solves issue with heigh transition
                // requiring explicit height value for both start and end state.
                // The timers here are responsible for removing the height CSS
                // property once the transition occurs, so that manipulating the
                // inner contents to change the heigh of the element is allowed.
                
                $(this).height($(this).height());
                
                var duration = $(this).css('-webkit-transition-duration'), ele = this;
                
                if(duration.substring(duration.length-2) != 'ms'){
                    if(duration.substring(duration.length-1) == 's')
                        duration = duration.substring(0,duration.length-1);
                    duration = parseInt(duration)*1000;
                }else{
                    duration = parseInt(duration.substring(0,duration.length-2));
                }
                
                setTimeout(function(){
                    
                    var p = $(ele).css('-webkit-transition-property');
                    
                    $(ele).css('-webkit-transition-property', 'none')
                          .css('-webkit-transition-duration', 0)
                          .css('height', '');
                          
                    setTimeout(function(){
                        
                        $(ele).css('-webkit-transition-property', p)
                              .css('-webkit-transition-duration', duration);
                        
                    }, parseInt(duration));
                          
                }, parseInt(duration));
                
                */
                
            }else{
                
                $(this).removeClass('expanded').addClass('collapsed');
                
            }

        },

        'execContainerAfter':function(){

            if($(this).children('.expanded').length > 0){
                if($(this).hasClass('collapsed'))
                    $(this).removeClass('collapsed').addClass('expanded');
            }else{
                if($(this).hasClass('expanded') && $(this).find('.collapsed').siblings(':not(.collapsed)').length == 0)
                    $(this).removeClass('expanded').addClass('collapsed');
            }

        }

    }
    
};

mwf.standard.interactivity.registerHandler('expandable', 'click', mwf.standard.interactivity.expandable.handler);