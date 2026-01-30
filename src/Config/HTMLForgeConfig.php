<?php

declare(strict_types=1);

namespace HTMLForge\Config;

use HTMLForge\Validation\ValidationMode;
use HTMLForge\Validation\ValidationProfile;

final readonly class HTMLForgeConfig
{
    public function __construct(
        public ValidationMode $mode = ValidationMode::Strict,
        public ValidationProfile $profile = ValidationProfile::WCAG_AA
    ) {}
}
