<?php
/**
 * Plugin Name: IPA Disable XML-RPC
 * Description: Turns off XML-RPC so bots cannot brute-force logins through xmlrpc.php (wp.getUsersBlogs, system.multicall) or abuse pingbacks.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * xmlrpc_enabled only covers authenticated methods; drop every method so
 * pingbacks and system.* calls are rejected too.
 */
add_filter( 'xmlrpc_methods', '__return_empty_array', PHP_INT_MAX );

/**
 * Stop advertising the endpoint in response headers and the RSD link.
 */
function ipa_disable_xmlrpc_remove_pingback_header( array $headers ): array {
	unset( $headers['X-Pingback'] );

	return $headers;
}
add_filter( 'wp_headers', 'ipa_disable_xmlrpc_remove_pingback_header' );
remove_action( 'wp_head', 'rsd_link' );
