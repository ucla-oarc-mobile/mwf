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
 * 
 */
class WURFL_DeviceRepositoryBuilder {
	
	private $persistenceProvider;
	private $userAgentHandlerChain;
	private $devicePatcher;

	private $lockFile;
	
	public function __construct($persistenceProvider, $userAgentHandlerChain, $devicePatcher) {
		$this->persistenceProvider = $persistenceProvider;
		$this->userAgentHandlerChain = $userAgentHandlerChain;
		$this->devicePatcher = $devicePatcher;
		$this->lockFile = dirname(__FILE__) . "/" . "DeviceRepositoryBuilder.php";
	}
	
	public function build($wurflFile, $wurflPatches = array(), $capabilitiesToUse = array()) {
		if (! $this->isRepositoryBuilt ()) {
			$fp = fopen($this->lockFile, "r");
			if (flock($fp, LOCK_EX) && !$this->isRepositoryBuilt()) {
				$infoIterator = new WURFL_Xml_VersionIterator ( $wurflFile );
				$deviceIterator = new WURFL_Xml_DeviceIterator ( $wurflFile, $capabilitiesToUse);
				$patchIterators = $this->toPatchIterators ( $wurflPatches , $capabilitiesToUse);
			
				$this->buildRepository ( $infoIterator, $deviceIterator, $patchIterators );
				$this->setRepositoryBuilt ();	
				flock($fp, LOCK_UN);			
			}
		}
		$deviceClassificationNames = $this->deviceClassificationNames ();
		return new WURFL_CustomDeviceRepository ( $this->persistenceProvider, $deviceClassificationNames );
	}
	
	private function buildRepository($wurflInfoIterator, $deviceIterator, $patchDeviceIterators = NULL) {
		$this->persistWurflInfo ( $wurflInfoIterator );
		$patchingDevices = array ();
		$patchingDevices = $this->toListOfPatchingDevices ( $patchDeviceIterators );		
		try {
			$this->process ( $deviceIterator, $patchingDevices );
		} catch ( Exception $exception ) {
			$this->clean ();
			throw new Exception ( "Problem Building WURFL Repository " . $exception );
		}
	}
	
	private function toPatchIterators($wurflPatches, $capabilitiesToUse) {
		$patchIterators = array ();	
		if (is_array ( $wurflPatches )) {
			foreach ( $wurflPatches as $wurflPatch ) {
				$patchIterators [] = new WURFL_Xml_DeviceIterator ( $wurflPatch, $capabilitiesToUse );
			}
		}
		return $patchIterators;
	}
	
	private function isRepositoryBuilt() {
		return $this->persistenceProvider->isWURFLLoaded ();
	}
	
	private function setRepositoryBuilt() {
		$this->persistenceProvider->setWURFLLoaded ();
	}
	
	private function deviceClassificationNames() {
		$deviceClusterNames = array ();
		foreach ( $this->userAgentHandlerChain->getHandlers () as $userAgentHandler ) {
			$deviceClusterNames [] = $userAgentHandler->getPrefix ();
		}
		return $deviceClusterNames;
	}
	
	private function clean() {
		$this->persistenceProvider->clear ();
	}
	
	private function persistWurflInfo($wurflInfoIterator) {
		foreach ( $wurflInfoIterator as $info ) {
			$this->persistenceProvider->save ( WURFL_Xml_Info::PERSISTENCE_KEY, $info );
		}
	}
	
	private function process($deviceIterator, $patchingDevices) {
		$usedPatchingDeviceIds = array ();
		foreach ( $deviceIterator as $device ) {
			$toPatch = isset ( $patchingDevices [$device->id] );
			if ($toPatch) {
				$device = $this->patchDevice ( $device, $patchingDevices [$device->id] );
				$usedPatchingDeviceIds [$device->id] = $device->id;
			}
			$this->classifyAndPersistDevice ( $device );
		}
		$this->classifyAndPersistNewDevices ( array_diff_key ( $patchingDevices, $usedPatchingDeviceIds ) );
		$this->persistClassifiedDevicesUserAgentMap ();
	}
	
	private function classifyAndPersistNewDevices($newDevices) {
		foreach ( $newDevices as $newDevice ) {
			$this->classifyAndPersistDevice ( $newDevice );
		}
	}
	
	private function classifyAndPersistDevice($device) {
		$this->userAgentHandlerChain->filter ( $device->userAgent, $device->id );
		$this->persistenceProvider->save ( $device->id, $device );
	}
	
	private function persistClassifiedDevicesUserAgentMap() {
		$this->userAgentHandlerChain->persistData ();
	}
	
	private function patchDevice($device, $patchingDevice) {
		return $this->devicePatcher->patch ( $device, $patchingDevice );
	}
	
	private function toListOfPatchingDevices($patchingDeviceIterators) {
		$currentPatchingDevices = array ();
		if (is_null ( $patchingDeviceIterators )) {
			return $currentPatchingDevices;
		}
		foreach ( $patchingDeviceIterators as $deviceIterator ) {
			$newPatchingDevices = $this->toArray ( $deviceIterator );
			$this->patchDevices ( $currentPatchingDevices, $newPatchingDevices );
		}
		return $currentPatchingDevices;
	}
	
	private function patchDevices(&$currentPatchingDevices, $newPatchingDevices) {
		foreach ( $newPatchingDevices as $deviceId => $newPatchingDevice ) {
			if (isset ( $currentPatchingDevices [$deviceId] )) {
				$currentPatchingDevices [$deviceId] = $this->patchDevice ( $currentPatchingDevices [$deviceId], $newPatchingDevice );
			} else {
				$currentPatchingDevices [$deviceId] = $newPatchingDevice;
			}
		}
	}
	
	private function toArray($deviceIterator) {
		$patchingDevices = array ();
		foreach ( $deviceIterator as $device ) {
			$patchingDevices [$device->id] = $device;
		}
		return $patchingDevices;
	}

}
