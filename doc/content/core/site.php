<h1 id="header">Site [mwf.site]</h1>

<div class="content">

<h2>Description</h2>

<p>The <strong>mwf.site</strong> namespace contains a number of properties and functions related to the global state of the framework. Most of these values are passed into Javascript server-side from the framework configuration settings.</p>

<h2>Functions &amp; Properties</h2>

<h3>Current (MWF 1.2)</h3>

<p>The following are available through the <strong>mwf.site</strong> namespace:</p>

<ul>
<li><p><strong>mwf.site.root</strong> The web root of the directory containing the front splash page.</p></li>
<li><p><strong>mwf.site.asset.root</strong> The web root of the framework assets directory.</p></li>
<li><p><strong>mwf.site.analytics.key</strong> A Google analytics key, if one is configured in the framework config, or NULL otherwise.</p></li>
<li><p><strong>mwf.site.mobile.maxWidth</strong> The maximum width that is considered a "mobile" device, where any device above this value will cause mwf.classification.isMobile() to return false. If this is not configured in the framework config, then this is NULL.</p></li>
<li><p><strong>mwf.site.mobile.maxHeight</strong> The maximum height that is considered a "mobile" device, where any device above this value will cause mwf.classification.isMobile() to return false. If this is not configured in the framework config, then this is NULL.</p></li>
<li><p><strong>mwf.site.domain()</strong> The domain of the current page, used for determining preview mode bar.</p></li>
</ul><h3>Previous (MWF 1.0-1.1)</h3>

<p>The following functions have been deprecated but are available for backwards compatibility:</p>

<ul>
<li><p><strong>mwf.site.webroot()</strong> An alias to mwf.site.root.</p></li>
<li><p><strong>mwf.site.webassetroot()</strong> An alias to mwf.site.asset.root.</p></li>
<li><p><strong>mwf.site.frontpage()</strong> Appends index.php to mwf.site.root.</p></li>
</ul>