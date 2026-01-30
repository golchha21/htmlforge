<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;
use HTMLForge\AST\TextNode;
use HTMLForge\Spec\ElementCategory as C;

final class AccessibleNameValidator
{
    public function validate(Node $node): void
    {
        $this->walk($node);
    }

    private function walk(Node $node): void
    {
        if ($node instanceof ElementNode) {
            $this->validateElement($node);
        }

        foreach ($node->children() as $child) {
            $this->walk($child);
        }
    }

    private function validateElement(ElementNode $node): void
    {
        $tag   = $node->tag;
        $attrs = $node->attributes;

        /*
        |--------------------------------------------------------------------------
        | Images require alt
        |--------------------------------------------------------------------------
        */
        if ($tag === 'img') {
            if (!array_key_exists('alt', $attrs)) {
                throw new ValidationException(
                    "<img> elements must have an alt attribute."
                );
            }
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
            "Interactive element <{$tag}> must have an accessible name."
        );
    }

    private function hasExplicitLabel(ElementNode $node, string $id): bool
    {
        $current = $node;

        // Walk up to the root
        while ($current->parent instanceof ElementNode) {
            $current = $current->parent;
        }

        // Walk the tree from root to find <label for="id">
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
            if ($child instanceof ElementNode) {
                if ($this->findLabelFor($child, $id)) {
                    return true;
                }
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

            if ($child instanceof ElementNode) {
                if ($this->hasVisibleText($child)) {
                    return true;
                }
            }
        }

        return false;
    }
}
