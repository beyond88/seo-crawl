<?php
namespace SeoCrawl\Traits;

/**
 * Error handler trait
 */
trait Form_Error {

	/**
	 * Holds the errors
	 *
	 * @var array
	 */
	public $errors = [];

	/**
	 * Check if the form has error
	 *
	 * @since 1.0.0
	 * @param  string $key Check key and return boolean.
	 * @return boolean
	 */
	public function has_error( $key ) {
		return isset( $this->errors[ $key ] ) ? true : false;
	}

	/**
	 * Get the error by key
	 *
	 * @since 1.0.0
	 * @param  key $key Get error following the key.
	 * @return string | false
	 */
	public function get_error( $key ) {
		if ( isset( $this->errors[ $key ] ) ) {
			return $this->errors[ $key ];
		}

		return false;
	}
}
