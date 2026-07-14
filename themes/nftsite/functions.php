<?php
/**
 * nftsite functions and definitions
 *
 * @package nftsite
 */

if ( ! defined( 'NFTSITE_VERSION' ) ) {
	define( 'NFTSITE_VERSION', '1.2.7' );
}

require get_template_directory() . '/inc/data.php';

/**
 * Theme setup.
 */
function nftsite_setup() {
	load_theme_textdomain( 'nftsite', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'nftsite' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'nftsite_setup' );

/**
 * Set content width.
 */
function nftsite_content_width() {
	$GLOBALS['content_width'] = 1280;
}
add_action( 'after_setup_theme', 'nftsite_content_width', 0 );

/**
 * Return a theme asset URI.
 *
 * @param string $path Relative path inside /assets/.
 * @return string
 */
function nftsite_asset_uri( $path ) {
	$path = ltrim( str_replace( '\\', '/', $path ), '/' );
	$map  = get_option( 'nftsite_media_map', array() );

	if ( is_array( $map ) && ! empty( $map[ $path ] ) ) {
		$url = wp_get_attachment_url( (int) $map[ $path ] );
		if ( $url ) {
			return $url;
		}
	}

	return get_template_directory_uri() . '/assets/' . $path;
}

/**
 * Return a public page URL by slug, with hash fallback.
 *
 * @param string $slug Page slug.
 * @param string $hash Optional hash fallback fragment without #.
 * @return string
 */
function nftsite_page_url( $slug, $hash = '' ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return home_url( '/index.php/' . $page->post_name . '/' );
	}
	return $hash ? home_url( '/#' . ltrim( $hash, '#' ) ) : home_url( '/' );
}

/**
 * NFT detail URL.
 *
 * @param string $id NFT id.
 * @return string
 */
function nftsite_url_nft( $id ) {
	return add_query_arg( 'id', rawurlencode( $id ), nftsite_page_url( 'nft' ) );
}

/**
 * Artist profile URL.
 *
 * @param string $id Artist id.
 * @return string
 */
function nftsite_url_artist( $id ) {
	return add_query_arg( 'id', rawurlencode( $id ), nftsite_page_url( 'artist', 'artist' ) );
}

/**
 * Whether plugin catalog CPTs are populated.
 *
 * @return bool
 */
function nftsite_use_cpt_catalog() {
	return function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog();
}

/**
 * Resolve image URL (absolute or theme relative).
 *
 * @param string $path_or_url Path or URL.
 * @return string
 */
function nftsite_media_url( $path_or_url ) {
	if ( ! $path_or_url ) {
		return '';
	}
	if ( preg_match( '#^https?://#i', $path_or_url ) ) {
		return $path_or_url;
	}
	return nftsite_asset_uri( $path_or_url );
}

/**
 * @param string $id Artist id.
 * @return array|null
 */
function nftsite_get_artist( $id ) {
	if ( nftsite_use_cpt_catalog() && class_exists( 'NFTSite_Core_Meta' ) ) {
		$post = NFTSite_Core_Meta::get_artist_by_slug( $id );
		if ( $post ) {
			$data           = NFTSite_Core_Meta::serialize_artist( $post );
			$data['avatar'] = $data['avatar'] ?: 'images/avatars/avatar-1.png';
			$data['avatar_sm'] = $data['avatar_sm'] ?: $data['avatar'];
			$data['banner'] = $data['banner'] ?: 'images/artist/banner.png';
			return $data;
		}
	}
	$artists = nftsite_seed_artists();
	return isset( $artists[ $id ] ) ? $artists[ $id ] : null;
}

/**
 * @param string $id NFT id.
 * @return array|null
 */
function nftsite_get_nft( $id ) {
	if ( nftsite_use_cpt_catalog() && class_exists( 'NFTSite_Core_Meta' ) ) {
		$post = NFTSite_Core_Meta::get_nft_by_slug( $id );
		if ( $post ) {
			return NFTSite_Core_Meta::serialize_nft( $post );
		}
	}
	$nfts = nftsite_seed_nfts();
	return isset( $nfts[ $id ] ) ? $nfts[ $id ] : null;
}

/**
 * Resolve current request artist (query ?id=).
 *
 * @param string $default Default artist id.
 * @return array
 */
