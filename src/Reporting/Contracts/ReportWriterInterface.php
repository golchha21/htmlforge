<?php

declare(strict_types=1);

namespace HTMLForge\Reporting\Contracts;

use HTMLForge\Validation\Reporting\ValidationReport;

interface ReportWriterInterface
{
    /**
     * Render the validation report into a formatted output.
     */
    public function write(ValidationReport $report): string;
}
