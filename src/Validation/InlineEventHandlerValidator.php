<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;

final class InlineEventHandlerValidator extends AbstractTreeValidator
{
    protected function validateElement(ElementNode $node): void
    {
        foreach ($node->attributes as $name => $_) {
            if (str_starts_with($name, 'on')) {
                throw new ValidationException(
                    "Inline event handler '{$name}' is not allowed. Use external scripts."
                );
            }
        }
    }
}

