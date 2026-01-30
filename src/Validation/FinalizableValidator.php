<?php

declare(strict_types=1);

namespace HTMLForge\Validation;

interface FinalizableValidator
{
    public function finalize(): void;
}
