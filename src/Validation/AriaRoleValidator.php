<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;

final class AriaRoleValidator extends AbstractTreeValidator
{
    protected function validateElement(ElementNode $node): void
    {
        if (!isset($node->attributes['role'])) {
            return;
        }

        $role = (string) $node->attributes['role'];

        if ($node->spec->inert) {
            throw new ValidationException(
                "ARIA role '{$role}' is not allowed on inert element <{$node->tag}>."
            );
        }
    }
}
