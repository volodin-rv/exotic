<?php

	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	class WbcrGnz_AssetsManagerPage extends Wbcr_FactoryPages401_ImpressiveThemplate {

		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages401_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = "gonzales";

		/**
		 * @var string
		 */
		public $page_menu_dashicon = 'dashicons-image-filter';

		/**
		 * @var int
		 */
		public $page_menu_position = 95;

		/**
		 * @param Wbcr_Factory400_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory400_Plugin $plugin)
		{
			$this->menu_title = __('Assets manager', 'gonzales');

			if( !defined('LOADING_GONZALES_AS_ADDON') ) {
				$this->internal = false;
				$this->menu_target = 'options-general.php';
				$this->add_link_to_plugin_actions = true;
			} else {
				$this->page_parent_page = 'performance';
			}

			parent::__construct($plugin);
		}

		/**
		 * @return string|void
		 */
		public function getMenuTitle()
		{
			return defined('LOADING_GONZALES_AS_ADDON')
				? __('Assets manager', 'gonzales')
				: __('General', 'gonzales');
		}

		/**
		 * Permalinks options.
		 *
		 * @since 1.0.0
		 * @return mixed[]
		 */
		public function getOptions()
		{
			$options = array();
			$options[] = array(
				'type' => 'html',
				'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __('Disable unused scripts, styles, and fonts', 'gonzales') . '</strong><p>' . __('There is a button in the adminbar called "Script Manager". If you click on it you will see a list of loaded scripts, styles and fonts on the current page of your site. If you think that one of the assets is superfluous on this page, you can disable it individually, so that it does not create unnecessary queries when page loading. Use the script manager very carefull to non-corrupt your website. We recommend to test this function at a local server.', 'gonzales') . '</p></div>'
			);

			$options[] = array(
				'type' => 'checkbox',
				'way' => 'buttons',
				'name' => 'disable_assets_manager',
				'title' => __('Disable assets manager', 'gonzales'),
				'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
				'hint' => __('Full disable of the module.', 'gonzales'),
				'eventsOn' => array(
					'hide' => '#wbcr-gnz-asset-manager-extend-options'
				),
				'eventsOff' => array(
					'show' => '#wbcr-gnz-asset-manager-extend-options'
				),
				'default' => false
			);

			$options[] = array(
				'type' => 'div',
				'id' => 'wbcr-gnz-asset-manager-extend-options',
				'items' => array(
					array(
						'type' => 'separator',
						'cssClass' => 'factory-separator-dashed'
					),
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'name' => 'disable_assets_manager_panel',
						'title' => __('Disable assets manager panel', 'gonzales'),
						'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
						'hint' => __('By default in your admin bar there is a button for control the assets scripts and styles. With this option, you can turn off the script manager on front and back-end.', 'gonzales'),
						'default' => false
					),
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'name' => 'disable_assets_manager_on_front',
						'title' => __('Disable assets manager on front', 'gonzales'),
						'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
						'hint' => __('Disables assets manager initialization for frontend.', 'gonzales'),
						'default' => false
					),
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'name' => 'disable_assets_manager_on_backend',
						'title' => __('Disable assets manager on back-end', 'gonzales'),
						'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
						'hint' => __('Disables assets manager initialization for backend.', 'gonzales'),
						'default' => true
					)
				)
			);

			$formOptions = array();

			$formOptions[] = array(
				'type' => 'form-group',
				'items' => $options,
				//'cssClass' => 'postbox'
			);

			return apply_filters('wbcr_gnz_assets_manager_options', $formOptions);
		}
	}
