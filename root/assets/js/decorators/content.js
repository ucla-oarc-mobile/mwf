if(typeof mwf == "undefined")
{
    var mwf = function(){};
}

mwf.decorator.Content = function(title, text)
{
    
    var firstMarker = "content-first";
    var lastMarker  = "content-last";
    
    var content = document.createElement("div");
    
    
    //If an initial title was specified, then set this conent's title.
    if(mwf.decorator.isSet(title))
    {
        this.setTitle(title);
    }
    
    
    //If initial text is specified, then add it to the content as a text block.
    if(mwf.decorator.isSet(text))
    {
        this.addTextBlock(text);
    }
    
    /**  
     * Sets the title of this content. If the specified title is null or 
     * undefined, then the content's title, if it exists, will be removed.
     * 
     * @param title The title of the content to set.
     */
    content.setTitle = function(title)
    {
        if(!mwf.decorator.isSet(title) && mwf.decorator.isSet(this.contentTitle))
        {
            this.removeChild(this.contentTitle);
            this.contentTitle = null;
        }
        else
        {
            mwf.decorator.prepend(this, mwf.decorator.ContentTitle(title), firstMarker, lastMarker);
        }
        
        
    }
    
    content.getTitle = function()
    {
        return (mwf.decorator.isSet(this.contentTitle))? this.contenTitle:null;
    }
    
    
    
    content.addItem = function(contentItem)
    {
        content.appendChild(contentItem);
        
    }
    
    content.addButton = function(labe, url, callback)
    {
        
    }
    
    content.addTextBlock = function(text)
    {
        
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
    
    return content;
}

mwf.decorator.ContentTitle = function(title, isH4)
{
    var contentTitle = document.createElement((isH4)? 'h4' : 'h1');
    
    contentTitle.innerHTML = title;
    
    contentTitle.setLight = function(isLight)
    {
        mwf.decorator.toggleClass(isLight, this, "light");
        return this;
    }
    
    //Set defaults.
    contentTitle.setLight(false);
    
    return contentTitle;
    
}