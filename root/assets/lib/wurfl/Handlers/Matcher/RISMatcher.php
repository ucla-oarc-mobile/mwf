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

class WURFL_Handlers_Matcher_RISMatcher implements WURFL_Handlers_Matcher_Interface {
	
	/**
	 * Creates a RISMatcher
	 *
	 * @return WURFL_Handlers_RISMatcher
	 */
	public static function INSTANCE() {
		if (self::$instance === null) {
			self::$instance = new self ();
		}
		return self::$instance;
	}
	
	/**
	 *
	 * @param array $collection
	 * @param string $needle
	 * @param int $tollerance
	 * @return string
	 */
	public function match(&$collection, $needle, $tollerance) {
		$match = NULL;
		$bestDistance = 0;
		$low = 0;
		$high = sizeof ( $collection ) - 1;
		$bestIndex = 0;
		while ( $low <= $high ) {
			$mid = round ( ($low + $high) / 2 );
			$find = $collection [$mid];
			$distance = $this->longestCommonPrefixLength ( $needle, $find );
			if ($distance > $bestDistance) {
				$bestIndex = $mid;
				$match = $find;
				$bestDistance = $distance;
			}
			
			$cmp = strcmp ( $find, $needle );
			if ($cmp < 0) {
				$low = $mid + 1;
			} else if ($cmp > 0) {
				$high = $mid - 1;
			
			} else {
				break;
			}
		}
		
		if ($bestDistance < $tollerance) {
			return NULL;
		}
		if($bestIndex == 0) {
			return $match;
		}
		return $this->firstOfTheBests ( $collection, $needle, $bestIndex, $bestDistance );
	}
	
	private function firstOfTheBests($collection, $needle, $bestIndex, $bestDistance) {
		
		while($bestIndex > 0 && $this->longestCommonPrefixLength ( $collection [$bestIndex-1], $needle ) == $bestDistance) {
			$bestIndex = $bestIndex - 1;
		}
		return $collection [$bestIndex];
	}
	
	private function longestCommonPrefixLength($s, $t) {
		$length = min ( strlen ( $s ), strlen ( $t ) );
		
		$i = 0;
		while ( $i < $length ) {
			if ($s [$i] !== $t [$i]) {
				break;
			}
			$i ++;
		
		}
		
		return $i;
	
	}
	
	private function __construct() {
	}
	
	private static $instance;
}

