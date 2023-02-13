<?php

declare(strict_types=1);

namespace App\Service;

interface PositionHandlerInterface
{
    public function countNextSiblings(object $entity): int;

    public function countPrevSiblings(object $entity): int;

    public function move(object $entity, string $movePosition): void;
}
