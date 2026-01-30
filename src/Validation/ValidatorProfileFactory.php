<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

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
                // full structural + semantic correctness
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

                // strict hygiene / security
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
