<?php
namespace SeoCrawl;

use SeoCrawl\Admin\Cron\CrawlTask;

/**
 * Ajax handler class
 */
class Ajax {

    /**
     * Class constructor
     */
    public function __construct() {
        add_action( 'wp_ajax_do_crawl_process', array( $this, 'do_crawl_process') );
        add_action( 'wp_ajax_nopriv_do_crawl_process', array( $this, 'do_crawl_process') );

        add_action( 'wp_ajax_stop_sync_crawling', array( $this, 'stop_sync_crawling') );
        add_action( 'wp_ajax_nopriv_stop_sync_crawling', array( $this, 'stop_sync_crawling') );
    }

    /**
     * Crawl and collect all information immediately
     *
     * @since 1.0.0
     * @access public
     * @param string|array
     * @return void
     */
    public function do_crawl_process() {

        check_ajax_referer( 'seocrawl-admin-nonce', 'security');

        if( ! empty( $_POST ) ) {

            try {

                if( ! wp_next_scheduled( 'seocrawl_sync_schedule' ) ) {
                    wp_schedule_event( time(), 'seocrawl_sync_1_min', 'seocrawl_sync_schedule' );
                }

                CrawlTask::instance()->crawl_task();
                wp_send_json_success(
                    "<p class='seocrawl_success'>" . __('Crawling is completed!', 'seo-crawler') . "</p>",
                    200
                );
            } catch(\Exception $e) {
                wp_send_json_error( $e->getMessage(),
                    200
                );
            }

        } else {
            wp_send_json_error(
                __('Something went wrong!', 'seo-crawler'),
                200
            );
        }

        wp_die();

    }

    /**
     * Stop crawling
     *
     * @since 1.0.0
     * @access public
     * @param string|array
     * @return void
     */
    public function stop_sync_crawling() {

        check_ajax_referer( 'seocrawl-admin-nonce', 'security');

        wp_clear_scheduled_hook('seocrawl_sync_schedule');
        wp_send_json_success(
            "",
            200
        );
    }
}
