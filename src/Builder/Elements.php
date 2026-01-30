<?php

declare(strict_types=1);

namespace HTMLForge\Builder;

use HTMLForge\AST\ElementNode;

final class Elements
{
    public function __construct(
        private HtmlBuilder $html
    ) {}

    public function div(array $attrs = [], array $children = []): ElementNode
    {
        return $this->html->element('div', $attrs, $children);
    }

    public function p(string $text): ElementNode
    {
        return $this->html->element('p', [], [$text]);
    }

    public function h1(string $text): ElementNode
    {
        return $this->html->element('h1', [], [$text]);
    }

    public function h2(string $text): ElementNode
    {
        return $this->html->element('h2', [], [$text]);
    }

    public function h3(string $text): ElementNode
    {
        return $this->html->element('h3', [], [$text]);
    }

    public function h4(string $text): ElementNode
    {
        return $this->html->element('h4', [], [$text]);
    }

    public function h5(string $text): ElementNode
    {
        return $this->html->element('h5', [], [$text]);
    }

    public function h6(string $text): ElementNode
    {
        return $this->html->element('h6', [], [$text]);
    }

    public function button(string $text, array $attrs = []): ElementNode
    {
        return $this->html->element('button', $attrs, [$text]);
    }

    public function img(string $src, string $alt, array $attrs = []): ElementNode
    {
        return $this->html->element(
            'img',
            array_merge($attrs, ['src' => $src, 'alt' => $alt])
        );
    }
}
