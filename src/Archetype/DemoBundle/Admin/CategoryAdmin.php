<?php

namespace Archetype\DemoBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;

class CategoryAdmin extends AbstractAdmin
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
            ->add('translations.name', null, ['label' => 'Name'])
            ->add('books')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'name'],
                'sort_parent_association_mappings' => [['fieldName' => 'translations']],
            ])
            ->add('books')
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
            ->add('translations', 'a2lix_translations', [
                'cascade_validation' => true,
                'fields' => [
                    'name' => [],
                ],
            ])
            ->add('books')
        ;
    }
}
