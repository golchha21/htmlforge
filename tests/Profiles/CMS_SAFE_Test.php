<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Validation\ValidationProfile;

final class CMS_SAFE_Test extends ProfileTestCase
{
    private const PROFILE = ValidationProfile::CMS_SAFE;

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
}
