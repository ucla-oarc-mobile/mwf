/**
 * Interface:
 *   mwf.touch.geolocation.getType() -> 0|1|2
 *   mwf.touch.geolocation.getTypeName() -> "HTML5 Geolocation"|"Google Gears"|"Unsupported"
 *   mwf.touch.geolocation.isSupported() -> boolean
 *   mwf.touch.geolocation.getPosition(onSuccessCallback, onFailureCallback) -> [['lat']=>decimal, ['lon']=>decimal]
 *   mwf.touch.geolocation.getLatitude() -> decimal
 *   mwf.touch.geolocation.getLongitude() -> decimal
 *   mwf.touch.geolocation.validPosition() -> boolean
 *   mwf.touch.geolocation.getError() -> string|false
 *   mwf.touch.geolocation.hasError() -> boolean
 *   mwf.touch.geolocation.setPosition(lat, lon)
 *   mwf.touch.geolocation.setError(err)
 *   mwf.touch.geolocation.flush()
 */

mwf.touch.geolocation = new function()
{
    var type = -1;
    var position = null;
    var highAccuracy = true;
    var timeout = 3000;

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

    this.isSupported = function()
    {
        return this.getType() > 0;
    }

    this.getPosition = function(onSuccess, onError)
    {
        var geo;
        switch(this.getType())
        {
            case 1:
                geo = navigator.geolocation;
                break;
            case 2:
                geo = google.gears.factory.create('beta.geolocation');
                break;
            default:
                mwf.touch.geolication.setError('No geolocation support available.');
                onError('No geolocation support available.');
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

            }, function() {
                if(typeof onSuccess != 'undefined')
                    onError('Google Gears Geolocation failure.');
            },
            {enableHighAccuracy:highAccuracy, maximumAge:timeout});

        return true;
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
