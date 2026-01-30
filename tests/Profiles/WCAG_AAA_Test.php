<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Validation\ValidationProfile;

final class WCAG_AAA_Test extends ProfileTestCase
{
    private const PROFILE = ValidationProfile::WCAG_AAA;

    public function test_heading_skip_fails(): void
    {
        $this->assertFalse(
            $this->render(self::PROFILE, fn($h, $d) =>
            $d->document(
                [$h->element('h1', [], ['A']), $h->element('h3', [], ['C'])],
                ['title' => 'Test']
            )
            )->isValid()
        );
    }
}
