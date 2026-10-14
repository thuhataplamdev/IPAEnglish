# IPAEnglish full-site indexing inventory — 2026-10-14

## Purpose

This evidence replaces URL-by-URL reactive indexing fixes with a full-site inventory. The scope is not limited to the submitted sitemap or a single Google Search Console export.

## Sources inspected

- Live recursive crawl starting from `/` and `/vi/`.
- WordPress REST inventory for all published `page` objects.
- WordPress REST inventory for categories, tags, and public authors.
- Native WordPress XML sitemap and child sitemaps.
- GSC Wizard latest URL Inspection history for the property.
- GSC Wizard live on-page audit of every intended English/Vietnamese search landing page.
- Google Search Console Coverage Drilldown export dated 2026-10-14.

## Inventory summary

- 190 internal endpoints/URLs were reached or explicitly enumerated in the bounded live crawl.
- 32 published WordPress page objects exist.
- 3 category archives exist; all currently have zero posts.
- 9 tag archives exist; all currently have zero posts.
- 2 public author archives exist.
- English and Vietnamese (`/vi/`) variants are independently crawlable and self-canonical.
- The pre-fix native sitemap exposes only 13 URLs and does not advertise the Vietnamese variants.
- 22 real search landing URLs were audited live: 11 English + 11 Vietnamese.
- All 22 intended landing URLs return HTTP 200, are indexable, self-canonical, and expose hreflang.

## Intended search landing pages

The following 11 logical pages should be indexable in every published TranslatePress language:

1. `/`
2. `/book-a-test/`
3. `/communicative-english-for-adults/`
4. `/contact-us/`
5. `/core-values/`
6. `/courses/`
7. `/faq/`
8. `/founders/`
9. `/global-english-for-teen-achievers/`
10. `/learning-system/`
11. `/testimonials/`

Current published languages produce 22 search-facing URLs (English + Vietnamese).

## Intentionally non-indexable surfaces

### Utility/template/account pages

`/blog/` is currently an empty archive and is excluded until real editorial content exists.

The following published WordPress pages are operational/template surfaces rather than search landing pages and remain excluded from sitemap plus `noindex`:

- `/user-account/`
- `/user-public-account/`
- `/user-public-account/tony-evans/`
- `/wishlist/`
- `/checkout/`
- `/membership-account/` and its child pages
- `/shortcodes/`
- `/typography/`
- `/home-page-two/`
- `/shop/`
- `/cart/`
- `/my-account/`
- `/courses-archive-gutenberg/`
- `/certificate-page/`

The language-prefixed equivalents are covered by the same normalized-path rules.

### Empty/low-value archives

These are crawlable in production but should not be search landing pages in the current information architecture:

- `/category/*/` and `/vi/category/*/`
- `/tag/*/` and `/vi/tag/*/`
- `/author/*/` and language variants
- `/teachers/` and `/vi/teachers/`
- `/teachers/anthony-evans/` while the profile remains thin
- feeds and author feeds
- demo certificate URLs
- WordPress/LMS search and filter variants

## Duplicate and legacy URL handling

- Raw WordPress numeric aliases (`?p=<id>` / `?page_id=<id>`) should 301 to the clean permalink, preserving a language prefix when present.
- LMS course filter/search query variants remain crawlable for users but are `noindex` when the query contains non-tracking parameters.
- Legacy `/stm_lms_course_category/*/` archive URLs currently return 404; they should 301 to the language-matched `/courses/` landing page.
- REST/oEmbed endpoints already emit `noindex` and are not search pages.
- `/wp-sitemap.xml` itself is not expected to be indexed as an HTML page.
- `/wp-admin/admin-ajax.php` and `/xmlrpc.php` are application endpoints, not search landing pages.

## GSC state used for diagnosis

The submitted sitemap reported 13 submitted URLs / 0 indexed in the sitemap aggregate, while direct URL Inspection showed 10 of the 13 current sitemap URLs as indexed. The sitemap aggregate is therefore not used as the sole source of truth.

Latest direct inspection identified `/blog/`, `/core-values/`, and `/teachers/anthony-evans/` as the three non-indexed URLs from the current sitemap. The full-site audit then showed that `/blog/` and the teacher profile are low/no-value search targets, while `/core-values/` is a substantive page that should remain indexable.

## Patch target state

After deployment:

- Sitemap advertises all search-facing pages in all published TranslatePress languages instead of English only.
- Empty categories/tags/authors/teachers archives are not advertised and emit `noindex`.
- Empty Blog and the thin Anthony Evans teacher profile are not advertised and emit `noindex`.
- Faceted/search course URLs emit `noindex` while clean `/courses/` URLs remain indexable.
- Legacy LMS taxonomy 404s 301 to the language-matched Courses page.
- Numeric WordPress aliases 301 to clean permalinks.
- `/core-values/` remains in sitemap and receives a crawlable internal link from the existing secondary/footer menu.

## Deploy verification gates

1. PHP syntax lint on the production/container PHP runtime.
2. Purge WordPress/W3 Total Cache.
3. Verify `wp-sitemap.xml` and page child sitemap return HTTP 200.
4. Verify sitemap contains all intended English + Vietnamese landing URLs and no utility/archive/thin URLs.
5. Verify category/tag/author/teachers/blog/thin teacher samples emit `noindex`.
6. Verify `/stm_lms_course_category/english/` and `/vi/stm_lms_course_category/english/` 301 to the correct Courses landing page.
7. Verify `?p=<page-id>` aliases 301 to the clean language-matched permalink.
8. Resubmit `https://www.ipaenglish.com/wp-sitemap.xml` in GSC.
9. Reinspect every intended sitemap URL, not only the URLs present in the old Coverage export.
