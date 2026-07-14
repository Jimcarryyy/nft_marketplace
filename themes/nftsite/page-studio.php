<?php
/**
 * Template for Creator Studio (slug: studio)
 *
 * @package nftsite
 */

get_header();

$is_logged = is_user_logged_in();
$artist    = null;
$items     = array();
$wallet    = '';
$nft_contract    = (string) get_option( 'nftsite_nft_contract', '' );
$market_contract = (string) get_option( 'nftsite_market_contract', '' );
$contracts_ready = (bool) preg_match( '/^0x[a-fA-F0-9]{40}$/', $nft_contract )
	&& (bool) preg_match( '/^0x[a-fA-F0-9]{40}$/', $market_contract );
$settings_url    = admin_url( 'options-general.php?page=nftsite-core' );

if ( $is_logged && class_exists( 'NFTSite_Core_Meta' ) ) {
	$user_id = get_current_user_id();
	$wallet  = (string) get_user_meta( $user_id, 'nftsite_wallet', true );
	$artist  = NFTSite_Core_Meta::get_artist_by_user( $user_id );
	if ( $artist ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_nft',
				'post_status'    => 'publish',
				'posts_per_page' => 24,
				'meta_key'       => '_nftsite_artist_id',
				'meta_value'     => (string) $artist->ID,
			)
		);
		$items = $q->posts;
	}
}
?>

