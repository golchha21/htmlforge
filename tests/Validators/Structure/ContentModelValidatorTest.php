<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Validators\Structure;

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Content\ContentModelValidator;
use PHPUnit\Framework\TestCase;

final class ContentModelValidatorTest extends TestCase
{
    public function test_nested_body_is_rejected(): void
    {
        $html = new HtmlBuilder();

        $document = $html->element('body', [], [
            $html->element('body'),
        ]);

        $pipeline = new ValidatorPipeline(
            validators: [new ContentModelValidator()],
            mode: ValidationMode::Strict,
            profile: ValidationProfile::STRICT_HTML
        );

        $this->assertFalse($pipeline->validate($document)->isValid());
    }
}
