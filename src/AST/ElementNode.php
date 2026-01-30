<?php

declare(strict_types=1);

namespace HTMLForge\AST;

use HTMLForge\Spec\ElementSpec;

final class ElementNode implements Node
{
    /**
     * @var ElementNode|null
     */
    public ?ElementNode $parent = null;

    /**
     * @param array<string, string|bool|int|float|null> $attributes
     * @param Node[] $children
     */
    public function __construct(
        public string $tag,
        public ElementSpec $spec,
        public array $attributes = [],
        public array $children = []
    ) {
        // Assign parent pointers
        foreach ($this->children as $child) {
            if ($child instanceof Node && property_exists($child, 'parent')) {
                $child->parent = $this;
            }
        }
    }

    /** @return Node[] */
    public function children(): array
    {
        return $this->children;
    }
}
