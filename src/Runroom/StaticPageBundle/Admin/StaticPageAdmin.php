<?php

namespace Runroom\StaticPageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\CoreBundle\Validator\ErrorElement;

class StaticPageAdmin extends AbstractAdmin
{
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('translations')->assertValid()->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('translations.title', null, [
                'label' => 'Title',
            ])
            ->add('publish')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
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
            ->add('publish', 'boolean', [
                'editable' => true,
            ])
            ->add('_action', null, [
                'actions' => [
                    'delete' => [],
                ],
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Static', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('translations', TranslationsType::class, [
                    'fields' => [
                        'title' => [],
                        'content' => [
                            'field_type' => CKEditorType::class,
                        ],
                        'slug' => [
                            'display' => false,
                        ],
                    ],
                ])
            ->end()
            ->with('Published', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('publish')
            ->end()
            ->with('SEO', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('meta_information', AdminType::class, [], [
                    'edit' => 'inline',
                ])
            ->end()
        ;
    }
}
