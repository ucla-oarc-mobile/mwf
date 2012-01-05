/**
 * MWF Decorator class for creating and manipulating form elements.
 * 
 * The class does not require JQuery or third party Javascript library, but 
 * depends on mwf.decorator class definition.

 *  
 * @namespace mwf.decorator.Form
 * @dependency mwf.decorator
 * @author zkhalapyan
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111115
 * 
 */

mwf.decorator.Form = function(title)
{
    
    /**
     * A CSS class name that indicates the first element in a list of elements.
     */
    var FIRST_MARKER = "form-first";
    
    /**
     * A CSS class name that indicates the last element in a list of elements.
     */
    var LAST_MARKER  = "form-last";
    
    var form = document.createElement("form");
    
    var attributes = [
                        new mwf.decorator.Attribute("Padded",   true, "form-padded"),
                        new mwf.decorator.Attribute("Full",     true, "form-full")
                     ];
    
    mwf.decorator.addAttributes(form, attributes);
    
    /**  
     * Sets the title of this form. If the specified title is null or 
     * undefined, then the form's title, if it exists, will be removed.
     * 
     * @param title The title to set.
     */
    form.setTitle = function(title)
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
    form.getTitle = function()
    {
        return (this._title)? this._title : null;
    }
    
    
    /**
     * Prepends an arbitrary DOM element to the current form.
     * 
     * @return This form element.
     */
    form.addItem = function(item)
    {
        mwf.decorator.append(this, item, FIRST_MARKER, LAST_MARKER); 
        
        return this;
    }

    
    /**
     * Appends a new text block element to the current content.
     * 
     * @return This form.
     */
    form.addTextBlock = function(text)
    {   
        //Create a new <p> tag and set its contents to equal the specified text.
        var textBlock = document.createElement('p');
        textBlock.innerHTML = text | "";
        
        return this.addItem(textBlock);

    }
    
    /**
     * Appends a text box with a specified name and ID attributes to the 
     * current form.
     * 
     * @param name The name of the text box input item.
     * @param id The ID of the new text box input item.
     * 
     * @return This form.
     */
    form.addTextBox = function(name, id)
    {
        var textBox = document.createElement('input');
        
        textBox.name = name || null;
        textBox.id   = id || null;
        
        return this.addItem(textBox);
    }
    
    /**
     * Appends a submit button to the current form.
     * 
     * @param text The visible text for the submit button.
     * @param callback The callback function for the submit button's onclick
     *        event listener.
     *        
     * @return This form.
     */
    form.addSubmitButton = function(text, callback)
    {
        var submitButton = document.createElement('input');
        
        submitButton.type = 'submit';
        submitButton.value = text;
        submitButton.onclick = callback || null;
        
        return this.addItem(submitButton);
    }
    
    form.setTitle(title);
   
    return form;
}

