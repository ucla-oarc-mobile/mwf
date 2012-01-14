<?php

/**
 * Configuration file that defines campus-specific configurations. This file
 * should be required to access the Config class. All config files are
 * populated through lazy inclusion and do not need to be directly included.
 *
 * @package core
 * @subpackage config
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20101021
 *
 * @uses Config
 */

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'config.class.php');

Config::set('global', 'site_url',                   '//' . $_SERVER['SERVER_ADDR'] . '/mwf');
Config::set('global', 'site_assets_url',            Config::get('global', 'site_url') . '/assets');

?>