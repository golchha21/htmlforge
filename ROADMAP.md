# HTMLForge Roadmap

This roadmap reflects the current state of HTMLForge and its intended direction.

HTMLForge is a correctness-first HTML compiler with deterministic validation and explainable diagnostics.
The core engine is considered stable as of v1.1.x.

---

## ✅ Completed (v1.1.x)

The following milestones are complete and considered stable for the v1.x series.

### Core Architecture
- AST-first design with no raw HTML rendering
- Deterministic pipeline: AST → Validation → RenderResult
- Explicit separation of validation and rendering

### Validation System
- Unified validator traversal model
- Clear validator responsibility boundaries
- No overlapping or duplicate violations
- Proper handling of inert and raw-text content
- Exact element path tracking (`html > body > form > input`)

### Diagnostics Model
- Canonical `Violation` structure with:
  - stable rule identifiers
  - element paths
  - severity
  - specification references
- Canonical `ValidationReport`
  - non-throwing behavior
  - structured data output
  - JSON serialization
  - HTML rendering
- Browser and PHPUnit parity

### Profiles
- `WCAG_A`
- `WCAG_AA`
- `STRICT_HTML`
- `CMS_SAFE`

Profiles are deterministic, regression-tested, and stable for v1.x.

### Project Hygiene
- Documentation structure finalized
- README, CONTRIBUTING, CHANGELOG, ROADMAP aligned
- PHP-backed documentation examples added
- Release and tagging policy defined

---

## 🟢 Current Status

HTMLForge is **feature-complete at the core engine level**.

The project is now transitioning from:
- internal correctness work  
  to
- external-facing usability and ecosystem tooling

No further core validation logic is planned for v1.x unless required for correctness.

---

## 🔜 Planned (v1.2.x — choose one primary focus)

Only one of the following will be pursued at a time.

### Option A — Tooling (Recommended)
- CLI interface for validation and rendering
- JSON and HTML report output via CLI
- Exit codes suitable for CI pipelines

### Option B — Ecosystem Integration
- Laravel service provider
- WordPress integration layer
- CMS-friendly report surfacing

### Option C — Diagnostic UX Refinement
- Improved HTML report layout
- Grouping and collapsing related violations
- Optional explanatory hints per rule

---

## 🚫 Explicit Non-Goals (v1.x)

The following are intentionally out of scope for v1.x:

- Auto-fixing invalid HTML
- Browser-style error recovery
- Heuristic or “best guess” validation
- Template rendering or view-layer concerns
- Framework-specific logic in the core engine

---

## 🧱 Stability Guarantees

For the remainder of v1.x:

- Public APIs remain stable
- Rule identifiers remain stable
- ValidationReport schema remains stable
- Breaking changes require v2.0

---

HTMLForge treats HTML as a language, not a suggestion.  
The roadmap reflects that philosophy.
