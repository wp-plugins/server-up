<?php
/*
Plugin Name: Server-UP
Plugin URI: http://eleyone.fr
Description: Shows if server is online, or not
Version: 1.0
Author: Arnaud Grousset
Author URI: http://eleyone.fr
*/

if (!version_compare(phpversion(), "5.3.2", "<")) {
	
	global $wpdb ;
	$file = __FILE__ ;
	
	/**
	 * Autoloading
	 */
	spl_autoload_register(function($class) {
	
		$path = str_replace("_", "/", $class) ;
		$path = plugin_dir_path(__FILE__) . "/lib/" . $path . ".php" ;
		
		if (file_exists($path)) {
	
			require_once $path ;
		}
	}, true) ;
	
	/**
	 * Plugin init.
	 */
	$adminpanel = new ServerUp($wpdb, plugin_dir_path($file), plugin_dir_url($file)) ;
} else {
	
	require_once plugin_dir_path(__FILE__) . "tpl/errors/phpVersion.php" ;
}
