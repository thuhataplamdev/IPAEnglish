<?php
/**
 * Plugin Name: IPA English SEO Index Hygiene
 * Description: Keeps utility/demo URLs out of XML sitemaps and adds noindex signals where indexing has no search value.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Page paths that are operational/template surfaces rather than search landing pages.
 *
 * Keep this list deliberately explicit. A page should only be added when the business
 * does not want it indexed and there is a separate search-facing destination if needed.
 *
 * @return string[]
 */
function ipaenglish_seo_non_index_page_paths() {
	return array(
		'blog',
		'user-account',
		'user-public-account',
		'user-public-account/tony-evans',
		'wishlist',
		'checkout',
		'membership-account',
		'membership-account/membership-billing',
		'membership-account/membership-cancel',
		'membership-account/membership-checkout',
		'membership-account/membership-confirmation',
		'membership-account/membership-invoice',
		'membership-account/membership-plans',
		'shortcodes',
		'typography',
		'home-page-two',
		'shop',
		'cart',
		'my-account',
		'courses-archive-gutenberg',
		'certificate-page',
	);
}

/**
 * Teacher profiles that are currently too thin to be useful search landing pages.
 *
 * Keep this list explicit so a future, substantive teacher profile can remain
 * indexable without reopening the whole teachers post type.
 *
 * @return string[]
 */
function ipaenglish_seo_non_index_teacher_slugs() {
	return array(
		'anthony-evans',
	);
}

/**
 * Resolve non-index page IDs for native WordPress page sitemap filtering.
 *
 * @return int[]
 */
