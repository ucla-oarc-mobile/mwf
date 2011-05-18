<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');

echo 'document.write(\'<link rel="apple-touch-icon" href="'.Config::get('global', 'appicon_img').'">\');';
echo 'document.write(\'<link rel="apple-touch-icon-precomposed" href="'.Config::get('global', 'appicon_img_precomposed').'">\');';
