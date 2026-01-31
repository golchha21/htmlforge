<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class LangAttributeValidator extends AbstractTreeValidator
{
    protected function validateElement(ElementNode $node): void
    {
        if ($node->tag !== 'html') {
            return;
        }

        $lang = $node->attributes['lang'] ?? null;

        if ($lang === null) {
            return;
        }

        if (!preg_match('/^[a-zA-Z]{2,3}(-[a-zA-Z]{2})?$/', $lang)) {
            throw new ValidationException(
                message: "Invalid language code '{$lang}'.",
                type: 'attributes',
                rule: 'attributes:lang-invalid',
                element: $node->tag,
                path: $this->currentPath(),
                spec: ['value' => $lang]
            );
        }
    }

}

