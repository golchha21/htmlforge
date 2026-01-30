<?php

declare(strict_types=1);

namespace HTMLForge\AST;

final readonly class TextNode implements Node
{
    public function __construct(
        public string $text
    ) {}

    /** @return Node[] */
    public function children(): array
    {
        return [];
    }
}
