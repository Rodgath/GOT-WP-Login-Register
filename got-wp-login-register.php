<?php 
/*
Plugin Name: GOT WP Login Register
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
	
	private $clientId;
	
	private $clientSecret;
	
	public function __construct()
	{
		
		$this->clientId = $this->getOption('client_id');
		$this->clientSecret = $this->getOption('client_secret');
		
		/* Load constants */
		$this->constants();
		
		/* Plugin init */
		add_action('init', array($this, 'pluginInit'));
		
		/* Plugin overrides */
		add_action('plugins_loaded', array($this, 'pluginLoaded'));

		/* Load frontend styles and scripts */
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
		
		/* Append Google one tap prompt within the <body> tag */
		add_action('wp_footer', array($this, 'oneTapPrompt'), 99);
		
		/* Includes */
		$this->includes();
		
	}
	
	private function constants()
	{
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
	public function i18n()
	{
		load_plugin_textdomain('got-wp-lr', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}
	
	public function pluginInit()
	{
		/* Internationalization */
		$this->i18n();
	}
	
	public function pluginLoaded()
	{
		add_filter('script_loader_tag', array($this, 'addLibClientAttr'), 10, 3);		
	}
	
	public function includes()
	{
		require_once GOTWPLR_ADMIN . 'admin.php';
		
	}
	
	public function admin_scripts()
	{
		
	}
	
	public function frontend_scripts()
	{
		wp_register_script('gotwplr-client-lib', 'https://accounts.google.com/gsi/client', array(), false, false);
		wp_enqueue_script('gotwplr-client-lib' );
	}
	
	public function intBoolToStrBool($var)
	{
		$bool = boolval($var);
		return var_export($bool, true);
	}
	
	protected function getOption($optionId) {
		return class_exists('DilazPanel') ? DilazPanel::getOption('gotwplr_options', $optionId) : false;
	}
	
	public function oneTapPrompt() 
	{
		if (is_user_logged_in()) 
			return null;
		
		$currentUrl = $this->getCurrentUrl();
		$loginUri = add_query_arg(['gotwplr_call' => 1], $currentUrl);
		
		$prompt = '<div id="g_id_onload"
		data-client_id="'. $this->clientId .'"
		data-context="'. $this->getOption('ot_context') .'"
		data-ux_mode="'. $this->getOption('ot_ux_mode') .'"
		data-login_uri="'. $loginUri .'"
		data-auto_prompt="false"
		data-cancel_on_tap_outside="'. $this->intBoolToStrBool($this->getOption('ot_cancel_on_tap_outside')) .'">
		</div>';
		
		echo $prompt;
	}
	
	private function auth()
	{
		
		$redirectTo = $this->getCurrentUrl();
		
		$errors = new WP_Error();
		
		if (isset($_GET['gotwplr_call']) && $_GET['gotwplr_call']) {
			
			/* Check if there is CSRF token in Cookie */
			if (!isset($_COOKIE['g_csrf_token']) || empty($_COOKIE['g_csrf_token']))
				return;
			
			/* Check if there is CSRF token in post body */
			if (!isset($_POST['g_csrf_token']) || empty($_POST['g_csrf_token']))
				return;
			
			/* Verify double submit cookie */
			if ($_POST['g_csrf_token'] !== $_COOKIE['g_csrf_token'])
				return;
			
			/* Check the received ID token */
			if (!isset($_POST['credential']) || empty($_POST['credential']))
				return;
			
			require_once 'vendor/autoload.php';
			
			$client = new Google_Client(['client_id' => $this->clientId]);
			
			$idToken = $_POST['credential'];
			
			/* Verify the JWT signature, the 'aud' claim, the 'exp' claim, and the 'iss' claim */
			$payload = $client->verifyIdToken($idToken);
			
			if ($payload) {
				$userid = $payload['sub'];
				// If request specified a G Suite domain:
				//$domain = $payload['hd'];
			} else {
				// Invalid ID token
			}

		}
		
	}
	
	public function getCurrentUrl()
	{
		return (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Optimize page loading speed by adding
	 * Google client library 'async' and 'defer' attributes
	 */
	public function addLibClientAttr($tag, $handle, $src)
	{
		
		/* if not our script, do nothing and return original $tag */
		if ('gotwplr-client-lib' !== $handle) {
			return $tag;
		}
		
		/* change the script tag by adding 'async defer' and return it. */
		$tag = '<script id="' . $handle . '" src="' . esc_url($src) . '" async defer></script>';
		
		return $tag;
	}
	
}

$GotWpLoginRegister = new GotWpLoginRegister();