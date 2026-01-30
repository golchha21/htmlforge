<?php

declare(strict_types=1);

namespace HTMLForge;

use Throwable;
use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\Renderer\{HtmlRenderer, RenderMode};
use HTMLForge\Render\RenderResult;
use HTMLForge\Validation\{
    ValidatorPipeline,
    ValidationException,
    ValidationProfile,
    ValidatorProfileFactory
};

final class HTMLForgeEngine
{
    private ValidatorPipeline $pipeline;
    private HtmlRenderer $renderer;

    public function __construct(
        HTMLForgeConfig $config = new HTMLForgeConfig()
    ) {
        $this->pipeline = new ValidatorPipeline(
            validators: ValidatorProfileFactory::build($config->profile),
            mode: $config->mode
        );

        $this->renderer = new HtmlRenderer();
    }

    /**
     * Render HTML from an AST node.
     */
    public function render(Node $document): RenderResult
    {
        try {
            return $this->renderInternal($document);
        } catch (ValidationException $e) {
            // Expected validation failure
            return RenderResult::fromValidationException($e);
        } catch (Throwable $e) {
            // Unexpected system error (TypeError, Error, etc.)
            return RenderResult::fromFatalError($e);
        }
    }

    private function renderInternal(Node $document): RenderResult
    {
        $report = $this->pipeline->validate($document);

        if ($report->hasErrors()) {
            return RenderResult::failure($report);
        }

        return RenderResult::success(
            $this->renderer->render(
                $document,
                $this->detectRenderMode($document)
            )
        );
    }

    private function detectRenderMode(Node $node): RenderMode
    {
        if ($node instanceof ElementNode && $node->tag === 'html') {
            return RenderMode::Document;
        }

        return RenderMode::Fragment;
    }
}
