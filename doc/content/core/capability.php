<h1 id="header">Capabilities [mwf.capability]</h1>

<div class="content">

<h2>Description</h2>

<p>The <strong>mwf.capability</strong> object provides telemetry about device abilities through active polling.</p>

<p>Internally, this object leverages Modernizr. However, this is not guaranteed to always be the case and users are encouraged to always use the MWF namespace documented below rather than to leverage side effects of the use of Modernizr. Modernizr is not used directly because MWF seeks to potentially provide a wider range of telemetry such as whether cookie writing is allowed and whether AJAX is available.</p>

<h2>Functions &amp; Properties</h2>

<h3>Current (MWF 1.2)</h3>

<p>The following functions are available through <strong>mwf.capability</strong>:</p>

<ul>
<li><p><strong>mwf.capability.ajax()</strong> True if the device supports AJAX through XMLHttpRequest or ActiveXObject.</p></li>
<li><p><strong>mwf.capability.applicationcache()</strong> True if the device supports application cache [WHATWG Web Applications 1.0 Sec 6.6].</p></li>
<li><p><strong>mwf.capability.audio()</strong> True if the device supports the HTML 5 audio tag  [HTML 5 Sec 4.8.7].</p></li>
<li><p><strong>mwf.capability.canvas()</strong> True if the device supports the HTML 5 canvas element  [HTML 5 Sec 4.8.11].</p></li>
<li><p><strong>mwf.capability.cookie()</strong> True if the device supports cookies through document.cookie.</p></li>
<li><p><strong>mwf.capability.css.borderradius()</strong> True if the device supports border-radius (or vendor prefixed) rule [CSS Backgrounds and Borders Module Level 3 Sec 5].</p></li>
<li><p><strong>mwf.capability.css.boxshadow()</strong> True if the device supports the box-shadow (or vendor prefixed) rule [CSS Backgrounds and Borders Module Level 3 Sec 7.2].</p></li>
<li><p><strong>mwf.capability.css.fontface()</strong> True if the device supports the @font-face rule [CSS Fonts Module Level 3 Sec 4.1].</p></li>
<li><p><strong>mwf.capability.css.gradients()</strong> True if the device supports the gradients (or vendor prefixed) property [CSS Image Values and Replaced Content Module Level 3 Sec 5].</p></li>
<li><p><strong>mwf.capability.css.prop(prop)</strong> True if the property string provided as a parameter is available for the device.</p></li>
<li><p><strong>mwf.capability.css.transforms()</strong> True if both mwf.capability.css.transforms2d() and mwf.capability.css.transforms3d().</p></li>
<li><p><strong>mwf.capability.css.transforms2d()</strong> True if device supports CSS 3 2D transform (or vendor prefixed) properties [CSS 2D Transforms Module Level 3].</p></li>
<li><p><strong>mwf.capability.css.transforms3d()</strong> True if device supports CSS 3 3D transform (or vendor prefixed) properties [CSS 3D Transforms Module Level 3].</p></li>
<li><p><strong>mwf.capability.css.transitions()</strong> True if device supports CSS 3 transition (or vendor prefixed) properties [CSS Transitions Module Level 3].</p></li>
<li><p><strong>mwf.capability.css3()</strong> True if device has minimal standardized CSS 3 support (as full browser) with border radius, box shadow and gradients.</p></li>
<li><p><strong>mwf.capability.draganddrop()</strong> True if device supports HTML 5 drag and drop [HTML 5 Sec 7.7].</p></li>
<li><p><strong>mwf.capability.events()</strong> True if device supports addEventListener. Even if false, DOM may still support onEvent element attributes.</p></li>
<li><p><strong>mwf.capability.event(eventName)</strong> True if device supports the event given by eventName.</p></li>
<li><p><strong>mwf.capability.flexbox()</strong> True if device supports the enhanced flexible box model.</p></li>
<li><p><strong>mwf.capability.inlinesvg()</strong> True if device supports SVG specified inline.</p></li>
<li><p><strong>mwf.capability.localstorage()</strong> True if device supports local storage under HTML 5 Web Storage API.</p></li>
<li><p><strong>mwf.capability.sessionstorage()</strong> True if device supports session storage under HTML 5 Web Storage API.</p></li>
<li><p><strong>mwf.capability.svg()</strong> True if device supports SVG.</p></li>
<li><p><strong>mwf.capability.touch()</strong> True if device has touch interface.</p></li>
<li><p><strong>mwf.capability.video()</strong> True if the device supports the HTML 5 video tag [HTML 5 Sec 4.8.6].</p></li>
<li><p><strong>mwf.capability.webgl()</strong> True if the device supports WebGL.</p></li>
<li><p><strong>mwf.capability.websockets()</strong> True if the device supports WebSocket API.</p></li>
<li><p><strong>mwf.capability.write()</strong> True if the device supports DOM writes. </p></li>
</ul><h3>Previous (MWF 1.0-1.1)</h3>

<p>This object did not exist before MWF 1.2.</p>

</div>