<?php

namespace App\Twig;

use App\Service\PositionHandlerInterface;
use Twig\Extension\RuntimeExtensionInterface;

class TreePositionRuntime implements RuntimeExtensionInterface
{
    private PositionHandlerInterface $positionHandler;

    public function __construct(PositionHandlerInterface $positionHandler)
    {
        $this->positionHandler = $positionHandler;
    }

    public function countNextSiblings(object $entity): int
    {
        return $this->positionHandler->countNextSiblings($entity);
    }

    public function countPrevSiblings(object $entity): int
    {
        return $this->positionHandler->countPrevSiblings($entity);
    }
}
