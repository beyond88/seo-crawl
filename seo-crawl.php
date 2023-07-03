<?php
/**
 * Plugin Name: SEO Crawl
 * Description: Crawl and check seo rating.
 * Plugin URI: https://github.com/beyond88/seo-crawl
 * Author: Mohiuddin Abdul Kader
 * Author URI: https://github.com/beyond88
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       seo-crawl
 * Domain Path:       /languages
 * Requires PHP:      7.0
 * Requires at least: 5.0
 * Tested up to:      6.2
 * @package SeoCrawl
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class SeoCrawler {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.0';

    /**
     * Class constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

    }

    /**
     * Initializes a singleton instance
     *
     * @return \SeoCrawler
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'SEOCRAWLER_VERSION', self::version );
        define( 'SEOCRAWLER_FILE', __FILE__ );
        define( 'SEOCRAWLER_PATH', __DIR__ );
        define( 'SEOCRAWLER_URL', plugins_url( '', SEOCRAWLER_FILE ) );
        define( 'SEOCRAWLER_ASSETS', SEOCRAWLER_URL . '/assets' );
        define( 'SEOCRAWLER_BASENAME', plugin_basename( __FILE__ ) );
        define( 'SEOCRAWLER_PLUGIN_NAME', 'SEOCRAWLER' );
        define( 'SEOCRAWLER_MINIMUM_PHP_VERSION', '7.0' );
        define( 'SEOCRAWLER_MINIMUM_WP_VERSION', '5.0' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new SeoCrawler\Assets();
        new SeoCrawler\SeoCrawleri18n();
        new SeoCrawler\Admin\Cron\SyncCron();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new SeoCrawler\Ajax();
        }

        if ( is_admin() ) {
            new SeoCrawler\Admin();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new SeoCrawler\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function seo_crawler() {
    return SeoCrawler::init();
}

// kick-off the plugin
seo_crawler();
