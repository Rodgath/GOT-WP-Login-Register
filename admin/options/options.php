<?php

defined('ABSPATH') || exit;

# Main Settings
# =============================================================================================
$options[] = array(
	'id'   => 'main-options',
	'name' => __('Main Options', 'dilaz-panel'),
	'type' => 'heading',
	'icon' => 'mdi-settings'
);

		# FIELDS - General settings
		# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		$options[] = array(
			'id'    => 'client_id',
			'name'  => __('Client Id:', 'dilaz-panel'),
			'desc'  => __('Google API client ID.', 'dilaz-panel'),
			'desc2'  => __('Example: <code>1234567890-abc123def456.apps.googleusercontent.com</code>. <br /> <a href="https://console.developers.google.com/apis/dashboard" target="_blank">Click here to create your own client Id</a>', 'dilaz-panel'),
			'type'  => 'text',
			'std'   => '',
			'class' => ''
		);
		// $options[] = array(
			// 'id'    => 'client_secret',
			// 'name'  => __('Client Secret (Optional):', 'dilaz-panel'),
			// 'desc2'  => __('Google API client Secret.', 'dilaz-panel'),
			// 'type'  => 'text',
			// 'std'   => '',
			// 'class' => ''
		// );

# One Tap Settings
# =============================================================================================
$options[] = array(
	'id'   => 'one-tap-options',
	'name' => __('One Tap Options', 'dilaz-panel'),
	'type' => 'heading',
	'icon' => 'mdi-settings'
);

		$options[] = array(
			'id'    => 'ot_auto_select',
			'name'  => __('Auto Select:', 'dilaz-panel'),
			'desc'  => __('This attribute determines whether or not to return an ID token automatically, without any user interaction, if only one Google session has approved your app.', 'dilaz-panel'),
			'type' => 'switch',
			'options' => array(
				1 => __('Yes', 'dilaz-panel'), 
				0 => __('No', 'dilaz-panel'),
			),
			'std'  => 0,
			'class' => ''
		);
		$options[] = array(
			'id'    => 'ot_cancel_on_tap_outside',
			'name'  => __('Cancel on tap outside:', 'dilaz-panel'),
			'desc'  => __('This attribute sets whether or not to cancel the One Tap request if the user clicks outside of the prompt.', 'dilaz-panel'),
			'type' => 'switch',
			'options' => array(
				1 => __('Yes', 'dilaz-panel'), 
				0 => __('No', 'dilaz-panel'),
			),
			'std'  => 1,
			'class' => ''
		);
		$options[] = array(
			'id'   => 'ot_context',
			'name' => __('Context:', 'dilaz-panel'),
			'desc' => __('This attribute changes the text of the title and messages shown in the One Tap prompt.', 'dilaz-panel'),
			'type' => 'select',
			'options' => array( 
				'signin'   => __('"Sign in with Google"', 'dilaz-panel'), 
				'signup'   => __('"Sign up with Google"', 'dilaz-panel'),
				'use' => __('"Use with Google"', 'dilaz-panel')
			),
			'std'   => 'signin',
			'class' => ''
		);
		$options[] = array(
			'id'   => 'ot_ux_mode',
			'name' => __('UX Mode:', 'dilaz-panel'),
			'desc' => __('This attribute sets the UX flow used by the Sign In With Google button.', 'dilaz-panel'),
			'type' => 'select',
			'options' => array( 
				'popup' => __('Popup window', 'dilaz-panel'), 
				'redirect' => __('Full page redirection', 'dilaz-panel')
			),
			'std'   => 'popup',
			'class' => ''
		);
		

