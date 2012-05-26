<?php

require_once(dirname(__FILE__).'/lib/template.php');
require_once(dirname(__FILE__).'/lib/url.php');

Template::init();

$page = isset($_GET['p']) ? $_GET['p'] : 'overview/introduction';
$path = dirname(__FILE__).'/content/'.$page.'.php';

if(!file_exists($path))
    $path = dirname(__FILE__).'/content/error/page_missing.php';

include($path);