<?php 
/*
Plugin Name: GOT-WP-Login-Register
Plugin URI: https://github.com/Rodgath/GOT-WP-Login-Register
Description: Google One Tap Login and Register for WordPress
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
		
		/* Internationalization */
		add_action('init', array($this, 'i18n'));
		
	}
	
	private function constants() {
		defined('LOGAN_PREFIX') || define('LOGAN_PREFIX', 'logan_');
		defined('LOGAN_DIR') || define('LOGAN_DIR', trailingslashit(plugin_dir_path(__FILE__)));
		defined('LOGAN_URI') || define('LOGAN_URI', trailingslashit(plugin_dir_url(__FILE__)));
		defined('LOGAN_ADMIN') || define('LOGAN_ADMIN', LOGAN_DIR.trailingslashit('admin'));
		defined('LOGAN_METABOX') || define('LOGAN_METABOX', LOGAN_DIR.trailingslashit('metabox'));
		defined('LOGAN_INC') || define('LOGAN_INC', LOGAN_DIR.trailingslashit('includes'));
		defined('LOGAN_ASSETS') || define('LOGAN_ASSETS', LOGAN_URI.trailingslashit('assets'));
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