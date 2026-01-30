<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Report;

use HTMLForge\Validation\ValidationReport;

final class JsonReportWriter
{
    public static function write(ValidationReport $report): string
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
