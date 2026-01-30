# Changelog

All notable changes to this project will be documented in this file.

The format follows **Keep a Changelog**.
This project adheres to **Semantic Versioning**.

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

[1.0.0]: https://github.com/golchha21/htmlforge/releases/tag/v1.0.0
