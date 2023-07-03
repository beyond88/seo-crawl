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
final class SeoCrawl {

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
     * @return \SeoCrawl
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
        define( 'SEOCRAWL_VERSION', self::version );
        define( 'SEOCRAWL_FILE', __FILE__ );
        define( 'SEOCRAWL_PATH', __DIR__ );
        define( 'SEOCRAWL_URL', plugins_url( '', SEOCRAWL_FILE ) );
        define( 'SEOCRAWL_ASSETS', SEOCRAWL_URL . '/assets' );
        define( 'SEOCRAWL_BASENAME', plugin_basename( __FILE__ ) );
        define( 'SEOCRAWL_PLUGIN_NAME', 'SEOCRAWL' );
        define( 'SEOCRAWL_MINIMUM_PHP_VERSION', '7.0' );
        define( 'SEOCRAWL_MINIMUM_WP_VERSION', '5.0' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new SeoCrawl\Assets();
        // new SeoCrawl\SeoCrawli18n();
        // new SeoCrawl\Admin\Cron\SyncCron();

        // if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        //     new SeoCrawl\Ajax();
        // }

        // if ( is_admin() ) {
        //     new SeoCrawl\Admin();
        // }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new SeoCrawl\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function seo_crawl() {
    return SeoCrawl::init();
}

// kick-off the plugin
seo_crawl();
