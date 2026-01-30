<?php

declare(strict_types=1);

namespace HTMLForge\AST;

interface Node
{
    /** @return Node[] */
    public function children(): array;
}
