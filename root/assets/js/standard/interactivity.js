mwf.standard.interactivity = new function(){
    
    /**
     * @param object ele DOM/jQuery object
     */
    this.init = function(ele){
        
        var addTriggers = function(ele){
            // find t- definitions on the element defined as .trigger
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
            
            var target = this,
                targetContainer = mwf.standard.interactivity.getHandlerElement(target),
                handlerName = mwf.standard.interactivity.getHandlerName(target),
                execHandler = mwf.standard.interactivity.getExecHandler(handlerName),
                initHandler = mwf.standard.interactivity.getInitHandler(handlerName),
                execContainerHandler = mwf.standard.interactivity.getExecContainerHandler(handlerName),
                initContainerHandler = mwf.standard.interactivity.getInitContainerHandler(handlerName);
            
            if(initContainerHandler)
                initContainerHandler.call(targetContainer);
            
            if(initHandler)
                initHandler.call(target);
            
            if(execContainerHandler)
                $(trigger).click(function(){execContainerHandler.call(targetContainer)});
            
            if(execHandler)
                $(trigger).click(function(){execHandler.call(target)});
            
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
    
    this.executeTarget = function(name){
        
        
        
    };
    
    var handlers = {};
    
    this.registerHandler = function(name, callbacks){
        
        handlers[name] = callbacks;
        
    };
    
    this.getExecHandler = function(name){
        
        return getHandler(name, 'exec');
        
    };

    this.getInitHandler = function(name){
        
        return getHandler(name, 'init');
        
    };
    
    this.getExecContainerHandler = function(name){
        
        return getHandler(name, 'execContainer');
        
    };

    this.getInitContainerHandler = function(name){
        
        return getHandler(name, 'initContainer');
        
    };
    
    var getHandler = function(name, type){
        
        return typeof handlers[name] == 'object' && typeof handlers[name][type] == 'function' 
            ? handlers[name][type] 
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
