# W1-02 official Screaming Frog crawl — 2026-10-07

This directory is the authoritative W1-02 crawl evidence. The earlier `fallback-2026-10-07` directory is retained only as an independent cross-check.

## Crawl configuration

- Tool: Screaming Frog SEO Spider 24.3 (free mode; no licence key stored).
- Start URL: `https://www.ipaenglish.com/`.
- Mode: Spider / standard HTML crawl; no authenticated areas.
- User-Agent: `Screaming Frog SEO Spider/24.3`.
- Crawl limit: 500 URLs.
- Images enabled.
- External URLs may be checked for response/redirect signals but are excluded from internal totals.
- EULA acceptance was supplied in a temporary runtime home after explicit operator consent; the EULA config and RPM are not stored in this repository.
- Use the same Spider mode, User-Agent, limit and target host for the W3 re-crawl.

## Official baseline summary

- Internal resources: 142.
- Internal HTML: 26.
- Internal 3xx / 4xx / 5xx: 0 / 0 / 0.
- External/discovered redirects: 2 (Google Maps 301 and Messenger 302); redirect chains: 0.
- Missing titles: 0; duplicate-title rows: 26 across 12 duplicate groups.
- Titles under 30 chars: 20; over 60 chars: 0.
- Missing Meta Descriptions: 26 / 26; duplicate non-empty descriptions: 0.
- Missing H1: 18 / 26; multiple H1: 2.
- Unique images: 15; images missing ALT text: 12 unique images / 50 inlink occurrences.
- Missing ALT attribute: 0 unique images.
- Images over 100 kB: 2 unique images / 4 inlink occurrences.
- Noindex directives: 0.
- HTML pages missing canonical: 0.
- All four required Vietnamese target URLs are present, return 200, are Indexable, and have self-referencing canonicals.

## Evidence layout

- `raw/`: direct Screaming Frog CSV exports.
- `derived/`: deterministic issue slices created from the direct exports for easier review; these do not replace the raw exports.
- `crawl-summary.json`: machine-readable summary of the official exports.
- `runtime-proof.txt`: concise runtime proof including version, free-mode licence status, EULA acknowledgement, crawl start/completion and exit codes.

## Key target-page H1 result

The official crawl confirms that `/vi/global-english-for-teen-achievers/`, `/vi/book-a-test/`, and `/vi/learning-system/` have no H1 in the crawled HTML. `/vi/` has one H1: `Học Viện Anh Ngữ IPA`.
