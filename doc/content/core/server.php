<h1 id="header">Server</h1>

<div class="content">

<h2>Description</h2>

<p>This functionality is responsible for making data determined client-side (Javascript) available server-side (PHP). To do this, an anonymous function is invoked on each request of the JS handler that writes cookies based on client-side device telemetry, if they are not already set or have changed, and then reloads the page to push the data back server-side.</p>

<p>This functionality is defined in <code>assets/js/core/server.js</code> and is automatically loaded by the JS handler.</p>

<h3>Current (MWF 1.2)</h3>

<p>This functionality writes cookies for data from the following other libraries:</p>

<ul>
<li><a class="internal present" href="<?php echo URL::path('core/classification'); ?>">mwf.classification</a></li>
<li><a class="internal present" href="<?php echo URL::path('core/screen'); ?>">mwf.screen</a></li>
<li><a class="internal present" href="<?php echo URL::path('core/userAgent'); ?>">mwf.userAgent</a></li>
</ul><p>Each of these libraries have a <code>cookieName</code> property that define the name of the cookie written.</p>

<p>This functionality will reload the page in the following cases:</p>

<ul>
<li>When a user arrives for the first time on a page powered by the MWF.</li>
<li>When a user changes their capabilities (and thus classification), screen dimensions or user agent.</li>
<li>When a user issues an override or unsets an override.</li>
</ul><p>As such, caution should be used in allowing a user to make a POST to their first page under MWF.</p>

<p>Once this routine has run, this data is then exposed in the PHP API on the framework server through the objects Classification, Screen and User_Agent.</p>

<h3>Previous (MWF 1.0-1.1)</h3>

<p>This functionality was not necessary before MWF 1.2, as MWF 1.0-1.1 determined capabilities server-side through static metadata and then pushed the data client-side.</p>

</div>