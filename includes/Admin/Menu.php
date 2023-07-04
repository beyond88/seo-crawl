<?php
namespace SeoCrawl\Admin;

/**
 * The Menu handler class
 */
class Menu {

	/**
	 * Plugin main file
	 *
	 * @var string class instance
	 */
	public $main;

	/**
	 * Initialize the class
	 *
	 * @since   1.0.0
	 * @param   object $main Inject class instance.
	 * @return  void
	 */
	public function __construct( $main ) {
		$this->main = $main;
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
	 * Register admin menu
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_menu() {
		$parent_slug = 'seocrawl';
		$capability  = 'manage_options';
		$icon_url    = 'dashicons-admin-site';

		$settings = apply_filters( 'seocrawl_admin_menu', [] );

		$hook = add_menu_page( __( 'SEO Crawl', 'seo-crawl' ), __( 'SEO Crawl', 'seo-crawl' ), $capability, $parent_slug, [ $this->main, 'plugin_menu_page' ], $icon_url, 50 );
		add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function enqueue_assets() {
		wp_enqueue_style( 'seocrawl-admin-boostrap' );
		wp_enqueue_style( 'seocrawl-admin-style' );
		wp_enqueue_script( 'seocrawl-admin-script' );
	}

}
