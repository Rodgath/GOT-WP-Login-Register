<?php

defined('ABSPATH') || exit;

# General Settings
# =============================================================================================
$options[] = array(
	'id'   => 'general-options',
	'name' => __('General Options', 'dilaz-panel'),
	'type' => 'heading',
	'icon' => 'mdi-settings'
);

		# FIELDS - General settings
		# >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		$options[] = array(
			'id'    => 'text',
			'name'  => __('Client ID:', 'dilaz-panel'),
			'desc'  => __('Text field example.', 'dilaz-panel'),
			'type'  => 'text',
			'std'   => '',
			'class' => ''
		);