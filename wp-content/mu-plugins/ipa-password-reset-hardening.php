<?php
/**
 * Plugin Name: IPA Password Reset Hardening
 * Description: Prevents password reset emails for legacy/high-risk accounts that should not be recoverable from the public reset form.
 * Version: 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return whether public password resets should be blocked for a user.
 */
function ipa_should_block_public_password_reset( WP_User $user ): bool {
	$blocked_logins = array( 'translate' );
	$blocked_emails = array( 'krisevans.ipa@gmail.com' );

	return in_array( strtolower( $user->user_login ), $blocked_logins, true )
		|| in_array( strtolower( $user->user_email ), $blocked_emails, true );
}

/**
 * Skip the reset email for blocked accounts.
 *
 * retrieve_password() still returns success, so the lost-password form shows the
 * same "check your email" message as for any other account and does not reveal
 * that the account is special. Blocked accounts must change their password from
 * wp-admin (Users > Profile) instead.
 */
function ipa_block_public_password_reset_email( bool $send, string $user_login, WP_User $user_data ): bool {
	if ( ipa_should_block_public_password_reset( $user_data ) ) {
		return false;
	}

	return $send;
}
add_filter( 'send_retrieve_password_email', 'ipa_block_public_password_reset_email', 10, 3 );
