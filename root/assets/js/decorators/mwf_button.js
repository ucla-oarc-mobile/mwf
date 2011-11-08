
//TEMPORARY: Assure that mwf.decorators namespace exists.
if(mwf == undefined)
{
    var mwf = function(){};
}

if(mwf.decorators == undefined)
{
    mwf.decorators = function(){};
}

mwf.decorators.SingleButton = function()
{
    this.prototype = new mwf.decorators.Button();
    
    
        
    this.render = function(buttonText, buttonURL, buttonCallback)
    {
        var button = createButton(buttonText, buttonURL, buttonCallback);
        
        button.className = getButtonClass();
        
        if(isSet(buttonCallback))
        {
            button.onclick = buttonCallback;
        }
        
        return button;
    }
    
    
}

mwf.decorators.DoubleButton = function()
{
    this.prototype = new mwf.decorators.Button();
    
        
    
    this.render = function (
                            leftButtonText, leftButtonURL, leftButtonCallback,
                            rightButtonText, rightButtonURL, rightButtonCallback
                           )
    {
        
        //Create the left button and set button text, url and class definition. 
        var leftButton = this.createButton(leftButtonText, leftButtonURL,
                                           leftButtonCallback, true);


        //Create the right button and set button text, url and class definition.
        var rightButton = this.createButton(rightButtonText, rightButtonURL,
                                            rightButtonCallback, false);
        
        
        //Create a div and add to it both buttons.
        var buttonsDiv = document.createElement('div');
        buttonsDiv.className = getButtonsClass();
        buttonsDiv.appendChild(leftButton);
        buttonsDiv.appendChild(rightButton);
        
        return buttonsDiv;
    }
    
}

mwf.decorators.Button = function()
{
    
        
    /*********************************************************************
     *                    PRIVATE VARIABLES BELOW                        *
     *********************************************************************/
    
    /**
     * Javascript closeure variable. Utilized by private scope to 
     * access public scope.
     */
    var me = this;
    
    /**
     * If true, the div containing the menu will have ".menu-full" in its class
     * definition.
     */
    var _isFull = true;
    
    /**
     * If true, the div containing the menu will have ".menu-padded" in its 
     * class definition.
     */
    var _isPadded = true;
    
    /**
     * If true, menu title will have ".light" in its class definition.
     */
    var _isLight = false;
    
    
     /*********************************************************************
     *                     PUBLIC FUNCTIONS BELOW                        *
     *********************************************************************/

    
    /**
     * Sets _isPadded.
     * @param isPadded The new value of _isDetailed.
     */   
    this.setIsPadded = function(isPadded)
    {
        _isPadded = isPadded;
    }
    
    /**
     * Sets _isFull.
     * @param isFull The new value of _isDetailed.
     */
    this.setIsFull = function(isFull)
    {
        _isFull = isFull;
    }
    
    /**
     * Sets _isLight.
     * @param isLight The new value of _isLight.
     */
    this.setIsLight = function(isLight)
    {
        _isLight = isLight;
    }
     
    /**
     * Concatenates a class definition string using boolean variables _isFull, 
     * _isDetailed, and _isPadded for buttons.
     * 
     * For example, if all the three variables are set to to true, then the 
     * returned string will be, "menu-full menu-detailed menu-padded".
     * 
     */
    this.getButtonClass = function()
    {
        
        var buttonClass = "";
         
        if(_isFull)
        {
            buttonClass += "button-full ";
        }
        
        if(_isPadded)
        {
            buttonClass += "button-padded ";
        }
        
        if(_isLight)
        {
            buttonClass += "button-light "
        }
        
        return buttonClass;
    }
    
    /**
     * 
     */
    this.createButton = function(buttonText, buttonURL, buttonCallback, isFirst)
    {
        var button = document.createElement('a');
        
        button.innerHTML = buttonText;
        button.href = buttonURL;
        
        //If button's callback is set, then set the <a>'s onclick property.
        if(isSet(buttonCallback))
        {
            buttonCallback.onclick = buttonCallback;
        }    
        
        //If isFirst is defined then the button is grouped with other buttons. 
        //Depending on the value of isFirst, either mark the button as first or
        //last (".button-first" vs. ".button-last").
        if(isSet(isFirst))
        {
            rightButton.className = (isFirst) ? "button-first" : "button-last";
        }
        
        return button;
    }
    
    /*********************************************************************
     *                     PRIVATE FUNCTIONS BELOW                       *
     *********************************************************************/
    var isSet = function(variable)
    {
        return variable != undefined && variable != null;
    }
    
    
    
    
}