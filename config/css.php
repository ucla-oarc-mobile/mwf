<?php

/**
 * Configuration file for automatic loading of custom stylesheets in css.php.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20110510
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * custom
 *
 * A STRING for a single directory under assets/css that is loaded after the
 * assets/css/default sheets for each category, or an ARRAY loaded in array
 * order from the directories specified in the array under assets/css.
 * 
 * If this is array('1','2') for example, and the sheets assets/css/1/basic.css
 * and assets/css/2/basic.css exist, then css.php will load the sheets in the
 * order assets/css/default/basic.css, then assets/css/1/basic.css and then
 * assets/css/2/basic.css. FALSE specifies no additional directories of sheets
 * to load.
 */
Config::set('css', 'custom', false);
