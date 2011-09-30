<?php

/**
 * Configuration file the image compressor.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20110511
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * image_cache_dir
 *
 * Name of the directory where compressed images will be saved. This is set up
 * when the install script is run, but it may be changed to make the image
 * compression script cache images in a different directory.
 *
 * The directory must be writable by the web server process or caching will
 * not occur.
 */

Config::set('image', 'cache_dir', '/var/mobile/cache/img/');
