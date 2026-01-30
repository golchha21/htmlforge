<?php

declare(strict_types=1);

namespace HTMLForge\Spec;

enum AccessibilityExposure
{
    case Exposed;
    case Hidden;
    case Conditional;
}
