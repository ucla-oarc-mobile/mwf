<?php

/**
 * 
 * @package mwf
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120220
 *
 * @uses Config
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 * @uses Classification
 */
require_once(dirname(__FILE__) . '/assets/config.php');
require_once(dirname(__FILE__) . '/assets/lib/decorator.class.php');
require_once(dirname(__FILE__) . '/assets/lib/classification.class.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title('Customize Home Screen')
        ->add_js_handler_library('full_libs', 'ConfigurableMenu')
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Customize Home Screen')
        ->render();

if (Classification::is_full()) {

    $apps = Config::get('frontpage', 'menu.name.default');
    $ids = Config::get('frontpage', 'menu.id.default');
    foreach ($apps as $key => $value) {
        if (!array_key_exists($key, $ids))
            continue;

        $this_id = htmlspecialchars($ids[$key]);
        $encoded_key = json_encode($key);
        $apps_rendered[$key] = '<div><input type="submit" onclick="cm.moveUp(' .
                $encoded_key . '); renderMenu(); return false" value="Up">' .
                '&nbsp;<input type="submit" onclick="cm.moveDown(' .
                $encoded_key . '); renderMenu(); return false" value="Down">' .
                '&nbsp;<input type="checkbox" onclick="cm.set(' .
                $encoded_key . ',this.checked); renderMenu()" id="'.$this_id.'" checked>&nbsp;<label for="' .
                $this_id .
                '">' .
                htmlspecialchars($apps[$key]) .
                '</label></div>';
        $disabled_apps_rendered[$key] = '<div><input type="submit" value="Up" disabled>' .
                '<input type="submit" value="Down" disabled>' .
                '<input type="checkbox" onclick="cm.set(' .
                $encoded_key . ',this.checked); renderMenu()" id="'.$this_id.'"><label for="' . $this_id . '">' .
                htmlspecialchars($apps[$key]) . '</label></div>';
    }

    $js = 'var apps=' . json_encode($apps_rendered) . ';var disabledApps=' . json_encode($disabled_apps_rendered) . ';';

    echo Site_Decorator::form(false, array('class'=>'short'))
            ->set_padded()
            ->set_title('Home Screen Customization')
            ->add_inner_tag('div', '', array('class' => 'option', 'id' => 'app_order'))
            ->render();

    echo HTML_Decorator::tag('script')
            ->add_inner($js .
                    "var cm = new mwf.full.ConfigurableMenu('homescreen_layout');".
                    "function renderMenu()".
                    "{cm.render('app_order',apps,disabledApps)}".
                    "renderMenu();")
            ->render();
} else {
    echo Site_Decorator::Content()
            ->set_padded()
            ->add_header('Home Screen Customization')
            ->add_paragraph('Device does not support customization.')
            ->render();
}

echo Site_Decorator::button()
        ->set_padded()
        ->add_option(Config::get('global', 'back_to_home_text'), 'index.php')
        ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();