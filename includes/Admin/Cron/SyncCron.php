<?php
namespace SeoCrawl\Admin\Cron;

use SeoCrawl\Traits\Singleton;
use SeoCrawl\Admin\Cron\CrawlTask;

class SyncCron {

    /**
     * Use singleton trait
     *
     * @var object
     */
    use Singleton;

    /**
     * Initialize cron class and it all functionalities
     *
     * @since 1.0.0
     * @access public
     * @param none
     * @return void
     */
    public function __construct() {
        add_filter( 'cron_schedules', array( $this, 'seocrawl_add_schedules') );
        add_action( 'seocrawl_sync_schedule', array( $this, 'seocrawl_sync_schedule_fn' ) );
    }

    /**
     * Initialize cron class and it all functionalities
     *
     * @since 1.0.0
     * @access public
     * @param none
     * @return void
     */
    public function seocrawl_add_schedules() {

        if( ! isset( $schedules["seocrawl_sync_5_min"] ) ) {
            $schedules["seocrawl_sync_5_min"] = array(
                'interval' => 5*60,
                'display' => __('Once every 5 minutes'));
        }

        if( ! isset( $schedules["seocrawl_sync_1_min"] )) {
            $schedules["seocrawl_sync_1_min"] = array(
                'interval' => 60,
                'display' => __('Once every 1 minutes'));
        }

        return $schedules;
    }

    /**
     * @throws \Exception
     * TODO:: use single event
     */
    public function seocrawl_sync_schedule_fn() {
        CrawlTask::instance()->crawl_task();
    }

}
