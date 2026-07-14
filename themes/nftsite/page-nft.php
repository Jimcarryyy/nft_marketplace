<?php
/**
 * Template for the NFT detail page (slug: nft)
 *
 * @package nftsite
 */

get_header();

$nft         = nftsite_current_nft( 'the-orbitians' );
$artist      = nftsite_get_artist( $nft['artist_id'] );
$artist_url  = $artist ? nftsite_url_artist( $artist['id'] ) : nftsite_page_url( 'artist', 'artist' );
$related_ids = array();
if ( $artist && ! empty( $artist['created'] ) ) {
	foreach ( $artist['created'] as $rid ) {
		if ( $rid !== $nft['id'] ) {
			$related_ids[] = $rid;
		}
		if ( count( $related_ids ) >= 9 ) {
			break;
		}
	}
}

$post_id     = isset( $nft['post_id'] ) ? (int) $nft['post_id'] : 0;
$token_id    = isset( $nft['token_id'] ) ? (string) $nft['token_id'] : '';
$price_eth   = isset( $nft['price_eth'] ) ? (string) $nft['price_eth'] : preg_replace( '/[^0-9.]/', '', $nft['price'] ?? '0' );
$listing     = isset( $nft['listing'] ) ? $nft['listing'] : null;
$is_listed   = $listing && ! empty( $listing['price_eth'] );
$list_price  = $is_listed ? (string) $listing['price_eth'] : $price_eth;
$contract    = isset( $nft['contract'] ) ? (string) $nft['contract'] : (string) get_option( 'nftsite_nft_contract', '' );
$status      = strtolower( (string) ( $nft['status'] ?? 'minted' ) );
$owner       = strtolower( (string) ( $nft['owner_wallet'] ?? '' ) );
$user_wallet = is_user_logged_in() ? strtolower( (string) get_user_meta( get_current_user_id(), 'nftsite_wallet', true ) ) : '';
$is_owner    = ( $owner && $user_wallet && $owner === $user_wallet );
$studio_url  = nftsite_page_url( 'studio', 'studio' );
$etherscan   = ( $contract && $token_id )
	? 'https://sepolia.etherscan.io/token/' . rawurlencode( $contract ) . '?a=' . rawurlencode( $token_id )
	: ( $contract ? 'https://sepolia.etherscan.io/address/' . rawurlencode( $contract ) : '' );
$mint_tx     = $post_id && class_exists( 'NFTSite_Core_Meta' )
	? (string) NFTSite_Core_Meta::get( $post_id, 'mint_tx', '' )
	: '';
$tx_url      = $mint_tx ? 'https://sepolia.etherscan.io/tx/' . rawurlencode( $mint_tx ) : '';
$royalty_bps = isset( $nft['royalty_bps'] ) ? (int) $nft['royalty_bps'] : 500;
$desc        = isset( $nft['description'] ) ? (array) $nft['description'] : array();
if ( empty( $desc ) && ! empty( $nft['title'] ) ) {
	$desc = array( $nft['title'] );
}

