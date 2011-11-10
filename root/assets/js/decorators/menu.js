/**
 * MWF Decorator class for creating and manipulating menus and menu items.
 * This decorator class aims to simplify the process of adding below items to
 * the MWF menu element:
 * 
 * -link list
 * -detailed link list
 * -text items
 * -checkboxes
 * -radio buttons
 * 
 * The class does not require JQuery or third party Javascript library. 
 * 
 * Example Link Menu: 
 * 
 * var menu = new mwf.decorators.menu();
 * 
 * //Set menu's title.
 * menu.setTitle("Simple Link Menu");
 * 
 * //Add to link menu items.
 * menu.addMenuLinkItem("Mobile Web Framework", "http://mwf.ucla.edu");
 * menu.addMenuLinkItem("UCLA Mobile Page", "http://m.ucla.edu");
 * 
 * //Finally, render the menu.
 * document.body.appendChild(menu.render());
 * 
 * @namespace mwf.decorator
 * @author zkhalapyan
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111031
 * 
 */

//TEMPORARY: Assure that mwf.decorators namespace exists.
if(typeof mwf == undefined)
{
    var mwf = function(){};
}

if(mwf.decorator == undefined)
{
    mwf.decorator = function(){};
}



mwf.decorator.Menu = function(title)
{   
    
    if(title != undefined)
    {
        this.setTitle(title);
    }
    
    /*********************************************************************
     *                    PRIVATE VARIABLES BELOW                        *
     *********************************************************************/
    
    /**
     * Javascript closeure variable. Utilized by private scope to 
     * access public scope.
     */
    var me = this;
    
    /**
     * Title element for this menu. This should be set using this.setTitle(..)
     * which will either create an H1 or H4 element and set it's text. Class 
     * definition for this element will be set by render().
     */
    var _menuTitle = null; 
    
    /**
     * Stores menu items in an ordered list for this menu.
     */ 
    var _menuItems  = document.createElement('ol');
    
    
    
    /*********************************************************************
     *                     PUBLIC FUNCTIONS BELOW                        *
     *********************************************************************/
    
    /**
     * Private method that wrappes the specified menuItem element inside an <li>
     * element and adds it to the menu list (an <ol> element).
     * 
     * @return Return the added item - yes, the same thing that was passed in.
     */
    this.addMenuItem = function(item)
    {
        //Create new <li> element.
        var li = document.createElement('li');
        
        //Add the item to the new <li> element.
        li.appendChild(item);
        
        //Add the <li> element to them menu's list.
        _menuItems.appendChild(li);
        
        return item;
        
    }
    
    /**
     * Adds a paragraph element with the specified text to the current menu.
     * 
     * @param text The text to be enclosed in a <p> tag and added to the menu.
     * @return Created menu item.
     */
    this.addMenuTextItem = function(text)
    {
        var textItem = document.createElement('p');
        
        //Set the paragraph's text.
        textItem.innerHTML = text;
        
        //Add the paragraph item to the menu's ordered list and return the item.
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
    this.addMenuLinkItem = function(text, url, details)
    {
        var linkItem = createLinkItem(text, url, details);
        
        this.addMenuItem(linkItem);
        
        return linkItem;
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
     * @return The created radio menu item.
     */
    this.addMenuRadioItem = function(name, value, label, details)
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
     * @return The created checkbox menu item.
     */   
    this.addMenuCheckboxItem = function(name, value, label, details)
    {
       return this.addMenuItem(createOptionItem(name, value, label, details, false));
    }
    
    /**
     * Sets the title for this menu. 
     * 
     * @param title The title of the current menu.
     * @param isH1  If true the header is <h1>, otherwise its <h4>.
     */
    this.setTitle = function(title, isH1)
    {
        //If isH1 is not specified, then set it to true.
        isH1 = (isH1 == undefined)? true : isH1;
        
        //Create a title element which is either H1 or H4 tag, decided by isH1.
        _menuTitle = document.createElement((isH1)? 'h1' : 'h4');
        
        //Set the title's text.
        _menuTitle.innerHTML = title;
        
        return this;
    }
    
    /**
     * Returns the first element of the menu.
     * @return The first element of the menu.
     */
    this.getLastMenuItem = function()
    {
        return _menuItems.lastChild;
    }
    
    /**
     * Returns the last element of the menu.
     * @return The last element of the menu.
     */
    this.getFirstMenuItem = function()
    {
        return _menuItems.firstChild;
    }
    
    /**
     * Returns the menu item at a certain index. If the index is negative or is
     * out of bounds, then a null value will be returned.
     * 
     * @return Menu item at specified index.
     */
    this.getMenuItemAt = function(index)
    {
        if(0 < index && index < _menuItems.children.length)
        {
            return _menuItems.children[index];
        }
        
        return null;
    }
    
    /**
     * Returns the number of elements in the menu.\
     * 
     * @return the number of elements in the menu.
     */
    this.size = function()
    {
        return _menuItems.children.length;
    }
    
    /**
     * Creates and returns the finalized menu <div>. This method will correctly
     * set ".menu-first" and ".menu-last" before returning the menu.
     *  
     * @return Finalized MWF menu <div> element.
     */
    this.render = function()
    {
        var menu = document.createElement('div');
        
        //Set menu's class information.
        menu.className = getMenuClass();
        
        //If the title has been set, then set its class information and then
        //add it to the menu. 
        if(_menuTitle != null)
        {
            //The title is always the first element. If _isLight is true,
            //then also include .light in the class information.
            _menuTitle.className = "menu-first " + getTitleClass();
   
            menu.appendChild(_menuTitle);
        }
        
        //In case the title was not set, then the first element in the menu
        //wil be the first item, marked with "menu-first".
        else
        {
            if(_menuItems.firstChild != undefined)
            {  
                _menuItems.firstChild.className += " menu-first";
            }
        }

        //If the last menu item is not undefined, then 
        //set it to have ".menu-last" in its class definition.
        if(_menuItems.lastChild != undefined)
        {
            _menuItems.lastChild.className += " menu-last";
        }
        
        //Add the menu items to the menu <div>.
        menu.appendChild(_menuItems);
 
        return menu;
       
    }
    
    /*********************************************************************
     *                     PRIVATE FUNCTIONS BELOW                       *
     *********************************************************************/
     
    /**
     * Concatenates a class definition string using boolean variables _isFull, 
     * _isDetailed, and _isPadded.
     * 
     * For example, if all the three variables are set to to true, then the 
     * returned string will be, "menu-full menu-detailed menu-padded".
     * 
     */
    var getMenuClass = function()
    {
        
        var menuClass = "";
         
        if(this.isFull())
        {
            menuClass += "menu-full ";
        }
        
        if(this.isDetailed())
        {
            menuClass += "menu-detailed ";
        }
        
        if(this.isPadded())
        {
            menuClass += "menu-padded ";
        }
        
        return menuClass;
    }
    
    var getTitleClass = function()
    {
        var titleClass = "";
        
        if(_isLight)
        {
            titleClass += "light ";
        }
        
        if(_isBlue)
        {
            titleClass += "blue ";
        }
        
        return titleClass;
        
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
        if(details != undefined && details != null)
        {
            //_isDetails has to be true since an element was added that includes
            //details.
            _isDetailed = true;
            
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
    
}

