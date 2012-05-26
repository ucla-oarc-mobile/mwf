<h1 id="header">Mobile Redirector</h1>

<div class="content">
    <h2>Redirect Script Basics</h2>

<p>The UCLA Mobile Web Framework provides a script that redirects "mobile" users away from one page to another.</p>

<p>The basic syntax for enabling such a redirect must include at minimum a URL encoded path for the GET parameter <code>m</code>.</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"application/javascript"</span> 
    <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/redirect/js.php?m={MOBILE_PATH}"</span><span class="nt">&gt;</span>
<span class="nt">&lt;/script&gt;</span>
</pre>
</div>


<p>A mobile user is one that is classified as such by <a class="internal present" href="<?php echo URL::path('core/classification'); ?>">mwf.classification.isMobile()</a>, namely one that has a screen size (as determined by <a class="internal present" href="<?php echo URL::path('core/screen'); ?>">mwf.screen</a>) less than the dimensions configured by the framework service provider in <code>config/global.php</code>.</p>

<p><strong>Compatibility Note:</strong> In MWF 1.0-1.1, rather than using Javascript to classify the user as mobile or non-mobile, the static metadata instead provided this definition. As such, the devices classified as mobile in MWF 1.0-1.1 may vary slightly from those in MWF 1.2.</p>

<p>At the most basic level, the advantage to using this script, as opposed to a self-engineered one, is that it considers user agents consistently with the mobile web framework itself, and it does so for a total payload of under 2 KB, as opposed to the <a class="internal present" href="<?php echo URL::path('script/required'); ?>">JS Handler</a>, which has a much larger payload size.</p>

<p>The redirect script also includes other benefits such as override capabilities and domain specificity (see below).</p>

<h2>Overriding the Redirect</h2>

<p>Sometimes a user on a mobile device may desire to view the full site, rather than the mobile site.</p>

<p>The redirect script makes this kind of functionality possible through a very simple mechanism. If a user requests a page with the redirect script included, but does so with a GET parameter <code>override_redirect=1</code>, then the redirect script will not redirect the user.</p>

<p>The redirect preference may be reset to redirect to mobile by requesting a page with <code>override_redirect=0</code>.</p>

<p><strong>Compatibility Note:</strong> In MWF 1.0-1.1, the override GET parameter was <code>ovrrdr</code>. For backwards compatibility, the <code>ovrrdr</code> parameter is still regarded as valid in MWF 1.2. However, MWF 1.0-1.1 do not accept the <code>override_redirect</code> parameter, as this was added in MWF 1.2.</p>

<p>The redirect script maintains the preference specified by the <code>override_redirect</code> parameter for all pages that include the script. By default, it maintains the preference for five minutes, refreshing the preference whenever the user lands on any page that also includes the redirect script.</p>

<p>There are three reasons an override on the redirect may stop:</p>

<ul>
<li>A page with <code>assets/redirect/js.php</code> is requested with the GET parameter <code>override_redirect=0</code>.</li>
<li>Five minutes pass without the user visiting a page that includes <code>assets/redirect/js.php</code>.</li>
<li>The user visits a page that uses the mobile framework, most notably the <code>assets/js.php</code> file.</li>
</ul><p>To avoid conflict between these scripts, <code>assets/redirect/js.php</code> file should never be included on the same page as the framework <code>assets/js.php</code> file.</p>

<h2>Domain Specificity and Expiries</h2>

<p>In some cases, it may not make sense to override the redirect universally. For example, one application might have links to another and the user might want to be on the desktop site for the first application, but on the mobile site for the other application.</p>

<p>Therefore, the script allows a domain identifier specified in the script include path as the GET parameter <code>d</code>:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"application/javascript"</span> 
    <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/redirect/js.php?m={MOBILE_PATH}&amp;d={DOMAIN}"</span><span class="nt">&gt;</span>
<span class="nt">&lt;/script&gt;</span>
</pre>
</div>


<p>In this case, the override call is still the same: request <code>sample.php?override_redirect=1</code> to prevent the redirect on sample.php. In this case, however, the setting will only apply to pages that include <code>assets/redirect/js.php</code> with the GET parameter <code>d</code> equal to <code>{DOMAIN}</code>.</p>

<p>For a specific domain, one may also set the expiration time on the preference to something besides five minutes via the GET parameter <code>e</code>.  This parameter is interpreted as the number of seconds until expiration from the current time:</p>

<div class="highlight">
<pre><span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"application/javascript"</span> 
    <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/redirect/js.php?m={MOBILE_PATH}&amp;d={DOMAIN}&amp;e={EXPIRY_SECONDS}"</span><span class="nt">&gt;</span>
<span class="nt">&lt;/script&gt;</span>
</pre>
</div>


<p>To avoid unintended global behaviors, the <code>e</code> parameter is not accepted without a <code>d</code> parameter for the domain.</p>

<p>This script thus provides a very powerful cross-domain way of achieving redirection and maintaining user browser preferences.</p>