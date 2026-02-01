<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Contracts;

use HTMLForge\AST\Node;
use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;
use HTMLForge\Validation\Reporting\Violation;
use Closure;
use LogicException;

abstract class AbstractTreeValidator
{
    /**
     * Current traversal path
     *
     * Example: html > body > form > input
     */
    protected array $path = [];

    /**
     * Violation emitter provided by the pipeline
     */
    private ?Closure $emit = null;

    final public function validate(Node $node, Closure $emit): void
    {
        $this->emit = $emit;
        $this->path = []; // reset per run

        $this->walk($node);

        $this->emit = null;
    }

    final protected function walk(Node $node): void
    {
        if ($node instanceof ElementNode) {
            $this->path[] = $node->tag;

            $this->validateElement($node);

            if ($node->spec->inert || $node->spec->rawText) {
                array_pop($this->path);
                return;
            }
        }

        foreach ($node->children() as $child) {
            $this->walk($child);
        }

        if ($node instanceof ElementNode) {
            array_pop($this->path);
        }
    }

    final protected function report(Violation $violation): void
    {
        if ($this->emit === null) {
            throw new LogicException(
                'Violation emitted outside of validator execution'
            );
        }

        ($this->emit)($violation);
    }

    protected function currentPath(): string
    {
        return implode(' > ', $this->path);
    }

    protected function validateText(TextNode $node): void
    {
        // default: no-op
    }

    abstract protected function validateElement(ElementNode $node): void;
}
