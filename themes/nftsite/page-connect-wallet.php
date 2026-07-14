<?php
/**
 * Template for the Connect Wallet page (slug: connect-wallet)
 *
 * @package nftsite
 */

get_header();
?>

<main id="primary" class="site-main connect-wallet-page">
	<section class="connect-wallet" aria-labelledby="connect-wallet-heading">
		<div class="connect-wallet__layout">
			<figure class="connect-wallet__media">
				<img
					src="<?php echo esc_url( nftsite_asset_uri( 'images/connect-wallet/hero.png' ) ); ?>"
					alt=""
					width="610"
					height="691"
					loading="eager"
				>
			</figure>

			<div class="connect-wallet__content">
				<div class="connect-wallet__inner">
					<h1 id="connect-wallet-heading" class="connect-wallet__title">
						<?php esc_html_e( 'Connect Wallet', 'nftsite' ); ?>
					</h1>
					<p class="connect-wallet__desc">
						<?php esc_html_e( 'Sign in with MetaMask on Sepolia. You’ll approve a connection, then sign a message (SIWE) to link your wallet to this site — that is the app login.', 'nftsite' ); ?>
					</p>
					<p class="wallet-detect" data-wallet-detect hidden></p>
					<p class="connect-wallet__hint" data-wallet-hint>
						<a href="https://metamask.io/download/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Install MetaMask', 'nftsite' ); ?></a>
						·
						<?php esc_html_e( 'Unlock it, select Sepolia network, then continue.', 'nftsite' ); ?>
					</p>

					<ul class="connect-wallet__list">
						<li>
							<button
								class="connect-wallet__option"
								type="button"
								data-nftsite-connect
								data-connect-wallet="Metamask"
							>
								<img
									class="connect-wallet__icon"
									src="<?php echo esc_url( nftsite_asset_uri( 'images/icons/Metamask.png' ) ); ?>"
									alt=""
									width="40"
									height="40"
									loading="lazy"
								>
								<span class="connect-wallet__option-label"><?php esc_html_e( 'MetaMask · Sign In', 'nftsite' ); ?></span>
							</button>
						</li>
					</ul>
					<p class="connect-wallet__footnote">
						<?php esc_html_e( 'WalletConnect and Coinbase Wallet are not wired yet — MetaMask is required for mint, list, and buy.', 'nftsite' ); ?>
					</p>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
