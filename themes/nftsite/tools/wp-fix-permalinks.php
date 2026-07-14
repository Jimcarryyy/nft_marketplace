<?php
/**
 * Fix permalinks for local XAMPP (PATHINFO style).
 *
 * Run: C:\xampp\php\php.exe wp-content\themes\nftsite\tools\wp-fix-permalinks.php
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';

// PATHINFO permalinks work on XAMPP without relying on Apache AllowOverride.
update_option( 'permalink_structure', '/index.php/%postname%/' );
flush_rewrite_rules( true );

$marketplace = get_page_by_path( 'marketplace' );
echo 'Permalink structure: ' . get_option( 'permalink_structure' ) . "\n";
if ( $marketplace ) {
	echo 'Marketplace URL: ' . get_permalink( $marketplace ) . "\n";
}
