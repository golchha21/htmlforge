<?php

declare(strict_types=1);

namespace HTMLForge\Tests\Core;

use HTMLForge\Validation\Reporting\Violation;
use PHPUnit\Framework\TestCase;

final class ViolationTest extends TestCase
{
    public function test_violation_serializes_correctly(): void
    {
        $v = new Violation(
            type: 'accessibility',
            message: 'Missing accessible name',
            rule: 'accessibility:accessible-name',
            element: 'input',
            path: 'html > body > form > input'
        );

        $data = $v->toArray();

        $this->assertSame('accessibility', $data['type']);
        $this->assertSame('accessibility:accessible-name', $data['rule']);
        $this->assertSame('input', $data['element']);
        $this->assertSame(
            'html > body > form > input',
            $data['path']
        );
    }
}
