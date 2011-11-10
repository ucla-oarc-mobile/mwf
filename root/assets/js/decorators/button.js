
if(typeof mwf == "undefined")
{
    var mwf = function(){};
}

mwf.decorator.Button = function(label, url, callback, isFirst)
{   
    //Create a new anchor element to represent the button.
    var button = document.createElement('a');

    //Set the button's visible text.
    button.innerHTML = label;
    
    //Set the button url.
    button.href = url;

    //If button's callback is set, then set the <a>'s onclick property.
    if(mwf.decorator.isSet(callback))
    {
        button.onclick = callback;
    }    

    //Depending on the value of isFirst, either mark the button as first or
    //last (".button-first" vs. ".button-last").
    if(mwf.decorator.isSet(isFirst))
    {        
        button.className = (isFirst) ? "button-first" : "button-last";
    }
    
    button.setLight = function(isLight)
    {
        mwf.decorator.toggleClass(isLight, this, "button-light");
        return this;
    }

    return button;
    
}

mwf.decorator.SingleButton = function(label, url, callback)
{
   
   var container = document.createElement('div');
   
   container.setFull = function(isFull)
   {
        mwf.decorator.toggleClass(isFull, this, "button-full");
        return this;
   }
   
   container.setPadded = function(isPadded)
   {
       mwf.decorator.toggleClass(isPadded, this, "button-padded");
       return this;
   }
    
   container.setLight = function(isLight)
   {
       mwf.decorator.toggleClass(isLight, this, "button-light");
       return this;
   }
  
   /**
    * Returns the button within the container.
    */
   container.getButton = function()
   {
       return button;
   }
   
   /**
    * Create a button to be contained inside the div tag. To access this button
    * use getButton() method.
    */
   var button = mwf.decorator.Button(label, url, callback);
   
   //Set the default values.
   container.setFull(true);
   container.setPadded(true);
   container.setLight(true);
   
   //Append the created button to the div container.
   container.appendChild(button);
   
   return container;
}

mwf.decorator.DoubleButton = function(firstLabel, firstUrl, firstCallback,
                                      secondLabel, secondUrl, secondCallback)
{
   
   var container = document.createElement('div');
   
   container.setFull = function(isFull)
   {
        mwf.decorator.toggleClass(isFull, this, "button-full");
        return this;
   }
   
   container.setPadded = function(isPadded)
   {
       mwf.decorator.toggleClass(isPadded, this, "button-padded");
       return this;
   }
    
   container.setLight = function(isLight)
   {
       mwf.decorator.toggleClass(isLight, this, "button-light");
       return this;
   }
   
   container.getFirstButton = function()
   {
       return firstButton;
   }
  
   container.getSecondButton = function()
   {
       return secondButton;
   }
   
   var firstButton  = mwf.decorator.Button(firstLabel, firstUrl, firstCallback, true);
   var secondButton = mwf.decorator.Button(secondLabel, secondUrl, secondCallback, false);
   
   container.setFull(true);
   container.setPadded(true);
   container.setLight(true);
   
   container.appendChild(firstButton);
   container.appendChild(secondButton);
   
   return container;
   
}

mwf.decorator.TopButton = function(label, url, callback)
{
    var topButton = mwf.decorator.SingleButton(label, url, callback);
    
    var button = topButton.getButton();
    
    button.id = "button-top";
    
    topButton.setBasic = function(isBasic)
    {
       mwf.decorator.toggleClass(!isBasic, button, "not-basic");
       return this;
    }
    
    //By default, the top button is not basic.
    topButton.setBasic(false);
    
    return topButton;
}


