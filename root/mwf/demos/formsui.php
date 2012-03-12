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

<?php
/* short form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_short()
        ->set_title('Short Form')
        ->add_text('text-1', 'Name')
        ->add_submit()
        ->render();

/* option form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Option Form')
        ->add_checkboxes('checkbox-group-1', 'Label for Checkbox',
                array(
                        array('id' => 'checkbox-1', 'label' => 'One', 'value' => 1),
                        array('id' => 'checkbox-2', 'label' => 'Two', 'value' => 2),
                        array('id' => 'checkbox-3', 'label' => 'Three', 'value' => 3)
                )
          )
        ->add_radios('radio-group-1', 'Label for Right Aligned Radio',
                array(
                        array('id' => 'radio-1', 'label' => 'One', 'value' => 1),
                        array('id' => 'radio-2', 'label' => 'Two', 'value' => 2),
                        array('id' => 'radio-3', 'label' => 'Three', 'value' => 3)
                ),
                array('align' => 'right')
          )
        ->add_radios('radio-group-2', 'Label for Justify Aligned Radio',
                array(
                        array('id' => 'radio-4', 'label' => 'One', 'value' => 1),
                        array('id' => 'radio-5', 'label' => 'Two', 'value' => 2),
                        array('id' => 'radio-6', 'label' => 'Three', 'value' => 3)
                ),
                array('align' => 'justify')
          )
        ->render();

/* full button form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Full Button Form')
        ->add_primary_button('Primary Button')
        ->add_secondary_button('Secondary Button')
        ->add_button('Neutral Button')
        ->add_primary_link_button('Primary Link')
        ->add_secondary_link_button('Secondary Link')
        ->add_link_button('Neutral Link')
        ->render();

/* textarea form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Textarea Form')
        ->add_textarea('textarea-1', 'Label for Textarea 1')
        ->render();

/* select form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Select Form')
        ->add_select('select-group-1', 'Label for Select',
                array(
                        array('label' => 'One', 'value' => 1),
                        array('label' => 'Two', 'value' => 2),
                        array('label' => 'Three', 'value' => 3)
                )
          )
        ->render();

/* required form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Required Form')
        ->add_text('text-10', 'Name', array('required' => true))
        ->add_checkboxes('checkbox-group-10', 'Checkbox',
                array(
                        array('id' => 'checkbox-11', 'label' => 'One', 'value' => 1),
                        array('id' => 'checkbox-12', 'label' => 'Two', 'value' => 2),
                        array('id' => 'checkbox-13', 'label' => 'Three', 'value' => 3)
                ),
                array('required' => true)
          )
        ->add_select('select-group-10', 'Select',
                array(
                        array('label' => 'One', 'value' => 1),
                        array('label' => 'Two', 'value' => 2),
                        array('label' => 'Three', 'value' => 3)
                ),
                array('required' => true)
          )
        ->add_textarea('textarea-10', 'Textarea', array('required' => true))
        ->render();

/* invalid form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Invalid Form')
        ->add_text('text-20', 'Name', array('required' => true, 'invalid' => 'Error messager goes here'))
        ->add_checkboxes('checkbox-group-20', 'Checkbox',
                array(
                        array('id' => 'checkbox-21', 'label' => 'One', 'value' => 1),
                        array('id' => 'checkbox-22', 'label' => 'Two', 'value' => 2),
                        array('id' => 'checkbox-23', 'label' => 'Three', 'value' => 3)
                ),
                array('required' => true, 'invalid' => 'Error messager goes here')
          )
        ->add_select('select-group-20', 'Select',
                array(
                        array('label' => 'One', 'value' => 1),
                        array('label' => 'Two', 'value' => 2),
                        array('label' => 'Three', 'value' => 3)
                ),
                array('required' => true, 'invalid' => 'Error messager goes here')
          )
        ->add_textarea('textarea-20', 'Textarea', array('required' => true, 'invalid' => 'Error messager goes here'))
        ->render();

/* disabled form */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Disabled Form')
        ->add_text('text-30', 'Name', array('disabled' => true))
        ->add_checkboxes('checkbox-group-30', 'Checkbox',
                array(
                        array('id' => 'checkbox-31', 'label' => 'One', 'value' => 1),
                        array('id' => 'checkbox-32', 'label' => 'Two', 'value' => 2),
                        array('id' => 'checkbox-33', 'label' => 'Three', 'value' => 3)
                ),
                array('disabled' => true)
          )
        ->add_select('select-group-30', 'Select',
                array(
                        array('label' => 'One', 'value' => 1),
                        array('label' => 'Two', 'value' => 2),
                        array('label' => 'Three', 'value' => 3)
                ),
                array('disabled' => true)
          )
        ->add_textarea('textarea-30', 'Textarea', array('disabled' => true))
        ->render();

/* not padded form */
echo Site_Decorator::form()
        ->set_title('Not Padded Form')
        ->add_text('text-100', 'Label')
        ->add_submit('Search')
        ->render();


/* prototype 0 */
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Prototype 0')
        ->add_subtitle('Subtitle')
        ->add_paragraph('A content bo with paragraph content')
        ->add_section('<p>One of multiple paragraphs defined within one content box(div).</p><p>Another of multiple paragraphs defined within one content box(div).</p>')
        ->add_fieldset('<p>One of multiple paragraphs defined within one content box(fieldset).</p><p>Another of multiple paragraphs defined within one content box(fieldset).</p>')
        ->add_submit('Submit')
        ->render();

?>

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