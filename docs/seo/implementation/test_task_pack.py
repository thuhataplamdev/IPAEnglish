from pathlib import Path
import re
import subprocess
import unittest


class SeoImplementationTaskPackTest(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        cls.root = Path(__file__).resolve().parent
        cls.dashboard = (cls.root / "00-DASHBOARD.md").read_text(encoding="utf-8")
        cls.task_files = sorted((cls.root / "tasks").glob("*.md"))

    def test_dashboard_has_exactly_16_unique_task_ids(self):
        ids = sorted(set(re.findall(r"SEO-W[123]-\d{2}", self.dashboard)))
        self.assertEqual(16, len(ids), ids)

    def test_every_dashboard_task_has_exactly_one_file(self):
        ids = sorted(set(re.findall(r"SEO-W[123]-\d{2}", self.dashboard)))
        names = [path.name for path in self.task_files]
        self.assertEqual(16, len(names), names)
        for task_id in ids:
            matches = [name for name in names if name.startswith(task_id)]
            self.assertEqual(1, len(matches), (task_id, matches))

    def test_w1_03_contains_all_baseline_findings(self):
        text = (self.root / "tasks" / "SEO-W1-03-technical-audit-triage-backlog.md").read_text(encoding="utf-8")
        for number in range(1, 11):
            self.assertIn(f"TECH-{number:03d}", text)

    def test_git_delta_is_scoped_to_implementation_docs(self):
        result = subprocess.run(
            ["git", "status", "--porcelain"],
            cwd=self.root,
            check=True,
            capture_output=True,
            text=True,
        )
        for line in result.stdout.splitlines():
            path = line[3:]
            self.assertTrue(path.startswith("docs/seo/implementation/"), line)


if __name__ == "__main__":
    unittest.main()
