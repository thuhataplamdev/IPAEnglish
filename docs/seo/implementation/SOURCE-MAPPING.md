# Source Mapping

This task pack was derived from repository `main` and does not replace the source specifications.

| Source | Used for |
|---|---|
| `docs/seo/SEO-SRS.md` | scope, actors, roadmap, acceptance, scope guard |
| `docs/seo/SEO-TSD.md` | technical ownership, WordPress integration, testing/deployment guardrails |
| `docs/seo/SEO-ESTIMATE.md` | week-by-week execution plan and effort breakdown |
| `docs/seo/TECHNICAL-SEO-AUDIT.md` | TECH-001..TECH-010 baseline findings/status/evidence model |
| `docs/seo/KEYWORD-MAP.md` | 20-keyword baseline and four Vietnamese target URLs |
| `wp-content/themes/masterstudy-child/functions.php` | minimal child-theme integration touchpoint |
| `.htaccess` | HTTPS/W3TC source-level configuration context |

## Authority order

1. Latest approved SRS/TSD on `main`.
2. Live production/runtime evidence.
3. Audit/Keyword Map working documents.
4. This task pack.

If production behavior differs from tracked source, document the difference before changing code/config.
