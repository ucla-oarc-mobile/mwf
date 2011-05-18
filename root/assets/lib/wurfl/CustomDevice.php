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
class WURFL_CustomDevice {
	
	private $modelDevices;
	
	/**
	 * 
	 * @param array $modelDevices
	 * @throws InvalidArgumentException if the $modelDevice is not an arry of atleast one WURFL_Xml_ModelDevice
	 */
	public function __construct($modelDevices) {
		if (! is_array ( $modelDevices ) || count ( $modelDevices ) < 1) {
			throw new InvalidArgumentException ( "modelDevices must be an array of at least one ModelDevice." );
		}
		$this->modelDevices = $modelDevices;
	
	}
	
	/**
	 * Magic Method
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name) {
		if (isset ( $name )) {
			switch ($name) {
				case "id" :
				case "userAgent" :
				case "fallBack" :
				case "actualDeviceRoot" :
					return $this->modelDevices [0]->$name;
					break;
				default :
					throw new WURFL_WURFLException ( "the field " . $name . " is not defined" );
					break;
			}
		
		}
		
		throw new WURFL_WURFLException ( "the field " . $name . " is not defined" );
	}
	
	/**
	 * 
	 */
	public function isSpecific() {
		foreach ( $this->modelDevices as $modelDevice ) {
			if ($modelDevice->specific === true || $modelDevice->actualDeviceRoot === true) {
				return true;
			}
		}
		
		return false;
	}
	

	
	/**
	 * Returns the value of a given capability name
	 * for the current device
	 * 
	 * @param string $capability must be a valid capability name
	 * @return string
	 * @throws InvalidArgumentException if the value of the $capability name is empty 
	 * or is not defined in wurfl.
	 */
	public function getCapability($capabilityName) {
		if (empty ( $capabilityName )) {
			throw new InvalidArgumentException ( "capability name must not be empty" );
		}
		if(!$this->isCapabilityDefined($capabilityName)) {
			throw new InvalidArgumentException ( "no capability named [$capabilityName] is present in wurfl." );	
		}
		foreach ( $this->modelDevices as $modelDevice ) {
			$capabilityValue = $modelDevice->getCapability ( $capabilityName );
			if ($capabilityValue != null) {
				return $capabilityValue;
			}
		}
		return "";
		
	
	}
	
	private function isCapabilityDefined($capabilityName) {
		return $this->modelDevices[count($this->modelDevices)-1]->isCapabilityDefined($capabilityName);
	}
	
	/**
	 * Returns all the value of the capabilities of the
	 * current device 
	 *
	 */
	public function getAllCapabilities() {
		$capabilities = array ();
		foreach ( array_reverse ( $this->modelDevices ) as $modelDevice ) {
			$capabilities = array_merge ( $capabilities, $modelDevice->getCapabilities () );
		}
		return $capabilities;
	}
}

