<?php
	/**
	 * Plugin Name: Webcraftic Disable Comments
	 * Plugin URI: https://wordpress.org/plugins/comments-plus/
	 * Description: Allows administrators to globally disable comments on their site. Comments can be disabled for individual record types.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.0.7
	 * Text Domain: comments-plus
	 * Domain Path: /languages/
	 * Author URI: http://webcraftic.com
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( defined('WCM_PLUGIN_ACTIVE') || (defined('WCL_PLUGIN_ACTIVE') && !defined('LOADING_COMMENTS_PLUS_AS_ADDON')) ) {
		function wbcr_cmp_admin_notice_error()
		{
			?>
			<div class="notice notice-error">
				<p><?php _e('We found that you have the "Clearfy - disable unused features" plugin installed, this plugin already has disable comments functions, so you can deactivate plugin "Disable comments"!'); ?></p>
			</div>
		<?php
		}

		add_action('admin_notices', 'wbcr_cmp_admin_notice_error');

		return;
	} else {

		define('WCM_PLUGIN_ACTIVE', true);

		define('WCM_PLUGIN_DIR', dirname(__FILE__));
		define('WCM_PLUGIN_BASE', plugin_basename(__FILE__));
		define('WCM_PLUGIN_URL', plugins_url(null, __FILE__));

		

		if( !defined('LOADING_COMMENTS_PLUS_AS_ADDON') ) {
			require_once(WCM_PLUGIN_DIR . '/libs/factory/core/boot.php');
		}

		require_once(WCM_PLUGIN_DIR . '/includes/class.plugin.php');

		if( !defined('LOADING_COMMENTS_PLUS_AS_ADDON') ) {
			//todo: обновить опции в старом плагине на новый префикс
			new WCM_Plugin(__FILE__, array(
				'prefix' => 'wbcr_comments_plus_', // wbcr_cmp
				'plugin_name' => 'wbcr_comments_plus',
				'plugin_title' => __('Webcraftic Disable comments', 'comments-plus'),
				'plugin_version' => '1.0.7',
				'required_php_version' => '5.2',
				'required_wp_version' => '4.2',
				'plugin_build' => 'free',
				//'updates' => WCM_PLUGIN_DIR . '/updates/'
			));
		}
	}