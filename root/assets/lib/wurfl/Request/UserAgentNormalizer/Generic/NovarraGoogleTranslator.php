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
class WURFL_Request_UserAgentNormalizer_Generic_NovarraGoogleTranslator implements WURFL_Request_UserAgentNormalizer_Interface {
	
	const NOVARRA_GOOGLE_TRANSLATOR_PATTERN = "/(\sNovarra-Vision.*)|(,gzip\(gfe\)\s+\(via translate.google.com\))/";
	
	/**
	 * Removes The serial number from the user-agent
	 * 
	 * 
	 * @param string $userAgent
	 * @return string
	 */
	public function normalize($userAgent) {
		return preg_replace(self::NOVARRA_GOOGLE_TRANSLATOR_PATTERN, "", $userAgent);
	}

}

