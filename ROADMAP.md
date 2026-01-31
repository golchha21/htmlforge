# HTMLForge Roadmap

This roadmap outlines the planned evolution of HTMLForge beyond v1.0.x.

HTMLForge follows **semantic versioning** and a **compiler-style discipline**:
- patch releases fix documentation or metadata
- minor releases add observability and tooling
- major releases are reserved for architectural shifts

HTMLForge does not chase convenience.
It strengthens correctness.

---

## Current Status

- **Latest stable:** v1.1.1
- **API stability:** v1.x frozen
- **Maintenance:** v1.1.x (docs/metadata only)

---

## v1.1.0 — Observability & Spec Transparency

**Theme:** Make validation *explainable*, *traceable*, and *tool-friendly*  
**Non-goals:** Auto-fixing, heuristics, framework coupling

---

### 1. Machine‑Readable Validation Reports (High priority)

**Problem**  
Validation output is currently human‑readable (HTML) but not ideal for CI or tooling.

**Planned additions**
```php
$report->toArray();
$report->toJson();
```

**Example**
```json
{
  "valid": false,
  "errors": [
    {
      "type": "accessibility",
      "rule": "accessible-name",
      "element": "input",
      "message": "Interactive element <input> must have an accessible name."
    }
  ]
}
```

**Why this matters**
- CI integration
- Editor tooling
- Deterministic diagnostics
- Zero behavior change

---

### 2. Spec Traceability Metadata (High priority)

**Problem**  
Validation rules exist, but their standards origin is implicit.

**Planned design**
```php
interface SpecAwareValidator
{
    public function specRefs(): array;
}
```

**Example references**
- WCAG 2.2 — 4.1.2
- HTML Living Standard — §4.10.5

Violations may surface this information in reports.

**Why this matters**
- Defensibility
- Education
- Enterprise adoption

---

### 3. Auto‑generated Element Coverage Documentation (High priority)

**Problem**  
Documentation is currently manual and risks drift.

**Planned solution**
Generate element coverage directly from `ElementRegistry`.

Example output:
```md
| Element | Categories | Attributes | Notes |
|--------|------------|------------|------|
| button | Flow, Interactive | type, disabled | Requires accessible name |
```

Proposed command:
```bash
php bin/htmlforge elements
```

**Why this matters**
- Zero drift between code and docs
- Contributor clarity
- Maintainer sanity

---

### 4. Validator Execution Contract (Medium priority)

**Problem**  
Validator ordering is implicit.

**Planned design**
```php
enum ValidationPhase {
  Structure,
  Attributes,
  Semantics,
  Accessibility,
  Policy
}
```

Validators declare their phase.
The pipeline enforces ordering.

**Why this matters**
- Predictable diagnostics
- Better error grouping
- Safer extensibility later

---

### 5. CI‑First Validation Mode (Medium priority)

**Problem**  
CI usage requires manual wiring.

**Planned addition**
```php
HTMLForge::ci()->validate($document);
```

Behavior:
- No HTML rendering
- Structured output only
- Deterministic exit codes

Optional CLI façade:
```bash
htmlforge validate input.php --profile=strict-html
```

**Why this matters**
- CI integration
- Static analysis workflows
- No framework coupling

---

## Explicitly Out of Scope (v1.x)

The following are intentionally excluded:

- Auto‑fix suggestions
- Lenient parsing
- HTML string ingestion
- Framework adapters (Laravel, WordPress)
- Template languages (Blade, Twig, JSX)

These are **post‑2.0 discussions**, if ever.

---

## Versioning Plan

| Version | Scope |
|-------|------|
| v1.0.x | Documentation and metadata |
| v1.1.0 | Observability and transparency |
| v1.2.0 | Tooling and CI polish |
| v2.0.0 | Extensibility (only if justified) |

---

## Maintainer Note

HTMLForge treats HTML as a **language**, not a suggestion.

Every future change must strengthen:
- correctness
- determinism
- accessibility
- debuggability

Convenience is never a justification.

If HTML renders, it must be correct.
