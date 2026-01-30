<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;

final class LangAttributeValidator extends AbstractTreeValidator
{
    protected function validateElement(ElementNode $node): void
    {
        if ($node->tag !== 'html') {
            return;
        }

        if (!isset($node->attributes['lang'])) {
            throw new ValidationException(
                '<html> element must have a lang attribute.'
            );
        }
    }
}

