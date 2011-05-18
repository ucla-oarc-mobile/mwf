<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 *
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Context {
	
	private $persistenceProvider;
	private $cacheProvider;
	private $logger;
	
	public function __construct($persistenceProvider, $caheProvider = null, $logger = null) {
		$this->persistenceProvider = $persistenceProvider;
		$this->cacheProvider = is_null($caheProvider) ? new WURFL_Cache_NullCacheProvider() : $caheProvider;
		$this->logger = is_null($logger) ? new WURFL_Logger_NullLogger() : $logger;
	}
	
	public function cacheProvider($cacheProvider) {
		return new WURFL_Context ( $this->persistenceProvider, $cacheProvider, $this->logger );
	}
	
	public function logger($logger) {
		return new WURFL_Context ( $this->persistenceProvider, $this->cacheProvider, $logger );
	}
	
	public function __get($name) {
		return $this->$name;
	}

}