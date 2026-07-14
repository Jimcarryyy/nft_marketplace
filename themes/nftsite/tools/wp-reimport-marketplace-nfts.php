<?php
/**
 * Force-reimport marketplace NFT files that were remapped on disk.
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

$keys = array(
	'images/nfts/magic-mushroom-0325.png',
	'images/nfts/happy-robot-032.png',
	'images/nfts/happy-robot-024.png',
	'images/nfts/designer-bear.png',
	'images/nfts/colorful-dog-0345.png',
	'images/nfts/dancing-robot.png',
	'images/nfts/cherry-blossom.png',
	'images/nfts/space-travel.png',
	'images/nfts/sunset-dimension.png',
	'images/nfts/desert-walk.png',
	'images/nfts/ice-cream-ape.png',
	'images/nfts/colorful-dog-0356.png',
);

$map       = get_option( 'nftsite_media_map', array() );
$theme_dir = get_template_directory();

foreach ( $keys as $key ) {
	$path = $theme_dir . '/assets/' . $key;
	if ( ! file_exists( $path ) ) {
		echo "Missing {$key}\n";
		continue;
	}

	if ( ! empty( $map[ $key ] ) ) {
		wp_delete_attachment( (int) $map[ $key ], true );
		unset( $map[ $key ] );
	}

	$filename  = basename( $path );
	$tmp       = wp_tempnam( $filename );
	copy( $path, $tmp );
	$file_bits = array(
		'name'     => $filename,
		'type'     => mime_content_type( $path ),
		'tmp_name' => $tmp,
		'error'    => 0,
		'size'     => filesize( $path ),
	);

	$id = media_handle_sideload( $file_bits, 0 );
	if ( is_wp_error( $id ) ) {
		echo 'Error ' . $key . ': ' . $id->get_error_message() . "\n";
		continue;
	}

	update_post_meta( $id, '_nftsite_asset_key', $key );
	$map[ $key ] = (int) $id;
	echo "Reimported {$key} -> #{$id}\n";
}

update_option( 'nftsite_media_map', $map, false );
echo "Done.\n";
