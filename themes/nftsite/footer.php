<?php
/**
 * The template for displaying the footer
 *
 * @package nftsite
 */
?>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-footer__grid">
				<div class="site-footer__brand">
					<a class="site-branding" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<span class="site-branding__icon" aria-hidden="true">
							<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M6 10.6667V25.3333C6 26.8061 7.19391 28 8.66667 28H23.3333C24.8061 28 26 26.8061 26 25.3333V10.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M22.6667 10.6667V8.66667C22.6667 7.19391 21.4728 6 20 6H12C10.5272 6 9.33333 7.19391 9.33333 8.66667V10.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M6 10.6667H26" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M13.3333 16H18.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<span class="site-branding__title"><?php esc_html_e( 'NFT Marketplace', 'nftsite' ); ?></span>
					</a>
					<p class="site-footer__tagline"><?php esc_html_e( 'NFT marketplace UI created with Anima for Figma.', 'nftsite' ); ?></p>
					<p class="site-footer__community"><?php esc_html_e( 'Join our community', 'nftsite' ); ?></p>
					<ul class="site-footer__social">
						<li>
							<a href="#" data-toast-soon aria-label="<?php esc_attr_e( 'Discord', 'nftsite' ); ?>">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M24.3 8.2a19.4 19.4 0 0 0-4.8-1.5l-.2.4a18 18 0 0 1 4.3 2.1 16.3 16.3 0 0 0-13.2 0 18 18 0 0 1 4.3-2.1l-.2-.4a19.4 19.4 0 0 0-4.8 1.5C6.5 12.8 5.5 17.2 6 21.5a19.6 19.6 0 0 0 5.9 3 14.7 14.7 0 0 0 1.3-2.1 12.6 12.6 0 0 1-2-.9l.5-.4c3.7 1.7 7.7 1.7 11.4 0l.5.4a12.6 12.6 0 0 1-2 .9 14.7 14.7 0 0 0 1.3 2.1 19.6 19.6 0 0 0 5.9-3c.6-4.8-.8-9.1-3.5-13.3ZM12.4 19.2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2Zm7.2 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2Z" fill="currentColor"/></svg>
							</a>
						</li>
						<li>
							<a href="#" data-toast-soon aria-label="<?php esc_attr_e( 'YouTube', 'nftsite' ); ?>">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M28.2 11.2a3.4 3.4 0 0 0-2.4-2.4C23.6 8.3 16 8.3 16 8.3s-7.6 0-9.8.5a3.4 3.4 0 0 0-2.4 2.4C3.3 13.4 3.3 16 3.3 16s0 2.6.5 4.8a3.4 3.4 0 0 0 2.4 2.4c2.2.5 9.8.5 9.8.5s7.6 0 9.8-.5a3.4 3.4 0 0 0 2.4-2.4c.5-2.2.5-4.8.5-4.8s0-2.6-.5-4.8ZM13.6 19.2v-6.4L19.5 16l-5.9 3.2Z" fill="currentColor"/></svg>
							</a>
						</li>
						<li>
							<a href="#" data-toast-soon aria-label="<?php esc_attr_e( 'Twitter', 'nftsite' ); ?>">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M26.8 10.3c.1-.6.1-1.2 0-1.8.7-.4 1.2-1 1.5-1.7-.7.4-1.4.7-2.2.8A3.3 3.3 0 0 0 16.7 11c0 .3 0 .5.1.8-2.8-.1-5.3-1.5-7-3.6-.3.5-.4 1-.4 1.6 0 1.1.6 2.1 1.5 2.7-.5 0-1.1-.2-1.5-.4v.1c0 1.6 1.1 2.9 2.6 3.2-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.7 2.2 3.1 2.3A6.6 6.6 0 0 1 6 21.4 9.4 9.4 0 0 0 11.1 23c6.1 0 9.4-5 9.4-9.4v-.4c.7-.5 1.2-1 1.6-1.7-.6.3-1.2.4-1.9.4l-.4-.4Z" fill="currentColor"/></svg>
							</a>
						</li>
						<li>
							<a href="#" data-toast-soon aria-label="<?php esc_attr_e( 'Instagram', 'nftsite' ); ?>">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M16 10.4A5.6 5.6 0 1 0 21.6 16 5.6 5.6 0 0 0 16 10.4Zm0 9.2A3.6 3.6 0 1 1 19.6 16 3.6 3.6 0 0 1 16 19.6Zm7.1-9.4a1.3 1.3 0 1 1-1.3-1.3 1.3 1.3 0 0 1 1.3 1.3ZM26.4 11.3a6.5 6.5 0 0 0-1.8-4.6 6.5 6.5 0 0 0-4.6-1.8c-1.8-.1-7.3-.1-9.1 0a6.5 6.5 0 0 0-4.6 1.8 6.5 6.5 0 0 0-1.8 4.6c-.1 1.8-.1 7.3 0 9.1a6.5 6.5 0 0 0 1.8 4.6 6.5 6.5 0 0 0 4.6 1.8c1.8.1 7.3.1 9.1 0a6.5 6.5 0 0 0 4.6-1.8 6.5 6.5 0 0 0 1.8-4.6c.1-1.8.1-7.2 0-9.1Zm-2.3 11a3.8 3.8 0 0 1-2.1 2.1c-1.5.6-5 .5-6.6.5s-5.1.1-6.6-.5a3.8 3.8 0 0 1-2.1-2.1c-.6-1.5-.5-5-.5-6.6s-.1-5.1.5-6.6a3.8 3.8 0 0 1 2.1-2.1c1.5-.6 5-.5 6.6-.5s5.1-.1 6.6.5a3.8 3.8 0 0 1 2.1 2.1c.6 1.5.5 5 .5 6.6s.1 5.1-.5 6.6Z" fill="currentColor"/></svg>
							</a>
						</li>
					</ul>
				</div>

				<div class="site-footer__explore">
					<h3 class="site-footer__heading"><?php esc_html_e( 'Explore', 'nftsite' ); ?></h3>
					<ul class="site-footer__links">
						<li><a href="<?php echo esc_url( nftsite_page_url( 'marketplace', 'marketplace' ) ); ?>"><?php esc_html_e( 'Marketplace', 'nftsite' ); ?></a></li>
						<li><a href="<?php echo esc_url( nftsite_page_url( 'rankings', 'rankings' ) ); ?>"><?php esc_html_e( 'Rankings', 'nftsite' ); ?></a></li>
						<li><a href="<?php echo esc_url( nftsite_page_url( 'connect-wallet', 'connect-wallet' ) ); ?>"><?php esc_html_e( 'Connect a wallet', 'nftsite' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__digest">
					<h3 class="site-footer__heading"><?php esc_html_e( 'Join Our Weekly Digest', 'nftsite' ); ?></h3>
					<p class="site-footer__digest-text"><?php esc_html_e( 'Get exclusive promotions & updates straight to your inbox.', 'nftsite' ); ?></p>
					<form class="newsletter__form newsletter__form--footer" action="#" method="post" data-newsletter-form>
						<label class="screen-reader-text" for="footer-email"><?php esc_html_e( 'Email address', 'nftsite' ); ?></label>
						<input
							id="footer-email"
							class="newsletter__input"
							type="email"
							name="email"
							placeholder="<?php esc_attr_e( 'Enter your email here', 'nftsite' ); ?>"
							required
						>
						<button class="btn btn--secondary newsletter__submit" type="submit">
							<span class="btn__icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M16.6667 3.33334H3.33334C2.41287 3.33334 1.66667 4.07954 1.66667 5.00001V15C1.66667 15.9205 2.41287 16.6667 3.33334 16.6667H16.6667C17.5872 16.6667 18.3333 15.9205 18.3333 15V5.00001C18.3333 4.07954 17.5872 3.33334 16.6667 3.33334Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M18.3333 5.83334L10.8583 10.5833C10.6011 10.7443 10.304 10.8297 10 10.8297C9.69602 10.8297 9.39887 10.7443 9.14167 10.5833L1.66667 5.83334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							<?php esc_html_e( 'Subscribe', 'nftsite' ); ?>
						</button>
					</form>
				</div>
			</div>

			<hr class="site-footer__divider">
			<p class="site-footer__copyright caption">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'NFT Market. Use this template freely.', 'nftsite' ); ?>
			</p>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
