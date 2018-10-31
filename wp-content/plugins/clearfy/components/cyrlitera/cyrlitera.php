<?php
	/**
	 * Plugin Name: Webcraftic Cyrlitera – transliteration of links and file names
	 * Plugin URI: https://wordpress.org/plugins/cyrlitera/
	 * Description: The plugin converts Cyrillic, Georgian links, filenames into Latin. It is necessary for correct work of WordPress plugins and improve links readability.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.0.4
	 * Text Domain: cyrlitera
	 * Domain Path: /languages/
	 * Author URI: http://webcraftic.com
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( defined('WCTR_PLUGIN_ACTIVE') || (defined('WCL_PLUGIN_ACTIVE') && !defined('LOADING_CYRLITERA_AS_ADDON')) ) {
		function wbcr_cyrlitera_admin_notice_error()
		{
			?>
			<div class="notice notice-error">
				<p><?php _e('We found that you have the "Clearfy - disable unused features" plugin installed, this plugin already has disable comments functions, so you can deactivate plugin "Webcraftic Cyrlitera"!', 'cyrlitera'); ?></p>
			</div>
		<?php
		}

		add_action('admin_notices', 'wbcr_cyrlitera_admin_notice_error');

		return;
	} else {

		define('WCTR_PLUGIN_ACTIVE', true);
		define('WCTR_PLUGIN_DIR', dirname(__FILE__));
		define('WCTR_PLUGIN_BASE', plugin_basename(__FILE__));
		define('WCTR_PLUGIN_URL', plugins_url(null, __FILE__));

		
		
		if( !defined('LOADING_CYRLITERA_AS_ADDON') ) {
			require_once(WCTR_PLUGIN_DIR . '/libs/factory/core/boot.php');
		}

		require_once(WCTR_PLUGIN_DIR . '/includes/class.helpers.php');
		require_once(WCTR_PLUGIN_DIR . '/includes/class.plugin.php');

		if( !defined('LOADING_CYRLITERA_AS_ADDON') ) {

			new WCTR_Plugin(__FILE__, array(
				'prefix' => 'wbcr_cyrlitera_',
				'plugin_name' => 'wbcr_cyrlitera',
				'plugin_title' => __('Webcraftic Cyrlitera', 'cyrlitera'),
				'plugin_version' => '1.0.4',
				'required_php_version' => '5.2',
				'required_wp_version' => '4.2',
				'plugin_build' => 'free',
				'updates' => WCTR_PLUGIN_DIR . '/updates/'
			));
		}
	}