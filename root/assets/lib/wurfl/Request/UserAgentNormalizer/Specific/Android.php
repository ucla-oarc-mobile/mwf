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
 * @package    WURFL_Request_UserAgentNormalizer_Specific
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer_Specific_Android implements WURFL_Request_UserAgentNormalizer_Interface {

    const ANDROID_OS_VERSION = "/(Android[\s\/]\d.\d)(.*?;)/";
    
	/**
	 * Trims To Two Digit The Os Version
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return preg_replace(self::ANDROID_OS_VERSION, "$1;", $userAgent);
	}


}
