<?php
/**
 * Plugin Name: IPA English SEO Index Hygiene
 * Description: Keeps utility/demo URLs out of XML sitemaps and adds noindex signals where indexing has no search value.
 * Version: 1.1.1
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
 * Resolve the translated public URLs for one canonical WordPress permalink.
 *
 * TranslatePress does not extend the native WordPress sitemap on this install,
 * even though the translated pages have their own self-canonical URLs and hreflang.
 * This helper exposes every published language URL to the sitemap provider.
 *
 * @param string $url Canonical permalink in the default language.
 * @return string[]
 */
function ipaenglish_seo_translated_urls( $url ) {
	$urls = array( $url );

	if ( ! class_exists( 'TRP_Translate_Press' ) ) {
		return $urls;
	}

	$trp                = TRP_Translate_Press::get_trp_instance();
	$url_converter      = $trp->get_component( 'url_converter' );
	$settings_component = $trp->get_component( 'settings' );
	$settings           = $settings_component->get_settings();
	$languages          = isset( $settings['publish-languages'] ) && is_array( $settings['publish-languages'] )
		? $settings['publish-languages']
		: array();

	if ( ! $url_converter || empty( $languages ) ) {
		return $urls;
	}

	add_filter( 'trp_add_language_to_home_url_check_for_admin', '__return_false' );

	$absolute_home = method_exists( $url_converter, 'get_abs_home' ) ? $url_converter->get_abs_home() : get_option( 'home' );
	$is_home_url    = untrailingslashit( (string) $url ) === untrailingslashit( (string) $absolute_home );

	foreach ( $languages as $language ) {
		if ( $is_home_url && method_exists( $url_converter, 'get_url_slug' ) ) {
			$language_slug = $url_converter->get_url_slug( $language );
			$translated_url = trailingslashit( (string) $absolute_home ) . ( '' !== $language_slug ? trailingslashit( $language_slug ) : '' );
		} else {
			$translated_url = $url_converter->get_url_for_language( $language, $url, '' );
		}

		if ( is_string( $translated_url ) && '' !== $translated_url ) {
			$urls[] = $translated_url;
		}
	}

	remove_filter( 'trp_add_language_to_home_url_check_for_admin', '__return_false' );

	return array_values( array_unique( array_map( 'esc_url_raw', $urls ) ) );
}

/**
 * Build the complete search-facing page sitemap, including every published language.
 *
 * The site currently has far more published WordPress page objects than actual search
 * landing pages. We query all published pages, remove the explicit non-index set, then
 * add one sitemap entry per published TranslatePress language. With the current site
 * inventory this produces the English + Vietnamese variants of the 11 real landing pages.
 *
 * @param array[]|null $url_list  Pre-generated URL list.
 * @param string       $post_type Post type.
 * @param int          $page_num  Sitemap page number.
 * @return array[]|null
 */
