<?php

declare(strict_types=1);

namespace HTMLForge\Spec;

use HTMLForge\AST\ElementNode;

final readonly class ElementSpec
{
    /**
     * @param ElementCategory[] $categories
     * @param string[] $allowedAttributes
     * @param string[] $requiredAttributes
     * @param string[] $allowedChildren
     */
    public function __construct(
        public string $tag,
        public array $categories,
        public bool $void = false,
        public bool $deprecated = false,
        public array $allowedAttributes = [],
        public array $requiredAttributes = [],
        public array $allowedChildren = [],
        public bool $rawText = false,
        public bool $inert = false
    ) {}

    public function isExposedToAccessibilityTree(ElementNode $node): bool
    {
        // Never exposed
        if ($this->inert) {
            return false;
        }

        $attrs = $node->attributes;

        // Conditional exposure rules
        return match ($this->tag) {
            'a' => array_key_exists('href', $attrs),

            'input' => !(
                array_key_exists('type', $attrs)
                && strtolower((string) $attrs['type']) === 'hidden'
            ),

            default => true,
        };
    }
}
