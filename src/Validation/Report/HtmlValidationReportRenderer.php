<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Report;

use HTMLForge\Validation\ValidationReport;
use HTMLForge\Validation\Violation;

final class HtmlValidationReportRenderer
{
    public static function render(
        ValidationReport $report,
        array $options = []
    ): string {
        $title = $options['title'] ?? 'HTMLForge Validation Report';
        $showType = $options['show_type'] ?? true;

        $items = array_map(
            fn (Violation $v) => self::renderViolation($v, $showType),
            $report->all()
        );

        $itemsHtml = implode("\n", $items);
        $count = count($report->all());

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{$title}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root {
      --error: #b00020;
      --bg: #ffffff;
      --fg: #111111;
      --muted: #666;
      --border: #e5e5e5;
    }

    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--bg);
      color: var(--fg);
      margin: 0;
      padding: 2rem;
      line-height: 1.5;
    }

    h1 {
      margin-top: 0;
    }

    .summary {
      margin-bottom: 1.5rem;
      color: var(--muted);
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    li {
      border-left: 4px solid var(--error);
      background: #fafafa;
      padding: 1rem;
      margin-bottom: 1rem;
    }

    .type {
      font-weight: 600;
      color: var(--error);
      margin-bottom: 0.25rem;
    }

    .message {
      margin: 0;
    }
  </style>
</head>
<body>
  <h1>{$title}</h1>
  <p class="summary">{$count} validation issue(s) found.</p>

  <ul>
    {$itemsHtml}
  </ul>
</body>
</html>
HTML;
    }

    private static function renderViolation(
        Violation $v,
        bool $showType
    ): string {
        $type = $showType
            ? "<div class=\"type\">" . htmlspecialchars($v->type) . "</div>"
            : '';

        $message = htmlspecialchars($v->message);

        return <<<HTML
<li>
  {$type}
  <p class="message">{$message}</p>
</li>
HTML;
    }
}
