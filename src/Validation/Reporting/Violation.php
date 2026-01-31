<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Reporting;

final readonly class Violation
{
    public function __construct(
        public string $type,
        public string $message,
        public ?string $rule = null,
        public ?string $element = null,
        public ?string $path = null,
        public array $spec = [],
        public string $severity = 'error' // error | warning (profile-controlled)
    ) {}

    public function toArray(): array
    {
        return [
            'type'    => $this->type,
            'rule'    => $this->rule,
            'element' => $this->element,
            'path'    => $this->path,
            'message' => $this->message,
            'spec'    => $this->spec,
        ];
    }
}
