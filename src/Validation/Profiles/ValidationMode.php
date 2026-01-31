<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Profiles;

enum ValidationMode
{
    case Strict;
    case Lenient;
}
