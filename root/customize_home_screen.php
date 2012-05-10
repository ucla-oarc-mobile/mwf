<?php

/**
 * 
 * @package mwf
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120314
 *
 * @uses Config
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Form_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 * @uses Classification
 */
require_once(__DIR__ . '/assets/config.php');
require_once(__DIR__ . '/assets/lib/decorator.class.php');
require_once(__DIR__ . '/assets/lib/classification.class.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title('Customize Home Screen')
        ->add_js_handler_library('full_libs', 'customizableMenu')
        ->add_js_handler_library('full_libs', 'jquery_ui_touch_punch')
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Customize Home Screen')
        ->render();

if (Classification::is_full()) {
    $js = "var cm = mwf.full.customizableMenu('home_screen_layout');";

    $apps = Config::get('frontpage', 'menu.name.default');
    $ids = Config::get('frontpage', 'menu.id.default');
    foreach ($apps as $key => $value) {
        if (!array_key_exists($key, $ids))
            continue;

        $this_id = htmlspecialchars($ids[$key]);
        $encoded_key = json_encode($key);
        $enabled_markup = '<label data-id="' . $encoded_key . '"><input id="' . $this_id . '" type="checkbox" checked>&nbsp;' .
                htmlspecialchars($apps[$key]) .
                '<span class="draggable-handle"></span></label>';
        $disabled_markup= '<label data-id="' . $encoded_key . '"><input id="' . $this_id . '" type="checkbox">&nbsp;' .
                htmlspecialchars($apps[$key]) .
                '<span class="draggable-handle"></span></label>';
        $js .= 'cm.addItem(' . json_encode($key) . ',' . json_encode($enabled_markup) . ',' . json_encode($disabled_markup) . ');';

    }

    echo Site_Decorator::form('Customize Home Screen')
            ->set_padded()
            ->add_paragraph('Drag menu items to desired order. Use checkboxes to remove items.')
            ->add_inner_tag('div', '', array('class' => 'option', 'id' => 'app_order'))
            ->render();

    echo Site_Decorator::button()
            ->set_padded()
            ->add_option('Save', '#', array('onclick' => 'saveMenu(); renderMenu(); return false'))
            ->add_option('Cancel', '#', array('onclick' => 'renderMenu(); return false'))
            ->render();

    echo Site_Decorator::button()
            ->set_padded()
            ->add_option('Reset To Default', '#', array('onclick' => 'cm.reset(); renderMenu(); return false'))
            ->render();

    echo HTML_Decorator::tag('script')
            ->add_inner($js .
                    "function saveMenu()" .
                    "{cm.reset();\$('#app_order').children().each(" .
                    "  function(index,element) {cm.setItemPosition(element.getAttribute('data-id'),index+1);" .
                    "cm.enableItem(element.getAttribute('data-id'),this.querySelector('[type=checkbox]').checked)})}" .
                    "function renderMenu()" .
                    "{cm.render('app_order')}" .
                    "renderMenu();" .
                    '$(function() { $( "#app_order" ).sortable({handle:".draggable-handle"}); $( "#app_order" ).disableSelection();});')
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