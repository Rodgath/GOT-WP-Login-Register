<?php 
/*
Plugin Name: GOT-WP-Login-Register
Plugin URI: https://github.com/Rodgath/GOT-WP-Login-Register
Description: Google One Tap Login and Register for WordPress.
Author: Rodgath
Text Domain: got-wp-lr
Domain Path: /languages
Version: 1.0
Author URI: https://github.com/Rodgath
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class GotWpLoginRegister {
	
	public function __construct() {
		
		/* Load constants */
		$this->constants();
		
		/* Internationalization */
		add_action('init', array($this, 'i18n'));
		
	}
	
	private function constants() {
		defined('GOTWPLR_PREFIX') || define('GOTWPLR_PREFIX', 'gotwplr_');
		defined('GOTWPLR_DIR') || define('GOTWPLR_DIR', trailingslashit(plugin_dir_path(__FILE__)));
		defined('GOTWPLR_URI') || define('GOTWPLR_URI', trailingslashit(plugin_dir_url(__FILE__)));
		defined('GOTWPLR_ADMIN') || define('GOTWPLR_ADMIN', GOTWPLR_DIR.trailingslashit('admin'));
		defined('GOTWPLR_INC') || define('GOTWPLR_INC', GOTWPLR_DIR.trailingslashit('includes'));
		defined('GOTWPLR_ASSETS') || define('GOTWPLR_ASSETS', GOTWPLR_URI.trailingslashit('assets'));
	}
	
	/**
	 * Language translations
	 */
	public function i18n() {
		load_plugin_textdomain('got-wp-lr', false, dirname(plugin_basename(__FILE__)).'/languages/');
	}
	
	public function menu() {
		
	}
	
	public function includes() {
		
	}
	
	public function admin_scripts() {
		
	}
	
	public function frontend_scripts() {
		
	}
	
}

$GotWpLoginRegister = new GotWpLoginRegister();