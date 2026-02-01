<?php

declare(strict_types=1);

namespace HTMLForge\Spec;

use HTMLForge\Spec\ElementCategory as C;

final class ElementRegistry
{
    /** @return array<string, ElementSpec> */
    public static function all(): array
    {
        return [

            /* =============================
             | Document root
             * ============================= */
            'html' => new ElementSpec(
                'html',
                [C::DocumentRoot],
                allowedAttributes: ['lang']
            ),

            /* =============================
             | Metadata
             * ============================= */
            'head'  => new ElementSpec('head',  [C::Metadata]),
            'title' => new ElementSpec('title', [C::Metadata]),

            'base' => new ElementSpec(
                'base',
                [C::Metadata],
                void: true,
                allowedAttributes: ['href', 'target']
            ),

            'meta' => new ElementSpec(
                'meta',
                [C::Metadata],
                void: true,
                allowedAttributes: [
                    'charset',
                    'name',
                    'content',
                    'http-equiv',
                ]
            ),

            'link' => new ElementSpec(
                'link',
                [C::Metadata],
                void: true,
                allowedAttributes: [
                    'rel',
                    'href',
                    'media',
                    'as',
                    'crossorigin',
                    'referrerpolicy',
                    'sizes',
                    'type',
                ]
            ),

            'style' => new ElementSpec(
                'style',
                [C::Metadata, C::RawText],
                allowedAttributes: ['media'],
                rawText: true,
                inert: true
            ),

            'script' => new ElementSpec(
                'script',
                [C::Metadata, C::RawText],
                allowedAttributes: [
                    'src',
                    'type',
                    'async',
                    'defer',
                    'crossorigin',
                    'referrerpolicy',
                    'nomodule',
                ],
                rawText: true,
                inert: true
            ),

            'noscript' => new ElementSpec(
                'noscript',
                [C::Metadata, C::Flow]
            ),

            /* =============================
             | Sectioning / landmarks
             * ============================= */
            'body'    => new ElementSpec('body',    [C::Sectioning, C::Flow]),
            'header'  => new ElementSpec('header',  [C::Sectioning, C::Flow]),
            'nav'     => new ElementSpec('nav',     [C::Sectioning, C::Flow]),
            'main'    => new ElementSpec('main',    [C::Sectioning, C::Flow]),
            'section' => new ElementSpec('section', [C::Sectioning, C::Flow]),
            'article' => new ElementSpec('article', [C::Sectioning, C::Flow]),
            'aside'   => new ElementSpec('aside',   [C::Sectioning, C::Flow]),
            'footer'  => new ElementSpec('footer',  [C::Sectioning, C::Flow]),
            'address' => new ElementSpec('address', [C::Sectioning, C::Phrasing]),

            /* =============================
             | Headings
             * ============================= */
            'h1' => new ElementSpec('h1', [C::Heading, C::Flow]),
            'h2' => new ElementSpec('h2', [C::Heading, C::Flow]),
            'h3' => new ElementSpec('h3', [C::Heading, C::Flow]),
            'h4' => new ElementSpec('h4', [C::Heading, C::Flow]),
            'h5' => new ElementSpec('h5', [C::Heading, C::Flow]),
            'h6' => new ElementSpec('h6', [C::Heading, C::Flow]),

            /* =============================
             | Grouping content
             * ============================= */
            'p'          => new ElementSpec('p',          [C::Flow]),
            'hr'         => new ElementSpec('hr',         [C::Flow], void: true),
            'pre'        => new ElementSpec('pre',        [C::Flow]),
            'blockquote' => new ElementSpec('blockquote',[C::Flow]),
            'ol'         => new ElementSpec('ol',         [C::Flow]),
            'ul'         => new ElementSpec('ul',         [C::Flow]),
            'li'         => new ElementSpec('li',         [C::Flow]),
            'dl'         => new ElementSpec('dl',         [C::Flow]),
            'dt'         => new ElementSpec('dt',         [C::Flow]),
            'dd'         => new ElementSpec('dd',         [C::Flow]),
            'figure'     => new ElementSpec('figure',     [C::Flow]),
            'figcaption' => new ElementSpec('figcaption', [C::Flow]),
            'div'        => new ElementSpec('div',        [C::Flow]),

            /* =============================
             | Phrasing content
             * ============================= */
            'a' => new ElementSpec(
                'a',
                [C::Flow, C::Phrasing, C::Interactive],
                allowedAttributes: ['href', 'target', 'rel', 'download']
            ),

            'span'   => new ElementSpec('span',   [C::Flow, C::Phrasing]),
            'em'     => new ElementSpec('em',     [C::Flow, C::Phrasing]),
            'strong' => new ElementSpec('strong', [C::Flow, C::Phrasing]),
            'small'  => new ElementSpec('small',  [C::Flow, C::Phrasing]),
            'code'   => new ElementSpec('code',   [C::Flow, C::Phrasing]),
            'br'     => new ElementSpec('br',     [C::Flow, C::Phrasing], void: true),

            /* =============================
             | Embedded
             * ============================= */
            'img' => new ElementSpec(
                'img',
                [C::Flow, C::Phrasing, C::Embedded],
                void: true,
                allowedAttributes: [
                    'src',
                    'alt',
                    'width',
                    'height',
                    'loading',
                    'decoding',
                ],
                requiredAttributes: ['src', 'alt']
            ),

            'iframe' => new ElementSpec(
                'iframe',
                [C::Flow, C::Embedded, C::Interactive],
                allowedAttributes: [
                    'src',
                    'title',
                    'loading',
                    'allow',
                    'referrerpolicy',
                ]
            ),

            /* =============================
             | Forms
             * ============================= */
            'form' => new ElementSpec(
                'form',
                [C::Flow, C::FormAssociated],
                allowedAttributes: ['action', 'method', 'enctype', 'novalidate']
            ),

            'label' => new ElementSpec(
                'label',
                [C::Flow, C::Phrasing, C::FormAssociated],
                allowedAttributes: ['for']
            ),

            'input' => new ElementSpec(
                'input',
                [C::Flow, C::Phrasing, C::FormAssociated, C::Interactive],
                void: true,
                allowedAttributes: [
                    'type',
                    'name',
                    'value',
                    'placeholder',
                    'checked',
                    'disabled',
                    'required',
                    'readonly',
                    'autocomplete',
                ]
            ),

            'button' => new ElementSpec(
                'button',
                [C::Flow, C::Phrasing, C::FormAssociated, C::Interactive],
                allowedAttributes: ['type', 'name', 'value', 'disabled']
            ),

            'select'   => new ElementSpec('select',   [C::Flow, C::FormAssociated, C::Interactive]),
            'textarea' => new ElementSpec('textarea', [C::Flow, C::FormAssociated, C::Interactive]),

            /* =============================
             | Inert / templates
             * ============================= */
            'template' => new ElementSpec(
                'template',
                [C::Flow, C::Inert],
                inert: true
            ),
        ];
    }
}
