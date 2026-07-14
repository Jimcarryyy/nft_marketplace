<?php
/**
 * Create NFT detail WordPress page.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-create-nft.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$page = get_page_by_path( 'nft' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'   => 'The Orbitians',
			'post_name'    => 'nft',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		fwrite( STDERR, $id->get_error_message() . "\n" );
		exit( 1 );
	}
	echo "Created NFT page #{$id}\n";
} else {
	$id = (int) $page->ID;
	echo "NFT page exists #{$id}\n";
}

flush_rewrite_rules();

// Import new assets.
$map       = get_option( 'nftsite_media_map', array() );
$theme_dir = get_template_directory();
$keys      = array(
	'images/nft-detail/orbitians-hero.png',
	'images/avatars/orbitian.png',
	'images/nfts/cat-from-future.png',
	'images/nfts/psycho-dog.png',
	'images/nfts/foxy-life.png',
	'images/nfts/dancing-robot-0345.png',
	'images/nfts/dancing-robot-0387.png',
);

foreach ( $keys as $key ) {
	$path = $theme_dir . '/assets/' . $key;
	if ( ! file_exists( $path ) ) {
		echo "Missing {$key}\n";
		continue;
	}
	if ( ! empty( $map[ $key ] ) && get_post( (int) $map[ $key ] ) ) {
		echo "Skip {$key}\n";
		continue;
	}
	$filename  = basename( $path );
	$tmp       = wp_tempnam( $filename );
	copy( $path, $tmp );
	$id_att = media_handle_sideload(
		array(
			'name'     => $filename,
			'type'     => mime_content_type( $path ),
			'tmp_name' => $tmp,
			'error'    => 0,
			'size'     => filesize( $path ),
		),
		0
	);
	if ( is_wp_error( $id_att ) ) {
		echo 'Error ' . $key . ': ' . $id_att->get_error_message() . "\n";
		continue;
	}
	$map[ $key ] = (int) $id_att;
	echo "Imported {$key} -> #{$id_att}\n";
}

update_option( 'nftsite_media_map', $map, false );
echo 'URL: ' . home_url( '/index.php/nft/' ) . "\n";
