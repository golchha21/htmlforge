<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\Validation\Report\HtmlValidationReportRenderer;

final class ValidationReport
{
    /** @var Violation[] */
    private array $violations = [];

    public function add(Violation $violation): void
    {
        $this->violations[] = $violation;
    }

    public function hasErrors(): bool
    {
        return $this->violations !== [];
    }

    /** @return Violation[] */
    public function all(): array
    {
        return $this->violations;
    }

    public function toArray(): array
    {
        return array_map(
            fn (Violation $v) => [
                'type' => $v->type,
                'message' => $v->message,
                'element' => $v->element,
            ],
            $this->violations
        );
    }

    public function toHtml(array $options = []): string
    {
        return HtmlValidationReportRenderer::render($this, $options);
    }
}
