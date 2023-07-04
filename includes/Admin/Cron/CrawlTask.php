<?php
namespace SeoCrawl\Admin\Cron;

use SeoCrawl\Traits\Singleton;

class CrawlTask {

    /**
     *
     * @var object
     */
    use Singleton;

    /**
	 * Settings otpions field
	 *
	 * @var string
	 */
    public $_option_name  = 'seocrawl';

    /**
     * Intiliaze the crawl task class
     *
     */
    function __construct() {}

    /**
     * Crawl task method to retrieve all links
     *
     * @since 1.0.0
     * @access public
     * @param none
     * @return void
     */
    public function crawl_task() {

        delete_option($this->_option_name);

        $sitemap_path = ABSPATH . 'sitemap.html';
        if ( file_exists( $sitemap_path ) ) {
            unlink( $sitemap_path );
        }

        // Start at the website's root URL (home page)
        $home_url = get_home_url();

        // Extract all internal hyperlinks
        $results = (array) $this->crawl_links( $home_url );

        // Save the home page's .php file as a .html file
        $home_php_path = ABSPATH . 'index.php';
        $home_html_path = ABSPATH . 'index.html';
        copy($home_php_path, $home_html_path);

        // Create a sitemap.html file that shows the results as a sitemap list structure
        $sitemap_content = '<ul>';
        foreach ($results as $result) {
            $sitemap_content .= '<li>' . esc_html($result) . '</li>';
        }
        $sitemap_content .= '</ul>';
        file_put_contents($sitemap_path, $sitemap_content);

        // Store results temporarily in the database
        $data['sitemap_url'] = site_url('sitemap.html');
        $data['links'] = $results;
        update_option($this->_option_name, $data);

    }

    /**
     * Crawl task method to retrieve all links
     *
     * @since 1.0.0
     * @access public
     * @param none
     * @return void
     */
    private function crawl_links( $url ) {

        $results = array();

        $response = wp_remote_get($url);

        if ( is_wp_error( $response ) ) {
            return $results;
        }

        // Example code to extract links using DOM parsing
        $html = wp_remote_retrieve_body( $response );
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $anchors = $dom->getElementsByTagName('a');

        foreach ( $anchors as $anchor ) {
            $href = $anchor->getAttribute('href');
            if ( strpos($href, home_url()) !== false ) {
                $results[] = $href;
            }
        }

        return $results;
    }

}
