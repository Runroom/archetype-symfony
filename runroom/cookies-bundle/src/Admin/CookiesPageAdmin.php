<?php

namespace Runroom\CookiesBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints as Assert;

class CookiesPageAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection): void
    {
        parent::configureRoutes($collection);

        $collection->remove('show');
        $collection->remove('delete');
        $collection->remove('list');
        $collection->remove('batch');
        $collection->remove('export');
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Translations', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('translations', TranslationsType::class, [
                    'label' => false,
                    'required' => false,
                    'fields' => [
                        'title' => [],
                        'content' => [
                            'field_type' => CKEditorType::class,
                        ],
                    ],
                    'constraints' => [
                        new Assert\Valid(),
                    ],
                ])
            ->end();
    }
}
