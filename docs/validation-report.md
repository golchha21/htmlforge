# ValidationReport

Validation results are returned as a ValidationReport.

The schema is canonical and frozen for v1.x.

## Core properties

A ValidationReport contains:
- Rule IDs
- Severity
- Human-readable messages
- Element paths

## Rule IDs

Rule IDs are stable and globally unique.
They are safe to store, diff, and reference.

## Element Paths

Paths identify the exact location of a violation within the HTML structure.
This enables precise debugging and tooling integration.

## Rendering Reports

Validation reports can be rendered as HTML.
This is useful for:
- CMS admin interfaces
- CI artifacts
- Developer debugging

## Non-Throwing Behavior

Validation failures do not interrupt rendering.
This allows inspection, logging, and controlled handling.
