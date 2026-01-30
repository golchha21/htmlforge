<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\Node;

final class ValidatorPipeline
{
    public function __construct(
        private array $validators,
        private ValidationMode $mode
    ) {}

    public function validate(Node $node): ValidationReport
    {
        $report = new ValidationReport();

//        foreach ($this->validators as $validator) {
//            error_log('[HTMLForge] Validator: ' . get_class($validator));
//        }

        foreach ($this->validators as $validator) {
            try {
                // Phase 1: traversal / per-node validation
                $validator->validate($node);

                // Phase 2: finalize (if supported)
                if ($validator instanceof FinalizableValidator) {
                    $validator->finalize();
                }
            } catch (ValidationException $e) {
                $report->add(
                    new Violation(
                        type: 'error',
                        message: $e->getMessage()
                    )
                );

                // ❗ never throw — pipeline collects
            }
        }

        return $report;
    }
}
