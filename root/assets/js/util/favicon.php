<?php

/**
 * Javascript file that defines the basic mwf object and libraries. This should
 * be included before any other JS scripts.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110331
 *
 * @uses Config
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');

/** Defines the file to be parsed as a Javascript file and sets a max cache life. */
if(!headers_sent()){
    header('Content-Type: text/javascript');
    header("Cache-Control: max-age=3600");
}

?>
document.write('<link rel="shortcut icon" href="<?php echo Config::get('global', 'site_url'); ?>/favicon.ico" />');