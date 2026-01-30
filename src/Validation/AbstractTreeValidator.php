<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\Node;
use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;

abstract class AbstractTreeValidator
{
    final public function validate(Node $node): void
    {
        $this->walk($node);
    }

    final protected function walk(Node $node): void
    {
        if ($node instanceof ElementNode) {
            $this->validateElement($node);

            // 🚫 Stop traversal for inert OR raw-text elements
            if ($node->spec->inert || $node->spec->rawText) {
                return;
            }
        }

        foreach ($node->children() as $child) {
            $this->walk($child);
        }
    }

    protected function validateText(TextNode $node): void
    {
        // default: no-op
    }

    abstract protected function validateElement(ElementNode $node): void;
}

