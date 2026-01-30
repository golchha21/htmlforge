<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Profiles;

use HTMLForge\Validation\ValidationProfile;

final class WCAG_A_Test extends ProfileTestCase
{
    private const PROFILE = ValidationProfile::WCAG_A;

    public function test_valid_document_passes(): void
    {
        $result = $this->render(self::PROFILE, function ($html, $doc) {
            return $doc->document(
                [
                    $html->element('main', [], [
                        $html->element('h1', [], ['Hello']),
                        $html->element('p', [], ['World']),
                    ]),
                ],
                ['title' => 'Test', 'lang' => 'en']
            );
        });

        $this->assertTrue($result->isValid());
    }

    public function test_inline_event_handler_allowed(): void
    {
        $result = $this->render(self::PROFILE, function ($html, $doc) {
            return $doc->document(
                [
                    $html->element('button', ['onclick' => 'alert(1)'], ['Click']),
                ],
                ['title' => 'Test']
            );
        });

        $this->assertTrue($result->isValid());
    }

    public function test_missing_accessible_name_fails(): void
    {
        $result = $this->render(self::PROFILE, function ($html, $doc) {
            return $doc->document(
                [$html->element('button', [], [])],
                ['title' => 'Test']
            );
        });

        $this->assertFalse($result->isValid());
    }

    public function test_label_wrapped_input_passes(): void
    {
        $result = $this->render(self::PROFILE, function ($html, $doc) {
            return $doc->document(
                [
                    $html->element('label', [], [
                        'Name',
                        $html->element('input', ['type' => 'text']),
                    ]),
                ],
                ['title' => 'Test']
            );
        });

        $this->assertTrue($result->isValid());
    }

    public function test_heading_skip_allowed(): void
    {
        $result = $this->render(self::PROFILE, function ($html, $doc) {
            return $doc->document(
                [
                    $html->element('h1', [], ['Title']),
                    $html->element('h3', [], ['Skipped']),
                ],
                ['title' => 'Test']
            );
        });

        $this->assertTrue($result->isValid());
    }
}
