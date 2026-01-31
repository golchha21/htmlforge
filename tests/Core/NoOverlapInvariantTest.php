<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Core;

use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Accessibility\AccessibleNameValidator;
use PHPUnit\Framework\TestCase;

final class NoOverlapInvariantTest extends TestCase
{
    public function test_img_alt_missing_produces_single_violation(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('img', [
                    'src' => '/example.png',
                ]),
            ],
            options: ['title' => 'Test']
        );

        $pipeline = new ValidatorPipeline(
            validators: [
                new AccessibleNameValidator(),
            ],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );


        $report = $pipeline->validate($document);
        $errors = $report->toArray()['errors'];

        $this->assertCount(1, $errors);
        $this->assertSame(
            'accessibility:img-alt-required',
            $errors[0]['rule']
        );
    }
}
