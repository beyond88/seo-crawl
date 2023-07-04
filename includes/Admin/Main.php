<?php
namespace SeoCrawl\Admin;
// use SeoCrawl\Helper as Helpers;

/**
 * Settings Handler class
 */
class Main {

	/**
	 * Settings otpions field
	 *
	 * @var string
	 */
    public $_option_name  = 'seocrawl';

	/**
	 * Settings otpions group field
	 *
	 * @var string
	 */
	public $_option_group = 'seocrawl_options_group';

	/**
	 * Settings otpions field default values
	 *
	 * @var array
	 */
    public $_default_options = array();

    /**
     * Initial the class and its all methods
     *
	 * @since 1.0.0
	 * @access	public
	 * @param	none
     * @return	void
     */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'set_default_options' ) );
		add_action( 'admin_init', array( $this, 'menu_register_settings' ) );
	}

    /**
     * Plugin page handler
     *
	 * @since 1.0.0
	 * @access	public
	 * @param	none
     * @return	void
     */
    public function plugin_menu_page() {

        $template = __DIR__ . '/views/menu-page.php';

        if ( file_exists( $template ) ) {
			$crawl = (array) get_option($this->_option_name);

			$sitemap_url = array_key_exists( 'sitemap_url', $crawl ) ? $crawl['sitemap_url'] : '';
			$links = array_key_exists( 'links', $crawl ) ? $crawl['links'] : [];

            return require_once $template;
        }

		print __('File not found!', 'seo-crawl');
    }

    /**
	 * Save the setting options
	 *
	 * @since	1.0.0
	 * @access 	public
	 * @param	array
	 * @return	void
	 */
	public function menu_register_settings() {
		add_option( $this->_option_name, $this->_default_options );
		register_setting( $this->_option_group, $this->_option_name );
	}

	/**
	 * Apply filter with default options
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function set_default_options() {
		return apply_filters( 'seocrawl_default_options', $this->_default_options );
	}
}
