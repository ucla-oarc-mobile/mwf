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
 * LGUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_LGHandler extends WURFL_Handlers_Handler {
	
	protected $prefix = "LG";
	
	function __construct($wurflContext, $userAgentNormalizer = null) {
		parent::__construct ( $wurflContext, $userAgentNormalizer );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	public function canHandle($userAgent) {
		return WURFL_Handlers_Utils::checkIfContains ( $userAgent, "LG" ) || WURFL_Handlers_Utils::checkIfStartsWith ( $userAgent, "lg" );
	}
	
	/**
	 *
	 * @param string $userAgent
	 * @return string
	 */
	function lookForMatchingUserAgent($userAgent) {
        $tolerance = WURFL_Handlers_Utils::indexOfOrLength($userAgent, "/", strpos ( $userAgent, "LG" ) );
        $userAgents = array_keys ( $this->userAgentsWithDeviceID );
        return parent::applyRisWithTollerance ( $userAgents, $userAgent, $tolerance );

	}
		

}
