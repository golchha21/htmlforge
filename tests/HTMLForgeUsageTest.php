<?php

declare(strict_types=1);

namespace HTMLForge\Tests;

use PHPUnit\Framework\TestCase;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\Elements;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\ValidationProfile;
use HTMLForge\Render\RenderResult;
use HTMLForge\Validation\ValidationReport;

final class HTMLForgeUsageTest extends TestCase
{
    public function test_valid_document_renders_html(): void
    {
        $html = new HtmlBuilder();
        $el   = new Elements($html);
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $el->h1('Hello'),
            $el->p('This is valid HTML.'),
            $el->button('Submit'),
        ]);

        $document = $doc->document(
            bodyContent: $body,
            options: [
                'title' => 'Test',
                'lang'  => 'en',
            ]
        );

        $result = HTMLForge::strict(ValidationProfile::WCAG_AA)
            ->render($document);

        $this->assertInstanceOf(RenderResult::class, $result);
        $this->assertTrue($result->isValid());
        $this->assertIsString($result->html);

        $this->assertStringContainsString('<!DOCTYPE html>', $result->html);
        $this->assertStringContainsString('<h1>Hello</h1>', $result->html);
        $this->assertStringContainsString('<button>Submit</button>', $result->html);
    }

    public function test_missing_accessible_name_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $html->element('button'), // ❌ no accessible name
        ]);

        $document = $doc->document(
            bodyContent: $body,
            options: [
                'title' => 'Invalid',
                'lang'  => 'en',
            ]
        );

        $result = HTMLForge::strict()->render($document);

        $this->assertFalse($result->isValid());
        $this->assertInstanceOf(ValidationReport::class, $result->report);
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_heading_skip_produces_error_report(): void
    {
        $html = new HtmlBuilder();
        $el   = new Elements($html);
        $doc  = new DocumentBuilder($html);

        $body = $html->element('div', [], [
            $el->h1('Title'),
            $el->h3('Skipped heading level'), // ❌ h2 missing
        ]);

        $document = $doc->document(
            bodyContent: $body,
            options: [
                'title' => 'Invalid Headings',
                'lang'  => 'en',
            ]
        );

        $result = HTMLForge::strict()->render($document);

        $this->assertFalse($result->isValid());
        $this->assertTrue($result->report->hasErrors());
    }

    public function test_lenient_mode_returns_report(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $body = $html->element('main', [], [
            $html->element('button'), // invalid
        ]);

        $document = $doc->document(
            bodyContent: $body,
            options: [
                'title' => 'Lenient',
                'lang'  => 'en',
            ]
        );

        $result = HTMLForge::lenient()->render($document);

        $this->assertInstanceOf(RenderResult::class, $result);
        $this->assertFalse($result->isValid());
        $this->assertInstanceOf(ValidationReport::class, $result->report);
        $this->assertTrue($result->report->hasErrors());
    }
}
