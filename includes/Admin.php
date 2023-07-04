<?php
namespace SeoCrawl;

/**
 * The admin class
 */
class Admin {

	/**
	 * Initialize the class
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		$main = new Admin\Main();
		$this->dispatch_actions( $main );

		new Admin\Menu( $main );

	}

	/**
	 * Dispatch and bind actions
	 *
	 * @since   1.0.0
	 * @param   string $main class instance.
	 * @return  void
	 */
	public function dispatch_actions( $main ) {}
}
