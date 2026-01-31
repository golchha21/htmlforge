# Example: Accessibility Validation

This example demonstrates WCAG-aware validation.

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
            new Element('title', [], [ new Text('Accessibility Example') ]),
        ]),
        new Element('body', [], [
            new Element('form', [], [
                new Element('input', ['type' => 'text', 'id' => 'username']),
            ]),
            new Element('h3', [], [ new Text('Improper Heading') ]),
        ]),
    ])
);

$forge = new HtmlForge(Profiles::WCAG_AA);
$result = $forge->renderDocument($document);

foreach ($result->report->violations() as $v) {
    echo $v->ruleId() . PHP_EOL;
    echo $v->path() . PHP_EOL;
    echo $v->message() . PHP_EOL . PHP_EOL;
}

echo $result->html;
```

## Scenario

- Missing labels
- Invalid heading structure
- ARIA misuse

## What this shows

- Accessible name enforcement
- Heading outline validation
- Rule IDs and paths in reports
