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

$appicon_img = Config::get('global', 'appicon_img');
if(strpos($appicon_img, '://') === false && substr($appicon_img, 0, 2) != '//')
{
    if(isset($_SERVER['HTTP_X_FORWARDED_SERVER']))
        $appicon_img = '//'.$_SERVER['HTTP_X_FORWARDED_SERVER'].'/'.$appicon_img;
    elseif(isset($_SERVER['HTTP_HOST']))
        $appicon_img = '//'.$_SERVER['HTTP_HOST'].'/'.$appicon_img;
    elseif(substr($appicon_img, 0, 1) != '/')
        $appicon_img = '/'.$appicon_img;
}

echo 'document.write(\'<link rel="apple-touch-icon" href="'.$appicon_img.'">\');';
echo 'document.write(\'<link rel="apple-touch-icon-precomposed" href="'.$appicon_img.'">\');';

