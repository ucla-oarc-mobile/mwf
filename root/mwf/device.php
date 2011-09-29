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

require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/classification.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/user_agent.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/lib/screen.class.php');

function label($text)
{
    return '<div style="color:#777; font-weight:bold">'.$text.'</div>';
}

function bool2text($text)
{
    return $text ? 'true' : 'false';
}

function text2text($text)
{
    return $text ? $text : 'false';
}

function js2bool2text($function)
{
    return '<script type="text/javascript">
document.write('.$function.'() ? "true" : "false");
</script>';
}

function js2text($function)
{
    return '<script type="text/javascript">
var t;
if(t = '.$function.'())
    document.write(t);
else
    document.write("false");
</script>';
}

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title('MWF About')->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Device')
        ->render();

echo Site_Decorator::content_full()
            ->set_padded()
            ->add_header('The Framework')
            ->add_subheader('Server Info')
            ->add_section(label('User Agent').$_SERVER['HTTP_USER_AGENT'])
            ->add_section(label('IP Address').$_SERVER['REMOTE_ADDR'])
            ->add_subheader('JS Classification')
            ->add_section(label('mwf.classification.isMobile()').js2bool2text('mwf.classification.isMobile'))
            ->add_section(label('mwf.classification.isBasic()').js2bool2text('mwf.classification.isBasic'))
            ->add_section(label('mwf.classification.isStandard()').js2bool2text('mwf.classification.isStandard'))
            ->add_section(label('mwf.classification.isFull()').js2bool2text('mwf.classification.isFull'))
            ->add_section(label('mwf.classification.isOverride()').js2bool2text('mwf.classification.isOverride'))
            ->add_section(label('mwf.classification.isPreview()').js2bool2text('mwf.classification.isPreview'))
            ->add_subheader('PHP Classification')
            ->add_section(label('Classification::is_mobile()').bool2text(Classification::is_mobile()))
            ->add_section(label('Classification::is_basic()').bool2text(Classification::is_basic()))
            ->add_section(label('Classification::is_standard()').bool2text(Classification::is_standard()))
            ->add_section(label('Classification::is_full()').bool2text(Classification::is_full()))
            ->add_section(label('Classification::is_override()').bool2text(Classification::is_override()))
            ->add_section(label('Classification::is_preview()').bool2text(Classification::is_preview()))
            ->add_subheader('JS User Agent')
            ->add_section(label('mwf.userAgent.getOS()').js2text('mwf.userAgent.getOS'))
            ->add_section(label('mwf.userAgent.getOSVersion()').js2text('mwf.userAgent.getOSVersion'))
            ->add_section(label('mwf.userAgent.getBrowser()').js2text('mwf.userAgent.getBrowser'))
            ->add_section(label('mwf.userAgent.getBrowserEngine()').js2text('mwf.userAgent.getBrowserEngine'))
            ->add_section(label('mwf.userAgent.getBrowserEngineVersion()').js2text('mwf.userAgent.getBrowserEngineVersion'))
            ->add_subheader('PHP User Agent')
            ->add_section(label('User_Agent::get_os()').text2text(User_Agent::get_os()))
            ->add_section(label('User_Agent::get_os_version()').text2text(User_Agent::get_os_version()))
            ->add_section(label('User_Agent::get_browser()').text2text(User_Agent::get_browser()))
            ->add_section(label('User_Agent::get_browser_engine()').text2text(User_Agent::get_browser_engine()))
            ->add_section(label('User_Agent::get_browser_engine_version()').text2text(User_Agent::get_browser_engine_version()))
            ->add_subheader('JS Screen')
            ->add_section(label('mwf.screen.getHeight()').js2text('mwf.screen.getHeight'))
            ->add_section(label('mwf.screen.getWidth()').js2text('mwf.screen.getWidth'))
            ->add_section(label('mwf.screen.getPixelRatio()').js2text('mwf.screen.getPixelRatio'))
            ->add_subheader('PHP Screen')
            ->add_section(label('Screen::get_height()').text2text(Screen::get_height()))
            ->add_section(label('Screen::get_width()').text2text(Screen::get_width()))
            ->add_section(label('Screen::get_pixel_ratio()').text2text(Screen::get_pixel_ratio()))
            ->render();

echo Site_Decorator::button_full()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
                ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
