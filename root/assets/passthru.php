<?php

/**
 * This file is responsible for loading cookies from the device telemetry stack,
 * accepting a GET parameter "return" that redirects the user back to the page
 * from before.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111104
 *
 * @uses JS
 */

require_once(dirname(__FILE__).'/lib/js.class.php');

if($_GET['mode'] == 'standards')
    echo '<!DOCTYPE html>';

?><html><head></head><body><script type="text/javascript"><?php

        /**
         * Core Javascript libraries always included.
         */

        $core_filenames = array('vars.php', 
                      'base.js',
                      'modernizr.js', 
                      'capability.js', 
                      'browser.js',
                      'useragent.js',
                      'screen.js',
                      'classification.js', 
                      'util.js',
                      'override.js',
                      'server.js');

        /**
         * Include each core Javascript library.
         */

        foreach($core_filenames as $filename)
            JS::load('core/'.$filename);
        ?> window.location = '<?php echo $_GET['return'] ?>';</script></body></html>
