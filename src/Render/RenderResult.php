<?php

declare(strict_types=1);

namespace HTMLForge\Render;

use Throwable;
use HTMLForge\Validation\ValidationException;
use HTMLForge\Validation\ValidationReport;
use HTMLForge\Validation\Violation;

final readonly class RenderResult
{
    private function __construct(
        public ?string $html,
        public ?ValidationReport $report
    ) {}

    public static function success(string $html): self
    {
        return new self($html, null);
    }

    public static function failure(ValidationReport $report): self
    {
        return new self(null, $report);
    }

    /**
     * Convert a ValidationException into a renderable failure.
     */
    public static function fromValidationException(
        ValidationException $e
    ): self {
        $report = new ValidationReport();
        $report->add(
            new Violation(
                type: 'error',
                message: $e->getMessage()
            )
        );

        return self::failure($report);
    }

    /**
     * Convert unexpected system errors into a renderable failure.
     */
    public static function fromFatalError(Throwable $e): self
    {
        $report = new ValidationReport();
        $report->add(
            new Violation(
                type: 'fatal',
                message: 'System error: ' . $e->getMessage()
            )
        );

        return self::failure($report);
    }

    public function isValid(): bool
    {
        return $this->html !== null;
    }
}
