<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Accessibility;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class FormLabelValidator extends AbstractTreeValidator
{
    /**
     * @var array<string, true>
     */
    private array $explicitLabels = [];

    protected function validateElement(ElementNode $node): void
    {
        // Register explicit labels: <label for="id">
        if ($node->tag === 'label' && isset($node->attributes['for'])) {
            $this->explicitLabels[$node->attributes['for']] = true;
            return;
        }

        // Only validate form controls
        if (!$this->isFormControl($node)) {
            return;
        }

        // Hidden inputs never require labels
        if ($node->tag === 'input' && ($node->attributes['type'] ?? '') === 'hidden') {
            return;
        }

        // Case 1: implicit label <label><input></label>
        if (
            $node->parent instanceof ElementNode &&
            $node->parent->tag === 'label'
        ) {
            return;
        }

        // Case 2: explicit label via for/id (seen earlier)
        if (
            isset($node->attributes['id']) &&
            isset($this->explicitLabels[$node->attributes['id']])
        ) {
            return;
        }

         throw new ValidationException(
            message: "<{$node->tag}> must be associated with a <label>.",
             type: 'accessibility',
             rule: 'accessibility:label-required',
             element: $node->tag,
             path: $this->currentPath()
        );
    }

    private function isFormControl(ElementNode $node): bool
    {
        return in_array($node->tag, [
            'input',
            'select',
            'textarea',
            'output',
            'progress',
            'meter',
        ], true);
    }
}
