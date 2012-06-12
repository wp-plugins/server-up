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

class ServerUp_Widget {
	
	const SERVERUP_WIDGET_ID = "widget_serverup" ;
	
	protected $serverup ;
	
	public function __construct($serverup) {
		
		$this->serverup = $serverup ;
	}
	
	public function init() {
		
		wp_register_sidebar_widget(self::SERVERUP_WIDGET_ID, __('Server-Up'), array($this, 'execute')) ;
		wp_register_widget_control(self::SERVERUP_WIDGET_ID, __('Server-Up'), array($this, 'control')) ;
		
		add_action('wp_print_styles', array($this, 'load_css')) ;
		//add_action('wp_print_scripts', 'load_js' ) ;
	}
	
	public function control() {
		
		$options = get_option(self::SERVERUP_WIDGET_ID) ;
		
		if (!is_array($options)) {
			
			$options = array() ;
		}
		
		$widget_data = $_POST[self::SERVERUP_WIDGET_ID] ;
		
		if ($widget_data['submit']) {
			
			$options['title'] = $widget_data['title'] ;
			$options['uptime'] = $widget_data['uptime'] ;
			update_option(self::SERVERUP_WIDGET_ID, $options) ;
		}
		
		// Render form
		$title = $options['title'] ;
		$uptime = $options['uptime'] ;
		
		// The HTML form will go here
		require_once $this->serverup->pluginPath . 'tpl/widget/config.php' ;
	}
	
	public function execute($args) {
		
		extract($args, EXTR_SKIP) ;
		echo $before_widget ;
		
		$options = get_option(self::SERVERUP_WIDGET_ID) ;
		
		$title = $options["title"] ;
		$uptime = $options["uptime"] ;
		
		$this->display($title, $uptime) ;
		
		echo $after_widget ;
	}
	
	private function display($title, $uptime) {
		
		$list_server = $this->getServers() ;
		
		foreach ($list_server as $index => $server) {
			
			$list_server[$index]['serverstatus'] = ServerUp_PortTesting::test_port($server['serveradress'], $server['serverport']) ;
		}
		
		require_once $this->serverup->pluginPath . 'tpl/widget/render.php' ;
	}
	
	public function load_css() {
		
		wp_enqueue_style('serverup-widget-style', $this->serverup->pluginUrl . 'css/widget.css', array()) ;
	}
	
	public function load_js() {
		
		wp_enqueue_script('serverup-widget-script', '/script.js', array( 'jquery' )) ;
	}
	
	private function getServers() {
		
		$sql = "SELECT * FROM " . $this->serverup->tableName ;
		
		return $this->serverup->wpdb->get_results($sql, ARRAY_A) ;
	}
}