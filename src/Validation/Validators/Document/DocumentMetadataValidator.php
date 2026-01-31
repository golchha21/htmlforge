<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Document;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Contracts\FinalizableValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class DocumentMetadataValidator
    extends AbstractTreeValidator
    implements FinalizableValidator
{
    private bool $seenTitle = false;

    protected function validateElement(ElementNode $node): void
    {
        if ($node->tag === 'title') {
            $this->seenTitle = true;
        }
    }

    public function finalize(): void
    {
        if (!$this->seenTitle) {
            throw new ValidationException(
                message: 'Document must contain a <title> element.',
                type: 'metadata',
                rule: 'metadata:title-required',
                element: 'head',
                path: $this->currentPath()
            );
        }
    }
}