function nftsite_current_artist( $default = 'animakid' ) {
	$id = isset( $_GET['id'] ) ? sanitize_title( wp_unslash( $_GET['id'] ) ) : $default;
	$artist = nftsite_get_artist( $id );
	if ( ! $artist ) {
		$artist = nftsite_get_artist( $default );
	}
	if ( ! $artist && nftsite_use_cpt_catalog() ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_artist',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			)
		);
		if ( $q->have_posts() ) {
			$artist = NFTSite_Core_Meta::serialize_artist( $q->posts[0] );
		}
	}
	return $artist;
}

/**
 * Resolve current request NFT (query ?id=).
 *
 * @param string $default Default NFT id.
 * @return array
 */
function nftsite_current_nft( $default = 'the-orbitians' ) {
	$id  = isset( $_GET['id'] ) ? sanitize_title( wp_unslash( $_GET['id'] ) ) : $default;
	$nft = nftsite_get_nft( $id );
	if ( ! $nft ) {
		$nft = nftsite_get_nft( $default );
	}
	if ( ! $nft && nftsite_use_cpt_catalog() ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_nft',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			)
		);
		if ( $q->have_posts() ) {
			$nft = NFTSite_Core_Meta::serialize_nft( $q->posts[0] );
		}
	}
	return $nft;
}

/**
 * @param string $id Collection id.
 * @return array|null
 */
function nftsite_get_collection( $id ) {
	if ( nftsite_use_cpt_catalog() && class_exists( 'NFTSite_Core_Meta' ) ) {
		$post = get_page_by_path( $id, OBJECT, 'nftsite_collection' );
		if ( $post ) {
			$artist_id = (int) NFTSite_Core_Meta::get( $post->ID, 'artist_id', 0 );
			$artist    = $artist_id ? get_post( $artist_id ) : null;
			$count     = NFTSite_Core_Meta::collection_item_count( $post->ID, $artist_id );
			return array(
				'id'        => $post->post_name,
				'title'     => get_the_title( $post ),
				'primary'   => get_the_post_thumbnail_url( $post, 'large' ) ?: '',
				'thumb_1'   => get_the_post_thumbnail_url( $post, 'thumbnail' ) ?: '',
				'thumb_2'   => get_the_post_thumbnail_url( $post, 'thumbnail' ) ?: '',
				'extra'     => (string) $count,
				'artist_id' => $artist ? $artist->post_name : '',
				'artist'    => $artist ? get_the_title( $artist ) : '',
				'avatar'    => $artist ? ( get_the_post_thumbnail_url( $artist, 'thumbnail' ) ?: '' ) : '',
			);
		}
	}
	$collections = nftsite_seed_collections();
	return isset( $collections[ $id ] ) ? $collections[ $id ] : null;
}

/**
 * Whether a nav slug is the current page.
 *
 * @param string $slug Page slug.
 * @return bool
 */
function nftsite_is_current_page( $slug ) {
	if ( 'home' === $slug ) {
		return is_front_page();
	}
	return is_page( $slug );
}

/**
 * Rankings rows for theme (CPT when available).
 *
 * @return array
 */
function nftsite_get_rankings() {
	if ( nftsite_use_cpt_catalog() && class_exists( 'NFTSite_Core_Meta' ) ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_artist',
				'post_status'    => 'publish',
				'posts_per_page' => 20,
				'meta_key'       => '_nftsite_volume',
				'orderby'        => 'meta_value_num',
				'order'          => 'DESC',
			)
		);
		$rows = array();
		foreach ( $q->posts as $i => $post ) {
			$artist = NFTSite_Core_Meta::serialize_artist( $post );
			$stats  = array(
				'change' => '—',
				'sold'   => (string) (int) $artist['nfts_sold'],
				'volume' => $artist['volume'],
			);
			$rows[] = array(
				'name'      => $artist['name'],
				'artist_id' => $artist['id'],
				'avatar'    => $artist['avatar_sm'] ?: $artist['avatar'],
				'periods'   => array(
					'today' => $stats,
					'week'  => $stats,
					'month' => $stats,
					'all'   => $stats,
				),
			);
		}
		if ( $rows ) {
			return $rows;
		}
	}
	return nftsite_seed_rankings();
}

/**
 * Compact seed payload for JS.
 *
 * @return array
 */
