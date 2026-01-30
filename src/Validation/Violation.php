<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

final readonly class Violation
{
    public function __construct(
        public string $type,
        public string $message,
        public ?string $element = null
    ) {}
}
