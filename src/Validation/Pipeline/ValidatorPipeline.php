<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Pipeline;

use HTMLForge\AST\Node;
use HTMLForge\Validation\Contracts\ProfileAwareValidator;
use HTMLForge\Validation\Exceptions\ValidationException;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Reporting\ValidationReport;
use HTMLForge\Validation\Reporting\Violation;

final class ValidatorPipeline
{
    public function __construct(
        private array $validators,
        private ValidationMode $mode,
        private ValidationProfile $profile
    ) {}

    public function validate(Node $node): ValidationReport
    {
        $report = new ValidationReport();

        foreach ($this->validators as $validator) {
            if (
                $validator instanceof ProfileAwareValidator &&
                !$validator->supportsProfile($this->profile)
            ) {
                continue;
            }

            try {
                $validator->validate($node);
            } catch (ValidationException $e) {
                $severity = $this->resolveSeverity($e);

                $report->add(
                    new Violation(
                        type: $e->type ?? 'error',
                        message: $e->getMessage(),
                        rule: $e->rule,
                        element: $e->element,
                        path: $e->path,
                        spec: $e->spec,
                        severity: $severity
                    )
                );

                // ❗ NO THROW — EVER
            }
        }

        return $report;
    }

    private function resolveSeverity(ValidationException $e): string
    {
        // STRICT mode: everything is fatal
        if ($this->mode === ValidationMode::Strict) {
            return 'error';
        }

        // Lenient mode: downgrade policy / hygiene issues
        return match ($e->rule) {
            'inline-event-handler' => 'warning',
            default => 'error',
        };
    }

}