function nftsite_js_data() {
	$artists = array();
	foreach ( nftsite_seed_artists() as $id => $artist ) {
		$artists[ $id ] = array(
			'id'   => $id,
			'name' => $artist['name'],
		);
	}

	$nfts = array();
	foreach ( nftsite_seed_nfts() as $id => $nft ) {
		$nfts[ $id ] = array(
			'id'        => $id,
			'title'     => $nft['title'],
			'artist_id' => $nft['artist_id'],
			'price'     => $nft['price'],
			'bid'       => $nft['bid'],
		);
	}

	$rankings = array();
	foreach ( nftsite_get_rankings() as $row ) {
		$rankings[] = array(
			'name'      => $row['name'],
			'artist_id' => $row['artist_id'],
			'periods'   => $row['periods'],
		);
	}

	return array(
		'homeUrl'         => home_url( '/' ),
		'marketplaceUrl'  => nftsite_page_url( 'marketplace', 'marketplace' ),
		'rankingsUrl'     => nftsite_page_url( 'rankings', 'rankings' ),
		'connectWalletUrl'=> nftsite_page_url( 'connect-wallet', 'connect-wallet' ),
		'createAccountUrl'=> nftsite_page_url( 'create-account', 'signup' ),
		'artists'         => $artists,
		'nfts'            => $nfts,
		'rankings'        => $rankings,
		'i18n'            => array(
			'copied'       => __( 'Copied!', 'nftsite' ),
			'following'    => __( 'Following', 'nftsite' ),
			'follow'       => __( 'Follow', 'nftsite' ),
			'connected'    => __( 'Connected', 'nftsite' ),
			'bidPlaced'    => __( 'Bid placed successfully (demo).', 'nftsite' ),
			'walletOk'     => __( 'Wallet connected.', 'nftsite' ),
			'accountOk'    => __( 'Account created. Welcome!', 'nftsite' ),
			'subscribed'   => __( 'You are subscribed!', 'nftsite' ),
			'comingSoon'   => __( 'Coming soon.', 'nftsite' ),
			'needWallet'   => __( 'Connect a wallet to place a bid.', 'nftsite' ),
			'invalidForm'  => __( 'Please fill in all fields correctly.', 'nftsite' ),
			'passwordMatch'=> __( 'Passwords do not match.', 'nftsite' ),
		),
	);
}

/**
 * Enqueue scripts and styles.
 */
function nftsite_scripts() {
	wp_enqueue_style(
		'nftsite-fonts',
		'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Work+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'nftsite-style',
		get_stylesheet_uri(),
		array( 'nftsite-fonts' ),
		NFTSITE_VERSION
	);

	wp_enqueue_script(
		'nftsite-main',
		get_template_directory_uri() . '/js/main.js',
		array(),
		NFTSITE_VERSION,
		true
	);

	wp_localize_script( 'nftsite-main', 'nftsiteData', nftsite_js_data() );
}
add_action( 'wp_enqueue_scripts', 'nftsite_scripts' );

/**
 * Keep primary nav lean — Studio + Connect live in header actions.
 *
 * @param array    $items Menu items.
 * @param stdClass $args  Args.
 * @return array
 */
function nftsite_filter_primary_menu_items( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}
	$filtered = array();
	foreach ( $items as $item ) {
		$slug  = isset( $item->url ) ? basename( untrailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) ) ) : '';
		$title = strtolower( trim( (string) $item->title ) );
		if ( in_array( $slug, array( 'studio', 'connect-wallet' ), true ) ) {
			continue;
		}
		if ( in_array( $title, array( 'studio', 'connect a wallet', 'connect wallet' ), true ) ) {
			continue;
		}
		$filtered[] = $item;
	}
	return $filtered;
}
add_filter( 'wp_nav_menu_objects', 'nftsite_filter_primary_menu_items', 10, 2 );

/**
 * Document title for dynamic artist/NFT pages.
 *
 * @param array $parts Title parts.
 * @return array
 */
function nftsite_document_title_parts( $parts ) {
	if ( is_page( 'artist' ) ) {
		$artist = nftsite_current_artist();
		if ( ! empty( $artist['name'] ) ) {
			$parts['title'] = $artist['name'];
		}
	}
	if ( is_page( 'nft' ) ) {
		$nft = nftsite_current_nft();
		if ( ! empty( $nft['title'] ) ) {
			$parts['title'] = $nft['title'];
		}
	}
	return $parts;
}
add_filter( 'document_title_parts', 'nftsite_document_title_parts' );

/**
 * Fallback primary menu when no menu is assigned.
 */
