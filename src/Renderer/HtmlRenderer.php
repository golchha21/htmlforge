<?php

declare(strict_types=1);

namespace HTMLForge\Renderer;

use HTMLForge\AST\Node;
use HTMLForge\AST\ElementNode;
use HTMLForge\AST\TextNode;

final class HtmlRenderer
{
    public function render(Node $node, RenderMode $mode = RenderMode::Fragment): string
    {
        $html = $this->renderNode($node);

        if ($mode === RenderMode::Document) {
            return "<!DOCTYPE html>\n" . $html;
        }

        return $html;
    }

    public function renderNode(Node $node): string
    {
        if ($node instanceof TextNode) {
            return htmlspecialchars($node->text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }

        if (!$node instanceof ElementNode) {
            return '';
        }

        $tag = $node->tag;
        $attrs = $this->renderAttributes($node->attributes);

        if ($node->spec->void) {
            return "<{$tag}{$attrs}>";
        }

        $content = '';

        if ($node->spec->rawText) {
            foreach ($node->children as $child) {
                if ($child instanceof TextNode) {
                    $content .= $child->text;
                }
            }
        } else {
            foreach ($node->children as $child) {
                $content .= $this->render($child);
            }
        }

        return "<{$tag}{$attrs}>{$content}</{$tag}>";
    }

    private function renderAttributes(array $attributes): string
    {
        if ($attributes === []) {
            return '';
        }

        $result = '';

        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $result .= " {$key}";
            } elseif ($value !== false && $value !== null) {
                $escaped = htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                $result .= " {$key}=\"{$escaped}\"";
            }
        }

        return $result;
    }
}
