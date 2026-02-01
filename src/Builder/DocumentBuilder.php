<?php

declare(strict_types=1);

namespace HTMLForge\Builder;

use HTMLForge\AST\ElementNode;

final class DocumentBuilder
{
    public function __construct(
        private HtmlBuilder $html
    ) {}

    /**
     * @param ElementNode|ElementNode[] $bodyContent
     */
    public function document(
        ElementNode|array $bodyContent,
        array $options = []
    ): ElementNode {
        /*
        |--------------------------------------------------------------------------
        | Normalize body children
        |--------------------------------------------------------------------------
        */
        $bodyChildren = is_array($bodyContent)
            ? $bodyContent
            : [$bodyContent];

        /*
        |--------------------------------------------------------------------------
        | <head>
        |--------------------------------------------------------------------------
        */
        $headChildren = [];

        // <meta charset>
        if (!empty($options['meta']['charset'])) {
            $headChildren[] = $this->html->element(
                'meta',
                ['charset' => $options['meta']['charset']]
            );
        }

        // <title>
        if (!empty($options['title'])) {
            $headChildren[] = $this->html->element(
                'title',
                [],
                [$options['title']]
            );
        }

        // <meta name="...">
        if (!empty($options['meta']) && is_array($options['meta'])) {
            foreach ($options['meta'] as $name => $content) {
                $headChildren[] = $this->html->element(
                    'meta',
                    [
                        'name'    => $name,
                        'content' => $content,
                    ]
                );
            }
        }

        // <link rel="stylesheet">
        if (!empty($options['stylesheets']) && is_array($options['stylesheets'])) {
            foreach ($options['stylesheets'] as $href) {
                $headChildren[] = $this->html->element(
                    'link',
                    [
                        'rel'  => 'stylesheet',
                        'href' => $href,
                    ]
                );
            }
        }

        // <style>
        if (!empty($options['styles']) && is_string($options['styles'])) {
            $headChildren[] = $this->html->element(
                'style',
                [],
                [$options['styles']]
            );
        }

        $head = $this->html->element('head', [], $headChildren);

        /*
        |--------------------------------------------------------------------------
        | <body>
        |--------------------------------------------------------------------------
        */
        $bodyAttributes = [];

        if (!empty($options['body']) && is_array($options['body'])) {
            $bodyAttributes = $options['body'];
        }

        // External scripts (deferred by default)
        if (!empty($options['scripts']) && is_array($options['scripts'])) {
            foreach ($options['scripts'] as $src) {
                $bodyChildren[] = $this->html->element(
                    'script',
                    [
                        'src'   => $src,
                        'defer' => true,
                    ]
                );
            }
        }

        // Inline scripts (explicit opt-in)
        if (!empty($options['inlineScripts']) && is_array($options['inlineScripts'])) {
            foreach ($options['inlineScripts'] as $code) {
                $bodyChildren[] = $this->html->element(
                    'script',
                    [],
                    [$code]
                );
            }
        }

        $body = $this->html->element(
            'body',
            $bodyAttributes,
            $bodyChildren
        );

        /*
        |--------------------------------------------------------------------------
        | <html>
        |--------------------------------------------------------------------------
        */
        $htmlAttributes = [
            'lang' => $options['lang'] ?? 'en',
        ];

        if (!empty($options['html']) && is_array($options['html'])) {
            $htmlAttributes = array_merge(
                $htmlAttributes,
                $options['html']
            );
        }

        return $this->html->element(
            'html',
            $htmlAttributes,
            [$head, $body]
        );
    }
}
