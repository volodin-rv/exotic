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
	 * @return array
	 */
	function wbcr_cyrlitera_get_plugin_options()
	{
		$options = array();

		$options[] = array(
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header">' . '<strong>' . __('Transliteration of Cyrillic alphabet.', 'cyrlitera') . '</strong>' . '<p>' . __('Converts Cyrillic permalinks of post, pages, taxonomies and media files to the Latin alphabet. Supports Russian, Ukrainian, Georgian, Bulgarian languages. Example: http://site.dev/последние-новости -> http://site.dev/poslednie-novosti', 'cyrlitera') . '</p>' . '</div>'
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'use_transliteration',
			'title' => __('Use transliteration', 'cyrlitera'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
			'hint' => __('If you enable this option, all URLs of new pages, posts, tags, and categories will automatically be converted to Latin.', 'cyrlitera'),
			'default' => false
		);
		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'use_transliteration_filename',
			'title' => __('Convert file names', 'cyrlitera'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
			'hint' => __('This option works only for new media library files. All Cyrillic names of the downloaded files will be converted to names with Latin characters.', 'cyrlitera'),
			'default' => false
		);
		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'use_force_transliteration',
			'title' => __('Force transliteration', 'cyrlitera'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => sprintf(__('If any of your plugins affects transliteration of links and file names, you can use this option to change the plugin of %s to overwrite the changes of the other plugins.', 'cyrlitera'), WCTR_Plugin::app()
				->getPluginTitle()),
			'default' => false
		);
		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'filename_to_lowercase',
			'title' => __('Convert file names into lowercase', 'cyrlitera'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'green'),
			'hint' => __('This function works only for new upload files. Example: File_Name.jpg -> file_name.jpg', 'cyrlitera'),
			'default' => false
		);

		$options[] = array(
			'type' => 'checkbox',
			'way' => 'buttons',
			'name' => 'redirect_from_old_urls',
			'title' => __('Redirection old URLs to new ones', 'cyrlitera'),
			'layout' => array('hint-type' => 'icon', 'hint-icon-color' => 'grey'),
			'hint' => __('If at the time of the plugin installation you had pages with unconverted links, use this option to redirect users from old to new URLs with the Latin alphabet.', 'cyrlitera'),
			'default' => false
		);

		$options[] = array(
			'type' => 'textarea',
			'way' => 'buttons',
			'name' => 'custom_symbols_pack',
			'title' => __('Character Sets', 'cyrlitera'),
			'hint' => __('You can supplement current base of transliteration characters. Write pairs of values separated by commas. Example:', 'cyrlitera') . ' <b>Ё=Jo,ё=jo,Ж=Zh,ж=zh</b>'
		);

		$options[] = array(
			'type' => 'html',
			'html' => 'wbcr_cyrlitera_rollback_button'
		);

		return $options;
	}

	/**
	 * @param $html_builder Wbcr_FactoryForms400_Html
	 */
	function wbcr_cyrlitera_rollback_button($html_builder)
	{
		$form_name = $html_builder->getFormName();

		$rollback = false;
		$convert_now = false;

		if( isset($_POST['wbcr_cyrlitera_rollback_action']) ) {
			check_admin_referer($form_name, 'wbcr_cyrlitera_rollback_nonce');

			global $wpdb;

			$posts = $wpdb->get_results("SELECT p.ID, p.post_name, m.meta_value as old_post_name FROM {$wpdb->posts} p
					LEFT JOIN {$wpdb->postmeta} m
					ON p.ID = m.post_id
					WHERE p.post_status
					IN ('publish', 'future', 'private') AND m.meta_key='wbcr_wp_old_slug' AND m.meta_value IS NOT NULL");

			foreach((array)$posts as $post) {
				if( $post->post_name != $post->old_post_name ) {
					$wpdb->update($wpdb->posts, array('post_name' => $post->old_post_name), array('ID' => $post->ID), array('%s'), array('%d'));
					delete_post_meta($post->ID, 'wbcr_wp_old_slug');
				}
			}

			$terms = $wpdb->get_results("SELECT t.term_id, t.slug, o.option_value as old_term_slug FROM {$wpdb->terms} t
					LEFT JOIN {$wpdb->options} o
					ON o.option_name=concat('wbcr_wp_term_',t.term_id, '_old_slug')
					WHERE o.option_value IS NOT NULL");

			foreach((array)$terms as $term) {
				if( $term->slug != $term->old_term_slug ) {
					$wpdb->update($wpdb->terms, array('slug' => $term->old_term_slug), array('term_id' => $term->term_id), array('%s'), array('%d'));
					delete_option('wbcr_wp_term_' . $term->term_id . '_old_slug');
				}
			}

			$rollback = true;
		}

		if( isset($_POST['wbcr_cyrlitera_convert_now_action']) ) {
			check_admin_referer($form_name, 'wbcr_cyrlitera_convert_now_nonce');

			global $wpdb;

			$posts = $wpdb->get_results("SELECT ID, post_name FROM {$wpdb->posts} WHERE post_name REGEXP('[^_A-Za-z0-9\-]+') AND post_status IN ('publish', 'future', 'private')");

			foreach((array)$posts as $post) {
				$sanitized_name = WCTR_Helper::sanitizeTitle(urldecode($post->post_name));

				if( $post->post_name != $sanitized_name ) {
					add_post_meta($post->ID, 'wbcr_wp_old_slug', $post->post_name);

					$wpdb->update($wpdb->posts, array('post_name' => $sanitized_name), array('ID' => $post->ID), array('%s'), array('%d'));
				}
			}

			$terms = $wpdb->get_results("SELECT term_id, slug FROM {$wpdb->terms} WHERE slug REGEXP('[^_A-Za-z0-9\-]+') ");

			foreach((array)$terms as $term) {
				$sanitized_slug = WCTR_Helper::sanitizeTitle(urldecode($term->slug));

				if( $term->slug != $sanitized_slug ) {
					update_option('wbcr_wp_term_' . $term->term_id . '_old_slug', $term->slug);
					$wpdb->update($wpdb->terms, array('slug' => $sanitized_slug), array('term_id' => $term->term_id), array('%s'), array('%d'));
				}
			}

			$convert_now = true;
		}

		?>

		<div class="form-group form-group-checkbox factory-control-convert_now_button">
			<label for="wbcr_clearfy_convert_now_button" class="col-sm-6 control-label">
				<span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right" title="" data-original-title="<?php _e('If at the time of the plugin installation you already had posts, pages, tags and categories, click on this button and the plugin will automatically convert URLs into Latin. Attention! Previously uploaded files will not be converted.', 'cyrlitera') ?>">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt="">
				</span>
			</label>

			<div class="control-group col-sm-6">
				<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
					<form method="post">
						<?php wp_nonce_field($form_name, 'wbcr_cyrlitera_convert_now_nonce'); ?>
						<input type="submit" name="wbcr_cyrlitera_convert_now_action" value="<?php _e('Convert already created posts and categories', 'cyrlitera') ?>" class="button button-default"/>
						<?php if( $convert_now ): ?>
							<div style="color:green;margin-top:5px;"><?php _e('Url of old posts, pages,terms,tags successfully converted into Latin!', 'cyrlitera') ?></div>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>


		<div class="form-group form-group-checkbox factory-control-rollback_button">
			<label for="wbcr_clearfy_rollback_button" class="col-sm-6 control-label">
				<span class="factory-hint-icon factory-hint-icon-grey" data-toggle="factory-tooltip" data-placement="right" title="" data-original-title="<?php _e('Allows you to restore converted URLs by using the "Convert already created posts and categories" button. This can be useful in case of incorrect URLs or incorrect transliteration of some characters. You can roll back changes and advance the character sets above to correct the plugin\'s work. ', 'cyrlitera') ?>">
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAQAAABKmM6bAAAAUUlEQVQIHU3BsQ1AQABA0X/komIrnQHYwyhqQ1hBo9KZRKL9CBfeAwy2ri42JA4mPQ9rJ6OVt0BisFM3Po7qbEliru7m/FkY+TN64ZVxEzh4ndrMN7+Z+jXCAAAAAElFTkSuQmCC" alt="">
				</span>
			</label>

			<div class="control-group col-sm-6">
				<div class="factory-checkbox factory-from-control-checkbox factory-buttons-way btn-group">
					<form method="post">
						<?php wp_nonce_field($form_name, 'wbcr_cyrlitera_rollback_nonce'); ?>
						<input type="submit" name="wbcr_cyrlitera_rollback_action" value="<?php _e('Rollback changes', 'cyrlitera') ?>" class="button button-default"/>
						<?php if( $rollback ): ?>
							<div style="color:green;margin-top:5px;"><?php _e('The rollback of new changes was successful!', 'cyrlitera') ?></div>
						<?php endif; ?>
					</form>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * @param $form
	 * @param $page Wbcr_FactoryPages401_ImpressiveThemplate
	 * @return mixed
	 */
	function wbcr_cyrlitera_seo_form_options($form, $page)
	{
		if( empty($form) ) {
			return $form;
		}

		$options = wbcr_cyrlitera_get_plugin_options();

		foreach(array_reverse($options) as $option) {
			array_unshift($form[0]['items'], $option);
		}

		return $form;
	}

	add_filter('wbcr_clr_seo_form_options', 'wbcr_cyrlitera_seo_form_options', 10, 2);