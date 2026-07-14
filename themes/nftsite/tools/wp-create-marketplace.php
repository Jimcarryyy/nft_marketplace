<?php
/**
 * Create Marketplace page and fix Reading/nav URLs.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-create-marketplace.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';

$page = get_page_by_path( 'marketplace' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'   => 'Marketplace',
			'post_name'    => 'marketplace',
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
	echo "Created Marketplace page #{$id}\n";
} else {
	$id = (int) $page->ID;
	echo "Marketplace page exists #{$id}\n";
}

echo 'URL: ' . get_permalink( $id ) . "\n";

// Flush rewrite rules so /marketplace/ resolves.
flush_rewrite_rules();
echo "Rewrite rules flushed.\n";
