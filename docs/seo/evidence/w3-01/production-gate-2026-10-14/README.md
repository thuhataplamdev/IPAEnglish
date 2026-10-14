# IPAEnglish production SEO gate — 2026-10-14

## Scope

Post-merge hotfix verification for the full site indexing inventory. The gate was restarted from the beginning after fixing two production regressions: the missing Vietnamese homepage in the multilingual page sitemap and duplicated `/vi/` prefixes in canonical redirects.

## Hotfix

- MU-plugin: `wp-content/mu-plugins/ipa-seo-index-hygiene.php`
- Production version: `1.1.1`
- Production SHA-256: `4cc6342336982d8edc0d5bb41ac1c2afa77f8f63fabbdb75b825a03dbd3e4daa`
- Previous production file backup timestamp: `20261014-175237`
- Fixes:
  - build redirect targets from TranslatePress' unfiltered absolute home URL;
  - strip any existing language prefix before rebuilding a language-specific canonical target;
  - explicitly preserve translated homepage URLs in the page sitemap.

## Gate results

### 1. PHP lint

PASS on the production PHP runtime:

`No syntax errors detected in wp-content/mu-plugins/ipa-seo-index-hygiene.php`

### 2. Cache purge

PASS via W3 Total Cache `w3tc_flush_all()`.

### 3. Sitemap

PASS.

- `https://www.ipaenglish.com/wp-sitemap.xml` → HTTP 200.
- `https://www.ipaenglish.com/wp-sitemap-posts-page-1.xml` → HTTP 200.
- Exact expected search landing inventory: 22 URLs.
- Actual child sitemap inventory: 22 URLs.
- Missing: 0.
- Extra: 0.
- Root sitemap advertises only the page child sitemap.

### 4. Full 190-URL inventory crawl

PASS. See `inventory-190.csv`.

- 190 URLs fetched.
- 164 HTTP 200.
- 24 HTTP 301.
- 1 HTTP 405 (`xmlrpc.php`, expected application endpoint behavior).
- 1 HTTP 400 (`wp-admin/admin-ajax.php`, expected application endpoint behavior without an action).
- Request/network errors: 0.

### 5. Noindex matrix

PASS.

| Group | URLs checked | Result |
|---|---:|---|
| Utility/template/account pages | 42 | 42/42 noindex |
| Categories | 6 | 6/6 noindex |
| Tags | 18 | 18/18 noindex |
| Authors | 4 | 4/4 noindex |
| Teachers archive/thin profile | 4 | 4/4 noindex |
| Feeds | 36 | 36/36 noindex |
| Certificate demo URLs | 14 | 14/14 noindex |
| Course query/faceted URLs | 4 | 4/4 noindex |
| Search pages | 2 | 2/2 noindex |
| oEmbed endpoints | 2 | 2/2 noindex |

### 6. Redirect matrix

PASS.

- `/stm_lms_course_category/english/` → 301 `/courses/`.
- `/vi/stm_lms_course_category/english/` → 301 `/vi/courses/`.
- 22/22 numeric WordPress aliases (`?p=<id>`) → one clean 301 to the language-matched canonical URL.
- No `/vi/vi/` duplication remains.

### 7. Landing-page audit

PASS for the indexing gate. See `landing-audit-22.csv`.

All 22 intended EN + VI landing URLs are:

- HTTP 200;
- live-indexable;
- self-canonical;
- free of `noindex`;
- exposing three hreflang entries.

GSC Wizard live on-page audit independently confirmed 22 indexable / 0 non-indexable. It also reported 83 content/on-page issues (10 high, 12 medium, 61 low), primarily missing H1/meta descriptions/image ALT on non-priority pages. These are on-page backlog items, not crawl/index blockers for this gate.

### 8. GSC sitemap resubmission

PASS.

- Re-submitted `https://www.ipaenglish.com/wp-sitemap.xml` on 2026-10-14.
- Accepted and downloaded by Google.
- Sitemap warnings: 0.
- Sitemap errors: 0.
- GSC Wizard live sitemap fetch extracted 22 URLs.
- Immediately after download, Search Console's sitemap aggregate still reported the previous `13 submitted / 0 indexed`; this is a GSC reporting lag, not the live sitemap contents.

### 9. Google URL Inspection — all 22 intended URLs

Completed 22/22.

| URL | Verdict | Coverage |
|---|---|---|
| `/` | PASS | Submitted and indexed |
| `/book-a-test/` | PASS | Submitted and indexed |
| `/communicative-english-for-adults/` | PASS | Submitted and indexed |
| `/contact-us/` | PASS | Submitted and indexed |
| `/core-values/` | NEUTRAL | Discovered - currently not indexed |
| `/courses/` | PASS | Submitted and indexed |
| `/faq/` | PASS | Submitted and indexed |
| `/founders/` | PASS | Submitted and indexed |
| `/global-english-for-teen-achievers/` | PASS | Submitted and indexed |
| `/learning-system/` | PASS | Submitted and indexed |
| `/testimonials/` | PASS | Submitted and indexed |
| `/vi/` | PASS | Submitted and indexed |
| `/vi/book-a-test/` | NEUTRAL | Crawled - currently not indexed |
| `/vi/communicative-english-for-adults/` | PASS | Submitted and indexed |
| `/vi/contact-us/` | PASS | Submitted and indexed |
| `/vi/core-values/` | NEUTRAL | URL is unknown to Google |
| `/vi/courses/` | NEUTRAL | Crawled - currently not indexed |
| `/vi/faq/` | PASS | Submitted and indexed |
| `/vi/founders/` | NEUTRAL | Crawled - currently not indexed |
| `/vi/global-english-for-teen-achievers/` | PASS | Submitted and indexed |
| `/vi/learning-system/` | PASS | Submitted and indexed |
| `/vi/testimonials/` | NEUTRAL | Crawled - currently not indexed |

Summary: 16 PASS / indexed, 6 NEUTRAL. For the four crawled-but-not-indexed URLs Google reports `INDEXING_ALLOWED` and self-canonical URLs. The two Core Values variants have not yet been fully crawled/recognized by Google. Production crawlability/indexability checks are clean for all 22.
