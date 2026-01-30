<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

enum ValidationMode
{
    case Strict;
    case Lenient;
}
