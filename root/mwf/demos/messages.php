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
        ->set_title('Messages Demo')
        ->add_js_handler_library('standard_libs', 'messages')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Messages Demo')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Messages Demo')
        ->add_paragraph('The following is a demo of MWF Messages.')
        ->render();

//@todo Create a clean easy-to-use Decorator for Alerts API.
echo Site_Decorator::content()
        ->add_header('Content Messages')
        ->add_paragraph(
                array(
                    'Inline message ',
                    HTML_Decorator::tag('span', 'alert', array('class' => 'message alert')),
                    ', ',
                    HTML_Decorator::tag('span', 'confirm', array('class' => 'message confirm')),
                    ', ',
                    HTML_Decorator::tag('span', 'error', array('class' => 'message error')),
                    ', ',
                    HTML_Decorator::tag('span', 'info', array('class' => 'message info')),
                    '.'))
        ->add_section(
                array(
                    HTML_Decorator::tag('div', 'This is an alert message inside a content', array('class' => 'message alert')),
                    HTML_Decorator::tag('div', 'This is an confirm message inside a content', array('class' => 'message confirm')),
                    HTML_Decorator::tag('div', 'This is an error message inside a content', array('class' => 'message error')),
                    HTML_Decorator::tag('div', 'This is an info message inside a content', array('class' => 'message info')) ))
        ->render();

echo HTML_Decorator::tag('div', 'This is a padded alert message', array('class'=>'message alert'))->render();
echo HTML_Decorator::tag('div', 'This is a padded confirm message', array('class'=>'message confirm'))->render();
echo HTML_Decorator::tag('div', 'This is not a padded error message', array('class'=>'message error not-padded'))->render();
echo HTML_Decorator::tag('div', 'This is not a padded info message', array('class'=>'message info not-padded'))->render();

echo HTML_Decorator::tag('div', 'This is an alert message from existing markup', array('id'=>'alert-msg','class'=>'message alert'))->render();


echo Site_Decorator::button()
        ->add_option('Back To Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<script type="text/javascript">
    if (mwf.classification.isFull()) {
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
    }
</script>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>