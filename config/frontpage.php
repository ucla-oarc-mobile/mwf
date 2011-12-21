<?php

/**
 * Configuration file for the front page (index.php).
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20111012
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * full_site_url    URL of non-mobile site link on front page for mobile devices.
 * help_site_url    URL of the help site or FALSE if there is none.
 *
 * @link index.php
 */
Config::set('frontpage', 'full_site_url', Config::get('global', 'full_site_url'));
Config::set('frontpage', 'help_site_url', Config::get('global', 'help_site_url'));

/**
 * header_image_main
 * header_image_main_alt
 * header_image_sub
 * header_image_sub_alt
 * header_main_text
 */

Config::set('frontpage', 'header_image_main', Config::get('global', 'site_assets_url').'/img/mwf-header-front.gif');
Config::set('frontpage', 'header_image_main_alt', 'MWF');
Config::set('frontpage', 'header_image_sub_alt', 'MWF');
Config::set('frontpage', 'header_image_sub', Config::get('global', 'site_assets_url').'/img/mwf-header.gif');
Config::set('frontpage', 'header_main_text', 'UCLA Mobile Web Framework');


/**
 * menu
 *
 * The structure of the splash page menu which is a three-deep array.
 * First level array defines the page as requested by GET['s'] and if
 * GET['s'] is not set, it will default to the contained array with the
 * key 'default'.
 *
 * Within each top-level array is another array that contains an item
 * for each menu item in the particular section.
 *
 * Within each item array definition, the following fields are available:
 *
 *  - name :: the name that appears for the menu item
 *
 *  - id :: the CSS id assigned to the item (for specific styling like
 *              the icon image)
 *
 *  - url :: the URL that the item links to (relative to index.php)
 *
 *  - restriction :: a string that may be any of the functions in User_agent
 *              to restrict the item to only appear for some devices
 *
 * @link index.php
 */
Config::set('frontpage', 'menu',  
   array(
   'default'=>array(
        array('name'=>'About',
              'id'=>'about',
              'url'=>'mwf/about.php')
        ,array('name'=>'Device Telemetry',
               'id'=>'device',
               'url'=>'mwf/device.php')
        ,array('name'=>'Collaboration',
              'id'=>'showcase',
              'url'=>'index.php?s=collaboration')
        ,array('name'=>'License',
              'id'=>'license',
              'url'=>'mwf/license.php')
        ,array('name'=>'Credits',
              'id'=>'credits',
              'url'=>'mwf/credits.php')
        )
    ,'collaboration'=>array(
        array('name'=>'Home',
              'url'=>'http://mwf.ucla.edu'),
        array('name'=>'Repository',
              'url'=>'https://github.com/ucla/mwf'),
        array('name'=>'Documentation',
              'url'=>'https://github.com/ucla/mwf/wiki'),
        array('name'=>'Issue Tracker',
              'url'=>'https://jira.ats.ucla.edu:8443/')
        )
    )
);
