<?php

/**
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110429
 *
 * @uses Config
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

echo 'document.write(\'<link rel="apple-touch-icon" href="'.Config::get('global', 'appicon_img').'">\');';
echo 'document.write(\'<link rel="apple-touch-icon-precomposed" href="'.Config::get('global', 'appicon_img_precomposed').'">\');';
