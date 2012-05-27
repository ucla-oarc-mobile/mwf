<h1 id="header">Requirements &amp; Packages</h1>

<div class="content">

<h2>System Requirements</h2>

<p>The codebase of the Mobile Web Framework is compatible with *NIX variants (including Redhat Linux, Debian Linux, Solaris, Mac OS X, etc.) running Apache 2 and PHP 5.1.6 and above, and it is the intent of the project to maintain full portability across all of these systems.</p>

<p>In addition, due to PHP's portability functions, some have reported success (with modifications to configuration files and paths) in installing the framework on Windows Server. However, at this time, the installation scripts, default file paths and the documentation on this site are preferential to *NIX, particularly Cent OS, Fedora and RHEL, so these operating systems are generally recommended.</p>

<h2>Required Packages</h2>

<p>The framework itself requires several packages (listed by their Redhat yum name):</p>

<ul>
<li>httpd</li>
<li>php</li>
<li>php-common</li>
<li>php-devel</li>
<li>php-cli</li>
<li>php-curl</li>
<li>php-gd</li>
<li>php-xml</li>
</ul><p>In addition, the following PHP directives should be enabled for best effect:</p>

<ul>
<li>allow_url_fopen = 1</li>
<li>display_errors = 0</li>
<li>safe_mode = 0</li>
</ul>

</div>