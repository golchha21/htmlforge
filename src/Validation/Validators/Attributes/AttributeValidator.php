<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Reporting\Violation;

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
        | Attribute allowance
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

            // inline event handlers (policy-controlled, but detected here)
            if (str_starts_with($name, 'on')) {
                continue;
            }

            // global attributes
            if (in_array($name, self::GLOBAL_ATTRIBUTES, true)) {
                continue;
            }

            // element-specific attributes
            if (in_array($name, $spec->allowedAttributes, true)) {
                continue;
            }

            $this->report(new Violation(
                type: 'attributes',
                message: "Attribute '{$name}' is not allowed on <{$tag}>.",
                rule: 'attributes:allowed',
                element: $tag,
                path: $this->currentPath(),
                spec: ['attribute' => $name]
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Required attributes
        |--------------------------------------------------------------------------
        */
        foreach ($spec->requiredAttributes as $required) {
            if (!array_key_exists($required, $node->attributes)) {
                $this->report(new Violation(
                    type: 'attributes',
                    message: "Attribute '{$required}' is required on <{$tag}>.",
                    rule: 'attributes:required',
                    element: $tag,
                    path: $this->currentPath(),
                    spec: ['attribute' => $required]
                ));
            }
        }
    }
}
