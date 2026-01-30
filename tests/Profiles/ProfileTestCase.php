<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use PHPUnit\Framework\TestCase;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\ValidationMode;
use HTMLForge\Validation\ValidationProfile;
use HTMLForge\Render\RenderResult;

abstract class ProfileTestCase extends TestCase
{
    protected function render(
        ValidationProfile $profile,
        callable $build
    ): RenderResult {
        $html = new HtmlBuilder();
        $doc  = new DocumentBuilder($html);

        $document = $build($html, $doc);

        return HTMLForge::using(
            new HTMLForgeConfig(
                mode: ValidationMode::Strict,
                profile: $profile
            )
        )->render($document);
    }
}
