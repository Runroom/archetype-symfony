<?php

declare(strict_types=1);

namespace App\Admin;

use App\Action\MoveTreeAction;
use App\Entity\Menu;
use App\Entity\MenuItem;
use App\Form\Type\TreeSelectorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

/**
 * @extends AbstractAdmin<MenuItem>
 */
final class MenuItemAdmin extends AbstractAdmin
{
    public function toString(object $object): string
    {
        return $object->getTitle() ?? '-';
    }

    protected function configure(): void
    {
        $this->setTemplate('outer_list_rows_list', 'sonata/list_outer_rows_list.html.twig');
        $this->setTemplate('list', 'sonata/list.html.twig');
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        $collection->add('move', $this->getRouterIdParameter() . '/move/{position}', [
            'position' => 'up|down|top|bottom',
            '_controller' => MoveTreeAction::class,
        ]);
        $collection->remove('show');

        if (!$this->isChild()) {
            $collection->clear();
        }
    }

    protected function configureQuery(ProxyQueryInterface $query): ProxyQueryInterface
    {
        if (!$query instanceof ProxyQuery) {
            return $query;
        }

        $query->andWhere($query->getRootAliases()[0] . '.lvl > 0')
            ->orderBy($query->getRootAliases()[0] . '.lft', 'ASC');

        return $query;
    }

    protected function alterNewInstance(object $object): void
    {
        if (!$this->hasRequest() || !$this->isChild()) {
            return;
        }

        $request = $this->getRequest();

        $parent = $this->getObject($request->query->get('childId'))
            ?? $this->getMenu()->getRoot();

        if (null === $parent) {
            return;
        }

        $object->setParent($parent);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('title', null, [
                'virtual_field' => true,
                'template' => 'sonata/toggle.html.twig',
            ])
            ->add('slug')
            ->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
                'actions' => [
                    'edit' => [],
                    'add_child' => [
                        'template' => 'sonata/add_child.html.twig',
                    ],
                    'delete' => [],
                    'move' => [
                        'template' => 'sonata/sort.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $menu = $this->getMenu();

        $form
            ->with('Basic', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('title')
                ->add('parent', TreeSelectorType::class, [
                    'required' => true,
                    'max_depth' => $menu->getMaxDepth(),
                    'subject' => $this->getSubject(),
                    'root' => $menu->getRoot(),
                    'class' => MenuItem::class,
                ])
            ->end()
            ->with('Published', [
                'box_class' => 'box box-solid box-primary',
            ])
            ->end();
    }

    private function getMenu(): Menu
    {
        if (!$this->isChild()) {
            throw new \LogicException('Menu item admin is not a child of menu admin.');
        }

        $parent = $this->getParent();

        if (!$parent->hasSubject()) {
            throw new \LogicException('Menu admin parent has no subject.');
        }

        $menu = $parent->getSubject();

        if (!$menu instanceof Menu) {
            throw new \LogicException('Menu admin parent is not a menu.');
        }

        return $menu;
    }
}
