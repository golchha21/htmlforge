<?php

declare(strict_types=1);

namespace HTMLForge;

use HTMLForge\AST\ElementNode;
use HTMLForge\AST\Node;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\Render\RenderResult;
use HTMLForge\Renderer\{HtmlRenderer, RenderMode};
use HTMLForge\Validation\Pipeline\ValidatorPipeline;
use HTMLForge\Validation\Pipeline\ValidatorProfileFactory;
use Throwable;

final class HTMLForgeEngine
{
    private ValidatorPipeline $pipeline;
    private HtmlRenderer $renderer;

    public function __construct(
        HTMLForgeConfig $config = new HTMLForgeConfig()
    ) {
        $this->pipeline = new ValidatorPipeline(
            validators: ValidatorProfileFactory::build($config->profile),
            mode: $config->mode,
            profile: $config->profile
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
        } catch (Throwable $e) {
            // System / programmer error (never validation)
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
