<h1 id="header">Override [mwf.override]</h1>

<div class="content">

<h2>Description</h2>

<p>This functionality allows the client to override their device classification with any classification equal to or lesser than their actual classification. To invoke this functionality, all the client must do is define a GET parameter <code>"override"={"basic","standard","full"}</code> in their request string to a page powered by the MWF. To return to their actual classification, they should include the GET parameter <code>"override"="no"</code> in their request string to a page powered by the MWF.</p>

<p>The mwf.override object does not itself provide any new methods. However, it does add several methods to <a class="internal present" href="<?php echo URL::path('core/classification'); ?>">mwf.classification</a>.</p>

<p>This functionality is defined in <code>assets/js/core/override.js</code> and is automatically loaded by the JS handler.</p>

<h3>Current (MWF 1.2)</h3>

<p>The following functions is always added to <code>mwf.classification</code> by <code>mwf.override</code>:</p>

<ul>
<li><code>mwf.classiciation.isOverride()</code></li>
</ul><p>If the client has overridden the default classification, then the following functions are defined/redefined within <code>mwf.classification</code> by <code>mwf.override</code>:</p>

<ul>
<li><p><code>mwf.classiciation.wasFull()</code> If the device's actual classification is full.</p></li>
<li><p><code>mwf.classiciation.wasStandard()</code> If the device's actual classification is at least standard.</p></li>
<li><p><code>mwf.classiciation.wasBasic()</code> Always true as all device were at least basic.</p></li>
<li><p><code>mwf.classiciation.isFull()</code> If <code>"override"="full"</code> and <code>mwf.classification.wasFull()</code> is true.</p></li>
<li><p><code>mwf.classiciation.isStandard()</code> If <code>"override"={"standard","full"}</code> and <code>mwf.classificiation.wasStandard()</code> is true.</p></li>
<li><p><code>mwf.classiciation.isBasic()</code> Always true as an override cannot be to less than basic.</p></li>
</ul><h3>Previous (MWF 1.0-1.1)</h3>

<p>This functionality was not necessary before MWF 1.2, as MWF 1.0-1.1 performed override logic server-side and then pushed the data client-side.</p>

</div>