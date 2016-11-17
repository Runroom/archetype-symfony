<?php

namespace Runroom\TranslationsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MessageAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('key')
            ->add('translations.value', null, ['label' => 'Value'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('key')
            ->add('value', 'html', [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'value'],
                'sort_parent_association_mappings' => [['fieldName' => 'translations']],
            ])
            ->add('_action', 'actions', [
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
            ->add('key')
            ->add('translations', 'a2lix_translations', [
                'cascade_validation' => true,
                'fields' => [
                    'value' => [
                        'required' => false,
                        'field_type' => 'ckeditor',
                        'config_name' => 'messages',
                    ],
                ],
            ])
        ;
    }
}
