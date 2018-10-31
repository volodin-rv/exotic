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

	function wbcr_cmp_rating_widget_url($page_url, $plugin_name)
	{
		if( $plugin_name == WCM_Plugin::app()->getPluginName() ) {
			return 'https://goo.gl/v4QkW5';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_pages_401_imppage_rating_widget_url', 'wbcr_cmp_rating_widget_url', 10, 2);

	function wbcr_cmp_group_options($options)
	{
		$options[] = array(
			'name' => 'disable_comments',
			'title' => __('Disable comments on the entire site', 'comments-plus'),
			'tags' => array('disable_all_comments'),
			'values' => array('disable_all_comments' => 'disable_comments')
		);
		$options[] = array(
			'name' => 'disable_comments_for_post_types',
			'title' => __('Select post types', 'comments-plus'),
			'tags' => array()
		);
		$options[] = array(
			'name' => 'comment_text_convert_links_pseudo',
			'title' => __('Replace external links in comments on the JavaScript code', 'comments-plus'),
			'tags' => array('recommended', 'seo_optimize')
		);
		$options[] = array(
			'name' => 'pseudo_comment_author_link',
			'title' => __('Replace external links from comment authors on the JavaScript code', 'comments-plus'),
			'tags' => array('recommended', 'seo_optimize')
		);
		$options[] = array(
			'name' => 'remove_x_pingback',
			'title' => __('Disable X-Pingback', 'comments-plus'),
			'tags' => array('recommended', 'defence', 'disable_all_comments')
		);
		$options[] = array(
			'name' => 'remove_url_from_comment_form',
			'title' => __('Remove field "site" in comment form', 'comments-plus'),
			'tags' => array()
		);

		return $options;
	}

	add_filter("wbcr_clearfy_group_options", 'wbcr_cmp_group_options');

	function wbcr_cmp_allow_quick_mods($mods)
	{
		$mods['disable_all_comments'] = array(
			'title' => __('One click disable all comments', 'comments-plus'),
			'icon' => 'dashicons-testimonial'
		);
		
		return $mods;
	}

	add_filter("wbcr_clearfy_allow_quick_mods", 'wbcr_cmp_allow_quick_mods');

	function wbcr_cmp_set_plugin_meta($links, $file)
	{
		if( $file == WCM_PLUGIN_BASE ) {
			$links[] = '<a href="https://goo.gl/TcMcS4" style="color: #FF5722;font-weight: bold;" target="_blank">' . __('Get ultimate plugin free', 'comments-plus') . '</a>';
		}

		return $links;
	}

	if( !defined('LOADING_COMMENTS_PLUS_AS_ADDON') ) {
		add_filter('plugin_row_meta', 'wbcr_cmp_set_plugin_meta', 10, 2);
	}



