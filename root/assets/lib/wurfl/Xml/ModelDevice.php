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
 * @package    WURFL_Xml
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
/**
 * Represents a device in the wurfl xml file
 *
 */
class WURFL_Xml_ModelDevice {

	
	private $id;
	private $fallBack;
	private $userAgent;
	private $actualDeviceRoot;
	private $specific;
	private $capabilities = array();
	private $groupIdCapabilitiesNameMap = array();
	
	
	function __construct($id, $userAgent, $fallBack, $actualDeviceRoot=false, $specific=false,
	$groupIdCapabilitiesMap = null) {
		
		$this->id = $id;
		$this->userAgent = $userAgent;
		$this->fallBack = $fallBack; 
		$this->actualDeviceRoot = $actualDeviceRoot == true ? true : false;
		$this->specific = $specific == true ? true : false;
		if (is_array($groupIdCapabilitiesMap)) {
			foreach ($groupIdCapabilitiesMap as $groupId => $capabilitiesNameValue) {
				$this->groupIdCapabilitiesNameMap[$groupId] = array_keys($capabilitiesNameValue); 
				$this->capabilities = array_merge($this->capabilities, $capabilitiesNameValue);
			}
			
		}
	}
 
	function __get($name) {
		return $this->$name;
	}


    function getCapabilities() {
        return $this->capabilities;
    }

    function getGroupIdCapabilitiesNameMap() {
        return $this->groupIdCapabilitiesNameMap;
    }
    

	function getCapability($capabilityName) {
		if(isset($this->capabilities[$capabilityName])) {
			return $this->capabilities[$capabilityName];
		}
		
		return NULL;
	}
	
	function isCapabilityDefined($capabilityName) {
		return array_key_exists($capabilityName, $this->capabilities);
	}
	
	function getGroupIdCapabilitiesMap() {
		$groupIdCapabilitiesMap = array();
		foreach ($this->groupIdCapabilitiesNameMap as $groupId => $capabilitiesName) {
			foreach ($capabilitiesName as $capabilityName) {
				$groupIdCapabilitiesMap[$groupId][$capabilityName] = $this->capabilities[$capabilityName];
			}
		}		
		return $groupIdCapabilitiesMap;
		
		
	}
	
	
	function isGroupDefined($groupId) {
		return array_key_exists($groupId, $this->groupIdCapabilitiesNameMap);
	}
	
	
}

