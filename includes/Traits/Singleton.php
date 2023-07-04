<?php
namespace SeoCrawl\Traits;

trait Singleton {

	/**
	 * Singleton class instance holder
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Make a class instance
	 *
	 * @since 1.0.0
	 * @return static
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {
			self::$instance = new self();

			if ( method_exists( self::$instance, 'boot' ) ) {
				self::$instance->boot();
			}
		}

		return self::$instance;
	}

}
