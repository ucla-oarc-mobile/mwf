<?php
/**
 *
 * @package mwf
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110519
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
require_once(dirname(dirname(__FILE__)) . '/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)) . '/assets/config.php');


echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('MWF Demos')
        ->add_js_handler_library('full_libs', 'messages')
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Demo')
        ->render();

echo Site_Decorator::content_full()
        ->set_padded()
        ->add_header('MWF Demo')
        ->add_paragraph('The following is a kitchen sink collection of MWF styles.')
        ->render();
?>

<!-- Messages -->
<div class="content-full content-padded">
    <h1 class="content-first">Messages</h1>
    <p>Inline message <span class="message-alert">alert</span>, <span class="message-confirm">confirm</span>, <span class="message-error">error</span>, <span class="message-info">info</span>.</p>
    <div>
        <div class="message-full message-alert">This is an alert message</div>
        <div class="message-full message-confirm">This is a confirm message</div>
        <div class="message-full message-error">This is an error message</div>
        <div class="message-full message-info">This is an info message</div>
    </div>
</div>

<div class="message-full message-padded message-alert">This is an alert message</div>
<div class="message-full message-padded message-confirm">This is a confirm message</div>
<div class="message-full message-padded message-error">This is an error message</div>
<div class="message-full message-padded message-info">This is an info message</div>

<?php
echo Site_Decorator::button_full()
        ->set_padded()
        ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
        ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>