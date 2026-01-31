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
        $title = $options['title'] ?? 'HTML Validation Failed';
        $groups = $report->byType();

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
                    --error: #b91c1c;
                    --border: #e5e7eb;
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
                    border-left: 3px solid var(--error);
                }

                .rule {
                    font-family: monospace;
                    color: var(--error);
                    font-weight: 600;
                }

                .meta {
                    font-family: monospace;
                    font-size: 0.875rem;
                    color: var(--muted);
                    margin-top: 0.25rem;
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
                <div class="violation">
                    <?php if ($v->rule): ?>
                        <div class="rule">✖ <?= htmlspecialchars($v->rule) ?></div>
                    <?php endif; ?>

                    <div class="meta">
                        <?php if ($v->element): ?>
                            &lt;<?= htmlspecialchars($v->element) ?>&gt;
                        <?php endif; ?>

                        <?php if ($v->path): ?>
                            — <?= htmlspecialchars($v->path) ?>
                        <?php endif; ?>
                    </div>

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
