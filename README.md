# HTMLForge

![PHP](https://img.shields.io/packagist/php-v/golchha21/htmlforge?logo=php&logoColor=white&color=777bb4)
[![Version](https://img.shields.io/packagist/v/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
[![Downloads](https://img.shields.io/packagist/dt/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
[![License](https://img.shields.io/packagist/l/golchha21/htmlforge)](https://packagist.org/packages/golchha21/htmlforge)
![Accessibility](https://img.shields.io/badge/Accessibility-WCAG%202.x-success)
![Standards](https://img.shields.io/badge/HTML-W3C%20Compliant-orange)

**HTMLForge** is a standards-first HTML compiler for PHP.

It generates **W3C-compliant, accessibility-validated HTML** by compiling an explicit Abstract Syntax Tree (AST) through a deterministic validation pipeline.

HTMLForge does not guess, auto-fix, or silently tolerate invalid markup.

If HTML renders, it is structurally correct and policy-compliant.

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

### Deterministic validation

All validation happens explicitly through a validator pipeline:

- Document structure
- Content model rules
- Attribute validity
- Attribute value constraints
- Accessibility (WCAG-aware)
- ARIA semantics
- Document metadata

Validation always runs **before** rendering.

Each failure maps to a **stable rule ID** with an exact element path.

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
Profiles are declarative.

---

### No runtime surprises

HTMLForge never:

- auto-injects missing elements
- fixes invalid markup
- rewrites your structure
- relies on browser error recovery

If something is wrong, you get a validation report — not broken HTML.

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

## Validation reports

HTMLForge produces **structured diagnostics**, not strings:

- Stable rule IDs
- Exact element paths (`html > body > form > input`)
- Machine-readable JSON
- Browser-friendly HTML reports

One violation always corresponds to **one semantic rule failure**.

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
