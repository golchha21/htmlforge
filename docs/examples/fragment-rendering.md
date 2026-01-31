# Example: Fragment Rendering

This example demonstrates rendering an HTML fragment.

## PHP Example

```php
<?php
require __DIR__ . '/vendor/autoload.php';

use HTMLForge\HtmlForge;
use HTMLForge\AST\Fragment;
use HTMLForge\AST\Element;
use HTMLForge\AST\Text;
use HTMLForge\Profiles;

$fragment = new Fragment([
    new Element('section', [], [
        new Element('h2', [], [ new Text('Fragment Title') ]),
        new Element('p', [], [ new Text('This is a fragment.') ]),
    ]),
]);

$forge = new HtmlForge(Profiles::STRICT_HTML);
$result = $forge->renderFragment($fragment);

if ($result->report->hasViolations()) {
    echo $result->report->toHtml();
    exit;
}

echo $result->html;
```

## Scenario

- No html or body element
- Fragment rendering mode
- Structural rules adjusted accordingly

## What this shows

- Difference between document and fragment modes
- Which validations still apply
- Which rules are intentionally skipped
