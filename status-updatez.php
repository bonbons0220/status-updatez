<?php
/*
Plugin Name: Status Updatez Core Plugin
Plugin URI: http://zendgame.ocm
Description: Manage content updates shared between WordPress users.
Version: 1.0.0
Author: Bonnie Souter
Author URI: http://zendgame.com
License: GPLv2

    Copyright 2015 Bonnie Souter  (email : bonnie@zendgame.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Singleton class for setting up the plugin.
 *
 */
final class Status_Updatez_Plugin {

	public $dir_path = '';
	public $dir_uri = '';
	public $admin_dir = '';
	public $lib_dir = '';
	public $templates_dir = '';
	public $css_uri = '';
	public $js_uri = '';

	/**
	 * Returns the instance.
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Status_Updatez_Plugin;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}
	
	/**
	 * Constructor method.
	 */
	private function __construct() {
		
		//Add Scripts
		//add_action( 'wp_enqueue_scripts', array( $this , 'register_status_updatez_script' ) );
		
		//Add Shortcodes
		//add_shortcode( 'STATUSUPDATEZ' , array( $this , 'status_updatez_shortcode' ) );	
		
		// Add content filter
		add_filter( 'the_content', array($this , 'show' ) );

	}

	//
	function register_status_updatez_script() {
		
		//Register, but don't enqueue styles
		//This example requires jquery 
		//wp_register_script( 'zz-script', $this->js_uri . "status-updatez.js", array( 'jquery' ), '1.0.0', true );
		
		//Register but don't enqueue scripts
		//wp_register_style( 'zz-style', $this->css_uri . "status-updatez.css" );
	}

	public function status_updatez_shortcode( $atts, $content = null, $tagname = null ) {

		//Shortcode loads scripts and styles
		//wp_enqueue_script( 'zz-script' );
		//wp_enqueue_style( 'zz-style' );
		
		//Content is unchanged
		
		return '';
	}

	/**
	 * Show the Status Update widget on the front end.
	 */
	function show( $content ) {
	
		$append = '';
		
		// Only show on development websites
		if ( 'development' !== WP_ENV) return $content;

		if ( function_exists( 'get_cfc_meta' ) ) {
			
			// These are the Tracking entries for this page.
			// Display them in reverse chronological order.
			$tracking = get_cfc_meta( 'tracking' );
			$final = count($tracking)-1;
			
			foreach( get_cfc_meta( 'tracking' ) as $key => $value ){
				//get all the fields for this entry
				$update = '';
				$fields = array_keys($tracking[$key]);
				$class='default';
				foreach ($fields as $thisfield) {
					$thisresult = the_cfc_field( 'tracking',$thisfield, false, $key , false);
					$update .= ucfirst($thisfield) . ": " . $thisresult . "<br>";
					if (count($tracking)-1 == $key) $class = ('status' === $thisfield) ? strtolower(str_replace(" ","-",$thisresult)) : $class ;
				}
				$update = '<div class="panel panel-' . $class . '"><div class="panel-body">' . $update . '</div></div>';
				$append = $update .  $append;
			}
		
		}
		
		return $content  . $append;
	}
	
	/**
	 * Magic method to output a string if trying to use the object as a string.
	 */
	public function __toString() {
		return 'status-updatez';
	}

	/**
	 * Magic method to keep the object from being cloned.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'status-updatez' ), '1.0' );
	}

	/**
	 * Magic method to keep the object from being unserialized.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Sorry, no can do.', 'status-updatez' ), '1.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "Status_Updatez_Plugin::{$method}", esc_html__( 'Method does not exist.', 'status-updatez' ), '1.0' );
		unset( $method, $args );
		return null;
	}

	/**
	 * Sets up globals.
	 */
	private function setup() {

		// Main plugin directory path and URI.
		$this->dir_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->dir_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );

		// Plugin directory paths.
		$this->lib_dir       = trailingslashit( $this->dir_path . 'lib'       );
		$this->admin_dir     = trailingslashit( $this->dir_path . 'admin'     );
		$this->templates_dir = trailingslashit( $this->dir_path . 'templates' );

		// Plugin directory URIs.
		$this->css_uri = trailingslashit( $this->dir_uri . 'css' );
		$this->js_uri  = trailingslashit( $this->dir_uri . 'js'  );
	}

	/**
	 * Loads files needed by the plugin.
	 */
	private function includes() {

		// Load class files.
		//require_once( $this->lib_dir . 'class-role.php'         );

		// Load include files.
		//require_once( $this->lib_dir . 'functions.php'                     );
		//require_once( $this->lib_dir . 'functions-admin-bar.php'           );
		//require_once( $this->lib_dir . 'functions-options.php'             );
		//require_once( $this->lib_dir . 'functions-shortcodes.php'          );
		//require_once( $this->lib_dir . 'functions-widgets.php'             );

		// Load template files.
		//require_once( $this->lib_dir . 'template.php' );

		// Load admin/backend files.
		if ( is_admin() ) {

			// General admin functions.
			//require_once( $this->admin_dir . 'functions-admin.php' );
		
			// Plugin settings.
			//require_once( $this->admin_dir . 'class-settings.php' );

		}
	}

	/**
	 * Sets up main plugin actions and filters.
	 */
	private function setup_actions() {

		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 */
	public function activation() {

	}
	
}

/**
 * Gets the instance of the `Status_Updatez_Plugin` class.  This function is useful for quickly grabbing data
 * used throughout the plugin.
 */
function status_updatez_plugin() {
	return Status_Updatez_Plugin::get_instance();
}

// Let's roll!
status_updatez_plugin();