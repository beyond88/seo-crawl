<div class="wrap">
	<div class="seo-crawl-margin-bottom-20">
		<h1 class="wp-heading-inline seo-crawl-margin-bottom-10">
			<?php echo esc_html__( 'SEO Crawl', 'seo-crawl' ); ?>
		</h1>

		<button type="button" name="start-crawl" id="start-crawl" class="button button-primary button-large seo-crawl-margin-right-20">
			<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
			&nbsp;
			<?php echo esc_html__( 'Start Crawl', 'seo-crawl' ); ?>
		</button>

		<?php
			$seocrawl_style = 'none;';
		if ( wp_next_scheduled( 'seocrawl_sync_schedule' ) ) :
			$seocrawl_style = 'inline-block;';
			endif;
		?>

		<button type="button" name="stop-crawling" id="stop-crawling" class="button button-primary button-large seo-crawl-margin-right-20" style="display:<?php echo esc_attr( $seocrawl_style ); ?>">
			<?php echo esc_html__( 'Stop Crawling', 'seo-crawl' ); ?>
		</button>

		<?php if ( ! empty( $sitemap_url ) ) : ?>
		<a href="<?php echo esc_url( $sitemap_url ); ?>" id="view-sitemap" class="button button-primary button-large" target="_blank">
			<?php echo esc_html__( 'View Sitemap', 'seo-crawl' ); ?>
		</a>
		<?php endif; ?>

		<div class="seo-crawl-status"></div>
	</div>

	<div class="">
		<h2>
			<?php echo esc_html__( 'Crawl Results', 'seo-crawl' ); ?>
		</h2>

		<div class="seo-crawl-results">
			<?php
			if ( ! empty( $links ) ) {
				echo '<ul>';
				foreach ( $links as $seocrawl_link ) {
					echo '<li><a href=' . esc_url( $seocrawl_link ) . ' target="_blank">' . esc_html( $seocrawl_link ) . '</a></li>';
				}
					echo '</ul>';
			} else {
				echo '<p>No results found.</p>';
			}
			?>
		</div>
	</div>

</div>
