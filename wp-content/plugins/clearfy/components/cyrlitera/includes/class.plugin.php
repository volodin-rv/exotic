<?php
	/**
	 * Transliteration core class
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 19.02.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('WCTR_Plugin') ) {

		if( !class_exists('WCTR_PluginFactory') ) {
			if( defined('LOADING_CYRLITERA_AS_ADDON') ) {
				class WCTR_PluginFactory {

				}
			} else {
				class WCTR_PluginFactory extends Wbcr_Factory400_Plugin {

				}
			}
		}
		
		class WCTR_Plugin extends WCTR_PluginFactory {

			/**
			 * @var Wbcr_Factory400_Plugin
			 */
			private static $app;

			/**
			 * @var bool
			 */
			private $as_addon;

			/**
			 * @param string $plugin_path
			 * @param array $data
			 * @throws Exception
			 */
			public function __construct($plugin_path, $data)
			{
				$this->as_addon = isset($data['as_addon']);

				if( $this->as_addon ) {
					$plugin_parent = isset($data['plugin_parent'])
						? $data['plugin_parent']
						: null;

					if( !($plugin_parent instanceof Wbcr_Factory400_Plugin) ) {
						throw new Exception('An invalid instance of the class was passed.');
					}

					self::$app = $plugin_parent;
				} else {
					self::$app = $this;
				}

				if( !$this->as_addon ) {
					parent::__construct($plugin_path, $data);
				}

				$this->setTextDomain();
				$this->setModules();

				$this->globalScripts();

				if( is_admin() ) {
					$this->adminScripts();
				}
			}

			/**
			 * @return Wbcr_Factory400_Plugin
			 */
			public static function app()
			{
				return self::$app;
			}

			protected function setTextDomain()
			{

				load_plugin_textdomain('cyrlitera', false, dirname(WCTR_PLUGIN_BASE) . '/languages/');
			}
			
			protected function setModules()
			{
				if( !$this->as_addon ) {
					self::app()->load(array(
						array('libs/factory/bootstrap', 'factory_bootstrap_400', 'admin'),
						array('libs/factory/forms', 'factory_forms_400', 'admin'),
						array('libs/factory/pages', 'factory_pages_401', 'admin'),
						array('libs/factory/clearfy', 'factory_clearfy_200', 'all')
					));
				}
			}

			protected function initActivation()
			{
				if( !$this->as_addon ) {
					include_once(WCTR_PLUGIN_DIR . '/admin/activation.php');
					self::app()->registerActivation('WCTR_Activation');
				}
			}

			private function registerPages()
			{
				if( $this->as_addon ) {
					return;
				}

				self::app()->registerPage('WCTR_CyrliteraPage', WCTR_PLUGIN_DIR . '/admin/pages/cyrlitera.php');
				self::app()->registerPage('WCTR_MoreFeaturesPage', WCTR_PLUGIN_DIR . '/admin/pages/more-features.php');
			}
			
			private function adminScripts()
			{
				require_once(WCTR_PLUGIN_DIR . '/admin/boot.php');
				require_once(WCTR_PLUGIN_DIR . '/admin/options.php');

				$this->initActivation();
				$this->registerPages();
			}
			
			private function globalScripts()
			{
				require_once(WCTR_PLUGIN_DIR . '/includes/classes/class.configurate-cyrlitera.php');
				new WCTR_ConfigСyrlitera(self::$app);
			}
		}
	}