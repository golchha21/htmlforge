<?php

declare(strict_types=1);

namespace HTMLForge\Spec;

enum ElementCategory: string
{
    case DocumentRoot      = 'document_root';
    case Metadata          = 'metadata';
    case Sectioning        = 'sectioning';
    case Heading           = 'heading';
    case Flow              = 'flow';
    case Phrasing          = 'phrasing';
    case Embedded          = 'embedded';
    case Interactive       = 'interactive';
    case FormAssociated    = 'form_associated';
    case Tabular           = 'tabular';
    case RawText           = 'raw_text';
    case Inert             = 'inert';
    case Edits             = 'edits';
    case Deprecated        = 'deprecated';
}
