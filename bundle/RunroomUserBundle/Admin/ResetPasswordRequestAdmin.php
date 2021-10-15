<?php

declare(strict_types=1);

namespace Runroom\UserBundle\Admin;

use Runroom\UserBundle\Entity\ResetPasswordRequest;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/** @extends AbstractAdmin<ResetPasswordRequest> */
final class ResetPasswordRequestAdmin extends AbstractAdmin
{
    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues['_sort_by'] = 'requestedAt';
        $sortValues['_sort_order'] = 'DESC';
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('show');
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('user');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('hashedToken')
            ->add('requestedAt')
            ->add('expiresAt')
            ->add('user');
    }
}
