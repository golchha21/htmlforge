<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Validators\Attributes;

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Attributes\AttributeValidator;
use PHPUnit\Framework\TestCase;

final class AttributeValidatorTest extends TestCase
{
    public function test_disallowed_attribute_fails(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('p', [
                    'not-a-real-attr' => 'nope',
                ]),
            ],
            options: ['title' => 'Test']
        );

        $pipeline = new ValidatorPipeline(
            validators: [new AttributeValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $this->assertFalse($pipeline->validate($document)->isValid());
    }
}
