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
interface WURFL_DeviceRepository {
	
	/**
	 * Return the WURFLInfo containing 
	 * 	- version
	 *  - lastupdated
	 */
	public function getWURFLInfo();
		
	public function getVersion();
	
	public function getLastUpdated();
	
	/**
	 * Returns a device for the given device Id
	 *
	 * @param string $deviceId
	 * @return WURFL_Device
	 * @throws WURFL_Exception if $deviceID is not defined in wurfl
	 * devices repository
	 */
	public function getDevice($deviceId);
	
	/**
	 * Return an array of all devices defined in the wurfl + patch files
	 * @return array
	 */
	public function getAllDevices();
	
	/**
	 * Returns an array of all the devices id
	 *
	 * @return array
	 */
	public function getAllDevicesID();
	
	
	/**
	 * Returns the Capability value for the given device id
	 * and capablility name
	 *
	 * @param string $deviceID
	 * @param string $capabilityName
	 * @return string
	 */
	public function getCapabilityForDevice($deviceId, $capabilityName);
	
	
	/**
	 * Returns an associative array of capabilityName => capabilityValue 
	 * for the given device 
	 * 
	 *
	 * @param string $deviceId
	 * @return array associative array of capabilityName, capabilityValue
	 */
	function getAllCapabilitiesForDevice($deviceId);
	
	/**
	 * Returns an array containing all devices from the root
	 * device to the device of the given id
	 *
	 * @param string $deviceId
	 * @return array
	 */
	public function getDeviceHierarchy($deviceId);
	
	
	/**
	 * Returns an array Of group IDs defined in wurfl
	 *
	 * @return array
	 */
	public function getListOfGroups();
	
	/**
	 * Returns an array of all capability names defined in
	 * the given group ID
	 *
	 * @param string $groupID
	 * @return array of capability names
	 */
	public function getCapabilitiesNameForGroup($groupID);
	
	/**
	 * Returns the group id in which the given capabiliy name
	 * belongs to
	 *
	 * @param string $capabilitity
	 * @return string
	 */
	public function getGroupIDForCapability($capability);

}

