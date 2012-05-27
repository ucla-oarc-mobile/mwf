<h1 id="header">Update Information</h1>

<div class="content">

<p>This documentation details upgrade requirements and significant changes for service and content providers for minor and major version releases. Documentation is not provided for revision releases, because they should not significantly change the behavior for either service or content providers.</p>

<h1>MWF 1.2 to MWF 1.3</h1>

<p>There are several notices for service providers in MWF 1.3:</p>

<ul>
<li>
<strong>PHP 5.3 is required for MWF 1.3, as opposed to MWF 1.2, which only required PHP 5.1.6.</strong> This requirement of PHP 5.3 will be maintain in all future releases of MWF.</li>
<li>
<strong>Configuration file format has changed to <code>ini</code> style in MWF 1.3.</strong> Service providers will thus need to port over configuration settings from MWF 1.2 <code>.php</code> files to <code>.ini</code> files in MWF 1.3. All future releases will use <code>ini</code> style instead of PHP files directly.</li>
<li>
<strong>The decorators in MWF 1.3 do not allow HTML content to be passed as inner content.</strong> This is a change from MWF 1.2, where MWF 1.2.14 generates E_NOTICE warnings, and prior versions of MWF 1.2 allow this content passed without any side-effects. For service providers that require HTML content to be passed, <code>-&gt;render(true)</code> may be passed instead of <code>-&gt;render()</code> in order to allow HTML content. However, it is generally recommended that this is not done.</li>
<li>
<strong>Caching now occurs in non-system directory.</strong> By default, instead of caching in the system <code>/var/mobile</code> directory, caching occurs in the <code>var</code> directory inside of the MWF distribution (but outside of the HTML doc root, which is in the <code>root</code> directory). So that the web server can read and write to it, you may need to change the ownership and/or permissions of the <code>var</code> directory that is inside of the MWF distribution directory.  If the web server cannot write to the caching directory, MWF will continue to work but will not use the cache for RSS feeds and minified images. You can change the location of the caching directory in the configuration files.</li>
<li>
<strong>No installation script.</strong> MWF 1.2 required an installation script to create necessary system directories. Those directories are no longer needed and there is no need for an installation script.</li>
<li>
<strong>No configuration required if MWF's <code>root</code> directory is your web docroot.</strong> MWF 1.2 required two configuration settings out of the box for it to work. MWF 1.3 will work without any configuration at all if the <code>root</code> directory is your web docroot. Of course, you'll want to customize MWF 1.3 with your own assets and content anyway. </li>
</ul><p>Content providers should also be advised of the following:</p>

<ul>
<li>
<strong>Lean CSS should be recommended for MWF 1.3, instead of the old syntax in MWF 1.2.</strong> By default, <code>css.php</code> provides definitions for both the old syntax (which includes suffixes like <code>content-full</code> for content and prefixes all qualifiers like <code>content-padded</code>, whereas the new syntax is <code>content</code> and <code>padded</code>). To run pages with only the lean CSS, pages should include <code>css.php?lean</code> instead of <code>css.php</code>. In MWF 2, the non-lean syntax will be removed altogether.</li>
<li>
<strong>Javascript API changes have been made.</strong> This removes the <code>mwf.capability.flexbox()</code> method because its completely inaccurate as reported by browsers currently. The <code>mwf.standard.geolocation</code> library has also been modified, especially in the way it handles errback.</li>
</ul><p>Because of some minor changes for content providers (namely the Javascript API), it is recommended that a preview instance be put up for content providers to test against before porting your instance completely over to MWF 1.3.</p>

</div>