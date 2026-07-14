<?php
/**
 * Smoke-check flagship plugin + REST.
 *
 * @package nftsite
 */

if ( php_sapi_name() !== 'cli' ) {
	exit( "CLI only.\n" );
}

require dirname( __FILE__, 5 ) . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

echo 'plugin=' . ( is_plugin_active( 'nftsite-core/nftsite-core.php' ) ? 'yes' : 'no' ) . PHP_EOL;
echo 'catalog=' . ( function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog() ? 'yes' : 'no' ) . PHP_EOL;

$request = new WP_REST_Request( 'GET', '/nftsite/v1/nfts' );
$request->set_param( 'per_page', 2 );
$response = rest_do_request( $request );
$data     = $response->get_data();
echo 'rest_nfts_total=' . ( isset( $data['total'] ) ? (int) $data['total'] : 0 ) . PHP_EOL;

$artist = nftsite_get_artist( 'animakid' );
echo 'artist=' . ( $artist ? $artist['name'] : 'missing' ) . PHP_EOL;
echo 'created=' . ( $artist && ! empty( $artist['created'] ) ? count( $artist['created'] ) : 0 ) . PHP_EOL;
