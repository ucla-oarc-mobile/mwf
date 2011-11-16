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
        ->set_title('MWF Demos')
        ->add_js_handler_library('full_libs', 'forms')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Demo')
        ->render();

echo Site_Decorator::content_full()
        ->set_padded()
        ->add_header('MWF Forms Demo')
        ->add_paragraph('The following is a demo of MWF Forms.')
        ->render();
?>

<!-- form.form -->
<form class="form" action="#" method="post">
    <h1>Short Form</h1>
    <label for="input-0">Name</label>
    <input type="text" id="input-0" name="input-0" />
    <input type="submit" value="Search" class="primary">
</form>

<!-- form.form-full -->
<form class="form full" action="#" method="post">
    <h1 class="light">Form</h1>
    <label for="input-1">Label for Input 1</label>
    <input type="text" id="input-1" name="input-1" />
    <label for="input-2" class="text-center">Label for Center Aligned Input 2</label>
    <input type="text" id="input-2" name="input-2" class="text-center" />
    <label for="input-3" class="text-right">Label for Right Aligned Input 3</label>
    <input type="text" id="input-3" name="input-3" class="text-right"/>
    <label for="textarea-1">Label for Textarea 1</label>
    <textarea id="textarea-1" name="textarea-1"></textarea>
    <fieldset>
        <legend>Radio Group</legend>
        <input type="radio" id="radio-1" name="radio-1" />
        <label for="radio-1">Label for Radio 1</label><br />
        <input type="radio" id="radio-2" name="radio-1" />
        <label for="radio-2">Label for Radio 2</label><br />
        <input type="radio" id="radio-3" name="radio-1" />
        <label for="radio-3">Label for Radio 3</label>
    </fieldset>
    <fieldset>
        <legend>Checkbox Group</legend>
        <input type="checkbox" id="checkbox-1" name="checkbox-1" />
        <label for="checkbox-1">Label for Checkbox 1</label><br />
        <input type="checkbox" id="checkbox-2" name="checkbox-1" />
        <label for="checkbox-2">Label for Checkbox 2</label><br />
        <input type="checkbox" id="checkbox-3" name="checkbox-1" />
        <label for="checkbox-3">Label for Checkbox 3</label>
    </fieldset>
    <label for="select-1">Label for Select 1</label>
    <select id="select-1" name="select-1">
        <option value="value-1">Value 1</option>
        <option value="value-2">Value 2</option>
        <option value="value-3">Value 3</option>
    </select>
    <input type="submit" value="Primary Action" class="primary" >
    <input type="submit" value="Secondary Action" class="secondary">
    <input type="reset" value="Neutral Action" class="neutral">
</form>

<?php
echo Site_Decorator::button_full()
        ->set_padded()
        ->add_option('Back to Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<script type="text/javascript">
</script>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>