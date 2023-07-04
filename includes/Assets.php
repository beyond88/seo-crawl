<?php
namespace SeoCrawl;

/**
 * Assets handlers class
 */
class Assets {

	/**
	 * Class constructor
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_assets' ] );
	}

	/**
	 * All available scripts
	 *
	 * @since   1.0.0
	 * @return  array
	 */
	public function get_admin_scripts() {
		return [
			'seocrawl-admin-script' => [
				'src'     => SEOCRAWL_ASSETS . '/js/backend.js',
				'version' => filemtime( SEOCRAWL_PATH . '/assets/js/backend.js' ),
				'deps'    => [ 'jquery' ],
			],
		];
	}

	/**
	 * All available styles
	 *
	 * @since   1.0.0
	 * @return  array
	 */
	public function get_admin_styles() {
		return [
			'seocrawler-admin-style' => [
				'src'     => SEOCRAWL_ASSETS . '/css/backend.css',
				'version' => filemtime( SEOCRAWL_PATH . '/assets/css/backend.css' ),
			],
		];
	}

	/**
	 * Register scripts and styles
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function register_admin_assets() {
		$scripts = $this->get_admin_scripts();
		$styles  = $this->get_admin_styles();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';
			wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';

			wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
		}

		wp_localize_script(
			'seocrawl-admin-script',
			'seocrawl',
			[
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'seocrawl-admin-nonce' ),
			]
		);
	}
}
