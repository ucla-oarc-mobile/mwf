<h1 id="header">Getting Started: Module Development</h1>

<div class="content">
    
    <h2>How to Implement the Framework</h2>

    <p>The first step in developing a module with the UCLA Mobile Web Framework is implementing the Framework in your application. By implementing the framework in your application, you will have access to all of the CSS styles and Javascript assets that are responsible for delivering a device agnostic mobile presentation. </p>

    <p>To implement the Framework in your application you simply include two tags in the <code>&lt;head&gt;</code> section of your page:</p>

    <div class="highlight">
    <pre><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/css.php"</span> <span class="na">type=</span><span class="s">"text/css"</span><span class="nt">&gt;</span>
    <span class="nt">&lt;script </span><span class="na">type=</span><span class="s">"text/javascript"</span> <span class="na">src=</span><span class="s">"http://{MOBILE_DOMAIN}/assets/js.php"</span><span class="nt">&gt;&lt;/script&gt;</span>
    </pre>
    </div>


    <p>These two tags will include a stylesheet and a javascript file that comprise the UCLA MWF in it's entirety, and once included, you have successfully implemented the Framework in your application. Although these are the only two tags the framework requires for inclusion, it is highly recommended that the following <code>&lt;meta&gt;</code> tag be included as well for uniform screen scaling across mobile devices:</p>

    <div class="highlight">
    <pre><span class="nt">&lt;meta</span> <span class="na">name=</span><span class="s">"viewport"</span> <span class="na">content=</span><span class="s">"height=device-height,width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"</span><span class="nt">&gt;</span>
    </pre>
    </div>


    <p>The framework does not require any application-side code to leverage as a content provider.</p>

    <h2>Building A Mobile User Interface</h2>

    <p>The UCLA Mobile Web Framework, in essence, is focused on content presentation, and as such is not in any way responsible for or cognizant of any content generation or data management in a given application. Because of this, it is up to the developer how they architect the backend system of the application. The only thing the framework requires is that a core set of HTML entities be used, allowing the framework to handle presentation. </p>

    <p>As such, developing a module with the UCLA Mobile Web Framework comes down to simply building an HTML interface that uses the correct classes, and the Mobile Web Framework will handle the rest.</p>

    <p>A key concept in building a mobile UI is simplicity. When users view a mobile application, they are generally presented with a minimal data set and as simplistic of an interface as possible. If you are porting an existing web application to a mobile module, it is recommended that you first think about what data is absolutely vital for the user, and what data may be superfluous when viewed on a mobile device. By streamlining your module and making it easy to navigate, you will present mobile users with the best possible application-like experience.</p>

    <h2>Key Entities</h2>

    <p>There are a few key entities you will likely want to use in your application, such as a <a class="internal present" href="<?php echo URL::path('entity/base'); ?>">header/footer</a>, <a class="internal present" href="<?php echo URL::path('entity/menu'); ?>">menu</a>, and <a class="internal present" href="<?php echo URL::path('entity/content'); ?>">content area</a>. You can find detailed information about each of these entities by clicking on these links, which will take you to the documentation page for each entity.</p>

    <h3>Header</h3>

    <p>To create a header, simply make a new <code>&lt;h1&gt;</code> entity and give it an <code>id="header"</code>. You can place an image and a link in the header for a logo that takes the user to the front page of your application (or another location), and you can add header text with a <code>&lt;span&gt;</code> element.</p>

    <p>This example is the default for UCLA Mobile:</p>

    <div class="highlight">
    <pre><span class="nt">&lt;h1</span> <span class="na">id=</span><span class="s">"header"</span><span class="nt">&gt;</span> 
        <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://m.ucla.edu"</span><span class="nt">&gt;</span> 
            <span class="nt">&lt;img</span> <span class="na">src=</span><span class="s">"http://m.ucla.edu/assets/img/ucla-logo.png"</span> <span class="na">alt=</span><span class="s">"UCLA"</span> <span class="na">width=</span><span class="s">"75"</span> <span class="na">height=</span><span class="s">"35"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;/a&gt;</span> 
        <span class="nt">&lt;span&gt;</span>{MODULETITLE}<span class="nt">&lt;/span&gt;</span> 
    <span class="nt">&lt;/h1&gt;</span>
    </pre>
    </div>


    <p>The exact prototype for the header may vary in the <code>a</code> and <code>img</code> link between content providers, and thus it is recommended that you follow the proscribed form by your institution's framework service provider. However, the markup style is roughly the same between deployments.</p>

    <h3>Footer</h3>

    <p>To create a footer, create a <code>&lt;div&gt;</code> entity and give it an id of <strong>#footer</strong>. This will place all contained text in a centered full-width area at the bottom of the page, and can be used for copyright notices and bottom navigation links. </p>

    <p>This example is the default for UCLA Mobile:</p>

    <div class="highlight">
    <pre><span class="nt">&lt;div</span> <span class="na">id=</span><span class="s">"footer"</span><span class="nt">&gt;</span> 
        <span class="nt">&lt;p&gt;</span>University of California <span class="ni">&amp;copy;</span> 2010 UC Regents<span class="nt">&lt;br</span> <span class="nt">/&gt;</span> 
        <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://{MOBILE_HELP_PAGE}"</span><span class="nt">&gt;</span>Help<span class="nt">&lt;/a&gt;</span> | <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"http://{DESKTOP_URL}"</span><span class="nt">&gt;</span>View Full Site<span class="nt">&lt;/a&gt;&lt;/p&gt;</span> 
    <span class="nt">&lt;/div&gt;</span>
    </pre>
    </div>


    <p>Again, the exact values of the <code>a</code> tags vary from institution to institution, but, as with the header, the general prototype is the same between deployments.</p>

    <h3>Menus</h3>

    <p>To create a menu, simply create a div entity and give it <code>class="menu-full</code>. Within the <code>div.menu-full</code> entity, you can specify a menu header with an <code>&lt;h1&gt;</code> entity and build your menu with an ordered list (<code>&lt;ol&gt;</code>). </p>

    <p>By default, the <code>div.menu-full</code> entity will give a full-width menu with large, centered items. Additionally, you can use the the <code>menu-padded</code> and <code>menu-detailed</code> classes for more styling. The <code>menu-padded</code> class will add some padding around the menu, and give it rounded corners on devices that support it. The <code>menu-detailed</code> class will make the menu items left aligned and give them a slightly smaller font. This is useful for more detailed menus where each item may have additional associated text. </p>

    <p>See below for some example menus.</p>

    <div class="highlight">
    <pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"menu-full menu-padded"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"light menu-first"</span><span class="nt">&gt;</span>{MENU_TITLE}<span class="nt">&lt;/h1&gt;</span> 
        <span class="nt">&lt;ol&gt;</span> 
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
        <span class="nt">&lt;/ol&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
    </pre>
    </div>


    <p>The preceding code is a simple padded menu that has three centered link items. This is a good solution for a simple broad navigation where each link item is a single phrase such as "Home" or "Contact Info". Especially noteworthy is the use of the <code>menu-first</code> and <code>menu-last</code> classes to delineate the first and last child entities of the menu. While not necessary for most devices, the use of these styles is highly recommended for backwards compatibility of devices that do not support the <code>:first-child</code> and <code>:last-child</code> CSS 2.1 pseudo-selectors.</p>

    <div class="highlight">
    <pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"menu-full menu-detailed menu-padded"</span><span class="nt">&gt;</span>
        <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"light menu-first"</span><span class="nt">&gt;</span>{MENU_TITLE}<span class="nt">&lt;/h1&gt;</span> 
        <span class="nt">&lt;ol&gt;</span> 
            <span class="nt">&lt;li&gt;</span>
                <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_1}"</span><span class="nt">&gt;</span> 
                {LINK_TITLE_1}
                <span class="nt">&lt;br</span> <span class="nt">/&gt;&lt;span</span> <span class="na">class=</span><span class="s">"smallprint"</span><span class="nt">&gt;</span>{LINK1_EXTRA_TEXT}&gt;<span class="nt">&lt;/span&gt;&lt;/a&gt;</span>
            <span class="nt">&lt;/li&gt;</span> 
            <span class="nt">&lt;li&gt;</span>	
                <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_2}"</span><span class="nt">&gt;</span> 
                {LINK_TITLE_2}
                 <span class="nt">&lt;br</span> <span class="nt">/&gt;&lt;span</span> <span class="na">class=</span><span class="s">"smallprint"</span><span class="nt">&gt;</span>{LINK2_EXTRA_TEXT}&gt;<span class="nt">&lt;/span&gt;&lt;/a&gt;</span>
            <span class="nt">&lt;/li&gt;</span> 
            <span class="nt">&lt;li</span> <span class="na">class=</span><span class="s">"menu-last"</span><span class="nt">&gt;</span>
                <span class="nt">&lt;a</span> <span class="na">href=</span><span class="s">"{LINK_URL_3}"</span><span class="nt">&gt;</span> 
                {LINK_TITLE_3}
                 <span class="nt">&lt;br</span> <span class="nt">/&gt;&lt;span</span> <span class="na">class=</span><span class="s">"smallprint"</span><span class="nt">&gt;</span>{LINK3_EXTRA_TEXT}&gt;<span class="nt">&lt;/span&gt;&lt;/a&gt;</span>
           <span class="nt">&lt;/li&gt;</span>
        <span class="nt">&lt;/ol&gt;</span>
    <span class="nt">&lt;/div&gt;</span>
    </pre>
    </div>


    <p>The preceding code shows an example of a more detailed menu using a menu with the <code>.menu-detailed</code> class as well as <code>span</code> elements with the <code>smallprint</code> class within the <code>&lt;a&gt;</code> tags of the list items to specify more content within each link. This can be used to give short descriptions of menu items used for articles or content links.</p>

    <h3>Content</h3>

    <p>To create a content area, simply create a <code>&lt;div&gt;</code> entity and give it <code>class="content-full</code>. By default, this will create a standalone content box entity that will be styled to display appropriately on various devices. </p>

    <p>As with the menu, there is a <code>content-padded</code> class available for further styling, and the use of <code>content-first</code> and <code>content-last</code> classes is highly encouraged for graceful degradation.</p>

    <p>Within a <code>div.content-full</code> entity, <code>&lt;h1&gt;</code> and <code>&lt;p&gt;</code> elements will be treated as block level elements. If you have multiple paragraphs in the same block of content, it is recommended that you place the correlating <code>&lt;p&gt;</code> elements within a <code>&lt;div&gt;</code> so the paragraphs themselves are not treated as separate content blocks. </p>

    <p>The <code>content-button</code> class can be applied to <code>&lt;div&gt;</code> elements for links (it is recommended that the contents of the <code>&lt;div&gt;</code> be wrapped in an <code>&lt;a&gt;</code> element), and <code>&lt;div.label&gt;</code> elements can be used within <code>&lt;div&gt;</code> elements to specify labels for content.</p>

    <p>See below for an example of a content area.</p>

    <div class="highlight">
    <pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"content-full content-padded"</span><span class="nt">&gt;</span> 
        <span class="nt">&lt;h1</span> <span class="na">class=</span><span class="s">"content-first light"</span><span class="nt">&gt;</span>{CONTENT_TITLE}<span class="nt">&lt;/h1&gt;</span> 
        <span class="nt">&lt;div&gt;</span>{CONTENT_BLOCK}<span class="nt">&lt;/div&gt;</span> 
        <span class="nt">&lt;p&gt;</span>{CONTENT_TEXT_BLOCK_1}<span class="nt">&lt;/p&gt;</span> 
        <span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"content-last"</span><span class="nt">&gt;</span>
            <span class="nt">&lt;p&gt;</span>{CONTENT_TEXT_BLOCK_2_PARAGRAPH_1}<span class="nt">&lt;/p&gt;</span> 
            <span class="nt">&lt;p&gt;</span>{CONTENT_TEXT_BLOCK_2_PARAGRAPH_1}<span class="nt">&lt;/p&gt;</span> 
        <span class="nt">&lt;/div&gt;</span> 
    <span class="nt">&lt;/div&gt;</span>
    </pre>
        
</div>