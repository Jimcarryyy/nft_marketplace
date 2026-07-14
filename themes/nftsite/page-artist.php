<?php
/**
 * Template for the Artist page (slug: artist)
 *
 * @package nftsite
 */

get_header();

$artist         = nftsite_current_artist( 'animakid' );
$created_ids    = isset( $artist['created'] ) ? (array) $artist['created'] : array();
$owned_ids      = isset( $artist['owned'] ) ? (array) $artist['owned'] : array();
$collection_ids = isset( $artist['collection'] ) ? (array) $artist['collection'] : array();
$created_count  = isset( $artist['created_count'] ) ? (int) $artist['created_count'] : count( $created_ids );
$owned_count    = isset( $artist['owned_count'] ) ? (int) $artist['owned_count'] : count( $owned_ids );
$collection_count = isset( $artist['collection_count'] ) ? (int) $artist['collection_count'] : count( $collection_ids );
$is_own_profile = is_user_logged_in()
	&& ! empty( $artist['user_id'] )
	&& (int) $artist['user_id'] === get_current_user_id();
$profile_url    = nftsite_page_url( 'create-account', 'signup' );
$website        = ! empty( $artist['website'] ) ? (string) $artist['website'] : '';
?>

<main id="primary" class="site-main artist-page">
	<section class="artist-banner" aria-hidden="true">
		<img
			src="<?php echo esc_url( nftsite_media_url( $artist['banner'] ) ); ?>"
			alt=""
			width="1280"
			height="320"
			loading="eager"
		>
	</section>

	<section class="artist-profile" aria-labelledby="artist-name">
		<div class="container">
			<div class="artist-profile__avatar-wrap">
				<img
					class="artist-profile__avatar"
					src="<?php echo esc_url( nftsite_media_url( $artist['avatar'] ) ); ?>"
					alt="<?php echo esc_attr( sprintf( __( '%s profile', 'nftsite' ), $artist['name'] ) ); ?>"
					width="120"
					height="120"
					loading="eager"
				>
			</div>

			<div class="artist-profile__top">
				<h1 id="artist-name" class="artist-profile__name"><?php echo esc_html( $artist['name'] ); ?></h1>

				<div class="artist-profile__actions">
					<?php if ( $is_own_profile ) : ?>
						<a class="btn btn--secondary artist-profile__edit" href="<?php echo esc_url( $profile_url ); ?>">
							<?php esc_html_e( 'Edit profile', 'nftsite' ); ?>
						</a>
					<?php endif; ?>

					<button
						class="btn btn--secondary artist-profile__wallet"
						type="button"
						data-copy-wallet="<?php echo esc_attr( $artist['wallet'] ); ?>"
						aria-label="<?php esc_attr_e( 'Copy wallet address', 'nftsite' ); ?>"
					>
						<span class="btn__icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M13.3333 10.8333V14.1667C13.3333 16.6667 12.3333 17.6667 9.83333 17.6667H5.83333C3.33333 17.6667 2.33333 16.6667 2.33333 14.1667V10.1667C2.33333 7.66667 3.33333 6.66667 5.83333 6.66667H9.16667" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M13.3333 10.8333H10.8333C9.16666 10.8333 9.16666 10 9.16666 9.16667V6.66667L13.3333 10.8333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.99999 2.33334H13.1667C15.6667 2.33334 16.6667 3.33334 16.6667 5.83334V9.00001" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<span class="artist-profile__wallet-text"><?php echo esc_html( $artist['wallet_short'] ); ?></span>
					</button>

					<?php if ( ! $is_own_profile ) : ?>
						<button
							class="btn btn--secondary btn--outline artist-profile__follow"
							type="button"
							data-follow-artist="<?php echo esc_attr( $artist['id'] ); ?>"
						>
							<span class="btn__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
									<path d="M4.16666 10H15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
								</svg>
							</span>
							<span class="artist-profile__follow-text"><?php esc_html_e( 'Follow', 'nftsite' ); ?></span>
						</button>
					<?php endif; ?>
				</div>
			</div>

			<dl class="artist-profile__stats">
				<div>
					<dt class="artist-profile__stat-value"><?php echo esc_html( $artist['volume'] ); ?></dt>
					<dd class="artist-profile__stat-label"><?php esc_html_e( 'Volume', 'nftsite' ); ?></dd>
				</div>
				<div>
					<dt class="artist-profile__stat-value"><?php echo esc_html( $artist['nfts_sold'] ); ?></dt>
					<dd class="artist-profile__stat-label"><?php esc_html_e( 'NFTs Sold', 'nftsite' ); ?></dd>
				</div>
				<div>
					<dt class="artist-profile__stat-value"><?php echo esc_html( $artist['followers'] ); ?></dt>
					<dd class="artist-profile__stat-label"><?php esc_html_e( 'Followers', 'nftsite' ); ?></dd>
				</div>
			</dl>

			<div class="artist-profile__bio">
				<h2 class="artist-profile__label"><?php esc_html_e( 'Bio', 'nftsite' ); ?></h2>
				<p><?php echo esc_html( $artist['bio'] ?: __( 'No bio yet.', 'nftsite' ) ); ?></p>
			</div>

			<div class="artist-profile__links">
				<h2 class="artist-profile__label"><?php esc_html_e( 'Links', 'nftsite' ); ?></h2>
				<ul class="artist-profile__social">
					<?php if ( $website ) : ?>
						<li>
							<a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Website', 'nftsite' ); ?>">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M16 28C22.6274 28 28 22.6274 28 16C28 9.37258 22.6274 4 16 4C9.37258 4 4 9.37258 4 16C4 22.6274 9.37258 28 16 28Z" stroke="currentColor" stroke-width="2"/><path d="M4 16H28" stroke="currentColor" stroke-width="2"/><path d="M16 4C18.5 8.5 20 12 20 16C20 20 18.5 23.5 16 28C13.5 23.5 12 20 12 16C12 12 13.5 8.5 16 4Z" stroke="currentColor" stroke-width="2"/></svg>
							</a>
						</li>
					<?php else : ?>
						<li><span class="artist-profile__nolink"><?php esc_html_e( 'No links added', 'nftsite' ); ?></span></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</section>

	<section class="artist-tabs-section" aria-label="<?php esc_attr_e( 'Artist content', 'nftsite' ); ?>">
		<div class="container">
			<div class="artist-tabs" role="tablist">
				<button class="artist-tabs__btn is-active" type="button" role="tab" aria-selected="true" aria-controls="artist-panel-created" data-artist-tab="created" id="artist-tab-created">
					<span><?php esc_html_e( 'Created', 'nftsite' ); ?></span>
					<span class="artist-tabs__count"><?php echo esc_html( (string) $created_count ); ?></span>
				</button>
				<button class="artist-tabs__btn" type="button" role="tab" aria-selected="false" aria-controls="artist-panel-owned" data-artist-tab="owned" id="artist-tab-owned">
					<span><?php esc_html_e( 'Owned', 'nftsite' ); ?></span>
					<span class="artist-tabs__count"><?php echo esc_html( (string) $owned_count ); ?></span>
				</button>
				<button class="artist-tabs__btn" type="button" role="tab" aria-selected="false" aria-controls="artist-panel-collection" data-artist-tab="collection" id="artist-tab-collection">
					<span><?php esc_html_e( 'Collection', 'nftsite' ); ?></span>
					<span class="artist-tabs__count"><?php echo esc_html( (string) $collection_count ); ?></span>
				</button>
			</div>
		</div>
	</section>

	<section class="artist-works">
		<div class="container">
			<?php
			$panels = array(
				'created'    => $created_ids,
				'owned'      => $owned_ids,
				'collection' => $collection_ids,
			);
			$first = true;
			foreach ( $panels as $panel_id => $ids ) :
				?>
				<div
					class="artist-panel<?php echo $first ? ' is-active' : ''; ?>"
					id="artist-panel-<?php echo esc_attr( $panel_id ); ?>"
					role="tabpanel"
					aria-labelledby="artist-tab-<?php echo esc_attr( $panel_id ); ?>"
					data-artist-panel="<?php echo esc_attr( $panel_id ); ?>"
					<?php echo $first ? '' : 'hidden'; ?>
				>
					<div class="artist-works__grid">
						<?php if ( empty( $ids ) ) : ?>
							<p class="artist-works__empty">
								<?php
								if ( 'created' === $panel_id ) {
									esc_html_e( 'No created NFTs yet.', 'nftsite' );
								} elseif ( 'owned' === $panel_id ) {
									esc_html_e( 'No owned NFTs yet.', 'nftsite' );
								} else {
									esc_html_e( 'No collections yet.', 'nftsite' );
								}
								?>
							</p>
						<?php else : ?>
							<?php
							foreach ( $ids as $item_id ) {
								if ( 'collection' === $panel_id ) {
									$col = nftsite_get_collection( $item_id );
									if ( ! $col ) {
										continue;
									}
									?>
									<article class="collection-card reveal">
										<a class="collection-card__link" href="<?php echo esc_url( nftsite_page_url( 'marketplace' ) ); ?>">
											<div class="collection-card__primary">
												<img src="<?php echo esc_url( nftsite_media_url( $col['primary'] ) ); ?>" alt="<?php echo esc_attr( $col['title'] ); ?>" loading="lazy">
											</div>
										</a>
										<div class="collection-card__meta">
											<h3 class="collection-card__title"><?php echo esc_html( $col['title'] ); ?></h3>
											<p class="collection-card__artist-name"><?php echo esc_html( $col['extra'] ); ?> <?php esc_html_e( 'items', 'nftsite' ); ?></p>
										</div>
									</article>
									<?php
								} else {
									$nft = nftsite_get_nft( $item_id );
									if ( $nft ) {
										nftsite_render_nft_card( $nft, $artist );
									}
								}
							}
							?>
						<?php endif; ?>
					</div>
				</div>
				<?php
				$first = false;
			endforeach;
			?>
		</div>
	</section>
</main>

<?php
get_footer();
