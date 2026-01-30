<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Report;

use HTMLForge\Validation\ValidationReport;

final class HtmlReportWriter
{
    public static function write(ValidationReport $report): string
    {
        $items = '';

        foreach ($report->all() as $v) {
            $items .= "<li><strong>{$v->type}</strong>: {$v->message}</li>";
        }

        return <<<HTML
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HTMLForge Validation Report</title>
  <style>
    body { font-family: system-ui, sans-serif; padding: 2rem; }
    li { margin-bottom: .5rem; }
  </style>
</head>
<body>
  <h1>Validation Report</h1>
  <p>Total issues: {$report->hasErrors()}</p>
  <ul>{$items}</ul>
</body>
</html>
HTML;
    }
}
