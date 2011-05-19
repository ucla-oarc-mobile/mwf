<?php

/**
 * A library included by assets/js.php for desktops that contains information
 * that the preview.js file will use.
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
 * @link /assets/js.php
 * @link /assets/js/desktop/preview.js
 */

?>mwf.desktop.preview_util = new function() {
    this.restrict_domain =
<?php if(Config::get('preview', 'restrict_domain')) {
    echo "'".Config::get('preview', 'restrict_domain')."';";
} else {
    echo "'NULL';";
} ?>
}; 