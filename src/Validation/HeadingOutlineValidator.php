<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

use HTMLForge\AST\ElementNode;

final class HeadingOutlineValidator extends AbstractTreeValidator
{
    private int $lastLevel = 0;

    protected function validateElement(ElementNode $node): void
    {
        if (!preg_match('/^h([1-6])$/', $node->tag, $m)) {
            return;
        }

        $level = (int) $m[1];

        if ($this->lastLevel > 0 && $level > $this->lastLevel + 1) {
            throw new ValidationException(
                "Heading level skipped from h{$this->lastLevel} to h{$level}."
            );
        }

        $this->lastLevel = $level;
    }
}
