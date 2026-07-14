<?php
/**
 * The header for our theme
 *
 * @package nftsite
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="nftsite-loader" class="site-loader" aria-hidden="true">
	<div class="site-loader__inner">
		<span class="site-loader__icon" aria-hidden="true">
			<svg width="40" height="40" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6 10.6667V25.3333C6 26.8061 7.19391 28 8.66667 28H23.3333C24.8061 28 26 26.8061 26 25.3333V10.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M22.6667 10.6667V8.66667C22.6667 7.19391 21.4728 6 20 6H12C10.5272 6 9.33333 7.19391 9.33333 8.66667V10.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M6 10.6667H26" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M13.3333 16H18.6667" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</span>
		<span class="site-loader__title"><?php esc_html_e( 'NFT Marketplace', 'nftsite' ); ?></span>
		<span class="site-loader__bar" aria-hidden="true"><span class="site-loader__bar-fill"></span></span>
	</div>
</div>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'nftsite' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container site-header__inner">
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

			<button class="nav-toggle" type="button" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'nftsite' ); ?>">
				<svg class="nav-toggle__open" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M4 7H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					<path d="M4 12H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					<path d="M4 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
				<svg class="nav-toggle__close" viewBox="0 0 24 24" fill="none" aria-hidden="true">
					<path d="M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
					<path d="M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
				</svg>
			</button>

			<nav id="site-navigation" class="site-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'nftsite' ); ?>">
				<a class="site-nav__home<?php echo is_front_page() ? ' is-current' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo is_front_page() ? ' aria-current="page"' : ''; ?>>
					<?php esc_html_e( 'Home', 'nftsite' ); ?>
				</a>

				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'menu nav-menu',
						'container'      => false,
						'fallback_cb'    => 'nftsite_fallback_menu',
					)
				);
				?>

				<div class="site-header__actions">
					<span class="session-chip session-chip--wallet" data-session-wallet hidden></span>
					<button class="btn btn--outline btn--tertiary site-header__connect" type="button" data-nftsite-connect data-connect-wallet="MetaMask">
						<?php esc_html_e( 'Connect Wallet', 'nftsite' ); ?>
					</button>
					<a class="btn btn--tertiary site-header__signup" href="<?php echo esc_url( is_user_logged_in() ? nftsite_page_url( 'studio' ) : nftsite_page_url( 'create-account', 'signup' ) ); ?>" data-signup-btn>
						<span class="btn__icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M10 10C12.0711 10 13.75 8.32107 13.75 6.25C13.75 4.17893 12.0711 2.5 10 2.5C7.92893 2.5 6.25 4.17893 6.25 6.25C6.25 8.32107 7.92893 10 10 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16.875 17.5C16.875 14.0482 13.6768 11.25 10 11.25C6.32322 11.25 3.125 14.0482 3.125 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<span data-signup-label><?php echo is_user_logged_in() ? esc_html__( 'Studio', 'nftsite' ) : esc_html__( 'Sign Up', 'nftsite' ); ?></span>
					</a>
				</div>
			</nav>
		</div>
	</header>

	<div id="nftsite-toasts" class="toast-stack" aria-live="polite" aria-atomic="true"></div>
