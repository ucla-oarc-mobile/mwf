var mwf = mwf || {};

mwf.decorator.Menu = function(title)
{
    
    var firstMarker = "menu-first";
    var lastMarker  = "menu-last";
    
    var menu = document.createElement('div');
    
    /**  
     * Sets the title of this menu. If the specified title is null or 
     * undefined, then the menu's title, if it exists, will be removed.
     * 
     * @param title The title of the menu to set.
     */
    menu.setTitle = function(title)
    {
        //If current element has a title, then unset it. 
        if(this._title)
        {
            mwf.decorator.unsetClass(this._title, firstMarker); 
            mwf.decorator.unsetClass(this._title, lastMarker); 
            
            if(this._items && this._items.firstChild)
            {
                mwf.decorator.setClass(this._items.firstChild, firstMarker); 
            }
            
            this.removeChild(this._title);
            
            this._title = null;
        }
        
        //Set title, if specified.
        if(title)
        {
            //Create a new title to add to the element, and save it in a member 
            //variable.
            this._title = mwf.decorator.Title(title);
            
            mwf.decorator.setClass(this._title, firstMarker); 
        
            if(this._items && this._items.firstChild)
            {
                mwf.decorator.unsetClass(this._items.firstChild, firstMarker); 
            }
            else
            {
                mwf.decorator.setClass(this._title, lastMarker); 
            }
            
            this.insertBefore(this._title, this.firstChild);
            
        }
        
        return this;
        
    }
    
    /**
     * Returns the current elements title if it's set; null otherwise. 
     * @return The current elements title if it's set; null otherwise. 
     */
    menu.getTitle = function()
    {
        return (this._title)? this._title : null;
    }
    
    
    menu.addMenuItem = function(item)
    {   
        if(!this._items)
        {
            this._items = document.createElement('ol');    
            this.appendChild(this._items);
        }
        
        var listItem = document.createElement('li');
        listItem.appendChild(item);
        
        if(this._items.children.length == 0)
        {
            if(this._title)
            {
               mwf.decorator.unsetClass(this._title, lastMarker); 
            }
        }
        else 
        {
            mwf.decorator.unsetClass(this._items.lastChild, lastMarker);  
        }
    
        mwf.decorator.setClass(listItem, lastMarker);
        
        /*
        if(this._title)
        {
            if(this._items.children.length == 0)
            {
                mwf.decorator.unsetClass(this._title, lastMarker);
                mwf.decorator.setClass(listItem, lastMarker);
            }
            else
            {
                mwf.decorator.unsetClass(this._items.lastChild, lastMarker);
                mwf.decorator.setClass(listItem, lastMarker);
            }
        }
        else
        {
            if(this._items.children.length == 0)
            {
                mwf.decorator.setClass(listItem, firstMarker);
                mwf.decorator.setClass(listItem, lastMarker);
            }
            else
            {
                mwf.decorator.unsetClass(this._items.lastChild, lastMarker);
                mwf.decorator.setClass(listItem, lastMarker);
            }
        }
        */
 
        
        this._items.appendChild(listItem);
        
        return this;
    }
    
    /**
     * Adds a paragraph element with the specified text to the current menu.
     * 
     * @param text The text to be enclosed in a <p> tag and added to the menu.
     * @return Created menu item.
     */  
    menu.addMenuTextItem = function(text)
    {
        var textItem = document.createElement('p');
        
        //Set the paragraph's text.
        textItem.innerHTML = text;
        
        //Add the paragraph item to the menu's ordered list.
        return this.addMenuItem(textItem);
    }
    
     /**
     * Adds a link item to this menu.
     * 
     * @param text    The text of the link item. 
     *                This will be enclosed within an <a> tag.
     * @param url     The URL of the link item.
     * @param details An optional element that adds details section to the item.    
     * 
     * @return Created menu item.         
     */
    menu.addMenuLinkItem = function(text, url, details)
    {
        return this.addMenuItem(createLinkItem(text, url, details));   
    }
    
   
    /**
     * Creates a new radio input element and combines it with a link item to 
     * create a menu item. Clicking the menu item will toggle the radio button.
     *
     * The actual link within the menu has an href attribute of "#".
     * 
     * @param name    The name attribute of the input element.
     * @param value   The value attribute of the input element.
     * @param label   Text label associated with this option item.
     * @param details Details to display about this option.
     *                
     * @return This menu - allowing chained invocation.
     */
    menu.addMenuRadioItem = function(name, value, label, details)
    {
       return this.addMenuItem(createOptionItem(name, value, label, details, true));
    }
    
    /**
     * Creates a new checkbox input element and combines it with a link item to 
     * create a menu item. Clicking the menu item will toggle the button.
     * 
     * The actual link within the menu has an href attribute of "#".
     *
     * @param name    The name attribute of the input element.
     * @param value   The value attribute of the input element.
     * @param label   Text label associated with this option item.
     * @param details Details to display about this option.
     *                
     * @return This menu - allowing chained invocation.
     */   
    menu.addMenuCheckboxItem = function(name, value, label, details)
    {
       return this.addMenuItem(createOptionItem(name, value, label, details, false));
    }
    
        
    /**
     * Creates a new input element and combines it with a link item to create a
     * menu item. Two types of input elements are supported radios and 
     * checkboxes. Clicking the menu item will toggle the checkbox/radio button.
     *
     *
     * @param name    The name attribute of the input element.
     * @param value   The value attribute of the input element.
     * @param label   Text label associated with this option item.
     * @param details Details to display about this option.
     * @param isRadio If true, the option item will be a radio input, checkbox 
     *                otherwise.
     *                
     * @return The created option item.
     */
    var createOptionItem = function(name, value, label, details, isRadio)
    {
        //Create the input element.
        var inputItem = document.createElement('input');

        //Set the input's type, name, and value.
        inputItem.type  = (isRadio)? "radio" : "checkbox";
        inputItem.name  = name;
        inputItem.value = value;

        //Create a standard menu link item and prepend the option button.
        var linkItem = createLinkItem(label, "#", details);
        linkItem.insertBefore(inputItem, linkItem.firstChild);

        //Add an event handler that would toggle the option button's
        //checked attribute on link click.
        linkItem.onclick = function() { 
           this.children[0].checked = !this.children[0].checked;
        };    
        
        return linkItem;
    }
    
    /**
     * Creates a link item, without adding it to the current menu.
     * 
     * @param text    The text of the link item. 
     *                This will be enclosed within an <a> tag.
     * @param url     The URL of the link item.
     * @param details An optional element that adds details section to the item.    
     * 
     * @return Created menu item.         
     */
    var createLinkItem = function(text, url, details)
    {
        var linkItem = document.createElement('a');
        
        linkItem.innerHTML = text;
        linkItem.href = url;
        
        //If details is defined, then add the details text within a span tag.
        if(details)
        {
            menu.setDetailed(true);
            
            linkItem.appendChild(document.createElement('br'));
            linkItem.appendChild(createDetailsSpan(details));
        }
        
        return linkItem;
    }
    
    /**
     * Creates a new <span> element with .smallprint class and with inner html
     * equal to the passed argument.
     * 
     * @param details The text to be enclosed within a <span> tag.
     * @return The created <span> element with class name ".smallprint".
     */
    var createDetailsSpan = function(details)
    {
        var detailsSpan = document.createElement('span');
        
        detailsSpan.innerHTML = details;
        detailsSpan.className = "smallprint";
        
        return detailsSpan;
        
    }
    
    /**
     * Returns the first element of the menu, if it exists. Null otherwise.
     * @return The first element of the menu.
     */
    menu.getFirstMenuItem = function()
    {
        return (this._items) ? this._items.firstChild : null;
    }
    
    /**
     * Returns the last element of the menu, if it exists. Null otherwise.
     * @return The last element of the menu.
     */
    menu.getLastMenuItem = function()
    {
        return (this._items) ? this._items.lastChild : null;
    }
    

    
    /**
     * Returns the menu item at a certain index. If the index is negative or is
     * out of bounds, then a null value will be returned.
     * 
     * @return Menu item at specified index.
     */
    menu.getMenuItemAt = function(index)
    {
        if(this._items && 0 <= index && index < this._items.children.length)
        {
            return this._items.children[index];
        }
        
        return null;
    }
    
    /**
     * Returns the number of elements in the menu.
     * 
     * @return the number of elements in the menu.
     */
    menu.size = function()
    {
        return (this._items) ? this._items.children.length : 0;
    }
    
    menu.setPadded = function(isPadded)
    {
        mwf.decorator.toggleClass(isPadded, this, "menu-padded");
        return this;
    }
    
    menu.setFull = function(isFull)
    {
        mwf.decorator.toggleClass(isFull, this, "menu-full");
        return this;
    }
    
    menu.setDetailed = function(isDetailed)
    {
        mwf.decorator.toggleClass(isDetailed, this, "menu-detailed");
        return this;
    }
    
    //Set defaults.
    menu.setPadded(true);
    menu.setFull(true);
    menu.setDetailed(false);
    menu.setTitle(title);
  
    
    return menu;
}
