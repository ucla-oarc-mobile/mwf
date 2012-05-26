<h1 id="header">Classification Overriding</h1>

<div class="content">
    <h2>Description</h2>

<p>Through the <a class="internal present" href="<?php echo URL::path('core/override'); ?>">override library</a> (<code>mwf.override</code>), the framework allows a user to override the way the framework classifies the user with any classification below the one that their devices is actually regarded as. Once an override has been triggered, until it is disabled, all handlers and functions will observe the override specification.</p>

<h2>Performing an Override</h2>

<p>This is possible by providing the GET parameter <code>override</code> on any page that includes the <a class="internal present" href="<?php echo URL::path('script/required'); ?>">JS Handler</a> with the value <code>basic</code>, <code>standard</code> or <code>full</code>. In doing so, the page in question will be refreshed to the classification level specified.</p>

<p>An example of a URL that enables an override is as follows (where <code>sample.php</code> includes the JS handler):</p>

<div class="highlight">
<pre>sample.php?override=standard
</pre>
</div>


<p>To disable the override, one may then specify the GET parameter <code>override</code> with the value <code>no</code>.</p>

<p>An example of a URL that disables the framework is as follows (where <code>sample.php</code> includes the JS handler):</p>

<div class="highlight">
<pre>sample.php?override=no
</pre>
</div>


<p><strong>Compatibility Note:</strong> MWF 1.0-1.1 only offered this functionality on the front splash page (<code>index.php</code>), and instead used the GET parameter <code>ovrcls</code>. In MWF 1.2, the GET parameter <code>ovrcls</code> is still accepted and valid on the front splash page, but its functionality is now expanded to encompass any page with the framework on it.</p>

<p>A user is not allowed to override to a classification higher than the one that their device actually is. This prevents libraries from loading that are incompatible with the actual device capabilities.</p>

<p><strong>Compatibility Note:</strong> MWF 1.0-1.1 allowed the user to override to any classification, whereas MWF 1.2 only allows the user to override to a classification less than the classification of the actual device.</p>

<h2>Telemetry About the Override</h2>

<p>The <code>mwf.classification</code> library allows one to determine if an override is active:</p>

<ul>
<li><code>mwf.classification.isOverride()</code></li>
</ul><p>If an override is valid, the behavior of <code>mwf.classification</code> will also be modified. In such a case, the following methods will produce information based on the override rather than the actual device:</p>

<ul>
<li><code>mwf.classification.isFull()</code></li>
<li><code>mwf.classification.isStandard()</code></li>
<li><code>mwf.classification.isBasic()</code></li>
</ul><p>The <code>mwf.classification</code> object then provides an additional set of methods to access the actual classification information about a device. These methods are not available if an override is not present (as the above classification methods will return the actual values):</p>

<ul>
<li><code>mwf.classification.wasFull()</code></li>
<li><code>mwf.classification.wasStandard()</code></li>
<li><code>mwf.classification.wasBasic()</code></li>
</ul><p>In addition, if the device is classified as a desktop and an override is present, it will classify the device as in preview mode and return true to the following function:</p>

<ul>
<li><code>mwf.classification.isPreview()</code></li>
</ul><p>If <code>config/preview.php</code> is configured and the page is under the specified domain, then this preview mode will also trigger the preview menu bar that allows the user to switch classifications (<strong>NOTE:</strong> The preview menu functionality is currently under refactor, as it is not optimized yet for MWF 1.2).</p>
</div>