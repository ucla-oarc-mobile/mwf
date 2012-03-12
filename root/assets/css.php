<?php
/**
 * This file is responsible for dynamically loading CSS for the client based on
 * user agent. This script outputs CSS and thus can be directly included via
 * <link>.
 *
 * This file should be included on all pages that use the mobile framework.
 *
 * @package core
 * @subpackage css
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120306
 *
 * @uses Classification
 * @uses CSS
 * @uses CSSMin
 * @uses Path
 * @uses Path_Validator
 * @uses User_Agent
 */
/**
 * Include necessary libraries.
 */
require_once(__DIR__ . '/lib/classification.class.php');
require_once(__DIR__ . '/lib/config.class.php');
require_once(__DIR__ . '/lib/cssmin.class.php');
require_once(__DIR__ . '/lib/path.class.php');
require_once(__DIR__ . '/lib/path_validator.class.php');
require_once(__DIR__ . '/lib/user_agent.class.php');

/**
 * Define classificaitons and whether or not they apply.
 */
$classifications = array(
    'basic' => Classification::is_basic(),
    'standard' => Classification::is_standard(),
    'full' => Classification::is_full()
);


/**
 * Defines the file to be parsed as a CSS file.
 */
header('Content-Type: text/css');

if (!Classification::init()) {
    header("Cache-Control: max-age=0");
}
?>/** Mobile Web Framework | http://mwf.ucla.edu */

<?php
/**
 * Get directory name for custom CSS from Config.
 *
 */
$custom = Config::get('css', 'custom');
$custom = $custom ? (array) $custom : array();

$load_compat = !isset($_GET['lean']);

/**
 * Load all basic.css stylesheets under the default and custom directories.
 */
foreach ($classifications as $classification => $is_classification) {
    if ($is_classification) {
        if ($load_compat) {
            require_once(__DIR__ . '/css/default/' . $classification . '-compat.css');
        }

        require_once(__DIR__ . '/css/default/' . $classification . '.css');

        if ($load_compat) {
            foreach ($custom as $dir) {
                if (file_exists(__DIR__ . '/css/' . $dir . '/' . $classification . '-compat.css')) {
                    include_once(__DIR__ . '/css/' . $dir . '/' . $classification . '-compat.css');
                }
            }
        }

        foreach ($custom as $dir) {
            if (file_exists(__DIR__ . '/css/' . $dir . '/' . $classification . '.css')) {
                include_once(__DIR__ . '/css/' . $dir . '/' . $classification . '.css');
            }
        }
    }
}

/**
 * Load URL-specified CSS files (minified) based on user agent.
 */
foreach ($classifications as $is_classification) {
    if ($is_classification && isset($_GET[$classification])) {
        foreach (explode(' ', $_GET[$classification]) as $file) {
            if (Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file)) {
                echo ' ' . CSSMin::minify($contents);
            }
        }
    }
}   