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

class ServerUp_Widget extends WP_Widget {
	
	const SERVERUP_WIDGET_ID = "widget_serverup" ;
	
	protected $serverup ;
	
	/* Widget control settings. */
	protected $_control_ops = array('id_base' => self::SERVERUP_WIDGET_ID) ;
	
	public function __construct() {
		
		$this->serverup = ServerUp::getInstance() ;
		
		$widget_ops = array(
			'classname' => self::SERVERUP_WIDGET_ID,
			'description' => __('Display a list of configured servers with name, icon and state (online or not)', ServerUp::TEXT_DOMAIN),
		) ;
		
		/* Create the widget. */
		$this->WP_Widget(self::SERVERUP_WIDGET_ID, __('Server-Up'), $widget_ops, $this->_control_ops ) ;
		
		$this->init() ;
	}
	
	/**
	 * Initialization of widget
	 * @author Arnaud Grousset
	 * @since 1.1
	 */
	public function init() {
		
		add_action('wp_print_styles', array($this, 'load_css')) ;
		//add_action('wp_print_scripts', 'load_js' ) ;
	}
	
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance ;
		
		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags($new_instance['title']) ;
		$instance['uptime'] = strip_tags($new_instance['uptime']) ;
		
		return $instance ;
	}
	
	public function form($instance) {
		
		/* Set up some default widget settings. */
		$defaults = array('title' => __('Server-Up'), 'uptime' => '60') ;
		$instance = wp_parse_args((array)$instance, $defaults) ;
		
		// Render form
		$title = strip_tags($instance['title']) ;
		$uptime = strip_tags($instance['uptime']) ;
		
		// The HTML form will go here
		require_once $this->serverup->pluginPath . 'tpl/widget/config.php' ;
	}
	
	public function widget($args, $instance) {
		
		extract($args, EXTR_SKIP) ;
		
		echo $before_widget ;
		
		$title = $instance["title"] ;
		$uptime = $instance["uptime"] ;
		
		$this->display($title, $uptime) ;
		
		echo $after_widget ;
		
	}
	
	/**
	 * Display widget' datas
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	private function display($title, $uptime) {
		
		$list_server = $this->getServers() ;
		
		foreach ($list_server as $index => $server) {
			
			$list_server[$index]['serverstatus'] = ServerUp_PortTesting::test_port($server['serveradress'], $server['serverport']) ;
		}
		
		require_once $this->serverup->pluginPath . 'tpl/widget/render.php' ;
	}
	
	/**
	 * Load Server-Up specific stylesheet
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	public function load_css() {
		
		wp_enqueue_style('serverup-widget-style', $this->serverup->pluginUrl . 'css/widget.css', array()) ;
	}
	
	/**
	 * Load Server-Up specific javascript
	 * @author Arnaud Grousset
	 * @since 1.0
	 */
	public function load_js() {
		
		wp_enqueue_script('serverup-widget-script', '/script.js', array( 'jquery' )) ;
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
}