<?php

namespace Archetype\DemoBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Runroom\BaseBundle\Admin\BasePositionAdmin;
use Runroom\BaseBundle\Form\Type\MediaType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints as Assert;

class BookAdmin extends BasePositionAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('translations.title', null, ['label' => 'Title'])
            ->add('category');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('picture', 'image')
            ->addIdentifier('title', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'title'],
                'sort_parent_association_mappings' => [['fieldName' => 'translations']],
            ])
            ->add('description', 'html', [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'description'],
                'sort_parent_association_mappings' => [['fieldName' => 'translations']],
            ])
            ->add('category')
            ->add('publish')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'delete' => [],
                    'move' => [
                        'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('translations', TranslationsType::class, [
                'label' => false,
                'fields' => [
                    'title' => [],
                    'slug' => [
                        'display' => false,
                    ],
                    'description' => [
                        'field_type' => CKEditorType::class,
                        'required' => false,
                    ],
                ],
                'constraints' => [
                    new Assert\Valid(),
                ],
            ])
            ->add('category')
            ->add('picture', MediaType::class, [
                'context' => 'default',
                'provider' => 'sonata.media.provider.image',
            ])
            ->add('publish');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('title')
            ->add('description', 'html')
            ->add('category')
            ->add('picture', 'image')
            ->add('publish');
    }
}
