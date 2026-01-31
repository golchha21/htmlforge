# Validation Profiles

Validation profiles control which rules are applied during validation.

Profiles do not alter rendering behavior.

## WCAG_A
- Enforces WCAG Level A accessibility requirements
- Suitable for basic accessibility compliance

## WCAG_AA
- Enforces WCAG Level AA requirements
- Recommended default for production sites

## WCAG_AAA
- Enforces WCAG Level AAA requirements
- Strict and often impractical for general use

## STRICT_HTML
- Enforces strict HTML correctness
- Disallows unsafe or ambiguous constructs

## CMS_SAFE
- Designed for user-generated content
- Blocks unsafe patterns
- Allows controlled flexibility

Choose the least permissive profile that fits your use case.