$activity = array();
if ( $post_id && class_exists( 'NFTSite_Core_Meta' ) ) {
	$aq = new WP_Query(
		array(
			'post_type'      => 'nftsite_activity',
			'post_status'    => 'publish',
			'posts_per_page' => 8,
			'meta_key'       => '_nftsite_nft_id',
			'meta_value'     => (string) $post_id,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	foreach ( $aq->posts as $act ) {
		$type = (string) NFTSite_Core_Meta::get( $act->ID, 'type', $act->post_title );
		if ( 'bid' === strtolower( $type ) ) {
			continue;
		}
		$activity[] = array(
			'type'   => $type,
			'tx'     => (string) NFTSite_Core_Meta::get( $act->ID, 'tx_hash', '' ),
			'amount' => (string) NFTSite_Core_Meta::get( $act->ID, 'amount_eth', '' ),
			'when'   => get_the_date( '', $act ),
		);
	}
}

/**
 * Render commerce sidebar based on real listing / ownership state.
 *
 * @param string $mod Class modifier.
 */
$render_commerce = static function ( $mod ) use (
	$post_id,
	$token_id,
	$list_price,
	$is_listed,
	$royalty_bps,
	$is_owner,
	$status,
	$studio_url,
	$owner
) {
	?>
	<aside
		class="nft-auction nft-commerce nft-auction--<?php echo esc_attr( $mod ); ?>"
		data-nft-commerce
		aria-label="<?php esc_attr_e( 'Purchase', 'nftsite' ); ?>"
	>
		<?php if ( $is_owner && $is_listed && $token_id ) : ?>
			<p class="nft-auction__label"><?php esc_html_e( 'Listed by you', 'nftsite' ); ?></p>
			<p class="nft-auction__price"><?php echo esc_html( $list_price ); ?> ETH</p>
			<p class="nft-auction__hint"><?php esc_html_e( 'Buyers can purchase this listing on Sepolia. Manage it from Studio.', 'nftsite' ); ?></p>
			<div class="nft-commerce__actions">
				<a class="btn btn--secondary nft-auction__cta" href="<?php echo esc_url( $studio_url ); ?>">
					<?php esc_html_e( 'Open Studio', 'nftsite' ); ?>
				</a>
			</div>

		<?php elseif ( $is_owner && $token_id ) : ?>
			<p class="nft-auction__label"><?php esc_html_e( 'You own this NFT', 'nftsite' ); ?></p>
			<p class="nft-auction__hint"><?php esc_html_e( 'It is not listed for sale. Set a price to put it on the market.', 'nftsite' ); ?></p>
			<div class="nft-commerce__actions">
				<button
					class="btn btn--secondary nft-auction__cta"
					type="button"
					data-studio-list
					data-nft-post="<?php echo esc_attr( (string) $post_id ); ?>"
					data-token-id="<?php echo esc_attr( $token_id ); ?>"
				>
					<?php esc_html_e( 'List for sale', 'nftsite' ); ?>
				</button>
				<a class="btn btn--outline nft-auction__cta nft-auction__cta--ghost" href="<?php echo esc_url( $studio_url ); ?>">
					<?php esc_html_e( 'Open Studio', 'nftsite' ); ?>
				</a>
			</div>

		<?php elseif ( $is_listed && $token_id ) : ?>
			<p class="nft-auction__label"><?php esc_html_e( 'Buy now', 'nftsite' ); ?></p>
			<p class="nft-auction__price"><?php echo esc_html( $list_price ); ?> ETH</p>
			<p class="nft-auction__royalty">
				<?php
				printf(
					/* translators: %s: royalty percent */
					esc_html__( 'Creator royalty: %s%%', 'nftsite' ),
					esc_html( number_format( $royalty_bps / 100, 1 ) )
				);
				?>
			</p>
			<div class="nft-commerce__actions">
				<button
					class="btn btn--secondary nft-auction__cta"
					type="button"
					data-buy-nft
					data-nft-post="<?php echo esc_attr( (string) $post_id ); ?>"
					data-token-id="<?php echo esc_attr( $token_id ); ?>"
					data-price-eth="<?php echo esc_attr( $list_price ); ?>"
					data-owner-wallet="<?php echo esc_attr( $owner ); ?>"
				>
					<?php esc_html_e( 'Buy NFT', 'nftsite' ); ?>
				</button>
			</div>

		<?php elseif ( 'sold' === $status ) : ?>
			<p class="nft-auction__label"><?php esc_html_e( 'Sold', 'nftsite' ); ?></p>
			<p class="nft-auction__hint"><?php esc_html_e( 'This NFT is no longer listed. Ask the owner to list it again from Studio.', 'nftsite' ); ?></p>

		<?php else : ?>
			<p class="nft-auction__label"><?php esc_html_e( 'Not for sale', 'nftsite' ); ?></p>
			<p class="nft-auction__hint">
				<?php
				echo $token_id
					? esc_html__( 'Minted on Sepolia but not listed yet.', 'nftsite' )
					: esc_html__( 'This item is not available to buy.', 'nftsite' );
				?>
			</p>
		<?php endif; ?>
		<div class="nft-commerce__status">
			<span class="tx-pill" data-tx-status hidden></span>
			<p class="nft-commerce__txlink" data-tx-explorer hidden></p>
		</div>
	</aside>
	<?php
};
?>

<main id="primary" class="site-main nft-page" <?php echo $post_id ? 'data-nft-post-id="' . esc_attr( (string) $post_id ) . '"' : ''; ?>>
	<section class="nft-hero" aria-label="<?php esc_attr_e( 'NFT artwork', 'nftsite' ); ?>">
		<img
			class="nft-hero__image"
			src="<?php echo esc_url( nftsite_media_url( $nft['hero'] ?: $nft['image'] ) ); ?>"
			alt="<?php echo esc_attr( $nft['title'] ); ?>"
			width="1280"
			height="560"
			loading="eager"
		>
	</section>

	<section class="nft-detail" aria-labelledby="nft-title">
		<div class="container nft-detail__grid">
			<div class="nft-detail__main">
				<header class="nft-detail__header">
					<h1 id="nft-title" class="nft-detail__title"><?php echo esc_html( $nft['title'] ); ?></h1>
					<p class="nft-detail__minted"><?php echo esc_html( $nft['minted'] ?: __( 'Minted on Sepolia', 'nftsite' ) ); ?></p>
					<?php if ( ! empty( $status ) ) : ?>
						<p class="tx-pill"><?php echo esc_html( ucfirst( $status ) ); ?><?php echo $token_id ? ' · #' . esc_html( $token_id ) : ''; ?></p>
					<?php endif; ?>
				</header>

				<?php $render_commerce( 'mobile' ); ?>

				<div class="nft-detail__created">
					<h2 class="nft-detail__section-label"><?php esc_html_e( 'Created By', 'nftsite' ); ?></h2>
					<a class="nft-detail__creator" href="<?php echo esc_url( $artist_url ); ?>">
						<img
							src="<?php echo esc_url( nftsite_media_url( $artist ? ( $artist['avatar_sm'] ?: $artist['avatar'] ) : 'images/avatars/orbitian.png' ) ); ?>"
							alt=""
							width="24"
							height="24"
							loading="lazy"
						>
						<span><?php echo esc_html( $artist ? $artist['name'] : '' ); ?></span>
					</a>
				</div>

				<div class="nft-detail__description">
					<h2 class="nft-detail__section-label"><?php esc_html_e( 'Description', 'nftsite' ); ?></h2>
					<div class="nft-detail__prose">
						<?php foreach ( $desc as $para ) : ?>
							<p><?php echo esc_html( $para ); ?></p>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="nft-detail__details">
					<h2 class="nft-detail__section-label"><?php esc_html_e( 'Details', 'nftsite' ); ?></h2>
					<ul class="nft-detail__links">
						<li>
							<?php if ( $etherscan ) : ?>
								<a href="<?php echo esc_url( $etherscan ); ?>" target="_blank" rel="noopener noreferrer">
							<?php else : ?>
								<a href="#" data-toast-soon>
							<?php endif; ?>
								<span class="nft-detail__link-icon" aria-hidden="true">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="1.5"/>
										<path d="M3 12H21" stroke="currentColor" stroke-width="1.5"/>
										<path d="M12 3C14.5 6 15.5 9 15.5 12C15.5 15 14.5 18 12 21C9.5 18 8.5 15 8.5 12C8.5 9 9.5 6 12 3Z" stroke="currentColor" stroke-width="1.5"/>
									</svg>
								</span>
								<?php esc_html_e( 'View on Etherscan', 'nftsite' ); ?>
							</a>
						</li>
						<?php if ( $tx_url ) : ?>
							<li>
								<a href="<?php echo esc_url( $tx_url ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="nft-detail__link-icon" aria-hidden="true">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="1.5"/>
											<path d="M3 12H21" stroke="currentColor" stroke-width="1.5"/>
										</svg>
									</span>
									<?php esc_html_e( 'Mint transaction', 'nftsite' ); ?>
								</a>
							</li>
						<?php endif; ?>
						<li>
							<?php if ( ! empty( $nft['metadata_uri'] ) ) : ?>
								<a href="<?php echo esc_url( $nft['metadata_uri'] ); ?>" target="_blank" rel="noopener noreferrer">
							<?php else : ?>
								<a href="#" data-toast-soon>
							<?php endif; ?>
								<span class="nft-detail__link-icon" aria-hidden="true">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="1.5"/>
										<path d="M3 12H21" stroke="currentColor" stroke-width="1.5"/>
										<path d="M12 3C14.5 6 15.5 9 15.5 12C15.5 15 14.5 18 12 21C9.5 18 8.5 15 8.5 12C8.5 9 9.5 6 12 3Z" stroke="currentColor" stroke-width="1.5"/>
									</svg>
								</span>
								<?php esc_html_e( 'View metadata', 'nftsite' ); ?>
							</a>
						</li>
					</ul>
				</div>

				<?php if ( $activity ) : ?>
					<div class="nft-detail__activity">
						<h2 class="nft-detail__section-label"><?php esc_html_e( 'Activity', 'nftsite' ); ?></h2>
						<ul class="nft-activity">
							<?php foreach ( $activity as $row ) : ?>
								<li class="nft-activity__row">
									<span class="nft-activity__type"><?php echo esc_html( ucfirst( $row['type'] ) ); ?></span>
									<?php if ( $row['amount'] ) : ?>
										<span class="nft-activity__amount"><?php echo esc_html( $row['amount'] ); ?> ETH</span>
									<?php endif; ?>
									<span class="nft-activity__when"><?php echo esc_html( $row['when'] ); ?></span>
									<?php if ( $row['tx'] ) : ?>
										<a class="nft-activity__tx" href="<?php echo esc_url( 'https://sepolia.etherscan.io/tx/' . rawurlencode( $row['tx'] ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Tx', 'nftsite' ); ?></a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<div class="nft-detail__tags">
					<h2 class="nft-detail__section-label"><?php esc_html_e( 'Tags', 'nftsite' ); ?></h2>
					<ul class="nft-tags">
						<?php foreach ( (array) ( $nft['tags'] ?? array() ) as $tag ) : ?>
							<li><a class="nft-tags__item" href="<?php echo esc_url( nftsite_page_url( 'marketplace', 'marketplace' ) ); ?>"><?php echo esc_html( $tag ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<?php $render_commerce( 'desktop' ); ?>
		</div>
	</section>

	<section class="nft-more section-block" aria-labelledby="nft-more-title">
		<div class="container">
			<header class="nft-more__header">
				<h2 id="nft-more-title" class="nft-more__title"><?php esc_html_e( 'More From This Artist', 'nftsite' ); ?></h2>
				<a class="btn btn--secondary btn--outline nft-more__cta nft-more__cta--desktop" href="<?php echo esc_url( $artist_url ); ?>">
					<?php esc_html_e( 'Go To Artist Page', 'nftsite' ); ?>
					<span class="btn__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.16666 10H15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10.8333 5L15.8333 10L10.8333 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
				</a>
			</header>

			<div class="nft-more__grid">
				<?php foreach ( $related_ids as $index => $rid ) : ?>
					<?php
					$related = nftsite_get_nft( $rid );
					if ( ! $related ) {
						continue;
					}
					$extra = 'nft-more__card';
					if ( $index >= 6 ) {
						$extra .= ' nft-more__card--desktop-only';
					}
					if ( $index >= 2 ) {
						$extra .= ' nft-more__card--hide-mobile-early';
					}
					nftsite_render_nft_card( $related, $artist, $extra );
					?>
				<?php endforeach; ?>
			</div>

			<a class="btn btn--secondary btn--outline nft-more__cta nft-more__cta--mobile" href="<?php echo esc_url( $artist_url ); ?>">
				<?php esc_html_e( 'Go To Artist Page', 'nftsite' ); ?>
				<span class="btn__icon" aria-hidden="true">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4.16666 10H15.8333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M10.8333 5L15.8333 10L10.8333 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
			</a>
		</div>
	</section>
</main>

<?php
get_footer();
