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
        obj.className = obj.className.replace(className, "");   
    }
    
    //This will prevent tangling class attributes as such
    //<a class></a>.
    if(obj.className.length == 0)
    {
        obj.className = null;
    }
}
    

