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
 *   
 *   @todo: For 2.0, do not return lat,long,accuracy.  Return the position object in its entirety instead.
 */

mwf.touch.geolocation = new function(optionalGeolocationObject)
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
    
    var geolocationObject = typeof optionalGeolocationObject == "undefined" ? undefined : optionalGeolocationObject;
    
    /**
     * @deprecated (should be a private or protected method)
     */
    this.getType = function()
    {
        if(type < 0)
            type =             
            typeof geolocationObject != "undefined" 
            ? 3
            : navigator.geolocation
            ? 1
            : typeof google != 'undefined' && google.gears
            ? 2
            : 0;
        return type;
    }

    /**
     * @deprecated (unnecessary)
     */
    this.getTypeName = function()
    {
        switch(this.getType())
        {
            case 1:
                return 'HTML5 Geolocation';
            case 2:
                return 'Google Gears';
            case 3:
                return "Custom";
            default:
                return 'Unsupported';
        }
    }
    
    /**
     * @deprecated (should be a private or protected method)
     */
    this.getApi = function()
    {
        if (typeof geolocationObject == "undefined") {
            switch(this.getType())
            {
                case 1:
                    geolocationObject = navigator.geolocation;
                    break;
                case 2:
                    geolocationObject = google.gears.factory.create('beta.geolocation');
                    break;
                default:
                    geolocationObject = null;
            }
        }
        return geolocationObject;
    }

    this.isSupported = function()
    {
        return this.getType() > 0;
    }

    /**
     * getPosition() is deprecated. Use getCurrentPosition() instead.
     *
     * @deprecated
     * @return void
     */
    this.getPosition = function(onSuccess, onError)
    {   
        var geo = this.getApi();
        if(geo === null)
        {
            if(typeof onError != 'undefined') {
                onError(ERROR_MESSAGE.NO_SUPPORT);
            }
            return;
        }

        geo.getCurrentPosition(
            function(position) {
                if(typeof onSuccess != 'undefined')
                    onSuccess({
                        'latitude':position.coords.latitude,
                        'longitude':position.coords.longitude,
                        'accuracy':position.coords.accuracy
                    });
            }, function(error) {
                if(typeof onError != 'undefined') {
                    var errorMsg = error.code == error.PERMISSION_DENIED ?
                    ERROR_MESSAGE.PERMISSION_DENIED : ERROR_MESSAGE.GENERAL;
                    onError(errorMsg);
                }         
            },
            {
                enableHighAccuracy:highAccuracy, 
                maximumAge:timeout, 
                timeout: geoTimeout
            });

        return;
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
            {
                enableHighAccuracy:highAccuracy, 
                maximumAge:timeout, 
                timeout: geoTimeout
            });

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

        if(geo !== null)
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
