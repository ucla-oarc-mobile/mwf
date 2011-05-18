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
 *
 */
class WURFL_Xml_DeviceIterator extends WURFL_Xml_AbstractIterator {
	
	private $capabilitiesToSelect = array ();
	private $filterCapabilities;
	
	function __construct($inputFile, $capabilities = array()) {
		parent::__construct ( $inputFile );
		foreach ( $capabilities as $groupId => $capabilityNames ) {
			$trimmedCapNames = $this->removeSpaces ( $capabilityNames );
			$capabilitiesAsArray = array ();
			if (strlen ( $trimmedCapNames ) != 0) {
				$capabilitiesAsArray = split ( ',', $trimmedCapNames );
			}
			$this->capabilitiesToSelect [$groupId] = $capabilitiesAsArray;
		}
		$this->filterCapabilities = empty ( $this->capabilitiesToSelect ) ? FALSE : TRUE;
	}
	
	private function removeSpaces($subject) {
		return str_replace ( " ", "", $subject );
	}
	
	public function readNextElement() {
		
		$deviceId = null;
		$groupId = null;
		
		while ( $this->xmlReader->read () ) {
			
			$nodeName = $this->xmlReader->name;
			switch ($this->xmlReader->nodeType) {
				case XMLReader::ELEMENT :
					switch ($nodeName) {
						case WURFL_Xml_Interface::DEVICE :
							$groupIDCapabilitiesMap = array ();
							
							$deviceId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ID );
							$userAgent = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::USER_AGENT );
							$fallBack = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::FALL_BACK );
							$actualDeviceRoot = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::ACTUAL_DEVICE_ROOT );
							$specific = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::SPECIFIC );
							$currentCapabilityNameValue = array ();
							if ($this->xmlReader->isEmptyElement) {
								$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot, $specific );
								break 3;
							}
							break;
						
						case WURFL_Xml_Interface::GROUP :
							$groupId = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::GROUP_ID );
							if ($this->needToReadGroup ( $groupId )) {
								$groupIDCapabilitiesMap [$groupId] = array ();
							} else {
								$this->moveToGroupEndElement ();
								break 2;
							}
							break;
						
						case WURFL_Xml_Interface::CAPABILITY :
							
							$capabilityName = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_NAME );
							if ($this->neededToReadCapability ( $groupId, $capabilityName )) {
								$capabilityValue = $this->xmlReader->getAttribute ( WURFL_Xml_Interface::CAPABILITY_VALUE );
								$currentCapabilityNameValue [$capabilityName] = $capabilityValue;
								$groupIDCapabilitiesMap [$groupId] [$capabilityName] = $capabilityValue;
							}
							
							break;
					}
					
					break;
				case XMLReader::END_ELEMENT :
					if ($nodeName == WURFL_Xml_Interface::DEVICE) {
						$this->currentElement = new WURFL_Xml_ModelDevice ( $deviceId, $userAgent, $fallBack, $actualDeviceRoot, $specific, $groupIDCapabilitiesMap );
						break 2;
					}
			}
		} // end of while
	

	}
	
	private function needToReadGroup($groupId) {
		if ($this->filterCapabilities) {
			return isset ( $this->capabilitiesToSelect [$groupId] );
		}
		return true;
	}
	
	private function neededToReadCapability($groupId, $capabilityName) {
		if (isset ( $this->capabilitiesToSelect [$groupId] )) {
			$capabilities = $this->capabilitiesToSelect [$groupId];
			if (empty ( $capabilities )) {
				return true;
			}
			foreach ( $capabilities as $capability ) {
				if (strcmp ( $capabilityName, $capability ) === 0) {
					return true;
				}
			}
			return false;
		}
		return true;
	
	}
	
	private function moveToGroupEndElement() {
		while ( ! $this->groupEndElement () ) {
			$this->xmlReader->read ();
		}
	}
	
	private function groupEndElement() {
		return ($this->xmlReader->name === "group") && ($this->xmlReader->nodeType === XMLReader::END_ELEMENT);
	}
}
