# SEO-W2-04 Index Hygiene Evidence — 2026-10-12

## Trigger

The official W1-02 crawl had 0 internal 3xx/4xx/5xx and 0 redirect chains, so W2-04 was originally a baseline no-op. Google Search Console later reported new exclusion categories including intentional redirects, one 404, a duplicate feed, and multiple Crawled/Discovered-not-indexed utility/demo/account URLs. This evidence records the bounded remediation without inventing redirects for URLs that have no equivalent replacement.

## Pre-hotfix observations

The native WordPress sitemap index exposed four child providers:

- `wp-sitemap-posts-page-1.xml`
- `wp-sitemap-posts-teachers-1.xml`
- `wp-sitemap-posts-stm-certificates-1.xml`
- `wp-sitemap-users-1.xml`

The page sitemap advertised operational/template surfaces such as account, membership, checkout/cart/wishlist, shortcodes/typography, `home-page-two`, `courses-archive-gutenberg`, and certificate utility pages. The certificate sitemap exposed `stm-certificates/demo-1/` through `demo-10/`. The users sitemap exposed author archives.

## Implementation

Production and repository owner: `wp-content/mu-plugins/ipa-seo-index-hygiene.php`.

The MU-plugin:

1. Uses `wp_sitemaps_posts_query_args` to exclude an explicit allow-reviewed list of non-search WordPress pages from the native page sitemap.
2. Uses `wp_sitemaps_post_types` to remove the demo `stm-certificates` post type from the sitemap index.
3. Uses `wp_sitemaps_add_provider` to remove the users sitemap provider because author archives are not search landing pages.
4. Uses native `wp_robots` plus `X-Robots-Tag: noindex, follow` for explicit utility/feed/author/demo request patterns.
5. Leaves the four priority SEO URLs indexable.
6. Does not create a blanket Home redirect and does not redirect the obsolete LMS category without a 1:1 replacement.

Production file SHA-256 after deployment:

`ef6a1f591e55402c3f3e866d98c881865cc14f8029e1cb60e687fd03c539503f`

Remote PHP lint: PASS.

## Runtime verification after deployment

### Sitemap index

`https://www.ipaenglish.com/wp-sitemap.xml` now exposes only:

- `https://www.ipaenglish.com/wp-sitemap-posts-page-1.xml`
- `https://www.ipaenglish.com/wp-sitemap-posts-teachers-1.xml`

The `stm-certificates` and `users` providers are absent.

### Page sitemap

The current page sitemap contains the search-facing pages observed at verification time: Founders, Contact Us, Blog, Learning System, Book a Test, Core Values, Testimonials, FAQ, Communicative English for Adults, Courses, and Global English for Teen Achievers.

Verified absent from the page/sitemap index sample: `user-account`, `wishlist`, `checkout`, membership account paths, `shortcodes`, `typography`, `home-page-two`, `cart`, `courses-archive-gutenberg`, `certificate-page`, certificate demo URLs, and author sitemap URLs.

### Priority target safety

All four target pages returned HTTP 200 with no `X-Robots-Tag` noindex and no robots meta noindex:

- `/vi/`
- `/vi/global-english-for-teen-achievers/`
- `/vi/book-a-test/`
- `/vi/learning-system/`

### Intentional noindex samples

The following samples returned HTTP 200 with `X-Robots-Tag: noindex, follow`:

- `/vi/user-account/`
- `/vi/wishlist/`
- `/cart/`
- `/vi/author/translate/feed/`
- `/stm-certificates/demo-1/`

### 404 and redirect policy

- `/stm_lms_course_category/english/` remains HTTP 404 with no redirect because no equivalent replacement was identified.
- A production database search found no literal `stm_lms_course_category/english` reference in post content, post meta, or options. No internal source URL was therefore changed.
- `http://ipaenglish.com/` -> `https://www.ipaenglish.com/`: 301.
- `https://ipaenglish.com/` -> `https://www.ipaenglish.com/`: 301.
- `http://www.ipaenglish.com/` -> `https://www.ipaenglish.com/`: 308.

These host/scheme normalizations are intentional and direct; no Home redirect was added for content 404s.

## Search Console follow-up

The cleaned `https://www.ipaenglish.com/wp-sitemap.xml` was re-submitted on 2026-10-12. GSC accepted it (`confirmed=true`), reported 0 warnings / 0 errors at submission time, and returned `isPending=true`, meaning Google queued a fresh download. Sitemap submission does not itself force indexing.

Fresh URL Inspection on 2026-10-12:

- `/vi/`: `Submitted and indexed`, robots allowed, indexing allowed, successful fetch, self canonical.
- `/vi/global-english-for-teen-achievers/`: `Submitted and indexed`, robots allowed, indexing allowed, successful fetch, self canonical.
- `/vi/learning-system/`: `Submitted and indexed`, robots allowed, indexing allowed, successful fetch, self canonical.
- `/vi/book-a-test/`: `Crawled - currently not indexed`, while robots are allowed, indexing is allowed, fetch is successful, and Google/user canonical are both the page itself.

The Book a Test state is not a robots/redirect/canonical defect. Recovery is assigned to W2-01/W2-02 so its title/meta/H1/copy/internal-link signals can be strengthened before requesting another crawl/index decision.

## Rollback

Remove `/srv/apps/IPAEnglish/wp-content/mu-plugins/ipa-seo-index-hygiene.php`, then re-verify `wp-sitemap.xml` and affected utility URLs. No WordPress core file or database content was mutated by this hotfix.
