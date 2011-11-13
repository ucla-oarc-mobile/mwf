if(typeof mwf == "undefined")
{
    var mwf = function(){};
}

mwf.decorator.Content = function(title, text)
{
    
    var firstMarker = "content-first";
    var lastMarker  = "content-last";
    
    var content = document.createElement("div");
    
    /**  
     * Sets the title of this content. If the specified title is null or 
     * undefined, then the content's title, if it exists, will be removed.
     * 
     * @param title The title of the content to set.
     */
    content.setTitle = function(title)
    {
        //If current element has a title, then unset it. 
        if(this.mwfTitle)
        {
            mwf.decorator.remove(this, this.mwfTitle, firstMarker, lastMarker);
            this.mwfTitle = null;
        }
        
        //Set title, if specified.
        if(title)
        {
            //Create a new title to add to the element, and save it in a member 
            //variable mwfTitle.
            this.mwfTitle = mwf.decorator.Title(title);
            
            //Prepend the new title to the content.
            mwf.decorator.prepend(this, this.mwfTitle, firstMarker, lastMarker);
            
        }
        
        
        
    }
    
    /**
     * Returns the current elements title if it's set; null otherwise. 
     * @return The current elements title if it's set; null otherwise. 
     */
    content.getTitle = function()
    {
        return (this.mwfTitle)? this.mwfTitle : null;
    }
    
    
    /**
     * Prepends an arbitrary DOM element to the current content.
     * 
     * @return This content element.
     */
    content.addItem = function(contentItem)
    {
        mwf.decorator.append(this, contentItem, firstMarker, lastMarker); 
    }
    
    content.addButton = function(label, url, callback)
    {
        mwf.decorator.append(this, 
                             mwf.decorator.ContentButton(label, url, callback),
                             firstMarker,
                             lastMarker);
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
        mwf.decorator.append(this, textBlock, firstMarker, lastMarker);
        
        return this;
    }
    
    content.setPadded = function(isPadded)
    {
        mwf.decorator.toggleClass(isPadded, this, "content-padded");
        return this;
    }
    
    content.setFull = function(isFull)
    {
        mwf.decorator.toggleClass(isFull, this, "content-full");
        return this;
    }
    
    //Set defaults.
    content.setFull(true);
    content.setPadded(true);
    
    content.setTitle(title);
    content.addTextBlock(text);
   
    return content;
}



mwf.decorator.ContentButton = function(label, url, callback)
{
    //Not implemented yet.
}