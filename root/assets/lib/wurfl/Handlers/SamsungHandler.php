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
 * SamsungUserAgentHanlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_SamsungHandler extends WURFL_Handlers_Handler {
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return boolean
	 */
	function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "Samsung/SGH" )
                || WURFL_Handlers_Utils::checkIfStartsWithAnyOf ( $userAgent, array("SEC-","Samsung","SAMSUNG", "SPH", "SGH", "SCH"));
	}


 	/**
	 * If UA starts with one of the following ("SEC-", "SAMSUNG-", "SCH"), apply RIS with FS.
	 * If UA starts with one of the following ("Samsung-","SPH", "SGH" ), apply RIS with First Space (not FS).
	 * If UA starts with "SAMSUNG/", apply RIS with threshold SS (Second Slash)
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
        $tolerance = $this->tolerance($userAgent);
		$this->logger->log ( "$this->prefix :Applying Conclusive Match for ua: $userAgent with tolerance $tolerance" );
		return WURFL_Handlers_Utils::risMatch ( array_keys ( $this->userAgentsWithDeviceID ), $userAgent, $tolerance );
	}

 
    private function tolerance($userAgent) {
        if(WURFL_Handlers_Utils::checkIfStartsWithAnyOf($userAgent, array("SEC-", "SAMSUNG-", "SCH"))) {
            return WURFL_Handlers_Utils::firstSlash($userAgent);
        }
        if(WURFL_Handlers_Utils::checkIfStartsWithAnyOf($userAgent, array("Samsung-","SPH", "SGH"))) {
            return WURFL_Handlers_Utils::firstSpace($userAgent);
        }
        if(WURFL_Handlers_Utils::checkIfStartsWith($userAgent, "SAMSUNG/")) {
            return WURFL_Handlers_Utils::secondSlash($userAgent);
        }
        return WURFL_Handlers_Utils::firstSlash($userAgent);
    }

    protected $prefix = "SAMSUNG";
}

