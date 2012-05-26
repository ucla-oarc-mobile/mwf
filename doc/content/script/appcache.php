<h1 id="header">Appcache Handler</h1>

<div class="content">
    <h2>About Appcache</h1>

<p>If you are unfamiliar with HTML5 offline application caching (Appcache), there are several excellent resources available online.  For example, perhaps you might enjoy reading <a href="http://diveintohtml5.com/offline.html">Dive Into HTML5: Let's Take This Offline</a>.</p>

<p>If you need a tool to assist you in determining what your offline caching manifest should contain, perhaps you will find the <a href="http://westciv.com/tools/manifestR/">Manifestr bookmarklet</a> helpful.</p>

<p>If you need to have content available to users of your site even when they have no network connectivity, HTML5 offline application caching can do that.</p>

<p>In addition, you can use an Appcache to improve performance.  This is especially useful with mobile devices that often have relatively slow and unreliable network connections.</p>

<h2>Why do I need an Appcache Handler?</h1>

<p>The MWF Device Telemetry Stack (DTS) complicates HTML5 offline application caching (Appcache).  Fortunately, the MWF Appcache Handler makes it easy again.</p>

<p>The DTS will sometimes need the MWF JavaScript handler to reload the page.  This is by design.  On page reload, the JavaScript changes and all proceeds as planned.  However, if the JavaScript that causes a reload is placed in the HTML5 offline appcache, the browser will reload again and again.</p>

<p>Choosing to not place the JavaScript handler into the Appcache is not a good solution.  The handler is essential to the more advanced features of MWF.  So you will want the JavaScript to be in the Appcache so users will have access to those features when they are offline.</p>

<p>Enter the Appcache Handler, which knows when to cache and when not to cache things.</p>

<h2>How do I use the Appcache Handler?</h1>

<ol>
<li>Create your manifest as usual in <code>root/assets/appcache/manifest.appcache</code>.</li>
<li>
<p>You can enable the Appcache on the appropriate page (usually <code>root/index.php</code> if you intend to cache the landing page for your MWF site) via the <code>add_appcache()</code> method of the HTML Decorator:</p>

<p><code>echo HTML_Decorator::html_start()-&gt;add_appcache()-&gt;render();</code></p>
</li>
</ol><p>If you are not using the MWF Decorator classes, you can specify the Appcache Handler in your <code>&lt;html&gt;</code> tag:</p>

<pre><code>&lt;html manifest="http://www.example.com/assets/appcache.php"&gt;
</code></pre>

<p>And that's it!  Your content will only be placed in the HTML5 offline application cache when it is safe for the browser to do so.</p>
</div>