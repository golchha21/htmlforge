<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Contracts;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;
use HTMLForge\AST\TextNode;

abstract class AbstractTreeValidator
{
    /**
     * Best-effort element path (v1.1)
     *
     * Example: html > body > form > input
     */
    private array $path = [];

    final public function validate(Node $node): void
    {
        // Reset per validation run
        $this->path = [];

        $this->walk($node);
    }

    final protected function walk(Node $node): void
    {
        if ($node instanceof ElementNode) {
            $this->path[] = $node->tag;

            try {
                $this->validateElement($node);

                if (!$node->spec->inert && !$node->spec->rawText) {
                    foreach ($node->children() as $child) {
                        $this->walk($child);
                    }
                }
            } finally {
                array_pop($this->path);
            }

            return;
        }

        foreach ($node->children() as $child) {
            $this->walk($child);
        }
    }

    /**
     * Current element path for validators
     */
    protected function currentPath(): string
    {
        return implode(' > ', $this->path);
    }

    protected function validateText(TextNode $node): void
    {
        // default: no-op
    }

    abstract protected function validateElement(ElementNode $node): void;
}
