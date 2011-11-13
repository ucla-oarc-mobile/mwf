if(typeof mwf == "undefined")
{
    var mwf = function(){};
}


mwf.decorator = function(){};


/**
 * Returns true if the specified variable is neither undefined nor null.
 * @return true, if the specified variable is neither undefined nor null.
 */
mwf.decorator.isSet = function(variable)
{
    return variable != undefined && variable != null;
}

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
            obj.className += ((obj.className.length > 0)?" ":"") + className;
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
        obj.className = obj.className.replace(/^\s+|\s+$/g,"");
    }
}

mwf.decorator.setClass = function(obj, className)
{
    mwf.decorator.toggleClass(true, obj, className);
}

mwf.decorator.unsetClass = function(obj, className)
{
    mwf.decorator.toggleClass(false, obj, className);
}

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

mwf.decorator.remove = function(container, element, firstMarker, lastMarker)
{
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
