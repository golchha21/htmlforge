# HTMLForge Roadmap

This roadmap reflects the current state of HTMLForge and its intended direction.

HTMLForge is a correctness-first HTML compiler with deterministic validation and explainable diagnostics.
The core engine is considered stable as of v1.1.x.

---

## ✅ Completed (v1.2.x)

### Diagnostics & Rule System
- Stable rule registry with non-overlapping IDs
- One semantic failure → one violation invariant
- Multiple violations across multiple nodes supported
- Profile-aware severity handling
- Explicit rule ownership per validator

### Reporting
- Canonical ValidationReport schema
- JSON and HTML report parity
- Grouped, human-readable browser output
- Machine-readable diagnostics for tooling

v1.2.x finalizes the validation and diagnostics model.

---

## 🔜 Planned (v1.3.x — choose one primary focus)

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
