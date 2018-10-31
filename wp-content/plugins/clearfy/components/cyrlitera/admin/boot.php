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
	function wbcr_cyrlitera_install_conflict_plugins()
	{
		$install_plugins = array();

		if( is_plugin_active('wp-translitera/wp-translitera.php') ) {
			$install_plugins[] = 'WP Translitera';
		}

		if( is_plugin_active('cyr3lat/cyr-to-lat.php') ) {
			$install_plugins[] = 'Cyr to Lat enhanced';
		}

		if( is_plugin_active('cyr2lat/cyr-to-lat.php') ) {
			$install_plugins[] = 'Cyr to Lat';
		}

		if( is_plugin_active('cyr-and-lat/cyr-and-lat.php') ) {
			$install_plugins[] = 'Cyr-And-Lat';
		}

		if( is_plugin_active('rustolat/rus-to-lat.php') ) {
			$install_plugins[] = 'RusToLat';
		}

		if( is_plugin_active('rus-to-lat-advanced/ru-translit.php') ) {
			$install_plugins[] = 'Rus filename and link translit';
		}

		return $install_plugins;
	}

	/**
	 * @return array
	 */
	function wbcr_cyrlitera_get_conflict_notices_error()
	{
		$notices = array();
		$plugin_title = WCTR_Plugin::app()->getPluginTitle();

		$default_notice = $plugin_title . ': ' . __('We found that you have the plugin %s installed. The functions of this plugin already exist in %s. Please deactivate plugin %s to avoid conflicts between plugins functions.', 'cyrlitera');
		$default_notice .= ' ' . __('If you do not want to deactivate the plugin %s for some reason, we strongly recommend do not use the same plugins functions at the same time!', 'cyrlitera');

		$install_conflict_plugins = wbcr_cyrlitera_install_conflict_plugins();

		if( !empty($install_conflict_plugins) ) {
			foreach((array)$install_conflict_plugins as $plugin_name) {
				$notices[] = sprintf($default_notice, $plugin_name, $plugin_title, $plugin_name, $plugin_name);
			}
		}

		return $notices;
	}

	add_filter('wbcr_clr_seo_page_warnings', 'wbcr_cyrlitera_get_conflict_notices_error');

	/**
	 * Ошибки совместимости с похожими плагинами
	 */
	function wbcr_cyrlitera_admin_conflict_notices_error()
	{
		$notices = wbcr_cyrlitera_get_conflict_notices_error();

		if( empty($notices) ) {
			return;
		}

		?>
		<div id="wbcr-cyrlitera-conflict-error" class="notice notice-error is-dismissible">
			<?php foreach((array)$notices as $notice): ?>
				<p>
					<?= $notice ?>
				</p>
			<?php endforeach; ?>
		</div>
	<?php
	}

	add_action('admin_notices', 'wbcr_cyrlitera_admin_conflict_notices_error');

	/**
	 * Виджет отзывов
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 * @return string
	 */
	function wbcr_cyrlitera_rating_widget_url($page_url, $plugin_name)
	{
		if( $plugin_name == WCTR_Plugin::app()->getPluginName() ) {
			return 'https://goo.gl/ecaj2V';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_pages_401_imppage_rating_widget_url', 'wbcr_cyrlitera_rating_widget_url', 10, 2);

	function wbcr_cyrlitera_group_options($options)
	{
		$install_conflict_plugins = wbcr_cyrlitera_install_conflict_plugins();
		$is_cyrilic = in_array(get_locale(), array('ru_RU', 'bel', 'kk', 'uk', 'bg', 'bg_BG', 'ka_GE'));

		if( !empty($install_conflict_plugins) || !$is_cyrilic ) {
			$tags = array();
		} else {
			$tags = array('recommended', 'seo_optimize');
		}

		$options[] = array(
			'name' => 'use_transliteration',
			'title' => __('Use transliteration', 'cyrlitera'),
			'tags' => $tags
		);

		$options[] = array(
			'name' => 'use_force_transliteration',
			'title' => __('Force transliteration', 'cyrlitera'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'use_transliteration_filename',
			'title' => __('Convert file names', 'cyrlitera'),
			'tags' => $tags
		);

		$options[] = array(
			'name' => 'filename_to_lowercase',
			'title' => __('Convert file names into lowercase', 'cyrlitera'),
			'tags' => $tags
		);

		$options[] = array(
			'name' => 'redirect_from_old_urls',
			'title' => __('Redirection old URLs to new ones', 'cyrlitera'),
			'tags' => array()
		);

		$options[] = array(
			'name' => 'custom_symbols_pack',
			'title' => __('Character Sets', 'cyrlitera'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_cyrlitera_group_options');

	function wbcr_cyrlitera_set_plugin_meta($links, $file)
	{
		if( $file == WCTR_PLUGIN_BASE ) {
			$links[] = '<a href="https://goo.gl/TcMcS4" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'cyrlitera') . '</a>';
		}

		return $links;
	}

	if( !defined('LOADING_CYRLITERA_AS_ADDON') ) {
		add_filter('plugin_row_meta', 'wbcr_cyrlitera_set_plugin_meta', 10, 2);
	}



