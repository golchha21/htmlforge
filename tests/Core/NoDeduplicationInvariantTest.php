<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Core;

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\Profiles\ValidationProfile;
use PHPUnit\Framework\TestCase;

final class NoDeduplicationInvariantTest extends TestCase
{
    public function test_same_rule_multiple_nodes_produce_multiple_violations(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('button', ['onclick' => 'a()'], ['A']),
                $html->element('button', ['onclick' => 'b()'], ['B']),
            ],
            options: [
                'title' => 'Test',
            ]
        );

        $result = HTMLForge::strict(
            profile: ValidationProfile::STRICT_HTML
        )->render($document);

        $this->assertFalse($result->isValid());

        $violations = array_filter(
            $result->report->all(),
            fn ($v) => $v->rule === 'security:inline-event-handler'
        );

        $this->assertCount(
            2,
            $violations,
            'Multiple identical rule violations must not be deduplicated'
        );
    }
}
