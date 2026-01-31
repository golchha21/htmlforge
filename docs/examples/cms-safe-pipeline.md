# Example: CMS-Safe Pipeline

This example demonstrates validating user-generated content.

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
    new Element('div', [], [
        new Element('script', [], [ new Text('alert("xss")') ]),
        new Element('p', [], [ new Text('User content') ]),
        new Element('a', ['href' => 'javascript:alert(1)'], [ new Text('Click me') ]),
    ]),
]);

$forge = new HtmlForge(Profiles::CMS_SAFE);
$result = $forge->renderFragment($fragment);

if ($result->report->hasViolations()) {
    file_put_contents(
        __DIR__ . '/validation.log',
        $result->report->toJson() . PHP_EOL,
        FILE_APPEND
    );
}

echo $result->html;
```

## Scenario

- Untrusted HTML input
- CMS_SAFE profile
- Rendering with warnings

## What this shows

- Non-throwing validation
- Safe rendering
- Inspectable violations
