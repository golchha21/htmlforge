# HTMLForge

![PHP](https://img.shields.io/packagist/php-v/golchha21/htmlforge?logo=php&logoColor=white&color=777bb4)
[![Version](https://img.shields.io/packagist/v/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
[![Downloads](https://img.shields.io/packagist/dt/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
[![License](https://img.shields.io/packagist/l/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
![Accessibility](https://img.shields.io/badge/Accessibility-WCAG%202.x-success)
![Standards](https://img.shields.io/badge/HTML-W3C%20Compliant-orange)

**HTMLForge** is a standards-first HTML compiler for PHP.

It generates **W3C-compliant, accessibility-validated HTML** by compiling an explicit
**Abstract Syntax Tree (AST)** through a deterministic validation pipeline.

HTMLForge does not guess, auto-fix, or silently tolerate invalid markup.

If HTML renders, it is **structurally correct and policy-compliant**.

---

## Why HTMLForge

Most HTML generation tools:

- concatenate strings
- rely on browsers to fix mistakes
- mix validation, rendering, and presentation
- fail late and unclearly

HTMLForge takes a different approach:

- HTML is treated as a **language with rules**
- Validation happens **before rendering**
- Errors are **data**, not crashes
- Accessibility is enforced by default

---

## Core Concepts

### AST-first design

HTMLForge builds an immutable **Abstract Syntax Tree (AST)**.

- No raw HTML strings are rendered directly
- Every element, attribute, and text node is explicit
- Invalid structures cannot be constructed accidentally

---

### Deterministic validation (v1.2)

All validation happens explicitly through a **multi-phase validator pipeline**:

- Document structure
- Content model rules
- Attribute validity
- Attribute value constraints
- Accessibility (WCAG-aware)
- ARIA semantics
- Document metadata
- Policy & security rules

Validation always runs **before** rendering.

In **v1.2**, validators **emit violations instead of throwing**, which guarantees:

- All violations are collected
- Multiple failures on multiple nodes are all reported
- No early exits or hidden errors

Each violation maps to:
- a **stable rule ID**
- a **single semantic failure**
- an **exact element path**

---

### Policy-driven profiles

Validation rules are grouped into **profiles**, not flags:

- `WCAG_A`
- `WCAG_AA`
- `WCAG_AAA`
- `STRICT_HTML`
- `CMS_SAFE`

Profiles define *what is enforced*, not *how HTML is written*.

No conditionals.  
No runtime switches.  
Profiles are declarative and explicit.

---

### No runtime surprises

HTMLForge never:

- auto-injects missing elements
- fixes invalid markup
- rewrites your structure
- relies on browser error recovery

If something is wrong, you get a **complete validation report** — not broken HTML.

---

## Accessibility by default

HTMLForge enforces real accessibility rules, not heuristics:

- Accessible names for interactive elements
- Proper form labeling (implicit and explicit)
- Landmark and heading structure
- ARIA role correctness
- Native HTML semantics preferred over ARIA

Accessibility failures are **validation errors**, not warnings.

---

## Rendering model

- Exactly one `<html>`, `<head>`, and `<body>` per document
- `<body>` is the root content container
- No implicit wrapper elements
- Raw-text and inert elements are isolated correctly
- Rendering only happens if validation passes

---

## Validation reports (v1.2)

HTMLForge produces **structured diagnostics**, not strings:

- Stable rule IDs (e.g. `accessibility:img-alt-required`)
- Exact element paths (`html > body > form > input`)
- Multiple violations are **never deduplicated**
- Machine-readable JSON output
- Browser-friendly grouped HTML reports

One violation always corresponds to **one semantic rule failure**.

---

### Security and policy enforcement

HTMLForge enforces strict security-related HTML policies:

- Inline JavaScript event handlers (`onclick`, `onload`, etc.)
- Profile-aware severity:
  - error in `STRICT_HTML`
  - warning in CMS-oriented profiles

These rules are enforced at validation time, not runtime.

---

## Documentation

The documentation is intentionally small, focused, and correctness-oriented.

If something is not documented, it is either unstable or out of scope.

### Getting started
- **[Overview](docs/overview.md)**  
  What HTMLForge is, what it is not, and when to use it.

- **[Core Concepts](docs/core-concepts.md)**  
  ASTs, validation vs rendering, determinism, and design decisions.

### Validation
- **[Validation Profiles](docs/validation-profiles.md)**  
  Available profiles and how to choose the right one.

- **[ValidationReport](docs/validation-report.md)**  
  Canonical schema, rule IDs, element paths, and report rendering.

### Examples
- **[Basic Document](docs/examples/basic-document.md)**  
  Rendering and validating a complete HTML document.

- **[Fragment Rendering](docs/examples/fragment-rendering.md)**  
  Rendering partial HTML without document-level assumptions.

- **[Accessibility Validation](docs/examples/accessibility-validation.md)**  
  WCAG-aware validation with rule IDs and element paths.

- **[CMS-Safe Pipeline](docs/examples/cms-safe-pipeline.md)**  
  Validating and rendering untrusted, user-generated content.

---

### Document encoding enforcement

HTMLForge requires an explicit character encoding declaration:

- `<meta charset="utf-8">` is mandatory
- Missing charset is a validation error
- HTMLForge does not auto-insert encoding metadata

This ensures deterministic parsing behavior and avoids
browser-dependent encoding assumptions.

---

## Appendix: Element Coverage Matrix

This usage example exercises the following HTML element categories:

| Category            | Elements Demonstrated |
|---------------------|----------------------|
| Document root       | html, head, body     |
| Metadata            | title, meta, style, link |
| Sectioning          | header, nav, main, section, article, aside, footer |
| Headings            | h1, h2               |
| Grouping            | p, ul, li, figure, figcaption |
| Phrasing            | a, span (implicit), text nodes |
| Embedded            | img                  |
| Forms               | form, label, input, button |
| Interactive         | a, button, input     |
| Global attributes   | class, id, lang, data-* |
| Accessibility       | implicit labels, alt text, landmarks |

This matrix reflects **real validation coverage**, not theoretical support.

Elements not shown here are still supported if present in the registry.

---

## Error handling

HTMLForge never throws during rendering.

Instead:

- All validation errors are collected
- Rendering returns a `RenderResult`
- You decide how to display, log, or block output

This makes HTMLForge safe for:

- browsers
- CMS pipelines
- static builds
- CI environments

---

## Installation

```bash
composer require golchha21/htmlforge
```

Requires **PHP 8.3+**.

---

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email vardhans@ulhas.net instead of using the issue tracker.

## Author

- [Ulhas Vardhan Golchha](https://github.com/golchha21) - *Initial work*

See also the list of [contributors](https://github.com/golchha21/htmlforge/graphs/contributors) who participated in this project.

---

## License

[MIT license](LICENSE.md).
