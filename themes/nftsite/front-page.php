<?php
/**
 * Front page template
 *
 * @package nftsite
 */

get_header();

$nft_count = 0;
$listed_count = 0;
$artist_count = 0;
$sale_count = 0;
if ( function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog() ) {
	$nfts = wp_count_posts( 'nftsite_nft' );
	$artists = wp_count_posts( 'nftsite_artist' );
	$nft_count = $nfts && ! empty( $nfts->publish ) ? (int) $nfts->publish : 0;
	$artist_count = $artists && ! empty( $artists->publish ) ? (int) $artists->publish : 0;
	$listed_count = count( nftsite_marketplace_nft_ids( 'listed' ) );
	$sale_q = new WP_Query(
		array(
			'post_type'      => 'nftsite_listing',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_nftsite_status',
			'meta_value'     => 'sold',
			'no_found_rows'  => false,
		)
	);
	$sale_count = (int) $sale_q->found_posts;
}

$hero_stats = array(
	array(
		'value' => (string) $sale_count,
		'label' => __( 'Sales', 'nftsite' ),
	),
	array(
		'value' => (string) $listed_count,
		'label' => __( 'Listed', 'nftsite' ),
	),
	array(
		'value' => (string) $artist_count,
		'label' => __( 'Artists', 'nftsite' ),
	),
);
?>

