<h1 id="header">Minifiers</h1>

<div class="content">
    <h2>Description</h2>

<p>The framework provides scripts that will minify Javascript and CSS just-in-time. This allows one to avoid minifying their Javascript and CSS every time it is altered, and it makes it possible to deliver particular CSS and JS to only devices of a given classification. It should be noted that, for pages that include the <a class="internal present" href="<?php echo URL::path('script/required'); ?>">CSS Handler</a> and <a class="internal present" href="<?php echo URL::path('script/required'); ?>">JS Handler</a>, these handlers have the same functionality and should be used instead to minify to reduce the number of HTTP requests. The syntax is the same as described below for the minifiers.</p>

<p>The framework provides a script that will compress an image to ideal dimensions based on the user's device. This feature allows one to provide a single image and let the framework scale it dynamically for the end user so that a high-resolution and low-resolution device both need only download an image optimized for their screen size.</p>

<h2>Intent</h2>

<p>Load times prove to be the major delimiting factor to the mobile browsing experience, and therefore a set of scripts should exist that enable sites to compress assets, just-in-time, through the framework.</p>

<h2>CSS &amp; JS Minifiers</h2>

<h3>Standalone Minifiers</h3>

<p>The standalone minifier for Javascript:</p>

<div class="highlight">
<pre><span class="n">http</span><span class="p">:</span><span class="o">//</span><span class="p">{</span><span class="n">MWF_INSTALLATION_ROOT</span><span class="p">}</span><span class="o">/</span><span class="n">assets</span><span class="o">/</span><span class="n">min</span><span class="o">/</span><span class="n">js</span><span class="p">.</span><span class="n">php</span>
</pre>
</div>


<p>The standalone minifier for CSS:</p>

<div class="highlight">
<pre><span class="n">http</span><span class="p">:</span><span class="o">//</span><span class="p">{</span><span class="n">MWF_INSTALLATION_ROOT</span><span class="p">}</span><span class="o">/</span><span class="n">assets</span><span class="o">/</span><span class="n">min</span><span class="o">/</span><span class="n">css</span><span class="p">.</span><span class="n">php</span>
</pre>
</div>


<h3>Classification Awareness</h3>

<p>Minification of custom sheets can target a specific classification:</p>

<ul>
<li>basic</li>
<li>standard</li>
<li>full</li>
</ul><p>The minification scripts and handlers all take the above three classification names as GET parameters. The values of these parameters, if used, should be a set of URL encoded web paths. If more than one path is specified for a single GET parameter, then they should be concatenated with a plus sign (+).</p>

<p>This example produces a minified version of a Javascript file for standard devices and above:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/min/js.php?standard={URL_ENCODED_PATH}"</span> <span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>


<p>This example produces a minified version of two CSS files:</p>

<div class="highlight">
<pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/min/css.php?standard={URL_ENCODED_PATH}+{URL_ENCODED_PATH_2}"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
</pre>
</div>


<p>These can be used in combination at multiple classification levels:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/min/js.php?standard={URL_ENCODED_PATH}&amp;full={URL_ENCODED_PATH_2}"</span> <span class="na">type=</span><span class="s">"text/javascript"</span><span class="nt">&gt;&lt;/script&gt;</span>
</pre>
</div>

<h2>Image Compression</h2>

<p>The framework provides a script that can be run off of <strong>{MOBILE_DOMAIN}</strong> to compress images suited for a user's device.</p>

<div class="highlight">
<pre>http://{MOBILE_DOMAIN}/assets/min/img.php?img={IMG_PATH}
</pre>
</div>


<p>It leverages caching policies to ensure that it does not, except when necessary, have to recompress the same image of the same size multiple times. In addition, it provides three different mechanisms by which a content provider can inform the script of compression:</p>

<ul>
<li>
<strong>browser_width_force</strong> &amp; <strong>browser_height_force</strong> - These parameters do not take an attribute but instead merely inform the script to compress the image to a maximum width or height equal to the user's browsing device.</li>
<li>
<strong>browser_width_percent</strong> &amp; <strong>browser_height_percent</strong> - These parameters take a value between 1 and 100 and inform the script to compress the image to a maximum width or height equal to the percent specified of the user's browsing agent.</li>
<li>
<strong>max_width</strong> &amp; <strong>max_height</strong> - These parameters do not take into consideration the user's browsing device but instead inform the script to compress the image to a maximum height or width specified in pixels by this parameter.
In terms of maximum size, the browser_width_percent and browser_height_percent parameters overrule the browser_width_force and browser_height_force parameters and the max_width and max_height parameters overrule both other sets.</li>
</ul><p>In this example, the image will never be larger than 400 pixels when compressed and in addition will also never be larger than 80% width and 60% height of the user's browsing device.</p>

<div class="highlight">
<pre><span class="nt">&lt;img</span> <span class="na">src=</span><span class="s">"http://m.ucla.edu/assets/min/img.php?img=http%3A%2F%2Fm.ucla.edu%2Fsomeimage.jpg</span>
<span class="s">&amp;browser_width_percent=80&amp;browser_height_percent=60&amp;max_width=400"</span> <span class="nt">/&gt;</span>
</pre>
</div>


<h3>Limitations</h3>

<p>The image compression script caching support is a work in progress. The framework development group is revisiting the caching policies which currently have an inordinately long retention period.</p>

<p>There is a bug in Android 2.2 and 2.3 such that the screen dimensions are not reported reliably. MWF can't reliably determine screen width if the OS/browser won't reliably report it. Users of the image minifier are especially encouraged to confirm that results are acceptable in Android 2.2 or 2.3, and to provide a fallback using CSS or other techniques in cases where the minifier cannot provide a satisfactory scaling on those devices.</p>