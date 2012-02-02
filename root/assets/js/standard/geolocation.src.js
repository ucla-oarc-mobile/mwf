/**
 * Interface:
 *   mwf.touch.geolocation.getType() -> 0|1|2
 *   mwf.touch.geolocation.getTypeName() -> "HTML5 Geolocation"|"Google Gears"|"Unsupported"
 *   mwf.touch.geolocation.getApi() -> Geolocation API (HTML5 or Google Gears)
 *   mwf.touch.geolocation.isSupported() -> boolean
 *   mwf.touch.geolocation.getPosition(onSuccessCallback, onFailureCallback) -> [['latitude']=>decimal, ['longitude']=>decimal, ['accuracy']=>decimal]
 *   mwf.touch.geolocation.getCurrentPosition(onSuccessCallback, onFailureCallback) -> [['latitude']=>decimal, ['longitude']=>decimal, ['accuracy']=>decimal]
 *   mwf.touch.geolocation.watchPosition(onSuccessCallback, onFailureCallback) -> [['latitude']=>decimal, ['longitude']=>decimal, ['accuracy']=>decimal]
 *   mwf.touch.geolocation.clearWatch(watchID)
 */

mwf.touch.geolocation = new function()
{
    var ERROR_MESSAGE = {
        GENERAL: 'Geolocation failure.',
        NO_SUPPORT: 'No geolocation support available.',
        PERMISSION_DENIED: 'Geolocation permission not granted.'
    };
    
    var ERROR = {
        NO_SUPPORT: {
            code: 2,
            message: ERROR_MESSAGE.NO_SUPPORT,
            PERMISSION_DENIED: 1,
            POSITION_UNAVAILABLE: 2,
            TIMEOUT: 3
        }
    };

    var type = -1;
    var position = null;
    var highAccuracy = true;
    
    //The maximum age (in milliseconds) of the reading (this is appropriate as 
    //the device may cache readings to save power and/or bandwidth).
    var timeout = 3000;
    
    //The maximum time (in milliseconds) for which you are prepared to allow 
    //the device to try to obtain a Geo location.
    var geoTimeout = 5000;
    
    this.getType = function()
    {
        if(type < 0)
            type = navigator.geolocation
                   ? 1
                   : google.gears
                     ? 2
                     : 0;
        return type;
    }

    this.getTypeName = function()
    {
        switch(this.getType())
        {
            case 1: return 'HTML5 Geolocation';
            case 2: return 'Google Gears';
            default: return 'Unsupported';
        }
    }
    
    this.getApi = function()
    {
        switch(this.getType())
        {
            case 1:
                return navigator.geolocation;
            case 2:
                return google.gears.factory.create('beta.geolocation');
            default:
                return null;
        }
    }

    this.isSupported = function()
    {
        return this.getType() > 0;
    }
    
    this.getCurrentPosition = function(onSuccess, onError)
    {
        var geo = this.getApi();
        
        if(geo === null)
        {
            if(typeof onError == 'function')
                onError(ERROR.NO_SUPPORT);
            return;
        }

        geo.getCurrentPosition(
            function(position) {
                if(typeof onSuccess == 'function')
                    onSuccess({
                        'latitude':position.coords.latitude,
                        'longitude':position.coords.longitude,
                        'accuracy':position.coords.accuracy
                    });
            }, function(error) {
                if(typeof onError == 'function') {
                    onError(error);
                }         
            },
            {enableHighAccuracy:highAccuracy, maximumAge:timeout, timeout: geoTimeout});

        return;
    }
    
    this.watchPosition = function(onSuccess, onError)
    {
        var geo = this.getApi();
        
        if(!geo)
        {
            if(typeof onError == 'function') {
                onError(ERROR.NO_SUPPORT);
            }
            return;
        }

        var watchID = geo.watchPosition(
        
            // Position was successfully retrieved
            function(position) {
                
                onSuccess && onSuccess({
                    'latitude': position.coords.latitude,
                    'longitude': position.coords.latitude,
                    'accuracy': position.coords.accuracy
                });
                
            },
            
            function(err) {
                if (typeof onError == 'function')
                    onError(err);
            },
            
            // Options
            {
                enableHighAccuracy: highAccuracy,
                maximumAge: timeout,
                timeout: geoTimeout
            }
        );
        
        return watchID;
    }
    
    this.clearWatch = function(watchID)
    {
        var geo = this.getApi();
        
        if(geo === null)
        {
            // If geolocation is not supported, silently fail
            return;
        }
        
        geo.clearWatch(watchID);
    }

    this.setTimeout = function(ms)
    {
        timeout = ms;
    }

    this.setHighAccuracy = function(bool)
    {
        highAccuracy = bool;
    }
}
