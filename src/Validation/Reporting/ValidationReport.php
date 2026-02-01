<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Reporting;

use HTMLForge\Reporting\Html\HtmlValidationReportRenderer;

final class ValidationReport
{
    /** @var Violation[] */
    private array $violations = [];

    public function add(Violation $v): void
    {
        // IMPORTANT:
        // Do NOT deduplicate.
        // Multiple AST nodes may violate the same rule independently.
        $this->violations[] = $v;
    }

    /**
     * Document is valid if there are no error-severity violations
     */
    public function isValid(): bool
    {
        return $this->errors() === [];
    }

    /** @return Violation[] */
    public function all(): array
    {
        return $this->violations;
    }

    /** @return Violation[] */
    public function errors(): array
    {
        return array_values(
            array_map(
                fn (Violation $v) => $v->toArray() + [
                        'severity' => $v->severity,
                    ],
                array_filter(
                    $this->violations,
                    fn (Violation $v) => $v->severity === 'error'
                )
            )
        );
    }

    public function toArray(): array
    {
        return [
            'valid'  => $this->isValid(),
            'errors' => $this->errors(),
        ];
    }

    /**
     * Render a browser-friendly HTML report
     */
    public function toHtml(array $options = []): string
    {
        return HtmlValidationReportRenderer::render($this, $options);
    }

    public function hasErrors(): bool
    {
        return !$this->isValid();
    }

    public function toJson(): string
    {
        return json_encode(
            $this->toArray(),
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        );
    }

    public function grouped(): array
    {
        $grouped = [];

        foreach ($this->violations as $violation) {
            $grouped[$violation->type][] = $violation;
        }

        ksort($grouped);

        return $grouped;
    }
}
