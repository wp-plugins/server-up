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
 * 
 * Class to manage admin configuration of the plugin
 * @author Arnaud Grousset
 * @since 1.0
 *
 */

class ServerUp_Admin {
	
	protected $serverup ;
	
	/**
	 * Constructor
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function __construct($serverup) {
		
		$this->serverup = $serverup ;
	}
	
	/**
	 * Register Hook
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function init() {
		
		add_menu_page(__('Server-Up', ServerUp::TEXT_DOMAIN), __('Server-Up', ServerUp::TEXT_DOMAIN), 'manage_options', ServerUp::MAIN_MENU_NAME, array($this, 'display_liste_server')) ;
		add_submenu_page(ServerUp::MAIN_MENU_NAME, __('Add server', ServerUp::TEXT_DOMAIN), __('Add server', ServerUp::TEXT_DOMAIN), 'manage_options', ServerUp::CONFIG_SUB_MENU_NAME, array($this, 'add_server')) ;
	}
	
	/**
	 * Display the main menu. It is à listing of all saved server you want check.
	 * @author Arnaud Grousset
	 * @since 
	 */
	public function display_liste_server() {
		
		$configDeleted = false ;
		
		// Check if configs need to be deleted
		if (isset($_POST['delete'])) {
			
			foreach ($_POST['delete'] as $configId) {
				
				$this->deleteServer($configId) ;
				$configDeleted = true ;
			}
		}
		
		$configs = $this->getServers() ;
		$adminURL = $this->serverup->adminUrl ;
		$menuName = ServerUp::CONFIG_SUB_MENU_NAME ;
		
		require_once $this->serverup->pluginPath . "tpl/admin/listing.php" ;
	}
	
	public function add_server() {
		
		if (isset($_GET['id'])) {
			
			$configId = $_GET['id'] ;
		}
		
		// Standard config
		$config = array(
			"id" => "",
			"servername" => "",
			"serveradress" => "",
			"serverport" => "",
			"servericons" => "",
			"servervisibility" => 0,
		) ;
		
		$configAdded = false;
		$configUpdated = false;
		
		// If a configuration should be updated or added
		if (isset($_POST[ServerUp::FORM_HIDDEN_FIELD_NAME]) && $_POST[ServerUp::FORM_HIDDEN_FIELD_NAME] == "Y") {
			
			$servericon = null ;
			$servervisibility = 0 ;
			
			// If a icon should be upload
			if ( !empty($_FILES['servericons']) && $_FILES['servericons']['error'] == 0) {
				
				$file = wp_handle_upload($_FILES['servericons'], array('test_form' => false)) ;
				$servericon = $file['url'] ;
			} else if (isset($_POST['servericons']) && $_POST['servericons'] != "") {
				
				$servericon = $_POST['servericons'] ;
			}
			
			if (isset($_POST['servervisibility']) && !empty($_POST['servervisibility'])) {
				
				$servervisibility = 1 ;
			}
			
			// If a configfile should be updated
			if (isset($_POST['config-id']) && $_POST['config-id'] != "") {
				
				$this->updateServer($_POST['config-id'], $_POST['servername'], $_POST['serveradress'], $_POST['serverport'], $servericon, $servervisibility) ;
				$configId = $_POST['config-id'] ;
				$configUpdated = true ;
			} else {
				
				// If a configfile should be added
				$configId = $this->addServer($_POST['servername'], $_POST['serveradress'], $_POST['serverport'], $servericon, $servervisibility) ;
				$configAdded = true;
			}
		}
		
		// If a configfile should be edited or a new one should be added
		if (isset($configId)) {
			
			$id = (int)$configId ;
			$data = $this->getServer($id) ;
			
			if (!empty($data)) {
				
				foreach ($data[0] as $key => $value) {
					
					$config[$key] = $value ;
				}
			}
		}
		
		$formName = ServerUp::FORM_NAME ;
		$hiddenFieldName = ServerUp::FORM_HIDDEN_FIELD_NAME ;
		
		require_once $this->serverup->pluginPath . "tpl/admin/config.php";
	}
	
	/**
	 * Returns an array containing all available webviewer configuratons
	 * @return array All available webviewer configurations
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	private function getServers() {
		
		$sql = "SELECT * FROM " . $this->serverup->tableName ;
		
		return $this->serverup->wpdb->get_results($sql, ARRAY_A) ;
	}
	
	/**
	 * Returns the requested configuration with id $id
	 * @param int $id Id of the configuration
	 * @return array Options of configuration with id $id 
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	private function getServer($id)
	{
		$sql = "SELECT * FROM " . $this->serverup->tableName . " WHERE id = %d" ;
		$sql = $this->serverup->wpdb->prepare($sql, $id) ;
		return $this->serverup->wpdb->get_results($sql, ARRAY_A) ;
	}
	
	/**
	 * 
	 * Adds a new configuration to the databse
	 * @param string $servername
	 * @param string $serveradress
	 * @param int $serverport
	 * @param string $servericon
	 * @return int
	 * @author Arnaud Grousset
	 * @since 1.2
	 */
	private function addServer($servername, $serveradress, $serverport, $servericon, $servervisibility) {
		
		$sql = "INSERT INTO " . $this->serverup->tableName . " (servername, serveradress, serverport, servericons, servervisibility) VALUES (%s, %s, %d, %s, %d) ;" ;
		$sql = $this->serverup->wpdb->prepare($sql, $servername, $serveradress, $serverport, $servericon, $servervisibility) ;
		
		$this->serverup->wpdb->query($sql) ;
		
		return $this->serverup->wpdb->insert_id ;
	}
	
	/**
	 * 
	 * Updates a configuration
	 * @param int $id
	 * @param string $servername
	 * @param string $serveradress
	 * @param int $serverport
	 * @param string $servericon
	 * @param int $servervisibility
	 * @return int
	 * @author Arnaud Grousset
	 * @since 1.2
	 */
	private function updateServer($id, $servername, $serveradress, $serverport, $servericon, $servervisibility) {
		
		$sql = "UPDATE " . $this->serverup->tableName . " SET servername = %s, serveradress = %s, serverport = %d, servericons = %s, servervisibility = %d WHERE id = %d;" ;
		$sql = $this->serverup->wpdb->prepare($sql, $servername, $serveradress, $serverport, $servericon, $servervisibility, $id) ;
		
		return $this->serverup->wpdb->query($sql) ;
	}
	
	/**
	 * Deleted the configuration with the id $id from the databse
	 * @param int $id Id of the configuration to delete
	 * @return int
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	private function deleteServer($id) {
		
		$sql = "DELETE FROM " . $this->serverup->tableName . " WHERE id = %d" ;
		$sql = $this->serverup->wpdb->prepare($sql, $id) ;
		
		return $this->serverup->wpdb->query($sql) ;
	}

}
