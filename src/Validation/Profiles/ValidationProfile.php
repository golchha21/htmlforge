<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Profiles;

enum ValidationProfile
{
    case WCAG_A;
    case WCAG_AA;
    case WCAG_AAA;
    case STRICT_HTML;
    case CMS_SAFE;
}
