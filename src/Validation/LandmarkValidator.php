<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;

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
                'Only one <main> landmark is allowed per document.'
            );
        }

        $this->hasMain = true;
    }
}
