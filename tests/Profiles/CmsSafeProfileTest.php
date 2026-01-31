<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Pipeline\ValidatorProfileFactory;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;
use PHPUnit\Framework\TestCase;

final class CmsSafeProfileTest extends TestCase
{
    public function test_inline_event_handler_allowed(): void
    {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $doc->document(
            bodyContent: [
                $html->element('button', ['onclick' => 'doThing()'], ['Click']),
            ],
            options: ['title' => 'Test']
        );

        $pipeline = new ValidatorPipeline(
            validators: ValidatorProfileFactory::build(ValidationProfile::CMS_SAFE),
            mode: ValidationMode::Strict,
            profile: ValidationProfile::CMS_SAFE
        );

        $this->assertTrue($pipeline->validate($document)->isValid());
    }
}
