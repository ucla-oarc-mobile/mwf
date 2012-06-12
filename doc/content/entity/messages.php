<h1 id="header">Messages</h1>

<div class="content">
    
<h2>Description</h2>

<p>The <code>.message</code> element, in conjunction with a type such as
<code>.alert</code>, <code>.confirm</code>, <code>.error</code> or <code>.info</code>,
provides a message box formatted for a particular context. This message
element works as a top-level item, formatted properly for presentation at
the same level as <code>.content</code> and <code>.menu</code>, as well as
inline within the <code>.content</code> entity.</p>

<p>A variation of this entity also provides a modal popup window that 
darkens the page behind it.</p>

<h2>Example Code</h2>

<h3>Basic Markup</h3>

<p>The following demonstrates the four base contexts associated with the message
entity:</p>

<div class="highlight">
<pre><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"message alert"</span><span class="nt">&gt;</span>{MESSAGE_TEXT}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"message confirm"</span><span class="nt">&gt;</span>{MESSAGE_TEXT}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"message error"</span><span class="nt">&gt;</span>{MESSAGE_TEXT}<span class="nt">&lt;/a&gt;</span>
<span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"message info"</span><span class="nt">&gt;</span>{MESSAGE_TEXT}<span class="nt">&lt;/a&gt;</span>
</pre>
</div>

<p>The above markup yields the following output:</p>

<img src="<?php echo URL::asset('images/messages.png'); ?>">

<p>This markup can also be used inside of a <code>.content</code> entity.</p>

<h3>Javascript Functions</h3>

<p>The <code>.message</code> entity is often useful in the context of DOM events,
and thus it includes a simple Javascript object for dynamic message actions.</p>

<p>In the event that a message exists somewhere in the DOM and you wish to
bring it to the front of the screen as a modal, it is possible as (supposing in
this case that the existing message element has the id <code>alert-msg</code>):</p>

<div class="highlight">
<pre>mwf.messages.modal({ id: "alert-msg" });</pre>
</div>

<p>In addition, one may dynamically generate a new modal and bring it to the
front of the screen as:</p>

<div class="highlight">
<pre>mwf.messages.modal({
        text: "An dynamic info message",
        type: "info"
});</pre>
</div>

<p>Finally, upon confirmation of the message, a callback may also be defined:</p>

<div class="highlight">
<pre>var cb = function() {
        // DO SOMETHING
};
mwf.messages.modal({
        text: "A not-padded confirm message with call back",
        type: "confirm",
        callback: cb
});    }</pre>
</div>

</div>