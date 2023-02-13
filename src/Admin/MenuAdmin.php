<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Menu;
use App\Entity\MenuItem;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @extends AbstractAdmin<Menu>
 */
final class MenuAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->remove('show');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('title')
            ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function prePersist(object $object): void
    {
        $root = new MenuItem();
        $root->setTitle($object->getTitle());
        $root->setMenu($object);

        $object->setRoot($root);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->with('Basic', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('title')
            ->end()
            ->with('Configuration', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('maxDepth', null, [
                    'help' => 'The maximum depth of the menu. Leave empty for unlimeted depth.',
                ])
            ->end();
    }

    protected function configureTabMenu(ItemInterface $menu, string $action, ?AdminInterface $childAdmin = null): void
    {
        if (!$childAdmin && !\in_array($action, ['edit', 'show'], true)) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->attributes->get('id');

        if ($this->isGranted('EDIT')) {
            $menu->addChild('Edit Menu', $admin->generateMenuUrl('edit', ['id' => $id]));
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('Manage Hierarchy', $admin->generateMenuUrl('App\Admin\MenuItemAdmin.list', ['id' => $id]));
        }
    }
}
