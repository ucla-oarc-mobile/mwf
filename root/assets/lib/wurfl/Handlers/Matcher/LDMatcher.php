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
 * @package    WURFL_Handlers_Matcher
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_Matcher_LDMatcher implements WURFL_Handlers_Matcher_Interface {
	
	private static $instance;
	
	private function __construct() {
	}
	
	public static function INSTANCE() {
		if (self::$instance === null) {
			self::$instance = new self ( );
		}
		return self::$instance;
	}
	
	/**
	 * Search through the collection of strings
	 * to find one with distance smaller than the
	 * given one
	 *
	 * @param array $collection
	 * @param string $needle
	 * @param int $tollerance
	 * @return string
	 */
	public function match(&$collection, $needle, $tollerance) {
		
		$best = $tollerance;
		$match = '';
		foreach ( $collection as $userAgent ) {
			if (abs ( strlen ( $needle ) - strlen ( $userAgent ) ) <= $tollerance) {
				$current = levenshtein($needle, $userAgent);
				if ($current <= $best) {
					$best = $current - 1;
					$match = $userAgent;
				}
			}
		}
		
		return $match;
	
	}
	
}

