<?php
	/**
	 * Plugin Name: Webcraftic Clearfy – WordPress optimization plugin
	 * Plugin URI: https://wordpress.org/plugins/clearfy/
	 * Description: Disables unused Wordpress features, improves performance and increases SEO rankings, using Clearfy, which makes WordPress very easy.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.2.1
	 * Text Domain: clearfy
	 * Domain Path: /languages/
	 * Author URI: http://webcraftic.com
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
		return;
	}
	define('WBCR_CLEARFY_PLUGIN_ACTIVE', true);

	define('WCL_PLUGIN_DIR', dirname(__FILE__));
	define('WCL_PLUGIN_BASE', plugin_basename(__FILE__));
	define('WCL_PLUGIN_URL', plugins_url(null, __FILE__));

	

	require_once(WCL_PLUGIN_DIR . '/includes/helpers.php');

	// creating a plugin via the factory
	require_once(WCL_PLUGIN_DIR . '/libs/factory/core/boot.php');
	require_once(WCL_PLUGIN_DIR . '/includes/class.plugin.php');

	new WCL_Plugin(__FILE__, array(
		'prefix' => 'wbcr_clearfy_',
		'plugin_name' => 'wbcr_clearfy',
		'plugin_title' => __('Clearfy', 'clearfy'),
		'plugin_version' => '1.2.1',
		'required_php_version' => '5.2',
		'required_wp_version' => '4.2',
		'plugin_build' => 'free',
		'updates' => WCL_PLUGIN_DIR . '/updates/'

	));