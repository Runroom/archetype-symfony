<?php

namespace Runroom\BaseBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints as Assert;

class EntityMetaInformationAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
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
                        'description' => [],
                    ],
                    'constraints' => [
                        new Assert\Valid(),
                    ],
                ])
            ->end();
    }
}
