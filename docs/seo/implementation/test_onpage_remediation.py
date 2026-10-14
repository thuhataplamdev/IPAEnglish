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
        self.assertEqual(22, len(re.findall(r"'description' => '[^']+'", self.source)))
        self.assertEqual(22, len(re.findall(r"'title' => '[^']+'", self.source)))

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

    def test_rendered_html_covers_elementor_and_footer_image_alt(self):
        self.assertIn("ipaenglish_start_onpage_html_buffer", self.source)
        self.assertIn("WP_HTML_Tag_Processor", self.source)
        self.assertIn("wp-image-", self.source)
        self.assertIn("preg_match", self.source)
        self.assertIn("set_attribute( 'alt'", self.source)

    def test_social_and_structured_metadata_are_rendered_for_landing_pages(self):
        self.assertIn("ipaenglish_render_social_and_structured_metadata", self.source)
        self.assertIn('property=\"og:title\"', self.source)
        self.assertIn('property=\"og:description\"', self.source)
        self.assertIn('property=\"og:image\"', self.source)
        self.assertIn('name=\"twitter:card\"', self.source)
        self.assertIn('type=\"application/ld+json\"', self.source)
        self.assertIn("'@type'       => 'WebPage'", self.source)

    def test_vietnamese_h1_localization_covers_remaining_english_labels(self):
        self.assertIn("Giá trị cốt lõi", self.source)
        self.assertIn("Khóa học tiếng Anh", self.source)
        self.assertIn("'/core-values/' === $context['path']", self.source)
        self.assertIn("'/courses/' === $context['path']", self.source)


if __name__ == "__main__":
    unittest.main()