# Google Signin Settings
# =============================================================================================
$options[] = array(
	'id'   => 'one-tap-options',
	'name' => __('Signin Button Options', 'dilaz-panel'),
	'type' => 'heading',
	'icon' => 'mdi-settings'
);

	$options[] = array(
		'id'   => 'signin-button-position',
		'name' => __('Signin Button Position', 'dilaz-panel'),
		'type' => 'subheading',
	);

		$options[] = array(
			'id'   => 'si_button_position',
			'name' => __('Button Position:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'form_before' => array('src' => $parameters['dir_url'] .'assets/images/google/btn-pos-form-before.png', 'alt' => 'Before the Login Form'),
				'form_top' => array('src' => $parameters['dir_url'] .'assets/images/google/btn-pos-form-top.png', 'alt' => 'Top of Login Form '),
				'form_bottom' => array('src' => $parameters['dir_url'] .'assets/images/google/btn-pos-form-bottom.png', 'alt' => 'Bottom of Login Form')
			),
			'std'   => 'form_top',
			'class' => ''
		);
		
	$options[] = array(
		'id'   => 'signin-button-style',
		'name' => __('Signin Button Style', 'dilaz-panel'),
		'type' => 'subheading',
	);

		$options[] = array(
			'id'   => 'si_type',
			'name' => __('Button Type:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'standard'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_type_standard.png', 'alt' => 'Standard'),
				'icon'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_type_icon.png', 'alt' => 'Icon')
			),
			'std'   => 'standard',
			'class' => ''
		);
		$options[] = array(
			'id'   => 'si_theme',
			'name' => __('Button Theme:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'outline'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_theme_outline.png', 'alt' => 'Outline'),
				'filled_blue'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_theme_filled_blue.png', 'alt' => 'Blue filled'),
				'filled_black'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_theme_filled_black.png', 'alt' => 'Black filled')
			),
			'std'   => 'outline',
			'class' => ''
		);
		$options[] = array(
			'id'   => 'si_size',
			'name' => __('Button Size:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'large'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_size_large.png', 'alt' => 'Large'),
				'medium'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_size_medium.png', 'alt' => 'Medium'),
				'small'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_size_small.png', 'alt' => 'Small')
			),
			'std'   => 'large',
			'class' => ''
		);
		$options[] = array(
			'id'   => 'si_text',
			'name' => __('Button Text:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'signin_with'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_text_signin_with.png', 'alt' => 'Sign in with Google'),
				'signup_with'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_text_signup_with.png', 'alt' => 'Sign up with Google'),
				'continue_with'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_text_continue_with.png', 'alt' => 'Continue with Google'),
				'signin'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_text_signin.png', 'alt' => 'Sign in')
			),
			'std'   => 'signin_with',
			'class' => ''
		);
		$options[] = array(
			'id'   => 'si_shape',
			'name' => __('Button Shape:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'rectangular'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_shape_rectangular.png', 'alt' => 'Rectangular-shaped'),
				'pill'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_shape_pill.png', 'alt' => 'Pill-shaped'),
				'circle'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_shape_circle.png', 'alt' => 'Circle-shaped'),
				'square'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_shape_square.png', 'alt' => 'Square-shaped')
			),
			'std'   => 'rectangular',
			'class' => ''
		);
		$options[] = array(
			'id'    => 'si_additional_width',
			'name'  => __('Add additional width:', 'dilaz-panel'),
			'desc'  => __('This attribute sets whether or not to cancel the One Tap request if the user clicks outside of the prompt.', 'dilaz-panel'),
			'type' => 'switch',
			'options' => array(
				1 => __('Yes', 'dilaz-panel'), 
				0 => __('No', 'dilaz-panel'),
			),
			'std'  => 1,
			'class' => '',
			'req_args' => array(
				'si_type' => 'standard'
			),
			'req_action' => 'show'
		);
		$options[] = array(
			'id'    => 'si_width',
			'name'  => __('Button Width:', 'dilaz-panel'),
			'desc2'  => __('The minimum button width, in pixels. The maximum width available is 400 pixels. <br /> <b>270</b> if inside the form. <br /> <b>320</b> if outside the form.', 'dilaz-panel'),
			'type'  => 'text',
			'std'   => '270',
			'class' => '',
			'req_args' => array(
				'si_additional_width' => 1
			),
			'req_action' => 'show'
		);
		$options[] = array(
			'id'   => 'si_logo_alignment',
			'name' => __('Button Logo Alignment:', 'dilaz-panel'),
			// 'desc' => __('Images used as radio option fields.', 'dilaz-panel'),
			'type' => 'radioimage',
			'options' => array(
				'left'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_logo_left.png', 'alt' => 'Left-aligned'),
				'center'  => array('src' => $parameters['dir_url'] .'assets/images/google/si_logo_center.png', 'alt' => 'Center-aligned')
			),
			'std'   => 'left',
			'class' => '',
			'req_args' => array(
				'si_additional_width' => 1
			),
			'req_action' => 'show'
		);

	$options[] = array(
		'id'   => 'signin-button-with-oen-tap',
		'name' => __('Use with One-Tap', 'dilaz-panel'),
		'type' => 'subheading',
	);
		$options[] = array(
			'id'    => 'si_auto_prompt',
			'name'  => __('Show Google One Tap:', 'dilaz-panel'),
			'desc'  => __('Whether to show Google One Tap in pages where Sign-In button is used.', 'dilaz-panel'),
			'type' => 'switch',
			'options' => array(
				1 => __('Yes', 'dilaz-panel'), 
				0 => __('No', 'dilaz-panel'),
			),
			'std'  => 0,
			'class' => ''
		);