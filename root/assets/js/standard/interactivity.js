mwf.standard.interactivity = new function(){
    
    /**
     * @param object ele DOM/jQuery object
     */
    this.init = function(ele){
        
        var addTriggers = function(ele){
            jQuery.each(ele.className.split(/\s+/), function(){
                if(this.substr(0, 2) == 't-')
                    mwf.standard.interactivity.initTrigger(ele, this.substring(2));
            });
        };
        
        (typeof ele == 'object' ? $(ele).find('.trigger') : $('.trigger')).each(function(){
            
            addTriggers(this);
            
            $(this).find('[class^="t-"]').each(function(){
                addTriggers(this);
            });
            
        });
        
    };
    
    /**
     * @param object ele DOM/jQuery object
     * @param string name name of the trigger
     */
    this.initTrigger = function(trigger, targetName){
        
        $('.'+targetName).each(function(){
            
            var i = mwf.standard.interactivity,
                target = this,
                targetContainer = i.getHandlerElement(target),
                handlerName = i.getHandlerName(target),
                handlerEvent = i.getHandlerEvent(handlerName),
                execHandler = i.getExecHandler(handlerName),
                initHandler = i.getInitHandler(handlerName),
                execContainerHandler = i.getExecContainerHandler(handlerName),
                initContainerHandler = i.getInitContainerHandler(handlerName);
            
            if(initContainerHandler)
                initContainerHandler.call(targetContainer);
            
            if(initHandler)
                initHandler.call(target);
            
            if(execContainerHandler)
                $(trigger).bind(handlerEvent, function(){execContainerHandler.call(targetContainer)});
            
            if(execHandler)
                $(trigger).bind(handlerEvent, function(){execHandler.call(target)});
            
        });
        
    };
    
    this.getHandlerElement = function(target){
        
        var handlerClassNames = mwf.standard.interactivity.getHandlerNames();
        
        if(handlerClassNames.length == 0)
            return false;
        
        var handlerClassNamesJoined = '.'+handlerClassNames.join(', .'),
            ele = $(target).closest(handlerClassNamesJoined);
            
        return ele.length > 0 ? ele.first() : false;
        
    };
    
    this.getHandlerName = function(target){
        
        var handlerClassNames = mwf.standard.interactivity.getHandlerNames();
        
        if(handlerClassNames.length == 0)
            return false;
        
        var handlerClassNamesJoined = '.'+handlerClassNames.join(', .'),
            ele = $(target).closest(handlerClassNamesJoined);
            
        if(ele.length == 0)
            return false;
        
        var handlerClassName = false,
            eleClassNames = ele.attr('class').split(/\s+/);
                
        jQuery.each(eleClassNames, function(){

            if(jQuery.inArray($.trim(this), handlerClassNames) >= 0)
                handlerClassName = $.trim(this);

        });
        
        return handlerClassName;
        
    };
    
    var handlers = {};
    
    this.registerHandler = function(name, event, callbacks){
        
        handlers[name] = {
            'event':event,
            'callbacks':callbacks
        };
        
    };
    
    this.getHandlerEvent = function(name){
        
        return handlers[name].event;
        
    }
    
    this.getExecHandler = function(name){
        
        return getHandlerCallback(name, 'exec');
        
    };

    this.getInitHandler = function(name){
        
        return getHandlerCallback(name, 'init');
        
    };
    
    this.getExecContainerHandler = function(name){
        
        return getHandlerCallback(name, 'execContainer');
        
    };

    this.getInitContainerHandler = function(name){
        
        return getHandlerCallback(name, 'initContainer');
        
    };
    
    var getHandlerCallback = function(name, type){
        
        return typeof handlers[name] == 'object' && typeof handlers[name].callbacks[type] == 'function' 
            ? handlers[name].callbacks[type] 
            : false;
        
    }
    
    this.getHandlerNames = function(){
        
        var c = [], i=0;
        for(var n in handlers){
            c[i++] = n;
        }
        return c;
        
    };
    
    // can use multiple with .closest such as $('...').closest('.expandable', '.transitionable')
    
};

window.addEventListener('load', function(){
    mwf.standard.interactivity.init();
});
