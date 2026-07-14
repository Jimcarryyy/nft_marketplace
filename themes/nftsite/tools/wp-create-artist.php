<?php
/**
 * Create Artist page and import assets.
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

$page = get_page_by_path( 'artist' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'  => 'Animakid',
			'post_name'   => 'artist',
			'post_status' => 'publish',
			'post_type'   => 'page',
			'post_content'=> '',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		fwrite( STDERR, $id->get_error_message() . "\n" );
		exit( 1 );
	}
	echo "Created Artist page #{$id}\n";
} else {
	echo 'Artist page exists #' . (int) $page->ID . "\n";
}

flush_rewrite_rules();

$map       = get_option( 'nftsite_media_map', array() );
$theme_dir = get_template_directory();
$keys      = array(
	'images/artist/banner.png',
	'images/artist/avatar-large.png',
	'images/nfts/crypto-city.png',
	'images/nfts/colorful-dog-0524.png',
	'images/nfts/space-tales.png',
	'images/nfts/cherry-blossom-037.png',
	'images/nfts/dancing-robots-0987.png',
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
	$filename = basename( $path );
	$tmp      = wp_tempnam( $filename );
	copy( $path, $tmp );
	$att = media_handle_sideload(
		array(
			'name'     => $filename,
			'type'     => mime_content_type( $path ),
			'tmp_name' => $tmp,
			'error'    => 0,
			'size'     => filesize( $path ),
		),
		0
	);
	if ( is_wp_error( $att ) ) {
		echo 'Error ' . $key . ': ' . $att->get_error_message() . "\n";
		continue;
	}
	$map[ $key ] = (int) $att;
	echo "Imported {$key} -> #{$att}\n";
}

update_option( 'nftsite_media_map', $map, false );
echo 'URL: ' . home_url( '/index.php/artist/' ) . "\n";
