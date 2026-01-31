<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Contracts;

interface FinalizableValidator
{
    public function finalize(): void;
}
