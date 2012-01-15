<?php
/**
 *
 * @package mwf.demos
 *
 * @author ilin
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111114
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Content_Full_Site_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/lib/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/config.php');


echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('Forms UI Demo')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Forms UI Demo')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Forms UI Demo')
        ->add_paragraph('The following is a demo of MWF Forms UI.')
        ->render();
?>

<!-- short form -->
<form action="#" method="post" class="short padded">
    <h1>Short Form</h1>
    <label for="input-1">Name</label>
    <input type="text" id="input-1" name="input-1" />
    <input type="submit" class="primary" value="Submit"/>
</form>

<!-- options -->
<form action="#" method="post" class="padded">
    <h1>Option Form</h1>
    <label>Checkbox</label>
    <div class="option">
        <input type="checkbox" id="checkbox-1" name="checkbox-1" />
        <label for="checkbox-1">One</label><br />
        <input type="checkbox" id="checkbox-2" name="checkbox-2" />
        <label for="checkbox-2">Two</label><br />
        <input type="checkbox" id="checkbox-3" name="checkbox-3" />
        <label for="checkbox-3">Three</label>
    </div>
    <label>Right Aligned Radio</label>
    <div class="option right">
        <label for="radio-1">One</label>
        <input type="radio" id="radio-1" name="radio-1" /><br />
        <label for="radio-2">Two</label>
        <input type="radio" id="radio-2" name="radio-2" /><br />
        <label for="radio-3">Three</label>
        <input type="radio" id="radio-3" name="radio-3" />
    </div>
    <label>Justify Aligned Radio</label>
    <div class="option justify">
        <label for="radio-4">One</label>
        <input type="radio" id="radio-4" name="radio-4" /><br />
        <label for="radio-5">Two</label>
        <input type="radio" id="radio-5" name="radio-5" /><br />
        <label for="radio-6">Three</label>
        <input type="radio" id="radio-6" name="radio-6" />
    </div>
</form>

<!-- button -->
<form class="padded" action="#" method="post">
    <h1>Full Button Form</h1>
    <input type="submit" value="Primary Button" class="primary" >
    <input type="submit" value="Secondary Button" class="secondary">
    <input type="reset" value="Neutral Button" class="neutral">
    <a href="#" class="button primary">Primary Link</a>
    <a href="#" class="button secondary">Secondary Link</a>
    <a href="#" class="button neutral">Neutral Link</a>
</form>

<!-- textarea -->
<form action="#" method="post" class="padded">
    <h1>Textarea Form</h1>
    <label for="textarea-1">Label for Text Area 1</label>
    <textarea id="textarea-1" name="textarea-1"></textarea>
</form>

<!-- select -->
<form action="#" method="post" class="padded">
    <h1>Select Form</h1>
    <label for="select-1">Label for Select 1</label>
    <select id="select-1" name="select-1">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
</form>

<!-- required -->
<form action="#" method="post" class="padded">
    <h1>Required Form</h1>
    <label for="input-10" class="required">Name</label>
    <input type="text" id="input-10" name="input-10" />
    <label class="required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-10" name="checkbox-10" />
        <label for="checkbox-10">One</label><br />
        <input type="checkbox" id="checkbox-11" name="checkbox-11" />
        <label for="checkbox-11">Two</label><br />
        <input type="checkbox" id="checkbox-12" name="checkbox-12" />
        <label for="checkbox-12">Three</label>
    </div>
    <label for="select-10" class="required">Status</label>
    <select id="select-10" name="select-10">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <label for="textarea-10" class="required">Comment</label>
    <textarea id="textarea-10" name="textarea-10"></textarea>
</form>

<!-- invalid -->
<form action="#" method="post" class="padded">
    <h1>Invalid Form</h1>
    <label for="input-11" class="invalid required">Name</label>
    <input type="text" id="input-11" name="input-11" class="invalid" />
    <p class="invalid">This field is required</p>
    <label class="invalid required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-13" name="checkbox-13" class="invalid" />
        <label for="checkbox-13" class="invalid">One</label><br />
        <input type="checkbox" id="checkbox-14" name="checkbox-14" class="invalid"/>
        <label for="checkbox-14"class="invalid">Two</label><br />
        <input type="checkbox" id="checkbox-15" name="checkbox-15" class="invalid"/>
        <label for="checkbox-15"class="invalid">Three</label>
    </div>
    <p class="invalid">This field is required</p>
    <label for="select-11" class="invalid required">Status</label>
    <select id="select-11" name="select-11" class="invalid">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <p class="invalid">This field is required</p>
    <label for="textarea-11" class="invalid required">Comment</label>
    <textarea id="textarea-11" name="textarea-11" class="invalid"></textarea>
    <p class="invalid">This field is required</p>
</form>

<!-- disabled -->
<form action="#" method="post" class="padded">
    <h1>Disabled Form</h1>
    <label for="input-12" class="required">Name</label>
    <input type="text" id="input-12" name="input-12" disabled="disabled"/>
    <label class="required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-10" name="checkbox-10" disabled="disabled"/>
        <label for="checkbox-16">One</label><br />
        <input type="checkbox" id="checkbox-11" name="checkbox-11" disabled="disabled"/>
        <label for="checkbox-17">Two</label><br />
        <input type="checkbox" id="checkbox-12" name="checkbox-12" disabled="disabled"/>
        <label for="checkbox-18">Three</label>
    </div>
    <label for="select-12" class="required">Status</label>
    <select id="select-10" name="select-10" disabled="disabled">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <label for="textarea-12" class="required">Comment</label>
    <textarea id="textarea-12" name="textarea-10" disabled="disabled"></textarea>
    <input type="submit" class="primary" value="Disabled" disabled="disabled">
    <input type="reset" class="secondary" value="Disabled" disabled="disabled">
    <a class="button disabled">Disabled</a>
</form>

<!-- not-padded -->
<form action="#" method="post">
    <h1 class="first">Not Padded Form</h1>
    <label for="input-99">Label 99</label>
    <input type="text" id="input-99" name="input-99">
    <input type="submit" value="Search" class="primary">
</form>

<!-- prototype 1 -->
<form class="padded" action="#" method="post">
    <h1 class="first">Prototype 1</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <fieldset>
        <p>One of multiple paragraphs defined within one content box (fieldset).</p>
        <p>Another of multiple paragraphs defined within one content box (fieldset).</p>
    </fieldset>
    <fieldset>
        <label for="input-100">Label for Input 100</label>
        <input type="text" id="input-100" name="input-100">
        <label for="textarea-100">Label for Textarea 100</label>
        <textarea id="textarea-100" name="textarea-100"></textarea>
        <label for="radio-100">Label for Radio 100</label>
        <input type="radio" id="radio-100" name="radio-100"><br />
        <label for="checkbox-100">Label for Checkbox 100</label>
        <input type="checkbox" id="checkbox-100" name="checkbox-100"><br />
        <label for="select-100">Label for Select 100</label>
        <select id="select-100" name="select-100">
            <option value="value-1">Value 1</option>
            <option value="value-2">Value 2</option>
            <option value="value-3">Value 3</option>
        </select>
    </fieldset>
    <h4>Subtitle</h4>
    <fieldset class="last">
        <p>Some text that comes before the submission.</p>
        <input type="submit" class="primary">
        <input type="reset">
    </fieldset>
</form>

<!-- prototype 2 -->
<div class="content padded">
    <h1 class="light">Prototype 2</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <form action="#" method="post">
        <h4>Subtitle</h4>
        <p>A content box with paragraph content.</p>
        <div>
            <p>One of multiple paragraphs defined within one content box (div).</p>
            <p>Another of multiple paragraphs defined within one content box (div).</p>
        </div>
        <fieldset>
            <p>One of multiple paragraphs defined within one content box (fieldset).</p>
            <p>Another of multiple paragraphs defined within one content box (fieldset).</p>
        </fieldset>
        <fieldset>
            <label for="input-101">Label for Input 101</label>
            <input type="text" id="input-101" name="input-101">
            <label for="textarea-101">Label for Textarea 101</label>
            <textarea id="textarea-101" name="textarea-101"></textarea>
        </fieldset>
        <div>
            <label for="radio-101">Label for Radio 101</label>
            <input type="radio" id="radio-101" name="radio-101"><br />
            <label for="checkbox-101">Label for Checkbox 101</label>
            <input type="checkbox" id="checkbox-101" name="checkbox-101"><br />
            <label for="select-101">Label for Select 101</label>
            <select id="select-101" name="select-1">
                <option value="value-1">Value 1</option>
                <option value="value-2">Value 2</option>
                <option value="value-3">Value 3</option>
            </select>
        </div>
        <h4>Subtitle</h4>
        <fieldset class="last">
            <p>Some text that comes before the submission.</p>
            <input type="submit" class="primary">
            <input type="reset">
        </fieldset>
    </form>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
</div>

<!-- prototype 3 -->
<div class="content padded">
    <h1 class="blue">Prototype 3</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <div>
        <form action="#" method="post">
            <p class="first">This and all the below form elements should be within one content box.</p>
            <fieldset>
                <label for="input-102">Label for Input 102</label>
                <input type="text" id="input-102" name="input-102">
                <label for="textarea-102">Label for Textarea 102</label>
                <textarea id="textarea-102" name="textarea-102"></textarea>
            </fieldset>
            <fieldset>
                <label for="radio-102">Label for Radio 102</label>
                <input type="radio" id="radio-102" name="radio-102"><br />
                <label for="checkbox-102">Label for Checkbox 102</label>
                <input type="checkbox" id="checkbox-102" name="checkbox-102"><br />
                <label for="select-102">Label for Select 102</label>
                <select id="select-102" name="select-102">
                    <option value="value-1">Value 1</option>
                    <option value="value-2">Value 2</option>
                    <option value="value-3">Value 3</option>
                </select>
            </fieldset>
            <p>Some text that comes before the submission.</p>
            <input type="submit" class="primary">
            <input type="reset" class="last">
        </form>
    </div>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
</div>

<?php
echo Site_Decorator::button()
        ->set_padded()
        ->add_option('Back to Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>