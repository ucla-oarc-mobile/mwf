<h1 id="header">Button</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>.button</code> entity and its variations form a button that spans the full width of a page. This button includes a gradient background using <strong>-moz</strong> and <strong>-webkit</strong> style attributes when possible, otherwise reverting to a solid color similar to the intended gradient. Depending on the way in which the entity and contained elements are marked up, the button will format itself as a one or two option button.</p>

<p>A variation on this, the <code>&lt;a#button-top&gt;</code> entity is available for non-linear browsers (standard and full devices) that positions a given link to be right-aligned within the page header, regardless of where the attribute resides in page markup.</p>

<h2>Intent</h2>

<p>The <code>.button</code> entity can be employed by any module to create a stand-alone object that links elsewhere in the system. Often, this entity is used to provide a back button or directional navigation buttons (next and previous) for a specific page. It is not intended to be used inside of a content area element such as a <strong>.content-full</strong> or <strong>.menu-full</strong>, but instead it should be used as a direct child of the body tag. To create a button inside a content area element, please see the documentation page for <a class="internal present" href="<?php echo URL::path('entity/content'); ?>">content</a>.</p>

<p>The <strong>#button-top</strong> entity can be employed by any module to create a stand-alone object that resides in the header and links elsewhere in the system. Often, this entity is used to provide a home button on a child page. It can be assigned to any <code>&lt;a&gt;</code> entity that will fit in a 16px by 85px space, as long as the <code>&lt;a&gt;</code> entity does not reside within a relatively positioned entity.</p>

<h2>Example Code</h2>

<h3>Single Option Button</h3>

<p>At the most basic level, a single option full width button can be created via <code>&lt;a.button&gt;</code>:</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>

<p><img src="<?php echo URL::asset('images/button-full-padded.png'); ?>" alt="Full Button with Padding"></p>

<p>Derived from this markup is <code>&lt;a.button.not-padded&gt;</code>, a variation where the button does not have padding on the edges of the browser nor rounded corners:</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">class=</span><span class="s">"button not-padded"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>

<p><img src="<?php echo URL::asset('images/button-full.png'); ?>" alt="Full Button with No Padding"></p>

<p>The framework also provides an alternate color scheme for buttons with <code>&lt;.light&gt;</code>:</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">class=</span><span class="s">"button light"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>


<p><img src="<?php echo URL::asset('images/button-full-padded-light.png'); ?>" alt="Light Full Button with Padding"></p>

<h3>Two Option Button</h3>

<p>The framework also provides the ability to create a two option button using a <code>&lt;div.button&gt;</code> entity:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_1}"</span><span class="nt">&gt;</span>{LINK_TEXT_1}<span class="nt">&lt;/a&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_2}"</span><span class="nt">&gt;</span>{LINK_TEXT_2}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>

<p><img src="<?php echo URL::asset('images/button-two-full-padded.png'); ?>" alt="Two Option Full Button"></p>


<p>As with a single option button, the two option button also supports <strong>.not-padded</strong>:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"button not-padded"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_1}"</span><span class="nt">&gt;</span>{LINK_TEXT_1}<span class="nt">&lt;/a&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_2}"</span><span class="nt">&gt;</span>{LINK_TEXT_2}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>The <code>&lt;div.button&gt;</code> attribute also has support for a single button element:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>The above method is completely interchangeable with the <code>&lt;a.button&gt;</code> markup described in the single option section.</p>

<p>For two item buttons, the <code>.light</code> attribute is assigned at the <code>&lt;a&gt;</code> level, not the <code>&lt;div&gt;</code> level:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_1}"</span> <span class="na">class=</span><span class="s">"light"</span><span class="nt">&gt;</span>{LINK_TEXT_1}<span class="nt">&lt;/a&gt;</span>
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_2}"</span> <span class="na">class=</span><span class="s">"light"</span><span class="nt">&gt;</span>{LINK_TEXT_2}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p><img src="<?php echo URL::asset('images/button-two-full-padded-light.png'); ?>" alt="Two Option Light Full Button with Padding"></p>

<p>The <code>.light</code> attribute may also be assigned to either option or both.</p>

<h3>Top Button</h3>

<h4>Basic Use</h4>

<p>At the most basic level, the <code>&lt;a#button-top&gt;</code> entity is defined as follows:</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">id=</span><span class="s">"button-top"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>


<p>Since the <code>&lt;a#button-top&gt;</code> entity leverages absolute positioning to position itself on the page, non-linear browsers (such as those found on T9 phones) will not be able to position the button correctly, and it will appear where ever you place the link in your markup. Use of the <strong>.not-basic</strong> class provides a mechanism for targeting only the non-linear browsers that support <code>&lt;a#button-top&gt;</code> positioning:</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">id=</span><span class="s">"button-top"</span> <span class="na">class=</span><span class="s">"not-basic"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>


<h4>Recommended Use (Graceful Degradation)</h4>

<p>The basic approach of <code>&lt;a#button-top.not-basic&gt;</code> works under most conditions, but for browsers that are not CSS compliant, graceful degradation is not possible. Furthermore, because basic browsers often need a home entity as well, the <code>&lt;a#button-top&gt;</code> entity is set up in such a way that it is fully compatible with <code>&lt;a.button&gt;</code> and its decorative styles.</p>

<div class="highlight">
<pre><span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span> <span class="na">id=</span><span class="s">"button-top"</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span>{LINK_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>


<p>In this example the button will appear as a regular full width button on a linear browser, yet it will appear as a right-aligned button within the page <code>&lt;h1#header&gt;</code> entity on a non-linear browser.</p>

<h2>Warnings</h2>

<h3>DOM Technical Warning for <strong>#button-top</strong>
</h3>

<p>The <code>&lt;a#button-top&gt;</code> entity leverages absolute positioning to place itself within the <code>&lt;h1#header&gt;</code> entity. As such, <code>&lt;a#button-top&gt;</code> cannot reside within a parent entity that is positioned relatively, but instead required either a statically (default behavior for an entity) or absolutely positioned set of parent entities. Further, <code>&lt;a#button-top&gt;</code> should not be employed on a page that does not include <code>&lt;h1#header&gt;</code>.</p>

<h2>W3C Markup Note for <code>&lt;a.button&gt;</code>
</h2>

<p>It is recommended by the W3C XHTML standard that an inline element <code>&lt;a&gt;</code> is always enclosed by a block element such as <code>&lt;div&gt;</code>. However, this is not required in the case of <code>&lt;a.button-full&gt;</code>, as the <code>&lt;a&gt;</code> entity is itself defined as a block-level element, so all styling and positioning is set correctly without a parent element.  Also, note that it is recommended that all framework modules validate with the HTML 5 doctype rather than an XHTML doctype.</p>

</div>