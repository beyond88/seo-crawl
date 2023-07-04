<?php
namespace SeoCrawl\Admin;

/**
 * Settings Handler class
 */
class Main {

	/**
	 * Settings otpions field
	 *
	 * @var string
	 */
	public $option_name = 'seo_crawl';

	/**
	 * Settings otpions group field
	 *
	 * @var string
	 */
	public $option_group = 'seocrawl_options_group';

	/**
	 * Settings otpions field default values
	 *
	 * @var array
	 */
	public $default_options = [];

	/**
	 * Initial the class and its all methods
	 *
	 * @since 1.0.0
	 * @return  void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'set_default_options' ] );
		add_action( 'admin_init', [ $this, 'menu_register_settings' ] );
	}

	/**
	 * Plugin page handler
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function plugin_menu_page() {

		$template = __DIR__ . '/views/menu-page.php';

		if ( file_exists( $template ) ) {
			$crawl = (array) get_option( $this->option_name );

			$sitemap_url = array_key_exists( 'sitemap_url', $crawl ) ? $crawl['sitemap_url'] : '';
			$links       = array_key_exists( 'links', $crawl ) ? $crawl['links'] : [];

			return require_once $template;
		}

		print esc_html__( 'File not found!', 'seo-crawl' );
	}

	/**
	 * Save the setting options
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function menu_register_settings() {
		add_option( $this->option_name, $this->default_options );
		register_setting( $this->option_group, $this->option_name );
	}

	/**
	 * Apply filter with default options
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public function set_default_options() {
		return apply_filters( 'seocrawl_default_options', $this->default_options );
	}
}
