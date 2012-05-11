<?php

/**
 * The front page when the user arrives at the mobile site on a mobile device.
 * If the user is on a non-mobile device and 
 * Config::get('global','site_nonmobile_url') is set, then they will be 
 * redirected.
 *
 * @package frontpage
 *
 * @author ebollens
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120312
 *
 * @uses Config
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Menu_Full_Site_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 * @uses User_Agent
 * @uses Classification
 * 
 * @link assets/redirect/unset_override.php
 */
require_once(dirname(__FILE__) . '/assets/config.php');
require_once(dirname(__FILE__) . '/assets/lib/decorator.class.php');
require_once(dirname(__FILE__) . '/assets/redirect/unset_override.php');
require_once(dirname(__FILE__) . '/assets/lib/user_agent.class.php');
require_once(dirname(__FILE__) . '/assets/lib/classification.class.php');

/**
 * Handle differences between a subsection and the top-level menu, using key
 * 'default' if on the front page or otherwise the $_GET['s'] parameter.
 */
$menu_section = isset($_GET['s']) ? $_GET['s'] : 'default';

$menu_names = Config::get('frontpage', 'menu.name.' . $menu_section);

if (!isset($menu_names)) {
    $menu_section = 'default';
    $menu_names = Config::get('frontpage', 'menu.name.' . $menu_section);
}

$menu_ids = Config::get('frontpage', 'menu.id.' . $menu_section);
$menu_urls = Config::get('frontpage', 'menu.url.' . $menu_section);
$menu_classes = Config::get('frontpage', 'menu.class.' . $menu_section);
$menu_externals = Config::get('frontpage', 'menu.external.' . $menu_section);

$main_menu = ($menu_section == 'default');

/**
 * Start page
 */
echo HTML_Decorator::html_start()->render();

$head = Site_Decorator::head()->set_title(Config::get('global', 'title_text'));
if ($main_menu && Config::get('frontpage', 'customizable_home_screen'))
    $head->add_js_handler_library('full_libs', 'customizableMenu');
echo $head->render();

echo HTML_Decorator::body_start($main_menu ? array('class' => 'front') : array())->render();

/*
 * Header
 */

//TODO: Use decorators rather than HTML
if ($main_menu)
    echo '<h1 id="header"><img src="' . Config::get('frontpage', 'header_image_main') . '" alt="' . Config::get('frontpage', 'header_image_main_alt') . '"><span>' . Config::get('frontpage', 'header_main_text') . '</span></h1>';
else
    echo Site_Decorator::header()->set_title(ucwords(str_replace('_', ' ', $_GET['s'])))->render();

/*
 * Menu
 */

$menu = Site_Decorator::menu()->set_padded()->set_detailed();

if ($main_menu)
    $menu->set_home_screen();

foreach ($menu_names as $key => $menu_name) {
    $list_item_attributes = array();
    if (isset($menu_classes[$key])) {
        $list_item_attributes['class'] = $menu_classes[$key];
    }
    if (isset($menu_ids[$key])) {
        $list_item_attributes['id'] = $menu_ids[$key];
    }

    $link_attributes = array();
    if (isset($menu_externals[$key])) {
        if ($menu_externals[$key])
            $link_attributes['rel'] = 'external';
    }

    $menu->add_item($menu_name, $menu_urls[$key], $list_item_attributes, $link_attributes, $key);
}

echo $menu->render();

/**
 * Back button
 */
if (!$main_menu)
    echo Site_Decorator::button()
            ->set_padded()
            ->add_option(Config::get('global', 'back_to_home_text'), 'index.php')
            ->render();

/**
 * Footer
 */
$footer = Site_Decorator::default_footer();
if ($main_menu && Classification::is_full() && Config::get('frontpage','customizable_home_screen'))
    $footer->add_footer_link('Customize Home Screen', "/customize_home_screen.php");
echo $footer->render();

/**
 * End page
 */
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
