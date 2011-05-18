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
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * BlackBerryUserAgentHanlder
 * 
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_BlackBerryHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 * Intercept all UAs containing "BlackBerry"
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "BlackBerry" ) || WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Blackberry" );
	}
	
	private $blackberryIds = array(
		"2." => "blackberry_generic_ver2",
        "3.2" => "blackberry_generic_ver3_sub2",
        "3.3" => "blackberry_generic_ver3_sub30",
        "3.5" => "blackberry_generic_ver3_sub50",
        "3.6" => "blackberry_generic_ver3_sub60",
        "3.7" => "blackberry_generic_ver3_sub70",
		"4.1" => "blackberry_generic_ver4_sub10",
       	"4.2" => "blackberry_generic_ver4_sub20",
	    "4.3" => "blackberry_generic_ver4_sub30",
	    "4.5" => "blackberry_generic_ver4_sub50",
       	"4.6" => "blackberry_generic_ver4_sub60",
	    "4.7" => "blackberry_generic_ver4_sub70",
	    "4." => "blackberry_generic_ver4",	
	    "5." => "blackberry_generic_ver5",
	    "6." => "blackberry_generic_ver6"
	
	);
	/**
	 * Apply Recovery Match
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function applyRecoveryMatch($userAgent) {
		$version = $this->blackberryVersion($userAgent);
		if(is_null($version)) {
			return WURFL_Constants::GENERIC;
		}
		foreach ($this->blackberryIds as $v => $deviceId) {
			if(WURFL_Handlers_Utils::checkIfStartsWith($version, $v)) {
				return $deviceId;
			}
		}
		
		return WURFL_Constants::GENERIC;
		
	}
	
	const BLACKBERRY_VERSION_PATTERN = "/Black[Bb]erry[^\/\s]+\/(\d.\d)/";
	private function blackberryVersion($userAgent) {
		if(preg_match(self::BLACKBERRY_VERSION_PATTERN, $userAgent, $matches)) {
			return $matches[1];
		}
		return NULL;
	}
	
	protected $prefix = "BLACKBERRY";
}

