<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;

final class IdReferenceValidator extends AbstractTreeValidator
{
    /** @var array<string,bool> */
    private array $ids = [];

    protected function validateElement(ElementNode $node): void
    {
        if (isset($node->attributes['id'])) {
            $id = (string) $node->attributes['id'];

            if (isset($this->ids[$id])) {
                throw new ValidationException(
                    "Duplicate id '{$id}' found."
                );
            }

            $this->ids[$id] = true;
        }
    }
}
