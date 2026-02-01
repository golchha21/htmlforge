<?php

declare(strict_types=1);

namespace HTMLForge\Validation\Contracts;

use Closure;

interface FinalizableValidator
{
    public function finalize(Closure $emit): void;
}
