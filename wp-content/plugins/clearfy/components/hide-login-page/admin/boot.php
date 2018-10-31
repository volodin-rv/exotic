<?php
	/**
	 * Admin boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * @return array
	 */
	function wbcr_hlp_install_conflict_plugins()
	{
		// fist array item 0 - conflict
		// fist array item 1 - maybe conflict
		$install_plugins = array();

		if( is_plugin_active('hide-my-wp/index.php') ) {
			$install_plugins[] = array(0, 'Hide My WP');
		}
		if( is_plugin_active('clearfy/hide-my-wp.php') ) {
			$install_plugins[] = array(1, 'Hide My WP');
		}
		if( is_plugin_active('rename-wp-login/rename-wp-login.php') ) {
			$install_plugins[] = array(0, 'Rename wp-login.php');
		}
		if( is_plugin_active('wps-hide-login/wps-hide-login.php') ) {
			$install_plugins[] = array(0, 'WPS Hide Login');
		}
		if( is_plugin_active('wp-cerber/wp-cerber.php') ) {
			$install_plugins[] = array(1, 'WP Cerber Security & Antispam');
		}
		if( is_plugin_active('all-in-one-wp-security-and-firewall/wp-security.php') ) {
			$install_plugins[] = array(1, 'All In One WP Security');
		}
		if( is_plugin_active('wp-hide-security-enhancer/wp-hide.php') ) {
			$install_plugins[] = array(1, 'WP Hide & Security Enhancer');
		}

		return $install_plugins;
	}

	/**
	 *
	 * @param Wbcr_Factory400_Plugin $plugin
	 * @param Wbcr_FactoryPages401_ImpressiveThemplate $page
	 * @return array
	 */
	function wbcr_hlp_get_conflict_notices_error($plugin, $page)
	{
		$is_form_page = in_array($page->id, array(
			'hide_login',
			'defence'
		));

		if( $plugin->getPluginName() == WHLP_Plugin::app()->getPluginName() && $is_form_page ) {

			$install_conflict_plugins = wbcr_hlp_install_conflict_plugins();

			if( !empty($install_conflict_plugins) ) {
				foreach((array)$install_conflict_plugins as $plugin) {
					if( sizeof($plugin) == 2 ) {
						if( $plugin[0] === 0 ) {
							$page->printWarningNotice(sprintf(__("We found that you are use the (%s) plugin to change wp-login.php page address. Please delete it, because Clearfy already contains these functions and you do not need to use two plugins. If you do not want to remove (%s) plugin for some reason, please do not use wp-login.php page address change feature in the Clearfy plugin, to avoid conflicts.", 'hide_login_page'), $plugin[1], $plugin[1]));
						} else {
							$page->printWarningNotice(sprintf(__("We found that you are use the (%s) plugin. Please do not use its wp-login.php page address change and the same feature in the Clearfy plugin, to avoid conflicts.", 'hide_login_page'), $plugin[1], $plugin[1]));
						}
					}
				}
			}
		}
	}

	add_filter('wbcr_factory_pages_401_imppage_print_all_notices', 'wbcr_hlp_get_conflict_notices_error', 10, 2);

	/**
	 * Виджет отзывов
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 * @return string
	 */
	function wbcr_hlp_rating_widget_url($page_url, $plugin_name)
	{
		if( $plugin_name == WHLP_Plugin::app()->getPluginName() ) {
			return 'https://goo.gl/ecaj2V';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_pages_401_imppage_rating_widget_url', 'wbcr_hlp_rating_widget_url', 10, 2);

	function wbcr_hlp_group_options($options)
	{
		$options[] = array(
			'name' => 'hide_wp_admin',
			'title' => __('Hide wp-admin', 'hide_login_page'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'hide_login_path',
			'title' => __('Hide Login Page', 'hide_login_page'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'login_path',
			'title' => __('New login page', 'hide_login_page'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_hlp_group_options');

	function wbcr_hlp_set_plugin_meta($links, $file)
	{
		if( $file == WHLP_PLUGIN_BASE ) {
			$links[] = '<a href="https://goo.gl/TcMcS4" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'hide_login_page') . '</a>';
		}

		return $links;
	}

	if( !defined('LOADING_HIDE_LOGIN_PAGE_AS_ADDON') ) {
		add_filter('plugin_row_meta', 'wbcr_hlp_set_plugin_meta', 10, 2);
	}



