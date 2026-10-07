<?php
/**
 * Plugin Name: IPA Image WebP Generator
 * Description: Generates smaller WebP siblings for JPEG/PNG media while retaining the original files as fallback.
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const IPA_IMAGE_WEBP_QUALITY = 82;

/**
 * Return whether a source file is eligible for WebP generation.
 */
function ipa_image_webp_is_supported_source( string $source ): bool {
	$extension = strtolower( (string) pathinfo( $source, PATHINFO_EXTENSION ) );

	return in_array( $extension, array( 'jpg', 'jpeg', 'png' ), true );
}

/**
 * Return the sibling WebP path for an original image.
 */
function ipa_image_webp_target_path( string $source ): string {
	return $source . '.webp';
}

/**
 * Generate one WebP sibling when it is smaller than the original.
 *
 * Originals are never replaced. Existing up-to-date WebP files are reused.
 */
function ipa_image_webp_generate_file( string $source, bool $force = false ): bool {
	if ( ! ipa_image_webp_is_supported_source( $source ) || ! is_readable( $source ) || ! is_file( $source ) ) {
		return false;
	}

	$target = ipa_image_webp_target_path( $source );

	if ( ! $force && is_file( $target ) && filemtime( $target ) >= filemtime( $source ) ) {
		return true;
	}

	$editor = wp_get_image_editor( $source );
	if ( is_wp_error( $editor ) ) {
		return false;
	}

	$quality_result = $editor->set_quality( IPA_IMAGE_WEBP_QUALITY );
	if ( is_wp_error( $quality_result ) ) {
		return false;
	}

	$saved = $editor->save( $target, 'image/webp' );
	if ( is_wp_error( $saved ) || ! is_file( $target ) ) {
		if ( is_file( $target ) ) {
			wp_delete_file( $target );
		}

		return false;
	}

	$source_size = filesize( $source );
	$target_size = filesize( $target );

	if ( false === $source_size || false === $target_size || $target_size >= $source_size ) {
		wp_delete_file( $target );
		return false;
	}

	$source_mode = fileperms( $source );
	if ( false !== $source_mode ) {
		chmod( $target, $source_mode & 0777 );
	}

	return true;
}

/**
 * Collect the original and generated attachment-size files from metadata.
 *
 * @return string[]
 */
function ipa_image_webp_attachment_files( array $metadata, int $attachment_id ): array {
	$attached_file = get_attached_file( $attachment_id );
	if ( ! is_string( $attached_file ) || '' === $attached_file ) {
		return array();
	}

	$directory = dirname( $attached_file );
	$files     = array( $attached_file => true );

	if ( ! empty( $metadata['original_image'] ) && is_string( $metadata['original_image'] ) ) {
		$files[ $directory . DIRECTORY_SEPARATOR . basename( $metadata['original_image'] ) ] = true;
	}

	if ( ! empty( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ) {
		foreach ( $metadata['sizes'] as $size ) {
			if ( ! empty( $size['file'] ) && is_string( $size['file'] ) ) {
				$files[ $directory . DIRECTORY_SEPARATOR . basename( $size['file'] ) ] = true;
			}
		}
	}

	return array_keys( $files );
}

/**
 * Generate WebP siblings whenever WordPress generates attachment metadata.
 */
function ipa_image_webp_generate_attachment( array $metadata, int $attachment_id ): array {
	foreach ( ipa_image_webp_attachment_files( $metadata, $attachment_id ) as $source ) {
		ipa_image_webp_generate_file( $source );
	}

	return $metadata;
}
add_filter( 'wp_generate_attachment_metadata', 'ipa_image_webp_generate_attachment', 20, 2 );

/**
 * Remove generated siblings when an attachment is deleted.
 */
function ipa_image_webp_delete_attachment( int $attachment_id ): void {
	$metadata = wp_get_attachment_metadata( $attachment_id );
	if ( ! is_array( $metadata ) ) {
		$metadata = array();
	}

	foreach ( ipa_image_webp_attachment_files( $metadata, $attachment_id ) as $source ) {
		$target = ipa_image_webp_target_path( $source );
		if ( is_file( $target ) ) {
			wp_delete_file( $target );
		}
	}
}
add_action( 'delete_attachment', 'ipa_image_webp_delete_attachment', 10, 1 );
