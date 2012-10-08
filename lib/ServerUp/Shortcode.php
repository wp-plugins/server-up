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

class ServerUp_Shortcode {
	
	protected $serverup ;
	
	public function __construct($serverup) {
		
		$this->serverup = $serverup ;
	}
	
	/**
	 * Renders the shortcodes [serverup]
	 * @param array $atts Attributes of the shortcode
	 * @return string Formatted HTML for output
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function init($atts) {
	
		if (isset($atts['id'])) {
				
			$id = (int) $atts['id'] ;
			$list_server = $this->getServer($id) ;
				
			if (!count($list_server) == 0) {
				
				return $this->render($list_server) ;
			}
		} else {
			
			$list_server = $this->getServers() ;
			
			if (!count($list_server) == 0) {
			
				return $this->render($list_server) ;
			}
		}
	}
	
	/**
	 * Renders the list server status for the shortcodes
	 * @param array $configuration Configuration to render the server
	 * @return string Formatted HTML for output
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	private function render($list_server) {
		
		foreach ($list_server as $index => $server) {
			
			$list_server[$index]['serverstatus'] = ServerUp_PortTesting::test_port($server['serveradress'], $server['serverport']) ;
		}
		
		require_once $this->serverup->pluginPath . 'tpl/shortcode/render.php' ;
	}
	
	/**
	 * Returns an array containing all available and visible configured server
	 * @return array All available configured server
	 * @author Arnaud Grousset
	 * @since 1.2
	 */
	private function getServers() {
		
		$sql = "SELECT * FROM {$this->serverup->tableName} where servervisibility = %d ;" ;
		$sql = $this->serverup->wpdb->prepare($sql, 1) ;
		return $this->serverup->wpdb->get_results($sql, ARRAY_A) ;
	}
	
	/**
	 * Returns the requested configured server with id $id
	 * @param int $id Id of the configured server
	 * @return array Options of configured server with id $id
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	private function getServer($id) {
		
		$sql = "SELECT * FROM " . $this->serverup->tableName . " WHERE id = %d" ;
		$sql = $this->serverup->wpdb->prepare($sql, $id) ;
		return $this->serverup->wpdb->get_results($sql, ARRAY_A) ;
	}
}