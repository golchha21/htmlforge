<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class AttributeValidator extends AbstractTreeValidator
{
    private const GLOBAL_ATTRIBUTES = [
        'id',
        'class',
        'style',
        'title',
        'hidden',
        'tabindex',
        'contenteditable',
        'draggable',
        'spellcheck',
        'translate',
        'dir',
        'role',
    ];

    protected function validateElement(ElementNode $node): void
    {
        $spec = $node->spec;
        $tag  = $node->tag;

        /*
        |--------------------------------------------------------------------------
        | Allowed attributes
        |--------------------------------------------------------------------------
        */
        foreach ($node->attributes as $name => $_value) {

            // data-* attributes
            if (str_starts_with($name, 'data-')) {
                continue;
            }

            // aria-* attributes (syntax only; semantics elsewhere)
            if (str_starts_with($name, 'aria-')) {
                continue;
            }

            // inline event handlers (policy-controlled)
            if (str_starts_with($name, 'on')) {
                return;
            }

            // global attributes
            if (in_array($name, self::GLOBAL_ATTRIBUTES, true)) {
                continue;
            }

            // element-specific attributes
            if (in_array($name, $spec->allowedAttributes, true)) {
                continue;
            }

            throw new ValidationException(
                message: "Attribute '{$name}' is not allowed on <{$tag}>.",
                rule: 'attributes:allowed',
                element: $tag,
                path: $this->currentPath(),
                spec: ['attribute' => $name]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Required attributes
        |--------------------------------------------------------------------------
        */
        foreach ($spec->requiredAttributes as $required) {
            if (!array_key_exists($required, $node->attributes)) {
                throw new ValidationException(
                    message: "Attribute '{$name}' is not allowed on <{$spec->tag}>.",
                    type: 'attributes',
                    rule: 'attributes:not-allowed',
                    element: $spec->tag,
                    path: $this->currentPath(),
                    spec: ['attribute' => $name]
                );
            }
        }
    }
}
