<?php

/**
 * Configuration file for Google Analytics.
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
 * account  Account identifier for Google code (UA-######-##) or FALSE for no GA.
 */
Config::set('analytics', 'account', false);
