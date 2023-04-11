<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class TreePositionHandler implements PositionHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function countNextSiblings(object $entity): int
    {
        $repository = $this->getRepository($entity);

        return \count($repository->getNextSiblings($entity));
    }

    public function countPrevSiblings(object $entity): int
    {
        $repository = $this->getRepository($entity);

        return \count($repository->getPrevSiblings($entity));
    }

    public function move(object $entity, string $movePosition): void
    {
        $repository = $this->getRepository($entity);

        switch ($movePosition) {
            case 'up':
                $repository->moveUp($entity, 1);
                break;
            case 'down':
                $repository->moveDown($entity, 1);
                break;
            case 'top':
                $repository->moveUp($entity, true);
                break;
            case 'bottom':
                $repository->moveDown($entity, true);
                break;
        }
    }

    private function getRepository(object $entity): NestedTreeRepository
    {
        $repository = $this->entityManager->getRepository(\get_class($entity));

        if (!$repository instanceof NestedTreeRepository) {
            throw new \RuntimeException('Repository must be instance of NestedTreeRepository');
        }

        return $repository;
    }
}
