<?php
namespace SeoCrawl;

/**
 * Support language
 *
 * @since    1.0.0
 */
class SeoCrawli18n {

	/**
	 * Call language method
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
	}

	/**
	 * Load language file from directory
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'seo-crawl',
			false,
			dirname( dirname( SEOCRAWL_BASENAME ) ) . '/languages/'
		);

	}

}
