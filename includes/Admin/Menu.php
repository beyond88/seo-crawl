<?php
namespace SeoCrawl\Admin;
use SeoCrawl\Helper;

/**
 * The Menu handler class
 */
class Menu {

    /**
     * Plugin main file
     *
     * @var string
    */
    public $main;

    /**
     * Initialize the class
     *
     * @since   1.0.0
     * @access  public
     * @param   object
     * @return  void
     */
    function __construct( $main ) {
        $this->main = $main;
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Register admin menu
     *
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    public function admin_menu() {
        $parent_slug = 'seocrawl';
        $capability = 'manage_options';
        $icon_url = 'dashicons-admin-site';

        $settings   = apply_filters( 'seocrawl_admin_menu', array() );

        $hook = add_menu_page( __( 'SEO Crawl', 'seo-crawl' ), __( 'SEO Crawl', 'seo-crawl' ), $capability, $parent_slug, [ $this->main, 'plugin_menu_page' ], $icon_url, 50 );
        add_action( 'admin_head-' . $hook, array( $this, 'enqueue_assets' ) );
    }

    /**
     * Enqueue scripts and styles
     *
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'seocrawl-admin-boostrap' );
        wp_enqueue_style( 'seocrawl-admin-style' );
        wp_enqueue_script( 'seocrawl-admin-script' );
    }

}
