<style>
    .screenshot {
        border: #ddd thin solid;
    }
</style>

<h1 id="header">Forms</h1>

<div class="content">

    <h2>Description</h2>
    
    <p>The <code>form</code> entity and its variations construct a distinct form area for a set of label and input elements that spans the full width of a page.</p>

    <h2>Intent</h2>
    
    <p>This entity can be employed by any module to create a form.  Most commonly, it will contain a <code>h1</code> header and sets of <code>label</code> and <code>input</code> pairs.  This is an example of a simple form.</p>
    
    <pre class="highlight">
&lt;form&gt;
    &lt;h1&gt;Form Title&lt;/h1&gt;
    &lt;label&gt;
        &lt;span&gt;Label Text&lt;/span&gt;
        &lt;input type="text" name="text-input" /&gt;
    &lt;/label&gt;
    &lt;input class="primary" type="submit" value="Button Text"/&gt;
&lt;/form&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form.png'); ?>" alt="A simple form"></p>
    
    <h2>Setup</h2>
    
    <p>Use the JavaScript handler to import formsPolyfills for browsers that support it.</p>
    
    <pre class="highlight">
&lt;script src="//{MOBILE_DOMAIN}/assets/js.php?full_libs=formsPolyfills" type="text/javascript"&gt;</pre>

    <h2>Text Input</h2>
    
    <p>Your typical text input will have the following code.</p>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;input type="text" name="text-input" /&gt;
&lt;/label&gt;</pre>
    
    <p>You can specify placeholder text by using <code>placeholder="Enter text here"</code>.</p>
    
    <pre class="highlight">
&lt;input type="text" name="text-input" placeholder="Please enter text here" /&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-placeholder.png'); ?>" alt="Input text with placeholder text"></p>

    <p>You may use input types from HTML5 such as <code>color</code>, <code>search</code>, <code>number</code>, <code>range</code>, <code>tel</code>, <code>url</code>, <code>email</code> and <code>date</code>.  The input shall be rendered appropriately by supported browsers.</p>

    <h2>Form elements</h2>
    
    <p>The following sections describes how to implement various form elements in MWF.</p>
    
    <h3>Textarea Input</h3>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;textarea name="textarea-input"&gt;&lt;/textarea&gt;
&lt;/label&gt;</pre>

    <h3>Option Input</h3>
    
    <p>Check boxes can be used the following way.</p>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;div class="option"&gt;
        &lt;label&gt;
            &lt;input type="checkbox" value="1" name="checkbox-input" /&gt;One
        &lt;/label&gt;
        &lt;label&gt;
            &lt;input type="checkbox" value="2" name="checkbox-input" /&gt;Two
        &lt;/label&gt;
        &lt;label&gt;
            &lt;input type="checkbox" value="3" name="checkbox-input" /&gt;Three
        &lt;/label&gt;
    &lt;/div&gt;
&lt;/label&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-checkboxes.png'); ?>" alt="Input checkboxes"></p>
    
    <p>Radio buttons is used the same way.</p>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;div class="option"&gt;
        &lt;label&gt;
            &lt;input type="radio" value="1" name="radio-input" /&gt;One
        &lt;/label&gt;
        &lt;label&gt;
            &lt;input type="radio" value="2" name="radio-input" /&gt;Two
        &lt;/label&gt;
        &lt;label&gt;
            &lt;input type="radio" value="3" name="radio-input" /&gt;Three
        &lt;/label&gt;
    &lt;/div&gt;
&lt;/label&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-radiobuttons.png'); ?>" alt="Input radiobuttons"></p>

    <h3>Select Input</h3>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;select name="select-input"&gt;
        &lt;option value="1"&gt;One&lt;/option&gt;
        &lt;option value="2"&gt;Two&lt;/option&gt;
        &lt;option value="3"&gt;Three&lt;/option&gt;
    &lt;/select&gt;
&lt;/label&gt;</pre>
    
    <h3>Required Input</h3>
    
    <p>Required input fields can use <code>required="required"</code> to provide extra visual cue and also client side validation if browser supports it.</p>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;input type="text" name="text-input" required="required" /&gt;
&lt;/label&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-required.png'); ?>" alt="Required input fields"></p>
    
    <h3>Form Button</h3>
    
    <p>MWF provides three types of form buttons:  Primary Action, Secondary Action and Neutral.</p>
    
    <pre class="highlight">
&lt;input class="primary" type="submit" value="Submit" /&gt;
&lt;input class="secondary" type="submit" value="Submit" /&gt;
&lt;input class="neutral" type="submit" value="Submit" /&gt;
&lt;a class="primary button" href="#"&gt;Submit&lt;/a&gt;
&lt;a class="secondary button" href="#"&gt;Submit&lt;/a&gt;
&lt;a class="nutral button" href="#"&gt;Submit&lt;/a&gt;
</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-button.png'); ?>" alt="Input form button"></p>
        
    <h3>Invalid Input</h3>
    
    <p>Invalid input fields can be highlighted by adding <code>invalid</code> class.  You can also supply messages to help user resolve the error.</p>
    
    <pre class="highlight">
&lt;label&gt;
    &lt;span&gt;Label Text&lt;/span&gt;
    &lt;input type="text" name="text-input" class="invalid" /&gt;
    &lt;span class="invalid&gt;Input error message here&lt;/span&gt;
&lt;/label&gt;</pre>
    
    <p><img class="screenshot" src="<?php echo URL::asset('images/form-invalid.png'); ?>" alt="Invalid input fields"></p>

</div>