<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Core;

use HTMLForge\Validation\Reporting\ValidationReport;
use HTMLForge\Validation\Reporting\Violation;
use PHPUnit\Framework\TestCase;

final class ValidationReportTest extends TestCase
{
    public function test_empty_report_is_valid(): void
    {
        $report = new ValidationReport();

        $this->assertTrue($report->isValid());
        $this->assertSame([], $report->toArray()['errors']);
    }

    public function test_report_with_violation_is_invalid(): void
    {
        $report = new ValidationReport();

        $report->add(new Violation(
            type: 'structure',
            message: 'Only one <body> allowed',
            rule: 'structure:single-body'
        ));

        $this->assertFalse($report->isValid());
        $this->assertCount(1, $report->toArray()['errors']);
    }
}
