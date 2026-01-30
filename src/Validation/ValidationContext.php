<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

final readonly class ValidationContext
{
    public function __construct(
        public int $htmlDepth = 0,
        public int $headCount = 0,
        public int $bodyCount = 0,
        public bool $insideRawText = false,
        public bool $insideInteractive = false,
        public ?string $nearestContainerTag = null
    ) {}

    public function withElement(
        string $tag,
        bool $rawText,
        bool $interactive
    ): self {
        return new self(
            htmlDepth: $this->htmlDepth,
            headCount: $this->headCount,
            bodyCount: $this->bodyCount,
            insideRawText: $rawText || $this->insideRawText,
            insideInteractive: $interactive || $this->insideInteractive,
            nearestContainerTag: $this->resolveNearestContainer($tag)
        );
    }

    public function withDocumentCounters(
        int $htmlDepth,
        int $headCount,
        int $bodyCount
    ): self {
        return new self(
            htmlDepth: $htmlDepth,
            headCount: $headCount,
            bodyCount: $bodyCount,
            insideRawText: $this->insideRawText,
            insideInteractive: $this->insideInteractive,
            nearestContainerTag: $this->nearestContainerTag
        );
    }

    private function resolveNearestContainer(string $tag): ?string
    {
        // Labeling containers override previous context
        if (in_array($tag, ['label', 'fieldset'], true)) {
            return $tag;
        }

        // Preserve existing container
        return $this->nearestContainerTag;
    }
}
