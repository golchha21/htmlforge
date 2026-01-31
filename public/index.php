<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use HTMLForge\Builder\DocumentBuilder;
use HTMLForge\Builder\Elements;
use HTMLForge\Builder\HtmlBuilder;
use HTMLForge\Config\HTMLForgeConfig;
use HTMLForge\HTMLForge;
use HTMLForge\Validation\Profiles\ValidationMode;
use HTMLForge\Validation\Profiles\ValidationProfile;

/*
|--------------------------------------------------------------------------
| Builders
|--------------------------------------------------------------------------
*/

$html = new HtmlBuilder();
$el   = new Elements($html);
$doc  = new DocumentBuilder($html);

/*
|--------------------------------------------------------------------------
| Document-level styles (STRICT_HTML-safe)
|--------------------------------------------------------------------------
*/

$styles = <<<CSS
:root {
  --bg: #ffffff;
  --fg: #111827;
  --muted: #6b7280;
  --border: #e5e7eb;
  --accent: #2563eb;
}

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
  color: var(--fg);
  background: var(--bg);
  line-height: 1.6;
}

header {
  border-bottom: 1px solid var(--border);
  background: #f9fafb;
}

nav {
  max-width: 1200px;
  margin: 0 auto;
}

nav ul {
  display: flex;
  gap: 1.5rem;
  list-style: none;
  margin: 0;
  padding: 1rem 2rem;
}

nav a {
  text-decoration: none;
  color: var(--fg);
  font-weight: 500;
}

nav a:hover {
  color: var(--accent);
}

main {
  display: grid;
  grid-template-columns: 3fr 1fr;
  gap: 2rem;
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

figure {
  margin: 0;
}

figcaption {
  font-size: 0.875rem;
  color: var(--muted);
}

aside {
  padding: 1.5rem;
  background: #f9fafb;
  border: 1px solid var(--border);
  border-radius: 0.5rem;
}

label {
  display: block;
  font-weight: 500;
  margin-bottom: 0.25rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid var(--border);
  border-radius: 0.375rem;
}

button {
  padding: 0.6rem 1.25rem;
  background: var(--accent);
  color: #fff;
  border: none;
  border-radius: 0.375rem;
  font-weight: 600;
  cursor: pointer;
}

footer {
  border-top: 1px solid var(--border);
  padding: 1.5rem 2rem;
  text-align: center;
  color: var(--muted);
  font-size: 0.875rem;
}
CSS;

/*
|--------------------------------------------------------------------------
| Header / Navigation
|--------------------------------------------------------------------------
*/

$header = $html->element('header', [], [
    $html->element('nav', [], [
        $html->element('ul', [], [
            $html->element('li', [], [
                $html->element('a', ['href' => '/'], ['Home']),
            ]),
            $html->element('li', [], [
                $html->element('a', ['href' => '/about'], ['About']),
            ]),
            $html->element('li', [], [
                $html->element('a', ['href' => '/contact'], ['Contact']),
            ]),
        ]),
    ]),
]);

/*
|--------------------------------------------------------------------------
| Main content
|--------------------------------------------------------------------------
*/

$article = $html->element('article', [], [

    $el->h1('HTMLForge Example Page'),

    $el->p(
        'This page is generated entirely using HTMLForge and passes STRICT_HTML validation.'
    ),

    $html->element('section', ['class' => 'features'], [
        $el->h2('Features'),
        $html->element('ul', [], [
            $html->element('li', [], ['Standards-first HTML']),
            $html->element('li', [], ['Accessibility enforced']),
            $html->element('li', [], ['No silent fixes']),
        ]),
    ]),

    $html->element('section', ['class' => 'media'], [
        $el->h2('Media Example'),
        $html->element('figure', [], [
            $html->element('img', [
                'src' => '/images/example.png',
                'alt' => 'Decorative placeholder image',
            ]),
            $html->element('figcaption', [], [
                'Example image with required alt text.',
            ]),
        ]),
    ]),

    $html->element('section', ['class' => 'form'], [
        $el->h2('Contact Form'),

        $html->element('form', [
            'method' => 'post',
            'action' => '/submit',
        ], [

            // implicit label — single naming source
            $html->element('label', [], [
                'Name',
                $html->element('input', [
                    'type' => 'text',
                    'name' => 'name',
                ]),
            ]),

            // explicit label — single naming source
            $html->element('div', [], [
                $html->element('label', ['for' => 'email'], ['Email']),
                $html->element('input', [
                    'id'   => 'email',
                    'type' => 'email',
                    'name' => 'email',
                ]),
            ]),

            $el->button('Submit'),
        ]),
    ]),
]);

$aside = $html->element('aside', [], [
    $el->h2('Related'),
    $html->element('ul', [], [
        $html->element('li', [], ['Documentation']),
        $html->element('li', [], ['GitHub Repository']),
    ]),
]);

$main = $html->element('main', [], [
    $article,
    $aside,
]);

/*
|--------------------------------------------------------------------------
| Footer
|--------------------------------------------------------------------------
*/

$footer = $html->element('footer', [], [
    $html->element('p', [], [
        '© ',
        date('Y'),
        ' HTMLForge',
    ]),
]);

/*
|--------------------------------------------------------------------------
| Document
|--------------------------------------------------------------------------
*/

$document = $doc->document(
    bodyContent: [
        $header,
        $main,
        $footer,
    ],
    options: [

        'html' => [
            'lang'  => 'en',
            'class' => 'no-js',
        ],

        'title' => 'HTMLForge – Complete Example',

        'meta' => [
            'viewport'    => 'width=device-width, initial-scale=1',
            'description' => 'A complete HTML document generated by HTMLForge.',
        ],

        'styles' => $styles,

        'stylesheets' => [
            '/assets/app.css',
        ],

        // STRICT_HTML: external scripts only
        'scripts' => [
            '/assets/app.js',
        ],

        'body' => [
            'class' => 'app',
            'data-theme' => 'light',
        ],
    ]
);

/*
|--------------------------------------------------------------------------
| Render
|--------------------------------------------------------------------------
*/

$result = HTMLForge::using(
    new HTMLForgeConfig(
        mode: ValidationMode::Strict,
        profile: ValidationProfile::STRICT_HTML
    )
)->render($document);

if (!$result->isValid()) {
    http_response_code(400);
    echo $result->report->toHtml([
        'title' => 'HTML Validation Failed',
    ]);
    exit;
}

header('Content-Type: text/html; charset=utf-8');
echo $result->html;
