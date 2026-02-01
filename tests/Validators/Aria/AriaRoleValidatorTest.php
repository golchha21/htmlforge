<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Validators\Aria;

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Accessibility\AriaRoleValidator;
use PHPUnit\Framework\TestCase;

final class AriaRoleValidatorTest extends TestCase
{
    public function test_invalid_role_is_rejected(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('div', ['role' => 'banana']),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $pipeline = new ValidatorPipeline(
            validators: [new AriaRoleValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $report = $pipeline->validate($document);

        $this->assertFalse($report->isValid());
    }
}

