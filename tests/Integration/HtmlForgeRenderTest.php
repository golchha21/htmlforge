<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Integration;

use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use PHPUnit\Framework\TestCase;

final class HtmlForgeRenderTest extends TestCase
{
    public function test_valid_document_renders_html(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('p', [], ['Hello world']),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $result = HTMLForge::using(
            new HTMLForgeConfig(
                mode: ValidationMode::Strict,
                profile: ValidationProfile::STRICT_HTML
            )
        )->render($document);

        $this->assertTrue($result->isValid());
        $this->assertStringContainsString('<!DOCTYPE html>', $result->html);
    }
}
