Function.prototype.inherit = function( parentClassOrObject )
{ 
	if ( parentClassOrObject.constructor == Function ) 
	{ 
		//Normal Inheritance 
		this.prototype = new parentClassOrObject;
		this.prototype.constructor = this;
		this.prototype.parent = parentClassOrObject.prototype;
	} 
	else 
	{ 
		//Pure Virtual Inheritance 
		this.prototype = parentClassOrObject;
		this.prototype.constructor = this;
		this.prototype.parent = parentClassOrObject;
	} 
    
	return this;
} 

if(typeof mwf == undefined)
{
    var mwf = function(){};
}


mwf.decorator = function() 
{
    
    /**
     * Javascript closeure variable. Utilized by private scope to 
     * access public scope.
     */
    var me = this;    
    
    var _isFull = true;
    
    var _isPadded = true;

    var _isDetailed = true;
    
    var _isLight = true;
    
    
    /**
     * Sets _isDetailed.
     * @param isDetailed The new value of _isDetailed.
     */
    this.setDetailed = function(isDetailed)
    {
        _isDetailed = isDetailed;
    }
    
    /**
     * Returns _isDetailed.
     * @return _isDetailed.
     */
    this.isDetailed = function()
    {
        return _isDetailed;
    }
    
    /**
     * Sets _isPadded.
     * @param isPadded The new value of _isDetailed.
     */   
    this.setPadded = function(isPadded)
    {
        _isPadded = isPadded;
    }
    
    /**
     * Returns _isPadded.
     * @return _isPadded.
     */
    this.isPadded = function()
    {
        return _isPadded;
    }
    
    /**
     * Sets _isFull.
     * @param isFull The new value of _isDetailed.
     */
    this.setFull = function(isFull)
    {
        _isFull = isFull;
    }
    
    /**
     * Returns _isFull.
     * @return _isFull.
     */
    this.isFull = function()
    {
        return _isFull;
    }
    
    /**
     * Sets _isLight.
     * @param isLight The new value of _isLight.
     */
    this.setLight = function(isLight)
    {
        _isLight = isLight;
    }

    /**
     * Returns _isLight.
     * @return _isLight.
     */
    this.isLight = function()
    {
        return _isLight;
    }
    
}
mwf.decorator.inherit(document.createElement('div'));


mwf.decorator.test = function()
{
    this.render = function()
    {
        this.setLight(false);
        console.log(this.isLight());
    }
}

mwf.decorator.test.inherit(mwf.decorator);




