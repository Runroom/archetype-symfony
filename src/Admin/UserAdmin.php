<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class UserAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_user';
    protected $baseRoutePattern = 'user';

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('test')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ;
    }
}
