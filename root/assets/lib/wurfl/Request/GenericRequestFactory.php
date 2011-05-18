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
class WURFL_Request_GenericRequestFactory {


	/**
	 * Creates GenericRequest Object from
	 * a $_SERVER object
	 *
	 * @param $_SERVER $request
	 * @return GenericRequest
	 */
	public function createRequest($request) {
		$userAgent = WURFL_WURFLUtils::getUserAgent($request);
		$userAgentProfile = WURFL_WURFLUtils::getUserAgentProfile($request);
		$isXhtmlDevice = WURFL_WURFLUtils::isXhtmlRequester($request);

		return new WURFL_Request_GenericRequest($userAgent, $userAgentProfile, $isXhtmlDevice);
	}

	public function createRequestForUserAgent($userAgent) {
		return new WURFL_Request_GenericRequest($userAgent, null, false);
	}

	
}


