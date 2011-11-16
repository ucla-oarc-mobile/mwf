/**
 * MWF Decorator class that encapsulates common behavior among specific MWF 
 * decorator classes such as Content, Button, and Menu. This class includes 
 * functionality for appending, prepending, and removing elements from a list
 * of elements while keeping track of first and last markers, functionality for 
 * setting and unsetting class names from an object and also for creating non-
 * specific, reusable elements such as a Title object.
 * 
 * The class does not require JQuery or third party Javascript library, but will
 * create an empty mwf namespacem, if one doesn't already exist.
 * 
 * @namespace mwf.decorator
 * @author zkhalapyan
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111115
 * 
 */


//Define MWF namespace, if it doesn't exist.
var mwf = mwf || function (){};

//Create a namespace for mwf.decorator.
mwf.decorator = function(){};

/**
 * Sets or unsets CSS classes for an object. Here, definition of 'set' is a
 * logical equivalent of add a class and 'unset' is equivalent to remove a 
 * class. 
 * 
 * Example:
 * 
 * //Create a div element.
 * var divObj = document.createElement('div');
 * 
 * //Add 'menu-first' class to the div object.
 * //Result: <div class="menu-first"> </div>
 * mwf.decorator.toggleClass(true, divObj, "menu-first");
 * 
 * //Add 'cool-div' class to the div object.
 * //Result: <div class="menu-first cool-div"> </div>
 * mwf.decorator.toggleClass(true, divObj, "cool-div");
 * 
 * //Remove menu-first class from the div object.
 * //Result: <div class="cool-div"> </div>
 * mwf.decorator.toggleClass(false, divObj, "menu-first");
 * 
 * //Remove 'unexisting-class' class from the div object. 
 * //Output: No change is made.
 * mwf.decorator.toggleClass(false, divObj, "unexisting-class");
 * 
 * @param set       Depending on this value, the class will either be 
 *                  set or unset.
 * @param obj       The object to act upon. 
 * @param className The name of the class to set/unset.
 */
mwf.decorator.toggleClass = function(set, obj, className)
{
    
    //If the specified object is undefined, then return false.
    if(typeof obj == "undefined")
    {
        return;
    }
    
    //If the className property of the object is undefined, then define it to
    //empty string.
    else if(typeof obj.className == "undefined")
    {
        obj.className = "";
    }
    
    //Set class.
    if(set)
    {
        //If the class name is not already included, add it to the object's
        //className property.
        if (obj.className.indexOf(className) == -1)
        { 
            obj.className += ((obj.className.length > 0)? " " : "") + className;
        }     
        
    }
    
    //Unset class.
    else
    {
        //Replace the class name with empty string.
        obj.className = obj.className.replace(className, "");   
    }
    
    //This will prevent tangling class attributes as such
    //<a class></a>.
    if(obj.className.length == 0)
    {
        obj.className = null;
    }
    
    //In case className is not empty, then trim any whitespace either from the 
    //left side or the right side.
    else
    {
        //Remove any trailing or heading extra spaces.
        obj.className = obj.className.replace(/^\s+|\s+$/g,"");
        
        //Remove any double spaces inside the class definition.
        obj.className = obj.className.replace(/\s+/g," ");
    }
}

/**
 * Adds a class name to the sepcified object. If the object already has the
 * class, no duplicate class will be added.
 * 
 * 
 * @param obj       The object to act upon. 
 * @param className The name of the class to set.
 */
mwf.decorator.setClass = function(obj, className)
{
    mwf.decorator.toggleClass(true, obj, className);
}

/**
 * Removes the class name from the object's className member variable. 
 * 
 * @param obj       The object to act upon. 
 * @param className The name of the class to unset.
 */
mwf.decorator.unsetClass = function(obj, className)
{
    mwf.decorator.toggleClass(false, obj, className);
}

/**
 * Prepends an element to the children of the provided container while keeping
 * track of the first and last markers. Think of firstMarker and lastMarker as
 * head and tail of a linked list - then preprend adds the element to the front
 * of the list and updates the head and tail of the list as appropriate.Here,
 * firstMarker and lastMarker are class names such as "menu-first" and 
 * "menu-last". After invoking this method, the first child will have the first
 * marker in its class definition, and the last child will have the last marker
 * in its class definition.
 * 
 * @param container   The container to accept the element.
 * @param element     The element to prepend to the container. 
 * @param firstMarker A class name that specifies a first element("menu-first").
 * @param lastMarker  A class name that specifies a last element("menu-last").
 */
mwf.decorator.prepend = function(container, element, firstMarker, lastMarker)
{
    //Add the last marker to the element to be prepended to the container.
    mwf.decorator.setClass(element, firstMarker);
        
    //If the container does not have any children, then the element will include
    //both first and last markers.
    if(container.children.length == 0)
    {
        mwf.decorator.setClass(element, lastMarker);
    } 
    
    //Handle the case where there is at least one element in the container's 
    //list.
    else 
    {        
        //Remove the first marker from the current first element.
        mwf.decorator.unsetClass(container.firstChild, firstMarker);   
    }
    
    //Append the element to the front of the container's children. I am assuming
    //here that if firstChild is undefined, then appendChild will still append
    //the element at the end.
    container.insertBefore(element, container.firstChild);
}


