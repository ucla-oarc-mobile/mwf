/**
 * MWF Decorator class for creating and manipulating content elements.
 * 
 * The class does not require JQuery or third party Javascript library, but 
 * depends on mwf.decorator class definition.
 * 
 * Example Use: 
 * 
 *  var content = mwf.decorator.Content("Hello World", "Some Text.");
 *  
 *  content.setTitle("New Title");
 *  content.addTextBlock("Some other text.");
 *  
 *  document.body.appendChild(content);
 *  
 * @namespace mwf.decorator.Menu
 * @dependency mwf.decorator
 * @author zkhalapyan
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111115
 * 
 */

mwf.decorator.Content = function(title, text)
{
    
    /**
     * A CSS class name that indicates the first element in a list of elements.
     */
    var FIRST_MARKER = "menu-first";
    
    /**
     * A CSS class name that indicates the last element in a list of elements.
     */
    var LAST_MARKER  = "menu-last";
    
    var content = document.createElement("div");
    
    var attributes = [
                        new mwf.decorator.Attribute("Padded",   true, "content-padded"),
                        new mwf.decorator.Attribute("Full",     true, "content-full")
                     ];
    
    mwf.decorator.addAttributes(content, attributes);
    
    /**  
     * Sets the title of this content. If the specified title is null or 
     * undefined, then the content's title, if it exists, will be removed.
     * 
     * @param title The title of the content to set.
     */
    content.setTitle = function(title)
    {
        //If current element has a title, then unset it. 
        if(this._title)
        {
            mwf.decorator.remove(this, this._title, FIRST_MARKER, LAST_MARKER);
            this._title = null;
        }
        
        //Set title, if specified.
        if(title)
        {
            //Create a new title to add to the element, and save it in a member 
            //variable.
            this._title = mwf.decorator.Title(title);
            
            //Prepend the new title to the content.
            mwf.decorator.prepend(this, this._title, FIRST_MARKER, LAST_MARKER);
            
            
        }
    }
    
    /**
     * Returns the current elements title if it's set; null otherwise. 
     * @return The current elements title if it's set; null otherwise. 
     */
    content.getTitle = function()
    {
        return (this._title)? this._title : null;
    }
    
    
    /**
     * Prepends an arbitrary DOM element to the current content.
     * 
     * @return This content element.
     */
    content.addItem = function(contentItem)
    {
        mwf.decorator.append(this, contentItem, FIRST_MARKER, LAST_MARKER); 
    }
    
    content.addButton = function(label, url, callback)
    {
        mwf.decorator.append(this, 
                             mwf.decorator.ContentButton(label, url, callback),
                             FIRST_MARKER,
                             LAST_MARKER);
    }
    
    /**
     * Prepends a new text block element to the current content.
     * 
     * @return This content.
     */
    content.addTextBlock = function(text)
    {
        if(!text)
            return this;
        
        //Create a new <p> tag and set its contents to equal the specified text.
        var textBlock = document.createElement('p');
        textBlock.innerHTML = text;
        
        //Append the text block to the content.
        mwf.decorator.append(this, textBlock, FIRST_MARKER, LAST_MARKER);
        
        return this;
    }
    

    
    content.setTitle(title);
    content.addTextBlock(text);
   
    return content;
}



mwf.decorator.ContentButton = function(label, url, callback)
{
    //Not implemented yet.
}