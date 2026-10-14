from pathlib import Path
import re
import unittest


class SeoOnPageRemediationContractTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        repo_root = Path(__file__).resolve().parents[3]
        cls.functions = (repo_root / "wp-content/themes/masterstudy-child/functions.php").read_text(encoding="utf-8")
        cls.source = (repo_root / "wp-content/themes/masterstudy-child/inc/seo-onpage.php").read_text(encoding="utf-8")
        cls.lms_filters = (
            repo_root / "wp-content/plugins/masterstudy-lms-learning-management-system/_core/stm-lms-templates/courses/filters.php"
        ).read_text(encoding="utf-8")

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

    def test_founders_legacy_page_heading_is_demoted_without_touching_profile_h2s(self):
        self.assertIn("Founders|Người(?:&nbsp;|\\x{00A0}|\\s)+Sáng", self.source)
        self.assertIn("'<p$1>$2</p>'", self.source)
        self.assertIn("'Founders of IPA English'", self.source)
        self.assertIn("'Nhà sáng lập IPA English'", self.source)

    def test_informative_media_have_language_aware_alt_copy(self):
        for attachment_id in (12232, 12252, 12297, 12299, 12350, 12410, 12525, 12804, 13062, 13221, 13482):
            self.assertRegex(self.source, rf"\b{attachment_id}\s*=>")
        self.assertIn("Decorative language flags intentionally retain alt=\"\"", self.source)

    def test_rendered_html_covers_elementor_and_footer_image_alt(self):
        self.assertIn("ipaenglish_start_onpage_html_buffer", self.source)
        self.assertIn("false === stripos( $html, '<html' )", self.source)
        self.assertNotIn("null === ipaenglish_get_custom_seo_data()", self.source)
        self.assertIn("WP_HTML_Tag_Processor", self.source)
        self.assertIn("wp-image-", self.source)
        self.assertIn("preg_match", self.source)
        self.assertIn("set_attribute( 'alt'", self.source)
        self.assertIn("/revslider/sr6/assets/assets/dummy.png", self.source)
        self.assertIn("$processor->set_attribute( 'alt', $title )", self.source)

    def test_home_core_values_heading_is_a_crawlable_en_vi_internal_link(self):
        self.assertIn("ipaenglish_link_home_core_values_heading", self.source)
        self.assertIn("if ( '/' !== $context['path'] )", self.source)
        self.assertIn("'Giá trị cốt lõi' : 'Core Values'", self.source)
        self.assertIn("'/vi/core-values/' : '/core-values/'", self.source)
        self.assertIn('class="ipaenglish-seo-core-values-link"', self.source)
        self.assertIn("ipaenglish_link_home_core_values_heading( $html, $context )", self.source)

    def test_social_and_structured_metadata_are_rendered_for_landing_pages(self):
        self.assertIn("ipaenglish_render_social_and_structured_metadata", self.source)
        self.assertIn('property=\"og:title\"', self.source)
        self.assertIn('property=\"og:description\"', self.source)
        self.assertIn('property=\"og:image\"', self.source)
        self.assertIn('name=\"twitter:card\"', self.source)
        self.assertIn('type=\"application/ld+json\"', self.source)
        self.assertIn("'@type'       => 'WebPage'", self.source)

    def test_vietnamese_h1_localization_covers_remaining_english_labels(self):
        self.assertIn("$replacement = '<h1$1>Giá trị cốt lõi</h1>'", self.source)
        self.assertIn("esc_html_e( 'Courses', 'masterstudy-lms-learning-management-system' )", self.lms_filters)
        self.assertIn("add_filter( 'gettext', 'ipaenglish_localize_lms_courses_heading', 999, 3 )", self.source)
        self.assertIn("'Courses' !== $text", self.source)
        self.assertIn("'masterstudy-lms-learning-management-system' !== $domain", self.source)
        self.assertIn("'vi' !== $context['language'] || '/courses/' !== $context['path']", self.source)
        self.assertIn("return 'Khóa học tiếng Anh';", self.source)
        self.assertNotIn("courses_filters__title", self.source)

    def test_supporting_copy_is_scoped_to_four_thin_english_landing_pages(self):
        self.assertIn("ipaenglish_onpage_supporting_copy_map", self.source)
        for path in (
            "/book-a-test/",
            "/communicative-english-for-adults/",
            "/contact-us/",
            "/courses/",
        ):
            self.assertRegex(self.source, rf"'{re.escape(path)}'\s*=>\s*'[^']+'");
        self.assertIn("'en' === $context['language']", self.source)
        self.assertIn("ipaenglish-seo-supporting-copy", self.source)
        self.assertIn("preg_replace( '#<footer\\b#i'", self.source)
        self.assertIn("preg_replace( '#</body>#i'", self.source)

    def test_supporting_copy_is_substantive_without_unverified_marketing_claims(self):
        block = re.search(
            r"function ipaenglish_onpage_supporting_copy_map\(\) \{(.*?)\n\}",
            self.source,
            re.S,
        )
        self.assertIsNotNone(block)
        copy_values = re.findall(r"=> '([^']+)'", block.group(1))
        self.assertEqual(4, len(copy_values))
        audited_base_words = [299, 249, 268, 276]
        projected_words = [base + len(copy.split()) for base, copy in zip(audited_base_words, copy_values)]
        self.assertGreaterEqual(min(projected_words), 325)
        for forbidden in ("guaranteed", "best", "number one", "certified result"):
            self.assertNotIn(forbidden, block.group(1).lower())


if __name__ == "__main__":
    unittest.main()
