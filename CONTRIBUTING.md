# Contributors

HTMLForge is a correctness-first project.

---

## Maintainer

- [Ulhas Vardhan Golchha](https://github.com/golchha21)

---

## How to Contribute

1. Fork the repository
2. Create a focused branch
3. Add or update tests
4. Keep changes small and intentional
5. Submit a pull request with a clear rationale

---

## Contribution Guidelines

- Do not bypass validation rules
- Do not add auto-fix behavior
- Prefer explicit rules to heuristics
- Tests are mandatory for behavior changes
- No framework-specific logic in core

---

## Release Policy

HTMLForge follows a strict, low-noise release discipline.

### Versioning
- The project follows **Semantic Versioning**
- Every release is **git-tagged**
- Tags are immutable once published

### GitHub Releases
- **Patch releases (`x.y.z`)**
  - Published as git tags only
  - No GitHub Release page
  - Used for documentation, tests, and non-semantic cleanup

- **Minor and major releases (`x.y.0`, `x.0.0`)**
  - Published as git tags and GitHub Releases
  - Used when behavior, guarantees, or capabilities change

### Immutability
- Past changelog entries are never edited after release
- Releases are append-only
- Tags are never moved or reused

---

## Philosophy

HTMLForge treats HTML as a **language**, not a suggestion.

Every contribution should strengthen:
- correctness
- determinism
- accessibility
- debuggability
