<?php

declare(strict_types=1);

namespace HTMLForge\Reporting\Json;

use HTMLForge\Reporting\Contracts\ReportWriterInterface;
use HTMLForge\Validation\Reporting\ValidationReport;

final class JsonReportWriter implements ReportWriterInterface
{
    public function write(ValidationReport $report): string
    {
        return json_encode(
            [
                'errors' => $report->toArray(),
                'count' => count($report->all()),
            ],
            JSON_PRETTY_PRINT
        );
    }
}
