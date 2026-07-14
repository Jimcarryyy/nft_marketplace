<?php
/**
 * Create Create Account page and import assets.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-create-account.php
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

$page = get_page_by_path( 'create-account' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'   => 'Create Account',
			'post_name'    => 'create-account',
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
	echo "Created Create Account page #{$id}\n";
} else {
	echo 'Create Account page exists #' . (int) $page->ID . "\n";
}

flush_rewrite_rules();

$map       = get_option( 'nftsite_media_map', array() );
$theme_dir = get_template_directory();
$key       = 'images/create-account/hero.png';
$path      = $theme_dir . '/assets/' . $key;

if ( ! file_exists( $path ) ) {
	echo "Missing {$key}\n";
} elseif ( ! empty( $map[ $key ] ) && get_post( (int) $map[ $key ] ) ) {
	echo "Skip {$key}\n";
} else {
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
	} else {
		$map[ $key ] = (int) $att;
		update_option( 'nftsite_media_map', $map, false );
		echo "Imported {$key} -> #{$att}\n";
	}
}

echo 'URL: ' . home_url( '/index.php/create-account/' ) . "\n";
