<?php

declare(strict_types=1);

namespace HTMLForge;

use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\Validation\ValidationMode;
use HTMLForge\Validation\ValidationProfile;

final class HTMLForge
{
    public static function using(HTMLForgeConfig $config): HTMLForgeEngine
    {
        return new HTMLForgeEngine($config);
    }

    /**
     * Strict validation.
     * Throws on first violation.
     */
    public static function strict(
        ValidationProfile $profile = ValidationProfile::WCAG_AA
    ): HTMLForgeEngine {
        return new HTMLForgeEngine(
            new HTMLForgeConfig(
                mode: ValidationMode::Strict,
                profile: $profile
            )
        );
    }

    /**
     * Lenient validation.
     * Returns a ValidationReport instead of throwing.
     */
    public static function lenient(
        ValidationProfile $profile = ValidationProfile::WCAG_AA
    ): HTMLForgeEngine {
        return new HTMLForgeEngine(
            new HTMLForgeConfig(
                mode: ValidationMode::Lenient,
                profile: $profile
            )
        );
    }
}
