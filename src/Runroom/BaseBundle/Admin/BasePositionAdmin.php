<?php

namespace Runroom\BaseBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class BasePositionAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    protected function configureRoutes(RouteCollection $collection): void
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{position}');
    }
}
