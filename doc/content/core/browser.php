<h1 id="header">Browser [mwf.browser]</h1>

<div class="content">

<h2>Description</h2>

<p>The <strong>mwf.browser</strong> object contains a number of methods that compute dimensionality and positioning within the current state of the browser. This should not be confused with <strong>mwf.screen</strong>, which provides dimensionality information about the static screen size.</p>

<h2>Functions &amp; Properties</h2>

<h3>Current (MWF 1.2)</h3>

<p>The following functions are available through <strong>mwf.browser</strong>:</p>

<ul>
<li><p><strong>mwf.browser.getHeight()</strong> The inner height of the current browser window.</p></li>
<li><p><strong>mwf.browser.getWidth()</strong> The inner width of the current browser window.</p></li>
<li><p><strong>mwf.browser.posLeft()</strong> The absolute position value of the left-most pixel of the visible browser window.</p></li>
<li><p><strong>mwf.browser.posTop()</strong> The absolute position value of the top-most pixel of the visible browser window.</p></li>
<li><p><strong>mwf.browser.posRight()</strong> The absolute position value of the right-most pixel of the visible browser window.</p></li>
<li><p><strong>mwf.browser.posBottom()</strong> The absolute position value of the bottom-most pixel of the visible browser window.</p></li>
</ul><h3>Previous (MWF 1.0-1.1)</h3>

<p>The following functions have been deprecated but are available for backwards compatibility:</p>

<ul>
<li><p><strong>mwf.browser.pageHeight()</strong> Alias of mwf.browser.getHeight().</p></li>
<li><p><strong>mwf.browser.pageWidth()</strong> Alias of mwf.browser.getWidth().</p></li>
</ul>

</div>