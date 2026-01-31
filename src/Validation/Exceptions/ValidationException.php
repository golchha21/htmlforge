<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Exceptions;

final class ValidationException extends \RuntimeException
{
    public function __construct(
        string $message,
        public ?string $type = null,
        public ?string $rule = null,
        public ?string $element = null,
        public ?string $path = null,
        public array $spec = []
    ) {
        parent::__construct($message);
    }
}
