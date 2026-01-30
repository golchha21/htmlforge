<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;

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
                'Document must contain a <title> element.'
            );
        }
    }
}


