<?php 
/**
 * Plugin Name:       GOT WP Login Register
 * Plugin URI:        https://github.com/Rodgath/GOT-WP-Login-Register
 * Description:       Google One Tap Login and Register for WordPress.
 * Version:           1.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Rodgath
 * Author URI:        https://github.com/Rodgath
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       got-wp-lr
 * Domain Path:       /languages
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

class GotWpLoginRegister {
	
	private $clientId;
	
	private $clientSecret;
	
	protected $googleClient;
	
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
		
		/* Load login styles and scripts */
		add_action('login_enqueue_scripts', array($this, 'login_scripts'));
		
		/* Append Google Signin button to WordPress login form */
		add_filter('login_form', array($this, 'googleSignInButton'));
		
		/* Includes */
		$this->includes();
		
		$this->clientId     = $this->getOption('client_id');
		$this->clientSecret = $this->getOption('client_secret');
		$this->googleClient = $this->getGoogleClient();
	}
	
	private function constants()
	{
		defined('GOTWPLR_PREFIX') || define('GOTWPLR_PREFIX', 'gotwplr_');
		defined('GOTWPLR_DIR')    || define('GOTWPLR_DIR', trailingslashit(plugin_dir_path(__FILE__)));
		defined('GOTWPLR_URI')    || define('GOTWPLR_URI', trailingslashit(plugin_dir_url(__FILE__)));
		defined('GOTWPLR_ADMIN')  || define('GOTWPLR_ADMIN', GOTWPLR_DIR.trailingslashit('admin'));
		defined('GOTWPLR_INC')    || define('GOTWPLR_INC', GOTWPLR_DIR.trailingslashit('includes'));
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
		
		/* Add Shortcodes */
		add_shortcode('gotwplr', array($this, 'signInButtonShortcode'));
		
		/* Register required plugins */
		add_action('tgmpa_register', array($this, 'registerRequiredPlugins'));
	}
	
	public function includes()
	{
		require_once GOTWPLR_ADMIN . 'admin.php';
		require_once GOTWPLR_INC . 'class-tgm-plugin-activation.php';		
	}
	
	public function login_scripts()
	{
		$this->gClientLibrary();
		wp_enqueue_script('gotwplr-js-login', GOTWPLR_ASSETS .'js/login.js', array('jquery'), null, true);
		wp_enqueue_style('logan-owl-css', GOTWPLR_ASSETS.'css/login.css');
	}
	
	public function frontend_scripts()
	{
		$this->gClientLibrary();
	}
	
	public function gClientLibrary()
	{
		wp_register_script('gotwplr-client-lib', 'https://accounts.google.com/gsi/client', array(), false, false);
		wp_enqueue_script('gotwplr-client-lib');
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
		
		if (empty($this->clientId))
			return null;
		
		$currentUrl = $this->getCurrentUrl();
		$loginUri   = add_query_arg(['gotwplr_call' => 1], $currentUrl);
		
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
	
	public function googleSignInButton()
	{
		if (is_user_logged_in()) 
			return null;
		
		if (empty($this->clientId))
			return null;
		
		$buttonPos = $this->getOption('si_button_position');
		
		$positionClass = $buttonPos;
		
		$button = '';
		$button .= '<div id="gotwplr-signin-btn" class="' . $positionClass . '" style="display:none">';
			if ($buttonPos == 'form_bottom') {
			$button .= $this->orSeparator();
			}
			$button .= '<div class="gotwplr-signin-btn-wrap">';
				$button .= $this->signInButtonMarkup();
			$button .= '</div>';
			if ($buttonPos == 'form_top') {
			$button .= $this->orSeparator();
			}
		$button .= '</div>';
		
		echo $button;
	}
	
	public function orSeparator()
	{
		return '<p class="gotwplr-or-separator"><span>OR</span></p>';
	}
	
	public function signInButtonMarkup($args = array())
	{
		
		$currentUrl = $this->getCurrentUrl();
		$loginUri   = add_query_arg(['gotwplr_call' => 1], $currentUrl);
		
		$context        = $args['context'] ? $args['context'] : $this->getOption('ot_context');
		$ux_mode        = $args['ux_mode'] ? $args['ux_mode'] : $this->getOption('ot_ux_mode');
		$type           = $args['type'] ? $args['type'] : $this->getOption('si_type');
		$theme          = $args['theme'] ? $args['theme'] : $this->getOption('si_theme');
		$size           = $args['size'] ? $args['size'] : $this->getOption('ot_ux_mode');
		$text           = $args['text'] ? $args['text'] : $this->getOption('si_text');
		$shape          = $args['shape'] ? $args['shape'] : $this->getOption('si_shape');
		$logo_align     = $args['logo_alignment'] || $args['width'] ? true : $this->getOption('si_additional_width');
		$logo_alignment = $args['logo_alignment'] ? $args['logo_alignment'] : $this->getOption('si_logo_alignment');
		$width          = $args['width'] && $args['width'] > 0 ? $args['width'] : $this->getOption('si_width');
		$auto_prompt    = $args['auto_prompt'] > 0 ? $args['auto_prompt'] : $this->intBoolToStrBool($this->getOption('si_auto_prompt'));
		
		$markup = '<div id="g_id_onload"
		data-client_id="'. $this->clientId .'"
		data-context="'. $context .'"
		data-ux_mode="'. $ux_mode .'"
		data-login_uri="'. $loginUri .'"
		data-auto_prompt="' . $auto_prompt .'">
		</div>';

		$markup .= '<div class="g_id_signin"
		data-type="'. $type .'"
		data-theme="'. $theme .'"
		data-size="'. $size .'"
		data-text="'. $text .'" 
		data-shape="'. $shape .'"';
		if ($logo_align) {
		$markup .= 'data-logo_alignment="'. $logo_alignment .'"
		data-width="'. $width .'"';
		}
		$markup .= '></div>';
		
		return $markup;
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
			
			// var_dump($payload);
			if ($payload) {
				// $userid = $payload['sub'];
				// If request specified a G Suite domain:
				//$domain = $payload['hd'];
				$userEmail = sanitize_email($payload['email']);
				if (is_email($userEmail)) {
					if (email_exists($userEmail)) {
						$this->signInUser($userEmail);
					} else {
						$this->signUpUser($payload);
					}
				}
				
			} else {
				// Invalid ID token
			}

		}
		
	}
	
	public function signInUser($userEmail)
	{
		$user = get_user_by('email', $userEmail);
		
		if ( !is_wp_error($user) ) {
			
			$this->manageWpUserAuthentication($user->ID);
			
			do_action(GOTWPLR_PREFIX .'after_user_signin', $user->ID);
		}
	}
	
	public function signUpUser($payload)
	{
		
		$userEmail = sanitize_email($payload['email']);
		$userName  = $this->generateUsername($userEmail);
		$userPass  = wp_generate_password(12, false);
		$userId    = wp_create_user($userName, $userPass, $userEmail);
		
		if ($userId) {
			
			wp_update_user(
				array(
					'ID' => $userId,
					'display_name' => sanitize_text_field($payload['name'])
				)
			);
			
			update_user_meta($userId, 'first_name', ucfirst(sanitize_text_field($payload['given_name'])));
			update_user_meta($userId, 'last_name', ucfirst(sanitize_text_field($payload['family_name'])));
			update_user_meta($userId, 'nickname', sanitize_text_field($payload['given_name']));
			
			$this->manageWpUserAuthentication($userId);
			
			do_action(GOTWPLR_PREFIX .'after_user_signup', $userId);
		}
	}
	
	protected function manageWpUserAuthentication($userId) 
	{
		/* Remove all cookies */
		wp_clear_auth_cookie();
		
		/* Set the WP login cookie */
		$secureCookie = is_ssl() ? true : false;
		wp_set_auth_cookie($userId, true, $secureCookie);
		
		/* Sett the current user object */
		wp_set_current_user($userId);
	}
	
	public function generateUsername($userEmail)
	{
		
		/* Create username from email first part and then add 4 random characters after */
		$userName = strstr($userEmail, '@', true).substr(uniqid('', true), -4);
		
		while (username_exists($userName)) {
			$userName = call_user_func([__CLASS__, 'generateUsername'], $userEmail);
		}
		
		return $userName;
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
	
	public function signInButtonShortcode($attr)
	{
		ob_start();
		
		extract(shortcode_atts(array(
			'context'        => '',
			'ux_mode'        => '',
			'type'           => '',
			'theme'          => '',
			'size'           => '',
			'text'           => '',
			'shape'          => '',
			'logo_alignment' => '',
			'width'          => '',
			'auto_prompt'    => ''
		), $attr));
		
		$args = [];
		$args['context']        = !empty(trim($context)) ? $context : false;
		$args['ux_mode']        = !empty(trim($ux_mode)) ? $ux_mode : false;
		$args['type']           = !empty(trim($type)) ? $type : false;
		$args['theme']          = !empty(trim($theme)) ? $theme : false;
		$args['size']           = !empty(trim($size)) ? $size : false;
		$args['text']           = !empty(trim($text)) ? $text : false;
		$args['shape']          = !empty(trim($shape)) ? $shape : false;
		$args['logo_alignment'] = !empty(trim($logo_alignment)) ? $logo_alignment : false;
		$args['width']          = !empty(trim($width)) ? $width : false;
		
		$shortcode = '<div class="gotwplr-signin-sc">';
			$shortcode .= $this->signInButtonMarkup($args);
		$shortcode .= '</div>';
		
		echo $shortcode;
		
		return ob_get_clean();
	}
	
	public function getCurrentUrl()
	{
		return (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
	
	/**
	 * Register required plugins
	 */
	public function registerRequiredPlugins()
	{
		tgmpa($this->requiredPlugins(), $this->requiredPluginsConfig());
	}
	
	/**
	 * List of required plugins
	 */
	public function requiredPlugins()
	{
		$requiredPlugins = array(
			array(
				'name'     => 'Dilaz Panel',
				'slug'     => 'dilaz-panel',
				'source'   => 'https://github.com/Rodgath/Dilaz-Panel/archive/refs/heads/master.zip',
				'required' => true,
			),
		);
		
		return apply_filters('gotwplr_required_plugins', $requiredPlugins);
	}
	
	public function requiredPluginsConfig()
	{
		$pluginData = get_plugin_data(__FILE__);
		
		$config = array(
			'id'           => GOTWPLR_PREFIX,          // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.

			
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'got-wp-lr' ),
				'menu_title'                      => __( 'Install Plugins', 'got-wp-lr' ),
				// translators: %s: plugin name.
				'installing'                      => __( 'Installing Plugin: %s', 'got-wp-lr' ),
				// translators: %s: plugin name.
				'updating'                        => __( 'Updating Plugin: %s', 'got-wp-lr' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'got-wp-lr' ),
				'notice_can_install_required'     => _n_noop(
					// translators: 1: plugin name(s).
					'<i>'. $pluginData['Name'] .'</i> requires the following plugin: %1$s.',
					'<i>'. $pluginData['Name'] .'</i> requires the following plugins: %1$s.',
					'got-wp-lr'
				),
				'notice_can_install_recommended'  => _n_noop(
					// translators: 1: plugin name(s).
					'<i>'. $pluginData['Name'] .'</i> recommends the following plugin: %1$s.',
					'<i>'. $pluginData['Name'] .'</i> recommends the following plugins: %1$s.',
					'got-wp-lr'
				),
				'notice_ask_to_update'            => _n_noop(
					// translators: 1: plugin name(s).
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'got-wp-lr'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					// translators: 1: plugin name(s).
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'got-wp-lr'
				),
				'notice_can_activate_required'    => _n_noop(
					// translators: 1: plugin name(s).
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'got-wp-lr'
				),
				'notice_can_activate_recommended' => _n_noop(
					// translators: 1: plugin name(s).
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'got-wp-lr'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'got-wp-lr'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'got-wp-lr'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'got-wp-lr'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'got-wp-lr' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'got-wp-lr' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'got-wp-lr' ),
				// translators: 1: plugin name.
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'got-wp-lr' ),
				// translators: 1: plugin name.
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for <i>'. $pluginData['Name'] .'</i>. Please update the plugin.', 'got-wp-lr' ),
				// translators: 1: dashboard link.
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'got-wp-lr' ),
				'dismiss'                         => __( 'Dismiss this notice', 'got-wp-lr' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'got-wp-lr' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'got-wp-lr' ),

				'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			)
		);
		
		return apply_filters('gotwplr_required_plugins_config', $config);
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