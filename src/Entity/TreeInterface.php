<?php

declare(strict_types=1);

namespace App\Entity;

interface TreeInterface
{
    public function getRgt(): ?int;

    public function getLft(): ?int;

    public function getLvl(): ?int;

    public function getRoot(): ?self;
}
