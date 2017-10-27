<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Entity\MetaInformation;
use Runroom\BaseBundle\Repository\MetaInformationRepository;

class DefaultMetaInformationProvider implements MetaInformationProviderInterface
{
    const DEFAULT_ROUTE = 'default';

    protected $repository;

    public function __construct(MetaInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function providesMetas(string $route): bool
    {
        return true;
    }

    public function findMetasFor(string $route, $model): MetaInformation
    {
        $metas = $this->repository->findOneByRoute($route);

        if (!$metas) {
            $metas = $this->repository->findOneByRoute(self::DEFAULT_ROUTE);
        }

        return $metas;
    }
}
