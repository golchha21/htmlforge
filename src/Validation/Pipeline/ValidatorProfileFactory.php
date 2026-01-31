<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Pipeline;

use HTMLForge\Validation\Profiles\ValidationProfile;
use HTMLForge\Validation\Validators\Accessibility\AccessibleNameValidator;
use HTMLForge\Validation\Validators\Accessibility\AriaRoleValidator;
use HTMLForge\Validation\Validators\Accessibility\FormLabelValidator;
use HTMLForge\Validation\Validators\Accessibility\HeadingOutlineValidator;
use HTMLForge\Validation\Validators\Accessibility\LandmarkValidator;
use HTMLForge\Validation\Validators\Attributes\AttributeValidator;
use HTMLForge\Validation\Validators\Attributes\IdReferenceValidator;
use HTMLForge\Validation\Validators\Attributes\InlineEventHandlerValidator;
use HTMLForge\Validation\Validators\Attributes\LangAttributeValidator;
use HTMLForge\Validation\Validators\Attributes\UrlAttributeValidator;
use HTMLForge\Validation\Validators\Content\ContentModelValidator;
use HTMLForge\Validation\Validators\Document\DocumentMetadataValidator;

final class ValidatorProfileFactory
{
    /** @return object[] */
    public static function build(ValidationProfile $profile): array
    {
        return match ($profile) {

            // -----------------------------
            // WCAG PROFILES (ACCESSIBILITY)
            // -----------------------------

            ValidationProfile::WCAG_A => [
                new ContentModelValidator(),
                new AttributeValidator($profile),
                new AccessibleNameValidator(),
                new FormLabelValidator(),
            ],

            ValidationProfile::WCAG_AA => [
                new ContentModelValidator(),
                new AttributeValidator($profile),
                new UrlAttributeValidator(),
                new IdReferenceValidator(),
                new LangAttributeValidator(),
                new DocumentMetadataValidator(),
                new AccessibleNameValidator(),
                new FormLabelValidator(),
                new HeadingOutlineValidator(),
                new LandmarkValidator(),
                new AriaRoleValidator(),
            ],

            ValidationProfile::WCAG_AAA => [
                new ContentModelValidator(),
                new AttributeValidator($profile),
                new UrlAttributeValidator(),
                new IdReferenceValidator(),
                new LangAttributeValidator(),
                new DocumentMetadataValidator(),
                new AccessibleNameValidator(),
                new FormLabelValidator(),
                new HeadingOutlineValidator(),
                new LandmarkValidator(),
                new AriaRoleValidator(),
                // future: contrast, language complexity, timing, etc.
            ],

            // -----------------------------
            // POLICY PROFILES
            // -----------------------------

            ValidationProfile::STRICT_HTML => [
                // structure + a11y
                new ContentModelValidator(),
                new AttributeValidator(),
                new UrlAttributeValidator(),
                new IdReferenceValidator(),
                new LangAttributeValidator(),
                new DocumentMetadataValidator(),
                new AccessibleNameValidator(),
                new FormLabelValidator(),
                new HeadingOutlineValidator(),
                new LandmarkValidator(),
                new AriaRoleValidator(),

                // hygiene (STRICT ONLY)
                new InlineEventHandlerValidator(),
            ],

            ValidationProfile::CMS_SAFE => [
                // safe authoring subset for CMS environments
                new ContentModelValidator(),
                new AttributeValidator($profile),
                new UrlAttributeValidator(),
                new IdReferenceValidator(),
                new LangAttributeValidator(),
                new DocumentMetadataValidator(),
                new AccessibleNameValidator(),
                new FormLabelValidator(),
                new HeadingOutlineValidator(),

                // intentionally excluded:
                // - InlineEventHandlerValidator (CMSs may rewrite JS)
                // - AriaRoleValidator (avoid author-hostile failures)
                // - Landmark escalation beyond outline
            ],
        };
    }
}
