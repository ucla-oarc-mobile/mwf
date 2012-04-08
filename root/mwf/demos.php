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

echo Site_Decorator::menu()
->set_title('MWF Demos')
->set_padded()
->add_text('The following is a kitchen sink collection of MWF styles.')
->add_item('Entities', 'demos/entities.php')
->add_item('Forms UI', './demos/formsui.php')
->add_item('Forms JS', './demos/formsjs.php')
->add_item('Messages', 'demos/messages.php');

echo Site_Decorator::button()
        ->set_padded()
        ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
        ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>