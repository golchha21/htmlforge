<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Validation\ValidationProfile;

final class STRICT_HTML_Test extends ProfileTestCase
{
    private const PROFILE = ValidationProfile::STRICT_HTML;

    public function test_inline_event_handler_fails(): void
    {
        $this->assertFalse(
            $this->render(self::PROFILE, fn($h, $d) =>
            $d->document(
                [$h->element('button', ['onclick' => 'x()'], ['Click'])],
                ['title' => 'Test']
            )
            )->isValid()
        );
    }
}
