<?php

declare(strict_types=1);

namespace HTMLForge\Tests;

use PHPUnit\Framework\TestCase;
use HTMLForge\Validation\ValidationReport;
use HTMLForge\Validation\Violation;

final class HtmlValidationReportRendererTest extends TestCase
{
    public function test_html_report_is_rendered(): void
    {
        $report = new ValidationReport();
        $report->add(new Violation(
            type: 'error',
            message: 'Inline event handler is not allowed.'
        ));

        $html = $report->toHtml();

        $this->assertStringContainsString('<!DOCTYPE html>', $html);
        $this->assertStringContainsString('<h1>', $html);
        $this->assertStringContainsString('Inline event handler is not allowed.', $html);
    }
}
