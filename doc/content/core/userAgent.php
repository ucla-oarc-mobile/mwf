<h1 id="header">User Agent [mwf.userAgent]</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>mwf.userAgent</code> object parses out information from <code>nagivator.userAgent</code>. </p>

<p>This object is defined in <code>assets/js/core/useragent.js</code> and is automatically loaded by the JS handler.</p>

<h2>Functions &amp; Properties</h2>

<h3>Current (MWF 1.2)</h3>

<p>The following functions are available through <code>mwf.userAgent</code>:</p>

<ul>
<li><p><code>mwf.userAgent.getOS()</code> Operating system of the device.</p></li>
<li><p><code>mwf.userAgent.getOSVersion()</code> Version number of the device operating system.</p></li>
<li><p><code>mwf.userAgent.getBrowser()</code> Browser being used to access the page.</p></li>
<li><p><code>mwf.userAgent.getBrowserEngine()</code> Browser engine being used to parse the page.</p></li>
<li><p><code>mwf.userAgent.getBrowserEngineVersion()</code> Version number of the browser engine being used to parse the page.</p></li>
</ul><p>If any of the above information cannot be determined, the functions return false instead.</p>

<p>The following attribute is also available through <code>mwf.userAgent</code>:</p>

<ul>
<li>
<code>mwf.userAgent.cookieName</code> The name of the cookie that assets/js/core/server.js writes.</li>
</ul><h3>Previous (MWF 1.0-1.1)</h3>

<p>Before MWF 1.2, this object was known as <code>mwf.user_agent</code>, and provided a wider range of functionality including the telemetry that is now provided by the <a class="internal present" href="<?php echo URL::path('core/classification'); ?>">mwf.classification</a> library. For backwards compatibility, this object is still available, though its methods alias those of <code>mwf.userAgent</code> and <code>mwf.classification</code>.</p>

<ul>
<li><p><code>mwf.user_agent.get_os()</code> Alias for mwf.userAgent.getOS(). </p></li>
<li><p><code>mwf.user_agent.()</code> Alias for mwf.userAgent.getOSVersion().</p></li>
<li><p><code>mwf.user_agent.get_browser()</code> Alias for mwf.userAgent.getBrowser().</p></li>
<li><p><code>mwf.user_agent.get_browser_version()</code> Returns false as MWF 1.2 does not provide this.</p></li>
<li><p><code>mwf.user_agent.is_mobile()</code> Alias for mwf.classification.isMobile().</p></li>
<li><p><code>mwf.user_agent.is_basic()</code> Alias for mwf.classification.isBasic(). </p></li>
<li><p><code>mwf.user_agent.is_standard()</code> Alias for mwf.classification.isStandard(). </p></li>
<li><p><code>mwf.user_agent.is_full()</code> Alias for mwf.classification.isFull(). </p></li>
<li><p><code>mwf.user_agent.is_touch()</code> Alias for mwf.classification.isStandard(). </p></li>
<li><p><code>mwf.user_agent.is_overriden()</code> Alias for mwf.classification.isOverride(). </p></li>
<li><p><code>mwf.user_agent.is_preview()</code> Alias for mwf.classification.isPreview(). </p></li>
</ul>

</div>