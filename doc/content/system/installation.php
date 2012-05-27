<h1 id="header">Installation</h1>

<div class="content">

<p>It is recommended that a single instance of the framework be hosted within an institution. This reduces redundant maintenance of the application, as updates to the framework have to occur in only one place, and because it best enables a unified mobile presence among modules that use it, regardless of where the modules are hosted. </p>

<p>This article is thus intended to give a start for service providers (those looking to host a copy of the framework).</p>

<p>Before getting started with this guide, please refer to the <a class="internal present" href="<?php echo URL::path('system/requirements'); ?>">System Requirements</a> documentation to make sure that your system is compatible with the Mobile Web Framework. It is the intent of the project to make this as portable as possible, but not all environments are yet fully supported.</p>

<h2>Getting the Framework</h2>

<p>The framework can be downloaded through two mechanisms, either via a direct download link on Github or via the Git version control system. The latter is recommended, and the rest of this section will intend that this is what you're trying to do. If you are simply going to download a copy of the framework in its entirety, you can bypass this section.</p>

<p>The first thing you will need to do to get a copy via Git is <a href="http://git-scm.com/download">install Git</a> on your server.</p>

<p>Once git is installed, the next step is to "clone" the repository onto your local machine.</p>

<p>If you're looking merely to pull a copy of the repository, this can be achieved as follows:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">clone</span> <span class="n">git</span><span class="p">:</span><span class="o">//</span><span class="n">github</span><span class="p">.</span><span class="n">com</span><span class="o">/</span><span class="n">ucla</span><span class="o">/</span><span class="n">mwf</span><span class="p">.</span><span class="n">git</span>
</pre>
</div>


<p>If, instead, you're looking to use Git to track both MWF releases and your own changes, you'll want to first initialize your own repository:</p>

<div class="highlight">
<pre><span class="n">mkdir</span> <span class="n">mwf</span>
<span class="n">cd</span> <span class="n">mwf</span>
<span class="n">git</span> <span class="n">init</span>
</pre>
</div>


<p>Once this is initialized, if you have a remote Git repository, you'll want to add a remote as follows:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">remote</span> <span class="n">add</span> <span class="n">origin</span> <span class="p">{</span><span class="n">YOUR_REMOTE_URL</span><span class="p">}</span>
</pre>
</div>


<p>Regardless of if you have your own remote repository, or intend to just handle version control locally, the next step is then to configure another remote that points at the MWF central repository:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">remote</span> <span class="n">add</span> <span class="n">upstream</span> <span class="n">git</span><span class="p">@</span><span class="n">github</span><span class="p">.</span><span class="n">com</span><span class="p">:</span><span class="n">ucla</span><span class="o">/</span><span class="n">mwf</span><span class="p">.</span><span class="n">git</span>
</pre>
</div>


<p>Once this remote is configured, then you can fetch a copy of the MWF itself:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">pull</span> <span class="n">upstream</span> <span class="n">master</span>
</pre>
</div>


<p>If you have your own remote repository, you can then push it up to that remote as follows:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">push</span> <span class="n">origin</span> <span class="n">master</span>
</pre>
</div>


<p>To begin developing your own code, it is recommended at minimum to work in your own branch.</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">checkout</span> <span class="o">-</span><span class="n">b</span> <span class="p">{</span><span class="n">INSTITUTION_NAME</span><span class="p">}</span><span class="o">/</span><span class="n">master</span> <span class="n">master</span>
</pre>
</div>


<p>At this point in time, you now have your own branch that you're working in and can do your own commits to separate from those of the MWF itself.</p>

<h2>Installing the Framework</h2>

<p>Once you have a copy of the framework, installation is relatively simple.</p>

<p>It is recommended that you configure your document root to be the <code>root/</code> directory of the MWF, keeping it isolated from other MWF folders such as <code>install/</code> and <code>config/</code>.</p>

<p>The first step to installing is to run the following command:</p>

<div class="highlight">
<pre><span class="n">sudo</span> <span class="n">sh</span> <span class="n">install</span><span class="o">/</span><span class="n">install</span><span class="p">.</span><span class="n">sh</span>
</pre>
</div>


<p>This will create <code>/var/mobile</code> and several directories under it for caching and other framework features that require the file system. These directories are relatively light. If you are not running a system that supports this, or you do not have <code>sudo</code>, you can still use the framework. You'll just need to take a look at the install script and create the directories with proper permissions where you intend to place them.</p>

