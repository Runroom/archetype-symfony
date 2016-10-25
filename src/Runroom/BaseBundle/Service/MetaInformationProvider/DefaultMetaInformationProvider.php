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

    public function providesMetas($meta_route)
    {
        return true;
    }

    public function findMetasFor($meta_route, $model)
    {
        $metas = $this->repository->findOneByRoute($meta_route);

        if (!$metas) {
            $metas = $this->repository->findOneByRoute(self::DEFAULT_ROUTE);
        }

        return $metas;
    }
}
