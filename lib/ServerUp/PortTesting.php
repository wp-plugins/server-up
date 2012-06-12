<?php 
/**
 * This file is part of Server-Up for Wordpress.
 * Copyright (C) 2012  Arnaud Grousset
 *
 * Server-Up  for Wordpress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Server-Up is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Server-Up for Wordpress.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Arnaud Grousset
 * @since 1.0
 *
 */

class ServerUp_PortTesting {
	
	/**
	 * 
	 * Test if a port is open on specific address. Return true if port are reachable, false else.
	 * @param String $address
	 * @param int $port1
	 * @param int $port2
	 * @return boolean
	 */
	public static function test_port($address, $port) {
		
		$result = false ;
		
		$fp = @fsockopen($address, $port, $errno, $errstr, 2) ;
		error_log($errstr) ;
		
		if ($fp) {
			
			$result = true ;
		}
		@fclose($fp) ;
		
		return $result ;
	}
	
	/**
	 * 
	 * Test if each port of a range of port on specific address are open. Return true if each port are reachable, return false if just one is'nt open.
	 * @param unknown_type $address
	 * @param unknown_type $port_first
	 * @param unknown_type $port_last
	 */
	public static function test_port_range($address, $port_first, $port_last) {
			
		if($port_first > $port_last) {
			
			$tmp = $port_last ;
			$port_last = $port_first ;
			$port_first = $tmp;
			
			unset($tmp) ;
			
		}
		
		for($i = $port_first; $i <= $port_last; $i++) {
			
			if(! self::test_port($address, $i)) {
				return false ;
			}
			
		}
		
		return true ;
		
	}
}