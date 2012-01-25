<?php
/**
 *
 * @package mwf.ext.full
 *
 * @author ilin
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110927
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
        ->add_js_handler_library('full_libs', 'messages')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Demo')
        ->render();

echo Site_Decorator::content_full()
        ->set_padded()
        ->add_header('MWF Message Demo')
        ->add_paragraph('The following is a demo of MWF Messages.')
        ->render();
?>

<!-- Messages -->
<div class="content padded">
    <h1 class="content-first">Content Messages</h1>
    <p>Inline message <span class="message alert">alert</span>, <span class="message confirm">confirm</span>, <span class="message error">error</span>, <span class="message info">info</span>.</p>
    <div>
        <div class="message full alert">This is an alert message</div>
        <div class="message full confirm">This is a confirm message</div>
        <div class="message full not-padded error">This is a not-padded error message</div>
        <div class="message full not-padded info">This is a not-padded info message</div>
    </div>
</div>

<div class="message full alert">This is an alert message</div>
<div class="message full confirm">This is a confirm message</div>
<div class="message full not-padded error">This is a not-padded error message</div>
<div class="message full not-padded info">This is a not-padded info message</div>

<div id="alert-msg" class="message full alert">This is an alert message from existing markup</div>

<?php
echo Site_Decorator::button_full()
        ->set_padded()
        ->add_option('Back To Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<script type="text/javascript">
    // an alert message from existing markup
    mwf.messages.modal({
        id: "alert-msg"
    });
    
    // a dynamic info message from dynamic markup
    mwf.messages.modal({
        text: "An dynamic info message",
        type: "info"
    });
    
    // a dynamic confirm message with callback
    cb = function() {
        alert("This is a call back function for confirm message.");
    }
    
    mwf.messages.modal({
        text: "A not-padded confirm message with call back",
        type: "confirm",
        padded: false,
        callback: cb
    });
</script>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>