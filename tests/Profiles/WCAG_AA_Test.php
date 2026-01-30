<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Validation\ValidationProfile;

final class WCAG_AA_Test extends ProfileTestCase
{
    private const PROFILE = ValidationProfile::WCAG_AA;

    public function test_valid_document_passes(): void
    {
        $this->assertTrue(
            $this->render(self::PROFILE, fn($h, $d) =>
            $d->document(
                [$h->element('h1', [], ['Hello'])],
                ['title' => 'Test', 'lang' => 'en']
            )
            )->isValid()
        );
    }

    public function test_inline_event_handler_allowed(): void
    {
        $this->assertTrue(
            $this->render(self::PROFILE, fn($h, $d) =>
            $d->document(
                [$h->element('button', ['onclick' => 'x()'], ['Click'])],
                ['title' => 'Test']
            )
            )->isValid()
        );
    }

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
