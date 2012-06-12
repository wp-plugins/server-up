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
 * Main class of the plugin
 * @author Arnaud Grousset
 * @since 1.0
 *
 */

class ServerUp {
	
	const VERSION = "1.0" ;
	const VERSION_OPTION_NAME = "serverup_version" ;
	const TABLE_NAME = "serverup";
	const MAIN_MENU_NAME = "serverup-menu";
	const CONFIG_SUB_MENU_NAME = "serverup-menu-config";
	const OPTIONS_SUB_MENU_PAGE = "serverup-menu-options";
	const TEXT_DOMAIN = "serverup";
	const FORM_NAME = "serverup-form" ;
	const FORM_HIDDEN_FIELD_NAME = "{self::FORM_NAME}-hidden" ;
	
	public $pluginPath ;
	public $pluginUrl ;
	public $uploadPath ;
	public $uploadUrl ;
	public $adminUrl ;
	public $wpdb ;
	public $tableName ;
	
	/**
	 * Inserts the database for the TeamSpeak3 Webviewer Data
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function __construct($wpdb, $pluginPath, $pluginUrl) {
		
		$this->wpdb = $wpdb ;
		$this->tableName = $this->wpdb->prefix . ServerUp::TABLE_NAME ;
		$this->pluginPath = $pluginPath . ((substr($pluginPath, -1) != '/') ? "/" : '' ) ;
		$this->pluginUrl = $pluginUrl ;
		$this->adminUrl = admin_url() ;
		
		$this->registerHooks() ;
	}
	
	/**
	 * Inserts the database for the TeamSpeak3 Webviewer Data
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function install() {
		
		$wpdb = $this->wpdb;
		
		$sql = "CREATE TABLE " . $this->tableName . " (
			id INT(5) NOT NULL AUTO_INCREMENT,
			servername VARCHAR(255) NOT NULL,
			serveradress VARCHAR(255) NOT NULL,
			serverport INT(6) NOT NULL,
			servericons VARCHAR(255) NULL,
			PRIMARY KEY  (id)
		);" ;
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		dbDelta($sql) ;
		add_option(ServerUp::VERSION_OPTION_NAME, ServerUp::VERSION) ;
		$this->upgrade() ;
	}
	
	/**
	 * Deletes the version option
	 * @since 1.0
	 * @author Arnaud Grousset
	 */
	public function uninstall() {
		
		delete_option(ServerUp::VERSION_OPTION_NAME) ;
	}
	
	/**
	 * Upgrades the table structure to the latest version
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	public function upgrade() {
		
		// Upgrade to database version 1.1
		if (version_compare(get_option(ServerUp::VERSION_OPTION_NAME), ServerUp::VERSION, "<")) {
			
			$sql = "CREATE TABLE " . $this->tableName . " (
				id INT(5) NOT NULL AUTO_INCREMENT,
				servername VARCHAR(255) NOT NULL,
				serveradress VARCHAR(255) NOT NULL,
				serverport INT(6) NOT NULL,
				servericons VARCHAR(255) NULL,
				PRIMARY KEY  (id)
			);" ;
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php') ;
			dbDelta($sql);
			
			update_option(ServerUp::VERSION_OPTION_NAME, ServerUp::VERSION) ;
		}
	}
	
	public function setI18n() {
		
		$path = basename($this->pluginPath) . "/l10n" ;
		load_plugin_textdomain(ServerUp::TEXT_DOMAIN, false, $path) ;
	}
	
	/**
	 * Registers hooks
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	private function registerHooks() {
		
		add_action('init', array($this, 'setI18n')) ;
		
		register_activation_hook($this->pluginPath . "server-up.php", array($this, 'install')) ;
		register_deactivation_hook($this->pluginPath .  "server-up.php", array($this, 'uninstall')) ;
		add_action('plugins_loaded', array($this, 'upgrade')) ;
		
		/**
		 * Loading administration panel
		 */
		$adminpanel = new ServerUp_Admin($this) ;
		
		if (isset($adminpanel)) {
				
			add_action('admin_menu', array($adminpanel, 'init')) ;
		}
		
		/**
		 * Loading widget
		 */
		$widget = new ServerUp_Widget($this) ;
		
		if (isset($widget)) {
				
			add_action("plugins_loaded", array($widget, 'init')) ;
		}
		
		/**
		 * Loading shortcode
		 */
		$shortcode = new ServerUp_Shortcode($this) ;
		
		if (isset($shortcode)) {
				
			add_shortcode('serverup', array($shortcode, 'init')) ;
		}
		
	}
}