<?php

/**
 * Configuration file for preview mode functionality.
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
 * restrict_domain
 *
 * Because multiple institutions and domains may utilize the framework
 * but it does not always make sense to have a preview mode menu appear,
 * this configuration parameter lets a domain restriction be set. This
 * domain restriction should only be the hostname, not path or scheme.
 *
 * The PHP boolean false may be set to not restrict at all.
 *
 */
Config::set('preview', 'restrict_domain', false);
