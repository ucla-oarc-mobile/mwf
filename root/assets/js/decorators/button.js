/**
 * MWF Decorator class for creating and manipulating Buttons.
 * 
 * Example Use: 
 * 
 *
 *  //Create a single button and append it to the document.
 *  var button = mwf.decorator.SingleButton("Hello World", "http://m.ucla.edu");
 *  document.body.appendChild(button.setLight(true));
 *  
 *  
 *  //Create a double button.
 *  var buttons = mwf.decorator.DoubleButton("Hello World 1", "http://m.ucla.edu", null,
 *                                           "Hello World 2", "http://m.ucla.edu", null);
 *
 *  //Set the buttons to not be light.
 *  buttons.setLight(false);
 *  
 *  //Set the first button to be light.
 *  buttons.getFirstButton().setLight(true);
 *  
 *  //Append the buttons to the document.
 *  document.body.appendChild(buttons);
 *
 *
 * @namespace mwf.decorator.Button
 * @dependency mwf.decorator
 * @author zkhalapyan
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111115
 * 
 */


/**
 * Creates a simple button provided the label, the url, and the callback 
 * function. Acts as a building block for SingleButton and DoubleButton.
 * 
 * @param label    The visible label for the button.
 * @param url      The URL for the anchor within the button.
 * @param callback The onclick handler callback for this button.
 */
mwf.decorator.Button = function(label, url, callback)
{   
    //Create a new anchor element to represent the button.
    var button = document.createElement('a');

    /**
     * Sets a new label for this button. The label is what's visible to the
     * front user and is encapsulated inside an anchor tag.
     */
    button.setLabel = function(label)
    {
        if(label)
        {
            this.innerHTML = label;
        }
    }
    
    /**
     * Sets the URL for this button. The URL will be actually be the value of
     * the href attribute of the underlying anchor tag. 
     */
    button.setURL = function(url)
    {
        if(url)
        {
            this.href = url;
        }
    }
    
    /**
     * Sets the on click listener for this button. 
     */
    button.click = function(callback)
    {
        //If button's callback is set, then set the <a>'s onclick property.
        if(callback)
        {
            button.onclick = callback;
        }   
    }
    
    button.setLabel(label);
    button.setURL(url);
    button.click(callback);

    mwf.decorator.addAttribute(button, new mwf.decorator.Attribute("Light",  true, "button-light"));
   
    return button;
    
}

/**
 * Creats a single button wrapped inside a <div> tag. Specifying a URL or a 
 * callback function is optional.
 * 
 * Example Use:
 * 
 *  var button = mwf.decorator.SingleButton("Hello World", "http://google.com");
 *  button.setLight(false);
 *  document.body.appendChild(button);
 * 
 * 
 * @param label    The visible label for the button.
 * @param url      The URL for the anchor within the button.
 * @param callback The onclick handler callback for this button.
 */
mwf.decorator.SingleButton = function(label, url, callback)
{
   
   var container = document.createElement('div');
   
   var attr = mwf.decorator.Attribute;

   var attributes = [
                        new attr("Padded", true, "button-padded"),
                        new attr("Full",   true, "button-full"),
                        new attr("Light",  true, "button-light")
                     ];

   mwf.decorator.addAttributes(container, attributes);

   /**
    * Create a button to be contained inside the div tag. To access this button
    * use getButton() method.
    */
   var button = mwf.decorator.Button(label, url, callback);
   
   /**
    * Returns the button within the container.
    */
   container.getButton = function()
   {
       return button;
   }
   
   container.click    = button.click;
   container.setLabel = button.setLabel;
   container.setURL   = button.setURL;
   
   //Append the created button to the div container.
   container.appendChild(button);
   
   return container;
}

/**
 * Convinience method designed to bypass the hassle with creating a DoubleButton
 * with no callbacks, or URLs. The method takes only two parameters - the first
 * button label, and the second button label. 
 * 
 * @param firstLabel     The visible label for the first button.
 * @param secondLabel    The visible label for the second button.
 */
mwf.decorator.SimpleDoubleButton = function(firstLabel, secondLabel)
{
    return mwf.decorator.DoubleButton(firstLabel, null, null, 
                                      secondLabel, null, null);
}

/**
 * Creates a double button with the provided labels, urls, and callbacks.
 * Specifying callback or URL values for either button is optional. 
 * 
 * @param firstLabel     The visible label for the first button.
 * @param firstUrl       The URL for the anchor within the first button.
 * @param firstCallback  The onclick handler callback for first button.
 * @param secondLabel    The visible label for the second button.
 * @param secondUrl      The URL for the anchor within the second button.
 * @param secondCallback The onclick handler callback for second button.
 */
mwf.decorator.DoubleButton = function(firstLabel, firstUrl, firstCallback,
                                      secondLabel, secondUrl, secondCallback)
{
   
   /**
    * A CSS class name that indicates a first element in a list of elements.
    */
    var FIRST_MARKER = "button-first";

   /**
    * A CSS class name that indicates the last element in a list of elements.
    */
   var LAST_MARKER  = "button-last";

   var container = document.createElement('div');
   
   var attr = mwf.decorator.Attribute;

   var attributes = [
                        new attr("Padded", true, "button-padded"),
                        new attr("Full",   true, "button-full"),
                        new attr("Light",  true, "button-light")
                     ];

   mwf.decorator.addAttributes(container, attributes);
   
   
   container.getFirstButton = function()
   {
       return firstButton;
   }
  
   container.getSecondButton = function()
   {
       return secondButton;
   }
   
   var firstButton  = mwf.decorator.Button(firstLabel, firstUrl, firstCallback);
   var secondButton = mwf.decorator.Button(secondLabel, secondUrl, secondCallback);

   mwf.decorator.append(container, firstButton, FIRST_MARKER, LAST_MARKER);
   mwf.decorator.append(container, secondButton, FIRST_MARKER, LAST_MARKER);
   
   return container;
   
}

/**
 * Creates a top button provided the label, url, and callback values.
 * 
 * @param label    The visible label for the button.
 * @param url      The URL for the anchor within the button.
 * @param callback The onclick handler callback for this button.
 */
mwf.decorator.TopButton = function(label, url, callback)
{
    var topButton = mwf.decorator.SingleButton(label, url, callback);
    
    var button = topButton.getButton();
    
    button.id = "button-top";
    
    //This part cannot really be done by attributes, as it's a negation. 
    topButton.setBasic = function(isBasic)
    {
       mwf.decorator.toggleClass(!isBasic, button, "not-basic");
       return this;
    }
    
    //By default, the top button is not basic.
    topButton.setBasic(false);
    
    return topButton;
}


