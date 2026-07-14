<?php
/**
 * Create Rankings WordPress page.
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-create-rankings.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';

$page = get_page_by_path( 'rankings' );
if ( ! $page ) {
	$id = wp_insert_post(
		array(
			'post_title'  => 'Rankings',
			'post_name'   => 'rankings',
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
	echo "Created Rankings page #{$id}\n";
} else {
	$id = (int) $page->ID;
	echo "Rankings page exists #{$id}\n";
}

flush_rewrite_rules();
echo 'URL: ' . home_url( '/index.php/rankings/' ) . "\n";