<main id="primary" class="site-main studio-page">
	<section class="studio-hero" aria-labelledby="studio-heading">
		<div class="container studio-hero__inner">
			<div class="studio-hero__copy">
				<p class="studio-eyebrow"><?php esc_html_e( 'Sepolia testnet', 'nftsite' ); ?></p>
				<h1 id="studio-heading" class="studio-hero__title"><?php esc_html_e( 'Creator Studio', 'nftsite' ); ?></h1>
				<p class="studio-hero__subtitle">
					<?php esc_html_e( 'Mint NFTs, list them for sale, and track your collection — all from one workspace.', 'nftsite' ); ?>
				</p>

				<ol class="studio-steps">
					<li class="<?php echo $wallet ? 'is-done' : 'is-current'; ?>">
						<span class="studio-steps__n">1</span>
						<span><?php esc_html_e( 'Connect MetaMask (Sepolia) & sign in', 'nftsite' ); ?></span>
					</li>
					<li class="<?php echo $contracts_ready ? 'is-done' : ( $wallet ? 'is-current' : '' ); ?>">
						<span class="studio-steps__n">2</span>
						<span><?php esc_html_e( 'Admin: deploy contracts & paste addresses', 'nftsite' ); ?></span>
					</li>
					<li class="<?php echo ( $contracts_ready && $wallet ) ? 'is-current' : ''; ?>">
						<span class="studio-steps__n">3</span>
						<span><?php esc_html_e( 'Mint → List → share NFT page for buyers', 'nftsite' ); ?></span>
					</li>
				</ol>
			</div>

			<aside class="studio-wallet" aria-label="<?php esc_attr_e( 'Wallet status', 'nftsite' ); ?>">
				<div class="studio-wallet__top">
					<div class="studio-wallet__icon" aria-hidden="true">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M19 7H5C3.89543 7 3 7.89543 3 9V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V9C21 7.89543 20.1046 7 19 7Z" stroke="currentColor" stroke-width="1.5"/>
							<path d="M16.5 14.5C17.0523 14.5 17.5 14.0523 17.5 13.5C17.5 12.9477 17.0523 12.5 16.5 12.5C15.9477 12.5 15.5 12.9477 15.5 13.5C15.5 14.0523 15.9477 14.5 16.5 14.5Z" fill="currentColor"/>
							<path d="M3 10H21" stroke="currentColor" stroke-width="1.5"/>
						</svg>
					</div>
					<div class="studio-wallet__body">
						<p class="studio-wallet__label"><?php esc_html_e( 'Wallet', 'nftsite' ); ?></p>
						<p class="studio-wallet__value" data-studio-wallet-label>
							<?php
							if ( $wallet ) {
								echo esc_html( substr( $wallet, 0, 6 ) . '…' . substr( $wallet, -4 ) );
							} else {
								esc_html_e( 'Not connected', 'nftsite' );
							}
							?>
						</p>
						<p class="studio-wallet__hint">
							<?php esc_html_e( 'MetaMask on Sepolia · SIWE links your artist profile', 'nftsite' ); ?>
						</p>
					</div>
				</div>
				<p class="wallet-detect" data-wallet-detect hidden></p>
				<button class="btn btn--secondary studio-wallet__cta" type="button" data-nftsite-connect>
					<?php echo $wallet ? esc_html__( 'Reconnect', 'nftsite' ) : esc_html__( 'Connect / Sign In', 'nftsite' ); ?>
				</button>
			</aside>
		</div>
	</section>

	<section class="studio-mint" aria-labelledby="studio-mint-heading">
		<div class="container">
			<?php if ( ! $contracts_ready ) : ?>
				<div class="studio-setup-banner" role="status">
					<div>
						<p class="studio-setup-banner__title"><?php esc_html_e( 'Minting is blocked until contracts are configured', 'nftsite' ); ?></p>
						<p class="studio-setup-banner__text">
							<?php esc_html_e( 'Your wallet is fine. An admin must deploy NFTSite721 + NFTSiteMarket to Sepolia, then paste the addresses into WordPress settings.', 'nftsite' ); ?>
						</p>
						<ol class="studio-setup-banner__list">
							<li><?php esc_html_e( 'Get free Sepolia ETH (faucet) in MetaMask', 'nftsite' ); ?></li>
							<li><code>cd wp-content/plugins/nftsite-core/contracts</code> → copy <code>.env.example</code> to <code>.env</code> → set RPC + deployer key</li>
							<li><code>npm run deploy:sepolia</code> → copy printed contract addresses</li>
							<li>
								<?php if ( current_user_can( 'manage_options' ) ) : ?>
									<a href="<?php echo esc_url( $settings_url ); ?>"><?php esc_html_e( 'Settings → NFTSite Core', 'nftsite' ); ?></a>
									<?php esc_html_e( ' → paste NFT + Market addresses → Save', 'nftsite' ); ?>
								<?php else : ?>
									<?php esc_html_e( 'Ask an admin: Settings → NFTSite Core → paste addresses → Save', 'nftsite' ); ?>
								<?php endif; ?>
							</li>
							<li><?php esc_html_e( 'Hard-refresh Studio, then Mint on Sepolia', 'nftsite' ); ?></li>
						</ol>
					</div>
					<?php if ( current_user_can( 'manage_options' ) ) : ?>
						<a class="btn btn--secondary" href="<?php echo esc_url( $settings_url ); ?>"><?php esc_html_e( 'Open settings', 'nftsite' ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<header class="studio-section-head">
				<h2 id="studio-mint-heading" class="studio-section-head__title"><?php esc_html_e( 'Mint NFT', 'nftsite' ); ?></h2>
				<p class="studio-section-head__desc"><?php esc_html_e( 'Upload artwork, set royalties, then confirm the mint in MetaMask.', 'nftsite' ); ?></p>
			</header>

			<div class="studio-mint__layout">
				<form id="studio-mint-form" class="studio-form" data-studio-mint-form enctype="multipart/form-data">
					<label class="studio-form__field">
						<span class="studio-form__label"><?php esc_html_e( 'Title', 'nftsite' ); ?></span>
						<input type="text" name="title" placeholder="<?php esc_attr_e( 'e.g. Distant Galaxy #12', 'nftsite' ); ?>" required>
					</label>

					<label class="studio-form__field">
						<span class="studio-form__label"><?php esc_html_e( 'Description', 'nftsite' ); ?></span>
						<textarea name="description" rows="4" placeholder="<?php esc_attr_e( 'Tell collectors what makes this piece special…', 'nftsite' ); ?>"></textarea>
					</label>

					<label class="studio-form__field studio-form__field--royalty">
						<span class="studio-form__label"><?php esc_html_e( 'Creator royalty (BPS)', 'nftsite' ); ?></span>
						<input type="number" name="royalty_bps" value="500" min="0" max="1000" step="1">
						<span class="studio-form__help"><?php esc_html_e( '500 BPS = 5%. Max 1000 (10%).', 'nftsite' ); ?></span>
					</label>

					<div class="studio-form__actions">
						<button class="btn btn--secondary studio-form__submit" type="submit">
							<span class="btn__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M10.8333 2.5L3.33333 11.6667H10L9.16667 17.5L16.6667 8.33333H10L10.8333 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							<?php esc_html_e( 'Mint on Sepolia', 'nftsite' ); ?>
						</button>
						<p class="studio-status" data-studio-status></p>
					</div>
				</form>

				<div class="studio-preview">
					<label class="studio-dropzone" data-studio-dropzone for="studio-image-input">
						<input id="studio-image-input" class="studio-dropzone__input" type="file" name="image" accept="image/*" required form="studio-mint-form" data-studio-file>
						<span class="studio-dropzone__frame">
							<img class="studio-dropzone__preview" data-studio-preview hidden alt="">
							<span class="studio-dropzone__empty" data-studio-drop-empty>
								<span class="studio-dropzone__icon" aria-hidden="true">
									<svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 16V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
										<path d="M8.5 11.5L12 8L15.5 11.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M4 16.5V18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18V16.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
									</svg>
								</span>
								<span class="studio-dropzone__title"><?php esc_html_e( 'Drop artwork here', 'nftsite' ); ?></span>
								<span class="studio-dropzone__hint"><?php esc_html_e( 'PNG, JPG, WEBP · click to browse', 'nftsite' ); ?></span>
							</span>
						</span>
					</label>
					<p class="studio-preview__caption"><?php esc_html_e( 'Preview updates as you select a file. Image is stored in WordPress media, then minted with a metadata URI.', 'nftsite' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="studio-library" aria-labelledby="studio-library-heading" data-studio-library>
		<div class="container">
			<header class="studio-section-head studio-section-head--row">
				<div>
					<h2 id="studio-library-heading" class="studio-section-head__title"><?php esc_html_e( 'Your NFTs', 'nftsite' ); ?></h2>
					<p class="studio-section-head__desc" data-studio-count>
						<?php
						printf(
							/* translators: %d: count */
							esc_html( _n( '%d item in your studio', '%d items in your studio', count( $items ), 'nftsite' ) ),
							count( $items )
						);
						?>
					</p>
				</div>
			</header>

			<div class="studio-library__body" data-studio-library-body>
				<div class="studio-library__loading" data-studio-loading hidden>
					<span class="studio-library__spinner" aria-hidden="true"></span>
					<span><?php esc_html_e( 'Updating your studio…', 'nftsite' ); ?></span>
				</div>

				<div class="studio-empty" data-studio-empty <?php echo empty( $items ) ? '' : 'hidden'; ?>>
					<div class="studio-empty__art" aria-hidden="true"></div>
					<p class="studio-empty__title"><?php esc_html_e( 'Nothing minted yet', 'nftsite' ); ?></p>
					<p class="studio-empty__text"><?php esc_html_e( 'Connect your wallet and mint your first piece above. Listed items will show a buy button on the NFT detail page.', 'nftsite' ); ?></p>
				</div>

				<div class="studio-grid" data-studio-grid <?php echo empty( $items ) ? 'hidden' : ''; ?>>
					<?php foreach ( $items as $post ) : ?>
						<?php
						$nft    = NFTSite_Core_Meta::serialize_nft( $post );
						$token  = $nft['token_id'];
						$status = $nft['status'];
						?>
						<article class="studio-item" data-studio-item data-nft-post="<?php echo esc_attr( (string) $post->ID ); ?>">
							<div class="studio-item__media">
								<img src="<?php echo esc_url( $nft['image'] ); ?>" alt="<?php echo esc_attr( $nft['title'] ); ?>" loading="lazy">
							</div>
							<div class="studio-item__body">
								<h3 class="studio-item__title"><?php echo esc_html( $nft['title'] ); ?></h3>
								<p class="tx-pill"><?php echo esc_html( $status ); ?><?php echo $token ? ' · #' . esc_html( $token ) : ''; ?></p>
								<div class="studio-item__actions">
									<?php if ( $token && 'listed' !== $status ) : ?>
										<button
											class="btn btn--tertiary"
											type="button"
											data-studio-list
											data-nft-post="<?php echo esc_attr( (string) $post->ID ); ?>"
											data-token-id="<?php echo esc_attr( $token ); ?>"
										>
											<?php esc_html_e( 'List for sale', 'nftsite' ); ?>
										</button>
									<?php endif; ?>
									<a class="btn btn--outline btn--tertiary" href="<?php echo esc_url( nftsite_url_nft( $nft['id'] ) ); ?>">
										<?php esc_html_e( 'View', 'nftsite' ); ?>
									</a>
								</div>
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
