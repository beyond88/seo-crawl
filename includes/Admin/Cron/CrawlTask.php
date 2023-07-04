<?php
namespace SeoCrawl\Admin\Cron;

use SeoCrawl\Traits\Singleton;

class CrawlTask {

	/**
	 * Use singleton traits
	 *
	 * @var object
	 */
	use Singleton;

	/**
	 * Settings otpions field
	 *
	 * @var string
	 */
	public $option_name = 'seo_crawl';

	/**
	 * Intiliaze the crawl task class
	 */
	public function __construct() {}

	/**
	 * Crawl task method to retrieve all links
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function crawl_task() {

		WP_Filesystem();
		global $wp_filesystem;
		delete_option( $this->option_name );

		$sitemap_path = ABSPATH . 'sitemap.html';
		if ( file_exists( $sitemap_path ) ) {
			unlink( $sitemap_path );
		}

		// Start at the website's root URL (home page).
		$home_url = get_home_url();

		// Extract all internal hyperlinks.
		$results = (array) $this->crawl_links( $home_url );

		// Save the home page's .php file as a .html file.
		$home_php_path  = ABSPATH . 'index.php';
		$home_html_path = ABSPATH . 'index.html';
		copy( $home_php_path, $home_html_path );

		// Create a sitemap.html file that shows the results as a sitemap list structure.
		$sitemap_content = '<ul>';
		foreach ( $results as $result ) {
			$sitemap_content .= '<li>' . esc_html( $result ) . '</li>';
		}
		$sitemap_content .= '</ul>';
		$wp_filesystem->put_contents( $sitemap_path, $sitemap_content );

		// Store results temporarily in the database.
		$data['sitemap_url'] = site_url( 'sitemap.html' );
		$data['links']       = $results;
		update_option( $this->option_name, $data );

	}

	/**
	 * Crawl task method to retrieve all links
	 *
	 * @since 1.0.0
	 * @param string $url Pass the link and prepare for document.
	 * @return string
	 */
	private function crawl_links( $url ) {

		$results = [];
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return $results;
		}

		// Example code to extract links using DOM parsing.
		$html = wp_remote_retrieve_body( $response );
		$dom  = new \DOMDocument();
		libxml_use_internal_errors(true); // Enable internal error handling.
		$success = $dom->loadHTML( $html );
		if ( ! $success ) {
			// Handle the error.
			$errors = libxml_get_errors(); // Get the XML errors.
			libxml_clear_errors(); // Clear the error buffer.

			$wp_error = new \WP_Error();

			foreach ($errors as $error) {
				// Add each error to the WP_Error object.
				$wp_error->add('dom_error', $error->message);
			}

			// Display or log the errors.
			if ( $wp_error->get_error_messages() ) {

				foreach ($wp_error->get_error_messages() as $message) {
					$results[] = esc_html( $message );
				}

				return $results;
			}

		}

		$anchors = $dom->getElementsByTagName( 'a' );
		foreach ( $anchors as $anchor ) {
			$href = $anchor->getAttribute( 'href' );
			if ( strpos( $href, home_url() ) !== false ) {
				$results[] = $href;
			}
		}

		return $results;
	}

}
