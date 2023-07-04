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
        add_action( 'seocrawl_sync_schedule', array( $this, 'seocrawl_sync_schedule_fn' ) );
    }

    /**
     * @throws \Exception
     * TODO:: use single event
     */
    public function seocrawl_sync_schedule_fn() {
        CrawlTask::instance()->crawl_task();
    }

}
