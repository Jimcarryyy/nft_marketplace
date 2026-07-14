<?php
/**
 * Activate nftsite-core, create studio page, import seed.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-bootstrap-flagship.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';

if ( ! function_exists( 'activate_plugin' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$plugin = 'nftsite-core/nftsite-core.php';
$result = activate_plugin( $plugin );
if ( is_wp_error( $result ) ) {
	fwrite( STDERR, 'Activate failed: ' . $result->get_error_message() . "\n" );
	exit( 1 );
}
echo "Plugin active: {$plugin}\n";

$page = get_page_by_path( 'studio' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'  => 'Creator Studio',
			'post_name'   => 'studio',
			'post_status' => 'publish',
			'post_type'   => 'page',
		),
		true
	);
	if ( is_wp_error( $id ) ) {
		fwrite( STDERR, $id->get_error_message() . "\n" );
		exit( 1 );
	}
	echo "Created Studio page #{$id}\n";
} else {
	echo 'Studio page exists #' . (int) $page->ID . "\n";
}

if ( class_exists( 'NFTSite_Core_Seed_Importer' ) ) {
	$imported = NFTSite_Core_Seed_Importer::import();
	echo sprintf(
		"Imported artists=%d nfts=%d collections=%d\n",
		$imported['artists'],
		$imported['nfts'],
		$imported['collections']
	);
} else {
	fwrite( STDERR, "Importer class missing\n" );
	exit( 1 );
}

flush_rewrite_rules();
echo 'Catalog ready: ' . ( nftsite_core_has_catalog() ? 'yes' : 'no' ) . "\n";
echo 'Studio URL: ' . home_url( '/index.php/studio/' ) . "\n";
