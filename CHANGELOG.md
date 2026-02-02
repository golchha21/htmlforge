# Changelog

All notable changes to this project will be documented in this file.

The format follows **Keep a Changelog**.
This project adheres to **Semantic Versioning**.

---

## [1.2.1] - 2026-02-02

--- Updated README, RULES, ROADMAP, and ELEMENT REGISTRY


## [1.2.0] - 2026-02-01

### Added
- Deterministic multi-violation reporting per node
- Formal 3-phase validation pipeline
- Finalized rule ID registry
- Structured diagnostics API for CI tooling
- Category-grouped HTML validation reports

### Fixed
- Consecutive identical violations collapsing into one
- Incorrect deduplication by rule only
- Misclassification of inline event handlers
- Validator short-circuiting during traversal

### Changed
- Validators emit violations instead of throwing
- Security rules separated from attribute validation
- Validation pipeline contract frozen for v1.x

### Stability
- Core validation architecture finalized
- API frozen for all v1.x releases

---

## [1.1.2] - 2026-01-31

### Added
- Complete PHP-backed documentation examples covering:
  - Full document rendering
  - Fragment rendering
  - Accessibility validation
  - CMS-safe validation pipelines

### Changed
- Consolidated and expanded project documentation
- Updated README.md with structured documentation index
- Clarified contribution and release policies
- Updated roadmap to reflect current direction

### Status
- Documentation and examples stabilized
- No changes to engine behavior, validation semantics, or public APIs

---

## [1.1.1] - 2026-01-31

### Fixed
- Changelog cleanup and version consistency
- Corrected duplicate release entries
- Minor README.md cleanup
- Updated versions

---

## [1.1.0] - 2026-01-31

### Added
- Stable rule ID registry with no-overlap invariant
- Element path tracking in all validation errors
- Canonical ValidationReport schema
- ELEMENT_REGISTRY documentation
- RULES documentation (normative)

### Changed
- Refined validator responsibilities to prevent duplicate violations
- Simplified and stabilized test suite
- Aligned documentation with actual engine behavior

### Fixed
- Duplicate accessibility and attribute violations
- Inconsistent error reporting between validators
- Pathless validation errors

### Status
- Engine semantics stabilized
- API and rule IDs frozen for v1.x

---

## [1.0.3] - 2026-01-30

### Fixed
- Add roadmap

---

## [1.0.2] - 2026-01-30

### Fixed
- Updated the badges on `README.md`

---

## [1.0.1] - 2026-01-30

### Fixed
- Renamed `REAMME.md` to `README.md`

---

## [1.0.0] – Initial Stable Release - 2026-01-30

This is the first public, stable release of HTMLForge.

### Added
- Standards-first HTML AST with deterministic rendering
- Complete HTML5 element registry
- Content model validation (document structure, void elements, raw-text, inert content)
- Attribute validation with global, data-*, and aria-* support
- WCAG-aware accessibility validation:
  - Accessible name enforcement (implicit, explicit, and ARIA-based)
  - Form label validation
  - Heading outline validation
  - Landmark validation
  - ARIA role validation
- URL, ID reference, and language attribute validators
- Inline event handler blocking for strict profiles
- Validation profiles:
  - WCAG_A
  - WCAG_AA
  - WCAG_AAA
  - STRICT_HTML
  - CMS_SAFE
- Deterministic rendering modes (Document vs Fragment)
- ValidationReport with HTML renderer for browser-friendly error output
- PHPUnit regression test matrix per profile

### Design Decisions
- No auto-fixing of invalid HTML
- No silent browser-like error recovery
- No framework or CMS assumptions in core
- Validation failures never throw during rendering

### Status
- First stable, production-ready release
- API frozen for v1.x

---
