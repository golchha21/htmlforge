<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Document;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Contracts\FinalizableValidator;
use HTMLForge\Validation\Reporting\Violation;

final class DocumentMetadataValidator extends AbstractTreeValidator implements FinalizableValidator
{
    private bool $seenTitle = false;
    private bool $seenCharset = false;

    protected function validateElement(ElementNode $node): void
    {
        if ($node->tag === 'title') {
            $this->seenTitle = true;
        }

        if (
            $node->tag === 'meta' &&
            array_key_exists('charset', $node->attributes)
        ) {
            $this->seenCharset = true;
        }
    }

    public function finalize(\Closure $emit): void
    {
        if (!$this->seenTitle) {
            $emit(new Violation(
                type: 'structure',
                message: 'Document must contain a <title> element.',
                rule: 'structure:title-required',
                element: 'title',
                path: 'html > head'
            ));
        }

        if (!$this->seenCharset) {
            $emit(new Violation(
                type: 'structure',
                message: 'Document must declare a <meta charset> element.',
                rule: 'structure:charset-required',
                element: 'meta',
                path: 'html > head'
            ));
        }
    }
}
