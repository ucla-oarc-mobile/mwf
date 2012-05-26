<h1 id="header">Required Handlers</h1>

<div class="content">

    <h2>Description</h2>
    
    <p>The <strong>CSS Handler</strong> (<code>css.php</code>) is responsible for loading style definitions for the MWF entities, and the <strong>JS Handler</strong> (<code>js.php</code>) is responsible for loading MWF Javascript functionality and related libraries. Both scripts do this through a dynamic process that considers the classification of the visitor's device and serves out a set of definitions catered to that device. They also allow a content provider (someone using the handler) to specify additional files that should be loaded in and minified at a particular classification level. Though PHP files, these handler identifies itself as content-type <code>text/css</code> and <code>text/javascript</code> respectively.</p>
    
    <p>To leverage standard MWF functionality, simply include two tags in the <code>&lt;head&gt;</code> section of your page:</p>

    <div class="highlight">
    <pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php"</span><span class="nt">&gt;&lt;/script&gt;</span>
    </pre>
    </div>

<h2>Intent</h2>

<p>To deliver a stylesheets and  Javascript functionality based on the user's browsing device and to minify and import additional libraries and scripts defined by the content provider, all within one requested script file.</p>

<h2>CSS Handler</h2>

<h3>Loading the CSS Handler</h3>

<p>The dynamic CSS handler resides at:</p>

<div class="highlight">
<pre>http://{MOBILE_DOMAIN}/assets/css.php
</pre>
</div>

<p>This file can be included through a standard <code>&lt;link&gt;</code> tag as with any other CSS file:</p>

<div class="highlight">
<pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
</pre>
</div>

<h3>Loading and Minifying Custom CSS</h3>

<p>In addition to loading in stylesheets for the framework entities, this also supports adding your own CSS (automatically minified) to any classification level through the CSS handler. In specifying a classification (<code>basic</code>, <code>standard</code> or <code>full</code>), the CSS will be fetched, minified and served out to any device of that classification level or higher.</p>

<p>For example, to include a custom CSS file for devices at the <code>standard</code> level and above:</p>

<div class="highlight">
<pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php?standard={URL_ENCODED_PATH}"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
</pre>
</div>


<p>It is possible to include multiple custom CSS files for devices at the same level as follows:</p>

<div class="highlight">
<pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php?standard={URL_ENCODED_PATH}+{URL_ENCODED_PATH_2}"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
</pre>
</div>


<p>A prototype that includes files at all classification levels:</p>

<div class="highlight">
<pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php?basic={URL_ENCODED_PATH}&amp;standard={URL_ENCODED_PATH_2}&amp;full={URL_ENCODED_PATH_3}"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
</pre>
</div>


<p>While the <a class="internal present" href="<?php echo URL::path('script/compression'); ?>">CSS Minifier</a> provides this same sort of minification, for pages using <code>css.php</code>, this method is recommended as it reduces the total number of HTTP requests by doing all the custom minification within a single HTTP request.</p>

<p><strong>Compatibility Note:</strong> Minification directly within the CSS Handler has been available since MWF 1.1. Content providers using an instance of MWF 1.0 must instead leverage the <a class="internal present" href="<?php echo URL::path('script/compression'); ?>">CSS Minifier</a>.</p>
</div>

<h2>JS Handler</h2>

<h3>Loading the JS Handler</h3>

<p>The dynamic JS handler resides at:</p>

<div class="highlight">
<pre><span class="n">http</span><span class="p">:</span><span class="o">//</span><span class="p">{</span><span class="n">MOBILE_DOMAIN</span><span class="p">}</span><span class="o">/</span><span class="n">assets</span><span class="o">/</span><span class="n">js</span><span class="p">.</span><span class="n">php</span>
</pre>
</div>


<p>This file can be included through a standard <code>&lt;script&gt;</code> tag as with any other JS file:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MWF_INSTALLATION_ROOT}/assets/js.php"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<h3>Loading Framework Libraries</h3>

<p>In addition to the default functionality always loaded by the framework, this handler also provides a mechanism to load additional framework libraries such as <a class="internal present" href="<?php echo URL::path('library/gelocation'); ?>">Geolocation</a> and <a class="internal present" href="<?php echo URL::path('library/touchable'); ?>">Touch Transitions</a>. To do this, it provides the GET parameters <code>standard_libs</code> and <code>full_libs</code>. </p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php?standard_libs=geolocation"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>Multiple libraries can be concatenated with a plus sign (+):</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php?full_libs=transitions+touch_transitions"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<h3>Loading and Minifying Custom Javascript</h3>

<p>In addition to loading in the framework Javascript API, this also supports adding your own Javascript (automatically minified) to any classification level through the JS handler. In specifying a classification (<code>basic</code>, <code>standard</code> or <code>full</code>), the Javascript will be fetched, minified and served out to any device of that classification level or higher.</p>

<p>For example, to include a custom Javascript file for devices at the <code>standard</code> level and above:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php?standard={URL_ENCODED_PATH}"</span> <span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>It is possible to include multiple custom Javascript files for devices at the same level as follows:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php?standard={URL_ENCODED_PATH}+{URL_ENCODED_PATH_2}"</span> <span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>A prototype that includes files at both Javascript classification levels:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php?standard={URL_ENCODED_PATH}&amp;full={URL_ENCODED_PATH_2}"</span> <span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>While the <a class="internal present" href="<?php echo URL::path('script/compression'); ?>">JS Minifier</a> provides this same sort of minification, for pages using <code>js.php</code>, this method is recommended as it reduces the total number of HTTP requests by doing all the custom minification within a single HTTP request.</p>

<p><strong>Compatibility Note:</strong> Minification directly within the JS Handler has been available since MWF 1.1. Content providers using an instance of MWF 1.0 must instead leverage the <a class="internal present" href="<?php echo URL::path('script/compression'); ?>">JS Minifier</a>.</p>

<h2>Flags to Disable Framework Functionality</h2>

<p>The <code>js.php</code> file, by default, writes several items that content providers may not desire. As such, <code>js.php</code> provides flags that allow individual functions to be disabled. These flags are listed below individually, but can be mixed together and in tandem with all other GET parameters.</p>

<h3>Google Analytics</h3>

<p>Google Analytics can also be turned off for sites with security concerns:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MWF_INSTALLATION_ROOT}/assets/js.php?no_ga"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>It should be noted that multiple instances of Google Analytics may run at once. This means that the framework Google Analytics will not conflict with Google Analytics instances also included by a content provider. Consequently, this should only be disabled if one does not wish to allow reporting at all to the central Google Analytics instance. This will lead to the site not having any global statistics provided.</p>

<h3>Favicon and Application Icons</h3>

<p>By default, <code>js.php</code> defines both a favicon and application icons from the framework.</p>

<p>For instances looking to set their own favicon, it can be disabled:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MWF_INSTALLATION_ROOT}/assets/js.php?no_favicon"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>For instances looking to set their own application icon, it too can be disabled:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MWF_INSTALLATION_ROOT}/assets/js.php?no_appicon"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>For instances looking to disable both the favicon and application icons, they can also be disabled simultaneously through one flag:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MWF_INSTALLATION_ROOT}/assets/js.php?no_icon"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>The <code>no_icon</code> flag is equivalent to a combination of both the <code>no_favicon</code> and <code>no_appicon</code> flag.</p>