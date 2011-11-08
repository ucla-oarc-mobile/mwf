<?php

/**
 * This file is responsible for doing just-in-time compression and conversion of
 * the specified image file and then outputting it as the binary content of this
 * file. This script can be included directly via <img>.
 *
 * @package core
 * @subpackage min
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111007
 *
 * @uses Device
 * @uses Screen
 * @uses Local_Image
 */
/**
 * If no img is provided, exit.
 */
if (!isset($_GET['img'])) {
    error_log('MWF Notice: Required URL parameter "img" not provided to ' . $_SERVER['PHP_SELF'], 0);
    exit(1);
}

/**
 * Require necessary libraries. 
 */
include_once(dirname(dirname(__FILE__)) . '/lib/screen.class.php');
include_once(dirname(dirname(__FILE__)) . '/lib/image.class.php');

/**
 * @var int maximum width the image should be as defined first by the browser
 *          width and then more specifically by URI parameters.
 */
$max_width = Screen::get_width() ? Screen::get_width() * Screen::get_pixel_ratio() : PHP_INT_MAX;

/**
 * @var int maximum height the image should be as defined first by the browser
 *          width and then more specifically by URI parameters.
 */
$max_height = Screen::get_height() ? Screen::get_height() * Screen::get_pixel_ratio() : PHP_INT_MAX;

/**
 * @var bool true if the image should be compressed based on width.
 */
$set_width = false;

/**
 * @var bool true if the image should be compressed based on height.
 */
$set_height = false;

/**
 * Defines $set_height true if a URI segment defining height is set and then
 * calculates the $max_height that the image should be based on the segment(s).
 *
 * @uses $_GET['browser_width_percent'] defines width as percentage of browser width
 * @uses $_GET['browser_width_force'] defines width as 100% of browser width at max
 * @uses $_GET['max_width'] defines  width by max pixels for the image
 */
if (isset($_GET['browser_width_percent']) || isset($_GET['browser_width_force']) || isset($_GET['max_width'])) {
    $set_width = true;
    if (isset($_GET['browser_width_percent']))
        $max_width = $max_width * $_GET['browser_width_percent'] / 100;
    if (isset($_GET['max_width']) && $_GET['max_width'] < $max_width)
        $max_width = $_GET['max_width'];
}

/**
 * Defines $set_height true if a URI segment defining height is set and then
 * calculates the $max_height that the image should be based on the segment(s).
 *
 * @uses $_GET['browser_height_percent']defines height as percentage of browser height
 * @uses $_GET['browser_height_force'] defines height as 100% of browser height at max
 * @uses $_GET['max_height'] defines height by max pixels for the image
 */
if (isset($_GET['browser_height_percent']) || isset($_GET['browser_height_force']) || isset($_GET['max_height'])) {
    $set_height = true;
    if (isset($_GET['browser_height_percent']))
        $max_height = $max_height * $_GET['browser_height_percent'] / 100;
    if (isset($_GET['max_height']) && $_GET['max_height'] < $max_height)
        $max_height = $_GET['max_height'];
}

/**
 * @var Local_Image work with a local version of the image specified in URI.
 */
$image = Image::factory($_GET['img']);

if (! $image) {
    error_log('MWF Notice: Image creation failed in ' . $_SERVER['PHP_SELF'] . '. Bad image path?: ' . $_GET['img'], 0);
    exit(1);
}

/** Force max width if $set_width is true. */
if ($set_width)
    $image->set_max_width($max_width);

/** For max height if $set_height is true. */
if ($set_height)
    $image->set_max_height($max_height);

/** Output the header so that browser treats it as an image rather than PHP file. */
header("Content-type: " . $image->get_mimetype());

/** Output the binary content of the image in its compressed state. */
echo $image->get_image_as_string();