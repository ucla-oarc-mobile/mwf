<?php
/**
 *
 * @package mwf.demos
 *
 * @author ilin
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120322
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Content_Site_Decorator
 * @uses Form_Site_Decorator
 * @uses Input_Site_Decorator
 * @uses Button_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/assets/config.php');
require_once(dirname(dirname(__DIR__)) . '/assets/lib/decorator.class.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('Forms With Polyfills')
        ->add_js_handler_library('full_libs', 'formsPolyfills')
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Forms With Polyfills')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Forms With Polyfills')
        ->render();

require('forms_inc.php');

echo Site_Decorator::button()
        ->set_padded()
        ->add_option('Back to Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>