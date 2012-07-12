<h1 id="header">Geolocation</h1>

<div class="content">

<h2>Description</h2>

<p>Geolocation functionality allows pages to determine location information on supporting devices. The <strong>mwf.standard.geolocation library</strong> (includable as the touch library <strong>geolocation</strong>) provides a straightforward interface for this purpose whereby browser-side scripts can determine if a given device supports and allows a <strong>geolocation</strong> method and, if so, can ascertain the current longitude and latitude of the given device.</p>

<h2>Implementation</h2>

<h3>Geolocation Methods</h3>

<p>This library supports two geolocation methods:</p>

<ul>
<li>
<strong>HTML 5</strong> - [1] - iPhone OS, iOS, Android 2, some Android 1 devices, etc.</li>
<li>
<strong>Google Gears</strong> - [2] - Windows Mobile 6, Symbian OS, some Android 1 devices, etc.</li>
</ul><p>A script may determine which of these methods is available through <strong>mwf.standard.geolocation.getType()</strong> where 1 represents HTML 5, 2 represents Google Gears, and 0 represents unavailable. Similarly, one may merely determine if geolocation is supported through <strong>mwf.standard.geolocation.isSupported()</strong>. Although this library supports two different methods with different underlying standards, it abstracts them into a common interface so, besides determining which library is supported, it does not matter which the device supports.</p>

<p>This API also supports both high accuracy and low accuracy retrievals of the position. By default, this library requests a high accuracy location. However, this behavior can be changed to take a low accuracy setting as follows:</p>

<pre><code>mwf.standard.geolocation.setHighAccuracy(false);</code></pre>

<h3>Initial Retrieval of Location</h3>

<p>To employ the framework's Javascript-driven <strong>geolocation</strong> library, the <strong>geolocation</strong> library must be specified as a parameter in the script tag that includes <strong>js.php</strong>:</p>

<pre><code>&lt;script type="text/javascript" src="../assets/js.php?standard_libs=geolocation"&gt;&lt;/script&gt;</code></pre>

<p>Geolocation does not happen instantly for two reasons:</p>

<ol>
<li>Many devices prompt the user to determine if they're willing to disclose their location.</li>
<li>Geolocation equipment on most devices is only available on-demand to conserve power.</li>
</ol><p>This means that, when a script attempts to retrieve geolocation information, the device will not respond immediately and instead there must be a way of retrieving this information when it becomes available. To handle this situation, the MWF Geolocation API employs callback functions, executed upon either a successful or unsuccessful retrieval of geolocation data:</p>

<pre><code>mwf.standard.geolocation.getCurrentPosition(onSuccessCallback, onFailureCallback).</code></pre>

<p>Consider the following example:</p>

<pre><code>mwf.standard.geolocation.getCurrentPosition(
    function(pos){ alert("Latitude:"+pos['latitude']+", Longitude:"+pos['longitude']+", Accuracy:"+pos['accuracy']); }, 
    function(err){ alert("Err:"+err.message); }
);</code></pre>

<p>In this case, this line will fire and then script execution will continue. Then, when <strong>geolocation</strong> succeeds, it will present an alert box with the latitude and longitude, or when it fails, it will present the error in an alert box.</p>

<h3>Cached Retrieval of Location</h3>

<p>On a page, more than one script may seek to leverage geolocation information, or it may need to on a recurring basis. However, such scripts may not always seek to go through the retrieval process. Therefore, in the event that <strong>mwf.standard.geolocation.getPosition(...)</strong> is called more than once, if the geolocation data has already been retrieved, this library will instead immediately return it to the callback. </p>

<p>A timeout on the cache can be set as follows, where ms is the number of milliseconds where the cached version will continue to be valid:</p>

<pre><code>mwf.standard.geolocation.setTimeout(ms);</code></pre>

<h3>Continuously Retrieving Location</h3>

<p>When determining a device's location through <code>getCurrentPosition</code>, consider the following issues:</p>

<ul>
<li><p>A device's location may change as the user moves</p></li>
<li><p>Devices will return location data as quickly as possible. As a result, the device may initially return inaccurate data to ensure performance</p></li>
</ul><p>To continuously poll a device's location data and execute a callback when a device's location changes or the location data becomes more accurate, use <code>watchPosition</code>:</p>

<pre><code>mwf.standard.geolocation.watchPosition(onSuccessCallback, onFailureCallback)</code></pre>

<p><code>watchPosition</code> returns a unique ID number that can be passed to <code>clearWatch</code> to discontinue polling:</p>

<pre><code>mwf.standard.geolocation.clearWatch(watchID)</code></pre>

<p>The following example demonstrates how to poll a device's position until the level of accuracy reaches a certain threshold (30 meters):</p>

<pre><code>var watchID = mwf.standard.geolocation.watchPosition(function(pos) {
	if(pos['accuracy'] &lt;= 30) {
		mwf.standard.geolocation.clearWatch(watchID);
		alert("Accuracy within 30 meters, Latitude: " + pos['latitude'] + ", Longitude: " + pos['longitude']);
	}
},
function(err) {
	alert(err);
});</code></pre>

</div>