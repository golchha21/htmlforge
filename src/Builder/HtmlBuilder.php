<?php

declare(strict_types=1);

namespace HTMLForge\Builder;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;
use HTMLForge\Spec\DeprecatedElements;
use HTMLForge\Spec\ElementRegistry;
use HTMLForge\Validation\Exceptions\ValidationException;

final class HtmlBuilder
{
    private array $specs;

    public function __construct()
    {
        $this->specs = ElementRegistry::all();
    }

    /**
     * @param array<string, mixed> $attributes
     * @param array<ElementNode|TextNode|string> $children
     */
    public function element(string $tag, array $attributes = [], array $children = []): ElementNode
    {
        if (!isset($this->specs[$tag])) {

            // Known but forbidden (deprecated)
            if (DeprecatedElements::isDeprecated($tag)) {
                throw new ValidationException(
                    "The <{$tag}> element is deprecated and not supported by HTMLForge."
                );
            }

            // Truly unknown
            throw new ValidationException(
                "Unknown HTML element <{$tag}>."
            );
        }

        $spec  = $this->specs[$tag];
        $nodes = [];

        foreach ($children as $child) {
            if (is_string($child)) {
                $nodes[] = new TextNode($child);
            } else {
                $nodes[] = $child;
            }
        }

        return new ElementNode(
            tag: $tag,
            spec: $spec,
            attributes: $attributes,
            children: $nodes
        );
    }

    public function text(string $text): TextNode
    {
        return new TextNode($text);
    }
}
