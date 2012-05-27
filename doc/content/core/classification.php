<h1 id="header">Classification [mwf.classification]</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>mwf.classification</code> object uses device telemetry to define the classification scheme for a device. To do this, it leverages other mwf libraries including <code>mwf.capability</code> and <code>mwf.screen</code>. The <code>mwf.classification</code> object may also be modified by <code>mwf.override</code> if the client has specified an override.</p>

<p>This object is defined in <code>assets/js/core/classification.js</code> and is automatically loaded by the JS handler.</p>

<h3>Current (MWF 1.2)</h3>

<p>The following functions are available through <code>mwf.classification</code>:</p>

<ul>
<li><p><code>mwf.classification.isMobile()</code> If the device has a screen size smaller than the mobile dimensions set in the framework config (default maximum mobile screen size of 799 x 599). This is determined by comparing this value to the one in <code>mwf.screen</code>, and it should be noted that it represents the <code>screen</code> dimensions, not the <code>browser.innerWindow</code> dimensions, as the latter may change dynamically while on a page.</p></li>
<li><p><code>mwf.classification.isBasic()</code> All devices are of the basic classification.</p></li>
<li><p><code>mwf.classification.isStandard()</code> Returns true for a device that supports cookies, live DOM writes and addEventListener.</p></li>
<li><p><code>mwf.classification.isFull()</code> Returns true for a device that has all standard capabilities, plus AJAX and at least limited CSS 3 support.</p></li>
<li><p><code>mwf.classification.isPreview()</code> Returns true for a non-mobile device with an override set.</p></li>
<li><p><code>mwf.classification.get()</code> The string value of the most capable classification of the device.</p></li>
</ul><p>The following attribute is also available through <code>mwf.classification</code>:</p>

<ul>
<li>
<code>mwf.classification.cookieName</code> The name of the cookie that assets/js/core/server.js writes.</li>
</ul><p>When an override is enabled, <code>mwf.override</code> adds the following functions:</p>

<ul>
<li><p><code>mwf.classiciation.wasFull()</code> If the device's actual classification is full.</p></li>
<li><p><code>mwf.classiciation.wasStandard()</code> If the device's actual classification is at least standard.</p></li>
<li><p><code>mwf.classiciation.wasBasic()</code> Always true as all device were at least basic.</p></li>
</ul><p>If an override is enabled, <code>mwf.override</code> also modifies the behavior of the following:</p>

<ul>
<li><p><code>mwf.classiciation.isFull()</code> If <code>"override"="full"</code> and <code>mwf.classification.wasFull()</code> is true.</p></li>
<li><p><code>mwf.classiciation.isStandard()</code> If <code>"override"={"standard","full"}</code> and <code>mwf.classificiation.wasStandard()</code> is true.</p></li>
<li><p><code>mwf.classiciation.isBasic()</code> Always true as an override cannot be to less than basic.</p></li>
</ul><p>See <a class="internal present" href="<?php echo URL::path('core/override'); ?>">mwf.override</a> for more information about override functionality.</p>

<h3>Previous (MWF 1.0-1.1)</h3>

<p>Before MWF 1.2, this functionality was encapsulated under the now-deprecated <code>mwf.user_agent</code> object, coupled tightly with other information now available through <code>mwf.userAgent</code>. For backwards compatibility, this object is still available, though its methods alias those of <code>mwf.userAgent</code> and <code>mwf.classification</code>. See the <a class="internal present" href="<?php echo URL::path('core/userAgent'); ?>">mwf.userAgent</a> documentation for a detailed description of the <code>mwf.user_agent</code></p>

</div>