<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Contracts;


use HTMLForge\Validation\Profiles\ValidationProfile;

interface ProfileAwareValidator
{
    public function supportsProfile(ValidationProfile $profile): bool;
}
