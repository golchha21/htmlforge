<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use PHPUnit\Framework\TestCase;

final class StrictHtmlProfileTest extends TestCase
{
    public function test_inline_event_handler_is_blocked(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('button', [
                    'onclick' => 'alert(1)',
                ], ['Click']),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $result = HTMLForge::using(
            new HTMLForgeConfig(
                mode: ValidationMode::Strict,
                profile: ValidationProfile::STRICT_HTML
            )
        )->render($document);

        $this->assertFalse($result->isValid());
    }
}
