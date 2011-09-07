<?php

/**
 * Configuration file for mobile-specific settings.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20110902
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * SIZES
 * 
 * - max_width          Maximum width for mwf.classification.isMobile()
 * - max_height         Maximum height for mwf.classification.isMobile()
 *
 * DO NOT INCLUDE A TRAILING SLASH
 */

Config::set('mobile', 'max_width', null);
Config::set('mobile', 'max_height', null);