/**
 * Appends an element to the children of the provided container while keeping
 * track of the first and last markers. Think of firstMarker and lastMarker as
 * head and tail of a linked list - then append adds the element to the end
 * of the list and updates the head and tail of the list as appropriate. Here,
 * firstMarker and lastMarker are class names such as "menu-first" and 
 * "menu-last". After invoking this method, the first child will have the first
 * marker in its class definition, and the last child will have the last marker
 * in its class definition.
 * 
 * @param container   The container to accept the element.
 * @param element     The element to append to the container. 
 * @param firstMarker A class name that specifies a first element("menu-first").
 * @param lastMarker  A class name that specifies a last element("menu-last").
 */
mwf.decorator.append = function(container, element, firstMarker, lastMarker)
{
    
    //Add the last marker to the element to be appended to the container.
    mwf.decorator.setClass(element, lastMarker);
        
    //If the container does not have any children, then the element will include
    //both first and last markers.
    if(container.children.length == 0)
    {
        mwf.decorator.setClass(element, firstMarker);
    } 
    //Handle the case where there is at least one element in the container's 
    //list.
    else 
    {        
        //Remove the last marker from the current last element.
        mwf.decorator.unsetClass(container.lastChild, lastMarker);   
    }
    
    //Append the element to the end of the container's children.
    container.appendChild(element);
    
}

/**
 *
 * @param container   The container from which the element will be removed.
 * @param element     The element to remove from the container.
 * @param firstMarker A class name that specifies a first element("menu-first").
 * @param lastMarker  A class name that specifies a last element("menu-last").
 */
mwf.decorator.remove = function(container, element, firstMarker, lastMarker)
{
    //If the element is not a child of the container, 
    //then return from the function.
    if(element.parentNode != container)
    {
        return;
    }
    
    //Unset both types of markers from the element to be removed.
    mwf.decorator.unsetClass(element, firstMarker);
    mwf.decorator.unsetClass(element, lastMarker);
    
    //Remove the child from the container. 
    container.removeChild(element);
    
    //In case the container has any other elements, then add firstMarker to the
    //first child and lastMarker to the last child of the container.
    if(container.children.length >= 1)
    {
        mwf.decorator.setClass(container.firstChild, firstMarker);
        mwf.decorator.setClass(container.lastChild, lastMarker);
         
    }
    
    
}

/**
 * Creates a non-specific header to be used within content or menu MWF elements.
 * 
 * @param label The visible label of the header/title.
 * @param level The level of the header/title, ranging from 1-4. Default is 1.
 */
mwf.decorator.Title = function(label, level)
{
    level = (1 <= level && level <= 4)? level : 1;
    
    var title = document.createElement("h" + level);

    title.innerHTML = label;
    
    mwf.decorator.addAttribute(title, new mwf.decorator.Attribute("Light", true, "light"));
   
    return title;
    
}

/**
 * Represents an attribute for an object.
 * 
 * @param name      The name of the attribute such as Full, Padded, or Light.
 * @param isSet     The default state of the attribute. If true, will be set.
 * @param className The class name representing this attribute i.e. button-full.
 */
mwf.decorator.Attribute = function(name, isSet, className)
{
    this.name      = name;
    this.className = className;
    this.isSet     = isSet;

}

/**
 * Allows adding class attributes to an object. This allows adding an array
 * of different types of class names that an object might have and produces 
 * setter and getter functions for that class. 
 * 
 * @param obj        The object to add the attribute on.
 * @param attributes An array of Attribute objects to be added to the object.
 * 
 */
mwf.decorator.addAttributes = function(obj, attributes)
{
    
    //Iterate through each attribute and generate getter and setter functions.
    for(var i = 0; i < attributes.length; i++)
    {
        mwf.decorator.addAttribute(obj, attributes[i]);        
    }
}


/**
 * 
 * For example, the below code using the attributes function:
 * 
 *  var attributes = [new mwf.decorator.Attribute("Light", true, "light")];
 *  mwf.decorator.addAttributes(obj, attributes);
 *  
 * Will produce the same code as:
 *  
 *  obj.setLight = function(isLight)
 *  {
 *      mwf.decorator.toggleClass(isLight, this, "light");
 *      return this;
 *  }
 *  
 *  obj.isLight = function()
 *  {
 *      return obj.className.indexOf(attr.className) != -1;
 *  }
 *   
 *  //Set defaults.
 *  obj.setLight(true);
 *  
 *  
 * @param obj  The object to add the attribute on.
 * @param attr The Attribute object to be added to the object.
 */
mwf.decorator.addAttribute = function(obj, attr)
{
    //Generate the setter function.
    obj["set" + attr.name] = function(isAttributeSet)
    {
        mwf.decorator.toggleClass(isAttributeSet, obj, attr.className);
        return obj;
    }

    //Generate the getter function.
    obj["is" + attr.name] = function()
    {
        return obj.className.indexOf(attr.className) != -1;
    }

    //Set the default value.
    obj["set" + attr.name](attr.isSet);
}