function nftsite_fallback_menu() {
	$links = array(
		array(
			'label' => __( 'Marketplace', 'nftsite' ),
			'slug'  => 'marketplace',
			'url'   => nftsite_page_url( 'marketplace', 'marketplace' ),
		),
		array(
			'label' => __( 'Rankings', 'nftsite' ),
			'slug'  => 'rankings',
			'url'   => nftsite_page_url( 'rankings', 'rankings' ),
		),
	);

	echo '<ul id="primary-menu" class="menu nav-menu">';
	foreach ( $links as $link ) {
		$current = nftsite_is_current_page( $link['slug'] );
		printf(
			'<li class="menu-item%1$s"><a href="%2$s"%3$s>%4$s</a></li>',
			$current ? ' current-menu-item' : '',
			esc_url( $link['url'] ),
			$current ? ' aria-current="page"' : '',
			esc_html( $link['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Render a reusable NFT card.
 *
 * @param array  $nft    NFT data.
 * @param array  $artist Artist data.
 * @param string $extra_class Optional extra class on article.
 */
function nftsite_render_nft_card( $nft, $artist = null, $extra_class = '' ) {
	if ( ! $nft ) {
		return;
	}
	if ( ! $artist && ! empty( $nft['artist_id'] ) ) {
		$artist = nftsite_get_artist( $nft['artist_id'] );
	}
	$artist_name = $artist ? $artist['name'] : ( $nft['artist_name'] ?? '' );
	$avatar      = $artist ? ( $artist['avatar_sm'] ?? $artist['avatar'] ) : ( $nft['artist_avatar'] ?? '' );
	$classes     = trim( 'nft-card reveal ' . $extra_class );
	$status      = strtolower( (string) ( $nft['status'] ?? '' ) );
	$is_listed   = ( 'listed' === $status ) || ( ! empty( $nft['listing']['price_eth'] ) );
	$search      = strtolower( $nft['title'] . ' ' . $artist_name . ' ' . $status );
	$img         = nftsite_media_url( $nft['image'] ?? '' );
	$av          = nftsite_media_url( $avatar );
	$price_label = $is_listed
		? ( $nft['price'] ?? '' )
		: ( 'sold' === $status ? __( 'Sold', 'nftsite' ) : __( 'Not for sale', 'nftsite' ) );
	$status_label = $is_listed ? __( 'Listed', 'nftsite' ) : ( $status ? ucfirst( $status ) : __( 'Minted', 'nftsite' ) );
	?>
	<article class="<?php echo esc_attr( $classes ); ?>" data-search="<?php echo esc_attr( $search ); ?>" data-status="<?php echo esc_attr( $status ?: 'minted' ); ?>">
		<a class="nft-card__link" href="<?php echo esc_url( nftsite_url_nft( $nft['id'] ) ); ?>">
			<div class="nft-card__media">
				<img
					src="<?php echo esc_url( $img ); ?>"
					alt="<?php echo esc_attr( $nft['title'] ); ?>"
					width="330"
					height="295"
					loading="lazy"
				>
				<span class="nft-card__badge"><?php echo esc_html( $status_label ); ?></span>
			</div>
			<div class="nft-card__body">
				<h2 class="nft-card__title"><?php echo esc_html( $nft['title'] ); ?></h2>
				<?php if ( $artist_name ) : ?>
					<div class="nft-card__artist">
						<?php if ( $av ) : ?>
							<img src="<?php echo esc_url( $av ); ?>" alt="" width="24" height="24" loading="lazy">
						<?php endif; ?>
						<span><?php echo esc_html( $artist_name ); ?></span>
					</div>
				<?php endif; ?>
				<div class="nft-card__meta">
					<div>
						<span class="nft-card__meta-label"><?php echo $is_listed ? esc_html__( 'Price', 'nftsite' ) : esc_html__( 'Status', 'nftsite' ); ?></span>
						<span class="nft-card__meta-value"><?php echo esc_html( $price_label ); ?></span>
					</div>
					<?php if ( ! empty( $nft['token_id'] ) ) : ?>
						<div class="nft-card__meta-right">
							<span class="nft-card__meta-label"><?php esc_html_e( 'Token', 'nftsite' ); ?></span>
							<span class="nft-card__meta-value">#<?php echo esc_html( $nft['token_id'] ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</a>
	</article>
	<?php
}
