<h1 id="header">Menu</h1>

<div class="content">

<h2>Description</h2>

<p>The <code>&lt;div.menu&gt;</code> entity and its variations form a distinct content area for a menu that spans the full width of a page. It includes various stylings that can be applied as well such as <code>.not-padded</code> and <code>.detailed</code>.</p>

<h2>Intent</h2>

<p>This entity can be employed by any module to create a menu. It contains a <code>&lt;ul&gt;</code> or <code>&lt;ol&gt;</code> entity inside.</p>

<h2>Example Code</h2>

<p>This is an example menu that leverages several different components of menu styling.</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"menu detailed not-padded"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"light"</span><span class="nt">&gt;</span>{MENU_TITLE}<span class="nt">&lt;/h1&gt;</span> 
    <span class="nt">&lt;ul&gt;</span> 
        <span class="nt">&lt;li&gt;</span>	
            <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_1}"</span><span class="nt">&gt;</span> 
            {LINK_TITLE_1}
            <span class="nt">&lt;/a&gt;&lt;/li&gt;</span> 
        <span class="nt">&lt;li&gt;</span>	
            <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_2}"</span><span class="nt">&gt;</span> 
            {LINK_TITLE_2}
            <span class="nt">&lt;/a&gt;&lt;/li&gt;</span> 
        <span class="nt">&lt;li</span> <span class="na">class=</span><span class="s">"menu-last"</span><span class="nt">&gt;</span>	
            <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_3}"</span><span class="nt">&gt;</span> 
            {LINK_TITLE_3}
            <span class="nt">&lt;/a&gt;&lt;/li&gt;</span> 
    <span class="nt">&lt;/ul&gt;</span>
<span class="nt">&lt;/div&gt;</span>
</pre>
</div>


<p>In all cases, the containing entity of a menu is a <code>div.menu</code>. This allows the use of both ordered list items (selectable entities in the menu) and other items such as headers or content detail areas. In addition, it provides <code>.detailed</code> and <code>.not-padded</code> for additional styling of the entire menu.</p>

<p>Within most menus, the first element will be an <code>&lt;h1&gt;</code> or <code>&lt;h4&gt;</code> representing the menu title. In these cases, <code>.light</code> is available for both. However, a header element is optional in any case. After the header (or at the beginning of <code>&lt;div.menu&gt;</code> if no header is used) comes an <code>&lt;ol&gt;</code> element, which provides the menu item styling. No additional classes are needed at the child level. To add subtitle text to a detailed menu (a menu with the <code>.detailed</code> styling class), use <code>&lt;span.smallprint&gt;</code>.</p>

<p>This code demonstrates a <code>.detailed</code> menu item that includes subtext:</p>

<div class="highlight">
<pre><span class="nt">&lt;li&gt;</span> 
    <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL}"</span><span class="nt">&gt;</span>{LINK_TITLE}
    <span class="nt">&lt;br</span> <span class="nt">/&gt;&lt;span</span> <span class="na">class=</span><span class="s">"smallprint"</span><span class="nt">&gt;</span>{LINK_EXTRA_TEXT}&gt;<span class="nt">&lt;/span&gt;&lt;/a&gt;</span>
<span class="nt">&lt;/li&gt;</span>
</pre>
</div>


<p>The UCLA Newsroom application uses <code>.menu</code> with <code>.detailed</code>. It also employs the <code>&lt;h1.light&gt;</code> entity.</p>

<p><img src="<?php echo URL::asset('images/menu-newsroom.png'); ?>" alt="Newsroom Menu"></p>

</div>