from pathlib import Path
import re
import unittest


class SeoOnPageRemediationContractTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        repo_root = Path(__file__).resolve().parents[3]
        cls.functions = (repo_root / "wp-content/themes/masterstudy-child/functions.php").read_text(encoding="utf-8")
        cls.source = (repo_root / "wp-content/themes/masterstudy-child/inc/seo-onpage.php").read_text(encoding="utf-8")

    def test_child_theme_loads_onpage_module(self):
        self.assertIn("inc/seo-onpage.php", self.functions)

    def test_all_search_facing_page_paths_have_en_vi_metadata(self):
        paths = [
            "/",
            "/book-a-test/",
            "/communicative-english-for-adults/",
            "/contact-us/",
            "/core-values/",
            "/courses/",
            "/faq/",
            "/founders/",
            "/global-english-for-teen-achievers/",
            "/learning-system/",
            "/testimonials/",
        ]
        for path in paths:
            self.assertIn(f"'{path}' => array(", self.source)
        self.assertEqual(22, self.source.count("'description' =>"))
        self.assertEqual(22, self.source.count("'title' =>"))

    def test_metadata_copy_stays_within_reviewed_length_ranges(self):
        titles = re.findall(r"'title' => '([^']+)'", self.source)
        descriptions = re.findall(r"'description' => '([^']+)'", self.source)
        self.assertEqual(22, len(titles))
        self.assertEqual(22, len(descriptions))
        for title in titles:
            self.assertGreaterEqual(len(title), 30, title)
            self.assertLessEqual(len(title), 60, title)
        for description in descriptions:
            self.assertGreaterEqual(len(description), 120, description)
            self.assertLessEqual(len(description), 160, description)

    def test_heading_remediation_covers_missing_and_multiple_h1_pages(self):
        for path in (
            "/communicative-english-for-adults/",
            "/contact-us/",
            "/core-values/",
            "/faq/",
            "/testimonials/",
            "/founders/",
        ):
            self.assertIn(path, self.source)
        self.assertIn("ipaenglish_fix_landing_page_heading_hierarchy", self.source)
        self.assertIn("preg_replace( '#<h1([^>]*)>#i', '<h2$1>'", self.source)

    def test_informative_media_have_language_aware_alt_copy(self):
        for attachment_id in (12232, 12252, 12297, 12299, 12350, 12410, 12525, 12804, 13062, 13482):
            self.assertRegex(self.source, rf"\b{attachment_id}\s*=>")
        self.assertNotRegex(self.source, r"\b13221\s*=>")
        self.assertIn("Decorative language flags, icons and slider placeholders intentionally retain alt=\"\"", self.source)


if __name__ == "__main__":
    unittest.main()
