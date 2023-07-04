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
	 * @return void
	 */
	public function __construct() {
		add_action( 'seocrawl_sync_schedule', [ $this, 'seocrawl_sync_schedule_fn' ] );
	}

	/**
	 * Call crawl task class and operate
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function seocrawl_sync_schedule_fn() {
		CrawlTask::instance()->crawl_task();
	}

}
