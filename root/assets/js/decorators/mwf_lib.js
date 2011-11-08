var MWFLib = function()
{
    
   
    
    
}


MWFLib.createSingleButton = function(buttonText, buttonCallback)
{
   return $('<a>')
            .attr("class", "button-full button-padded")
            .text(buttonText)
            .click(buttonCallback);
        
}

/**
 * 
 */
MWFLib.createDoubleButton = function(leftButtonText, leftButtonCallback, 
                                     rightButtonText, rightButtonCallback)
{
   
    var leftButton = $('<a>')
                         .attr("class", "button-light button-first")
                         .text(leftButtonText)
                         .click(leftButtonCallback);

    var rightButton = $('<a>')
                         .attr("class", "button-light button-last")
                         .text(rightButtonText)
                         .click(rightButtonCallback);

    return  $('<div>')
             .attr("class", "button-full button-padded")
             .append(leftButton)
             .append(rightButton);

}   


/**
 * MWF CONTENT
 */
var MWFContent = function()
{
    
}

MWFContent.createTitle = function(titleText)
{
    return $("<h1>")
            .attr("class", "content-first light")
            .text(titleText);

 
}

MWFContent.createSimpleContent = function createContent(titleText, contentText)
{
    
    var contentPar = $('<p>')
                        .attr("class", "content-last")
                        .html(contentText);
    
    return $('<div>')
              .attr("class", "content-full content-padded")
              .append(MWFContent.createTitle(titleText))
              .append(contentPar);
    
}



/**
 * MWF MENU
 */
var MWFMenu = function(titleText)
{
    var menuList = $('<ol>');
    var menu     = $('<div>')
                         .attr("class", "menu-full menu-detailed menu-padded")
                         .append(createMenuTitle(titleText))
                         .append(menuList);
                         
   
    
    this.getMenu = function()
    {
        menuList.children().attr("class", "");
        
        return menu;
    }
    
    this.addMenuItem = function(item)
    {
        menuList.append($('<li>').append(item));
    }
    
}

MWFMenu.createMenuTitle = function(titleText)
{
    var header = $("<h1>");
    header.attr("class", "menu-first light");
    header.text(titleText);

    return header;
}