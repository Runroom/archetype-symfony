<?php

namespace Runroom\StaticPageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class StaticPageAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('translations.title', null, [
                'label' => 'Title',
            ])
            ->add('publish');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('title', null, [
                'sortable' => true,
                'sort_field_mapping' => [
                    'fieldName' => 'title',
                ],
                'sort_parent_association_mappings' => [[
                    'fieldName' => 'translations',
                ]],
            ])
            ->add('location', 'choice', [
                'editable' => true,
                'choices' => [
                    StaticPage::LOCATION_NONE => 'None',
                    StaticPage::LOCATION_FOOTER => 'Footer',
                ],
            ])
            ->add('publish', 'boolean', [
                'editable' => true,
            ])
            ->add('_action', null, [
                'actions' => [
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('Static', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('translations', TranslationsType::class, [
                    'label' => false,
                    'fields' => [
                        'title' => [],
                        'content' => [
                            'field_type' => CKEditorType::class,
                        ],
                        'slug' => [
                            'display' => false,
                        ],
                    ],
                    'constraints' => [
                        new Assert\Valid(),
                    ],
                ])
            ->end()
            ->with('Published', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('publish')
                ->add('location', ChoiceType::class, [
                    'choices' => [
                        'None' => StaticPage::LOCATION_NONE,
                        'Footer' => StaticPage::LOCATION_FOOTER,
                    ],
                ])
            ->end()
            ->with('SEO', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('metaInformation', AdminType::class, [], [
                    'edit' => 'inline',
                ])
            ->end();
    }
}
