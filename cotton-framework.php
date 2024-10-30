<?php
/*
Version: 0.1.3
Plugin Name: Cotton Framework
Plugin URI: http://code.google.com/p/cotton-framework/
Description: This is a public beta. The Cotton Framework provides a Cross-Browser Standards Compliant XHTML and CSS framework design and developed for Web Site and Search Engine Optimization following W3C Standards and Google Webmaster Standards.
Author: Jay Fortner
Author URI: http://wordpress.org/extend/plugins/profile/w3prodigy
License: GPL2

Copyright 2010  Jay Fortner  (email : w3prodigy@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Handles Plugin Setup
 * 
 * Imports Custom Theme Directory
 * Flushes WP Rewrite API on activation
 * Registers default settings on activation
 * Removes settings on deactivation
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

$cotton_dir_name = str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
define( 'COTTON_DIR', WP_PLUGIN_DIR . '/' . $cotton_dir_name  );
define( 'COTTON_PLUGIN_DIR', COTTON_DIR . 'plugins' );
define( 'COTTON_PLUGIN_URL', WP_PLUGIN_URL . '/' . $cotton_dir_name . 'plugins' );

global $cotton;
$cotton = new Cotton_Framework;

class Cotton_Framework {
	
	function Cotton_Framework()
	{	
		include_once( COTTON_DIR . '/cotton-settings.php' );
		$this->settings = new Cotton_Settings;
		
		if ( function_exists( 'register_theme_directory' ) )
			register_theme_directory( COTTON_DIR . '/themes' );

		register_activation_hook( __FILE__, array(&$this, 'register_activation_hook') );
		register_deactivation_hook( __FILE__, array(&$this, 'register_deactivation_hook') );
		
	} // function
	
	function register_activation_hook()
	{
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		
		add_option( $this->settings->settings_section, $this->settings->settings_defaults);
	} // function
	
	function register_deactivation_hook()
	{
		delete_option( $this->settings->settings_section );
	} // function
	
} // class

?>