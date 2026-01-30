<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;

final class UrlAttributeValidator extends AbstractTreeValidator
{
    private const URL_ATTRIBUTES = ['href', 'src', 'action'];

    protected function validateElement(ElementNode $node): void
    {
        foreach (self::URL_ATTRIBUTES as $attr) {
            if (!isset($node->attributes[$attr])) {
                continue;
            }

            if (!filter_var($node->attributes[$attr], FILTER_VALIDATE_URL)
                && !str_starts_with($node->attributes[$attr], '/')
            ) {
                throw new ValidationException(
                    "Invalid URL in '{$attr}' attribute."
                );
            }
        }
    }
}

