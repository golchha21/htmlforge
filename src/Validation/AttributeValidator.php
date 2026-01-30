<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;

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

    public function __construct(
        private ValidationProfile $profile
    ) {}

    protected function validateElement(ElementNode $node): void
    {
        $spec = $node->spec;

        foreach ($node->attributes as $name => $_) {

            // data-* attributes
            if (str_starts_with($name, 'data-')) {
                continue;
            }

            // aria-* attributes
            if (str_starts_with($name, 'aria-')) {
                continue;
            }

            // inline event handlers (policy-based)
            if (str_starts_with($name, 'on')) {
                if ($this->profile === ValidationProfile::STRICT_HTML) {
                    throw new ValidationException(
                        "Inline event handler '{$name}' is not allowed."
                    );
                }
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

            throw new ValidationException(
                "Attribute '{$name}' is not allowed on <{$spec->tag}>."
            );
        }

        // required attributes
        foreach ($spec->requiredAttributes as $required) {
            if (!array_key_exists($required, $node->attributes)) {
                throw new ValidationException(
                    "<{$spec->tag}> requires attribute '{$required}'."
                );
            }
        }
    }
}
