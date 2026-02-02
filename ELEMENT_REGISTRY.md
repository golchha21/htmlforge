# Element Registry

This document defines the supported HTML elements in **HTMLForge v1.2** and their classification.

The registry is **authoritative**:
if an element is not listed here, it is not supported.

This document describes **what elements exist and how they are classified**.
It does not describe validation rules in detail — those are defined in `RULES.md`.

---

## Scope and Non-Goals

This registry defines element availability and classification only.

It does **not**:
- auto-correct invalid HTML
- insert missing elements or attributes
- relax rules based on browser behavior
- override validation profiles

All correctness enforcement is performed by validators.
If an element appears here but violates a rule, validation will fail.

---

## Document Root

- html
- head
- body

**Document invariants:**
- Exactly one `<html>`, `<head>`, and `<body>` element is required.
- `<title>` and `<meta charset>` are mandatory (see Metadata).

---

## Metadata

- title
- meta
- link
- style
- script
- noscript
- base

**Document invariants:**
- Exactly one `<title>` element is required per document.
- A character encoding declaration using  
  `<meta charset="utf-8">` is required.

HTMLForge does not auto-insert missing metadata.

---

## Sectioning / Landmarks

- header
- nav
- main
- section
- article
- aside
- footer
- address

**Accessibility notes:**
- Landmark semantics are validated.
- Native HTML semantics are preferred over ARIA roles.

---

## Headings

- h1
- h2
- h3
- h4
- h5
- h6

**Accessibility notes:**
- Heading order and outline consistency are validated.

---

## Grouping Content

- p
- div
- hr
- pre
- blockquote
- ol
- ul
- li
- dl
- dt
- dd
- figure
- figcaption

---

## Phrasing Content

- a
- em
- strong
- small
- s
- cite
- q
- dfn
- abbr
- data
- time
- code
- var
- samp
- kbd
- sub
- sup
- i
- b
- u
- mark
- span
- br
- wbr

**Accessibility notes:**
- Interactive phrasing elements (e.g. `<a>`) require accessible names.

---

## Embedded Content

- img
- iframe
- embed
- object
- param
- video
- audio
- source
- track
- map
- area
- picture

**Accessibility notes:**
- `<img>` requires an `alt` attribute.
  - Empty `alt=""` is permitted for decorative images.
  - Missing `alt` triggers a validation error.
- Media elements are validated for correct attribute usage.

---

## Forms

- form
- label
- input
- button
- select
- textarea
- fieldset
- legend
- datalist
- option
- optgroup
- output
- progress
- meter

**Accessibility notes:**
- Interactive form controls require accessible names.
- Labels may be implicit or explicit.
- Invalid nesting of interactive controls is rejected.

---

## Tabular Data

- table
- caption
- colgroup
- col
- thead
- tbody
- tfoot
- tr
- th
- td

**Accessibility notes:**
- Structural correctness is enforced.
- Semantic misuse is rejected.

---

## Interactive Containers

- details
- summary
- dialog

---

## Inert / Templates

- template

Content inside `<template>` is inert and excluded from validation traversal
until instantiated.

---

## Profile-Aware Behavior

Some attributes and behaviors are profile-dependent.

Example:
- Inline JavaScript event handlers (`onclick`, etc.)
  - allowed in `CMS_SAFE`
  - rejected in `STRICT_HTML`

Attribute validity is determined by validators, not by this registry alone.

---

## Notes

- Deprecated elements are **intentionally excluded**
- SVG and MathML are **out of scope** for v1.x
- Custom elements are **not supported**

This registry is frozen for v1.2.x.
