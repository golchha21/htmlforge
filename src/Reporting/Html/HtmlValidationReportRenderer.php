<?php

declare(strict_types=1);

namespace HTMLForge\Reporting\Html;

use HTMLForge\Validation\Reporting\ValidationReport;

final class HtmlValidationReportRenderer
{
    public static function render(
        ValidationReport $report,
        array $options = []
    ): string {
        $title  = $options['title'] ?? 'HTML Validation Failed';
        $groups = $report->grouped();

        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title><?= htmlspecialchars($title) ?></title>
            <style>
                :root {
                    --bg: #ffffff;
                    --fg: #111827;
                    --muted: #6b7280;
                    --border: #e5e7eb;

                    --structure: #b91c1c;
                    --attributes: #ea580c;
                    --accessibility: #16a34a;
                    --aria: #2563eb;
                    --security: #6b7280;
                }

                body {
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
                    background: var(--bg);
                    color: var(--fg);
                    margin: 0;
                    padding: 2rem;
                }

                h1 {
                    margin-bottom: 1.5rem;
                }

                h2 {
                    margin-top: 2rem;
                    border-bottom: 1px solid var(--border);
                    padding-bottom: 0.25rem;
                }

                .violation {
                    margin: 1rem 0;
                    padding-left: 1rem;
                    border-left: 3px solid var(--border);
                }

                .violation.structure     { border-left-color: var(--structure); }
                .violation.attributes    { border-left-color: var(--attributes); }
                .violation.accessibility { border-left-color: var(--accessibility); }
                .violation.aria          { border-left-color: var(--aria); }
                .violation.security        { border-left-color: var(--security); }

                .rule {
                    font-family: monospace;
                    font-weight: 600;
                    margin-bottom: 0.25rem;
                }

                .meta {
                    font-family: monospace;
                    font-size: 0.875rem;
                    color: var(--muted);
                }

                .message {
                    margin-top: 0.5rem;
                }
            </style>
        </head>
        <body>

        <h1><?= htmlspecialchars($title) ?></h1>

        <?php foreach ($groups as $type => $violations): ?>
            <h2><?= ucfirst($type) ?> (<?= count($violations) ?>)</h2>

            <?php foreach ($violations as $v): ?>
                <div class="violation <?= htmlspecialchars($type) ?>">
                    <?php if ($v->rule): ?>
                        <div class="rule">✖ <?= htmlspecialchars($v->rule) ?></div>
                    <?php endif; ?>

                    <?php if ($v->element || $v->path): ?>
                        <div class="meta">
                            <?php if ($v->element): ?>
                                &lt;<?= htmlspecialchars($v->element) ?>&gt;
                            <?php endif; ?>
                            <?php if ($v->path): ?>
                                — <?= htmlspecialchars($v->path) ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="message">
                        <?= htmlspecialchars($v->message) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>

        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
