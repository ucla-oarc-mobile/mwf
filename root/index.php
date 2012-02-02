<?php

/**
 * The front page when the user arrives at the mobile site on a mobile device.
 * If the user is on a non-mobile device and {'global':'site_nonmobile_url'} is
 * set in config/global.php, then they will be redirected.
 *
 * This page throws a fatal error if either {'global':'site_url'} or
 * {'global':'site_assets_url'} are not set in /config/global.php.
 *
 * @package frontpage
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110901
 *
 * @uses Config
 * @uses JS
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
 * 
 * @link /config/global.php
 * @link assets/redirect/unset_override.php
 */
/**
 * Require necessary libraries.
 */
require_once(dirname(__FILE__) . '/assets/config.php');
require_once(dirname(__FILE__) . '/assets/lib/decorator.class.php');
require_once(dirname(__FILE__) . '/assets/redirect/unset_override.php');

/**
 * Handle differences between a subsection and the top-level menu, using key
 * 'default' if on the front page or otherwise the $_GET['s'] parameter.
 */

$menu_section = 'default';
if (isset($_GET['s'])) {
    $menu_section = $_GET['s'];
} 

$menu_names = Config::get('frontpage', 'menu.name.'.$menu_section);

if (! isset($menu_names)) {
    $menu_section = 'default';
    $menu_names = Config::get('frontpage', 'menu.name.'.$menu_section);
}

$menu_ids = Config::get('frontpage', 'menu.id.'.$menu_section);
$menu_urls = Config::get('frontpage', 'menu.url.'.$menu_section);
$menu_restrictions = Config::get('frontpage', 'menu.restriction.'.$menu_section);
$menu_externals = Config::get('frontpage', 'menu.external.'.$menu_section);

$main_menu = ($menu_section == 'default');
/**
 * Start page
 */

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title(Config::get('global', 'title_text'))->render();

echo HTML_Decorator::body_start($main_menu ? array('class'=>'front') : array())->render();

/*
 * Header
 */

if($main_menu)
    echo '<h1 id="header"><img src="'.Config::get('frontpage', 'header_image_main').'" alt="'.Config::get('frontpage', 'header_image_main_alt').'"><span>'.Config::get('frontpage', 'header_main_text').'</span></h1>';
else
    echo Site_Decorator::header()->set_title(ucwords(str_replace('_', ' ', $_GET['s'])))->render();

/*
 * Menu
 */

$menu = Site_Decorator::menu()->set_padded()->set_detailed();

if($main_menu)
    $menu->add_class('front');

for($i = 0; $i < count($menu_names); $i++)
{
    if (isset($menu_restrictions[$i])) {
        $function = $menu_restrictions[$i];
        if (!User_Agent::$function())
            continue;
    }
    $link_attributes=array();
    if (isset($menu_externals[$i])) {
        if ($menu_externals[$i]) 
            $link_attributes['rel']='external';
    }
    $list_item_attributes=array();
    if (isset($menu_ids[$i]))
        $list_item_attributes['id']=$menu_ids[$i];

    $menu->add_item($menu_names[$i], $menu_urls[$i], $list_item_attributes,$link_attributes);
}

echo $menu->render();

/**
 * Back button
 */
if(!$main_menu)
    echo Site_Decorator::button()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), 'index.php')
                ->render();

/**
 * Footer
 */

echo Site_Decorator::default_footer()->render();

/**
 * End page
 */
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
