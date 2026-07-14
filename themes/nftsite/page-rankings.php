<?php
/**
 * Template for the Rankings page (slug: rankings)
 *
 * @package nftsite
 */

get_header();

$creators = nftsite_get_rankings();

$tabs = array(
	array(
		'id'    => 'today',
		'short' => '1d',
		'long'  => __( 'Today', 'nftsite' ),
	),
	array(
		'id'    => 'week',
		'short' => '7d',
		'long'  => __( 'This Week', 'nftsite' ),
	),
	array(
		'id'    => 'month',
		'short' => '30d',
		'long'  => __( 'This Month', 'nftsite' ),
	),
	array(
		'id'    => 'all',
		'short' => __( 'All Time', 'nftsite' ),
		'long'  => __( 'All Time', 'nftsite' ),
	),
);
?>

<main id="primary" class="site-main rankings-page">
	<section class="rankings-hero" aria-labelledby="rankings-title">
		<div class="container">
			<header class="rankings-hero__header">
				<h1 id="rankings-title" class="rankings-hero__title"><?php esc_html_e( 'Top Creators', 'nftsite' ); ?></h1>
				<p class="rankings-hero__subtitle"><?php esc_html_e( 'Check out top ranking NFT artists on the NFT Marketplace.', 'nftsite' ); ?></p>
			</header>

			<div class="rankings-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Timeframe', 'nftsite' ); ?>">
				<?php foreach ( $tabs as $index => $tab ) : ?>
					<button
						class="rankings-tabs__btn<?php echo 0 === $index ? ' is-active' : ''; ?>"
						type="button"
						role="tab"
						id="rankings-tab-<?php echo esc_attr( $tab['id'] ); ?>"
						aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						data-rankings-tab="<?php echo esc_attr( $tab['id'] ); ?>"
					>
						<span class="rankings-tabs__label rankings-tabs__label--short"><?php echo esc_html( $tab['short'] ); ?></span>
						<span class="rankings-tabs__label rankings-tabs__label--long"><?php echo esc_html( $tab['long'] ); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="rankings-table-section" aria-label="<?php esc_attr_e( 'Creator rankings', 'nftsite' ); ?>">
		<div class="container">
			<div class="rankings-table" role="table" data-rankings-table>
				<div class="rankings-table__head" role="row">
					<div class="rankings-col rankings-col--rank" role="columnheader">#</div>
					<div class="rankings-col rankings-col--artist" role="columnheader"><?php esc_html_e( 'Artist', 'nftsite' ); ?></div>
					<div class="rankings-col rankings-col--change" role="columnheader"><?php esc_html_e( 'Change', 'nftsite' ); ?></div>
					<div class="rankings-col rankings-col--sold" role="columnheader"><?php esc_html_e( 'NFTs Sold', 'nftsite' ); ?></div>
					<div class="rankings-col rankings-col--volume" role="columnheader"><?php esc_html_e( 'Volume', 'nftsite' ); ?></div>
				</div>

				<div class="rankings-table__body">
					<?php foreach ( $creators as $index => $row ) : ?>
						<?php
						$rank    = $index + 1;
						$period  = $row['periods']['today'];
						$artist_url = nftsite_url_artist( $row['artist_id'] );
						?>
						<article
							class="rankings-row reveal"
							role="row"
							data-rankings-row
							data-periods="<?php echo esc_attr( wp_json_encode( $row['periods'] ) ); ?>"
						>
							<div class="rankings-col rankings-col--rank" role="cell">
								<span class="rankings-row__rank"><?php echo esc_html( (string) $rank ); ?></span>
							</div>

							<div class="rankings-col rankings-col--artist" role="cell">
								<a class="rankings-row__artist-link" href="<?php echo esc_url( $artist_url ); ?>">
									<img
										class="rankings-row__avatar"
										src="<?php echo esc_url( nftsite_media_url( $row['avatar'] ) ); ?>"
										alt=""
										width="60"
										height="60"
										loading="lazy"
									>
									<span class="rankings-row__name"><?php echo esc_html( $row['name'] ); ?></span>
								</a>
							</div>

							<div class="rankings-col rankings-col--change" role="cell">
								<span class="rankings-row__change" data-rankings-change><?php echo esc_html( $period['change'] ); ?></span>
							</div>

							<div class="rankings-col rankings-col--sold" role="cell">
								<span class="rankings-row__sold" data-rankings-sold><?php echo esc_html( $period['sold'] ); ?></span>
							</div>

							<div class="rankings-col rankings-col--volume" role="cell">
								<span class="rankings-row__volume" data-rankings-volume><?php echo esc_html( $period['volume'] ); ?></span>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
