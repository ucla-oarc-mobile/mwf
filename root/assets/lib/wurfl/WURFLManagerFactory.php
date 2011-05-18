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

/**
 * This Class is reponsable for creating a WURFLManager instance
 * by instantiating and wiring together all the neccessary
 * 
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_WURFLManagerFactory {
	
	const DEBUG = FALSE;
	const WURFL_LAST_MODIFICATION_TIME = "WURFL_LAST_MODIFICATION_TIME";
	
	private $wurflConfig;
	private $wurflManager;
	private $persistenceStorage;
	
	public function __construct($wurflConfig, $persistenceStorage=NULL) {
		$this->wurflConfig = $wurflConfig;
		$this->persistenceStorage = $persistenceStorage ? $persistenceStorage : self::persistenceStorage ( $this->wurflConfig->persistence );			
    }
	
	/**
	 * Creates a new WURFLManager Object
	 */
	public function create() {		
		if (! isset ( $this->wurflManager )) {
			$this->init ();		
		}		
		if ($this->hasToBeReloaded ()) {
			$this->reload ();
		}
		
		return $this->wurflManager;
	}
	
	
	private function reload() {
		$this->persistenceStorage->setWURFLLoaded ( FALSE );
		$this->invalidateCache ();
		$this->init ();
		$this->persistenceStorage->save ( self::WURFL_LAST_MODIFICATION_TIME, filemtime ( $this->wurflConfig->wurflFile ) );
	}
	
	public function hasToBeReloaded() {
		if (! $this->wurflConfig->allowReload) {
			return false;
		}
		$lastModificationTime = $this->persistenceStorage->load ( self::WURFL_LAST_MODIFICATION_TIME );
		$currentModificationTime = filemtime ( $this->wurflConfig->wurflFile );
		return $currentModificationTime > $lastModificationTime;
	}
	
	private function invalidateCache() {
		$cacheProvider = self::cacheProvider ( $this->wurflConfig->cache );
		$cacheProvider->clear ();
	}
	
	public function remove() {
		$this->persistenceStorage->clear ();
		$this->wurflManager = NULL;
	}
	
	private function init() {
		$cacheProvider = self::cacheProvider ( $this->wurflConfig->cache );
		$logger = null; //$this->logger($wurflConfig->logger);
		
		$context = new WURFL_Context ( $this->persistenceStorage );
		$context = $context->cacheProvider ( $cacheProvider )->logger ( $logger );
		
		$userAgentHandlerChain = WURFL_UserAgentHandlerChainFactory::createFrom ( $context );
		$deviceRepository = $this->deviceRepository ( $this->persistenceStorage, $userAgentHandlerChain );
		$wurflService = new WURFL_WURFLService ( $deviceRepository, $userAgentHandlerChain, $cacheProvider );
		
		$requestFactory = new WURFL_Request_GenericRequestFactory ( );
		
		$this->wurflManager = new WURFL_WURFLManager ( $wurflService, $requestFactory );
	}
	
	private static function persistenceStorage($persistenceConfig) {
		return WURFL_Storage_Factory::create( $persistenceConfig );
	}
	
	private static function cacheProvider($cacheConfig) {
		return WURFL_Storage_Factory::create ( $cacheConfig );
	}
	
	/**
	 * @param userAgentHandlerChain
	 */
	private function deviceRepository($persistenceStorage, $userAgentHandlerChain) {
		$devicePatcher = new WURFL_Xml_DevicePatcher ();
		$deviceRepositoryBuilder = new WURFL_DeviceRepositoryBuilder ( $persistenceStorage, $userAgentHandlerChain, $devicePatcher );
		
		return $deviceRepositoryBuilder->build ( $this->wurflConfig->wurflFile, $this->wurflConfig->wurflPatches );
	}
	
	

}