<p>Once this is done, then you'll want to modify configuration files in <code>config/</code>.</p>

<p>The following two properties in <code>config/global.php</code> must be set:</p>

<ul>
<li>
<code>site_url</code> The web accessible URL where the front splash page (<code>root/index.php</code>) resides <strong>[required]</strong>
</li>
<li>
<code>site_assets_url</code> The web accessible URL where the MWF assets (<code>root/assets/</code>) reside <strong>[required]</strong>
</li>
</ul><p>Beyond these, <code>config/global.php</code> includes several other properties that may be set. Please refer to inline documentation as to the purpose of each of these properties.</p>

<p>There are several other configuration files you may want to modify to get started:</p>

<ul>
<li>
<code>config/analytics.php</code> with your Google Analytics key to enable Google Analytics</li>
<li>
<code>config/css.php</code> with a directory name of CSS files that you'll define special for your institution</li>
<li>
<code>config/frontpage.php</code> with the structure of items displayed the front splash page (<code>index.php</code>)</li>
<li>
<code>config/mobile.php</code> if you want to change the maximum screen dimensions for a device to be considered "mobile"</li>
<li>
<code>config/preview.php</code> with the domain under which the preview mode menu should appear</li>
</ul><p>If you did not run <code>install/install.sh</code>, or have configured your directories in a different way, you will also need to set the image cache directory variable <code>cache_dir</code> in <code>config/image.php</code> to be a directory that is writable by the web server user.</p>

<p>Once this is done, you should have a working copy of the framework.</p>

<h2>Customizing the Framework</h2>

<p>Most institutions seek to apply their own styles to the framework. To do this, you do <em>not</em> need to modify the files under <code>root/assets/css/default</code>. Instead, you should create another directory under <code>root/assets/css</code> and set the variable in <code>config/css.php</code> as this directory name. </p>

<p>Once you have another directory under <code>root/assets/css</code> and have configured <code>config/css.php</code> as such, you can define a <code>basic.css</code>, <code>standard.css</code> and/or <code>full.css</code> within this directory and these definitions will be loaded in addition to the default CSS.</p>

<h2>Updating the Framework</h2>

<p>The framework is frequently updated with bug fixes, added device support and new features. As such, updating it to the latest stable version is highly recommended. A stable version number is one either with an <code>rc</code> descriptor at the end of the version number, or one with no descriptor at the end.</p>

<p>In the event that you're doing this without Git, you should follow this process:</p>

<ol>
<li>Download the latest copy of the framework into a new directory.</li>
<li>Copy your configuration settings to the new directory.</li>
<li>Copy your custom CSS folder to the new directory.</li>
<li>Copy any modules you have created into the new directory.</li>
</ol><p>However, this is where the power of Git really shines. </p>

<p>Under the Git model described above, you can instead issue the following commands:</p>

<div class="highlight">
<pre><span class="n">git</span> <span class="n">checkout</span> <span class="n">master</span>
<span class="n">git</span> <span class="n">pull</span> <span class="n">upstream</span> <span class="n">master</span>
<span class="n">git</span> <span class="n">checkout</span> <span class="p">{</span><span class="n">INSTITUTION_NAME</span><span class="p">}</span><span class="o">/</span><span class="n">master</span>
<span class="n">git</span> <span class="n">merge</span> <span class="o">--</span><span class="n">no</span><span class="o">-</span><span class="n">ff</span> <span class="n">master</span>
</pre>
</div>


<p>If there are no conflicts, this process will occur smoothly and without a hitch. If there are conflicts, you can then resolve them as need be. This will not affect any CSS in your custom CSS folder, nor modules you have created or configuration settings you have made. This thus significantly reduces the effort involved in maintaining the latest version of the framework for your institution.</p>

<h2>Going a Step Further</h2>

<p>If you're interested not only in using the framework, but in developing for it and contributing back to the initiative, this is highly encouraged. The first step to doing this is <a href="mailto:mwf@lists.ucla.edu">contacting the MWF core team</a> to get access to the JIRA issue tracking system. Then you can use Git to create a patch file that you can submit to JIRA as a "Merge Request" ticket. If you have a public Git repository, you can also issue a pull request to the <code>develop</code> branch of MWF itself. More information on this is coming soon to the wiki, or available on request in the meantime.</p>

</div>