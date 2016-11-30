<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Repository\MetaInformationRepository;

class DefaultMetaInformationProvider implements MetaInformationProviderInterface
{
    const DEFAULT_ROUTE = 'default';

    protected $repository;

    public function __construct(MetaInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function providesMetas($route)
    {
        return true;
    }

    public function findMetasFor($route, $model)
    {
        $metas = $this->repository->findOneByRoute($route);

        if (!$metas) {
            $metas = $this->repository->findOneByRoute(self::DEFAULT_ROUTE);
        }

        return $metas;
    }
}
