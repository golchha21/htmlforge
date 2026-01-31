# HTMLForge Rule Registry (v1.1)

This document defines all validation rules enforced by HTMLForge.
Rule IDs are stable, unique, and non-overlapping.

---

## Global Invariants

- One semantic issue MUST produce exactly one rule violation
- Each rule is owned by exactly one validator
- Rules are profile-aware but never duplicated
- Rule IDs are immutable once released

---

## AccessibleNameValidator

### accessibility:img-alt-required

**Severity:** error  
**Profiles:** WCAG_A, WCAG_AA, WCAG_AAA, STRICT_HTML

**Applies to:**
- img

**Does not apply to:**
- picture
- source
- img with role="presentation"

**Description:**  
`<img>` elements must include a non-empty `alt` attribute.

---

### accessibility:interactive-name-required

**Severity:** error  
**Profiles:** WCAG_A, WCAG_AA, WCAG_AAA, STRICT_HTML

**Applies to:**
- input (except type="hidden")
- button
- select
- textarea
- a

**Description:**  
Interactive elements must have an accessible name via visible text,
label association, or ARIA naming.

---

## AttributeValidator

### attributes:disallowed

**Severity:** error  
**Profiles:** WCAG_A, WCAG_AA, WCAG_AAA, STRICT_HTML, CMS_SAFE

**Applies to:**
- all elements

**Description:**  
Attributes not allowed by the HTML specification, global attributes,
`data-*`, or `aria-*` are rejected.

---

## ContentModelValidator

### structure:interactive-nesting

**Severity:** error  
**Profiles:** WCAG_A, WCAG_AA, WCAG_AAA, STRICT_HTML

**Applies to:**
- button
- input
- select
- textarea

**Description:**  
Interactive controls must not be nested inside other interactive controls,
except where explicitly permitted (e.g. labels).

---

### structure:document-root

**Severity:** error  
**Profiles:** WCAG_A, WCAG_AA, WCAG_AAA, STRICT_HTML

**Applies to:**
- html
- head
- body

**Description:**  
Documents must contain exactly one `<html>`, `<head>`, and `<body>` element.

---

## InlineEventHandlerValidator

### policy:inline-event-handler

**Severity:**
- error (STRICT_HTML)
- warning (other profiles)

**Profiles:** STRICT_HTML

**Applies to:**
- all elements

**Description:**  
Inline JavaScript event handler attributes (e.g. `onclick`) are forbidden.

---

## AriaRoleValidator

### aria:role-invalid

**Severity:** error  
**Profiles:** WCAG_AA, WCAG_AAA, STRICT_HTML

**Applies to:**
- all elements with a `role` attribute

**Description:**  
ARIA roles must be valid and compatible with the host element’s semantics.

---

## No-Overlap Invariant

A single semantic problem MUST NOT generate more than one rule violation.

**Example:**
- Missing `<img alt>` → `accessibility:img-alt-required`
- MUST NOT also trigger `attributes:required`
