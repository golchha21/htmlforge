# Overview

HTMLForge is a correctness-first HTML engine.

It treats HTML as a **language with rules**, not as a string format that browsers will try to recover from.
Its primary goal is to make invalid, inaccessible, or unsafe HTML *visible* instead of silently tolerated.

## What HTMLForge is

- A standards-driven HTML AST and validation engine
- Deterministic by design
- Explicit about errors and violations
- Framework- and CMS-agnostic

## What HTMLForge is not

- Not a template engine
- Not a browser emulator
- Not an auto-fixer
- Not a heuristic-based linter

HTMLForge will never guess developer intent or modify invalid markup to make it â€œworkâ€.

## When to use HTMLForge

Use HTMLForge when:
- HTML correctness matters
- Accessibility is non-negotiable
- Output must be deterministic
- Validation results need to be inspectable and auditable

## When not to use HTMLForge

HTMLForge may not be a good fit if:
- You want browser-style error recovery
- You rely on malformed HTML rendering
- You want automatic fixes instead of explicit failures
