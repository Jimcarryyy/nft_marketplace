<?php
/**
 * One-time setup: create Home page, set front page, import theme images into Media Library.
 *
 * Run from CLI:
 *   C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-import-assets.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "Run this script from the command line.\n" );
}

$wp_load = dirname( __FILE__, 5 ) . '/wp-load.php';
if ( ! file_exists( $wp_load ) ) {
	fwrite( STDERR, "Could not find wp-load.php at: {$wp_load}\n" );
	exit( 1 );
}

require $wp_load;
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$theme_dir = get_template_directory();
$assets_dir = $theme_dir . '/assets/images';

if ( ! is_dir( $assets_dir ) ) {
	fwrite( STDERR, "Assets folder missing: {$assets_dir}\n" );
	exit( 1 );
}

/**
 * Import a local file into the Media Library (skip if already imported by key).
 *
 * @param string $absolute_path Full path to file.
 * @param string $key           Option map key.
 * @param array  &$map          Attachment map.
 * @return int Attachment ID or 0.
 */
function nftsite_cli_import_file( $absolute_path, $key, &$map ) {
	if ( isset( $map[ $key ] ) ) {
		$existing = (int) $map[ $key ];
		if ( $existing && get_post( $existing ) ) {
			echo "Skip (exists): {$key} -> #{$existing}\n";
			return $existing;
		}
	}

	if ( ! file_exists( $absolute_path ) ) {
		echo "Missing file: {$absolute_path}\n";
		return 0;
	}

	$filename = basename( $absolute_path );
	$file_bits = array(
		'name'     => $filename,
		'type'     => mime_content_type( $absolute_path ),
		'tmp_name' => $absolute_path,
		'error'    => 0,
		'size'     => filesize( $absolute_path ),
	);

	// media_handle_sideload expects an upload tmp file; copy first.
	$tmp = wp_tempnam( $filename );
	copy( $absolute_path, $tmp );
	$file_bits['tmp_name'] = $tmp;

	$attachment_id = media_handle_sideload( $file_bits, 0, null );

	if ( is_wp_error( $attachment_id ) ) {
		@unlink( $tmp );
		echo 'Error importing ' . $key . ': ' . $attachment_id->get_error_message() . "\n";
		return 0;
	}

	update_post_meta( $attachment_id, '_nftsite_asset_key', $key );
	$map[ $key ] = (int) $attachment_id;
	echo "Imported: {$key} -> #{$attachment_id}\n";
	return (int) $attachment_id;
}

$map = get_option( 'nftsite_media_map', array() );
if ( ! is_array( $map ) ) {
	$map = array();
}

$iterator = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator( $assets_dir, FilesystemIterator::SKIP_DOTS )
);

$imported = 0;
foreach ( $iterator as $file ) {
	if ( ! $file->isFile() ) {
		continue;
	}
	$ext = strtolower( $file->getExtension() );
	if ( ! in_array( $ext, array( 'png', 'jpg', 'jpeg', 'webp', 'gif', 'svg' ), true ) ) {
		continue;
	}

	$absolute = $file->getPathname();
	$relative = str_replace( '\\', '/', substr( $absolute, strlen( $assets_dir ) + 1 ) );
	$key      = 'images/' . $relative;

	$id = nftsite_cli_import_file( $absolute, $key, $map );
	if ( $id ) {
		$imported++;
	}
}

update_option( 'nftsite_media_map', $map, false );
echo "Media map saved (" . count( $map ) . " items).\n";

// Create / update Home page.
$home = get_page_by_path( 'home' );
if ( ! $home ) {
	$home_id = wp_insert_post(
		array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<!-- The homepage layout is rendered by the nftsite theme front-page.php template. -->',
		),
		true
	);
	if ( is_wp_error( $home_id ) ) {
		fwrite( STDERR, 'Failed to create Home page: ' . $home_id->get_error_message() . "\n" );
		exit( 1 );
	}
	echo "Created Home page #{$home_id}\n";
} else {
	$home_id = (int) $home->ID;
	echo "Home page already exists #{$home_id}\n";
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );
echo "Reading settings: static front page = Home (#{$home_id})\n";

// Set theme screenshot from design if present.
$design_screenshot = 'C:/Users/Admin/Desktop/NFT materials/Pages design to build/Homepage (desktop).png';
$theme_screenshot  = $theme_dir . '/screenshot.png';
if ( file_exists( $design_screenshot ) ) {
	// WordPress expects ~1200x900; copy design as preview.
	copy( $design_screenshot, $theme_screenshot );
	echo "Updated theme screenshot.png\n";
}

echo "Done. View your site front-end (not Pages list) to see the design.\n";
echo "Media Library should now list the imported NFT images.\n";
