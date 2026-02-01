<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Pipeline;

use HTMLForge\AST\Node;
use HTMLForge\Validation\Contracts\FinalizableValidator;
use HTMLForge\Validation\Contracts\ProfileAwareValidator;
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

        $emit = function (Violation $v) use ($report) {
            $report->add($this->applySeverity($v));
        };

        /*
        |--------------------------------------------------------------------------
        | Phase 1: Tree validation
        |--------------------------------------------------------------------------
        */
        foreach ($this->validators as $validator) {
            if (
                $validator instanceof ProfileAwareValidator &&
                !$validator->supportsProfile($this->profile)
            ) {
                continue;
            }

            $validator->validate($node, $emit);
        }

        /*
        |--------------------------------------------------------------------------
        | Phase 2: Finalization
        |--------------------------------------------------------------------------
        */
        foreach ($this->validators as $validator) {
            if (
                $validator instanceof ProfileAwareValidator &&
                !$validator->supportsProfile($this->profile)
            ) {
                continue;
            }

            if ($validator instanceof FinalizableValidator) {
                $validator->finalize($emit);
            }
        }

        return $report;
    }

    private function applySeverity(Violation $v): Violation
    {
        if ($this->mode === ValidationMode::Strict) {
            return $v;
        }

        if ($v->rule === 'inline-event-handler') {
            return new Violation(
                type: $v->type,
                message: $v->message,
                rule: $v->rule,
                element: $v->element,
                path: $v->path,
                spec: $v->spec,
                severity: 'warning'
            );
        }

        return $v;
    }
}
