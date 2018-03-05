<?php

namespace Runroom\BaseBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
use Sonata\UserBundle\Form\Type\SecurityRolesType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends SonataUserAdmin
{
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
