# Example: Basic Document

This example demonstrates rendering and validating a complete HTML document.

## PHP Example

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use HTMLForge\HtmlForge;
use HTMLForge\AST\Document;
use HTMLForge\AST\Element;
use HTMLForge\AST\Text;
use HTMLForge\Profiles;

$document = new Document(
    new Element('html', ['lang' => 'en'], [
        new Element('head', [], [
            new Element('title', [], [ new Text('HTMLForge Example') ]),
        ]),
        new Element('body', [], [
            new Element('main', [], [
                new Element('h1', [], [ new Text('Hello, HTMLForge') ]),
                new Element('p', [], [ new Text('This document is fully valid.') ]),
            ]),
        ]),
    ])
);

$forge = new HtmlForge(Profiles::STRICT_HTML);
$result = $forge->renderDocument($document);

if ($result->report->hasViolations()) {
    echo $result->report->toHtml();
    exit;
}

echo $result->html;
```

## Scenario

- Full HTML document
- Strict validation
- No violations

## What this shows

- Document-level validation
- Deterministic rendering
- Clean ValidationReport

This is the recommended starting point for new users.
