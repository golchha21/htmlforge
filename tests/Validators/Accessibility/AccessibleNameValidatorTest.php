<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Validators\Accessibility;

use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Accessibility\AccessibleNameValidator;
use PHPUnit\Framework\TestCase;

final class AccessibleNameValidatorTest extends TestCase
{
    public function test_input_without_label_or_aria_fails(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('form', [], [
                    $html->element('input', ['type' => 'text']),
                ]),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $pipeline = new ValidatorPipeline(
            validators: [new AccessibleNameValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $report = $pipeline->validate($document);

        $this->assertFalse($report->isValid());
    }

    public function test_label_wrapped_input_passes(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('label', [], [
                    'Email',
                    $html->element('input', ['type' => 'email']),
                ]),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $pipeline = new ValidatorPipeline(
            validators: [new AccessibleNameValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $report = $pipeline->validate($document);

        $this->assertTrue($report->isValid());
    }
}
