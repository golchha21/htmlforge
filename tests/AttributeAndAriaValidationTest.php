<?php

declare(strict_types=1);

namespace HTMLForge\Tests;

use PHPUnit\Framework\TestCase;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\ValidationProfile;
use HTMLForge\Validation\ValidationReport;

final class AttributeAndAriaValidationTest extends TestCase
{
    public function test_invalid_url_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $html->element('a', ['href' => 'not-a-url'], ['Bad link']),
        ]);

        $result = HTMLForge::strict(ValidationProfile::WCAG_AA)
            ->render($doc->document($body));

        $this->assertFalse($result->isValid());
        $this->assertInstanceOf(ValidationReport::class, $result->report);
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_duplicate_id_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $html->element('button', ['id' => 'x'], ['One']),
            $html->element('button', ['id' => 'x'], ['Two']),
        ]);

        $result = HTMLForge::strict()->render(
            $doc->document($body)
        );

        $this->assertFalse($result->isValid());
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_invalid_lang_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $result = HTMLForge::strict()->render(
            $doc->document(
                $html->element('main', [], []),
                ['lang' => '123']
            )
        );

        $this->assertFalse($result->isValid());
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_aria_role_override_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', ['role' => 'navigation'], []);

        $result = HTMLForge::strict()->render(
            $doc->document($body)
        );

        $this->assertFalse($result->isValid());
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_inline_event_handler_blocked_in_strict_html_profile(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $html->element('button', ['onclick' => 'alert(1)'], ['Click']),
        ]);

        $result = HTMLForge::strict(ValidationProfile::STRICT_HTML)
            ->render($doc->document($body));

        $this->assertFalse($result->isValid());
        $this->assertTrue($result->report->hasErrors());
    }
}
