<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

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
                    message: "Invalid URL in '{$attr}' attribute.",
                    type: 'attributes',
                    rule: 'attributes:url-invalid',
                    element: $node->tag,
                    path: $this->currentPath(),
                    spec: ['attribute' => $attr]
                );
            }
        }
    }
}

