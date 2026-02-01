<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Content;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;
use HTMLForge\Validation\Context\ValidationContext;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Reporting\Violation;

final class ContentModelValidator extends AbstractTreeValidator
{
    private ValidationContext $context;

    /**
     * Interactive controls that must NOT be nested inside other controls
     */
    private const INTERACTIVE_CONTROLS = [
        'button',
        'select',
        'textarea',
        'option',
    ];

    /**
     * Containers that are allowed to contain interactive controls
     */
    private const LABELING_CONTAINERS = [
        'label',
        'fieldset',
    ];

    public function __construct()
    {
        $this->context = new ValidationContext();
    }

    protected function validateElement(ElementNode $node): void
    {
        $spec = $node->spec;
        $tag  = $node->tag;

        /*
        |--------------------------------------------------------------------------
        | Interactive control nesting
        |--------------------------------------------------------------------------
        */
        if (
            in_array($tag, self::INTERACTIVE_CONTROLS, true) &&
            $this->context->insideInteractive &&
            !in_array($this->context->nearestContainerTag, self::LABELING_CONTAINERS, true)
        ) {
            $this->report(new Violation(
                type: 'structure',
                message: "Interactive control <{$tag}> must not be nested inside another interactive control.",
                rule: 'structure:interactive-nesting',
                element: $tag,
                path: $this->currentPath()
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Void elements must not have children
        |--------------------------------------------------------------------------
        */
        if ($spec->void && count($node->children) > 0) {
            $this->report(new Violation(
                type: 'structure',
                message: "<{$tag}> is a void element and must not have children.",
                rule: 'structure:void-has-children',
                element: $tag,
                path: $this->currentPath()
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Document structure
        |--------------------------------------------------------------------------
        */
        $htmlDepth = $this->context->htmlDepth;
        $headCount = $this->context->headCount;
        $bodyCount = $this->context->bodyCount;

        if ($tag === 'html') {
            if ($htmlDepth > 0) {
                $this->report(new Violation(
                    type: 'structure',
                    message: 'Nested <html> elements are not allowed.',
                    rule: 'structure:single-html',
                    element: 'html',
                    path: $this->currentPath()
                ));
            }
            $htmlDepth++;
        }

        if ($tag === 'head') {
            $headCount++;
            if ($headCount > 1) {
                $this->report(new Violation(
                    type: 'structure',
                    message: 'Only one <head> element is allowed per document.',
                    rule: 'structure:single-head',
                    element: 'head',
                    path: $this->currentPath()
                ));
            }
        }

        if ($tag === 'body') {
            $bodyCount++;
            if ($bodyCount > 1) {
                $this->report(new Violation(
                    type: 'structure',
                    message: 'Only one <body> element is allowed per document.',
                    rule: 'structure:single-body',
                    element: 'body',
                    path: $this->currentPath()
                ));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Advance context
        |--------------------------------------------------------------------------
        */
        $this->context = $this->context
            ->withDocumentCounters($htmlDepth, $headCount, $bodyCount)
            ->withElement(
                tag: $tag,
                rawText: $spec->rawText,
                interactive: in_array($tag, self::INTERACTIVE_CONTROLS, true)
            );
    }

    protected function validateText(TextNode $node): void
    {
        // Text nodes are always allowed
    }
}
