<?php
/**
 * Template for Create Account / Edit Profile (slug: create-account)
 *
 * @package nftsite
 */

get_header();

$logged_in = is_user_logged_in();
$artist    = null;
$name      = '';
$bio       = '';
$website   = '';
$email     = '';
$wallet    = '';

if ( $logged_in && class_exists( 'NFTSite_Core_Meta' ) ) {
	$user    = wp_get_current_user();
	$email   = $user->user_email;
	$wallet  = (string) get_user_meta( $user->ID, 'nftsite_wallet', true );
	$artist  = NFTSite_Core_Meta::get_artist_by_user( $user->ID );
	if ( $artist ) {
		$serialized = NFTSite_Core_Meta::serialize_artist( $artist );
		$name       = $serialized['name'];
		$bio        = $serialized['bio'];
		$website    = $serialized['website'] ?? '';
	} else {
		$name = $user->display_name;
	}
}

$artist_url = ( $artist && ! empty( $artist->post_name ) )
	? nftsite_url_artist( $artist->post_name )
	: nftsite_page_url( 'artist', 'artist' );
?>

<main id="primary" class="site-main create-account-page">
	<section class="create-account" aria-labelledby="create-account-heading">
		<div class="create-account__layout">
			<figure class="create-account__media">
				<img
					src="<?php echo esc_url( nftsite_asset_uri( 'images/create-account/hero.png' ) ); ?>"
					alt=""
					width="610"
					height="691"
					loading="eager"
				>
			</figure>

			<div class="create-account__content">
				<div class="create-account__inner">
					<h1 id="create-account-heading" class="create-account__title">
						<?php
						echo $logged_in
							? esc_html__( 'Edit Profile', 'nftsite' )
							: esc_html__( 'Complete Profile', 'nftsite' );
						?>
					</h1>
					<p class="create-account__desc">
						<?php
						echo $logged_in
							? esc_html__( 'Update your display name, bio, and website. Your wallet stays the login identity.', 'nftsite' )
							: esc_html__( 'Connect MetaMask first, then choose a display name. Identity is wallet-first via Sign-In With Ethereum.', 'nftsite' );
						?>
					</p>

					<?php if ( ! $logged_in ) : ?>
						<button class="btn btn--secondary create-account__submit" type="button" data-nftsite-connect>
							<?php esc_html_e( 'Connect / Sign In', 'nftsite' ); ?>
						</button>
					<?php else : ?>
						<?php if ( $wallet ) : ?>
							<p class="create-account__wallet"><?php echo esc_html( substr( $wallet, 0, 6 ) . '…' . substr( $wallet, -4 ) ); ?></p>
						<?php endif; ?>

						<form class="create-account__form" action="#" method="post" novalidate data-create-account-form data-profile-form>
							<label class="create-account__field">
								<span class="screen-reader-text"><?php esc_html_e( 'Display name', 'nftsite' ); ?></span>
								<span class="create-account__field-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M10 10C12.3012 10 14.1667 8.13452 14.1667 5.83333C14.1667 3.53214 12.3012 1.66666 10 1.66666C7.69881 1.66666 5.83333 3.53214 5.83333 5.83333C5.83333 8.13452 7.69881 10 10 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M17.1583 18.3333C17.1583 15.1083 13.95 12.5 10 12.5C6.05 12.5 2.84167 15.1083 2.84167 18.3333" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<input type="text" name="username" value="<?php echo esc_attr( $name ); ?>" placeholder="<?php esc_attr_e( 'Display name', 'nftsite' ); ?>" autocomplete="nickname" required>
							</label>

							<label class="create-account__field">
								<span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'nftsite' ); ?></span>
								<span class="create-account__field-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M2.5 5.83334L9.075 10.0917C9.64167 10.45 10.3667 10.45 10.9333 10.0917L17.5 5.83334" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M16.6667 4.16666H3.33333C2.41286 4.16666 1.66666 4.91286 1.66666 5.83332V14.1667C1.66666 15.0871 2.41286 15.8333 3.33333 15.8333H16.6667C17.5871 15.8333 18.3333 15.0871 18.3333 14.1667V5.83332C18.3333 4.91286 17.5871 4.16666 16.6667 4.16666Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<input type="email" name="email" value="<?php echo esc_attr( $email ); ?>" placeholder="<?php esc_attr_e( 'Email (optional)', 'nftsite' ); ?>" autocomplete="email">
							</label>

							<label class="create-account__field create-account__field--textarea">
								<span class="screen-reader-text"><?php esc_html_e( 'Bio', 'nftsite' ); ?></span>
								<textarea name="bio" rows="4" placeholder="<?php esc_attr_e( 'Short bio', 'nftsite' ); ?>"><?php echo esc_textarea( $bio ); ?></textarea>
							</label>

							<label class="create-account__field">
								<span class="screen-reader-text"><?php esc_html_e( 'Website', 'nftsite' ); ?></span>
								<span class="create-account__field-icon" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M10 17.5C14.1421 17.5 17.5 14.1421 17.5 10C17.5 5.85786 14.1421 2.5 10 2.5C5.85786 2.5 2.5 5.85786 2.5 10C2.5 14.1421 5.85786 17.5 10 17.5Z" stroke="currentColor" stroke-width="1.5"/>
										<path d="M2.5 10H17.5" stroke="currentColor" stroke-width="1.5"/>
									</svg>
								</span>
								<input type="url" name="website" value="<?php echo esc_attr( $website ); ?>" placeholder="<?php esc_attr_e( 'https://your-site.com', 'nftsite' ); ?>" autocomplete="url">
							</label>

							<button class="btn btn--secondary create-account__submit" type="submit">
								<?php esc_html_e( 'Save profile', 'nftsite' ); ?>
							</button>
							<p class="create-account__status" data-profile-status hidden></p>
							<?php if ( $artist ) : ?>
								<a class="create-account__view" href="<?php echo esc_url( $artist_url ); ?>"><?php esc_html_e( 'View public profile', 'nftsite' ); ?></a>
							<?php endif; ?>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
