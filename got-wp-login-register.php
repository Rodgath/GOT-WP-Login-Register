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
	
	private $googleClient;
	
	public function __construct()
	{
		
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
		
		$this->clientId = $this->getOption('client_id');
		$this->clientSecret = $this->getOption('client_secret');
		$this->googleClient = $this->getGoogleClient();
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
		
		/* Run login endpoint */
		$this->auth();
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
		// if (is_user_logged_in()) 
			// return null;
		
		$currentUrl = $this->getCurrentUrl();
		$loginUri = add_query_arg(['gotwplr_call' => 1], $currentUrl);
		
		$prompt = '<div id="g_id_onload"
		data-client_id="'. $this->clientId .'"
		data-context="'. $this->getOption('ot_context') .'"
		data-ux_mode="'. $this->getOption('ot_ux_mode') .'"
		data-auto_select="'. $this->intBoolToStrBool($this->getOption('ot_auto_select')) .'"
		data-login_uri="'. $loginUri .'"
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
			
			$idToken = $_POST['credential'];
			
			/* get the payload */
			$payload = $this->getPayload($idToken);
			
			var_dump($payload);
			if ($payload) {
				$userid = $payload['sub'];
				// If request specified a G Suite domain:
				//$domain = $payload['hd'];
			} else {
				// Invalid ID token
			}

		}
		
	}
	
	private function getPayload($idToken)
	{
		
		$client = $this->googleClient;
		
		/* Create the JWT service and set leeway property
		/* Fixes leeway issue with JWT token */
		/* @see - https://github.com/googleapis/google-api-php-client/issues/1630 */
		$jwt = new \Firebase\JWT\JWT;
		$jwt::$leeway = 5;
		
		do {
			$attempt = 0;
			
			try {
				
				/* Verify the JWT signature, the 'aud' claim, the 'exp' claim, and the 'iss' claim */
				$payload = $client->verifyIdToken($idToken);
				
				$retry = false;
				
			} catch (Firebase\JWT\BeforeValidException $e) {
				$attempt++;
				$retry = $attempt < 2;
			}
			
		} while ($retry);
		
		return $payload;
	}
	
	private function getGoogleClient() 
	{
		require_once GOTWPLR_DIR . '/vendor/autoload.php';
		
		/* Create the Google client object */
		$client = new Google_Client(apply_filters('gotwplr_client_config', array()));
		
		$client->setApplicationName('Google One Tap WP');
		$client->setClientId($this->clientId);
		$client->setClientSecret($this->clientSecret);
		$client->setRedirectUri($this->getCurrentUrl());
		
		return $client;
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