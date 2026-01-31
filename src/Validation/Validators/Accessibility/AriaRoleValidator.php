<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Accessibility;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Exceptions\ValidationException;

final class AriaRoleValidator extends AbstractTreeValidator
{
    /**
     * Allowed ARIA role → permitted host elements
     */
    private const ROLE_MAP = [
        'banner'       => ['header'],
        'navigation'   => ['nav'],
        'main'         => ['main'],
        'contentinfo'  => ['footer'],
        'button'       => ['button', 'a', 'input'],
        'link'         => ['a'],
        'textbox'      => ['input', 'textarea'],
        'img'          => ['img'],
        'list'         => ['ul', 'ol'],
        'listitem'     => ['li'],
    ];

    /**
     * Native implicit roles that MUST NOT be overridden
     */
    private const NATIVE_ROLES = [
        'header' => 'banner',
        'nav'    => 'navigation',
        'main'   => 'main',
        'footer' => 'contentinfo',
        'button' => 'button',
        'a'      => 'link',
        'input'  => 'textbox',
        'img'    => 'img',
        'ul'     => 'list',
        'ol'     => 'list',
        'li'     => 'listitem',
    ];

    protected function validateElement(ElementNode $node): void
    {
        $role = $node->attributes['role'] ?? null;

        if ($role === null) {
            return;
        }

        $tag = $node->tag;

        /*
        |--------------------------------------------------------------------------
        | Unknown role
        |--------------------------------------------------------------------------
        */
        if (!isset(self::ROLE_MAP[$role])) {
            throw new ValidationException(
                message: "Invalid ARIA role '{$role}'.",
                type: 'aria',
                rule: 'aria:role-invalid',
                element: $tag,
                path: $this->currentPath(),
                spec: ['role' => $role]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Native role override (stronger rule)
        |--------------------------------------------------------------------------
        */
        if (
            isset(self::NATIVE_ROLES[$tag]) &&
            self::NATIVE_ROLES[$tag] !== $role
        ) {
            throw new ValidationException(
                message: "ARIA role '{$role}' must not override native semantics of <{$tag}>.",
                type: 'aria',
                rule: 'aria:role-override',
                element: $tag,
                path: $this->currentPath(),
                spec: [
                    'role'   => $role,
                    'native' => self::NATIVE_ROLES[$tag],
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Role not permitted on this element
        |--------------------------------------------------------------------------
        */
        if (!in_array($tag, self::ROLE_MAP[$role], true)) {
            throw new ValidationException(
                message: "ARIA role '{$role}' is not allowed on <{$tag}>.",
                type: 'aria',
                rule: 'aria:role-disallowed',
                element: $tag,
                path: $this->currentPath(),
                spec: ['role' => $role]
            );
        }
    }
}