function ipaenglish_seo_multilingual_page_sitemap( $url_list, $post_type, $page_num ) {
	if ( 'page' !== $post_type ) {
		return $url_list;
	}

	if ( 1 !== (int) $page_num ) {
		return array();
	}

	$query = new WP_Query(
		array(
			'post_type'              => 'page',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'ID',
			'order'                  => 'ASC',
			'post__not_in'           => ipaenglish_seo_non_index_page_ids(),
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$entries = array();

	foreach ( $query->posts as $post ) {
		$permalink = get_permalink( $post );

		if ( ! is_string( $permalink ) || '' === $permalink ) {
			continue;
		}

		foreach ( ipaenglish_seo_translated_urls( $permalink ) as $translated_url ) {
			$entries[] = array(
				'loc'     => $translated_url,
				'lastmod' => wp_date( DATE_W3C, strtotime( $post->post_modified_gmt ) ),
			);
		}
	}

	return $entries;
}
add_filter( 'wp_sitemaps_posts_pre_url_list', 'ipaenglish_seo_multilingual_page_sitemap', 10, 3 );

/**
 * The multilingual page provider is intentionally emitted as one bounded sitemap.
 *
 * @param int|null $max_num_pages Existing override.
 * @param string   $post_type     Post type.
 * @return int|null
 */
function ipaenglish_seo_multilingual_page_sitemap_max_pages( $max_num_pages, $post_type ) {
	if ( 'page' === $post_type ) {
		return 1;
	}

	return $max_num_pages;
}
add_filter( 'wp_sitemaps_posts_pre_max_num_pages', 'ipaenglish_seo_multilingual_page_sitemap_max_pages', 10, 2 );

/**
 * Remove utility/template pages and explicitly thin teacher profiles from native sitemaps.
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
 * Author and taxonomy archives are not search landing pages on this site, so do not
 * advertise users/taxonomies sitemap providers.
 *
 * @param WP_Sitemaps_Provider $provider Sitemap provider instance.
 * @param string               $name     Provider name.
 * @return WP_Sitemaps_Provider|false
 */
function ipaenglish_seo_filter_sitemap_provider( $provider, $name ) {
	if ( in_array( $name, array( 'users', 'taxonomies' ), true ) ) {
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
 * Get the language slug from the current request, if one is present.
 *
 * @return string
 */
function ipaenglish_seo_request_language_slug() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );

	if ( ! is_string( $path ) ) {
		return '';
	}

	$segments = explode( '/', trim( rawurldecode( $path ), '/' ) );

	if ( ! empty( $segments[0] ) && preg_match( '/^[a-z]{2}(?:-[a-z]{2})?$/i', $segments[0] ) ) {
		return strtolower( $segments[0] );
	}

	return '';
}

/**
 * Build an absolute public URL without TranslatePress re-applying the current
 * request language through WordPress' home_url filter.
 *
 * @param string $path Optional public path.
 * @return string
 */
function ipaenglish_seo_absolute_home_url( $path = '' ) {
	$base = '';

	if ( class_exists( 'TRP_Translate_Press' ) ) {
		$trp           = TRP_Translate_Press::get_trp_instance();
		$url_converter = $trp->get_component( 'url_converter' );

		if ( $url_converter && method_exists( $url_converter, 'get_abs_home' ) ) {
			$base = (string) $url_converter->get_abs_home();
		}
	}

	if ( '' === $base ) {
		$base = (string) get_option( 'home' );
	}

	return esc_url_raw( trailingslashit( $base ) . ltrim( (string) $path, '/' ) );
}

/**
 * Remove one leading language slug from a permalink path before rebuilding a
 * language-specific canonical target. This makes redirect generation idempotent.
 *
 * @param string $path URL path.
 * @return string
 */
function ipaenglish_seo_path_without_language_slug( $path ) {
	$segments = explode( '/', trim( rawurldecode( (string) $path ), '/' ) );

	if ( ! empty( $segments[0] ) && preg_match( '/^[a-z]{2}(?:-[a-z]{2})?$/i', $segments[0] ) ) {
		array_shift( $segments );
	}

	return implode( '/', $segments );
}

/**
 * Identify non-tracking query parameters.
 *
 * @return string[]
 */
function ipaenglish_seo_non_tracking_query_keys() {
	$keys = array_keys( $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only URL classification.

	return array_values(
		array_filter(
			$keys,
			static function ( $key ) {
				return ! preg_match( '/^(?:utm_.+|gclid|fbclid|msclkid)$/i', (string) $key );
			}
		)
	);
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

	if ( 'teachers' === $path || 0 === strpos( $path, 'category/' ) || 0 === strpos( $path, 'tag/' ) ) {
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

	if ( 'courses' === $path && ! empty( ipaenglish_seo_non_tracking_query_keys() ) ) {
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

	if ( function_exists( 'is_category' ) && is_category() ) {
		return true;
	}

	if ( function_exists( 'is_tag' ) && is_tag() ) {
		return true;
	}

	if ( function_exists( 'is_post_type_archive' ) && is_post_type_archive( 'teachers' ) ) {
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
 * Convert legacy LMS taxonomy 404s and raw WordPress numeric aliases into durable
 * canonical redirects so they stop consuming crawl budget as separate URLs.
 */
function ipaenglish_seo_canonical_redirects() {
	if ( is_admin() ) {
		return;
	}

	$path          = ipaenglish_seo_request_path();
	$language_slug = ipaenglish_seo_request_language_slug();

	if ( 0 === strpos( $path, 'stm_lms_course_category/' ) && ! preg_match( '#/feed/?$#', $path ) ) {
		$target_path = ( '' !== $language_slug ? $language_slug . '/' : '' ) . 'courses/';
		wp_safe_redirect( ipaenglish_seo_absolute_home_url( $target_path ), 301 );
		exit;
	}

	$numeric_id = 0;
	$query_keys = ipaenglish_seo_non_tracking_query_keys();

	if ( 1 === count( $query_keys ) && in_array( $query_keys[0], array( 'p', 'page_id' ), true ) ) {
		$numeric_id = isset( $_GET[ $query_keys[0] ] ) ? absint( wp_unslash( $_GET[ $query_keys[0] ] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- canonical redirect only.
	}

	if ( $numeric_id > 0 ) {
		$post = get_post( $numeric_id );

		if ( $post instanceof WP_Post && 'publish' === $post->post_status ) {
			$target = get_permalink( $post );

			if ( is_string( $target ) && '' !== $target ) {
				$target_path = wp_parse_url( $target, PHP_URL_PATH );
				$target_path = ipaenglish_seo_path_without_language_slug( (string) $target_path );
				$target      = ipaenglish_seo_absolute_home_url(
					( '' !== $language_slug ? $language_slug . '/' : '' ) . $target_path
				);

				wp_safe_redirect( $target, 301 );
				exit;
			}
		}
	}
}
add_action( 'template_redirect', 'ipaenglish_seo_canonical_redirects', 1 );

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
