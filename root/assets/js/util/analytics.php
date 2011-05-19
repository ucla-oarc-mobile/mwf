<?php

/**
 * Javascript file that loads Google Analytics if an account is set in the
 * analytics config file (/assets/config/analytics.php). This requires DOM
 * write capabilities.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20101021
 *
 * @uses Config
 * @link /assets/config/analytics.php
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');

if(Config::get('analytics', 'account')){

?> var _gaq=_gaq||[];_gaq.push(["_setAccount","<?php echo Config::get('analytics', 'account'); ?>"]);_gaq.push(["_trackPageview"]);(function(){var b=document.createElement("script");b.type="text/javascript";b.async=true;b.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(b,a)})(); <?php

}

?>