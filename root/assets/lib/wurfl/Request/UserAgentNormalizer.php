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
 * @package    WURFL_Request
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer implements WURFL_Request_UserAgentNormalizer_Interface {

	
	function __construct($normalizers = array()) {
		if(is_array($normalizers)) {
			$this->_userAgentNormalizers = $normalizers;
		}
	}
	
	/**
	 * Adds a new UserAgent Normalizer to the chain
	 *
	 * @param WURFL_UserAgentNormalizer_Interface $Normalizer
	 * @return unknown
	 */
	public function addUserAgentNormalizer(WURFL_Request_UserAgentNormalizer_Interface $normalizer) {
		$userAgentNormalizers = $this->_userAgentNormalizers; 
		$userAgentNormalizers[] = $normalizer;
		return new WURFL_Request_UserAgentNormalizer($userAgentNormalizers);
	}

	
	
	
	/**
	 * Return the number of normalizers currently registered
	 */
	public function count() {
		return count($this->_userAgentNormalizers);
	}
	
	/**
	 * Normalize the given user agent by passing down the chain 
	 * of normalizes
	 *
	 * @param unknown_type $userAgent
	 * @return unknown
	 */
	public function normalize($userAgent) {
		$normalizedUserAgent = $userAgent;
		foreach ($this->_userAgentNormalizers as $normalizer) {
			$normalizedUserAgent = $normalizer->normalize($normalizedUserAgent);
		}
		return $normalizedUserAgent;
	}

	/**
	 * UserAgentNormalizer chain
	 *
	 * @var array
	 */
	protected $_userAgentNormalizers = array();
}

