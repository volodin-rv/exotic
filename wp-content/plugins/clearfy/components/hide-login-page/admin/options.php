<?php
	/**
	 * Options for additionally form
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 21.01.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * We register notifications for some actions
	 *
	 * @see libs\factory\pages\themplates\FactoryPages401_ImpressiveThemplate
	 * @param $notices
	 * @param Wbcr_Factory400_Plugin $plugin
	 * @return array
	 */
	function wbcr_hlp_get_action_notices($notices)
	{
		$notices[] = array(
			'conditions' => array(
				'wbcr_hlp_login_path_incorrect' => 1,
			),
			'type' => 'danger',
			'message' => __('You entered an incorrect part of the path to your login page. The path to the login page can not consist only of digits, at least 3 characters, you must use only the characters [0-9A-z_-]!', 'hide_login_page')
		);
		$notices[] = array(
			'conditions' => array(
				'wbcr_hlp_login_path_exists' => 1,
			),
			'type' => 'danger',
			'message' => __('The entered login page name is already used for one of your pages. Try to choose a different login page name!', 'hide_login_page')
		);

		return $notices;
	}

	add_filter('wbcr_factory_pages_401_imppage_actions_notice', 'wbcr_hlp_get_action_notices');

	/**
	 * @return array
	 */
	function wbcr_hlp_get_plugin_options()
	{
		$options = array();

		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . __('<strong>Protect your admin login</strong>.', 'hide_login_page') . '<p>' . __('Dozens of bots attack your login page at /wp-login.php and /wp-admin/daily. Bruteforce and want to access your admin panel. Even if you\'re sure that you have created a complex and reliable password, this does not guarantee security and does not relieve your login page load. The easiest way is to protect the login page by simply changing its address to your own and unique.', 'hide_login_page') . '</p></div>'
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'hide_wp_admin',
			'title' => __('Hide wp-admin', 'hide_login_page'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __("Hides the /wp-admin directory for unauthorized users. If the option is disabled, when you request the page /wp-admin you will be redirected to the login page, even if you changed its address. Therefore, for protection purposes enable this option.", 'hide_login_page')
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'hide_login_path',
			'title' => __('Hide Login Page', 'hide_login_page'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'red'),
			'hint' => __("Hides the wp-login.php and wp-signup.php pages.", 'hide_login_page') . '<br>--<br><span class="hint-warnign-color">' . __("Use this option carefully! If you forget the new login page address, you can not get into the admin panel.", 'hide_login_page') . '</span>'
		);

		$recovery_url = wbcr_hlp_get_recovery_url();
		$recovery_url = !empty($recovery_url)
			? '<br><br>' . sprintf(__("If unable to access the login/admin section anymore, use the Recovery Link which reset links to default: \n%s", 'hide_login_page'), $recovery_url)
			: '';
		$new_login_url = wbcr_hlp_get_new_login_url();

		$options[] = array(
			'type' => 'textbox',
			'name' => 'login_path',
			'placeholder' => 'secure/auth.php',
			'title' => __('New login page', 'hide_login_page'),
			'hint' => __('Set a new login page name without slash. Example: mysecretlogin', 'hide_login_page') . '<br><span style="color:red">' . __("IMPORTANT! Be sure that you wrote down the new login page address", 'hide_login_page') . '</span>: <b><a href="' . $new_login_url . '" target="_blank">' . $new_login_url . '</a></b>' . $recovery_url,
			//'units' => '<i class="fa fa-unlock" title="' . __('This option will protect your blog against unauthorized access.', 'hide_login_page') . '"></i>',
			//'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'red')
		);

		return $options;
	}

	/**
	 * @param $form
	 * @param $page Wbcr_FactoryPages401_ImpressiveThemplate
	 * @return mixed
	 */
	function wbcr_hlp_defence_form_options($form, $page)
	{
		if( empty($form) ) {
			return $form;
		}

		$options = wbcr_hlp_get_plugin_options();

		foreach($options as $option) {
			$form[0]['items'][] = $option;
		}

		return $form;
	}

	add_filter('wbcr_clr_defence_form_options', 'wbcr_hlp_defence_form_options', 10, 2);

	/**
	 * Предотвращаем попытки убить доступ к админ панели
	 *
	 * @param Wbcr_Factory400_Plugin $plugin
	 * @param Wbcr_FactoryPages401_ImpressiveThemplate $page
	 */
	function wbcr_hlp_after_form_save($plugin, $page)
	{
		$is_form_page = in_array($page->id, array(
			'hide_login',
			'defence'
		));

		if( $plugin->getPluginName() == WHLP_Plugin::app()->getPluginName() && $is_form_page ) {

			$login_path = WHLP_Plugin::app()->getOption('login_path');
			$valid_path = !is_numeric($login_path) && preg_match('/^[0-9A-z_-]{3,}$/', $login_path);

			if( !empty($login_path) ) {
				if( !$valid_path ) {
					WHLP_Plugin::app()->deleteOption('login_path');
					WHLP_Plugin::app()->deleteOption('hide_login_path');

					$page->redirectToAction('index', array('wbcr_hlp_login_path_incorrect' => 1));
				}

				$args = array(
					'name' => $login_path,
					'post_type' => array('page', 'post', 'attachment'),
					'numberposts' => 1
				);

				$posts = get_posts($args);

				if( !empty($posts) ) {
					WHLP_Plugin::app()->deleteOption('login_path');
					WHLP_Plugin::app()->deleteOption('hide_login_path');

					$page->redirectToAction('index', array('wbcr_hlp_login_path_exists' => 1));
				}

				$old_login_path = WHLP_Plugin::app()->getOption('old_login_path');

				if( !$old_login_path || $login_path != $old_login_path ) {

					$recovery_code = md5(rand(1, 9999) . microtime());

					$body = __("Hi,\nThis is %s plugin. Here is your new WordPress login address:\nURL: %s", 'hide_login_page') . PHP_EOL . PHP_EOL;
					$body .= __("IMPORTANT! Be sure that you wrote down the new login page address", 'hide_login_page') . '!' . PHP_EOL . PHP_EOL;
					$body .= __("If unable to access the login/admin section anymore, use the Recovery Link which reset links to default: \n%s", 'hide_login_page') . PHP_EOL . PHP_EOL;
					$body .= __("Best Regards,\n%s", 'hide_login_page') . PHP_EOL;

					$new_url = site_url('wp-login.php');

					$body = sprintf($body, WHLP_Plugin::app()
							->getPluginTitle(), $new_url, wbcr_hlp_get_recovery_url($recovery_code), WHLP_Plugin::app()
							->getPluginTitle()) . PHP_EOL;

					$subject = sprintf(__('[%s] Your New WP Login!', 'hide_login_page'), WHLP_Plugin::app()
						->getPluginTitle());

					wp_mail(get_option('admin_email'), $subject, $body);

					WHLP_Plugin::app()->updateOption('old_login_path', $login_path);
					WHLP_Plugin::app()->updateOption('login_recovery_code', $recovery_code);
				}
			} else {

				// if new login path is empty
				WHLP_Plugin::app()->deleteOption('old_login_path');
				WHLP_Plugin::app()->deleteOption('login_recovery_code');
			}
		}
	}

	add_action('wbcr_factory_400_imppage_after_form_save', 'wbcr_hlp_after_form_save', 10, 2);

	/**
	 * It is not possible to create a page with the same slugs as the login page
	 *
	 * @param string $slug
	 * @param int $post_ID
	 * @param string $post_status
	 * @param string $post_type
	 * @return string
	 */
	function wbcr_hlp_login_path_noconflict($slug, $post_ID, $post_status, $post_type)
	{
		if( in_array($post_type, array('post', 'page', 'attachment')) ) {
			$login_path = WHLP_Plugin::app()->getOption('login_path');

			if( !empty($login_path) ) {
				if( $slug == trim($login_path) ) {
					$slug = $slug . rand(10, 99);
				}
			}
		}

		return $slug;
	}

	add_filter('wp_unique_post_slug', 'wbcr_hlp_login_path_noconflict', 10, 4);

	/**
	 * Get the new address of the login page
	 *
	 * @return string
	 */
	function wbcr_hlp_get_new_login_url()
	{
		$login_path = WHLP_Plugin::app()->getOption('login_path');

		if( empty($login_path) ) {
			return home_url('/') . 'wp-login.php';
		}

		if( WbcrFactoryClearfy200_Helpers::isPermalink() ) {
			return WbcrFactoryClearfy200_Helpers::userTrailingslashit(home_url('/') . $login_path);
		} else {
			return home_url('/') . '?' . $login_path;
		}
	}

	/**
	 * Allows you to get a link to reset settings
	 *
	 * @param string|null $recovery_code
	 * @return string|void
	 */
	function wbcr_hlp_get_recovery_url($recovery_code = null)
	{
		$recovery_code = empty($recovery_code)
			? WHLP_Plugin::app()->getOption('login_recovery_code')
			: $recovery_code;

		if( empty($recovery_code) ) {
			return '';
		}

		return home_url('/?wbcr_hlp_login_recovery=' . $recovery_code);
	}
