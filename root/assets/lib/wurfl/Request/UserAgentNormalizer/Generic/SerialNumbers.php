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
 * @package    WURFL_Request_UserAgentNormalizer_Generic
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer_Generic_SerialNumbers implements WURFL_Request_UserAgentNormalizer_Interface {
	
	const SERIAL_NUMBERS_PATTERN = "/(\[(TF|NT|ST)[\d|X]+\])|(\/SN[\d|X]+)/";
	
	/**
	 * Removes The serial number from the user-agent
	 * 
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return preg_replace(self::SERIAL_NUMBERS_PATTERN, "", $userAgent);
	}

}

