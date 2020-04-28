<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends SonataUserAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('enabled', null, [
                'editable' => true,
            ])
            ->add('createdAt')
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [],
                    'impersonate' => [
                        'template' => 'sonata/action/impersonate_user.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $user = $this->getSubject();

        $formMapper
            ->with('General', [
                'class' => 'col-md-4',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('username')
                ->add('email')
                ->add('plainPassword', TextType::class, [
                    'required' => !$user || \is_null($user->getId()),
                ])
                ->add('enabled')
                ->add('groups', ModelType::class, [
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ])
            ->end()
            ->with('Roles', [
                'class' => 'col-md-8',
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('realRoles', SecurityRolesType::class, [
                    'label' => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ])
            ->end();
    }
}
