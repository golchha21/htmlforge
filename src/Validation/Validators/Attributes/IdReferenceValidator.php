<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class IdReferenceValidator extends AbstractTreeValidator
{
    private array $ids = [];
    private array $references = [];

    protected function validateElement(ElementNode $node): void
    {
        // Collect IDs
        if (isset($node->attributes['id'])) {
            $id = $node->attributes['id'];

            if (isset($this->ids[$id])) {
                throw new ValidationException(
                    message: "Duplicate id '{$id}'.",
                    type: 'attributes',
                    rule: 'attributes:duplicate-id',
                    element: $node->tag,
                    path: $this->currentPath(),
                    spec: ['id' => $id]
                );
            }

            $this->ids[$id] = true;
        }

        // Collect IDREFs
        foreach (['for', 'aria-labelledby', 'aria-describedby'] as $attr) {
            if (isset($node->attributes[$attr])) {
                foreach (preg_split('/\s+/', $node->attributes[$attr]) as $ref) {
                    $this->references[] = [
                        'id' => $ref,
                        'tag' => $node->tag,
                        'path' => $this->currentPath(),
                    ];
                }
            }
        }
    }

    public function finalize(): void
    {
        foreach ($this->references as $ref) {
            if (!isset($this->ids[$ref['id']])) {
                throw new ValidationException(
                    message: "Referenced id '{$ref['id']}' does not exist.",
                    type: 'attributes',
                    rule: 'attributes:id-reference-missing',
                    element: $ref['tag'],
                    path: $ref['path'],
                    spec: ['id' => $ref['id']]
                );
            }
        }
    }
}
