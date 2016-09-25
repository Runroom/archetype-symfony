<?php

namespace Runroom\BaseBundle\Admin;

use Pix\SortableBehaviorBundle\Services\PositionHandler;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class BasePositionAdmin extends AbstractAdmin
{
    public $last_position = 0;
    protected $position_service;

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'position',
    ];

    public function setPositionService(PositionHandler $position_handler)
    {
        $this->position_service = $position_handler;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{position}');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->last_position = $this->position_service->getLastPosition($this->getRoot()->getClass());
    }
}