function ipaenglish_seo_non_index_page_ids() {
	static $ids = null;

	if ( null !== $ids ) {
		return $ids;
	}

	$ids = array();

	foreach ( ipaenglish_seo_non_index_page_paths() as $path ) {
		$page = get_page_by_path( $path, OBJECT, 'page' );

		if ( $page instanceof WP_Post ) {
			$ids[] = (int) $page->ID;
		}
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Remove utility/template pages from the native page sitemap.
 *
 * @param array  $args      WP_Query arguments.
 * @param string $post_type Post type name.
 * @return array
 */
function ipaenglish_seo_filter_sitemap_posts_query_args( $args, $post_type ) {
	$excluded_ids = array();

	if ( 'page' === $post_type ) {
		$excluded_ids = ipaenglish_seo_non_index_page_ids();
	} elseif ( 'teachers' === $post_type ) {
		foreach ( ipaenglish_seo_non_index_teacher_slugs() as $slug ) {
			$teacher = get_page_by_path( $slug, OBJECT, 'teachers' );

			if ( $teacher instanceof WP_Post ) {
				$excluded_ids[] = (int) $teacher->ID;
			}
		}
	} else {
		return $args;
	}

	if ( empty( $excluded_ids ) ) {
		return $args;
	}

	$existing_exclusions = isset( $args['post__not_in'] ) && is_array( $args['post__not_in'] )
		? $args['post__not_in']
		: array();

	$args['post__not_in'] = array_values(
		array_unique(
			array_merge( $existing_exclusions, $excluded_ids )
		)
	);

	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'ipaenglish_seo_filter_sitemap_posts_query_args', 10, 2 );

/**
 * Remove demo certificate posts from the native sitemap index.
 *
 * @param WP_Post_Type[] $post_types Public sitemap post types.
 * @return WP_Post_Type[]
 */
function ipaenglish_seo_filter_sitemap_post_types( $post_types ) {
	unset( $post_types['stm-certificates'] );

	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'ipaenglish_seo_filter_sitemap_post_types' );

/**
 * Author archives are not search landing pages on this site, so do not advertise
 * a users sitemap at all.
 *
 * @param WP_Sitemaps_Provider $provider Sitemap provider instance.
 * @param string               $name     Provider name.
 * @return WP_Sitemaps_Provider|false
 */
function ipaenglish_seo_filter_sitemap_provider( $provider, $name ) {
	if ( 'users' === $name ) {
		return false;
	}

	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'ipaenglish_seo_filter_sitemap_provider', 10, 2 );

/**
 * Normalize the public request path and drop a leading language code such as /vi/.
 *
 * @return string
 */
function ipaenglish_seo_request_path() {
	static $normalized_path = null;

	if ( null !== $normalized_path ) {
		return $normalized_path;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );

	if ( ! is_string( $path ) ) {
		$normalized_path = '';
		return $normalized_path;
	}

	$path     = trim( rawurldecode( $path ), '/' );
	$segments = '' === $path ? array() : explode( '/', $path );

	if ( ! empty( $segments ) && preg_match( '/^[a-z]{2}(?:-[a-z]{2})?$/i', $segments[0] ) ) {
		array_shift( $segments );
	}

	$normalized_path = implode( '/', $segments );

	return $normalized_path;
}

/**
 * Classify non-indexable requests using URI data only.
 *
 * This is safe to call while WordPress is still building response headers, before
 * conditional query tags are guaranteed to be available.
 *
 * @return bool
 */
function ipaenglish_seo_request_uri_is_non_indexable() {
	$path = ipaenglish_seo_request_path();

	if ( in_array( $path, ipaenglish_seo_non_index_page_paths(), true ) ) {
		return true;
	}

	if ( 0 === strpos( $path, 'stm-certificates/' ) || 0 === strpos( $path, 'author/' ) ) {
		return true;
	}

	if ( 0 === strpos( $path, 'teachers/' ) ) {
		$teacher_slug = substr( $path, strlen( 'teachers/' ) );

		if ( in_array( $teacher_slug, ipaenglish_seo_non_index_teacher_slugs(), true ) ) {
			return true;
		}
	}

	if ( 'feed' === $path || preg_match( '#/feed/?$#', $path ) ) {
		return true;
	}

	if ( 'courses' === $path && isset( $_GET['search'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only URL classification.
		return true;
	}

	return false;
}

/**
 * Determine whether the current request is intentionally non-indexable.
 *
 * @return bool
 */
function ipaenglish_seo_request_is_non_indexable() {
	if ( ipaenglish_seo_request_uri_is_non_indexable() ) {
		return true;
	}

	if ( function_exists( 'is_search' ) && is_search() ) {
		return true;
	}

	if ( function_exists( 'is_author' ) && is_author() ) {
		return true;
	}

	if ( function_exists( 'is_feed' ) && is_feed() ) {
		return true;
	}

	if ( function_exists( 'is_singular' ) && is_singular( 'stm-certificates' ) ) {
		return true;
	}

	return false;
}

/**
 * Add a native robots meta directive for HTML utility/archive pages.
 *
 * @param array $robots Robots directives.
 * @return array
 */
function ipaenglish_seo_filter_robots( $robots ) {
	if ( ipaenglish_seo_request_is_non_indexable() ) {
		unset( $robots['index'] );
		$robots['noindex'] = true;
	}

	return $robots;
}
add_filter( 'wp_robots', 'ipaenglish_seo_filter_robots', 20 );

/**
 * Send an HTTP noindex signal too, which also covers feeds/non-HTML responses that
 * do not render wp_robots() in a document head.
 *
 * @param array $headers Response headers.
 * @return array
 */
function ipaenglish_seo_filter_headers( $headers ) {
	if ( ipaenglish_seo_request_uri_is_non_indexable() ) {
		$headers['X-Robots-Tag'] = 'noindex, follow';
	}

	return $headers;
}
add_filter( 'wp_headers', 'ipaenglish_seo_filter_headers', 20 );

/**
 * Give the substantive Core Values page a crawlable internal link from the
 * existing footer menu. The page is intentionally kept indexable and in the
 * sitemap; this link removes its current orphan-page condition.
 *
 * @param string   $items Rendered menu item HTML.
 * @param stdClass $args  wp_nav_menu() arguments.
 * @return string
 */
function ipaenglish_seo_add_core_values_footer_link( $items, $args ) {
	if ( empty( $args->theme_location ) || 'secondary' !== $args->theme_location ) {
		return $items;
	}

	$core_values_url = home_url( '/core-values/' );

	if ( false !== strpos( $items, $core_values_url ) ) {
		return $items;
	}

	$items .= sprintf(
		'<li class="menu-item ipaenglish-seo-core-values-link"><a href="%1$s">%2$s</a></li>',
		esc_url( $core_values_url ),
		esc_html__( 'Core Values', 'masterstudy' )
	);

	return $items;
}
add_filter( 'wp_nav_menu_items', 'ipaenglish_seo_add_core_values_footer_link', 20, 2 );
