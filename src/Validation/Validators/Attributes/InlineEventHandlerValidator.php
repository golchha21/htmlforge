<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Validators\Attributes;

use HTMLForge\AST\ElementNode;
use HTMLForge\Validation\Contracts\AbstractTreeValidator;
use HTMLForge\Validation\Contracts\ProfileAwareValidator;
use HTMLForge\Validation\Exceptions\ValidationException;
use HTMLForge\Validation\Profiles\ValidationProfile;

final class InlineEventHandlerValidator extends AbstractTreeValidator implements ProfileAwareValidator
{
    protected function validateElement(ElementNode $node): void
    {
        foreach ($node->attributes as $attr => $_) {
            if (str_starts_with($attr, 'on')) {
                throw new ValidationException(
                    message: "Inline event handler '{$attr}' is not allowed.",
                    type: 'security',
                    rule: 'security:inline-event-handler',
                    element: $node->tag,
                    path: $this->currentPath(),
                    spec: ['attribute' => $attr]
                );
            }
        }
    }

    public function supportsProfile(ValidationProfile $profile): bool
    {
        return $profile === ValidationProfile::STRICT_HTML;
    }

}

