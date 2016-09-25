<?php

namespace Runroom\BaseBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class StaticPageAdmin extends BasePositionAdmin
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
        parent::configureListFields($listMapper);

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
            ->add('location', 'choice', [
                'choices' => [
                    'none' => '',
                    'footer' => 'Footer',
                ],
            ])
            ->add('_action', null, [
                'actions' => [
                    'open' => [
                        'template' => 'sonata/actions/open_static.html.twig',
                    ],
                    'delete' => [],
                    'move' => [
                        'template' => 'PixSortableBehaviorBundle:Default:_sort.html.twig',
                    ],
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
                ->add('translations', 'a2lix_translations', [
                    'cascade_validation' => true,
                    'fields' => [
                        'title' => [],
                        'content' => [
                            'field_type' => 'ckeditor',
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
                ->add('location', 'choice', [
                    'label' => 'Mostrar en:',
                    'choices' => [
                        'none' => 'No mostrar',
                        'footer' => 'Footer',
                    ],
                ])
            ->end()
            ->with('SEO', [
                'box_class' => 'box box-solid box-primary',
            ])
                ->add('meta_information', 'sonata_type_admin', [], [
                    'edit' => 'inline',
                ])
            ->end()
        ;
    }
}
