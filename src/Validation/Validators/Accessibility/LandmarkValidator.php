<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Accessibility;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class LandmarkValidator extends AbstractTreeValidator
{
    private bool $hasMain = false;

    protected function validateElement(ElementNode $node): void
    {
        if ($node->tag !== 'main') {
            return;
        }

        if ($this->hasMain) {
            throw new ValidationException(
                message: "Multiple <{$node->tag}> landmarks are not allowed.",
                type: 'accessibility',
                rule: 'accessibility:landmark-duplicate',
                element: $node->tag,
                path: $this->currentPath()
            );

        }

        $this->hasMain = true;
    }
}
