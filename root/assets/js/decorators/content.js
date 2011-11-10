if(typeof mwf == "undefined")
{
    var mwf = function(){};
}

mwf.decorator.Content = function()
{
    var content = document.createElement("div");
    
    
    content.setTitle = function(title)
    {
        this.appendChild(mwf.decorator.ContentTitle(title));
    }
    
    
    return content;
}

mwf.decorator.ContentTitle = function(title)
{
    var contentTitle = document.createElement('h1');
    
    contentTitle.innerHTML = title;
    
    contentTitle.setLight = function(isLight)
    {
        
    }
    
    contentTitle.isFull = function(isFull)
    {
        
    }
    
    
    return contentTitle;
    
}