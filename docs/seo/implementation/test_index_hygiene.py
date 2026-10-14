from pathlib import Path
import unittest


class SeoIndexHygieneContractTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        repo_root = Path(__file__).resolve().parents[3]
        cls.plugin_path = repo_root / "wp-content" / "mu-plugins" / "ipa-seo-index-hygiene.php"
        cls.source = cls.plugin_path.read_text(encoding="utf-8")

    def test_multilingual_page_sitemap_is_enabled(self):
        self.assertIn("wp_sitemaps_posts_pre_url_list", self.source)
        self.assertIn("TRP_Translate_Press", self.source)
        self.assertIn("publish-languages", self.source)
        self.assertIn("ipaenglish_seo_translated_urls", self.source)

    def test_low_value_archives_are_noindex(self):
        self.assertIn("0 === strpos( $path, 'category/' )", self.source)
        self.assertIn("0 === strpos( $path, 'tag/' )", self.source)
        self.assertIn("'teachers' === $path", self.source)
        self.assertIn("is_post_type_archive( 'teachers' )", self.source)
        self.assertIn("array( 'users', 'taxonomies' )", self.source)

    def test_duplicate_and_legacy_routes_are_normalized(self):
        self.assertIn("stm_lms_course_category/", self.source)
        self.assertIn("array( 'p', 'page_id' )", self.source)
        self.assertIn("wp_safe_redirect", self.source)
        self.assertIn("ipaenglish_seo_non_tracking_query_keys", self.source)


if __name__ == "__main__":
    unittest.main()
