<?php
/**
 * Plugin Name: IPA English Login Abuse Protection
 * Description: Limits password-reset abuse and anonymous WordPress user enumeration.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Require a valid WordPress form nonce for requests posted to wp-login.php.
 * Custom account recovery forms (LMS/WooCommerce) remain compatible and are
 * still covered by the per-IP and per-account limits below.
 */
function ipaenglish_security_password_reset_form_field() {
	wp_nonce_field( 'ipaenglish_password_reset', 'ipaenglish_password_reset_nonce' );
}
add_action( 'lostpassword_form', 'ipaenglish_security_password_reset_form_field' );

/**
 * Use HMAC-derived, non-reversible transient keys: do not persist plain IP
 * addresses or usernames in WordPress option names.
 *
 * @param string $category Bucket name.
 * @param string $identifier IP address or user ID.
 * @return string
 */
function ipaenglish_security_reset_bucket_key( $category, $identifier ) {
	return 'ipa_pr_' . $category . '_' . substr( hash_hmac( 'sha256', (string) $identifier, wp_salt( 'auth' ) ), 0, 32 );
}

/**
 * Reject automated reset submissions before WordPress creates a reset key or
 * sends email. No external CAPTCHA service or API credentials are required.
 *
 * @param WP_Error      $errors    Existing reset validation errors.
 * @param WP_User|false $user_data Account resolved by WordPress Core.
 * @return WP_Error
 */
function ipaenglish_security_limit_password_reset( $errors, $user_data ) {
	if ( ! $errors instanceof WP_Error ) {
		return $errors;
	}

	$method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( (string) $_SERVER['REQUEST_METHOD'] ) : '';

	if ( 'POST' === $method && isset( $_SERVER['SCRIPT_NAME'] ) && 'wp-login.php' === basename( (string) $_SERVER['SCRIPT_NAME'] ) ) {
		$nonce = isset( $_POST['ipaenglish_password_reset_nonce'] ) && is_string( $_POST['ipaenglish_password_reset_nonce'] )
			? sanitize_text_field( wp_unslash( $_POST['ipaenglish_password_reset_nonce'] ) )
			: '';

		if ( ! wp_verify_nonce( $nonce, 'ipaenglish_password_reset' ) ) {
			$errors->add( 'ipa_reset_invalid_request', 'Please reopen the password-reset form and try again.' );
			return $errors;
		}
	}

	if ( $errors->has_errors() || ! $user_data instanceof WP_User ) {
		return $errors;
	}

	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '';
	$ip = filter_var( $ip, FILTER_VALIDATE_IP ) ? $ip : '';

	// Account quotas work even when the requester rotates IP addresses.
	$user_key     = ipaenglish_security_reset_bucket_key( 'user', (string) $user_data->ID );
	$daily_key    = $user_key . '_day';
	$cooldown_key = $user_key . '_cool';
	$daily_count  = (int) get_transient( $daily_key );

	$ip_key   = '' !== $ip ? ipaenglish_security_reset_bucket_key( 'ip', $ip ) : '';
	$ip_count = '' !== $ip_key ? (int) get_transient( $ip_key ) : 0;

	if ( $daily_count >= 4 || false !== get_transient( $cooldown_key ) || ( '' !== $ip_key && $ip_count >= 6 ) ) {
		$errors->add( 'ipa_reset_rate_limited', 'Too many password-reset requests. Please wait before trying again or contact support.' );
		return $errors;
	}

	// Only successful, validated reset requests consume quota.
	set_transient( $daily_key, $daily_count + 1, DAY_IN_SECONDS );
	set_transient( $cooldown_key, 1, 10 * MINUTE_IN_SECONDS );

	if ( '' !== $ip_key ) {
		set_transient( $ip_key, $ip_count + 1, HOUR_IN_SECONDS );
	}

	return $errors;
}
add_filter( 'lostpassword_errors', 'ipaenglish_security_limit_password_reset', 10, 2 );

/**
 * Block anonymous and unauthorized REST user listings and individual user
 * records. This covers both pretty /wp-json URLs and ?rest_route= variants.
 * Authorized administrators retain normal editor and WordPress behavior.
 */
function ipaenglish_security_protect_rest_users( $result, $server, $request ) {
	if ( ! $request instanceof WP_REST_Request || 'GET' !== strtoupper( $request->get_method() ) ) {
		return $result;
	}

	if ( preg_match( '#^/wp/v2/users(?:/[0-9]+)?/?$#', $request->get_route() ) && ! current_user_can( 'list_users' ) ) {
		return new WP_Error( 'ipa_users_not_public', 'Not found.', array( 'status' => 404 ) );
	}

	return $result;
}
add_filter( 'rest_pre_dispatch', 'ipaenglish_security_protect_rest_users', 10, 3 );

/**
 * Prevent the classic ?author=1 numeric author enumeration redirect.
 * Public author archives are deliberately not changed by this guard.
 */
function ipaenglish_security_block_numeric_author_enumeration() {
	if ( is_user_logged_in() || ! isset( $_GET['author'] ) || ! is_scalar( $_GET['author'] ) ) {
		return;
	}

	$author = (string) wp_unslash( $_GET['author'] );

	if ( ctype_digit( $author ) ) {
		status_header( 404 );
		nocache_headers();
		wp_die( 'Not found.', 'Not found.', array( 'response' => 404 ) );
	}
}
add_action( 'template_redirect', 'ipaenglish_security_block_numeric_author_enumeration', 0 );
