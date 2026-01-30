<?php

declare(strict_types=1);

namespace HTMLForge\Spec;

final class DeprecatedElements
{
    /**
     * HTML elements deprecated or obsolete in modern HTML.
     * These are intentionally NOT supported by HTMLForge v1.
     */
    public const LIST = [
        'acronym',
        'applet',
        'basefont',
        'big',
        'blink',
        'center',
        'font',
        'frame',
        'frameset',
        'noframes',
        'strike',
        'tt',
        'marquee',
    ];

    public static function isDeprecated(string $tag): bool
    {
        return in_array($tag, self::LIST, true);
    }
}
