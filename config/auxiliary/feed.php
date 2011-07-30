<?php

/**
 * Configuration file the auxiliary Feed API.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author nemerson
 * @version 20110727
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(dirname(__FILE__))).'/root/assets/lib/config.class.php');

/**
 * cache_path
 *
 * A server path that denotes the directory that should be used for
 * caching by the Feed auxiliary library.
 * 
 * DO NOT INCLUDE A TRAILING SLASH
 */
Config::set('auxiliary/feed', 'cache_path', '/var/mobile/cache/simplepie');
