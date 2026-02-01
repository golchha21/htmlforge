<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Accessibility;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Reporting\Violation;

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
            $this->report(new Violation(
                type: 'structure',
                message: "Heading level skipped from h{$this->lastLevel} to h{$level}.",
                rule: 'structure:heading-skip',
                element: "h{$level}",
                path: $this->currentPath(),
                spec: ['from' => $this->lastLevel, 'to' => $level]
            ));

        }

        $this->lastLevel = $level;
    }
}
