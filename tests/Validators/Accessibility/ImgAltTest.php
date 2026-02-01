<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Validators\Accessibility;

use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Attributes\AttributeValidator;
use PHPUnit\Framework\TestCase;

final class ImgAltTest extends TestCase
{
    public function test_img_without_alt_produces_single_violation(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('img', ['src' => '/test.png']),
            ],
            options: ['title' => 'Test', 'meta' => ['charset' => 'utf-8']]
        );

        $pipeline = new ValidatorPipeline(
            validators: [new AttributeValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $report = $pipeline->validate($document);
        $errors = $report->toArray()['errors'];

        $this->assertCount(1, $errors);
        $this->assertSame('attributes:required', $errors[0]['rule']);
    }
}
