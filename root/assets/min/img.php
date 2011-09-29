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
 * @version 20110921
 *
 * @uses Device
 * @uses Browser
 * @uses Local_Image
 */

/**
 * If no img URL is provided, exit.
 */
if (! isset($_GET['img'])) {
    error_log('MWF Notice: Required URL parameter "img" not provided to ' . $_SERVER['PHP_SELF'], 0);
    exit(1);
}
    
/**
 * Require necessary libraries. 
 */
include_once(dirname(dirname(__FILE__)).'/lib/browser.class.php');
include_once(dirname(dirname(__FILE__)).'/lib/local_image.class.php');

/**
 * @var int maximum width the image should be as defined first by the browser
 *          width and then more specifically by URI parameters.
 */
$max_width = Browser::get_width();

/**
 * @var int maximum height the image should be as defined first by the browser
 *          width and then more specifically by URI parameters.
 */
$max_height = Browser::get_height();

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
if(isset($_GET['browser_width_percent']) || isset($_GET['browser_width_force']) || isset($_GET['max_width']))
{
	$set_width = true;
	if(isset($_GET['browser_width_percent']))
		$max_width = $max_width * $_GET['browser_width_percent'] / 100;
	if(isset($_GET['max_width']) && $_GET['max_width'] < $max_width)
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
if(isset($_GET['browser_height_percent']) || isset($_GET['browser_height_force']) || isset($_GET['max_height']))
{
	$set_height = true;
	if(isset($_GET['browser_height_percent']))
		$max_height = $max_height * $_GET['browser_height_percent'] / 100;
	if(isset($_GET['max_height']) && $_GET['max_height'] < $max_height)
		$max_height = $_GET['max_height'];
}

if(ini_get('allow_url_fopen') != 1 && (substr($_GET['img'], 0, 7) == 'http://' || substr($_GET['img'], 0, 8) == 'https://'))
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$_GET['img']);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $contents = curl_exec($ch);
    curl_close($ch);
   
    if(strlen(substr($_GET['img'], strrpos($_GET['img'], '.'))) > 4)
        die();
 
    $temp_path = Config::get('image', 'tmp_dir').'/'.md5($_GET['img']).'.'.substr($_GET['img'], strrpos($_GET['img'], '.'));
    $fh = fopen($temp_path, 'w');
    fwrite($fh, $contents);
    fclose($fh);
    $local_image_path = $temp_path; 
    $was_downloaded = true;
}
else
{
    $local_image_path = $_GET['img'];
}

/**
 * @var Local_Image work with a local version of the image specified in URI.
 */
$image = new Local_Image($local_image_path);

/** GIF, JPG, and JPEG are within XHTML MP 1.0 specification. */
$image->set_allowed_extension('gif');
$image->set_allowed_extension('jpeg');
$image->set_allowed_extension('jpg');
$image->set_allowed_extension('png');

/** Force max width if $set_width is true. */
if($set_width)
	$image->set_max_width($max_width);

/** For max height if $set_height is true. */
if($set_height)
	$image->set_max_height($max_height);

/** Output the header so that browser treats it as an image rather than PHP file. */
$image->output_header();

/** Output the binary content of the image in its compressed state. */
$image->output_image();

if(isset($was_downloaded))
    unlink($local_image_path);

