<?php
/**
 * Template for the Marketplace page (slug: marketplace)
 *
 * @package nftsite
 */

get_header();

$filter         = isset( $_GET['filter'] ) ? sanitize_key( wp_unslash( $_GET['filter'] ) ) : 'all';
$filter         = in_array( $filter, array( 'all', 'listed' ), true ) ? $filter : 'all';
$nft_ids        = nftsite_marketplace_nft_ids( $filter );
$all_count      = count( nftsite_marketplace_nft_ids( 'all' ) );
$listed_count   = count( nftsite_marketplace_nft_ids( 'listed' ) );
$collection_ids = nftsite_marketplace_collection_ids();
$marketplace_url = nftsite_page_url( 'marketplace', 'marketplace' );
?>

<main id="primary" class="site-main marketplace-page">
	<section class="marketplace-hero" aria-labelledby="marketplace-title">
		<div class="container">
			<header class="marketplace-hero__header">
				<h1 id="marketplace-title" class="marketplace-hero__title"><?php esc_html_e( 'Browse Marketplace', 'nftsite' ); ?></h1>
				<p class="marketplace-hero__subtitle">
					<?php
					printf(
						/* translators: 1: total NFTs 2: listed count */
						esc_html__( '%1$d NFTs in catalog · %2$d listed for sale on Sepolia.', 'nftsite' ),
						(int) $all_count,
						(int) $listed_count
					);
					?>
				</p>
			</header>

			<form class="marketplace-search" role="search" action="<?php echo esc_url( $marketplace_url ); ?>" method="get">
				<?php if ( 'listed' === $filter ) : ?>
					<input type="hidden" name="filter" value="listed">
				<?php endif; ?>
				<label class="screen-reader-text" for="marketplace-search-input"><?php esc_html_e( 'Search NFTs', 'nftsite' ); ?></label>
				<input
					id="marketplace-search-input"
					class="marketplace-search__input"
					type="search"
					name="q"
					value="<?php echo isset( $_GET['q'] ) ? esc_attr( wp_unslash( $_GET['q'] ) ) : ''; ?>"
					placeholder="<?php esc_attr_e( 'Search your favourite NFTs', 'nftsite' ); ?>"
					autocomplete="off"
					data-marketplace-search
				>
				<span class="marketplace-search__icon" aria-hidden="true">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
			</form>
		</div>
	</section>

	<section class="marketplace-tabs-section" aria-label="<?php esc_attr_e( 'Marketplace filters', 'nftsite' ); ?>">
		<div class="container">
			<div class="marketplace-status-filters" role="group" aria-label="<?php esc_attr_e( 'Sale status', 'nftsite' ); ?>">
				<a
					class="marketplace-status-filters__btn<?php echo 'all' === $filter ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( $marketplace_url ); ?>"
				><?php esc_html_e( 'All', 'nftsite' ); ?> <span><?php echo esc_html( (string) $all_count ); ?></span></a>
				<a
					class="marketplace-status-filters__btn<?php echo 'listed' === $filter ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( add_query_arg( 'filter', 'listed', $marketplace_url ) ); ?>"
				><?php esc_html_e( 'For sale', 'nftsite' ); ?> <span><?php echo esc_html( (string) $listed_count ); ?></span></a>
			</div>
			<div class="marketplace-tabs" role="tablist">
				<button
					class="marketplace-tabs__btn is-active"
					type="button"
					role="tab"
					id="tab-nfts"
					aria-selected="true"
					aria-controls="panel-nfts"
					data-tab="nfts"
				>
					<span class="marketplace-tabs__label"><?php esc_html_e( 'NFTs', 'nftsite' ); ?></span>
					<span class="marketplace-tabs__count"><?php echo esc_html( (string) count( $nft_ids ) ); ?></span>
				</button>
				<button
					class="marketplace-tabs__btn"
					type="button"
					role="tab"
					id="tab-collections"
					aria-selected="false"
					aria-controls="panel-collections"
					data-tab="collections"
				>
					<span class="marketplace-tabs__label"><?php esc_html_e( 'Collections', 'nftsite' ); ?></span>
					<span class="marketplace-tabs__count"><?php echo esc_html( (string) count( $collection_ids ) ); ?></span>
				</button>
			</div>
		</div>
	</section>

	<section class="marketplace-results">
		<div class="container">
			<div
				class="marketplace-panel is-active"
				id="panel-nfts"
				role="tabpanel"
				aria-labelledby="tab-nfts"
				data-panel="nfts"
			>
				<div class="marketplace-grid marketplace-grid--nfts">
					<?php
					foreach ( $nft_ids as $nid ) {
						$nft = nftsite_get_nft( $nid );
						if ( $nft ) {
							nftsite_render_nft_card( $nft, null, 'marketplace-card' );
						}
					}
					?>
				</div>
				<p class="marketplace-empty" <?php echo empty( $nft_ids ) ? '' : 'hidden'; ?>>
					<?php
					echo 'listed' === $filter
						? esc_html__( 'No NFTs are listed for sale yet. Mint in Studio, then List for sale.', 'nftsite' )
						: esc_html__( 'No NFTs match your search.', 'nftsite' );
					?>
				</p>
			</div>

			<div
				class="marketplace-panel"
				id="panel-collections"
				role="tabpanel"
				aria-labelledby="tab-collections"
				data-panel="collections"
				hidden
			>
				<div class="marketplace-grid marketplace-grid--collections">
					<?php foreach ( $collection_ids as $cid ) : ?>
						<?php
						$collection = nftsite_get_collection( $cid );
						if ( ! $collection ) {
							continue;
						}
						$c_artist = nftsite_get_artist( $collection['artist_id'] );
						$search   = strtolower( $collection['title'] . ' ' . ( $c_artist ? $c_artist['name'] : '' ) );
						?>
						<article class="collection-card marketplace-card reveal" data-search="<?php echo esc_attr( $search ); ?>">
							<a class="collection-card__link" href="<?php echo esc_url( $c_artist ? nftsite_url_artist( $c_artist['id'] ) : nftsite_page_url( 'marketplace' ) ); ?>">
								<div class="collection-card__primary">
									<img
										src="<?php echo esc_url( nftsite_media_url( $collection['primary'] ) ); ?>"
										alt="<?php echo esc_attr( $collection['title'] ); ?>"
										width="410"
										height="410"
										loading="lazy"
									>
								</div>
								<div class="collection-card__thumbs">
									<div class="collection-card__thumb">
										<img src="<?php echo esc_url( nftsite_media_url( $collection['thumb_1'] ) ); ?>" alt="" loading="lazy">
									</div>
									<div class="collection-card__thumb">
										<img src="<?php echo esc_url( nftsite_media_url( $collection['thumb_2'] ) ); ?>" alt="" loading="lazy">
									</div>
									<div class="collection-card__more" aria-hidden="true">
										<span><?php echo esc_html( $collection['extra'] ); ?></span>
									</div>
								</div>
							</a>
							<div class="collection-card__meta">
								<h2 class="collection-card__title"><?php echo esc_html( $collection['title'] ); ?></h2>
								<?php if ( $c_artist ) : ?>
									<div class="collection-card__artist">
										<img
											class="collection-card__avatar"
											src="<?php echo esc_url( nftsite_media_url( $c_artist['avatar_sm'] ) ); ?>"
											alt=""
											width="24"
											height="24"
											loading="lazy"
										>
										<span class="collection-card__artist-name"><?php echo esc_html( $c_artist['name'] ); ?></span>
									</div>
								<?php endif; ?>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
				<p class="marketplace-empty" hidden><?php esc_html_e( 'No collections match your search.', 'nftsite' ); ?></p>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
