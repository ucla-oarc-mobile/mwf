<h1 id="header">Header &amp; Footer</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>&lt;h1#header</code>&gt; entity forms a top bar that spans full width across the top of mobile pages in the framework. This top bar includes a gradient, using <strong>-moz</strong> and <strong>-webkit</strong> style attributes when possible, otherwise reverting to a solid color similar to the intended gradient.</p>

<p>The <code>&lt;div#footer&gt;</code> entity represents a full width bar that spans the bottom of mobile pages in the framework. This bottom bar is a vertical region distinct from the main body.</p>

<h2>Intent</h2>

<p>These entities are intended to be used on every page of an MWF-supported application. They create a unified feel between all pages. The <code>&lt;h1#header</code>&gt; provides a stylistic bar atop all pages, along with a back button to link all other pages back to the landing page. Meanwhile, the code>&lt;div#footer&gt;</code> includes a Copyright notice, a Help link, and a View Full Site link. Neither element is required on any page, but both are recommended.</p>

<h2>Header</h2>

<p><img src="<?php echo URL::asset('images/header-newsroom.png'); ?>" alt="UCLA Newsroom Header"></p>

<p>Replace <strong>{MODULE_TITLE}</strong> with a particular module's title. Replace <strong>{MOBILE_DOMAIN}</strong> with a particular University's mobile domain name.</p>

<div class="highlight">
<pre><span class="nt">&lt;h1</span> <span class="na">id=</span><span class="s">"header"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}"</span><span class="nt">&gt;</span> 
        <span class="nt">&lt;img</span> <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/img/{LOGO_IMG}"</span> <span class="na">alt=</span><span class="s">"{ALT_TAG}"</span> <span class="na">width=</span><span class="s">"75"</span> <span class="na">height=</span><span class="s">"35"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;/a&gt;</span> 
    <span class="nt">&lt;span&gt;</span>{MODULE_TITLE}<span class="nt">&lt;/span&gt;</span> 
<span class="nt">&lt;/h1&gt;</span>
</pre>
</div>

<p>There are no variations of this style. It is intended to be universal between pages.</p>

<h2>Footer</h2>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"footer"</span><span class="nt">&gt;</span> 
    <span class="nt">&lt;p&gt;</span>University of California <span class="ni">&amp;copy;</span> 2011 UC Regents<span class="nt">&lt;br&gt;</span> 
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/help"</span><span class="nt">&gt;</span>Help<span class="nt">&lt;/a&gt;</span> | <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://{FULL_SITE_DOMAIN}"</span><span class="nt">&gt;</span>View Full Site<span class="nt">&lt;/a&gt;&lt;/p&gt;</span> 
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>

<p>There are no variations of this style. It is intended to be universal between pages. However, a specific implementation may modify the text within the element if so desired.</p>

</div>