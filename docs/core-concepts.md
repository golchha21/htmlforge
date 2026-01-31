# Core Concepts

This document explains the mental model behind HTMLForge.

Understanding these concepts is essential to using the engine correctly.

## HTML as an AST

HTMLForge does not operate on strings.
HTML is represented as a structured Abstract Syntax Tree (AST).

This enables:
- Structural validation
- Deterministic rendering
- Precise error localization
- Rule-based enforcement

## Validation and Rendering are Separate

Validation and rendering are independent phases.

- Validation produces a ValidationReport
- Rendering always produces output

Validation failures **never throw during rendering**.
This is a deliberate design decision.

## Determinism

Given the same input and profile:
- Validation results are stable
- Rule IDs do not change
- Rendering output is identical

This makes HTMLForge suitable for CI, CMS pipelines, and automated enforcement.

## No Auto-Recovery

HTMLForge does not:
- Insert missing elements
- Close unclosed tags
- Rewrite invalid structures

If markup is invalid, the engine reports it.
Nothing is silently corrected.

## Profiles

Validation behavior is controlled by profiles.

Profiles define:
- Which rules are active
- How strict validation is
- What trade-offs are acceptable

Profiles do not change rendering behavior.
