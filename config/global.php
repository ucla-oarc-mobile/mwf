<?php

/**
 * Configuration file for globally-used settings.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20110511
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * PATHS
 * 
 * - site_url           URL of the mobile site home page in mwf.site.webroot().
 * - site_assets_url    URL of the assets folder in mwf.site.webassetroot().
 * - site_nonmobile_url URL to redirect non-mobile (or FALSE to not redirect).
 * - full_site_url      URL of non-mobile site link on front page for mobile devices.
 * - help_site_url      URL of the help site or FALSE if there is none.
 *
 * DO NOT INCLUDE A TRAILING SLASH
 */

Config::set('global', 'site_url', false);
Config::set('global', 'site_assets_url', false);
Config::set('global', 'site_nonmobile_url', false);
Config::set('global', 'full_site_url', false);
Config::set('global', 'help_site_url', false);

/**
 * CORE
 *
 * - cookie_prefix :: The prefix attached to all cookies that the framework writes.
 */

Config::set('global', 'cookie_prefix', 'mwf_');

/**
 * TEXT AND IMAGES
 *
 * - back_to_home_text      The text of a go back to home button.
 * - copyright_text         The footer copyright notice written by decorator.
 * - header_home_button     Full image path for the header home button image.
 * - header_home_button_alt Alternate text for the header home button image.
 * - title_text             Title written by decorator into the head
 */

Config::set('global', 'appicon_img',                Config::get('global', 'site_assets_url').'/img/mwf-appicon.png');
Config::set('global', 'appicon_img_precomposed',    Config::get('global', 'site_assets_url').'/img/mwf-appicon-precomposed.png');
Config::set('global', 'appicon_allow_disable_flag', true);
Config::set('global', 'back_to_home_text',          'Go Back to Home');
Config::set('global', 'copyright_text',             'University of California &copy; 2010 UC Regents');
Config::set('global', 'header_home_button',         Config::get('global', 'site_assets_url').'/img/mwf-header.gif');
Config::set('global', 'header_home_button_alt',     'MWF');
Config::set('global', 'title_text',                 'UCLA MWF');

/******************************************************************
 *
 * DEPRECATED SETTINGS
 *
 * Settings below this point are supported by the MWF in a deprecated
 * capacity only and should not be relied on by components or modules
 * as they will eventually be removed.
 *
 */

Config::set('global', 'header_image_sub_alt', 'MWF');
Config::set('global', 'header_image_sub', Config::get('global', 'site_assets_url').'/img/mwf-header.gif');
