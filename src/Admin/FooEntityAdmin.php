<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class FooEntityAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('pictures', CollectionType::class, [
                'by_reference' => false,
                'required' => true,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'admin_code' => FooPictureAdmin::class,
            ])
        ;
    }
}
