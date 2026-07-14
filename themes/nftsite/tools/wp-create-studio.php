<?php
/**
 * Create Studio page.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-create-studio.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';

$page = get_page_by_path( 'studio' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'   => 'Creator Studio',
			'post_name'    => 'studio',
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
	echo "Created Studio page #{$id}\n";
} else {
	echo 'Studio page exists #' . (int) $page->ID . "\n";
}

flush_rewrite_rules();
echo 'URL: ' . home_url( '/index.php/studio/' ) . "\n";