<main id="primary" class="site-main">
	<section class="hero" aria-labelledby="hero-title">
		<div class="container hero__grid">
			<div class="hero__content">
				<h1 id="hero-title" class="hero__title">
					<?php esc_html_e( 'Discover Digital Art And Collect NFTs', 'nftsite' ); ?>
				</h1>

				<p class="hero__description">
					<?php esc_html_e( 'NFT marketplace UI created with Anima for Landing page. Sign up for the latest news and updates. No spam.', 'nftsite' ); ?>
				</p>

				<div class="hero__actions">
					<a class="btn btn--primary" href="<?php echo esc_url( nftsite_page_url( 'create-account', 'signup' ) ); ?>">
						<span class="btn__icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M10.8333 2.5L3.33333 11.6667H10L9.16667 17.5L16.6667 8.33333H10L10.8333 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<?php esc_html_e( 'Get Started', 'nftsite' ); ?>
					</a>
				</div>

				<dl class="hero__stats">
					<?php foreach ( $hero_stats as $stat ) : ?>
						<div class="hero-stat">
							<dt class="hero-stat__value"><?php echo esc_html( $stat['value'] ); ?></dt>
							<dd class="hero-stat__label"><?php echo esc_html( $stat['label'] ); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>

			<aside class="hero__featured" aria-label="<?php esc_attr_e( 'Featured NFT', 'nftsite' ); ?>">
				<?php
				$featured_nft    = nftsite_get_nft( 'space-walking' );
				$featured_artist = nftsite_get_artist( 'animakid' );
				?>
				<article class="featured-card">
					<a class="featured-card__link" href="<?php echo esc_url( nftsite_url_nft( 'space-walking' ) ); ?>">
						<div class="featured-card__media">
							<img
								src="<?php echo esc_url( nftsite_media_url( $featured_nft['image'] ) ); ?>"
								alt="<?php echo esc_attr( $featured_nft['title'] ); ?>"
								width="510"
								height="510"
								loading="eager"
							>
						</div>
						<div class="featured-card__body">
							<h2 class="featured-card__title"><?php echo esc_html( $featured_nft['title'] ); ?></h2>
							<div class="featured-card__artist">
								<img
									class="featured-card__avatar"
									src="<?php echo esc_url( nftsite_media_url( $featured_artist['avatar_sm'] ) ); ?>"
									alt=""
									width="24"
									height="24"
									loading="lazy"
								>
								<span class="featured-card__artist-name"><?php echo esc_html( $featured_artist['name'] ); ?></span>
							</div>
						</div>
					</a>
				</article>
			</aside>
		</div>
	</section>

	<?php
	$trending_collections = array();
	foreach ( array( 'dsgn-animals', 'moonbirds', 'neo-echos' ) as $cid ) {
		$col = nftsite_get_collection( $cid );
		if ( $col ) {
			$trending_collections[] = $col;
		}
	}
	?>

	<section class="trending section-block" id="trending" aria-labelledby="trending-title">
		<div class="container">
			<header class="section-header">
				<h2 id="trending-title" class="section-heading"><?php esc_html_e( 'Trending Collection', 'nftsite' ); ?></h2>
				<p class="section-subheading"><?php esc_html_e( 'Checkout our weekly updated trending collection.', 'nftsite' ); ?></p>
			</header>

			<div class="trending__grid">
				<?php foreach ( $trending_collections as $collection ) : ?>
					<?php $c_artist = nftsite_get_artist( $collection['artist_id'] ); ?>
					<article class="collection-card reveal">
						<a class="collection-card__link" href="<?php echo esc_url( $c_artist ? nftsite_url_artist( $c_artist['id'] ) : nftsite_page_url( 'marketplace' ) ); ?>">
							<div class="collection-card__primary">
								<img
									src="<?php echo esc_url( nftsite_media_url( $collection['primary'] ) ); ?>"
									alt="<?php echo esc_attr( sprintf( __( '%1$s collection artwork', 'nftsite' ), $collection['title'] ) ); ?>"
									width="410"
									height="410"
									loading="lazy"
								>
							</div>

							<div class="collection-card__thumbs">
								<div class="collection-card__thumb">
									<img
										src="<?php echo esc_url( nftsite_media_url( $collection['thumb_1'] ) ); ?>"
										alt=""
										width="100"
										height="100"
										loading="lazy"
									>
								</div>
								<div class="collection-card__thumb">
									<img
										src="<?php echo esc_url( nftsite_media_url( $collection['thumb_2'] ) ); ?>"
										alt=""
										width="100"
										height="100"
										loading="lazy"
									>
								</div>
								<div class="collection-card__more" aria-hidden="true">
									<span><?php echo esc_html( $collection['extra'] ); ?></span>
								</div>
							</div>
						</a>

						<div class="collection-card__meta">
							<h3 class="collection-card__title"><?php echo esc_html( $collection['title'] ); ?></h3>
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
		</div>
	</section>

	<?php
	$top_creator_ids = nftsite_home_creator_ids();
	$rankings_url    = nftsite_page_url( 'rankings', 'rankings' );
	?>

	<section class="top-creators section-block" id="rankings" aria-labelledby="creators-title">
		<div class="container">
			<header class="section-header section-header--with-action">
				<div class="section-header__text">
					<h2 id="creators-title" class="section-heading"><?php esc_html_e( 'Top Creators', 'nftsite' ); ?></h2>
					<p class="section-subheading"><?php esc_html_e( 'Checkout Top Rated Creators on the NFT Marketplace', 'nftsite' ); ?></p>
				</div>

				<a class="btn btn--secondary btn--outline top-creators__cta top-creators__cta--desktop" href="<?php echo esc_url( $rankings_url ); ?>">
					<span class="btn__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5.83333 17.5V15.8333H14.1667V17.5H5.83333ZM3.33333 14.1667V7.5H5V14.1667H3.33333ZM7.5 14.1667V5H9.16667V14.1667H7.5ZM11.6667 14.1667V9.16667H13.3333V14.1667H11.6667ZM15 14.1667V3.33333H16.6667V14.1667H15Z" fill="currentColor"/>
						</svg>
					</span>
					<?php esc_html_e( 'View Rankings', 'nftsite' ); ?>
				</a>
			</header>

			<div class="creators__grid">
				<?php foreach ( $top_creator_ids as $index => $creator_id ) : ?>
					<?php $creator = nftsite_get_artist( $creator_id ); ?>
					<?php if ( ! $creator ) { continue; } ?>
					<a class="creator-card reveal" href="<?php echo esc_url( nftsite_url_artist( $creator['id'] ) ); ?>">
						<span class="creator-card__rank" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
						<img
							class="creator-card__avatar"
							src="<?php echo esc_url( nftsite_media_url( $creator['avatar_sm'] ) ); ?>"
							alt=""
							width="120"
							height="120"
							loading="lazy"
						>
						<div class="creator-card__info">
							<h3 class="creator-card__name"><?php echo esc_html( $creator['name'] ); ?></h3>
							<p class="creator-card__sales">
								<span class="creator-card__sales-label"><?php esc_html_e( 'Total Sales:', 'nftsite' ); ?></span>
								<span class="creator-card__sales-value"><?php echo esc_html( $creator['sales'] ); ?></span>
							</p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>

			<a class="btn btn--secondary btn--outline top-creators__cta top-creators__cta--mobile" href="<?php echo esc_url( $rankings_url ); ?>">
				<span class="btn__icon" aria-hidden="true">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M10.8333 2.5L3.33333 11.6667H10L9.16667 17.5L16.6667 8.33333H10L10.8333 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
				<?php esc_html_e( 'View Rankings', 'nftsite' ); ?>
			</a>
		</div>
	</section>

	<?php
	$categories = array(
		array(
			'name'  => __( 'Art', 'nftsite' ),
			'image' => 'images/categories/art.png',
			'icon'  => 'images/icons/PaintBrush.png',
			'slug'  => 'art',
		),
		array(
			'name'  => __( 'Collectibles', 'nftsite' ),
			'image' => 'images/categories/collectibles.png',
			'icon'  => 'images/icons/Swatches.png',
			'slug'  => 'collectibles',
		),
		array(
			'name'  => __( 'Music', 'nftsite' ),
			'image' => 'images/categories/music.png',
			'icon'  => 'images/icons/MusicNotes.png',
			'slug'  => 'music',
		),
		array(
			'name'  => __( 'Photography', 'nftsite' ),
			'image' => 'images/categories/photography.png',
			'icon'  => 'images/icons/Camera.png',
			'slug'  => 'photography',
		),
		array(
			'name'  => __( 'Video', 'nftsite' ),
			'image' => 'images/categories/video.png',
			'icon'  => 'images/icons/VideoCamera.png',
			'slug'  => 'video',
		),
		array(
			'name'  => __( 'Utility', 'nftsite' ),
			'image' => 'images/categories/utility.png',
			'icon'  => 'images/icons/MagicWand.png',
			'slug'  => 'utility',
		),
		array(
			'name'  => __( 'Sport', 'nftsite' ),
			'image' => 'images/categories/sport.png',
			'icon'  => 'images/icons/Basketball.png',
			'slug'  => 'sport',
		),
		array(
			'name'  => __( 'Virtual Worlds', 'nftsite' ),
			'image' => 'images/categories/virtual-worlds.png',
			'icon'  => 'images/icons/Planet.png',
			'slug'  => 'virtual-worlds',
		),
	);

	$discover_ids = array( 'distant-galaxy', 'life-on-edena', 'astrofiction' );

	$how_it_works = array(
		array(
			'title' => __( 'Setup Your Wallet', 'nftsite' ),
			'text'  => __( 'Set up your wallet of choice. Connect it to the NFT market by clicking the wallet icon in the top right corner.', 'nftsite' ),
			'icon'  => 'images/how-it-works/setup-wallet.png',
		),
		array(
			'title' => __( 'Create Collection', 'nftsite' ),
			'text'  => __( 'Upload your work and setup your collection. Add a description, social links and floor price.', 'nftsite' ),
			'icon'  => 'images/how-it-works/create-collection.png',
		),
		array(
			'title' => __( 'Start Earning', 'nftsite' ),
			'text'  => __( 'Choose between auctions and fixed-price listings. Start earning by selling your NFTs or trading others.', 'nftsite' ),
			'icon'  => 'images/how-it-works/start-earning.png',
		),
	);
	$marketplace_url = nftsite_page_url( 'marketplace', 'marketplace' );
	?>

	<section class="categories section-block" id="marketplace" aria-labelledby="categories-title">
		<div class="container container--categories">
			<header class="section-header">
				<h2 id="categories-title" class="section-heading"><?php esc_html_e( 'Browse Categories', 'nftsite' ); ?></h2>
			</header>

			<div class="categories__grid">
				<?php foreach ( $categories as $category ) : ?>
					<?php
					$cat_url = add_query_arg( 'category', rawurlencode( $category['slug'] ), $marketplace_url );
					?>
					<a class="category-card reveal" href="<?php echo esc_url( $cat_url ); ?>">
						<div class="category-card__media">
							<img
								class="category-card__bg"
								src="<?php echo esc_url( nftsite_asset_uri( $category['image'] ) ); ?>"
								alt="<?php echo esc_attr( $category['name'] ); ?>"
								width="480"
								height="400"
								loading="lazy"
							>
							<span class="category-card__icon" aria-hidden="true">
								<img src="<?php echo esc_url( nftsite_asset_uri( $category['icon'] ) ); ?>" alt="" width="80" height="80">
							</span>
						</div>
						<div class="category-card__label">
							<h3 class="category-card__name"><?php echo esc_html( $category['name'] ); ?></h3>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="discover section-block" aria-labelledby="discover-title">
		<div class="container">
			<header class="section-header section-header--with-action">
				<div class="section-header__text">
					<h2 id="discover-title" class="section-heading"><?php esc_html_e( 'Discover More NFTs', 'nftsite' ); ?></h2>
					<p class="section-subheading"><?php esc_html_e( 'Explore new trending NFTs', 'nftsite' ); ?></p>
				</div>

				<a class="btn btn--secondary btn--outline discover__cta discover__cta--desktop" href="<?php echo esc_url( $marketplace_url ); ?>">
					<span class="btn__icon" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.66666 10C1.66666 10 4.16666 4.16667 10 4.16667C15.8333 4.16667 18.3333 10 18.3333 10C18.3333 10 15.8333 15.8333 10 15.8333C4.16666 15.8333 1.66666 10 1.66666 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</span>
					<?php esc_html_e( 'See All', 'nftsite' ); ?>
				</a>
			</header>

			<div class="discover__grid">
				<?php
				foreach ( $discover_ids as $did ) {
					$dnft = nftsite_get_nft( $did );
					if ( $dnft ) {
						nftsite_render_nft_card( $dnft );
					}
				}
				?>
			</div>

			<a class="btn btn--secondary btn--outline discover__cta discover__cta--mobile" href="<?php echo esc_url( $marketplace_url ); ?>">
				<span class="btn__icon" aria-hidden="true">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.66666 10C1.66666 10 4.16666 4.16667 10 4.16667C15.8333 4.16667 18.3333 10 18.3333 10C18.3333 10 15.8333 15.8333 10 15.8333C4.16666 15.8333 1.66666 10 1.66666 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
				<?php esc_html_e( 'See All', 'nftsite' ); ?>
			</a>
		</div>
	</section>

	<section class="highlight" aria-labelledby="highlight-title">
		<div class="highlight__bg" style="background-image: url('<?php echo esc_url( nftsite_asset_uri( 'images/highlight/magic-mushrooms.png' ) ); ?>');"></div>
		<div class="highlight__overlay"></div>
		<div class="container highlight__inner">
			<div class="highlight__content">
				<a class="highlight__artist" href="<?php echo esc_url( nftsite_url_artist( 'shroomie' ) ); ?>">
					<img
						src="<?php echo esc_url( nftsite_asset_uri( 'images/avatars/avatar-7.png' ) ); ?>"
						alt=""
						width="24"
						height="24"
						loading="lazy"
					>
					<span><?php esc_html_e( 'Shroomie', 'nftsite' ); ?></span>
				</a>
				<h2 id="highlight-title" class="highlight__title"><?php esc_html_e( 'Magic Mushrooms', 'nftsite' ); ?></h2>
			</div>

			<div class="highlight__timer" aria-label="<?php esc_attr_e( 'Featured drop', 'nftsite' ); ?>">
				<p class="highlight__timer-label"><?php esc_html_e( 'Featured on Sepolia', 'nftsite' ); ?></p>
				<p class="highlight__timer-note"><?php echo esc_html( (string) $nft_count ); ?> <?php esc_html_e( 'NFTs in catalog', 'nftsite' ); ?></p>
			</div>

			<a class="btn btn--secondary highlight__cta" href="<?php echo esc_url( nftsite_url_nft( 'magic-mushroom-0325' ) ); ?>">
				<span class="btn__icon" aria-hidden="true">
					<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.66666 10C1.66666 10 4.16666 4.16667 10 4.16667C15.8333 4.16667 18.3333 10 18.3333 10C18.3333 10 15.8333 15.8333 10 15.8333C4.16666 15.8333 1.66666 10 1.66666 10Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</span>
				<?php esc_html_e( 'See NFT', 'nftsite' ); ?>
			</a>
		</div>
	</section>

	<section class="how-it-works section-block" aria-labelledby="how-title">
		<div class="container">
			<header class="section-header">
				<h2 id="how-title" class="section-heading"><?php esc_html_e( 'How It Works', 'nftsite' ); ?></h2>
				<p class="section-subheading"><?php esc_html_e( 'Find out how to get started', 'nftsite' ); ?></p>
			</header>

			<div class="how-it-works__grid">
				<?php foreach ( $how_it_works as $step ) : ?>
					<article class="how-card reveal">
						<img
							class="how-card__icon"
							src="<?php echo esc_url( nftsite_asset_uri( $step['icon'] ) ); ?>"
							alt=""
							width="160"
							height="160"
							loading="lazy"
						>
						<div class="how-card__text">
							<h3 class="how-card__title"><?php echo esc_html( $step['title'] ); ?></h3>
							<p class="how-card__desc"><?php echo esc_html( $step['text'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="newsletter section-block" aria-labelledby="newsletter-title">
		<div class="container">
			<div class="newsletter__card">
				<div class="newsletter__media">
					<img
						src="<?php echo esc_url( nftsite_asset_uri( 'images/newsletter-astronaut.png' ) ); ?>"
						alt="<?php esc_attr_e( 'Astronaut reading a newspaper', 'nftsite' ); ?>"
						width="425"
						height="310"
						loading="lazy"
					>
				</div>
				<div class="newsletter__content">
					<h2 id="newsletter-title" class="newsletter__title"><?php esc_html_e( 'Join Our Weekly Digest', 'nftsite' ); ?></h2>
					<p class="newsletter__text"><?php esc_html_e( 'Get exclusive promotions & updates straight to your inbox.', 'nftsite' ); ?></p>
					<form class="newsletter__form" action="#" method="post" data-newsletter-form>
						<label class="screen-reader-text" for="newsletter-email"><?php esc_html_e( 'Email address', 'nftsite' ); ?></label>
						<input
							id="newsletter-email"
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
		</div>
	</section>
</main>

<?php
get_footer();
