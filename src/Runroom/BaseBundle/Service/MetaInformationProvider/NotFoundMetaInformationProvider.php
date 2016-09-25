<?php

namespace Runroom\BaseBundle\Service\MetaInformationProvider;

use Runroom\BaseBundle\Repository\MetaInformationRepository;

class NotFoundMetaInformationProvider implements MetaInformationProviderInterface
{
    const HOME_ROUTE = 'runroom.runroom.route.home';

    protected $repository;

    public function __construct(MetaInformationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function providesMetas($meta_route)
    {
        return $meta_route == '';
    }

    public function findMetasFor($meta_route, $model)
    {
        $metas = $this->repository->findOneByRoute(self::HOME_ROUTE);

        return $metas;
    }
}
