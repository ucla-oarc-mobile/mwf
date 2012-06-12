<h1 id="header">Content</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>&lt;div.content&gt;</code> entity and its variations form a distinct content area for a set of text that spans the full width of a page. It includes various stylings that can be applied as well such as <code>.content.not-padded</code>.</p>

<h2>Intent</h2>

<p>This entity can be employed by any module to create a content area. Most commonly, it will contain an <code>&lt;h1&gt;</code> header and <code>&lt;div&gt;</code> or <code>&lt;p&gt;</code> tags to separate different blocks of content.</p>

<h2>Example Code</h2>

<p>This is an example content area that leverages several different components of the style.</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"content"</span><span class="nt">&gt;</span> 
    <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"light"</span><span class="nt">&gt;</span>{CONTENT_TITLE}<span class="nt">&lt;/h1&gt;</span> 
    <span class="nt">&lt;div&gt;</span>{CONTENT_BLOCK}<span class="nt">&lt;/div&gt;</span> 
    <span class="nt">&lt;p&gt;</span>{CONTENT_TEXT_BLOCK_1}<span class="nt">&lt;/p&gt;</span> 
    <span class="nt">&lt;p</span><span class="nt">&gt;</span>{CONTENT_TEXT_BLOCK_2}<span class="nt">&lt;/p&gt;</span> 
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>In all cases, the <code>.content</code> containing entity is a <code>&lt;div&gt;</code>. This allows the use of both traditionally inline entities <code>&lt;h1&gt;</code> and <code>&lt;p&gt;</code> and the block entity <code>&lt;div&gt;</code>, where the direct children of the <code>&lt;div.content&gt;</code> are all distinct content blocks. In addition, the framework provides <code>&lt;div.not-padded&gt;</code> for additional styling of the content area (removes rounded corners and padding).</p>

<p>Within most content areas, the first element will be an <code>&lt;h1&gt;</code> used as a title heading, with the <strong>.light</strong> style optionally available. After the header (or at the beginning of the <code>&lt;div.content&gt;</code> if no header is used) comes a set of either <code>&lt;div&gt;</code> or <code>&lt;p&gt;</code> tags which define individual elements in the content elements area. No additional classes are needed at this child level, but a couple are optionally available. The <code>&lt;div.button&gt;</code> element creates a "button-like" content entity which should have an <code>&lt;a&gt;</code> tag surrounding its interior content, and in addition a <strong>.label</strong> class makes it possible to have labels, both for <code>&lt;div.button&gt;</code> and for the more general <code>&lt;p&gt;</code> and <code>&lt;div&gt;</code> tags within <code>&lt;.content&gt;</code>.</p>

<p>See below for an example using <code>&lt;div.button&gt;</code> and <code>&lt;div.label&gt;</code>:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"content"</span><span class="nt">&gt;</span> 
    <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"light"</span><span class="nt">&gt;</span>{CONTENT_TITLE}<span class="nt">&lt;/h1&gt;</span> 
    <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"button"</span><span class="nt">&gt;</span> 
        <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{BUTTON_LINK}"</span><span class="nt">&gt;</span> 
            <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"label"</span><span class="nt">&gt;</span>{BUTTON_LABEL}<span class="nt">&lt;/div&gt;</span> 
            {BUTTON_VALUE}<span class="nt">&lt;/a&gt;</span> 
    <span class="nt">&lt;/div&gt;</span> 
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>As a note, at the direct child level of <code>.content</code>, the framework defines <code>&lt;h1&gt;</code> and <code>&lt;p&gt;</code> as block entities because of the way in which it separates pieces of content. To add multiple paragraphs of content within a single content element block, add another <code>&lt;div&gt;</code> within the <code>&lt;div.content-full&gt;</code> element, and then place paragraphs within that child <code>&lt;div&gt;</code>:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"content not-padded"</span><span class="nt">&gt;</span> 
    <span class="nt">&lt;div&gt;</span>
        <span class="nt">&lt;p&gt;</span>{PARAGRAPH_1_BLOCK_1}<span class="nt">&lt;p&gt;</span>
        <span class="nt">&lt;p&gt;</span>{PARAGRAPH_2_BLOCK_1}<span class="nt">&lt;p&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
    <span class="nt">&lt;div&gt;</span>
        <span class="nt">&lt;p&gt;</span>{PARAGRAPH_3_BLOCK_2}<span class="nt">&lt;p&gt;</span>
        <span class="nt">&lt;p&gt;</span>{PARAGRAPH_4_BLOCK_2}<span class="nt">&lt;p&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>The UCLA tour app welcome message uses <code>.content</code>. It also employs the <code>&lt;h1.light&gt;</code> class.</p>

<p><img src="<?php echo URL::asset('images/content-tour.png'); ?>" alt="Self-Guided Tour Content Box"></p>

</div>