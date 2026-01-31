<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Accessibility;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;
use HTMLForge\Spec\ElementCategory as C;

final class AccessibleNameValidator extends AbstractTreeValidator
{
    protected function validateElement(ElementNode $node): void
    {
        $tag   = $node->tag;
        $attrs = $node->attributes;

        /*
        |--------------------------------------------------------------------------
        | <img> requires alt
        |--------------------------------------------------------------------------
        */
        if ($tag === 'img') {
            if (!array_key_exists('alt', $attrs)) {
                throw new ValidationException(
                    message: "<img> elements must have an alt attribute.",
                    type: 'accessibility',
                    rule: 'accessibility:img-alt-required',
                    element: 'img',
                    path: $this->currentPath()
                );
            }

            // alt="" is valid (decorative images)
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Hidden inputs are not exposed
        |--------------------------------------------------------------------------
        */
        if ($tag === 'input' && ($attrs['type'] ?? '') === 'hidden') {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Only interactive elements require accessible names
        |--------------------------------------------------------------------------
        */
        if (!in_array(C::Interactive, $node->spec->categories, true)) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ARIA-provided names
        |--------------------------------------------------------------------------
        */
        if (
            !empty(trim((string) ($attrs['aria-label'] ?? ''))) ||
            !empty(trim((string) ($attrs['aria-labelledby'] ?? '')))
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Implicit label: <label><input></label>
        |--------------------------------------------------------------------------
        */
        if (
            $tag === 'input' &&
            $node->parent instanceof ElementNode &&
            $node->parent->tag === 'label'
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Explicit label: <label for="id">
        |--------------------------------------------------------------------------
        */
        if (
            $tag === 'input' &&
            isset($attrs['id']) &&
            $this->hasExplicitLabel($node, $attrs['id'])
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Visible text content (buttons, links, etc.)
        |--------------------------------------------------------------------------
        */
        if ($this->hasVisibleText($node)) {
            return;
        }

        throw new ValidationException(
            message: "Interactive element <{$tag}> must have an accessible name.",
            type: 'accessibility',
            rule: 'accessibility:interactive-name-required',
            element: $tag,
            path: $this->currentPath()
        );
    }

    private function hasExplicitLabel(ElementNode $node, string $id): bool
    {
        $current = $node;

        while ($current->parent instanceof ElementNode) {
            $current = $current->parent;
        }

        return $this->findLabelFor($current, $id);
    }

    private function findLabelFor(ElementNode $node, string $id): bool
    {
        if (
            $node->tag === 'label' &&
            ($node->attributes['for'] ?? null) === $id
        ) {
            return true;
        }

        foreach ($node->children() as $child) {
            if ($child instanceof ElementNode && $this->findLabelFor($child, $id)) {
                return true;
            }
        }

        return false;
    }

    private function hasVisibleText(ElementNode $node): bool
    {
        foreach ($node->children() as $child) {
            if ($child instanceof TextNode && trim($child->text) !== '') {
                return true;
            }

            if ($child instanceof ElementNode && $this->hasVisibleText($child)) {
                return true;
            }
        }

        return false;
    }
}
